using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Profumi.Json;
using System.Net;
using System.Web;
using Newtonsoft.Json;
using Profumi.DB;
using Profumi;
using System.Threading;
using CookComputing.XmlRpc;
using Egoi;

namespace Profumi
{
    public partial class FormSendSMS : Form
    {
        private SQLiteDatabase db;
        private Main ma;
        private String user;
        private String login = "informatica@fafedis.pt";
        private String password = "leclercgoi29";
        private String apikey = "3ec8e415ff9b7939513675fd50b0c308b07d8fd9";
        private String list = "25";
        
        public FormSendSMS(SQLiteDatabase dbmain, Main main, String username)
        {
            InitializeComponent();
            labelCharacterSms.Text = "0/150";
            //ligação a DB sqlite
            db = dbmain;
            ma = main;
            user = username;
            //Aqui vou ver os estado das sms no arranque do software
            verifysms();

            Boolean continue_while = true;
            int start = 0;

            while (continue_while)
            {
                EgoiMap te = new EgoiMap();
                te.Add("apikey", apikey);
                te.Add("listID", list);
                te.Add("limit", 1000);
                te.Add("start", start);
                te.Add("subscriber", "all_subscribers");

                EgoiApi mm;

                mm.sendSMS(te);


                start += 999;
            }  

        	
            //        $client = new SoapClient('http://api.e-goi.com/v2/soap.php?wsdl');
            //    $result = $client->subscriberData($params);
		
            //    if(!empty($result))
            //    {
            //        foreach($result['subscriber'] as $arr)
            //        {
            //            if(in_array('351-962411301', $arr))
            //            {
            //                $result_final = $arr['UID'];
            //                $continue_while = false;
            //            }
            //        }	
            //    }else{
            //        $continue_while = false;
            //    }
            //    $start = $start + 999;
            //    unset($result);
            //}
            //return $result_final;

            //teste meu com egoi
            //EgoiApi smstest;
            //EgoiMap te = new EgoiMap();
            //te.Add("apikey", apikey);
            //te.Add("listID", list);
            //te.Add(
            //smstest.sendSMS(

        }

        /// <summary>
        /// fechar a aplicação
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonClose_Click(object sender, EventArgs e)
        {
            this.Close();
            ma.Close();
        }

        /// <summary>
        /// Button send sms
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonSend_Click(object sender, EventArgs e)
        {
            //o resto
            String numberstring = textBoxNumber.Text;
            Int32 numbernumerico;
            //primeiro verifico o numero de telemóvel.
            //int nd = 2;
            //if(nd < 1)
            progressBarSms.Value = 0;

            if (numberstring.Substring(0).StartsWith("9") && numberstring.Length == 9 && textBoxSms.Text.Length > 5)
            {
                //agora verifico se é numerico
                try
                {
                    numbernumerico = Convert.ToInt32(numberstring);
                    progressBarSms.Value = 3;
                    String textsms = textBoxSms.Text.Replace("'", "");
                    //String message = urlencode(textsms);
	                String alfaSender = "Profumi";
                    String url = "http://ziegen.dyndns.org/ez4usms/API/sendSMS.php?account=" + login + "&licensekey=" + password + "&phoneNumber=" + numbernumerico + "&messageText=" + HttpUtility.UrlEncode(textsms) + "&TTL=30&alfaSender=" + alfaSender;
                    //String url = "https://ziegen.dyndns.org/ez4usms/API/sendSMS.php?account=" + login + "&licensekey=" + password + "&phoneNumber=" + numbernumerico + "&messageText=" + textsms + "&TTL=30&alfaSender=" + alfaSender;

                    var json = sendSms<Sms>(url);                    

                    if (json.Result == "OK")
                    {
                        try
                        {
                            Dictionary<String, String> data = new Dictionary<String, String>();
                            data.Add("result", json.Result);
                            data.Add("smsid", json.LastSMSID.ToString());
                            data.Add("smsinserted", json.NrOfInsertedMessages.ToString());
                            data.Add("user_name", user);
                            //data.Add("sms_state", json.Result);
                            DateTime dtime = DateTime.Now;
                            data.Add("sms_date", dtime.ToString());
                            data.Add("sms_contact", numberstring);
                            data.Add("sms_text", textsms);

                            if (db.Insert("sms", data))
                            {
                                //vou verificar o estado do sms depois de inserir na DB
                                progressBarSms.Value = 6;
                                Thread.Sleep(12000);
                                String smsid = json.LastSMSID.ToString();
                                url = "http://ziegen.dyndns.org/ez4usms/API/getSMSStatus.php?account=" + login + "&licensekey=" + password + "&smsID=" + smsid;
                                var json2 = sendSms<Sms>(url);

                                if (json2.Result == "OK")
                                {
                                    data = new Dictionary<String, String>();
                                    try
                                    {
                                        //aqui ver o estado do sms e depois saber o que fazer
                                        progressBarSms.Value = 9;
                                        switch (json2.MessageInfo.DeliveryStatus)
                                        {
                                            case "0":
                                                data.Add("sms_state", "Não Processada");
                                                MessageBox.Show("Mensagem ainda não processada");
                                                break;
                                            case "1":
                                                data.Add("sms_state", "Entregue");
                                                MessageBox.Show("Mensagem entregue");
                                                break;
                                            case "2":
                                                data.Add("sms_state", "Pendente");
                                                MessageBox.Show("Mensagem pendente");
                                                break;
                                            case "3":
                                                data.Add("sms_state", "Não entregue e Não vai ser entregue");
                                                MessageBox.Show("Mensagem não entregue e não vai ser entregue");
                                                break;
                                            default:
                                                data.Add("sms_state", "Erro desconhecido:" + json2.MessageInfo.DeliveryStatus);
                                                MessageBox.Show("Erro desconhecido");
                                                break;
                                        }
                                        db.Update("sms", data, String.Format("smsid = {0}", smsid));
                                    }
                                    catch (Exception crap)
                                    {
                                        MessageBox.Show(crap.Message);
                                    }
                                }                                
                            }
                            else
                            {
                                MessageBox.Show("Chamar o administrador (erro no insert depois de enviar a sms)");
                            }
                            textBoxNumber.Text = "";
                            textBoxSms.Text = "";
                        }
                        catch (Exception fail)
                        {
                            String error = "The following error has occurred:\r\n";
                            error += fail.Message.ToString() + "\r\n";
                            MessageBox.Show(error);
                            this.Close();
                        }
                    }
                    else
                    {
                        MessageBox.Show("Contacto o administrador");
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Verificar o numero inserido");
                }
            }
            else
            {
                MessageBox.Show("Verificar o numero inserido");
            }
        }

        /// <summary>
        /// Permite saber o numero de caracteres já isneridos na sms
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void textBoxSms_KeyUp(object sender, KeyEventArgs e)
        {
            labelCharacterSms.Text = textBoxSms.TextLength.ToString() + "/150";
        }

        /// <summary>
        /// send sms
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="query"></param>
        /// <returns></returns>
        private T sendSms<T>(String query) where T : new()
        {
            using (var w = new WebClient())
            {
                var json_data = string.Empty;
                // attempt to download JSON data as a string
                try
                {
                    //WebProxy proxy = new WebProxy();
                    //proxy.Address = new Uri("http://219.21.221.25:8080/");
                    ////proxy.Credentials = new NetworkCredential("ricardo", "ame4805");  //These can be replaced by user input, if wanted.
                    
                    //proxy.UseDefaultCredentials = false;
                    //proxy.BypassProxyOnLocal = false;

                    WebProxy proxy = new WebProxy("http://219.21.221.25:8080/");
                    proxy.Credentials = new NetworkCredential("ricardo", "ame4805");
                    //proxy.Credentials = CredentialCache.DefaultCredentials;

                    //proxy.UseDefaultCredentials = false;
                    //WebRequest.DefaultWebProxy = proxy;



                    w.Proxy = proxy;
                    json_data = w.DownloadString(query);
                    //json_data = w.DownloadString("http://127.0.0.1:8001/query?q=select%20StatRakeAmount,%20StatNewStarsVPP%20from%20stats");
                }
                catch (Exception ex) {
                    ex.ToString();
                }
                // if string with JSON data is not empty, deserialize it to class and return its instance 
                return !string.IsNullOrEmpty(json_data) ? JsonConvert.DeserializeObject<T>(json_data) : new T();
            }
        }

        private void linkLabel1_LinkClicked(object sender, LinkLabelLinkClickedEventArgs e)
        {
            FormHistory fh = new FormHistory(db);
            fh.Show();
        }

        private void verifysms()
        {
            //primeiro ir buscar a DB todos os sms != Entregue
            DataTable dt = db.GetDataTable("select smsid from sms where sms_state != 'Entregue'");
            foreach (DataRow row in dt.Rows) // Loop over the rows.
            {
                Dictionary<String, String> data;
                foreach (var item in row.ItemArray) // Loop over the items.
                {
                    try
                    {
                        String url = "http://ziegen.dyndns.org/ez4usms/API/getSMSStatus.php?account=" + login + "&licensekey=" + password + "&smsID=" + item;
                        var json2 = sendSms<Sms>(url);
                        data = new Dictionary<String, String>();
                        switch (json2.MessageInfo.DeliveryStatus)
                        {
                            case "0":
                                data.Add("sms_state", "Não Processada");
                                //MessageBox.Show("Mensagem ainda não processada");
                                break;
                            case "1":
                                data.Add("sms_state", "Entregue");
                                //MessageBox.Show("Mensagem entregue");
                                break;
                            case "2":
                                data.Add("sms_state", "Pendente");
                                //MessageBox.Show("Mensagem pendente");
                                break;
                            case "3":
                                data.Add("sms_state", "Não entregue e Não vai ser entregue");
                                //MessageBox.Show("Mensagem não entregue e não vai ser entregue");
                                break;
                            default:
                                data.Add("sms_state", "Erro desconhecido:" + json2.MessageInfo.DeliveryStatus);
                                //MessageBox.Show("Erro desconhecido");
                                break;
                        }
                        db.Update("sms", data, String.Format("smsid = {0}", item));
                    }
                    catch (Exception) { }
                }
            }
        }

    }
}
