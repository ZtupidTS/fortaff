using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using TiltStopLoss;
using System.IO;

namespace StopLoss
{
    public partial class FormSet : Form
    {
        private Stoploss sl;
        
        public FormSet(Stoploss formsl, Double loss, Int64 hand, Int32 time, Double win, Double losspeak, Double peakover, Boolean hidebb, Double wininter, Double lossinter)
        {
            InitializeComponent();
            sl = formsl;
            textBoxStopHand.Text = hand.ToString();
            textBoxStopLoss.Text = loss.ToString();
            textBoxStopTime.Text = time.ToString();
            textBoxStopWin.Text = win.ToString();
            textBoxStopLossPeak.Text = losspeak.ToString();
            textBoxPeakOver.Text = peakover.ToString();
            textBoxStopLossIntermediate.Text = lossinter.ToString();
            textBoxStopWinIntermediate.Text = wininter.ToString();
            if (hidebb)
            {
                checkBoxHideBbbs.Checked = true;
            }
            else
            {
                checkBoxHideBbbs.Checked = false;
            }
            loadconfig();
        }

        #region only numeric on textbox

        private void textBoxStopLoss_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        private void textBoxStopHand_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        private void textBoxStopTime_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        private void textBoxStopWin_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        private void textBoxStopLossPeak_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        private void textBoxPeakOver_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        private void textBoxStopLossIntermediate_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        private void textBoxStopWinIntermediate_KeyPress(object sender, KeyPressEventArgs e)
        {
            new Utils().onlynumeric(e);
        }

        #endregion

        /// <summary>
        /// Ao clicar no botão ok mando a informação para o form stoploss
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonOk_Click(object sender, EventArgs e)
        {
            Int64 hand = new Utils().stringtoInt64(textBoxStopHand.Text);
            Double loss = new Utils().stringtoDouble(textBoxStopLoss.Text);
            Int32 time = new Utils().stringtoInt32(textBoxStopTime.Text);
            Double win = new Utils().stringtoDouble(textBoxStopWin.Text);
            Double losspeak = new Utils().stringtoDouble(textBoxStopLossPeak.Text);
            Double peakover = new Utils().stringtoDouble(textBoxPeakOver.Text);
            Double wininter = new Utils().stringtoDouble(textBoxStopWinIntermediate.Text);
            Double lossinter = new Utils().stringtoDouble(textBoxStopLossIntermediate.Text);
            Boolean continu = true;
            if (wininter >= win && wininter != 0)
            {
                labelAlertIntermediate.Text = "Stopwin intermediate don't superior at stopwin final";
                continu = false;
            }
            if (lossinter >= loss && lossinter != 0 && continu)
            {
                labelAlertIntermediate.Text = "StopLoss intermediate don't superior at stopLoss final";
                continu = false;
            }
            if(continu)
            {
                sl.setNewValue(hand, loss, time, win, losspeak, peakover, checkBoxHideBbbs.Checked, wininter, lossinter);
                this.Close();
            }
        }

        #region load config
        /// <summary>
        /// Permite guardar as configurações da janela
        /// </summary>
        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_setnewvalue.txt";
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
            }
        }

        private void FormSet_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_setnewvalue.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Close();
        }
        #endregion

        
    }
}
