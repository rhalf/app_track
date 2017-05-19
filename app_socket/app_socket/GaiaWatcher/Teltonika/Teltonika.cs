/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class Teltonika. 
*/
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;

namespace GaiaWatcher {

    public class Teltonika {

        private static Teltonika _instance = null;

        public static Teltonika getInstance () {
            if (_instance == null) {
                _instance = new Teltonika();
            }
            return _instance;
        }

        private Teltonika () {

        }

    }
}
