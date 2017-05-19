using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows;

namespace GaiaWatcher.Database {
    public class Query {


        private DatabaseProfile _databaseProfile = null;


        public Query (DatabaseProfile databaseProfile) {
            this._databaseProfile = databaseProfile;
        }


        public Unit getUnit (string imei) {

            Unit unit = null;

            using (MySqlConnection mySqlConnection = new MySqlConnection(_databaseProfile.connectionString)) {

                mySqlConnection.Open();

                string sql =
               "SELECT * " +
               "FROM app_main.unit " +
               "WHERE app_main.unit.unit_imei = @imei " +
               "LIMIT 1;";

                using (MySqlCommand mySqlCommand = new MySqlCommand(sql, mySqlConnection)) {

                    mySqlCommand.Parameters.AddWithValue("@imei", imei);

                    using (MySqlDataReader mySqlDataReader = mySqlCommand.ExecuteReader()) {
                        if (!mySqlDataReader.HasRows) {
                            mySqlDataReader.Dispose();
                            return null;
                        } else {
                            mySqlDataReader.Read();
                            unit = new Unit();
                            unit.id = mySqlDataReader.GetInt32("id");
                            unit.imei = mySqlDataReader.GetString("unit_imei");
                            unit.serial = mySqlDataReader.GetString("unit_serial_number");
                            unit.dtCreated = mySqlDataReader.GetDateTime("unit_dt_created");
                            mySqlDataReader.Close();
                        }
                    }
                }   
            }

            return unit;
        }

        public void setUnitData (UnitData unitData) {

            using (MySqlConnection mySqlConnection = new MySqlConnection(_databaseProfile.connectionString)) {

                mySqlConnection.Open();

                string databaseName = "app_data_2017";
                string tableName = "data_" + unitData.header.imei;

                string sql =
                   "INSERT INTO " + databaseName + "." + tableName + " " +
                   "(" +

                    "h_server, h_client, h_command, h_event, h_length," +

                    "g_latitude, g_longitude, g_altitude, g_course, g_satellite, g_status, g_accuracy," +

                    "c_signal, c_status," +

                    "i_speed, i_runtime, i_odo, i_acc, i_sos, i_epc, i_batt," +

                    "i_vcc, i_accel, i_decel, i_tow, i_motion, i_fuel, i_rpm," +

                    "i_alarm, i_mode, i_pic, i_ibutton, i_weight, i_relay1, i_relay2," +

                    "i_relay3, i_relay4" +

                   ")" +
                   "VALUES (" +

                    "@h_server, @h_client, @h_command, @h_event, @h_length," +

                    "@g_latitude, @g_longitude, @g_altitude, @g_course, @g_satellite, @g_status, @g_accuracy," +

                    "@c_signal, @c_status," +

                    "@i_speed, @i_runtime, @i_odo, @i_acc, @i_sos, @i_epc, @i_batt," +

                    "@i_vcc, @i_accel, @i_decel, @i_tow, @i_motion, @i_fuel, @i_rpm," +

                    "@i_alarm, @i_mode, @i_pic, @i_ibutton, @i_weight, @i_relay1, @i_relay2," +

                    "@i_relay3, @i_relay4" +

                   ");";

                using (MySqlCommand mySqlCommand = new MySqlCommand(sql, mySqlConnection)) {

                    mySqlCommand.Parameters.AddWithValue("@h_server", unitData.header.server);
                    mySqlCommand.Parameters.AddWithValue("@h_client", unitData.header.client);
                    mySqlCommand.Parameters.AddWithValue("@h_command", unitData.header.meitrackCommand.id);
                    mySqlCommand.Parameters.AddWithValue("@h_event", unitData.header.meitrackEvent.code);
                    mySqlCommand.Parameters.AddWithValue("@h_length", unitData.header.length);


                    mySqlCommand.Parameters.AddWithValue("@g_latitude", unitData.gps.coordinate.latitude);
                    mySqlCommand.Parameters.AddWithValue("@g_longitude", unitData.gps.coordinate.longitude);
                    mySqlCommand.Parameters.AddWithValue("@g_altitude", unitData.gps.coordinate.altitude);
                    mySqlCommand.Parameters.AddWithValue("@g_course", unitData.gps.coordinate.course);
                    mySqlCommand.Parameters.AddWithValue("@g_satellite", unitData.gps.satellite);
                    mySqlCommand.Parameters.AddWithValue("@g_status", unitData.gps.status);
                    mySqlCommand.Parameters.AddWithValue("@g_accuracy", unitData.gps.accuracy);

                    mySqlCommand.Parameters.AddWithValue("@c_signal", unitData.gprs.signal);
                    mySqlCommand.Parameters.AddWithValue("@c_status", unitData.gprs.status);

                    mySqlCommand.Parameters.AddWithValue("@i_speed", unitData.io.speed);
                    mySqlCommand.Parameters.AddWithValue("@i_runtime", unitData.io.runtime);
                    mySqlCommand.Parameters.AddWithValue("@i_odo", unitData.io.odo);
                    mySqlCommand.Parameters.AddWithValue("@i_acc", unitData.io.acc);
                    mySqlCommand.Parameters.AddWithValue("@i_sos", unitData.io.sos);
                    mySqlCommand.Parameters.AddWithValue("@i_epc", unitData.io.epc);
                    mySqlCommand.Parameters.AddWithValue("@i_batt", unitData.io.batt);

                    mySqlCommand.Parameters.AddWithValue("@i_vcc", unitData.io.vcc);
                    mySqlCommand.Parameters.AddWithValue("@i_accel", unitData.io.accel);
                    mySqlCommand.Parameters.AddWithValue("@i_decel", unitData.io.decel);
                    mySqlCommand.Parameters.AddWithValue("@i_tow", unitData.io.tow);
                    mySqlCommand.Parameters.AddWithValue("@i_motion", unitData.io.motion);
                    mySqlCommand.Parameters.AddWithValue("@i_fuel", unitData.io.fuel);
                    mySqlCommand.Parameters.AddWithValue("@i_rpm", unitData.io.rpm);

                    mySqlCommand.Parameters.AddWithValue("@i_alarm", unitData.io.alarm);
                    mySqlCommand.Parameters.AddWithValue("@i_mode", unitData.io.mode);
                    mySqlCommand.Parameters.AddWithValue("@i_pic", unitData.io.picture);
                    mySqlCommand.Parameters.AddWithValue("@i_ibutton", unitData.io.ibutton);
                    mySqlCommand.Parameters.AddWithValue("@i_weight", unitData.io.weight);

                    mySqlCommand.Parameters.AddWithValue("@i_relay1", unitData.io.relay1);
                    mySqlCommand.Parameters.AddWithValue("@i_relay2", unitData.io.relay2);
                    mySqlCommand.Parameters.AddWithValue("@i_relay3", unitData.io.relay3);
                    mySqlCommand.Parameters.AddWithValue("@i_relay4", unitData.io.relay4);

                    mySqlCommand.ExecuteNonQuery();
                }
            }
        }
    }
}
