using GaiaWatcher.Classes;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {
    public class Header {

        public DateTime server {
            get;
            set;
        }
        public DateTime client {
            get;
            set;
        }
        public string unit {
            get;
            set;
        }
        public string imei {
            get;
            set;
        }
        public  MeitrackCommand meitrackCommand {
            get;
            set;
        }
        public MeitrackEvent meitrackEvent {
            get;
            set;
        }
        public int length {
            get;
            set;
        }
        public int protocol {
            get;
            set;
        }
    }
}
