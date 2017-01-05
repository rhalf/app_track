using GaiaWatcher.Classes;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {
    public class Unit {

        public int id {
            get;
            set;
        }

        public string imei{
            get;
            set;
        }
        public string serial {
            get;
            set;
        }
        public DateTime dtCreated {
            get;
            set;
        }
    }
}
