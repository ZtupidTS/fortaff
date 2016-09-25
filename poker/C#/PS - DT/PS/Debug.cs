using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace PS
{
    class Debug
    {

        public String getFileName()
        {
            return "E:/!!ERROR!!_DT_" + DateTime.Now.ToString("yyyy_M_d_HH_MM") + ".txt";
        }

        public void LogMessage(String message)
        {
            StreamWriter w = new StreamWriter(getFileName(), true);
            w.Write(message);
            w.WriteLine();
            w.Close();
        }

        public void ErrorVpn(String message)
        {
            String path = "E:/!!VPN!!_DT_" + DateTime.Now.ToString("yyyy_M_d_HH_MM") + ".txt";
            StreamWriter w = new StreamWriter(path, true);
            w.Write(message);
            w.WriteLine();
            w.Close();
        }

    }
}
