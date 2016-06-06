using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace PS
{
    class AppendToFile
    {
        public int ndt = 0;
        public int fdt = 0;

        public void AppendToFileDT(String handcopy, String date, Boolean down, Boolean zoom, String vm, String drive)
        {
            String nl = getNL(handcopy);
            String path = "";
            String txtzoom = "";
            if (zoom)
            {
                txtzoom = "zoom";
            }
            if (down)
            {
                path = drive + ":/HH" + fdt + "_" + date + "_NL" + nl + "_up_" + txtzoom + "_"+vm+".txt";
            }
            else
            {
                path = drive + ":/HH" + fdt + "_" + date + "_NL" + nl + "_down_" + txtzoom + "_" + vm + ".txt";
            }
            
            //File file = new File("E:/HH" + fdt + "_" + date + ".txt");
            ndt = ndt + 1;

            //true = append file
            StreamWriter w = new StreamWriter(path, true);
            w.Write(handcopy);
            w.WriteLine();
            w.WriteLine();
            w.Close();
            
            if (ndt == 500)
            {
                fdt = fdt + 1;
                ndt = 0;
            }
        }

        public String getNL(String hand)
        {
            //only nl200
            String[] temp = hand.Split('(');
            String[] temp2 = temp[1].ToString().Split(')');

            if (hand.Contains("0.01/") && hand.Contains("0.02"))
            {
                return "2";
            }
            if (hand.Contains("0.02/") && hand.Contains("0.05"))
            {
                return "5";
            }
            if (hand.Contains("0.05/") && hand.Contains("0.10"))
            {
                return "10";
            }
            if (hand.Contains("0.08/") && hand.Contains("0.16"))
            {
                return "16";
            }
            if (temp2[0].Contains("0.10/") && temp2[0].Contains("0.20"))
            {
                return "20";
            }
            if (hand.Contains("0.10/") && hand.Contains("0.25"))
            {
                return "25";
            }
            if (hand.Contains("0.15/") && hand.Contains("0.30"))
            {
                return "30";
            }
            if (hand.Contains("0.25/") && hand.Contains("0.50"))
            {
                return "50";
            }
            if (hand.Contains("0.50/") && hand.Contains("1.00"))
            {
                return "100";
            }
            if (temp2[0].Contains("1/") && temp2[0].Contains("2") && !temp2[0].Contains("."))
            {
                return "200";
            }
            if (temp2[0].Contains("2/") && temp2[0].Contains("4") && !temp2[0].Contains("."))
            {
                return "400";
            }
            if (hand.Contains("2.50/") && hand.Contains("5.00"))
            {
                return "500";
            }
            return "_";
        }

    }
}
