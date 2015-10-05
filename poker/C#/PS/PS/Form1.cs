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


namespace PS
{
    public partial class FormInicial : Form
    {
        Boolean continueDt = false;
        public int initial_y = 354;
        public int initial_x = 159;
        public int hand_y = 518;
        public int hand_x = 187;
        private const int MOUSEEVENTF_LEFTDOWN = 0x02;
        private const int MOUSEEVENTF_LEFTUP = 0x04;
        String loginsend = "";
        Boolean down = false;
        Boolean firststart = true;
        Boolean zoom = false;
        String ipinicial;
        VpnConnect.VPN vpn;

        const int VK_UP = 0x26; //key up

        public FormInicial()
        {
            InitializeComponent();
            loadconfig();
            //aqui vai ser para a vpn
            ipinicial = new Utils().getipinternet();
                       
        }

        [DllImport("user32.dll")]
        public static extern void keybd_event(byte bVk, byte bScan, int dwFlags, int dwExtraInfo);

        public const int KEYEVENTF_EXTENDEDKEY = 0x0001; //Key down flag
        public const int KEYEVENTF_KEYUP = 0x0002; //Key up flag
        public const int VK_LCONTROL = 0xA2; //Left Control key code
        public const int A = 0x41; //A Control key code
        public const int C = 0x43; //A Control key code

        [DllImport("user32.dll")]
        public static extern void mouse_event(int dwFlags, int dx, int dy, int cButtons, int dwExtraInfo);

        private void buttonStart_Click(object sender, EventArgs e)
        {
            if (textBoxLogin.Text == "")
            {
                textBoxLogin.Text = "Login here first";
            }
            else
            {
                Boolean contar = true;
                int n = 5;

                while (contar)
                {
                    if (n != 0)
                    {
                        System.Threading.Thread.Sleep(500);
                        n = n - 1;
                    }
                    else
                    {
                        contar = false;
                    }
                }

                continueDt = true;
                if (firststart)
                {
                    //méthode async
                    MethodInvoker startdt = new MethodInvoker(Dt);
                    startdt.BeginInvoke(null, null);
                    firststart = false;
                }
                
            }
        }

        public void Dt()
        {
            RecupClipboard handcopy = new RecupClipboard();
            OperationWindow ow = new OperationWindow();
            if (checkBoxLogin.Checked)
            {
                loginsend = "PokerStars Lobby - Logged in as " + textBoxLogin.Text.ToString();
            }
            else
            {
                loginsend = "PokerStars Lobby";
            }
            if (checkBoxDown.Checked)
            {
                down = true;
            }
            if (checkBoxZoom.Checked)
            {
                zoom = true;
            }
            ow.selectLobby(loginsend, down, zoom);            
            int cincominuto = 0;
            int vpnminute = 0;
            int vpnnumber = 1;
            while (true)
            {
                while (continueDt)
                {

                    try
                    {
                        if (!zoom)
                        {
                            if (cincominuto == 700)
                            //if (cincominuto == 1)
                            {
                                Cursor.Position = new Point(initial_x, initial_y);
                                mouse_event(MOUSEEVENTF_LEFTDOWN, initial_x, initial_y, 0, 0);
                                mouse_event(MOUSEEVENTF_LEFTUP, initial_x, initial_y, 0, 0);

                                for (int i = 0; i < 100; i++)
                                {
                                    keybd_event(VK_UP, 0, 0, 0);
                                    keybd_event(VK_UP, 0, KEYEVENTF_KEYUP, 0);
                                    System.Threading.Thread.Sleep(400);
                                }

                                ow.closetable();
                                cincominuto = 0;
                            }
                        }

                        Cursor.Position = new Point(initial_x, initial_y);
                        mouse_event(MOUSEEVENTF_LEFTDOWN, initial_x, initial_y, 0, 0);
                        mouse_event(MOUSEEVENTF_LEFTUP, initial_x, initial_y, 0, 0);

                        Cursor.Position = new Point(hand_x, hand_y);
                        mouse_event(MOUSEEVENTF_LEFTDOWN, hand_x, hand_y, 0, 0);
                        mouse_event(MOUSEEVENTF_LEFTUP, hand_x, hand_y, 0, 0);

                        // Hold Control down and press A
                        keybd_event(VK_LCONTROL, 0, 0, 0);
                        keybd_event(A, 0, 0, 0);
                        keybd_event(A, 0, KEYEVENTF_KEYUP, 0);
                        keybd_event(VK_LCONTROL, 0, KEYEVENTF_KEYUP, 0);

                        // Hold Control down and press C
                        keybd_event(VK_LCONTROL, 0, 0, 0);
                        keybd_event(C, 0, 0, 0);
                        keybd_event(C, 0, KEYEVENTF_KEYUP, 0);
                        keybd_event(VK_LCONTROL, 0, KEYEVENTF_KEYUP, 0);

                        //coller
                        handcopy.getClipboard(ow, down, zoom, textBoxVm.Text, textBoxDrive.Text);

                        cincominuto = cincominuto + 1;
                        vpnminute++;

                        System.Threading.Thread.Sleep(400);
                        //System.Threading.Thread.Sleep(1500);

                        //agora vejo se o ip for igual
                        //if (ipinicial.Equals(new Utils().getipinternet()))
                        //{
                        //    new Utils().detectApps("PokerStars");
                        //}

                        //aqui o ciclo de antes
                        if (vpnminute >= 5)
                        {
                            vpnminute = 0;
                            int tentative = 1;
                            while (!vpn.TestConnection())
                            {
                                vpn.Manage();
                                if (tentative > 5)
                                {
                                    if (vpnnumber == 1)
                                    {
                                        vpn.VPNConnectionName = textBoxVpn2.Text;
                                        textBoxVpn1.ForeColor = Color.Red;
                                        vpnnumber++;
                                        tentative = 1;
                                    }
                                    else
                                    {
                                        if (vpnnumber == 2)
                                        {
                                            vpn.VPNConnectionName = textBoxVpn3.Text;
                                            textBoxVpn2.ForeColor = Color.Red;
                                            vpnnumber++;
                                            tentative = 1;
                                        }
                                        else
                                        {
                                            //shutdown the machine
                                            Process.Start("shutdown", "/s /t 0");
                                        }
                                    }
                                }
                                tentative++;
                            }
                        }
                        //ici je vais mettre une exception au cas ou
                    }
                    catch (Exception ex)
                    {
                        new Debug().LogMessage(ex.ToString());
                    }
                }
            }
        }

        private void buttonStop_Click(object sender, EventArgs e)
        {
            continueDt = false;
        }

        private void checkBoxLogin_CheckedChanged(object sender, EventArgs e)
        {
            if (checkBoxLogin.Checked)
            {
                textBoxLogin.Visible = true;
            }
            else
            {
                textBoxLogin.Visible = false;
            }
        }

        private void FormInicial_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString()+','+this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config.txt", false);
            w.Write("Location="+location);
            w.WriteLine();
            if (checkBoxDown.Checked)
            {
                w.Write("Checkbox_down=true");
                w.WriteLine();
            }
            if (checkBoxLogin.Checked)
            {
                w.Write("checkBox_Login=" + textBoxLogin.Text.ToString());
                w.WriteLine();
            }
            if (checkBoxZoom.Checked)
            {
                w.Write("Checkbox_zoom=true");
                w.WriteLine();
            }
            w.Write("Vm="+textBoxVm.Text);
            w.WriteLine();
            w.Write("Vpn1=" + textBoxVpn1.Text);
            w.WriteLine();
            w.Write("Vpn2=" + textBoxVpn2.Text);
            w.WriteLine();
            w.Write("Vpn3=" + textBoxVpn3.Text);
            w.WriteLine();
            w.Write("drive=" + textBoxDrive.Text);
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
                    checkBoxLogin.Checked = true;
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
                default:
                    break;
            }
        }

        private void buttonConnectVpn_Click(object sender, EventArgs e)
        {
            if (textBoxVpn1.Text.Equals(""))
            {
                MessageBox.Show("Preencher as linhas das vpns");
            }
            else
            {
                //Process.Start("shutdown", "/s /t 0");
                vpn = new VpnConnect.VPN(textBoxVpn1.Text, ipinicial);
            }
        }
    }
}
