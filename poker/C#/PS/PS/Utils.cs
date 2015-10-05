using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Diagnostics;

namespace PS
{
    class Utils
    {

        public String getipinternet()
        {
            WebClient client = new WebClient();
            String[] ipsplit = client.DownloadString("http://icanhazip.com/").Split('\n');
            return ipsplit[0];
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
