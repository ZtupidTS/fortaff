using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Xml;
using System.IO;
using System.Xml.Serialization;
using System.Diagnostics;
using StopLoss.DB;

namespace MoneyLover
{
    public partial class FormMain : Form
    {
        private SQLiteDatabase sql;
        private String year;
        private String month;
        private Double receitas;
        private Double despesas;
        private Boolean allyear;
        
        public FormMain()
        {
            InitializeComponent();
            
            if (new Utils().dbExists())
            {
                sql = new SQLiteDatabase();
                fillCbYear();                
            }
            comboBoxMonth.Enabled = false;
        }

        private void openToolStripMenuItem_Click(object sender, EventArgs e)
        {
            openFileDialogMoneyLoverFile.FileName = "";
            openFileDialogMoneyLoverFile.ShowDialog();
            if (!openFileDialogMoneyLoverFile.FileName.Equals(""))
            {
                //copiar a DB para a pasta do soft
                if (new Utils().dbExists())
                {
                    sql = null;
                    GC.Collect();
                    GC.WaitForPendingFinalizers();
                }
                new Utils().copyFile(openFileDialogMoneyLoverFile.FileName);
                sql = new SQLiteDatabase();
            }
            fillCbYear();
        }

        private void fillCbYear()
        {
            comboBoxYear.Items.Clear();
            //encher a combo dos anos
            DataTable dt = sql.GetDataTable("select distinct strftime('%Y', display_date) as Year from transactions");
            for (int i = 0; i < dt.Rows.Count; i++)
            {
                //new Utils().alertMessage(dt.Rows[i].ItemArray[0].ToString());
                comboBoxYear.Items.Add(dt.Rows[i].ItemArray[0].ToString());
            }
        }

        private void fillCbMonth(String year)
        {
            this.year = year;
            comboBoxMonth.Items.Clear();
            //encher a combo dos anos
            DataTable dt = sql.GetDataTable("select distinct strftime('%m', display_date) as Month from transactions where strftime('%Y', display_date) = '"+year+"'");
            for (int i = 0; i < dt.Rows.Count; i++)
            {
                //new Utils().alertMessage(dt.Rows[i].ItemArray[0].ToString());

                comboBoxMonth.Items.Add(new Utils().monthIntToString(dt.Rows[i].ItemArray[0].ToString()));
            }
            comboBoxMonth.Items.Add("Ano Inteiro");
        }

        private void comboBoxYear_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (comboBoxYear.SelectedItem.ToString() != "")
            {
                fillCbMonth(comboBoxYear.SelectedItem.ToString());
                //new Utils().alertMessage(comboBoxYear.SelectedItem.ToString());
                comboBoxMonth.Enabled = true;
            }
        }

        private void comboBoxMonth_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (comboBoxMonth.SelectedItem.ToString() != "" && comboBoxMonth.SelectedItem.ToString() != "Ano Inteiro")
            {
                this.month = new Utils().monthStringToInt(comboBoxMonth.SelectedItem.ToString());

                String receit = sql.ExecuteScalar("select sum(tr.amount) from transactions tr, categories cat "
                    + "where strftime('%Y', tr.display_date) = '" + year + "' and strftime('%m', tr.display_date) = '" + month + "' and tr.cat_id = cat.cat_id and cat.cat_type = 1");
                receitas = new Utils().stringtoDouble(receit);
                labelReceitas.Text = receitas.ToString() + " €";

                String despe = sql.ExecuteScalar("select sum(tr.amount) from transactions tr, categories cat "
                    + "where strftime('%Y', tr.display_date) = '" + year + "' and strftime('%m', tr.display_date) = '" + month + "' and tr.cat_id = cat.cat_id and cat.cat_type = 2");
                despesas = new Utils().stringtoDouble(despe);
                labelDespesas.Text = despesas.ToString() + " €";

                totalCount(Math.Round(receitas - despesas, 2));

                //agora preencher o datgagridview
                fillDgvAll(false);
                allyear = false;
            }
            else
            {
                String receit = sql.ExecuteScalar("select sum(tr.amount) from transactions tr, categories cat "
                    + "where strftime('%Y', tr.display_date) = '" + year + "' and tr.cat_id = cat.cat_id and cat.cat_type = 1");
                receitas = new Utils().stringtoDouble(receit);
                labelReceitas.Text = receitas.ToString() + " €";

                String despe = sql.ExecuteScalar("select sum(tr.amount) from transactions tr, categories cat "
                    + "where strftime('%Y', tr.display_date) = '" + year + "' and tr.cat_id = cat.cat_id and cat.cat_type = 2");
                despesas = new Utils().stringtoDouble(despe);
                labelDespesas.Text = despesas.ToString() + " €";

                totalCount(Math.Round(receitas - despesas, 2));

                //agora preencher o datgagridview
                fillDgvAll(true);
                allyear = true;
            }
        }

        private void totalCount(Double total)
        {
            labelTotal.Text = total.ToString() + " €";
            if (total < 0)
            {
                labelTotal.ForeColor = Color.Red;
            }
            else
            {
                labelTotal.ForeColor = Color.Green;
            }
        }

        private void fillDgvAll(Boolean anointeiro)
        {
            DataTable dt;
            
            if (anointeiro)
            {
                dt = sql.GetDataTable("select cat.cat_name as Nome, round(sum(tr.amount),2) as 'Valor €', cat.cat_type, cat.cat_id from transactions tr, categories cat "
                + "where strftime('%Y', tr.display_date) = '" + year + "' and tr.cat_id = cat.cat_id group by cat.cat_id");
            }
            else
            {
                dt = sql.GetDataTable("select cat.cat_name as Nome, round(sum(tr.amount),2) as 'Valor €', cat.cat_type, cat.cat_id from transactions tr, categories cat "
                + "where strftime('%Y', tr.display_date) = '" + year + "' and strftime('%m', tr.display_date) = '" + month + "' and tr.cat_id = cat.cat_id group by cat.cat_id");
            }
            
            dataGridViewAll.AllowUserToAddRows = false;
            dataGridViewAll.AllowUserToDeleteRows = false;
            dataGridViewAll.ReadOnly = true;
            dataGridViewAll.DataSource = dt;
            dataGridViewAll.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.AllCells;
            dataGridViewAll.Columns[2].Visible = false;
            dataGridViewAll.Columns[3].Visible = false;
            dataGridViewAll.Sort(dataGridViewAll.Columns[1], ListSortDirection.Descending);
            //por a cor verde ou vermelho
            colorDgv(dataGridViewAll);
            dataGridViewAll.Refresh();
        }

        private void dataGridViewAll_Click(object sender, EventArgs e)
        {
            int row = dataGridViewAll.CurrentCell.RowIndex;
            int colum = dataGridViewAll.CurrentCell.ColumnIndex;

            String sel = dataGridViewAll.Rows[row].Cells[3].Value.ToString();

            DataTable dt;

            if (allyear)
            {
                dt = sql.GetDataTable("select tr.note as Nome, round(sum(tr.amount),2) as 'Valor €', tr.display_date as Data from transactions tr, categories cat "
                    + "where strftime('%Y', tr.display_date) = '" + year + "' and"
                    + " tr.cat_id = cat.cat_id and cat.cat_id = '" + sel + "' group by tr.note");
            }
            else
            {
                dt = sql.GetDataTable("select tr.note as Nome, round(sum(tr.amount),2) as 'Valor €', tr.display_date as Data from transactions tr, categories cat "
                    + "where strftime('%Y', tr.display_date) = '" + year + "' and strftime('%m', tr.display_date) = '" + month + "' and"
                    + " tr.cat_id = cat.cat_id and cat.cat_id = '" + sel + "' group by tr.note");
            }

            dataGridViewSelection.AllowUserToAddRows = false;
            dataGridViewSelection.AllowUserToDeleteRows = false;
            dataGridViewSelection.ReadOnly = true;
            dataGridViewSelection.DataSource = dt;
            dataGridViewSelection.Sort(dataGridViewSelection.Columns[1], ListSortDirection.Descending);
            dataGridViewSelection.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.AllCells;
            dataGridViewSelection.Refresh();
        }

        private void dataGridViewAll_Sorted(object sender, EventArgs e)
        {
            colorDgv(dataGridViewAll);
        }

        private void colorDgv(DataGridView dgv)
        {
            foreach (DataGridViewRow row in dgv.Rows)
            {
                //currQty += row.Cells["qty"].Value;
                if (row.Cells[2].Value.ToString() == "1")
                {
                    row.DefaultCellStyle.ForeColor = Color.Green;
                }
                else
                {
                    row.DefaultCellStyle.ForeColor = Color.Red;
                }
                dataGridViewAll.Refresh();
            }
        }

    }


}
