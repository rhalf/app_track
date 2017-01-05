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
using GaiaWatcherSocket.Classes;
using System.Windows.Controls.Primitives;
using GaiaWatcher.Database;
using System.Threading.Tasks;
using System.Windows.Threading;
using System.Threading;
using GaiaWatcherSocket.Forms;

namespace GaiaWatcherSocket {
    /// <summary>
    /// Interaction logic for WindowMain.xaml
    /// </summary>
    public partial class WindowMain : Window {

        Application _application;

        public WindowMain () {
            InitializeComponent();
        }

        #region SocketProfile
        private void buttonServiceProfileAdd_Click (object sender, RoutedEventArgs e) {
            WindowServiceProfile windowServiceProfile = new WindowServiceProfile();
            windowServiceProfile.ShowDialog();

            reloadSocketProfiles();
        }
        private void buttonServiceProfileEdit_Click (object sender, RoutedEventArgs e) {

            if (listViewSocketProfile.SelectedItem == null)
                return;

            SocketProfile serviceProfile = (SocketProfile)listViewSocketProfile.SelectedItem;

            WindowServiceProfile windowServiceProfile = new WindowServiceProfile(serviceProfile);
            windowServiceProfile.ShowDialog();

            reloadSocketProfiles();
        }
        private void buttonServiceProfileDelete_Click (object sender, RoutedEventArgs e) {
            if (listViewSocketProfile.SelectedItem == null)
                return;

            SocketProfile serviceProfile = (SocketProfile)listViewSocketProfile.SelectedItem;

            MessageBoxResult messageBoxResult = MessageBox.Show(
                "Are you sure you want to delete this?\n\n" +
                "id : " + serviceProfile.id + "\n" +
                "company : " + serviceProfile.company.name + "\n" +
                "service : " + serviceProfile.socket + "\n" +
                "ip : " + serviceProfile.ip + "\n" +
                "port : " + serviceProfile.port + "\n" +
                "isEnabled : " + serviceProfile.isEnabled + "\n",
                "ServiceProfile",
                MessageBoxButton.OKCancel,
                MessageBoxImage.Question);

            if (messageBoxResult != MessageBoxResult.OK) {
                return;
            }


            List<SocketProfile> serviceProfiles = Storage.getInstance().getSocketProfiles();


            foreach (SocketProfile sp in serviceProfiles) {
                if (sp.id == serviceProfile.id) {
                    serviceProfiles.Remove(sp);
                    break;
                }
            }

            Storage.getInstance().setServiceProfiles(serviceProfiles);

            reloadSocketProfiles();
        }
        #endregion

        private void reloadSocketProfiles () {
            _application.socketProfiles = Storage.getInstance().getSocketProfiles();
            _application.databaseProfile = Storage.getInstance().getDatabaseProfile();

            listViewSocketProfile.ItemsSource = _application.socketProfiles;
            listViewSocketManager.ItemsSource = _application.socketManagers;

            listViewSocketProfile.Items.Refresh();
            listViewSocketManager.Items.Refresh();

        }
        private void Window_Initialized (object sender, EventArgs e) {
            try {
                _application = Application.getInstance();
                this.DataContext = _application;
                reloadSocketProfiles();
            } catch (Exception exception) {
                Debug.Write(exception.Message);
            }
        }

        private void Window_Closing (object sender, System.ComponentModel.CancelEventArgs e) {
            Storage.getInstance().setServiceProfiles(_application.socketProfiles);
            Storage.getInstance().setDatabaseProfile(_application.databaseProfile);

        }

        private void toggleButtonServer_Click (object sender, RoutedEventArgs e) {
            if (toggleButtonServer.IsChecked == true) {
                foreach (SocketProfile sp in listViewSocketProfile.Items) {
                    if (sp.isEnabled) {
                        if (sp.company.name == Company.ATS) {
                            _application.socketManagers.Add(new AtsSocketManager(sp));
                        }
                        if (sp.company.name == Company.MEITRACK) {
                            _application.socketManagers.Add(new MeitrackSocketManager(sp));
                        }
                        if (sp.company.name == Company.TELTONIKA) {
                            _application.socketManagers.Add(new TeltonikaSocketManager(sp));
                        }
                    }
                }
                foreach (SocketManager sm in _application.socketManagers) {
                    sm.start();
                }

                _application.socketStartTime = DateTime.Now;
                reloadSocketProfiles();

            } else {
                foreach (SocketManager sm in _application.socketManagers) {
                    sm.stop();
                }
                _application.socketManagers.Clear();
                reloadSocketProfiles();
            }
        }

        private void toggleButtonDatabase_Click (object sender, RoutedEventArgs e) {
            if (toggleButtonDatabase.IsChecked == true) {
                _application.database = new Database(_application.databaseProfile);
                _application.database.start(_application.socketManagers);

                _application.databaseStartTime = DateTime.Now;
            } else {
                _application.database.stop();
            }
        }

        private void buttonTestMysql_Click (object sender, RoutedEventArgs e) {


            _application.database = new Database(_application.databaseProfile);
            Task task = new Task(() => {
                Dispatcher.BeginInvoke(DispatcherPriority.Background, new Action(() => {
                    buttonTestMysql.IsEnabled = false;
                }));

                if (_application.database.testMySql()) {
                    MessageBox.Show("Successful!", "Mysql");
                } else {
                    MessageBox.Show("Failed!", "Mysql");
                }
                Dispatcher.BeginInvoke(DispatcherPriority.Background, new Action(() => {
                    buttonTestMysql.IsEnabled = true;
                }));
            });
            task.Start();
        }

        private void listViewSocketManager_MouseDoubleClick (object sender, MouseButtonEventArgs e) {
            ListView listView = (ListView)sender;

            if (listView.SelectedItem == null)
                return;

            SocketManager socketManager = (SocketManager)listView.SelectedItem;

            WindowSocketManager dialogTcpClient = new WindowSocketManager(socketManager);
            dialogTcpClient.Show();
        }
    }
}
