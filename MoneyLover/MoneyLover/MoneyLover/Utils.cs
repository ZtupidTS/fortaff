using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;
using System.Windows.Forms;
using System.Text.RegularExpressions;

namespace MoneyLover
{
    class Utils
    {
        /// <summary>
        /// copy file source to folder software
        /// </summary>
        /// <param name="path"></param>
        public void copyFile(String path)
        {
            String pathfinal = Directory.GetCurrentDirectory();
            if (File.Exists(pathfinal + "\\DB\\ML.sqlite"))
            {
                File.Delete(pathfinal + "\\DB\\ML.sqlite");
            }
            
            String fileName = System.IO.Path.GetFileName(path);
            String destFile = System.IO.Path.Combine(pathfinal + "\\DB", fileName);
            System.IO.File.Copy(path, destFile, true);
            File.Move(@destFile, pathfinal + "\\DB\\ML.sqlite");
            File.Delete(@destFile);
        }

        /// <summary>
        /// é para saber se já existe uma DB do money lover na pasta.
        /// </summary>
        /// <returns></returns>
        public Boolean dbExists()
        {
            String pathfinal = Directory.GetCurrentDirectory();
            if (File.Exists(pathfinal + "\\DB\\ML.sqlite"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public void alertMessage(String message)
        {
            MessageBox.Show(message);
        }

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

        public String monthIntToString(String month)
        {
            switch (month)
            {
                case "01":
                    return "Janeiro";
                case "02":
                    return "Fevereiro";
                case "03":
                    return "Março";
                case "04":
                    return "Abril";
                case "05":
                    return "Maio";
                case "06":
                    return "Junho";
                case "07":
                    return "Julho";
                case "08":
                    return "Agosto";
                case "09":
                    return "Setembro";
                case "10":
                    return "Outubro";
                case "11":
                    return "Novembro";
                case "12":
                    return "Dezembro";
                default:
                    return "";
            }
        }

        public String monthStringToInt(String month)
        {
            switch (month)
            {
                case "Janeiro":
                    return "01";
                case "Fevereiro":
                    return "02";
                case "Março":
                    return "03";
                case "Abril":
                    return "04";
                case "Maio":
                    return "05";
                case "Junho":
                    return "06";
                case "Julho":
                    return "07";
                case "Agosto":
                    return "08";
                case "Setembro":
                    return "09";
                case "Outubro":
                    return "10";
                case "Novembro":
                    return "11";
                case "Dezembro":
                    return "12";
                default:
                    return "";
            }
        }

    }
}
