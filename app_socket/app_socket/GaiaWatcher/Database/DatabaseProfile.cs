using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher.Database {
    public class DatabaseProfile {

        public string ip {
            get;
            set;
        }

        public string port {
            get;
            set;
        }

        public string databaseName {
            get;
            set;
        }

        public string username {
            get;
            set;
        }

        public string password {
            get;
            set;
        }


        public string connectionString {
            get {
                //Standard
                //Server = myServerAddress; Database = myDataBase; Uid = myUsername; Pwd = myPassword;
                //Specifying TCP port
                //Server=myServerAddress;Port=1234;Database=myDataBase;Uid=myUsername; Pwd = myPassword;
                return "SERVER=" + this.ip + ";" + "PORT=" + this.port.ToString() + ";" + "DATABASE=" + this.databaseName + ";" + "UID=" + this.username + ";" + "PASSWORD=" + this.password + ";";
            }
        }



    }
}
