/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class service. This includes types of the service that the socketManager is going to offer.
*/
using GaiaWatcher.Classes;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {

    public class Service {

        public static string COMMAND {
            get {
                return "COMMAND";
            }
        }

        public static string MVT100 {
            get {
                return "MVT100";
            }
        }
        public static string T1 {
            get {
                return "T1";
            }
        }
        public static string FM1100 {
            get {
                return "FM1100";

            }
        }

        private string _name;
    

        public Service (String name) {
            _name = name;
        }
        public string name {
            get {
                return _name;
            }
        }
        public override string ToString () {
            return _name;
        }


        public virtual CommandData parseCommandData (byte[] data) {
            throw new NotImplementedException();
        }

        public virtual UnitData parseUnitData (byte[] data) {
            throw new NotImplementedException();
        }

        public virtual Digital parseDigital (string value) {
            throw new NotImplementedException();
        }
        public virtual Analog parseAnalog (string value) {
            throw new NotImplementedException();
        }
        public virtual List<MeitrackCommand> commands () {
            throw new NotImplementedException();
        }
    }
}
