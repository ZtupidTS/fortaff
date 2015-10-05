using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Diagnostics;
using System.IO;
using System.Net;
using TiltStopLoss;

namespace StopLoss
{
    public partial class FormDownloadUpdate : Form
    {
        WebClient webClient;
        Stopwatch sw = new Stopwatch();
        Main fmain;
        Uri url;
        String nv;
        Double ov;
        String foldername;
        
        public FormDownloadUpdate(Main wmain, Uri url, Double nv, Double ov)
        {
            InitializeComponent();
            fmain = wmain;
            this.url = url;
            if (nv.ToString().Length > 3)
            {
                this.nv = nv.ToString().Replace(',', '.');
            }
            else
            {
                this.nv = nv.ToString().Replace(',', '.') + "0";
            }
            
            this.ov = ov;
            labelDownloaded.Text = "-- MB's / -- MB's";
            labelSpeed.Text = "-- kb/s";
            labelPerc.Text = "-- %";
        }

        //public void DownloadFile(string urlAddress, string location)
        public void DownloadFile()
        {
            webClient = new WebClient();
            webClient.DownloadProgressChanged += new DownloadProgressChangedEventHandler(ProgressChanged);
            webClient.DownloadFileCompleted += new AsyncCompletedEventHandler(Completed);

            // Start the stopwatch which we will be using to calculate the download speed
            sw.Start();

            try
            {
                // Starts the download
                webClient.DownloadFileAsync(url, foldername + "\\Poker BRM v"+nv+".exe");
                buttonSaveFile.Enabled = false;
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }

        // The event that will fire whenever the progress of the WebClient is changed
        private void ProgressChanged(object sender, DownloadProgressChangedEventArgs e)
        {
            // Calculate download speed and output it to labelSpeed.
            labelSpeed.Text = string.Format("{0} kb/s", (e.BytesReceived / 1024d / sw.Elapsed.TotalSeconds).ToString("0.00"));

            // Update the progressbar percentage only when the value is not the same.
            progressBar.Value = e.ProgressPercentage;

            // Show the percentage on our label.
            labelPerc.Text = e.ProgressPercentage.ToString() + "%";

            // Update the label with how much data have been downloaded so far and the total size of the file we are currently downloading
            labelDownloaded.Text = string.Format("{0} MB's / {1} MB's",
                (e.BytesReceived / 1024d / 1024d).ToString("0.00"),
                (e.TotalBytesToReceive / 1024d / 1024d).ToString("0.00"));
        }

        // The event that will trigger when the WebClient is completed
        private void Completed(object sender, AsyncCompletedEventArgs e)
        {
            // Reset the stopwatch.
            sw.Reset();
            try
            {
                System.Diagnostics.Process.Start(foldername + "\\Poker BRM v" + nv + ".exe");
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
            //fechar tudo aqui
            fmain.ShowInTaskbar = true;
            fmain.WindowState = FormWindowState.Normal;
            fmain.Close();
            //this.Close();
        }

        private void buttonSaveFile_Click(object sender, EventArgs e)
        {
            //this.folderBrowserDialog.RootFolder = System.Environment.SpecialFolder.MyComputer;
            DialogResult result = this.folderBrowserDialog.ShowDialog();
            if (result == DialogResult.OK)
            {
                // the code here will be executed if the user presses Open in
                // the dialog.
                foldername = this.folderBrowserDialog.SelectedPath;
                DownloadFile();
            }
        }

        private void FormDownloadUpdate_FormClosed(object sender, FormClosedEventArgs e)
        {
            fmain.ShowInTaskbar = true;
            fmain.WindowState = FormWindowState.Normal;
            fmain.Close();
            //this.Close();
        }
    }
}
