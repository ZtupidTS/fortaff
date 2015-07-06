using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Net.NetworkInformation;
using System.Net.Mail;

namespace CheckIp
{
    class Program
    {
        static void Main(string[] args)
        {
            List<Tuple<String,String>> pc = new List<Tuple<String, String>>();
            pc.Add(Tuple.Create("219.21.221.3","BO"));
            pc.Add(Tuple.Create("219.21.221.4", "TSE"));
            pc.Add(Tuple.Create("219.21.221.14", "Disque paire"));
            pc.Add(Tuple.Create("219.21.221.15", "Infosaft"));
            pc.Add(Tuple.Create("219.21.221.12", "W2k3app"));
            pc.Add(Tuple.Create("219.21.221.211", "Nas4Free"));
            pc.Add(Tuple.Create("219.21.221.232", "Rasp"));
            pc.Add(Tuple.Create("219.21.222.10", "Disque TSE paire"));
            pc.Add(Tuple.Create("219.21.222.11", "Disque TSE impaire"));

            Ping pingSender = new Ping();
            PingReply reply;
            String response = "";

            foreach (var lst in pc)
            {
                reply= pingSender.Send(lst.Item1);

                if (reply.Status == IPStatus.Success)
                {
                    response += lst.Item2 + "...... OK";
                    //Console.WriteLine("Address: {0}", reply.Address.ToString());
                    //Console.WriteLine("RoundTrip time: {0}", reply.RoundtripTime);
                    //Console.WriteLine("Time to live: {0}", reply.Options.Ttl);
                    //Console.WriteLine("Don't fragment: {0}", reply.Options.DontFragment);
                    //Console.WriteLine("Buffer size: {0}", reply.Buffer.Length);
                }
                else
                {
                    response += lst.Item2 + "..... PROBLEM";
                    //Console.WriteLine(reply.Status);
                }
                response += "\r\n";

            }

            SmtpClient client = new SmtpClient();
            client.Port = 25;
            client.Host = "auth.ptasp.com";
            client.EnableSsl = false;
            client.Timeout = 10000;
            client.DeliveryMethod = SmtpDeliveryMethod.Network;
            client.UseDefaultCredentials = true;
            client.Credentials = new System.Net.NetworkCredential("ep108651@fafedis.pt", "fafedis0");

            MailMessage mm = new MailMessage("informatica@fafedis.pt", "informatica@fafedis.pt", "Ping Result", response);            
            mm.BodyEncoding = UTF8Encoding.UTF8;
            mm.DeliveryNotificationOptions = DeliveryNotificationOptions.OnFailure;

            client.Send(mm);            
            
        }
    }
}
