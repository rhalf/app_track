using System.Text;

namespace GaiaWatcher {
    public class CommandData {
        public string imei {
            get;
            set;
        }
        public string command {
            get;
            set;
        }

        public string parameter {
            get;
            set;
        }

        public Service service {
            get;
            set;
        }

        public byte[] generate () {
            string raw = "";

            if (this.service.name == Service.MVT100) {
                if (this.command == "vehicle_locate") {
                    string data = "," + this.imei + ",A10*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }
                if (this.command == "vehicle_disable") {
                    string data = "," + this.imei + ",C01,0,11111*";
                    raw = "@@M" + (data.Length + 2+2).ToString() + data;
                }
                if (this.command == "vehicle_enable") {
                    string data = "," + this.imei + ",C01,0,00000*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }
                if (this.command == "device_gsm_reboot") {
                    string data = "," + this.imei + ",F01*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }
                if (this.command == "device_gprs_reboot") {
                    string data = "," + this.imei + ",F02*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }
                if (this.command == "device_cache_clear") {
                    string data = "," + this.imei + ",F09,3*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }
           
                if (this.command == "device_sleep_disable") {
                    string data = "," + this.imei + ",A73,0*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }
                if (this.command == "device_sleep_normal") {
                    string data = "," + this.imei + ",A73,1*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }
                if (this.command == "device_sleep_deep") {
                    string data = "," + this.imei + ",A73,2*";
                    raw = "@@M" + (data.Length + 2 + 2).ToString() + data;
                }

                raw += Meitrack.getInstance().generateSum(raw) + "\r\n";
                return ASCIIEncoding.UTF8.GetBytes(raw);

            }
            if (this.service.name == Service.T1) {

            }
         
            if (this.service.name == Service.FM1100) {

            }

            return ASCIIEncoding.UTF8.GetBytes(raw);
        }

    }
}