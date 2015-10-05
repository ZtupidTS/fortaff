using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using TiltStopLoss;


namespace StopLoss
{
    public partial class FormInit : Form
    {
        private Main wmain;
        
        public FormInit(Main wmain)
        {
            InitializeComponent();
            this.wmain = wmain;
            this.StartPosition = FormStartPosition.CenterScreen;
            comboBoxLanguage.SelectedIndex = 0;
        }

        private void buttonOk_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void FormInit_FormClosed(object sender, FormClosedEventArgs e)
        {
            wmain.SelectLanguage(comboBoxLanguage.SelectedIndex);
            //wmain.Visible = true;
        }
    }
}
