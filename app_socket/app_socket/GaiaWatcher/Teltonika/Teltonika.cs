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
