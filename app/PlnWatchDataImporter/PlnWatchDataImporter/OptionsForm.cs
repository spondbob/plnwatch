﻿using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Configuration;

namespace PlnWatchDataImporter
{
    public partial class OptionsForm : Form
    {
        public OptionsForm()
        {
            InitializeComponent();
        }

        private void OptionsForm_Load(object sender, EventArgs e)
        {
            mySqlHostTextBox.Text = ConfigurationManager.AppSettings["mysqlhost"];
            mySqlUserTextBox.Text = ConfigurationManager.AppSettings["mysqluser"];
            mySqlPassTextBox.Text = ConfigurationManager.AppSettings["mysqlpass"];
            mySqlDbTextBox.Text = ConfigurationManager.AppSettings["mysqldb"];
            mySqlPathTextBox.Text = ConfigurationManager.AppSettings["mysqlpath"];
        }

        private void closeButton_Click(object sender, EventArgs e)
        {
            Configuration config = ConfigurationManager.OpenExeConfiguration(ConfigurationUserLevel.None);
            config.AppSettings.Settings.Remove("mysqlhost");
            config.AppSettings.Settings.Add("mysqlhost", mySqlHostTextBox.Text);
            config.AppSettings.Settings.Remove("mysqluser");
            config.AppSettings.Settings.Add("mysqluser", mySqlUserTextBox.Text);
            config.AppSettings.Settings.Remove("mysqlpass");
            config.AppSettings.Settings.Add("mysqlpass", mySqlPassTextBox.Text);
            config.AppSettings.Settings.Remove("mysqldb");
            config.AppSettings.Settings.Add("mysqldb", mySqlDbTextBox.Text);
            config.AppSettings.Settings.Remove("mysqlpath");
            config.AppSettings.Settings.Add("mysqlpath", mySqlPathTextBox.Text);
            config.Save(ConfigurationSaveMode.Modified);
            ConfigurationManager.RefreshSection("appSettings");
            Close();
        }

        private void OptionsForm_VisibleChanged(object sender, EventArgs e)
        {
            if (Visible)
            {
                mySqlHostTextBox.Text = ConfigurationManager.AppSettings["mysqlhost"];
                mySqlUserTextBox.Text = ConfigurationManager.AppSettings["mysqluser"];
                mySqlPassTextBox.Text = ConfigurationManager.AppSettings["mysqlpass"];
                mySqlDbTextBox.Text = ConfigurationManager.AppSettings["mysqldb"];
                mySqlPathTextBox.Text = ConfigurationManager.AppSettings["mysqlpath"];
            }
        }

        private void mySqlPathBrowseButton_Click(object sender, EventArgs e)
        {
            openFileDialog.FileName = mySqlPathTextBox.Text;
            if (openFileDialog.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                mySqlPathTextBox.Text = openFileDialog.FileName;
        }
    }
}