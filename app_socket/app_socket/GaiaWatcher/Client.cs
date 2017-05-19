/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#
   
	functions 		:		Definition of class Client. Represents client connection.
*/
using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class Client {

        private Guid _guid;

        public Client () {
            _guid = Guid.NewGuid();
        }

        public Guid id {
            get {
                return _guid;
            }
        }

        public string ip {
            get;
            set;
        }

        public long iBytes {
            get;
            set;
        }
        public long oBytes {
            get;
            set;
        }
    
        public DateTime dateTime {
            get;
            set;
        }
        public TcpClient tcpClient {
            get;
            set;
        }

        public bool isConnected {
            get {
                try {
                    if (this.tcpClient != null && this.tcpClient.Client != null && this.tcpClient.Client.Connected) {
                        /* pear to the documentation on Poll:
                         * When passing SelectMode.SelectRead as a parameter to the Poll method it will return 
                         * -either- true if Socket.Listen(Int32) has been called and a connection is pending;
                         * -or- true if data is available for reading; 
                         * -or- true if the connection has been closed, reset, or terminated; 
                         * otherwise, returns false
                         */

                        // Detect if client disconnected
                        if (this.tcpClient.Client.Poll(0, SelectMode.SelectRead)) {
                            byte[] buff = new byte[1];
                            if (this.tcpClient.Client.Receive(buff, SocketFlags.Peek) == 0) {
                                // Client disconnected
                                return false;
                            } else {
                                return true;
                            }
                        }

                        return true;
                    } else {
                        return false;
                    }
                } catch {
                    return false;
                }
            }
        }
    }
}
