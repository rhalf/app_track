using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Diagnostics;

using GaiaWatcher;
using Newtonsoft.Json;

namespace GaiaWatcherSocket {
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window {

        Application app;

        List<Service> services;


        public MainWindow () {
            InitializeComponent();

            app = new Application();

            try {
                services = JsonConvert.DeserializeObject<List<Service>>(Properties.Settings.Default.Services);
                listViewServers.DataContext = services;
            } catch (Exception exception) {
                Debug.Write(exception.Message);
            }

            gridTop.DataContext = app;

        }

        private void buttonStartStop_Click (object sender, RoutedEventArgs e) {
            app.isStarted = !app.isStarted;
        }
    }
}
