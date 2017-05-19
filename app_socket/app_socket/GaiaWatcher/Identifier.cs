/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class Identifier. Creates unique id.
*/
using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class Identifier {

        private static Identifier _instance = null;

        private long _uniqueId = 0;

        public static Identifier getInstance () {
            if (_instance == null) {
                _instance = new Identifier();
            }

            return _instance;
        }

        public long getUniqueId () {
            return ++_uniqueId;
        }

    }
}
