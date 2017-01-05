using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace GaiaWatcher {
    public class GaiaWatcher {

        private static GaiaWatcher instance = null;

        private GaiaWatcher () { }

        public static GaiaWatcher getInstance () {
            if (instance == null) {
                instance = new GaiaWatcher();
            }
            return instance;
        }

        public List<Company> getCompanies () {

            List<Company> companies = new List<Company>();

            var ats = new Company(Company.ATS);
            var meitrack = new Company(Company.MEITRACK);
            var teltonika = new Company(Company.TELTONIKA);

            companies.Add(ats);
            companies.Add(meitrack);
            companies.Add(teltonika);

            return companies;
        }
    }
}
