using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Diagnostics;
using System.Runtime.InteropServices;
using System.Windows.Forms;

namespace PS
{
    class OperationWindow
    {
        List<Tuple<String, int>> list;
        int numbertable = 1;
        String login;
        int tablewhlogin;
        Boolean downtoup;
        Boolean zoom;

        [DllImport("user32.dll")]
        public static extern int FindWindow(string lpClassName, string lpWindowName);
        [DllImport("user32.dll")]
        public static extern int SendMessage(int hWnd, uint Msg, int wParam, int lParam);
        [DllImport("user32.dll", EntryPoint = "FindWindow", SetLastError = true)]
        static extern IntPtr FindWindowByCaption(IntPtr ZeroOnly, string lpWindowName);

        [DllImport("user32.dll", CharSet = CharSet.Auto)]
        static extern IntPtr SendMessage(IntPtr hWnd, UInt32 Msg, IntPtr wParam, IntPtr lParam);
        [DllImport("user32.dll")]
        private static extern bool SetForegroundWindow(IntPtr hWnd);
        [DllImportAttribute("User32.dll")]
        private static extern int SetForegroundWindow(int hWnd);
        [DllImport("user32.dll", SetLastError = true)]
        public static extern IntPtr SetActiveWindow(IntPtr hWnd);

        [DllImport("user32.dll")]
        public static extern void keybd_event(byte bVk, byte bScan, int dwFlags, int dwExtraInfo);


        public const int WM_SYSCOMMAND = 0x0112;
        public const int SC_CLOSE = 0xF060;
        const UInt32 WM_CLOSE = 0x0010;
        
        const int VK_UP = 0x26; //key up
        const int VK_DOWN = 0x28; //key down
        public const int KEYEVENTF_KEYUP = 0x0002; //Key up flag
        const int VK_RETURN = 0x0D; //enter key
        const int VK_ENTER = 13;

        /// <summary>
        /// /////
        /// </summary>
        /// private delegate bool EnumDelegate(IntPtr hWnd, int lParam);
        /// 
        const int MAXTITLE = 255;
        private delegate bool EnumDelegate(IntPtr hWnd, int lParam);
        private List<string> lstTitles = new List<string>();

        [DllImport("user32.dll", EntryPoint = "EnumDesktopWindows",
        ExactSpelling = false, CharSet = CharSet.Auto, SetLastError = true)]
        private static extern bool EnumDesktopWindows(IntPtr hDesktop,
        EnumDelegate lpEnumCallbackFunction, IntPtr lParam);

        [DllImport("user32.dll", EntryPoint = "GetWindowText",
        ExactSpelling = false, CharSet = CharSet.Auto, SetLastError = true)]
        private static extern int _GetWindowText(IntPtr hWnd,
        StringBuilder lpWindowText, int nMaxCount);

        [DllImport("user32.dll")]
        [return: MarshalAs(UnmanagedType.Bool)]
        static extern bool IsWindowVisible(IntPtr hWnd);
               

        /// <summary>
        /// ///
        /// </summary>

        
        public void getAllWindow()
        {
            if (list.Count != 0)
            {
                list = new List<Tuple<String, int>>();
            }
                        
            EnumDelegate delEnumfunc = new EnumDelegate(EnumWindowsProc);
            bool bSuccessful = EnumDesktopWindows(IntPtr.Zero, delEnumfunc, IntPtr.Zero); //for current desktop

        }

        private bool EnumWindowsProc(IntPtr hWnd, int lParam)
        {
            string strTitle = GetWindowText(hWnd);
            //if (strTitle != "" & IsWindowVisible(hWnd)) //
            if (strTitle != "" & IsWindowVisible(hWnd) && strTitle.Contains("No Limit Hold")) //
            {
                //lstTitles.Add(strTitle);
                addToList(strTitle, true);
            }
            return true;
        }

        public static string GetWindowText(IntPtr hWnd)
        {
            StringBuilder strbTitle = new StringBuilder(MAXTITLE);
            int nLength = _GetWindowText(hWnd, strbTitle, strbTitle.Capacity + 1);
            strbTitle.Length = nLength;
            return strbTitle.ToString();
        }

        public void addToList(String table, Boolean origin)
        {
            if (origin)
            {
                list.Add(Tuple.Create(table, 0));
            }
            else
            {
                table = table.Replace('\'', '_');
                String[] tablearray = table.Split('_');
                
                for (int i = 0; i < list.Count; i++)
                {
                    Boolean fim = false;
                    if (list[i].Item1.Contains(tablearray[2]))
                    {
                        int j = list[i].Item2;
                        String nametable = list[i].Item1;
                        list.RemoveAll(item => item.Item1 == nametable);
                        list.Add(Tuple.Create(nametable, (j + 1)));
                        fim = true;
                    }
                    if (fim) break;
                }
                
            }  
        }

        public void closetable()
        {
            //aqui vou fechar caso existe a janela de não poder abrir mais mesas
            EnumDelegate delEnumfunc = new EnumDelegate(EnumWindowsProc_MT);
            bool bSuccessful = EnumDesktopWindows(IntPtr.Zero, delEnumfunc, IntPtr.Zero);

            for (int i = 0; i < list.Count; i++)
            {
                if (list[i].Item2 == 0)
                {
                    IntPtr windowPtr = FindWindowByCaption(IntPtr.Zero, list[i].Item1);
                    SendMessage(windowPtr, WM_CLOSE, IntPtr.Zero, IntPtr.Zero);
                    numbertable = numbertable - 1;
                }
            }
            IntPtr winNews = FindWindowByCaption(IntPtr.Zero, "News");
            if (winNews != IntPtr.Zero)
            {
                SendMessage(winNews, WM_CLOSE, IntPtr.Zero, IntPtr.Zero);
            }
            IntPtr winnews = FindWindowByCaption(IntPtr.Zero, "news");
            if (winnews != IntPtr.Zero)
            {
                SendMessage(winnews, WM_CLOSE, IntPtr.Zero, IntPtr.Zero);
            }
            IntPtr winmynews = FindWindowByCaption(IntPtr.Zero, "My News");
            if (winmynews != IntPtr.Zero)
            {
                SendMessage(winmynews, WM_CLOSE, IntPtr.Zero, IntPtr.Zero);
            }
            //aqui vou abrir mesas
            selectLobby(login, downtoup, zoom);
            
        }

        private bool EnumWindowsProc_MT(IntPtr hWnd, int lParam)
        {
            string strTitle = GetWindowText(hWnd);
            if (strTitle != "" & IsWindowVisible(hWnd) && strTitle.Equals("PokerStars")) //
            {
                int ass = FindWindow(null, "PokerStars");
                if (ass > 0)
                {
                    SetForegroundWindow(ass);
                    SetActiveWindow((IntPtr)ass);
                    SendMessage(ass, WM_SYSCOMMAND, SC_CLOSE, 0);                    
                }
            }
            return true;
        }

        public void selectLobby(String login2, Boolean down, Boolean zoom)
        {
            downtoup = down;
            login = login2;
            this.zoom = zoom;
            //to activate an application
            list = new List<Tuple<String, int>>();

            //aqui para saber se tem login ou não
            if (!zoom)
            {
                if (login.Contains("Logged"))
                {
                    tablewhlogin = 19;
                }
                else
                {
                    tablewhlogin = 5;
                }

                //aqui se começa do inicio o do fim
                Byte directioninit;
                Byte directionend;

                if (downtoup)
                {
                    directioninit = VK_DOWN;
                    directionend = VK_UP;
                }
                else
                {
                    directioninit = VK_UP;
                    directionend = VK_DOWN;
                }

                Boolean first = true;
                while (numbertable < tablewhlogin)
                {
                    int hWnd = FindWindow(null, login);
                    //int hWnd = FindWindow(null, "PokerStars Lobby");
                    SetForegroundWindow(hWnd);

                    if (first)
                    {
                        //ici c'est pour remonter dans le lobby
                        for (int i = 0; i < tablewhlogin; i++)
                        {
                            keybd_event(directioninit, 0, 0, 0);
                            keybd_event(directioninit, 0, KEYEVENTF_KEYUP, 0);
                            System.Threading.Thread.Sleep(1000);
                        }
                        first = false;
                    }
                    getAllWindow();
                    if (list.Count == tablewhlogin)
                    {
                        numbertable = tablewhlogin;
                    }
                    else
                    {
                        numbertable = tablewhlogin - (tablewhlogin - list.Count);
                        keybd_event(directionend, 0, 0, 0);
                        keybd_event(directionend, 0, KEYEVENTF_KEYUP, 0);
                        keybd_event(VK_RETURN, 0, 0, 0);
                        keybd_event(VK_RETURN, 0, KEYEVENTF_KEYUP, 0);
                        System.Threading.Thread.Sleep(3500);
                    }
                    //System.Windows.Forms.MessageBox.Show(""+list.Count);

                }
                //numbertable = 19;
                getAllWindow();
                
            }
            int hWndhh = FindWindow(null, "Instant Hand History");
            //int hWndhh = FindWindow(null, "Historique instantané des mains");
            if (hWndhh > 0)
            {
                SetForegroundWindow(hWndhh);
            }
        }

    }
}