using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {
    public class Digital {

        public Digital () {
            this.input = new List<int>();
            this.output = new List<int>();
        }

        public List<int> input {
            get;
            set;
        }

        public List<int> output {
            get;
            set;
        }
    }
}
 