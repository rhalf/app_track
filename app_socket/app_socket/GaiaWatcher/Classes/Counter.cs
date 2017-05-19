using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher.Classes {
    public class Counter {

        public long oBytes {
            get;
            set;
        }
        public long iBytes {
            get;
            set;
        }
        public long oPackets {
            get;
            set;
        }
        public long iPackets {
            get;
            set;
        }
        public long asyncs {
            get;
            set;
        }

        public virtual Clients clients {
            get;
            set;
        }

        public virtual ClientUnits clientUnits {
            get;
            set;
        }

        public virtual BufferQueue bufferUnitDatas {
            get;
            set;
        }
        public virtual BufferDictionary bufferCommands {
            get;
            set;
        }
       

        public long clientCreated {
            get;
            set;
        }

        public long clientDestroyed {
            get;
            set;
        }

        public long task {
            get;
            set;
        }

        public double oBytesToKiloBytes {
            get {
                return oBytes / 1000;
            }
        }
        public double iBytesToKiloBytes {
            get {
                return iBytes / 1000;
            }
        }

    }
}
