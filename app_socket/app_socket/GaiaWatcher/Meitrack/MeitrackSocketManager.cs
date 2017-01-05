using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcherSocket;
using System.Threading;
using System.Net.Sockets;
using System.Diagnostics;
using GaiaWatcher.Classes;
using System.Threading.Tasks;

namespace GaiaWatcher {

    public class MeitrackSocketManager : SocketManager {

        public MeitrackSocketManager (SocketProfile socketProfile) : base(socketProfile) {

        }

        protected override void Communicate (ref Client client) {
            UnitData unitData = null;
            Byte[] buffer = new Byte[256];
            try {
                using (NetworkStream networkStream = client.tcpClient.GetStream()) {
                    networkStream.ReadTimeout = 2 * 60 * 1000;
                    networkStream.WriteTimeout = 2 * 60 * 1000;

                    do {
                        Array.Clear(buffer, 0, buffer.Length);
                        if (!networkStream.CanRead) {
                            return;
                        }
                        if (!networkStream.DataAvailable) {
                            TimeSpan timeSpan = DateTime.Now.Subtract(client.dateTime);
                            if (timeSpan.Minutes > 1) {
                                return;
                            }
                            Thread.Sleep(1000);
                            continue;
                        }

                        int count = networkStream.Read(buffer, 0, buffer.Length);

                        client.iBytes += count;
                        base.iBytes += count;
                        base.iPackets += 1;

                        if (!Meitrack.getInstance().checkSum(buffer)) {
                            Log.unitData(unitData, new Exception("Check sum is wrong."));
                            continue;
                        }

                        if (base.serviceProfile.socket == Service.MVT100) {
                            unitData = Mvt100.getInstance().parseUnitData(buffer);
                        }

                        if (base.serviceProfile.socket == Service.T1) {

                        }

                        if (unitData != null) {
                            client.imei = unitData.header.imei;
                            this._bufferIn.Enqueue(unitData);
                        } else {
                            throw new Exception("Device is not Mvt100.");
                        }

                    } while (client.tcpClient.Connected);
                }
            } catch (Exception exception) {
                Log.client(client, exception, buffer);
            }
        }
    }
}
