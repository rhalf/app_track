namespace GaiaWatcher {
    public class CommandData {
        public string imei {
            get;
            set;
        }
        public string command {
            get;
            set;
        }

        public string[] parameter {
            get;
            set;
        }

        public Service service {
            get;
            set;
        }

    }
}