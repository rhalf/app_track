/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for the form windowServiceManager.
*/
using GaiaWatcher;
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
using System.Windows.Shapes;

namespace GaiaWatcherSocket.Forms {
    /// <summary>
    /// Interaction logic for WindowServiceManager.xaml
    /// </summary>
    public partial class WindowSocketManager : Window {
        public WindowSocketManager (SocketManager socketManager) {
            InitializeComponent();

            List<Client> clients = socketManager.clients.Values.ToList<Client>();

            listViewServiceManager.ItemsSource = clients;
            listViewServiceManager.Items.Refresh();
        }
    }
}
