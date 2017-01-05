using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcher.Classes;

namespace GaiaWatcher {

    public class Command : Service {

        private static Command instance = null;

        public static Command getInstance () {
            if (instance == null) {
                instance = new Command();
            }
            return instance;
        }
        private Command() : base(Service.COMMAND) {

        }




        public override CommandData parseCommandData (byte[] data) {
            return base.parseCommandData(data);
        }
    }
}