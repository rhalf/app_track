﻿/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class fm1100. 
*/
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;

namespace GaiaWatcher {

    public class Fm1100 : Service {

        private static Fm1100 _instance = null;

        public static Fm1100 getInstance () {
            if (_instance == null) {
                _instance = new Fm1100();
            }
            return _instance;
        }

        public Fm1100() : base(Service.FM1100) {

        }


    }
}
