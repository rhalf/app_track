using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;

namespace GaiaWatcher.Classes {
    public class Log {

        public static void unitData (UnitData unitData, Exception exception) {
            string title;
            if (unitData == null) {
                title = "UnitData";
            } else {
                title = unitData.header.imei;
            }

            string path = Environment.GetFolderPath(Environment.SpecialFolder.CommonApplicationData) + "\\" + System.AppDomain.CurrentDomain.FriendlyName + "\\logs";
            if (!Directory.Exists(path)) {
                Directory.CreateDirectory(path);
            }

            string dateValue = DateTime.Now.ToString("yyyy-MM-dd");
            string timeValue = DateTime.Now.ToString("HH:mm:ss");


            string fileName = path + "\\exception_" + dateValue + ".txt";

            if (!File.Exists(fileName)) {
                try {
                    using (StreamWriter streamWriter = new StreamWriter(fileName, false)) {
                        streamWriter.WriteLine("[" + timeValue + "]\t" + title);
                        streamWriter.WriteLine("\t\t" + exception.Message);
                        streamWriter.WriteLine("\t\t" + exception.StackTrace.ToString());
                    }
                } catch {
                    //Do nothing
                }
            } else {
                try {
                    using (StreamWriter streamWriter = new StreamWriter(fileName, true)) {
                        streamWriter.WriteLine("[" + timeValue + "]\t" + title);
                        streamWriter.WriteLine("\t\t" + exception.Message);
                        streamWriter.WriteLine("\t\t" + exception.StackTrace.ToString());
                    }
                } catch {
                    //Do nothing
                }
            }
        }
        public static void client (Client client, Exception exception, byte[] buffer) {

            string title;
            if (client == null) {
                title = "UnitData";
            } else {
                IPEndPoint remote = (IPEndPoint)client.tcpClient.Client.RemoteEndPoint;
                title = remote.Address.ToString();
            }

            string path = Environment.GetFolderPath(Environment.SpecialFolder.CommonApplicationData) + "\\" + System.AppDomain.CurrentDomain.FriendlyName + "\\logs";
            if (!Directory.Exists(path)) {
                Directory.CreateDirectory(path);
            }

            string dateValue = DateTime.Now.ToString("yyyy-MM-dd");
            string timeValue = DateTime.Now.ToString("HH:mm:ss");


            string fileName = path + "\\exception_" + dateValue + ".txt";

            if (!File.Exists(fileName)) {
                try {
                    using (StreamWriter streamWriter = new StreamWriter(fileName, false)) {
                        streamWriter.WriteLine("[" + timeValue + "]\t" + title);
                        streamWriter.WriteLine("\t\t" + exception.Message);
                        streamWriter.WriteLine("\t\t" + exception.StackTrace.ToString());
                        streamWriter.WriteLine("\t\t" + ASCIIEncoding.UTF8.GetString(buffer).Trim());
                    }
                } catch {
                    //Do nothing
                }
            } else {
                try {
                    using (StreamWriter streamWriter = new StreamWriter(fileName, true)) {
                        streamWriter.WriteLine("[" + timeValue + "]\t" + title);
                        streamWriter.WriteLine("\t\t" + exception.Message);
                        streamWriter.WriteLine("\t\t" + exception.StackTrace.ToString());
                        streamWriter.WriteLine("\t\t" + ASCIIEncoding.UTF8.GetString(buffer).Trim());
                    }
                } catch {
                    //Do nothing
                }
            }
        }
        public static void exception (Exception exception) {
            string path = Environment.GetFolderPath(Environment.SpecialFolder.CommonApplicationData) + "\\" + System.AppDomain.CurrentDomain.FriendlyName + "\\logs";
            if (!Directory.Exists(path)) {
                Directory.CreateDirectory(path);
            }

            string dateValue = DateTime.Now.ToString("yyyy-MM-dd");
            string timeValue = DateTime.Now.ToString("HH:mm:ss");


            string fileName = path + "\\exception_" + dateValue + ".txt";

            if (!File.Exists(fileName)) {
                try {
                    using (StreamWriter streamWriter = new StreamWriter(fileName, false)) {
                        streamWriter.WriteLine("[" + timeValue + "]\tException");
                        streamWriter.WriteLine("\t\t" + exception.Message);
                        streamWriter.WriteLine("\t\t" + exception.StackTrace.ToString());
                    }
                } catch {
                    //Do nothing
                }
            } else {
                try {
                    using (StreamWriter streamWriter = new StreamWriter(fileName, true)) {
                        streamWriter.WriteLine("[" + timeValue + "]\tException");
                        streamWriter.WriteLine("\t\t" + exception.Message);
                        streamWriter.WriteLine("\t\t" + exception.StackTrace.ToString());
                    }
                } catch {
                    //Do nothing
                }
            }

        }
    }
}
