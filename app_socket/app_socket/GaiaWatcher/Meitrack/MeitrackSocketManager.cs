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
using System.IO;

namespace GaiaWatcher {

    public class MeitrackSocketManager : SocketManager {

        public MeitrackSocketManager (SocketProfile socketProfile) : base(socketProfile) {

        }

        protected override void Communicate (ref Client client) {
            ClientUnit clientUnit = null;
            UnitData unitData = null;
            Byte[] buffer = new Byte[256];
            try {
                using (NetworkStream networkStream = client.tcpClient.GetStream()) {
                    networkStream.ReadTimeout = 1000 * 60 * 3;
                    networkStream.WriteTimeout = 1000 * 60 * 3;

                    do {
                        Array.Clear(buffer, 0, buffer.Length);

                        if (!networkStream.DataAvailable) {
                            TimeSpan timeSpan = DateTime.Now.Subtract(client.dateTime);
                            if (timeSpan.TotalMinutes > 3) {
                                return;
                            }
                            Thread.Sleep(1);
                        }

                        int count = networkStream.Read(buffer, 0, buffer.Length);

                        if (count == 0) {
                            throw new Exception("No data. Considered disconnected.");
                        }

                        client.iBytes += count;
                        base.iBytes += count;
                        base.iPackets += 1;

                        if (!Meitrack.getInstance().fromDevice(buffer)) {
                           throw new Exception("Data is not a from Meitrack Device.");
                        }

                        if (!Meitrack.getInstance().checkSum(buffer)) {
                           throw new Exception("Check sum is wrong.");
                        }

                        if (base.serviceProfile.socket == Service.MVT100) {
                            unitData = Mvt100.getInstance().parseUnitData(buffer);
                        }

                        if (base.serviceProfile.socket == Service.T1) {
                            unitData = T1.getInstance().parseUnitData(buffer);
                        }

                        clientUnit = new ClientUnit() {
                            dateTime = new DateTime(DateTime.Now.Ticks),
                            imei = unitData.header.imei,
                            ip = client.ip,
                            iBytes = count,
                        };

                        base.clientUnits.add(clientUnit);

                        this._bufferUnitDatas.Enqueue(unitData);

                        object obj = null;
                        if (this.bufferCommands != null) {
                            if (this.bufferCommands.Count != 0) {
                                if (this.bufferCommands.ContainsKey(clientUnit.imei)) {
                                    this.bufferCommands.TryRemove(clientUnit.imei, out obj);
                                    if (obj != null) {
                                        this.send(networkStream, (CommandData)obj);
                                    }
                                }
                            }
                        }

                        client.dateTime = new DateTime(DateTime.Now.Ticks);

                    } while (client.tcpClient.Connected);
                }
            } catch (IOException ioException) {
                //Log.client(client, ioException, buffer);
            } catch (Exception exception) {
                Log.client(client, exception, buffer);
            } finally {
                if (clientUnit != null) {
                    base.clientUnits.remove(clientUnit);
                }
            }
        }

        public void send (NetworkStream networkStream, CommandData command) {
            //------------------------------------------------Send message
            byte[] data = command.generate();
            int count = command.generate().Length;
            networkStream.Write(data, 0, count);
            networkStream.Flush();
            base.oBytes += count;
        }
    }
}
