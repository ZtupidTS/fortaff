using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Profumi.DB;

namespace Profumi
{
    public partial class FormHistory : Form
    {
        private BindingSource bindingSource1 = new BindingSource();
        private SQLiteDatabase db;
        private DataTable dt;
        
        public FormHistory(SQLiteDatabase dbmain)
        {
            InitializeComponent();
            db = dbmain;
        }

        private void buttonClose_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void FormHistory_Load(object sender, EventArgs e)
        {
            dt = db.GetDataTable("select * from sms order by sms_contact");
            bindingSource1.DataSource = dt;
            dataGridViewSms.DataSource = bindingSource1;
            setDgv();
        }

        private void textBoxSearch_TextChanged(object sender, EventArgs e)
        {
            dt = db.GetDataTable("select * from sms where sms_contact LIKE '%"+textBoxSearch.Text.ToString()+"%' order by sms_date desc");
            bindingSource1.DataSource = dt;
            dataGridViewSms.DataSource = bindingSource1;
            setDgv();
        }

        private void setDgv()
        {
            //renomear as colunas
            dataGridViewSms.Columns["result"].HeaderText = "Resultado Envio";
            dataGridViewSms.Columns["smsid"].HeaderText = "SMS id";
            dataGridViewSms.Columns["smsinserted"].HeaderText = "Qtd Inserida";
            dataGridViewSms.Columns["user_name"].HeaderText = "Nome Utilizador";
            dataGridViewSms.Columns["sms_state"].HeaderText = "Estado";
            dataGridViewSms.Columns["sms_date"].HeaderText = "Data";
            dataGridViewSms.Columns["sms_contact"].HeaderText = "Contacto";
            dataGridViewSms.Columns["sms_text"].HeaderText = "SMS Texto";
            //resize colunas
            dataGridViewSms.AutoResizeColumns();
            dataGridViewSms.AutoResizeRows();
            dataGridViewSms.Columns[0].Width = 1;
            //reorganizar e desaparecer colunas
            dataGridViewSms.Columns["id"].Visible = false;
            dataGridViewSms.Columns["result"].Visible = false;
            dataGridViewSms.Columns["smsid"].Visible = false;
            dataGridViewSms.Columns["smsinserted"].Visible = false;
            dataGridViewSms.Columns["user_name"].DisplayIndex = 4;
            dataGridViewSms.Columns["sms_state"].DisplayIndex = 2;
            dataGridViewSms.Columns["sms_date"].DisplayIndex = 3;
            dataGridViewSms.Columns["sms_contact"].DisplayIndex = 0;
            dataGridViewSms.Columns["sms_text"].DisplayIndex = 1;
            //order by
            //dataGridViewSms.Sort(dataGridViewSms.Columns["sms_date"], ListSortDirection.Descending);
            
        }

    }
}
