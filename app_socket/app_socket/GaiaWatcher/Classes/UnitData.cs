using GaiaWatcher.Classes;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {
    public class UnitData {

        public Header header {
            get;
            set;
        }

        public Gps gps {
            get;
            set;
        }

        public Gprs gprs {
            get;
            set;
        }

        public Io io {
            get;
            set;
        }
    }
}
