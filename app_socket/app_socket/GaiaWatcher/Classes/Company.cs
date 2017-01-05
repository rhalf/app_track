using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {

    public class Company {

        public const string ATS = "Ats";
        public const string MEITRACK = "Meitrack";
        public const string TELTONIKA = "Teltonika";

        private string _name;

        public Company (string name) {
            _name = name;
        }

        public string name {
            get {
                return _name;
            }
        }
        public List<string> sockets {
            get {
                switch (this.name) {
                    case Company.ATS: {
                            List<string> services = new List<String>();
                            services.Add(Service.COMMAND);
                            return services;
                        }
                    case Company.MEITRACK: {
                            List<string> services = new List<String>();
                            services.Add(Service.MVT100);
                            services.Add(Service.T1);
                            return services;
                        }
                    case Company.TELTONIKA: {
                            List<string> services = new List<String>();
                            services.Add(Service.FM1100);
                            return services;
                        }
                    default:
                        return null;
                }
            }
        }
        public override string ToString () {
            return _name;
        }
    }
}
