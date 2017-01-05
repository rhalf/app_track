using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Cryptography;
using System.Text;

namespace GaiaWatcher.Classes {
    public class Helper {

        private static long seeder = 0;

        public static long genNewUniqueId() {
            return DateTime.UtcNow.Ticks;
        }
        public static long getNewSeedId () {
            seeder += 1;
            return seeder;
        }

      
    }
}
