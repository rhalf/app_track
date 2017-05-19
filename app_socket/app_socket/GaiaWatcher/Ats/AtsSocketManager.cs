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
                    networkStream.ReadTimeout = 1000 * 60 * 5;
                    networkStream.WriteTimeout = 1000 * 60 * 5;

                    do {
                        Array.Clear(buffer, 0, buffer.Length);

                        int count = networkStream.Read(buffer, 0, buffer.Length);

                        client.iBytes += count;
                        base.iBytes += count;
                        base.iPackets += 1;

                        if (base.serviceProfile.socket == Service.COMMAND) {
                            commandData = Command.getInstance().parseCommandData(buffer);

                        }



                        if (commandData != null) {
                            while (!this.bufferCommands.ContainsKey(commandData.imei)) {
                                this.bufferCommands.TryAdd(commandData.imei, commandData);
                            }
                        } else {
                            throw new Exception("Data format is not a Command.");
                        }


                        client.dateTime = new DateTime(DateTime.Now.Ticks);
                    } while (client.tcpClient.Connected);
                }
            } catch (Exception exception) {
                Log.client(client, exception, buffer);
            }
        }
    }
}
