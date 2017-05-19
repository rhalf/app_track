/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class clients. Storage for referencing clients connection.
*/
using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class Clients : ConcurrentDictionary<Guid, Client> {

        public void add (Client clientNew) {
            while (!this.ContainsKey(clientNew.id)) {
                this.TryAdd(clientNew.id, clientNew);
            }
        }

        public void remove (Client client) {
            Client clientOld = null;
            while (this.ContainsKey(client.id)) {
                this.TryRemove(client.id, out clientOld);
            }
            clientOld = null;
        }
    }
}
