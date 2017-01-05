using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using GaiaWatcher;
using GaiaWatcher.Classes;

namespace GaiaWatcher {

    public class Meitrack {

        private static Meitrack instance = null;
        private List<MeitrackEvent> _meitrackEvents = null;
        private List<MeitrackCommand> _meitrackCommands = null;

        public static Meitrack getInstance () {
            if (instance == null) {
                instance = new Meitrack();
            }
            return instance;
        }

        private Meitrack () {
            //Commands
            _meitrackCommands = new List<MeitrackCommand>();
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A10", description = "Real-Time Location Query" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A11", description = "Setting a Heartbeat Packet Reporting Interval " });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A12", description = "Track by Time Interval" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A13", description = "Setting the Heading Change Report Function" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A14", description = "Track by Distance" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A15", description = "Setting the Parking Scheduled Tracking Function" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A16", description = "Enabling the Parking Scheduled Tracking Function" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A17", description = "Enabling or Disabling the RFID Control OUT1 Function" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A19", description = "3D-Shake Wake Up" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A21", description = "Setting GPRS Parameters " });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A22", description = "Setting the DNS Server IP Address" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A23", description = "Setting the Standby GPRS Server" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A70", description = "Reading All Authorized Phone Numbers" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A71", description = "Setting Authorized Phone Numbers" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A72", description = "Setting a Listen-in Phone Number" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "A73", description = "Setting the Smart Sleep Mode" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "AAA", description = "Automatic Event Report" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "AFF", description = "Deleting a GPRS Event in the Cache Zone" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B05", description = "Setting a Geo-Fence" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B06", description = "Deleting a Geo-Fence" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B07", description = "Setting the Speeding Alarm Function" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B08", description = "Setting the Towing Alarm Function" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B21", description = "Setting the Anti-Theft Function" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B31", description = "Turning Off the Indicator" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B06", description = "Deleting a Geo-Fence" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B34", description = "Setting a Log Interval" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B35", description = "Setting the SMS Time Zone" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B36", description = "Setting the GPRS Time Zone" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B60", description = "Checking the Engine First to Determine Tracker Running Status" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B91", description = "Setting SMS Event Characters" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B92", description = "Setting a GPRS Event Flag" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B93", description = "Reading a GPRS Event Flag " });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B96", description = "Setting a Photographing Event Flag" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B97", description = "Reading a Photographing Event Flag" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "B99", description = "Setting Event Authorization" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C01", description = "Output Control" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C02", description = "Notifying the Tracker of Sending an SMS" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C03", description = "Setting a GPRS Event Transmission Mode" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C13", description = "GPRS Information Display (LCD Display)" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C40", description = "Registering a Temperature Sensor Number" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C41", description = "Deleting a Registered Temperature Sensor" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C42", description = "Reading the Temperature Sensor SN and Number" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C43", description = "Setting a Temperature Value for the High/Low Temperature Alarm and Logical Name " });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C44", description = "Reading Temperature Sensor Parameters" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C46", description = "Checking Temperature Sensor Parameters" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C47", description = "Setting Fuel Parameters" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C48", description = "Reading Fuel Parameters" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "C49", description = "Setting a Fuel Theft Alarm" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D00", description = "Obtaining a Picture" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D01", description = "Obtaining the Picture List" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D02", description = "Deleting a Picture" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D03", description = "Timely Photograghing" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D10", description = "Authorizing an RFID Card" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D11", description = "Authorizing RFID Cards in Batches" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D12", description = "Checking Whether a RFID Is Authorized" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D13", description = "Reading an Authorized RFID" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D14", description = "Deleting an Authorized RFID" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D15", description = "Deleting Authorized RFIDs in Batches" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D16", description = "Checking the Checksum of the Authorized RFID Database" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D65", description = "Setting the Maintenance Mileage" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "D66", description = "Setting Maintenance Time" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "E91", description = "Reading the Tracker Firmware Version and SN" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "F01", description = "Restarting the GSM Module" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "F02", description = "Restarting the GPS Module" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "F08", description = "Setting the Mileage and Run Time" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "F09", description = "Deleting SMS/GPRS Cache Data" });
            _meitrackCommands.Add(new MeitrackCommand() { id = _meitrackCommands.Count, code = "F11", description = "Restoring Initial Settings" });
            //Events
            _meitrackEvents = new List<MeitrackEvent>();
            _meitrackEvents.Add(new MeitrackEvent() { code = 1, description = "SOS Pressed" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 2, description = "Input 2 Active" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 3, description = "Input 3 Active" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 4, description = "Input 4 Active" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 5, description = "Input 5 Active" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 9, description = "Input 1 Inactive" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 10, description = "Input 2 Inactive" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 11, description = "Input 3 Inactive" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 12, description = "Input 4 Inactive" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 13, description = "Input 5 Inactive" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 17, description = "Low Battery" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 18, description = "Low External Battery" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 19, description = "Speeding" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 20, description = "Enter Geo-fence" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 21, description = "Exit Geo-fence" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 22, description = "External Battery On" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 23, description = "External Battery Cut" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 24, description = "Lose GPS Signal" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 25, description = "GPS Signal Recovery" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 26, description = "Enter Sleep" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 27, description = "Exit Sleep" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 28, description = "GPS Antenna Cut" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 29, description = "Device Reboot" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 31, description = "Heartbeat" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 32, description = "Heading Change" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 33, description = "Distance Interval Tracking" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 34, description = "Reply Current (Passive)" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 35, description = "Time Interval Tracking" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 36, description = "Tow" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 37, description = "RFID" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 39, description = "Picture" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 40, description = "Power Off" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 41, description = "Stop Moving" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 42, description = "Start Moving" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 44, description = "GSM Jammed" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 50, description = "Temperature High" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 51, description = "Temperature Low" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 52, description = "Fuel Fulled" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 53, description = "Fuel Empty" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 54, description = "Fuel Stolen" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 56, description = "Armed" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 57, description = "Disarmed" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 58, description = "Stealing" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 63, description = "GSM No Jamming" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 65, description = "Press Input 1 (SOS) to Call" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 66, description = "Press Input 2 to Call" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 67, description = "Press Input 3 to Call" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 68, description = "Press Input 4 to Call" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 69, description = "Press Input 5 to Call" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 70, description = "Reject Incoming Call" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 71, description = "Get Location by Call" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 72, description = "Auto Answer Incoming Cal" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 73, description = "Listen-in (Voice Monitoring)" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 79, description = "Fall" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 80, description = "Install" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 81, description = "Drop Off" });
            _meitrackEvents.Add(new MeitrackEvent() { code = 139, description = "Maintenance Notice" });
        }




        public bool checkSum (Byte[] unitData) {

            //string[] datas = ASCIIEncoding.UTF8.GetString(unitData).Split(',');

            Byte[] check = new Byte[2];
            int total = 0;


            for (int index = 0; index < unitData.Length; index++) {

                total += unitData[index];

                if (unitData[index] == 0x2A) {
                    check[0] = unitData[index + 1];
                    check[1] = unitData[index + 2];
                    break;
                }
            }

            string sum = ASCIIEncoding.UTF8.GetString(check);
            int lastByte = total & 0x000000FF;
            int checkSum = int.Parse(sum, System.Globalization.NumberStyles.HexNumber);

            if (lastByte == checkSum) {
                return true;
            }
            return false;

        }

        public MeitrackEvent getMeitrackEvent (int code) {
            MeitrackEvent meitrackEventItem = null;
            foreach (MeitrackEvent meitrackEvent in _meitrackEvents) {
                if (meitrackEvent.code == code) {
                    meitrackEventItem = meitrackEvent;
                    break;
                }
            }
            return meitrackEventItem;
        }

        public MeitrackCommand getMeitrackCommand (string code) {
            MeitrackCommand meitrackCommandItem = null;
            foreach (MeitrackCommand meitrackCommand in _meitrackCommands) {
                if (meitrackCommand.code == code) {
                    meitrackCommandItem = meitrackCommand;
                    break;
                }
            }
            return meitrackCommandItem;
        }
    }
}