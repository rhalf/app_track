/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Definition of class Strorage.
*/
using GaiaWatcher.Database;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcherSocket.Classes {
    public class Storage {
        private static Storage instance = null;

        private Storage () {

        }

        public static Storage getInstance () {
            if (instance == null) {
                instance = new Storage();
            }
            return instance;
        }

        public List<SocketProfile> getSocketProfiles () {
            try {
                List<SocketProfile> servicesProfiles = JsonConvert.DeserializeObject<List<SocketProfile>>(Properties.Settings.Default.ServiceProfiles);
                if (servicesProfiles == null) {
                    servicesProfiles = new List<SocketProfile>();
                }
                return servicesProfiles;
            } catch {
                return new List<SocketProfile>();
            }
        }

        public bool setServiceProfiles (List<SocketProfile> services) {
            try {
                Properties.Settings.Default.ServiceProfiles = JsonConvert.SerializeObject(services);
                Properties.Settings.Default.Save();
                return true;
            } catch  {
                return false;
            }
        }


        public DatabaseProfile getDatabaseProfile () {
            try {
                DatabaseProfile databaseProfile = JsonConvert.DeserializeObject<DatabaseProfile> (Properties.Settings.Default.DatabaseProfile);
                if (databaseProfile == null) {
                    databaseProfile = new DatabaseProfile();
                }
                return databaseProfile;
            } catch {
                return new DatabaseProfile();
            }
        }

        public bool setDatabaseProfile (DatabaseProfile databaseProfile) {
            try {
                Properties.Settings.Default.DatabaseProfile = JsonConvert.SerializeObject(databaseProfile);
                Properties.Settings.Default.Save();
                return true;
            } catch {
                return false;
            }
        }
    }
}
