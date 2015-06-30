using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net.Mail;
using System.IO;

namespace checkinfosaft
{
    class Program
    {
        public static Int64 port;
        public static string ipaddressserver;
        public static Boolean ssl;
        public static String login;
        public static String password;
        public static String sender;
        public static String receipt;
                
        static void Main(string[] args)
        {
            String folder = "C:\\ProgramData\\InfoSAFT\\FTP\\BACKUP";            
            //String folder = "C:";
            string[] filePaths = Directory.GetFiles(@"" + folder, "*.txt");

            //aqui vou carregar as configurações do mail
            loadConfig();

            Boolean faultfile = false;
            int daytoday = DateTime.Now.DayOfYear;
            //vou percorrer os ficheiros
            foreach (String fi in filePaths)
            {
                //System.IO.File.GetLastWriteTime
                Console.WriteLine(fi.ToString());
                int lastmodified = File.GetLastWriteTime(fi).DayOfYear;
                if (daytoday == lastmodified)
                {
                    faultfile = true;
                }
                if (faultfile) break;
            }


            if (!faultfile)
            {
                sendmail();
            }
        }


        private static void sendmail()
        {
            SmtpClient client = new SmtpClient();
            client.Port = (int)port;
            client.Host = ipaddressserver;
            client.EnableSsl = ssl;
            client.Timeout = 10000;
            client.DeliveryMethod = SmtpDeliveryMethod.Network;
            client.UseDefaultCredentials = true;
            client.Credentials = new System.Net.NetworkCredential(login, password);

            MailMessage mm = new MailMessage(sender, receipt, "Problema infosaft", "Falta ficheiros do dia de ontem");
            mm.BodyEncoding = UTF8Encoding.UTF8;
            mm.DeliveryNotificationOptions = DeliveryNotificationOptions.OnFailure;

            client.Send(mm);
        }

        private static void loadConfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config.txt";
            string line;
            // Read the file and display it line by line.
            if (File.Exists(filepath))
            {
                System.IO.StreamReader file = new System.IO.StreamReader(filepath);
                while ((line = file.ReadLine()) != null)
                {
                    String[] array = line.Split('=');
                    configframe(array);
                }
                file.Close();
            }
        }

        private static void configframe(String[] line)
        {
            switch (line[0])
            {
                case "port":
                    port = Convert.ToInt64(line[1].ToString());
                    break;
                case "ipaddressserver":
                    ipaddressserver = line[1].ToString();
                    break;
                case "ssl":
                    if (line[1].ToString().ToLower().Equals("true"))
                    {
                        ssl = true;
                    }
                    else
                    {
                        ssl = false;
                    }
                    break;
                case "login":
                    login = line[1].ToString();
                    break;
                case "password":
                    password = line[1].ToString();
                    break;
                case "sender":
                    sender = line[1].ToString();
                    break;
                case "receipt":
                    receipt = line[1].ToString();
                    break;
                default:
                    break;
            }
        }
    }
}
