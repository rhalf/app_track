using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcher.Classes;
using System.Globalization;

namespace GaiaWatcher {

    public class T1 : Service {

        private static T1 _instance = null;

        public T1 () : base(Service.T1) {

        }

        public static T1 getInstance () {
            if (_instance == null) {
                _instance = new T1();
            }
            return _instance;
        }



        public override List<MeitrackCommand> commands () {
            List<MeitrackCommand> commands = new List<MeitrackCommand>();
            commands.Add(new MeitrackCommand() { code = "A10", description = "Real-Time Location Query" });
            commands.Add(new MeitrackCommand() { code = "A11", description = "Setting a Heartbeat Packet Reporting Interval " });
            commands.Add(new MeitrackCommand() { code = "A12", description = "Track by Time Interval" });
            commands.Add(new MeitrackCommand() { code = "A13", description = "Setting the Heading Change Report Function" });
            commands.Add(new MeitrackCommand() { code = "A14", description = "Track by Distance" });
            commands.Add(new MeitrackCommand() { code = "A15", description = "Setting the Parking Scheduled Tracking Function" });
            commands.Add(new MeitrackCommand() { code = "A16", description = "Enabling the Parking Scheduled Tracking Function" });
            commands.Add(new MeitrackCommand() { code = "A17", description = "Enabling or Disabling the RFID Control OUT1 Function" });
            commands.Add(new MeitrackCommand() { code = "A19", description = "3D-Shake Wake Up" });
            commands.Add(new MeitrackCommand() { code = "A21", description = "Setting GPRS Parameters " });
            commands.Add(new MeitrackCommand() { code = "A22", description = "Setting the DNS Server IP Address" });
            commands.Add(new MeitrackCommand() { code = "A23", description = "Setting the Standby GPRS Server" });
            commands.Add(new MeitrackCommand() { code = "A70", description = "Reading All Authorized Phone Numbers" });
            return commands;
        }

        public override UnitData parseUnitData (byte[] data) {
            //[0]$$R148,
            //[1]865734029500608,
            //[2]AAA,
            //[3]35,
            //[4]25.261175,
            //[5]51.492953,
            //[6]151204083437,
            //[7]V,
            //[8]0,
            //[9]31,
            //[10]0,
            //[11]0,
            //[12]0.0,
            //[13]0,
            //[14]92921,
            //[15]2340711,
            //[16]=427|2|008E|53C1,
            //[17]ioDigital = 0421,
            //[18]ioAnalog = 0006|0000|0000|0A6E|03BD,
            //[19]protocol = 00000001,
            //[20]checksum = *D0\r\n

            UnitData unitData = null;

            try {

                unitData = new UnitData();

                string[] datas = ASCIIEncoding.UTF8.GetString(data, 0, data.Length).Trim('\0').Split(',');

                //============================================================Header
                int protocol = 0;
                if (!String.IsNullOrEmpty(datas[19]) && datas[19][0] != '*') {
                    Int32.TryParse(datas[19], out protocol);
                }

                int length = 0;
                if (data.Length > 0)
                    length = data.Length;

                string imei = "";
                if (!String.IsNullOrEmpty(datas[1])) {
                    imei = datas[1];
                } else {
                    throw new Exception("#header.imei");
                }

                int meitrackEvent = 35;
                if (!Int32.TryParse(datas[3], out meitrackEvent)) {
                    throw new Exception("#header.event");
                }

                string command = "AAA";
                if (!String.IsNullOrEmpty(datas[2])) {
                    command = datas[2];
                } else {
                    throw new Exception("#header.command");
                }

                DateTime client;
                if (!DateTime.TryParseExact(datas[6], "yyMMddHHmmss", CultureInfo.InvariantCulture, DateTimeStyles.None, out client)) {
                    throw new Exception("#header.client");
                }


                TimeSpan timeSpan = client.Subtract(DateTime.UtcNow);
                if (timeSpan.TotalSeconds > 60) {
                    throw new Exception("#header.client client:" + client.ToString("yy-MM-dd HH:mm:ss") + ",server:" + DateTime.UtcNow.ToString("yy-MM-dd HH:mm:ss"));
                }

                unitData.header = new Header() {
                    server = DateTime.UtcNow,
                    client = client,
                    imei = imei,
                    unit = this.name,
                    length = length,
                    meitrackCommand = Meitrack.getInstance().getMeitrackCommand(command),
                    meitrackEvent = Meitrack.getInstance().getMeitrackEvent(meitrackEvent),
                    protocol = protocol
                };

                //============================================================Gps
                double latitude = 0;
                double longitude = 0;
                int altitude = 0;
                int course = 0;


                if (!Double.TryParse(datas[4], out latitude)) {
                    throw new Exception("#coordinate.latitude");
                }
                if (!Double.TryParse(datas[5], out longitude)) {
                    throw new Exception("#coordinate.longitude");
                }
                if (!Int32.TryParse(datas[13], out altitude)) {
                    throw new Exception("#coordinate.altitude");
                }
                if (!Int32.TryParse(datas[11], out course)) {
                    throw new Exception("#coordinate.course");
                }

                Coordinate coordinate = new Coordinate() {
                    latitude = latitude,
                    longitude = longitude,
                    altitude = altitude,
                    course = course
                };


                double accuracy = 0;
                int satellite = 0;
                int gpsStatus = 0;

                if (!Double.TryParse(datas[12], out accuracy)) {
                    throw new Exception("#gps.accuracy");
                }
                if (!Int32.TryParse(datas[8], out satellite)) {
                    throw new Exception("#gps.satellite");
                }
                gpsStatus = (datas[7] == "A") ? 1 : 0; //1 if valid, 2 if invalid

                unitData.gps = new Gps() {
                    coordinate = coordinate,
                    accuracy = Convert.ToInt32(accuracy),
                    satellite = satellite,
                    status = gpsStatus
                };

                //============================================================Gprs
                int signal = 0;
                if (!Int32.TryParse(datas[9], out signal)) {
                    throw new Exception("#gprs.signal");
                }

                unitData.gprs = new Gprs() {
                    signal = signal,
                    status = datas[16]
                };

                //============================================================Io
                Digital digital = this.parseDigital(datas[17]);
                Analog analog = this.parseAnalog(datas[18]);

                double batt = 0;
                double vcc = 0;

                batt = (analog.input[3] * 3.3 * 2) / 4096;
                vcc = (analog.input[4] * 3.3 * 16) / 4096;

                batt = batt * 1000;
                vcc = vcc * 1000;

                int speed = 0;
                int runtime = 0;
                int odo = 0;

                if (!Int32.TryParse(datas[10], out speed)) {
                    throw new Exception("#io.speed");
                }
                if (!Int32.TryParse(datas[15], out runtime)) {
                    throw new Exception("#io.runtime");
                }
                if (!Int32.TryParse(datas[14], out odo)) {
                    throw new Exception("#io.odo");
                }


                unitData.io = new Io() {
                    speed = speed, //kph
                    runtime = runtime, //sec
                    odo = odo, //meter

                    sos = digital.input[0],//1 if on, 0 if off
                    acc = digital.input[1],//1 if on, 0 if off
                    epc = vcc > 6000 ? 0 : 1,//1 if cut, 0 if not

                    batt = Convert.ToInt32(batt),//millivolts
                    vcc = Convert.ToInt32(vcc),//millivolts

                    relay1 = digital.output[0],
                    relay2 = digital.output[1],
                    relay3 = digital.output[2],
                    relay4 = digital.output[3],

                    picture = "",
                    ibutton = ""
                };

            } catch (Exception exception) {
                Log.exception(new Exception("T1 : UnitData is corrupted." + exception.Message, exception));
            }

            return unitData;
        }

        public override Digital parseDigital (string value) {
            //output
            //bit[0] = output1
            //bit[1] = output2
            //bit[2] = output3
            //bit[3] =
            //bit[4] =
            //bit[5] =
            //bit[6] =
            //bit[7] =
            //input
            //bit[8] = input1(SOS)
            //bit[9] = input2
            //bit[10] = input3
            //bit[11] =
            //bit[12] =
            //bit[13] =
            //bit[14] =
            //bit[15] =
            int iValue = 0;

            Int32.TryParse(value, System.Globalization.NumberStyles.HexNumber, System.Globalization.CultureInfo.InvariantCulture, out iValue);

            Digital digital = new Digital();

            for (int index = 0; index < 16; index++) {
                int bit = (iValue >> index) & 1;

                if (index < 8) {
                    digital.output.Add(bit);
                } else {
                    digital.input.Add(bit);
                }
            }

            return digital;
        }
        public override Analog parseAnalog (string value) {
            //Separated by "|".
            //Hexadecimal
            //AD1|AD2|AD3|BatteryVoltage|ExternalVoltage


            //Note:
            //Analog input values in an SMS report are empty.

            //Voltage formula of analog AD(AD1, AD2, and AD3): 
            //-MVT340 / MVT380: (AD x 6)/ 1024
            //-T1 / T3 / MVT600 / MVT800 / MVT100: (AD x 3.3 x 2)/ 4096
            //-T322X / T333 / T355: AD / 100

            //Voltage formula of battery analog(AD4): 
            //-MVT340 / MVT380: (AD4 x 3 x 2)/ 1024
            //-MT90 / T1 / T3 / MVT100 / MVT600 / MVT800 / TC68S: (AD4 x 3.3 x 2)/ 4096
            //-T311 / T322X / T333 / T355: AD4 / 100

            //Voltage formula of external power supply (AD5): 
            //-MVT340 / MVT380: (AD5 x 3 x 16)/ 1024
            //-T1 / T3 / MVT100 / MVT600 / MVT800 / TC68S: (AD5 x 3.3 x 16)/ 4096
            //-T311 / T322X / T333 / T355: AD5 / 100

            Analog analog = new Analog();
            string[] values = null;

            try {
                values = value.Split('|');

                foreach (string n in values) {
                    int iValue = 0;
                    Int32.TryParse(n, System.Globalization.NumberStyles.HexNumber, System.Globalization.CultureInfo.InvariantCulture, out iValue);
                    analog.input.Add(iValue);
                }

            } catch {

                for (int index = 0; index < 5; index++) {
                    analog.input.Add(0);
                    analog.output.Add(0);
                }

            }
            return analog;

        }
    }
}
