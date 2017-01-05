using System;
using System.Collections.Concurrent;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using System.Text;

namespace GaiaWatcher {
    public class Coordinate {
        public double latitude {
            get;
            set;
        }
        public double longitude {
            get;
            set;
        }
        public double altitude {
            get;
            set;
        }
        public int course {
            get;
            set;
        }
    }
}
