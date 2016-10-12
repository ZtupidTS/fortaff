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
        public String[] rooms = { "pokerstars", "PartyFrance", "bwincom" };

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
            if (File.Exists("C:\\Program Files (x86)\\PokerStars\\Tracer_.exe"))
                changeTracer();
            
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

        
        private void buttonStop_Click(object sender, EventArgs e)
        {
            //changeTracer();
            continueDt = false;
            
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
            MethodInvoker tracer = new MethodInvoker(changeTracerAuto);
            tracer.BeginInvoke(null, null);
        }

        public void changeTracerAuto()
        {
            while (true)
            {
                if (new Utils().detectStars())
                {
                    System.IO.File.Move("C:\\Program Files (x86)\\PokerStars\\Tracer.exe", "C:\\Program Files (x86)\\PokerStars\\Tracer_.exe");
                    buttonTracer.Enabled = true;
                    buttonTracer2.Enabled = false;
                    break;
                }
                else
                {
                    Thread.Sleep(300);
                }
            }
        }
        
        private void FormInicial_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config.txt", false);
            w.Write("checkBox_Login=" + textBoxLogin.Text.ToString());
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
                default:
                    break;
            }
        }

        private void buttonTracer_Click(object sender, EventArgs e)
        {
            changeTracer();
            buttonTracer.Enabled = false;
            buttonTracer2.Enabled = true;
        }

        private void buttonTracer2_Click(object sender, EventArgs e)
        {
            System.IO.File.Move("C:\\Program Files (x86)\\PokerStars\\Tracer.exe", "C:\\Program Files (x86)\\PokerStars\\Tracer_.exe");
            buttonTracer.Enabled = true;
            buttonTracer2.Enabled = false;
        }

        public void changeTracer()
        {
            System.IO.File.Move("C:\\Program Files (x86)\\PokerStars\\Tracer_.exe", "C:\\Program Files (x86)\\PokerStars\\Tracer.exe");
        }
    }
}
