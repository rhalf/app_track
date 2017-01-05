using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Diagnostics;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Threading;

namespace GaiaWatcherSocket {

    public class Machine : INotifyPropertyChanged {

        double _systemRamSize = 0;
        double _systemCpuUsage = 0;
        double _systemProcessor = Environment.ProcessorCount;

        double _appCpuUsage = 0;
        double _appMemorySize = 0;
        double _appThreadCount = 0;
        double _appHandleCount = 0;

        TimeSpan _systemUpTime;



        private static Machine instance;

        public event PropertyChangedEventHandler PropertyChanged;

        public void NotifyPropertyChanged (string propertyName) {
            PropertyChangedEventHandler handler = PropertyChanged;
            if (handler != null) {
                handler(this, new PropertyChangedEventArgs(propertyName));
            }
        }

        private Machine () {

            string processName = Process.GetCurrentProcess().ProcessName;

            PerformanceCounter systemCpuCounter = new PerformanceCounter("Processor", "% Processor Time", "_Total");
            PerformanceCounter systemRamCounter = new PerformanceCounter("Memory", "Available MBytes");
            PerformanceCounter appProcessCounter = new PerformanceCounter("Process", "% Processor Time", processName);
            PerformanceCounter appMemoryCounter = new PerformanceCounter("Process", "Working Set - Private", processName);
            PerformanceCounter appThreadCounter = new PerformanceCounter("Process", "Thread Count", processName);
            PerformanceCounter appHandleCounter = new PerformanceCounter("Process", "Handle Count", processName);

            PerformanceCounter systemUpTimeCounter = new PerformanceCounter("System", "System Up Time");

            Task task = new Task(() => {
                while (true) {

                    Thread.Sleep(1000);

                    try {
                        instance._systemCpuUsage = systemCpuCounter.NextValue();
                        instance._systemRamSize = systemRamCounter.NextValue();
                        double appCpuUsage = _systemCpuUsage / appProcessCounter.NextValue() / _systemProcessor;

                        if (double.IsInfinity(appCpuUsage) || double.IsNaN(appCpuUsage)) {
                            instance._appCpuUsage = 0.00;
                        } else {
                            instance._appCpuUsage = appCpuUsage;
                        }
                        instance._appMemorySize = appMemoryCounter.NextValue() / 1024 / 1024;
                        instance._systemUpTime = TimeSpan.FromSeconds(systemUpTimeCounter.NextValue());
                        instance._appHandleCount = appHandleCounter.NextValue();
                        instance._appThreadCount = appThreadCounter.NextValue();
                    } catch (Exception exception) {
                        Debug.Write(exception.Message);
                    }

                    refresh();
                }
            });

            task.Start();
        }


        public static Machine getInstance () {
            if (instance == null) {
                instance = new Machine();
            }
            return instance;
        }


        public void refresh () {
            NotifyPropertyChanged("name");
            NotifyPropertyChanged("os");
            NotifyPropertyChanged("ips");
            NotifyPropertyChanged("processor");
            NotifyPropertyChanged("core");
            NotifyPropertyChanged("utc");

            NotifyPropertyChanged("mem");
            NotifyPropertyChanged("cpu");
            NotifyPropertyChanged("thread");
            NotifyPropertyChanged("handle");
            NotifyPropertyChanged("app");
            NotifyPropertyChanged("upTime");


        }

        //=====================================================================
        public string name {
            get {
                return System.Environment.MachineName;
            }
        }
        public string os {
            get {
                string bit = "";
                if (System.Environment.Is64BitOperatingSystem) {
                    bit = " 64 bit";
                } else {
                    bit = " 32 bit";
                }
                return System.Environment.OSVersion.ToString() + bit;
            }
        }
        public List<string> publicIps {
            get {
                IPHostEntry host;
                host = Dns.GetHostEntry(Dns.GetHostName());


                List<String> listIp = new List<String>();
                foreach (IPAddress ip in host.AddressList) {
                    if (ip.AddressFamily.ToString() == "InterNetwork") {
                        if (ip.AddressFamily == System.Net.Sockets.AddressFamily.InterNetwork) {
                            listIp.Add(ip.ToString());
                        }
                    }
                }
                return listIp;
            }
        }
        public List<string> ips {
            get {
                IPHostEntry host;
                host = Dns.GetHostEntry(Dns.GetHostName());


                List<String> listIp = new List<String>();
                foreach (IPAddress ip in host.AddressList) {
                    if (ip.AddressFamily.ToString() == "InterNetwork") {
                        if (ip.AddressFamily == System.Net.Sockets.AddressFamily.InterNetwork) {
                            listIp.Add(ip.ToString());
                        }
                    }
                }
                return listIp;
            }
        }
        public string processor {
            get {
                return _systemProcessor.ToString();
            }
        }

        public string cpu {
            get {
                return string.Format("{0:0.00}", _systemCpuUsage) + "%";
            }
        }
        public string mem {
            get {
                return string.Format("{0:0.00}", _appMemorySize) + "mb";
            }
        }
        public string app {
            get {
                return string.Format("{0:0.00}", _appCpuUsage) + "%";
            }
        }

        public string thread {
            get {
                return _appThreadCount.ToString();
            }
        }

        public string handle {
            get {
                return _appHandleCount.ToString();
            }
        }
        public string upTime {
            get {
                return _systemUpTime.ToString(@"dd\.hh\:mm\:ss");
            }
        }

        public string utc {
            get {
                return DateTime.UtcNow.ToString("yy-MM-dd HH:mm:ss");
            }
        }
        //=====================================================================
    }
}