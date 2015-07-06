using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Profumi.DB;
using Profumi;

namespace Profumi
{
    public partial class Main : Form
    {
        private SQLiteDatabase db;
        
        public Main()
        {
            InitializeComponent();
            db = new SQLiteDatabase();
            DataTable dt = db.GetDataTable("select name from Users");
            foreach (DataRow row in dt.Rows) // Loop over the rows.
	        {
	            foreach (var item in row.ItemArray) // Loop over the items.
	            {
                    comboBoxLogin.Items.Add(item);
	            }
	        }            
        }

        /// <summary>
        /// Fechar a aplicação
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonClose_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        /// <summary>
        /// Verifico se a password ta certo
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonOk_Click(object sender, EventArgs e)
        {
            if (comboBoxLogin.SelectedIndex != -1)
            {
                String dt = db.ExecuteScalar("SELECT name FROM Users WHERE name = '" + comboBoxLogin.SelectedItem.ToString() + "' and password = '" + textBoxPassword.Text.ToString() + "'");
                if (dt != "")
                {
                    FormSendSMS fss = new FormSendSMS(db, this, comboBoxLogin.SelectedItem.ToString());
                    fss.Show();
                    this.Visible = false;
                }
                else
                {
                    MessageBox.Show("Palavra-passe errada");
                }
            }
            else
            {
                MessageBox.Show("Tem de seleccionar um Utilizador");
            }
        }

        /// <summary>
        /// If enter press aciona button ok.
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void textBoxPassword_KeyUp(object sender, KeyEventArgs e)
        {
            if (e.KeyValue == (char)13)
            {
                // Enter key pressed
                buttonOk_Click(sender, e);
            }
        }
    }
}
