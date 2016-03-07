using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.IO;

namespace CleanHH
{
    class Utils
    {
        /// <summary>
        /// String to int64
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public Int64 stringtoInt64(String value)
        {
            if (value.Equals(""))
            {
                return 0;
            }
            else
            {
                return Convert.ToInt64(value);
            }
        }

        /// <summary>
        /// String to double
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public Double stringtoDouble(String value)
        {
            int alphaCounter = Regex.Matches(value, @"[a-zA-Z]").Count;
            if (value.Equals("") || alphaCounter > 0)
            {
                //new Debug().LogMessage("Valeur de string to double:" + value);
                return 0.0;
            }
            else
            {
                return Convert.ToDouble(value);
            }
        }

        /// <summary>
        /// String to int32
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public Int32 stringtoInt32(String value)
        {
            if (value.Equals(""))
            {
                return 0;
            }
            else
            {
                return Convert.ToInt32(value);
            }
        }

        /// <summary>
        /// Para eliminar os ficheiro de erros com mais de 3 dias
        /// </summary>
        public void deletefileerrors()
        {
            String pathfinal = Directory.GetCurrentDirectory();
            string[] files = Directory.GetFiles(pathfinal + "\\error");

            foreach (string file in files)
            {
                FileInfo fi = new FileInfo(file);
                if (fi.LastWriteTime < DateTime.Now.AddDays(-3))
                    fi.Delete();
            }
        }

        /// <summary>
        /// get limit hands network hive
        /// </summary>
        /// <param name="hand"></param>
        /// <returns></returns>
        public String getNlHive(String hand)
        {
            //only nl200
            String[] temp = hand.Split('(');
            String[] temp2 = temp[1].ToString().Split(')');

            if (hand.Contains("0.01/") && hand.Contains("0.02"))
            {
                return " - Blinds 0.01EUR/0.02EUR - No Limit Hold'em";
            }
            if (hand.Contains("0.02/") && hand.Contains("0.05"))
            {
                return " - Blinds 0.02EUR/0.05EUR - No Limit Hold'em";
            }
            if (hand.Contains("0.05/") && hand.Contains("0.10"))
            {
                return " - Blinds 0.05EUR/0.10EUR - No Limit Hold'em";
            }
            if (hand.Contains("0.08/") && hand.Contains("0.16"))
            {
                return " - Blinds 0.08EUR/0.16EUR - No Limit Hold'em";
            }
            if (temp2[0].Contains("0.10/") && temp2[0].Contains("0.20"))
            {
                return " - Blinds 0.10EUR/0.20EUR - No Limit Hold'em";
            }
            if (hand.Contains("0.10/") && hand.Contains("0.25"))
            {
                return " - Blinds 0.10EUR/0.25EUR - No Limit Hold'em";
            }
            if (hand.Contains("0.15/") && hand.Contains("0.30"))
            {
                return " - Blinds 0.15EUR/0.30EUR - No Limit Hold'em";
            }
            if (hand.Contains("0.25/") && hand.Contains("0.50"))
            {
                return " - Blinds 0.25EUR/0.50EUR - No Limit Hold'em";
            }
            if (hand.Contains("0.50/") && hand.Contains("1.00"))
            {
                return " - Blinds 0.50EUR/1.00EUR - No Limit Hold'em";
            }
            if (temp2[0].Contains("1/") && temp2[0].Contains("2") && !temp2[0].Contains("."))
            {
                return " - Blinds 1.00EUR/2.00EUR - No Limit Hold'em";
            }
            if (temp2[0].Contains("2/") && temp2[0].Contains("4") && !temp2[0].Contains("."))
            {
                return " - Blinds 2.00EUR/4.00EUR - No Limit Hold'em";
            }
            if (hand.Contains("2.50/") && hand.Contains("5.00"))
            {
                return " - Blinds 2.50EUR/5.00EUR - No Limit Hold'em";
            }
            return "_";
        }

        /// <summary>
        /// get old number hand hive
        /// </summary>
        /// <param name="s"></param>
        /// <returns></returns>
        public Int64 getOldNumberHandsHive(string s)
        {
            int l = s.IndexOf(":");
            if (l > 0)
            {
                return stringtoInt64(s.Substring(0, l));
            }
            return 0;
        }

        /// <summary>
        /// get name table hive
        /// </summary>
        /// <param name="table"></param>
        /// <returns></returns>
        public String getNameTableHive(String table)
        {
            int l = table.IndexOf("Table '");
            // length de "table '"
            int length = 7;
            int k = table.Substring(l + length, 30).IndexOf("'");
            return table.Substring(l + length, k);
        }
        
    }
}
