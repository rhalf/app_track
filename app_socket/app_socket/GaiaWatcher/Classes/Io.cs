using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class Io {
        public int speed {
            get;
            set;
        }
        public int runtime {
            get;
            set;
        }
        public int odo {
            get;
            set;
        }
        public int acc {
            get;
            set;
        }
        public int sos {
            get;
            set;
        }
        public int epc {
            get;
            set;
        }
        public int batt {
            get;
            set;
        }
        public int vcc {
            get;
            set;
        }

        public int accel {
            get;
            set;
        }
        public int decel {
            get;
            set;
        }

        public int tow {
            get;
            set;
        }

        public int motion {
            get;
            set;
        }
        public int fuel {
            get;
            set;
        }

        public int rpm {
            get;
            set;
        }

        public int alarm {
            get;
            set;
        }
        public int mode {
            get;
            set;
        }
        public string ibutton {
            get;
            set;
        }

        public string picture {
            get;
            set;
        }
        public int weight {
            get;
            set;
        }
        public int relay1 {
            get;
            set;
        }
        public int relay2 {
            get;
            set;
        }
        public int relay3 {
            get;
            set;
        }
        public int relay4 {
            get;
            set;
        }
    }
}
