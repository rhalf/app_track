using GaiaWatcher.Classes;
using GaiaWatcherSocket;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Diagnostics;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace GaiaWatcher {

    public class SocketManager : Counter, INotifyPropertyChanged {

        public event PropertyChangedEventHandler PropertyChanged;

        public void notifyPropertyChanged (string propertyName) {
            PropertyChangedEventHandler handler = PropertyChanged;
            if (handler != null) {
                handler(this, new PropertyChangedEventArgs(propertyName));
            }
        }
        //====================================

        private TcpListener _tcpListener;
        private SocketProfile _socketProfile;

        protected Clients _clients;

        protected UnitDatas _bufferOut;
        protected UnitDatas _bufferIn;

        private bool _isRunning = false;

        public override Clients clients {
            get {
                return _clients;
            }
        }
        public override UnitDatas bufferIn {
            get {
                return _bufferIn;
            }
        }
        public override UnitDatas bufferOut {
            get {
                return _bufferOut;
            }
        }
        public SocketManager (SocketProfile socketProfile) {

            this._socketProfile = socketProfile;

            _tcpListener = new TcpListener(new IPEndPoint(IPAddress.Parse(this._socketProfile.ip), this._socketProfile.port));

            _clients = new Clients();
            _bufferIn = new UnitDatas();
            _bufferOut = new UnitDatas();

            Task task = new Task(() => {
                while (true) {
                    Thread.Sleep(1000);
                    refresh();
                }
            });
            task.Start();
        }
        private void refresh () {

            base.units = 0;

            foreach (Client clientItem in _clients.Values) {
                if (clientItem.imei != null)
                    base.units++;
            }

            notifyPropertyChanged("oBytesToKiloBytes");
            notifyPropertyChanged("iBytesToKiloBytes");
            notifyPropertyChanged("iPackets");
            notifyPropertyChanged("oPackets");
            notifyPropertyChanged("clients");
            notifyPropertyChanged("asyncs");
            notifyPropertyChanged("units");
            notifyPropertyChanged("bufferIn");
            notifyPropertyChanged("bufferOut");
            notifyPropertyChanged("task");

        }
        public SocketProfile serviceProfile {
            get {
                return _socketProfile;
            }
        }
        public bool isRunning {
            get {
                return _isRunning;
            }
        }
        public bool start () {
            try {

                if (_isRunning) {
                    return true;
                }


                _tcpListener.Start();
                _tcpListener.BeginAcceptTcpClient(new AsyncCallback(asyncBeginAccept), _tcpListener);


                _isRunning = true;
                return true;

            } catch (Exception exception) {
                Debug.Write(exception);
                _tcpListener.Stop();
                _isRunning = false;
                return false;

            }
        }
        public bool stop () {
            try {
                if (_isRunning) {
                    //if (_clients.Count > 0) {
                    //    foreach (Client client in _clients.Values) {
                    //        client.tcpClient.GetStream().Close();
                    //        client.tcpClient.Close();
                    //    }
                    //    _clients.Clear();
                    //}
                    _tcpListener.Stop();
                }
                return true;
            } catch {
                return false;
            }
        }
        private void asyncBeginAccept (IAsyncResult iAsyncResult) {


            Task task = Task.Factory.StartNew(() => {
                Client clientNew = null;
                try {
                    using (TcpClient tcpClient = _tcpListener.EndAcceptTcpClient(iAsyncResult)) {
                        tcpClient.ReceiveTimeout = 2 * 60 * 1000;
                        tcpClient.SendTimeout = 2 * 60 * 1000;


                        clientNew = new Client() {
                            tcpClient = tcpClient,
                            dateTime = DateTime.Now
                        };

                        clientAdd(clientNew);
                        if (clientNew.tcpClient != null) {
                            this.Communicate(ref clientNew);
                        }
                        clientRemove(clientNew);

                    }
                } catch (Exception exception) {
                    Log.client(clientNew, exception, null);
                }
            }, TaskCreationOptions.LongRunning);


            try {
                _tcpListener.BeginAcceptTcpClient(new AsyncCallback(asyncBeginAccept), _tcpListener);
            } catch {
                ;
            }
        }
        protected void clientAdd (Client client) {
            while (!_clients.ContainsKey(client.id)) {
                _clients.TryAdd(client.id, client);
            }
        }
        protected void clientRemove (Client client) {
            Client clientOld = null;
            while (_clients.ContainsKey(client.id)) {
                _clients.TryRemove(client.id, out clientOld);
            }
        }
        protected virtual void Communicate (ref Client clientNew) {
            throw new NotImplementedException();
        }
    }
}
