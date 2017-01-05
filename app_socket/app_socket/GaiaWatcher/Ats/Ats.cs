using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcher.Classes;

namespace GaiaWatcher {

    public class Ats {

        private static Ats instance = null;

        public static Ats getInstance () {
            if (instance == null) {
                instance = new Ats();
            }
            return instance;
        }

        private Ats () {

        }


    }
}