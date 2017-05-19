/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class telTonikaSocketManager. 
*/
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcherSocket;
using System.Threading;

namespace GaiaWatcher {

    public class TeltonikaSocketManager : SocketManager {

        public TeltonikaSocketManager (SocketProfile serviceProfile) : base(serviceProfile) {

        }

        protected override void Communicate (ref Client clientNew) {


           

            if (base.serviceProfile.socket == Service.FM1100) {

            }


            Thread.Sleep(1000);
        }
    }
}
