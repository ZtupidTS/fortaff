using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Diagnostics;
using System.Text.RegularExpressions;
using System.IO;

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
            var request = (HttpWebRequest)WebRequest.Create("http://bot.whatismyipaddress.com");

            request.UserAgent = "curl"; // this simulate curl linux command

            string publicIPAddress;

            request.Method = "GET";
            using (WebResponse response = request.GetResponse())
            {
                using (var reader = new StreamReader(response.GetResponseStream()))
                {
                    publicIPAddress = reader.ReadToEnd();
                }
            }

            return publicIPAddress.Replace("\n", "");
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
