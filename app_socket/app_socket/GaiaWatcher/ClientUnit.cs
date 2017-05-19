/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class ClientUnit. Represents connection of each unit.
*/

using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {

    public class ClientUnit {
         
        private Guid _clientUnitGuid;

        public ClientUnit () {
            _clientUnitGuid = Guid.NewGuid();
        }

        public Guid id {
            get {
                return _clientUnitGuid;
            }
        }

        public string ip {
            get;
            set;
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
    }
}
