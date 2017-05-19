/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class socketManager. This is a baseClass for all sockets that will listen to tcp.
*/
using GaiaWatcher.Classes;
using GaiaWatcherSocket;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Diagnostics;
using System.IO;
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
        protected ClientUnits _clientUnits;

        protected BufferQueue _bufferUnitDatas;
        protected BufferDictionary _bufferCommands;

        private bool _isRunning = false;

        public override Clients clients {
            get {
                return _clients;
            }
        }
        public override ClientUnits clientUnits {
            get {
                return _clientUnits;
            }
        }
        public override BufferQueue bufferUnitDatas {
            get {
                return _bufferUnitDatas;
            }
        }

        public override BufferDictionary bufferCommands {
            get {
                return _bufferCommands;
            }
            set {
                _bufferCommands = value;
            }
        }

        public SocketManager (SocketProfile socketProfile) {

            this._socketProfile = socketProfile;

            _tcpListener = new TcpListener(new IPEndPoint(IPAddress.Parse(this._socketProfile.ip), this._socketProfile.port));

            _clients = new Clients();
            _clientUnits = new ClientUnits();
            _bufferUnitDatas = new BufferQueue();
            _bufferCommands = new BufferDictionary();

            Task task = new Task(() => {
                while (true) {
                    Thread.Sleep(2000);
                    refresh();
                }
            });
            task.Start();
        }
        private void refresh () {



            //TimeSpan timeSpan = DateTime.Now.Subtract(clientItem.dateTime);
            //if (timeSpan.TotalMinutes > 5) {
            //    clientRemove(clientItem);
            //}

            notifyPropertyChanged("oBytesToKiloBytes");
            notifyPropertyChanged("iBytesToKiloBytes");
            notifyPropertyChanged("iPackets");
            notifyPropertyChanged("oPackets");
            notifyPropertyChanged("clients");
            notifyPropertyChanged("clientUnits");
            notifyPropertyChanged("asyncs");
            notifyPropertyChanged("bufferCommands");
            notifyPropertyChanged("bufferUnitDatas");
            notifyPropertyChanged("task");
            notifyPropertyChanged("clientCreated");
            notifyPropertyChanged("clientDestroyed");

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
                try {
                    using (TcpClient tcpClient = _tcpListener.EndAcceptTcpClient(iAsyncResult)) {
                        tcpClient.ReceiveTimeout = 1000 * 60 * 3;
                        tcpClient.SendTimeout = 1000 * 60 * 3;
                        tcpClient.NoDelay = true;

                        IPEndPoint remote = (IPEndPoint)tcpClient.Client.RemoteEndPoint;

                        Client clientNew = new Client() {
                            tcpClient = tcpClient,
                            dateTime = new DateTime(DateTime.Now.Ticks),
                            ip = remote.Address.ToString()
                        };

                        clientCreated++;
                        clients.add(clientNew);
                        if (clientNew.tcpClient != null) {
                            this.Communicate(ref clientNew);
                        }
                        clients.remove(clientNew);
                        clientDestroyed++;
                    }
                } catch (IOException ioException) {
                    Log.exception(ioException);
                } catch (Exception exception) {
                    Log.exception(exception);
                }
            }, TaskCreationOptions.LongRunning);

            try {
                _tcpListener.BeginAcceptTcpClient(
                    new AsyncCallback(asyncBeginAccept),
                    _tcpListener);
            } catch {
                ;
            }
        }


        protected virtual void Communicate (ref Client clientNew) {
            throw new NotImplementedException();
        }
    }
}
