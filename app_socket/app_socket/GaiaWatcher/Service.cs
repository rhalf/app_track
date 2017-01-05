using GaiaWatcher.Classes;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {

    public class Service {

        public static string COMMAND {
            get {
                return "Command";
            }
        }

        public static string MVT100 {
            get {
                return "Mvt100";
            }
        }
        public static string T1 {
            get {
                return "T1";
            }
        }
        public static string FM1100 {
            get {
                return "Fm1100";

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
