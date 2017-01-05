using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher.Classes {
    public class NetworkTool {

        /// <summary>
        /// Checks the connection state
        /// </summary>
        /// <returns>True on connected. False on disconnected.</returns>
        public static bool IsConnected (TcpClient tcpClient) {
            // Detect if client disconnected
            if (tcpClient.Client.Poll(0, SelectMode.SelectRead)) {
                byte[] buff = new byte[1];
                if (tcpClient.Client.Receive(buff, SocketFlags.Peek) == 0) {
                    // Client disconnected
                    return false;
                }
            }
            return true;
        }
    }

}
