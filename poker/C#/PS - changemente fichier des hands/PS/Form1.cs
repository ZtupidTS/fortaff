using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Runtime.InteropServices;
using System.IO;
using System.Diagnostics;
using System.Net;
using System.Threading;


namespace PS
{
    public partial class FormInicial : Form
    {
        Boolean continueDt = true;
        //public int initial_y = 354;
        //public int initial_x = 159;
        //public int hand_y = 518;
        //public int hand_x = 187;
        //private const int MOUSEEVENTF_LEFTDOWN = 0x02;
        //private const int MOUSEEVENTF_LEFTUP = 0x04;
        //String loginsend = "";
        //Boolean down = false;
        //Boolean firststart = true;
        //Boolean zoom = false;
        String ipinicial;
        //VpnConnect.VPN vpn;
        public WebClient webclient = new WebClient();
        public int i = 1;
        private Thread convertfile;
        private Boolean continuconvertstars = true;

        //const int VK_UP = 0x26; //key up

        delegate void SetTextCallbacks(String text);

        public FormInicial()
        {
            InitializeComponent();
            loadconfig();
            //aqui vai ser para a vpn
            //ipinicial = new Utils().getipinternetMeu();
            //String ipinicial2 = new Utils().getipinternet2();
            ipinicial = new Utils().getipinternetMeu();
            label1.Text = ipinicial;
            
        }

        //[DllImport("user32.dll")]
        //public static extern void keybd_event(byte bVk, byte bScan, int dwFlags, int dwExtraInfo);

        //public const int KEYEVENTF_EXTENDEDKEY = 0x0001; //Key down flag
        //public const int KEYEVENTF_KEYUP = 0x0002; //Key up flag
        //public const int VK_LCONTROL = 0xA2; //Left Control key code
        //public const int A = 0x41; //A Control key code
        //public const int C = 0x43; //A Control key code

        //[DllImport("user32.dll")]
        //public static extern void mouse_event(int dwFlags, int dx, int dy, int cButtons, int dwExtraInfo);

        public void Dt()
        {
            while (continueDt)
            {
                String temp = new Utils().getipinternet3(webclient);
                if (temp != ipinicial)
                {
                    continueDt = false;
                    //fecha a stars
                    String[] rooms = { "pokerstars", "PartyFrance" };
                    foreach (String room in rooms)
                    {
                        new Utils().detectApps(room);
                    }
                    listbox("Mudança de IP");
                }
                listbox(i + "- " + temp + " (1)");
                i++; 
            }
        }

        public void DtMeu()
        {
            while (continueDt)
            {
                String temp = new Utils().getipinternetMeu();
                if (temp != ipinicial)
                {
                    continueDt = false;
                    //fecha a stars
                    String[] rooms = { "pokerstars", "PartyFrance" };
                    foreach (String room in rooms)
                    {
                        new Utils().detectApps(room);
                    }
                    listbox("Mudança de IP");
                }
                listbox(i + "- " + temp + " (2)");
                i++;
            }
        }

        public void Dt2()
        {
            while (continueDt)
            {
                String temp = new Utils().getipinternet2();
                if (temp != ipinicial)
                {
                    continueDt = false;
                    //fecha a stars
                    String[] rooms = { "pokerstars", "PartyFrance" };
                    foreach (String room in rooms)
                    {
                        new Utils().detectApps(room);
                    }
                    listbox("Mudança de IP");
                }
                listbox(i + "- " + temp + " (3)");
                i++;
            }
        }

        public void listbox(String text)
        {
            if (this.listBox1.InvokeRequired)
            {
                SetTextCallbacks d = new SetTextCallbacks(setListbox);
                this.Invoke(d, new object[] { text });
            }
            else
            {
                // It's on the same thread, no need for Invoke
                this.listBox1.TopIndex = this.listBox1.Items.Add(text);

                //this.labelStop.ForeColor = cor;
            }
        }

        public void setListbox(String text)
        {
            this.listBox1.TopIndex = this.listBox1.Items.Add(text);
            //this.labelStop.ForeColor = cor;
        }

        //public void buttonStart_Click(object sender, EventArgs e)
        //{
            
        //    //if (textBoxLogin.Text == "")
        //    //{
        //    //    textBoxLogin.Text = "Login here first";
        //    //}
        //    //else
        //    //{
        //    //    Boolean contar = true;
        //    //    int n = 5;

        //    //    while (contar)
        //    //    {
        //    //        if (n != 0)
        //    //        {
        //    //            System.Threading.Thread.Sleep(500);
        //    //            n = n - 1;
        //    //        }
        //    //        else
        //    //        {
        //    //            contar = false;
        //    //        }
        //    //    }

        //    //    continueDt = true;
        //    //    if (firststart)
        //    //    {
        //    //        //méthode async
        //    //        MethodInvoker startdt = new MethodInvoker(Dt);
        //    //        startdt.BeginInvoke(null, null);
        //    //        firststart = false;
        //    //    }
                
        //    //}


        //}

        //public void Dt()
        //{
        //    RecupClipboard handcopy = new RecupClipboard();
        //    OperationWindow ow = new OperationWindow();
        //    if (checkBoxLogin.Checked)
        //    {
        //        loginsend = "PokerStars Lobby - Logged in as " + textBoxLogin.Text.ToString();
        //    }
        //    else
        //    {
        //        loginsend = "PokerStars Lobby";
        //    }
        //    if (checkBoxDown.Checked)
        //    {
        //        down = true;
        //    }
        //    if (checkBoxZoom.Checked)
        //    {
        //        zoom = true;
        //    }
        //    ow.selectLobby(loginsend, down, zoom);            
        //    int cincominuto = 0;
        //    int vpnminute = 0;
        //    int vpnnumber = 1;
        //    while (true)
        //    {
        //        while (continueDt)
        //        {

        //            try
        //            {
        //                if (!zoom)
        //                {
        //                    if (cincominuto == 700)
        //                    //if (cincominuto == 1)
        //                    {
        //                        Cursor.Position = new Point(initial_x, initial_y);
        //                        mouse_event(MOUSEEVENTF_LEFTDOWN, initial_x, initial_y, 0, 0);
        //                        mouse_event(MOUSEEVENTF_LEFTUP, initial_x, initial_y, 0, 0);

        //                        for (int i = 0; i < 100; i++)
        //                        {
        //                            keybd_event(VK_UP, 0, 0, 0);
        //                            keybd_event(VK_UP, 0, KEYEVENTF_KEYUP, 0);
        //                            System.Threading.Thread.Sleep(400);
        //                        }

        //                        ow.closetable();
        //                        cincominuto = 0;
        //                    }
        //                }

        //                Cursor.Position = new Point(initial_x, initial_y);
        //                mouse_event(MOUSEEVENTF_LEFTDOWN, initial_x, initial_y, 0, 0);
        //                mouse_event(MOUSEEVENTF_LEFTUP, initial_x, initial_y, 0, 0);

        //                Cursor.Position = new Point(hand_x, hand_y);
        //                mouse_event(MOUSEEVENTF_LEFTDOWN, hand_x, hand_y, 0, 0);
        //                mouse_event(MOUSEEVENTF_LEFTUP, hand_x, hand_y, 0, 0);

        //                // Hold Control down and press A
        //                keybd_event(VK_LCONTROL, 0, 0, 0);
        //                keybd_event(A, 0, 0, 0);
        //                keybd_event(A, 0, KEYEVENTF_KEYUP, 0);
        //                keybd_event(VK_LCONTROL, 0, KEYEVENTF_KEYUP, 0);

        //                // Hold Control down and press C
        //                keybd_event(VK_LCONTROL, 0, 0, 0);
        //                keybd_event(C, 0, 0, 0);
        //                keybd_event(C, 0, KEYEVENTF_KEYUP, 0);
        //                keybd_event(VK_LCONTROL, 0, KEYEVENTF_KEYUP, 0);

        //                //coller
        //                handcopy.getClipboard(ow, down, zoom, textBoxVm.Text, textBoxDrive.Text);

        //                cincominuto = cincominuto + 1;
        //                vpnminute++;

        //                System.Threading.Thread.Sleep(400);
        //                //System.Threading.Thread.Sleep(1500);

        //                //agora vejo se o ip for igual
        //                //if (ipinicial.Equals(new Utils().getipinternet()))
        //                //{
        //                //    new Utils().detectApps("PokerStars");
        //                //}

        //                //aqui o ciclo de antes
        //                if (vpnminute >= 5)
        //                {
        //                    vpnminute = 0;
        //                    int tentative = 1;
        //                    while (!vpn.TestConnection())
        //                    {
        //                        vpn.Manage();
        //                        if (tentative > 5)
        //                        {
        //                            if (vpnnumber == 1)
        //                            {
        //                                vpn.VPNConnectionName = textBoxVpn2.Text;
        //                                textBoxVpn1.ForeColor = Color.Red;
        //                                vpnnumber++;
        //                                tentative = 1;
        //                            }
        //                            else
        //                            {
        //                                if (vpnnumber == 2)
        //                                {
        //                                    vpn.VPNConnectionName = textBoxVpn3.Text;
        //                                    textBoxVpn2.ForeColor = Color.Red;
        //                                    vpnnumber++;
        //                                    tentative = 1;
        //                                }
        //                                else
        //                                {
        //                                    //shutdown the machine
        //                                    Process.Start("shutdown", "/s /t 0");
        //                                }
        //                            }
        //                        }
        //                        tentative++;
        //                    }
        //                }
        //                //ici je vais mettre une exception au cas ou
        //            }
        //            catch (Exception ex)
        //            {
        //                new Debug().LogMessage(ex.ToString());
        //            }
        //        }
        //    }
        //}

        private void buttonStop_Click(object sender, EventArgs e)
        {
            continueDt = false;
            continuconvertstars = false;
            String[] rooms = { "pokerstars", "PartyFrance" };
            foreach (String room in rooms)
            {
                new Utils().detectApps(room);
            }
            this.Close();
        }

        private void buttonStart_Click(object sender, EventArgs e)
        {
            MethodInvoker startdt = new MethodInvoker(Dt);
            startdt.BeginInvoke(null, null);
            MethodInvoker startdt3 = new MethodInvoker(DtMeu);
            startdt3.BeginInvoke(null, null);
            MethodInvoker startdt2 = new MethodInvoker(Dt2);
            startdt2.BeginInvoke(null, null);
            MethodInvoker convertfile = new MethodInvoker(convertFileStars);
            convertfile.BeginInvoke(null, null);
            //convertfile = new Thread(new ThreadStart(this.convertFileStars));
            //convertfile.Start();
        }

        private long sizeDir(String dir)
        {
            string[] a = Directory.GetFiles(dir, "*.*");
            long b = 0;
            foreach (string name in a)
            {
                FileInfo info = new FileInfo(name);
                b += info.Length;
            }
            return b;
        }

        public String pathApp()
        {
            String startupPath = System.IO.Directory.GetCurrentDirectory();
            String icon_path = new Uri(startupPath).LocalPath;
            return icon_path;
        }

        private void convertFileStars()
        {
            string[] folders;
            string[] filehands;

            string exemplo = "";
            using (StreamReader streamReader = new StreamReader("Z:\\meu.txt", Encoding.UTF8))
            {
                exemplo = streamReader.ReadToEnd();
                streamReader.Close();
                streamReader.Dispose();
            }

            while (continuconvertstars)
            {
                try
                {
                    //ober a lista de directorios
                    //folders = Directory.GetDirectories(textBoxoldlink.ToString());
                    //obter dados de cada pasta
                    //foreach (String fo in folders)
                    //{
                        //aqui obtenho o tamanho da pasta
                        //long sizedirectory = sizeDir(fo);
                        //agora se não existe na DB vou meter ou verificar se há mudanças
                        //Boolean folderboo = folderChanges(fo, sizedirectory);
                        //true = ler directorio
                        //false = ir para outro directorio

                        //if (folderboo)
                        //{
                            //vou passar a ir novamente a todos os ficheiros
                    String linkfile = textBoxoldlink.Text.ToString();
                    filehands = Directory.GetFiles(linkfile, "*.txt");

                            String textfile2 = "";
                            foreach (String fi in filehands)
                            {
                                //antes de ir ler o ficheiro ver se tem o mesmo tamanho
                                FileInfo info = new FileInfo(fi);
                                //Boolean fileboo = fileChanges(Path.GetFileName(fi), info.Length);
                                Boolean fileboo = true;

                                //true = ler file
                                //false = ir para outro
                                if (fileboo)
                                {
                                    //vou copiar o ficheiro original
                                    String tempfile = pathApp() + "\\tempfile\\" + info.Name;

                                    //File.SetAttributes(tempfile, FileAttributes.Normal);
                                    File.Copy(fi, tempfile, true);
                                    File.SetAttributes(tempfile, FileAttributes.Normal);

                                    using (StreamReader streamReader = new StreamReader(tempfile, Encoding.UTF8))
                                    {
                                        textfile2 = streamReader.ReadToEnd();
                                        streamReader.Close();
                                        streamReader.Dispose();
                                    }
                                    textfile2 = textfile2.Replace(exemplo, "€");
                                    //String path = "c:/file.ini";
                                    using (var stream = new FileStream(tempfile, FileMode.Truncate))
                                    {
                                        using (var writer = new StreamWriter(stream))
                                        {
                                            writer.Write(textfile2);
                                        }
                                    }
                                    //handHive(textfile2, info.Name);
                                    String icon_path = new Uri(textBoxnewlink.Text.ToString()).LocalPath;
                                    String dede = icon_path + "\\" + info.Name;
                                    StreamWriter w = new StreamWriter(dede, false);
                                    w.Write(textfile2);
                                    w.WriteLine();
                                    w.Close();


                                    //vou eliminar todos os ficheiros presente na pasta tempfile
                                    var dir = new DirectoryInfo(pathApp() + "\\tempfile\\");
                                    foreach (var file in dir.GetFiles())
                                    {
                                        try
                                        {
                                            file.Delete();
                                        }
                                        catch (IOException ex)
                                        {
                                            //file is currently locked
                                            //if (logs) new Debug().LogMessage("Problem no catch delete: " + ex.ToString());
                                        }
                                    }
                                    File.Delete(tempfile);
                                }
                                textfile2 = "";
                            //}

                        }
                    //}
                }
                catch (Exception e)
                {
                    //if (logs) new Debug().LogMessage("Problem no handconverthive: " + e.ToString());
                    //convertHandsHive();
                }
            }
        }

        //private void checkBoxLogin_CheckedChanged(object sender, EventArgs e)
        //{
        //    if (checkBoxLogin.Checked)
        //    {
        //        textBoxLogin.Visible = true;
        //    }
        //    else
        //    {
        //        textBoxLogin.Visible = false;
        //    }
        //}

        private void FormInicial_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config.txt", false);
            w.Write("checkBox_Login=" + textBoxLogin.Text.ToString());
            w.WriteLine();
            w.Write("textboxold=" + textBoxoldlink.Text.ToString());
            w.WriteLine();
            w.Write("textboxnew=" + textBoxnewlink.Text.ToString());
            w.WriteLine();
            w.Close();
        }

        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config.txt";
            if (File.Exists(filepath))
            {
                string line;
                // Read the file and display it line by line.
                System.IO.StreamReader file = new System.IO.StreamReader(filepath);
                while ((line = file.ReadLine()) != null)
                {
                    String[] array = line.Split('=');
                    configframe(array);
                }
                file.Close();
            }
        }

        private void configframe(String[] line)
        {
            switch (line[0])
            {
                case "Location":
                    String[] loc = line[1].Split(',');
                    this.StartPosition = FormStartPosition.Manual;
                    this.Location = new Point(int.Parse(loc[0]), int.Parse(loc[1]));
                    break;
                case "Checkbox_down":
                    checkBoxDown.Checked = true;
                    break;
                case "checkBox_Login":
                    //checkBoxLogin.Checked = true;
                    textBoxLogin.Text = line[1].ToString();
                    break;
                case "Checkbox_zoom":
                    checkBoxZoom.Checked = true;
                    break;
                case "Vm":
                    textBoxVm.Text = line[1].ToString();
                    break;
                case "Vpn1":
                    textBoxVpn1.Text = line[1].ToString();
                    break;
                case "Vpn2":
                    textBoxVpn2.Text = line[1].ToString();
                    break;
                case "Vpn3":
                    textBoxVpn3.Text = line[1].ToString();
                    break;
                case "drive":
                    textBoxDrive.Text = line[1].ToString();
                    break;
                case "textboxold":
                    textBoxoldlink.Text = line[1].ToString();
                    break;
                case "textboxnew":
                    textBoxnewlink.Text = line[1].ToString();
                    break;
                default:
                    break;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            folderBrowserDialog1.ShowDialog();
            textBoxoldlink.Text = folderBrowserDialog1.SelectedPath.ToString();
            //folderoriginalhive = folderBrowserDialogHand.SelectedPath.ToString();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            folderBrowserDialog1.ShowDialog();
            textBoxnewlink.Text = folderBrowserDialog1.SelectedPath.ToString();
        }

        //private void buttonConnectVpn_Click(object sender, EventArgs e)
        //{
        //    if (textBoxVpn1.Text.Equals(""))
        //    {
        //        MessageBox.Show("Preencher as linhas das vpns");
        //    }
        //    else
        //    {
        //        //Process.Start("shutdown", "/s /t 0");
        //        vpn = new VpnConnect.VPN(textBoxVpn1.Text, ipinicial);
        //    }
        //}
    }
}
