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

    public class AtsSocketManager : SocketManager {

        public AtsSocketManager (SocketProfile socketProfile) : base(socketProfile) {

        }

        protected override void Communicate (ref Client client) {
            CommandData commandData = null;
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

                        if (base.serviceProfile.socket == Service.COMMAND) {
                            commandData = Command.getInstance().parseCommandData(buffer);
                        }



                    } while (client.tcpClient.Connected);
                }
            } catch (Exception exception) {
                Log.client(client, exception, buffer);
            }
        }
    }
}
