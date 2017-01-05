using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcher.Classes;
using System.Globalization;
using System.Diagnostics;

namespace GaiaWatcher {

    public class Mvt100 : Service {

        private static Mvt100 _instance = null;

        private Mvt100 () : base(Service.MVT100) {

        }

        public static Mvt100 getInstance () {
            if (_instance == null) {
                _instance = new Mvt100();
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

            unitData = new UnitData();

            string[] datas = ASCIIEncoding.UTF8.GetString(data, 0, data.Length).Trim('\0').Split(',');

            int protocol = 0;
            if (!String.IsNullOrEmpty(datas[19]) && datas[19][0] != '*') {
                protocol = int.Parse(datas[19]);
            }

            unitData.header = new Header() {
                server = DateTime.UtcNow,
                client = DateTime.ParseExact(datas[6], "yyMMddHHmmss", CultureInfo.InvariantCulture),
                imei = datas[1],
                unit = this.name,
                length = data.Length,
                meitrackCommand = Meitrack.getInstance().getMeitrackCommand(datas[2]),
                meitrackEvent = Meitrack.getInstance().getMeitrackEvent(int.Parse(datas[3])),
                protocol = protocol
            };

            unitData.gps = new Gps() {
                coordinate = new Coordinate() {
                    latitude = Double.Parse(datas[4]),
                    longitude = Double.Parse(datas[5]),
                    altitude = int.Parse(datas[13]),
                    course = int.Parse(datas[11])
                },
                accuracy = (int)double.Parse(datas[12]),
                satellite = int.Parse(datas[8]),
                status = (datas[7] == "A") ? 1 : 0

            };

            unitData.gprs = new Gprs() {
                signal = int.Parse(datas[9]),
                status = datas[16]
            };


            Digital digital = this.parseDigital(datas[17]);
            Analog analog = this.parseAnalog(datas[18]);

            double batt = 0;
            double vcc = 0;


            batt = (analog.input[3] * 3.3 * 2) / 4096;
            vcc = (analog.input[4] * 3.3 * 16) / 4096;

            unitData.io = new Io() {
                speed = int.Parse(datas[10]),
                runtime = int.Parse(datas[15]),
                odo = int.Parse(datas[14]),

                sos = digital.input[0],
                acc = digital.input[1],
                epc = analog.input[4] > 0 ? 1 : 0,

                batt = batt,
                vcc = vcc
            };

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
            int iValue = int.Parse(value, System.Globalization.NumberStyles.HexNumber);

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
            //123|456|235|1456|222 (Hexadecimal)
            //AD1|AD2|AD3|BatteryVoltage|ExternalVoltage

            Analog analog = new Analog();
            string[] values = null;

            try {
                values = value.Split('|');

                foreach (string n in values) {
                    int iValue = int.Parse(n, System.Globalization.NumberStyles.HexNumber);
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
