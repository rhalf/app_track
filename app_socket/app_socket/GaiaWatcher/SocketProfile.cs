using GaiaWatcher;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace GaiaWatcherSocket {

    public class SocketProfile : INotifyPropertyChanged {

     

        public event PropertyChangedEventHandler PropertyChanged;

        public void NotifyPropertyChanged (string propertyName) {
            PropertyChangedEventHandler handler = PropertyChanged;
            if (handler != null) {
                handler(this, new PropertyChangedEventArgs(propertyName));
            }
        }

        //===============================================================

        public SocketProfile () {
          
            //_task = new Task(new Action(() => {
            //    while (true) {
            //        Thread.Sleep(1000);
            //        NotifyPropertyChanged("isEnabled");
            //        NotifyPropertyChanged("device");
            //        NotifyPropertyChanged("ip");
            //        NotifyPropertyChanged("port");
            //    }
            //}));
            //_task.Start();
        }

        public void refresh() {
            NotifyPropertyChanged("isEnabled");
            NotifyPropertyChanged("socket");
            NotifyPropertyChanged("ip");
            NotifyPropertyChanged("port");
            NotifyPropertyChanged("task");

        }

        //===============================================================

        public long id {
            get;
            set;
        }

        public bool isEnabled {
            get;
            set;
        }

        public Company company{
            get;
            set;
        }
        public string socket {
            get;
            set;
        }
        
        public string ip {
            get;
            set;
        }

        public int port {
            get;
            set;
        }

        public int task {
            get;
            set;
        }

    }
}
