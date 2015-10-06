using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Diagnostics;
using System.Text.RegularExpressions;

namespace PS
{
    class Utils
    {

        public String getipinternetMeu()
        {
            WebClient client = new WebClient();
            String[] ipsplit = client.DownloadString("http://icanhazip.com/").Split('\n');
            return ipsplit[0];
        }

        public String getipinternet2()
        {
            try
            {
                string externalIP;
                externalIP = (new WebClient()).DownloadString("http://checkip.dyndns.org/");
                externalIP = (new Regex(@"\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}"))
                             .Matches(externalIP)[0].ToString();
                return externalIP;
            }
            catch { return null; }
        }

        public String getipinternet3(WebClient wc)
        {
            string externalIP;
            externalIP = wc.DownloadString("http://checkip.dyndns.org/");
            externalIP = (new Regex(@"\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}"))
                             .Matches(externalIP)[0].ToString();
            return externalIP;            
        }

        /// <summary>
        /// close skype
        /// </summary>
        public void detectApps(String nameprocess)
        {
            // Is running
            try
            {
                foreach (Process proc in Process.GetProcessesByName(nameprocess))
                {
                    proc.Kill();
                }
            }
            catch (Exception ex)
            {
                //MessageBox.Show(ex.Message);
                new Debug().LogMessage(ex.ToString());
            }
        }
    }
}
