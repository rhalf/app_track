/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for the form windowService.
*/
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

using GaiaWatcher;
using System.Net;
using Newtonsoft.Json;
using GaiaWatcherSocket.Classes;
using GaiaWatcher.Classes;

namespace GaiaWatcherSocket {
    /// <summary>
    /// Interaction logic for WindowService.xaml
    /// </summary>
    public partial class WindowServiceProfile : Window {

        bool toBeEditted;

        SocketProfile serviceProfile = null;

        //Edit existing serviceProfile
        public WindowServiceProfile (SocketProfile serviceProfile) {
            InitializeComponent();

            comboBoxCompanies.ItemsSource = GaiaWatcher.GaiaWatcher.getInstance().getCompanies();
            comboBoxIp.ItemsSource = Machine.getInstance().publicIps;

            this.serviceProfile = serviceProfile;

            foreach (Company company in comboBoxCompanies.Items) {
                if (company.name == this.serviceProfile.company.name) {
                    comboBoxCompanies.SelectedItem = company;
                    break;
                }
            }

            comboBoxServices.ItemsSource = this.serviceProfile.company.sockets;

            foreach (string service in comboBoxServices.Items) {
                if (service == this.serviceProfile.socket) {
                    comboBoxServices.SelectedItem = service;
                    break;
                }
            }

            comboBoxIp.SelectedItem = this.serviceProfile.ip;
            textBoxPort.Text = this.serviceProfile.port.ToString();
            checkBoxIsEnabled.IsChecked = this.serviceProfile.isEnabled;
            textBoxTask.Text = this.serviceProfile.task.ToString();
            toBeEditted = true;
        }

        //Add new serviceProfile
        public WindowServiceProfile () {
            InitializeComponent();

            comboBoxCompanies.ItemsSource = GaiaWatcher.GaiaWatcher.getInstance().getCompanies();
            comboBoxIp.ItemsSource = Machine.getInstance().publicIps;

            this.serviceProfile = new SocketProfile();

            //comboBoxIp.SelectedItem = this.serviceProfile.ip;
            textBoxPort.Text = "50010";
            checkBoxIsEnabled.IsChecked = true;
            textBoxTask.Text = "3";
            toBeEditted = true;

            toBeEditted = false;
        }


        private void comboBoxCompanies_SelectionChanged (object sender, SelectionChangedEventArgs e) {
            ComboBox comboBox = (ComboBox)sender;
            Company company = (Company) comboBox.SelectedItem;
            comboBoxServices.ItemsSource = company.sockets;

        }

        private void buttonSave_Click (object sender, RoutedEventArgs e) {
            try {

                if (toBeEditted) {
                    this.serviceProfile.company = (Company)comboBoxCompanies.SelectedItem;
                    this.serviceProfile.socket = (String)comboBoxServices.SelectedItem;
                    this.serviceProfile.ip = comboBoxIp.SelectedItem.ToString();
                    this.serviceProfile.port = int.Parse(textBoxPort.Text);
                    this.serviceProfile.isEnabled = (bool)checkBoxIsEnabled.IsChecked;
                    this.serviceProfile.task = int.Parse(textBoxTask.Text);

                    List<SocketProfile> serviceProfiles = Storage.getInstance().getSocketProfiles();

                    for (int index = 0; index < serviceProfiles.Count; index++) {
                        if (serviceProfiles[index].id == this.serviceProfile.id) {
                            serviceProfiles[index] = this.serviceProfile;
                        }
                    }
                    Storage.getInstance().setServiceProfiles(serviceProfiles);
                } else {
                    this.serviceProfile.id = Helper.genNewUniqueId();
                    this.serviceProfile.company = (Company)comboBoxCompanies.SelectedItem;
                    this.serviceProfile.socket = (String)comboBoxServices.SelectedItem;
                    this.serviceProfile.ip = comboBoxIp.SelectedItem.ToString();
                    this.serviceProfile.port = Int32.Parse(textBoxPort.Text);
                    this.serviceProfile.isEnabled = (bool)checkBoxIsEnabled.IsChecked;
                    this.serviceProfile.task = int.Parse(textBoxTask.Text);

                    List<SocketProfile> serviceProfiles = Storage.getInstance().getSocketProfiles();
                    serviceProfiles.Add(serviceProfile);

                    Storage.getInstance().setServiceProfiles(serviceProfiles);
                }

                this.Close();
            } catch (Exception exception) {
                MessageBox.Show(exception.Message, "Error");
            }
        }
    }
}
