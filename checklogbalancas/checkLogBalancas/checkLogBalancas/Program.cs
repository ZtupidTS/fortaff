using System;
using System.Collections.Generic;
//using System.Linq;
using System.Text;
using System.IO;
using System.Net.Mail;

namespace checkLogBalancas
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
        public static int deletemonth;
        public static String folder = "";
        public static DateTime lastrun = DateTime.Now;
        
        static void Main(string[] args)
        {
            //aqui vou carregar as configurações do mail
            loadConfig();

            if (folder.Length > 0 && Directory.Exists(folder))
            {

                //ficheiro com nome diferente que apareceu me
                //import_total_plu

                //pegar só nos ficheiros superior a data de arranque desse script
                //startdate = DateTime.Now;
                //startdate = new DateTime(2015, 03, 10);
                


                string[] filePaths = Directory.GetFiles(@"" + folder, "*.log");

                //vou percorrer os ficheiros
                String mailtext = "";
                
                foreach (String fi in filePaths)
                {
                    if (File.GetLastWriteTime(fi).Date > lastrun)
                    {
                        //vou ler o ficheiro
                        String filetostring = File.ReadAllText(fi, Encoding.Default);

                        if (filetostring.Contains("ocorreu o seguinte erro"))
                        {
                            if (mailtext.Length > 0)
                            {
                                mailtext += "\r\n";
                            }

                            mailtext += File.GetLastWriteTime(fi).Day.ToString() + "/" + File.GetLastWriteTime(fi).Month.ToString() + "/" + File.GetLastWriteTime(fi).Year.ToString();
                            mailtext += " " + File.GetLastWriteTime(fi).TimeOfDay.ToString() + ":\r\n";
                            //como tem erros vou copiar só essa linhas.
                            string[] myFileLines = File.ReadAllLines(fi, Encoding.Default);
                            foreach (String line in myFileLines)
                            {
                                if (line.Contains("ocorreu o seguinte erro"))
                                {
                                    mailtext += line + "\r\n";
                                }
                            }

                        }
                    }
                }

                if (mailtext.Length > 0)
                {
                    sendmail(mailtext);
                }
                else
                {
                    try
                    {
                        String path = Directory.GetCurrentDirectory();
                        StreamWriter w = File.AppendText(path + "/logs/error_" + DateTime.Now.Year.ToString() + "_" + DateTime.Now.Month.ToString() + "_" + DateTime.Now.Day.ToString() + "_noerror.txt");
                        w.Write(DateTime.Now.ToString() + "_ não ouve erros no envio\r\n\r\n");
                        w.WriteLine();
                        w.Close();
                    }
                    catch (IOException ex)
                    {

                    }
                }

                //Agora vou apagar os ficheiro antigos de  X meses
                foreach (string file in filePaths)
                {
                    FileInfo fi = new FileInfo(file);
                    if (fi.LastWriteTime < DateTime.Now.AddMonths(deletemonth))
                        fi.Delete();
                }

                //Aqui escrevo o lastrun
                try
                {
                    String path = Directory.GetCurrentDirectory();
                    StreamWriter w = new StreamWriter(path + "/software.txt", false);
                    w.Write("lastrun=" + DateTime.Now.ToString());
                    w.WriteLine();
                    
                    w.Close();
                }
                catch (IOException ex)
                {
                    sendmail(ex.ToString());
                }
            }
            else
            {
                sendmail("Não foi preenchido ou mal preenchido o campo 'folderlog' na ficheiro das configurações.");
            }

        }

        private static void sendmail(String textmail)
        {
            try
            {
                SmtpClient client = new SmtpClient();
                client.Port = (int)port;
                client.Host = ipaddressserver;
                client.EnableSsl = ssl;
                client.Timeout = 10000;
                client.DeliveryMethod = SmtpDeliveryMethod.Network;
                client.UseDefaultCredentials = true;
                client.Credentials = new System.Net.NetworkCredential(login, password);

                MailMessage mm = new MailMessage(sender, receipt, "Problema Envio atualização para a balanças", textmail);
                mm.BodyEncoding = UTF8Encoding.UTF8;
                mm.DeliveryNotificationOptions = DeliveryNotificationOptions.OnFailure;

                client.Send(mm);
            }
            catch (Exception e)
            {
                try
                {
                    String path = Directory.GetCurrentDirectory();
                    StreamWriter w = File.AppendText(path + "/logs/error_" + DateTime.Now.Year.ToString() + "_" + DateTime.Now.Month.ToString() + "_" + DateTime.Now.Day.ToString() + ".txt");
                    w.Write(DateTime.Now.ToString() + "_Não foi possível enviar o mail:\r\nTexto do mail: " + textmail + "\r\nErro do envio do mail: " + e.ToString() + "\r\n\r\n");
                    w.WriteLine();
                    w.Close();
                }
                catch (IOException ex)
                {
                    
                }
            }
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

            filepath = path + "/software.txt";
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
                case "deletefile":
                    deletemonth = 0 - Convert.ToInt16(line[1].ToString());
                    break;
                case "folderlog":
                    folder = line[1].ToString();
                    break;
                case "lastrun":
                    if (line[1].ToString().Length > 0)
                    {
                        lastrun = Convert.ToDateTime(line[1].ToString());
                    }
                    else
                    {
                        lastrun = DateTime.Now;
                    }                    
                    break;
                default:
                    break;
            }
        }
    }
}
