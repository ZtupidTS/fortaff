using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Security.Cryptography;
using System.IO;
using System.Configuration;
using System.Runtime.InteropServices;
using System.Threading;
using System.Windows.Forms;
using System.Globalization;
using System.Diagnostics;
using System.Text.RegularExpressions;

namespace TiltStopLoss
{
    class Utils
    {
        /// <summary>
        /// Devolve o ano e mês que serve para o pedido a DB sobre os BBs
        /// </summary>
        /// <returns></returns>
        public String yearmonth()
        {
            return DateTime.Now.ToString("yyyyMM");
        }

        /// <summary>
        /// Devolve o ano e semana que serve para o pedido a DB sobre os BBs
        /// </summary>
        /// <returns></returns>
        public String yearweek()
        {
            DateTime date = DateTime.Now;
            // Seriously cheat.  If its Monday, Tuesday or Wednesday, then it'll 
            // be the same week# as whatever Thursday, Friday or Saturday are,
            // and we always get those right
            DayOfWeek day = CultureInfo.InvariantCulture.Calendar.GetDayOfWeek(date);
            if (day >= DayOfWeek.Monday && day <= DayOfWeek.Wednesday)
            {
                date = date.AddDays(3);
            }
            // Return the week of our adjusted day
            int week = CultureInfo.InvariantCulture.Calendar.GetWeekOfYear(date, CalendarWeekRule.FirstFourDayWeek, DayOfWeek.Monday);
            String weekfin = "";
            if (week < 10)
            {
                weekfin = "0" + week.ToString();
            }
            else
            {
                weekfin = week.ToString();
            }
            return DateTime.Now.ToString("yyyy") + weekfin;
        }

        /// <summary>
        /// Toca a musica chata do stop
        /// </summary>
        public WMPLib.WindowsMediaPlayer playsound(String sound, Boolean loop)
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "\\sounds\\" +sound;
            //mp3  & wav
            WMPLib.WindowsMediaPlayer player = new WMPLib.WindowsMediaPlayer();

            player.URL = filepath;
            if (loop)
            {
                player.settings.setMode("loop", true);
            }
            player.controls.play();            
            //old only wav
            //System.Media.SoundPlayer player = new System.Media.SoundPlayer(filepath);
            //player.PlayLooping();            
            return player;
        }

        /// <summary>
        /// Serve para as textbox
        /// Só permite inserir numeros
        /// </summary>
        /// <param name="e"></param>
        public void onlynumeric(KeyPressEventArgs e)
        {
            if (!char.IsControl(e.KeyChar)
                    && !char.IsDigit(e.KeyChar)
                    && e.KeyChar != (char)Keys.Decimal && e.KeyChar != (char)Keys.N)
            {
                e.Handled = true;
            }
            // only allow one decimal point
            //if (e.KeyChar == '.'
            //    && (sender as TextBox).Text.IndexOf('.') > -1)
            //{
            //    e.Handled = true;
            //}
        }

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
        /// String to double
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public float StringTofloat(String value)
        {
            int alphaCounter = Regex.Matches(value, @"[a-zA-Z]").Count;
            if (value.Equals("") || alphaCounter > 0)
            {
                //new Debug().LogMessage("Valeur de string to double:" + value);
                return 0.0f;
            }
            else
            {
                return float.Parse(value, CultureInfo.InvariantCulture.NumberFormat);
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
        /// copy file source to folder software
        /// </summary>
        /// <param name="path"></param>
        public void copyFile(String path)
        {
            String pathfinal = Directory.GetCurrentDirectory();
            String fileName = System.IO.Path.GetFileName(path);
            String destFile = System.IO.Path.Combine(pathfinal+"\\sounds", fileName);
            System.IO.File.Copy(path, destFile, true);
        }

        /// <summary>
        /// delete sound from original path because exist in new path
        /// </summary>
        public void deleteSound()
        {
            String pathfinal = Directory.GetCurrentDirectory();
            String filepath = pathfinal + "\\alarm.wav";
            if (File.Exists(@filepath))
            {
                File.Delete(@filepath);
            }
        }

        /// <summary>
        /// change name file config
        /// </summary>
        public void changeFileConfig()
        {
            String pathfinal = Directory.GetCurrentDirectory();
            String filepath = pathfinal + "\\config.txt";
            if (File.Exists(@filepath))
            {
                File.Move(@filepath, pathfinal+"\\config_main.txt");
                File.Delete(@filepath);
            }
            filepath = pathfinal + "\\config2.txt";
            if (File.Exists(@filepath))
            {
                File.Move(@filepath, pathfinal + "\\config_stoploss.txt");
                File.Delete(@filepath);
            }
            filepath = pathfinal + "\\config3.txt";
            if (File.Exists(@filepath))
            {
                File.Move(@filepath, pathfinal + "\\config_setnewvalue.txt");
                File.Delete(@filepath);
            }
            String pathfinal2 = pathfinal + "\\config";
            filepath = pathfinal + "\\config_main.txt";
            if (File.Exists(@filepath))
            {
                File.Move(@filepath, pathfinal2 + "\\config_main.txt");
                File.Delete(@filepath);
            }
            filepath = pathfinal + "\\config_stoploss.txt";
            if (File.Exists(@filepath))
            {
                File.Move(@filepath, pathfinal2 + "\\config_stoploss.txt");
                File.Delete(@filepath);
            }
            filepath = pathfinal + "\\config_setnewvalue.txt";
            if (File.Exists(@filepath))
            {
                File.Move(@filepath, pathfinal2 + "\\config_setnewvalue.txt");
                File.Delete(@filepath);
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

        /// <summary>
        /// metodo para verifyapp
        /// </summary>
        /// <param name="nameprocess"></param>
        /// <returns></returns>
        public Boolean detectApp(String nameprocess)
        {
            // Is running
            try
            {
                foreach (Process proc in Process.GetProcessesByName(nameprocess))
                {
                    return true;
                }
                return false;
            }
            catch (Exception ex)
            {
                //MessageBox.Show(ex.Message);
                new Debug().LogMessage(ex.ToString() + "_detecApp");
                return false;
            }
        }

        /// <summary>
        /// string to minute
        /// </summary>
        /// <param name="time"></param>
        /// <returns></returns>
        public Int32 stringTimeToMinute(String time)
        {
            if (String.IsNullOrEmpty(time))
            {
                return 0;
            }
            else
            {
                String[] timer = time.Split(':');
                return (Convert.ToInt32(timer[0]) * 60 + Convert.ToInt32(timer[1]));
            }
        }

        /// <summary>
        /// int to string 
        /// </summary>
        /// <param name="time"></param>
        /// <returns></returns>
        public String intToStringTimer(Int32 time)
        {
            if (time < 60)
            {
                if (time >= 10)
                {
                    return "00:" + time + ":00";
                }
                else
                {
                    return "00:0" + time + ":00";
                }
            }
            else
            {
                Int32 hours = 0;
                while (time >= 60)
                {
                    hours++;
                    time = time - 60;
                }
                if (hours >= 10)
                {
                    if (time >= 10)
                    {
                        return hours+":" + time + ":00";
                    }
                    else
                    {
                        return hours+":0" + time + ":00";
                    }                    
                }
                else
                {
                    if (time >= 10)
                    {
                        return "0"+hours + ":" + time + ":00";
                    }
                    else
                    {
                        return "0"+hours + ":0" + time + ":00";
                    }
                }
            }
        }

        /// <summary>
        /// get limit of hand PS
        /// </summary>
        /// <param name="hand"></param>
        /// <returns></returns>
        public Int16 getNlPs(String hand)
        {
            //only nl200
            String[] temp = hand.Split('(');
            String[] temp2 = temp[1].ToString().Split(')');
            
            if (hand.Contains("0.01/") && hand.Contains("0.02"))
            {
                return 2;
            }
            if (hand.Contains("0.02/") && hand.Contains("0.05"))
            {
                return 5;
            }
            if (hand.Contains("0.05/") && hand.Contains("0.10"))
            {
                return 10;
            }
            if (hand.Contains("0.08/") && hand.Contains("0.16"))
            {
                return 16;
            }
            if (hand.Contains("0.10/") && hand.Contains("0.20"))
            {
                return 20;
            }
            if (hand.Contains("0.10/") && hand.Contains("0.25"))
            {
                return 25;
            }
            if (hand.Contains("0.15/") && hand.Contains("0.30"))
            {
                return 30;
            }
            if (hand.Contains("0.25/") && hand.Contains("0.50"))
            {
                return 50;
            }
            if (hand.Contains("0.50/") && hand.Contains("1.00"))
            {
                return 100;
            }
            if (temp2[0].Contains("1/") && temp2[0].Contains("2") && !temp2[0].Contains("."))
            {
                return 200;
            }
            if (temp2[0].Contains("2/") && temp2[0].Contains("4") && !temp2[0].Contains("."))
            {
                return 400;
            }
            if (hand.Contains("2.50/") && hand.Contains("5.00"))
            {
                return 500;
            }
            return 0;
        }

        /// <summary>
        /// get limit for ipoker
        /// </summary>
        /// <param name="hand"></param>
        /// <returns></returns>
        public Int16 getNlIpoker(String hand)
        {
            //only nl200
            String[] temp = hand.Split(new string[] { "gametype" }, StringSplitOptions.RemoveEmptyEntries);
            
            if (temp[1].Contains("0.01/") && temp[1].Contains("0.02"))
            {
                return 2;
            }
            if (temp[1].Contains("0.02/") && temp[1].Contains("0.05"))
            {
                return 5;
            }
            if (temp[1].Contains("0.05/") && temp[1].Contains("0.10"))
            {
                return 10;
            }
            if (temp[1].Contains("0.08/") && temp[1].Contains("0.16"))
            {
                return 16;
            }
            if (temp[1].Contains("0.10/") && temp[1].Contains("0.20"))
            {
                return 20;
            }
            if (temp[1].Contains("0.10/") && temp[1].Contains("0.25"))
            {
                return 25;
            }
            if (temp[1].Contains("0.15/") && temp[1].Contains("0.30"))
            {
                return 30;
            }
            if (temp[1].Contains("0.25/") && temp[1].Contains("0.50"))
            {
                return 50;
            }
            if (temp[1].Contains("0.50/") && temp[1].Contains("1.00"))
            {
                return 100;
            }
            if (temp[1].Contains("1/") && temp[1].Contains("2"))
            {
                return 200;
            }
            if (temp[1].Contains("2/") && temp[1].Contains("4"))
            {
                return 400;
            }
            if (temp[1].Contains("2.50/") && temp[1].Contains("5.00"))
            {
                return 500;
            }
            return 0;
        }

        /// <summary>
        /// get limit for party poker and wpt
        /// </summary>
        /// <param name="hand"></param>
        /// <returns></returns>
        public Int16 getNlpp(String hand)
        {
            String[] handsplitbl = hand.Split(new string[] { "\r\n" }, StringSplitOptions.RemoveEmptyEntries);
            String[] linefinal = handsplitbl[1].Split(' ');
            String limite1 = linefinal[0].Replace("$", "");
            String limite2 = limite1.Replace("€", "");
            String limitefinal = limite2.Replace("£", "");
            switch (limitefinal)
            {
                case "0.01/0.02":
                    return 2;
                case "0.02/0.04":
                    return 4;
                case "4":
                    return 4;
                case "0.05/0.10":
                    return 10;
                case "10":
                    return 10;
                case "0.10/0.25":
                    return 25;
                case "25":
                    return 25;
                case "0.25/0.50":
                    return 50;
                case "50":
                    return 50;
                default:
                    return 0;
            }            
        }

        /// <summary>
        /// String to datetime
        /// </summary>
        /// <param name="time"></param>
        /// <returns></returns>
        public DateTime stringToDateTime(String time)
        {
            return Convert.ToDateTime(time);
        }

        /// <summary>
        /// Corriga a string devolvida pelo hem2 para os vpps
        /// </summary>
        /// <param name="rakejson"></param>
        /// <returns></returns>
        public String resolveStringHem2(String rakejson)
        {
            Boolean continu = true;
            //Regex rgx = new Regex("[^0-9]");
            Regex rgx = new Regex("^-?[0-9]/\\d*(/\\./\\d+)?$");
            String final = "";
            if (rakejson.Contains("."))
            {
                continu = false;
                String[] tempspli = rakejson.Split('.');
                final = rgx.Replace(tempspli[0], "") + "." + tempspli[1];
            }
            if (rakejson.Contains(",") && continu)
            {
                continu = false;
                String[] tempspli = rakejson.Split(',');
                final = rgx.Replace(tempspli[0], "") + "," + tempspli[1];
            }
            return final;
        }
    }
}
