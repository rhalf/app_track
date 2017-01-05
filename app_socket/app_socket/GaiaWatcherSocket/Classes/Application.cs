using GaiaWatcher;
using GaiaWatcher.Database;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Threading;

namespace GaiaWatcherSocket {

    public class Application : INotifyPropertyChanged {

        private static Application instance = null;

        private DateTime _socketStartTime;
        private DateTime _databaseStartTime;

        public event PropertyChangedEventHandler PropertyChanged;

        public void NotifyPropertyChanged (string propertyName) {
            PropertyChangedEventHandler handler = PropertyChanged;
            if (handler != null) {
                handler(this, new PropertyChangedEventArgs(propertyName));
            }
        }

        public static Application getInstance () {
            if (instance == null) {
                instance = new Application();
            }

            instance.socketProfiles = new List<SocketProfile>();
            instance.socketManagers = new List<SocketManager>();

            return instance;
        }

        public Machine machine {
            get {
                return Machine.getInstance();
            }
        }
        public DatabaseProfile databaseProfile {
            get;
            set;
        }
        public Database database {
            get;
            set;
        }
        public List<SocketProfile> socketProfiles {
            get;
            set;
        }
        public List<SocketManager> socketManagers {
            get;
            set;
        }

        public DateTime socketStartTime {
            get {
                return this._socketStartTime;
            }
            set {
                this._socketStartTime = value;
                NotifyPropertyChanged("socketStartTime");
            }
        }
        public DateTime databaseStartTime {
            get {
                return this._databaseStartTime;
            }
            set {
                this._databaseStartTime = value;
                NotifyPropertyChanged("databaseStartTime");
            }
        }
    }
}
