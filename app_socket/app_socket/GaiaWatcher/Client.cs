using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class Client  {

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
            get {
                IPEndPoint remote = (IPEndPoint)this.tcpClient.Client.RemoteEndPoint;
                return remote.Address.ToString();
            }
        }

        public string imei {
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
    }
}
