using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Collections;
using System.Globalization;
using System.Runtime.InteropServices;


namespace PS
{
    class RecupClipboard
    {
        AppendToFile file = new AppendToFile();
        String oldcopyhand = "";
        String newcopyhand = "";
        ArrayList handarray = new ArrayList();
        ArrayList tablearray = new ArrayList();
        OperationWindow ow;

        public void getClipboard(OperationWindow ow2, Boolean down, Boolean zoom, String vm, String drive)
        {
            ow = ow2;
            newcopyhand = GetText();
            if (newcopyhand != oldcopyhand)
            {
                if(newcopyhand.StartsWith("PokerStars Hand #") && !newcopyhand.Contains("hulkric59"))
                {
                    String can = "cancelled";
                    if (!newcopyhand.ToLower().Contains(can.ToLower()))
                    {
                        if (!handarray.Contains(newcopyhand))
                        {
                            handarray.Add(newcopyhand);
                            String date = getDate();
                            file.AppendToFileDT(newcopyhand, date, down, zoom, vm, drive);
                            ow.addToList(newcopyhand, false);
                            oldcopyhand = newcopyhand;
                        }
                    }
                }
            }
        }

        public String getDate()
        {
            return DateTime.Now.ToString("yyyy_M_d");
        }

        [DllImport("user32.dll")]
        static extern IntPtr GetClipboardData(uint uFormat);
        [DllImport("user32.dll")]
        static extern bool IsClipboardFormatAvailable(uint format);
        [DllImport("user32.dll", SetLastError = true)]
        static extern bool OpenClipboard(IntPtr hWndNewOwner);
        [DllImport("user32.dll", SetLastError = true)]
        static extern bool CloseClipboard();
        [DllImport("kernel32.dll")]
        static extern IntPtr GlobalLock(IntPtr hMem);
        [DllImport("kernel32.dll")]
        static extern bool GlobalUnlock(IntPtr hMem);

        const uint CF_UNICODETEXT = 13;

        public static string GetText()
        {
            if (!IsClipboardFormatAvailable(CF_UNICODETEXT))
                return null;
            if (!OpenClipboard(IntPtr.Zero))
                return null;

            string data = null;
            var hGlobal = GetClipboardData(CF_UNICODETEXT);
            if (hGlobal != IntPtr.Zero)
            {
                var lpwcstr = GlobalLock(hGlobal);
                if (lpwcstr != IntPtr.Zero)
                {
                    data = Marshal.PtrToStringUni(lpwcstr);
                    GlobalUnlock(lpwcstr);
                }
            }
            CloseClipboard();

            return data;
        }

    }
}
