/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class clientUnits. Storage for referencing clientUnit connection.
*/
using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class ClientUnits : ConcurrentDictionary<string, ClientUnit> {

        public void add (ClientUnit clientUnitNew) {
            if (!this.ContainsKey(clientUnitNew.imei)) {
                this.remove(clientUnitNew);
                this.TryAdd(clientUnitNew.imei, clientUnitNew);
            } else {
                this.TryAdd(clientUnitNew.imei, clientUnitNew);
            }
        }

        public void remove (ClientUnit clientUnitNew) {
            ClientUnit clientUnitOld = null;
            while (this.ContainsKey(clientUnitNew.imei)) {
                this.TryRemove(clientUnitNew.imei, out clientUnitOld);
            }
            clientUnitOld = null;
        }
    }
}
