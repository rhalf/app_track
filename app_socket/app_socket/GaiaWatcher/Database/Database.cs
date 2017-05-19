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

            try {
                Query query = new Query(_databaseProfile);

                if (serviceManager.bufferUnitDatas.IsEmpty) {
                    Thread.Sleep(1000);
                    return;
                }

                //Get data from the buffer.
                object object1 = null;
                if (!serviceManager.bufferUnitDatas.TryDequeue(out object1)) {
                    //Log.exception(new Exception("Cannot dequeue buffer."));
                    return;
                }
                if (object1 == null) {
                    Log.exception(new Exception("The unitData is null."));
                    return;
                }

                //UnitData Cast and validate
                UnitData unitData = (UnitData)object1;
                if (unitData == null) {
                    Log.unitData(unitData, new Exception("Cant parse unitData data from unitDatas."));
                    return;
                }
                if (unitData.header == null || unitData.gps == null || unitData.gprs == null || unitData.io == null) {
                    Log.unitData(unitData, new Exception("Cant parse unitData property data from unitDatas."));
                    return;
                }

                //Check Database Connection
                //if (mysqlConnection.State != ConnectionState.Open) {
                //    serviceManager.buffer.Enqueue(unitData);
                //    Log.exception(new Exception("Connection to database is not open."));
                //    return;
                //}


                //Check if unit is registered 
                Unit unit = query.getUnit(unitData.header.imei);
                if (unit == null) {
                    Log.unitData(unitData, new Exception(unitData.header.imei + " is not registered to the system."));
                    return;
                }

                //Insert Data to the database server
                query.setUnitData(unitData);

            } catch (Exception exception) {
                Log.exception(exception);
            }
        }
    }
}
