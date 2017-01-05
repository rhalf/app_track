using GaiaWatcher.Classes;
using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Data;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace GaiaWatcher.Database {
    public class Database {

        DatabaseProfile _databaseProfile;
        Query _query;

        private bool _isActivated = false;
        public Database (DatabaseProfile databaseProfile) {
            _databaseProfile = databaseProfile;
        }
        public bool start (List<SocketManager> serviceManagers) {
            try {

                if (_isActivated == true) {
                    return true;
                }


                foreach (SocketManager serviceManager in serviceManagers) {

                    for (int count = 0; count < serviceManager.serviceProfile.task; count++) {
                        Task task = new Task(new Action(() => {
               
                            serviceManager.task++;
                            while (_isActivated) {
                                uploadUnitDatas(serviceManager);
                            }
                            serviceManager.task--;
                        }));
                        task.Start();
                    }
                }

                _isActivated = true;
                return true;
            } catch (Exception exception) {
                return false;
            }
        }
        public bool stop () {
            try {
                if (!_isActivated) {
                    return true;
                }

                _isActivated = false;

                return true;
            } catch (Exception exception) {
                return false;
            }
        }
        public bool testMySql () {
            try {
                MySqlConnection mysqlConnection = new MySqlConnection(_databaseProfile.connectionString);
                mysqlConnection.Open();
                mysqlConnection.Close();
                return true;
            } catch (Exception exception) {
                Debug.Write(exception.StackTrace.ToString());
                return false;
            }
        }
        private void uploadUnitDatas (SocketManager serviceManager) {

            MySqlConnection mysqlConnection = new MySqlConnection(_databaseProfile.connectionString);

            Query query = new Query(mysqlConnection);

            if (serviceManager.bufferIn.IsEmpty) {
                Thread.Sleep(1000);
                return;
            }

            UnitData unitData = null;

            //Get data from the buffer.
            if (!serviceManager.bufferIn.TryDequeue(out unitData)) {
                //Log.exception(new Exception("Cannot dequeue bufferIn."));
                return;
            }

            if (unitData == null) {
                Log.exception(new Exception("The unitData is null."));
                return;
            }

            //Check Database Connection
            //if (mysqlConnection.State != ConnectionState.Open) {
            //    serviceManager.bufferIn.Enqueue(unitData);
            //    Log.exception(new Exception("Connection to database is not open."));
            //    return;
            //}

            //Check if unit is registered 
            try {
                Unit unit = query.getUnit(unitData.header.imei);
            } catch (Exception exception) {
                Log.exception(exception);
                return;
            }

            //Insert Data to the database server
            try {
                query.setUnitData(unitData);
            } catch (Exception exception) {
                Log.exception(exception);
                return;
            }
        }
    }
}
