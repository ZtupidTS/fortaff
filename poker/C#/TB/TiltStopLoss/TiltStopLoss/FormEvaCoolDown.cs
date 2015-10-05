using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using RatingControls;
using System.IO;
using StopLoss.DB;
using XSystem.WinControls;
using TiltStopLoss;

namespace StopLoss
{
    public partial class FormEvaCoolDown : Form
    {
        //databse
        SQLiteDatabase dbsqlite;
        //DataTable table;
        RatingBar[] rate;
        String[] idquestions;
        Label[] questions;
        Label[] traco;

        public FormEvaCoolDown(SQLiteDatabase sqlite)
        {
            InitializeComponent();
            loadconfig();
            //db
            dbsqlite = sqlite;
            //datetimepicker
            dateTimePickerStart.Value = DateTime.Now;
            dateTimePickerEnd.Value = DateTime.Now;
            //load questions
            DataTable reader = dbsqlite.GetDataTable("select cd.idquestions, qwc.questions, qwc.id, round((SUM(cd.rating) / count(qwc.id)),2) AS median from cooldown cd, questionwc qwc where cd.idquestions = qwc.id group by qwc.id");
            LoadPanel(reader);
        }

        #region load and close form

        private void FormCoolDown_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_evacooldown.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Close();
        }

        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_evacooldown.txt";
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
                default:
                    break;
            }
        }

        #endregion

        private void buttonSaveExit_Click(object sender, EventArgs e)
        {
            this.Close();            
        }

        private float getRating(String median)
        {
            Double rate = new Utils().stringtoDouble(median);
            
            if (rate <= 0.3)
                return 0.0f;
                
            if (rate > 0.3 && rate <= 0.6)
                return 0.5f;
                
            if (rate > 0.6 && rate <= 1.3)
                return 1.0f;
                
            if (rate > 1.3 && rate <= 1.7)
                return 1.5f;
                
            if (rate > 1.7 && rate <= 2.3)
                return 2.0f;
                
            if (rate > 2.3 && rate <= 2.6)
                return 2.5f;
                
            if (rate > 2.6 && rate <= 3.3)
                return 3.0f;
                
            if (rate > 3.3 && rate <= 3.6)
                return 3.5f;
                
            if (rate > 3.6 && rate <= 4.3)
                return 4.0f;
                
            if (rate > 4.3 && rate <= 4.6)
                return 4.5f;
                
            return 5.0f;
        }

        private void LoadPanel(DataTable dt)
        {
            if (dt.Rows.Count > 0)
            {
                rate = new RatingBar[dt.Rows.Count];
                idquestions = new String[dt.Rows.Count];
                questions = new Label[dt.Rows.Count];
                traco = new Label[dt.Rows.Count];
                int i = 0;
                foreach (DataRow row in dt.Rows)
                {
                    //rating
                    rate[i] = new RatingBar();
                    rate[i].Location = new System.Drawing.Point(900, 25 * (i + 1));
                    rate[i].Size = new System.Drawing.Size(185, 18);
                    rate[i].IconsCount = ((byte)(5));
                    rate[i].Rate = getRating(row.ItemArray[3].ToString());
                    rate[i].Enabled = false;
                    panelQuestions.Controls.Add(rate[i]);
                    //id
                    idquestions[i] = row.ItemArray[0].ToString();
                    //questions
                    questions[i] = new Label();
                    questions[i].Text = row.ItemArray[1].ToString();
                    questions[i].Font = new System.Drawing.Font("Microsoft Sans Serif", 10);
                    questions[i].Location = new System.Drawing.Point(20, 25 * (i + 1));
                    questions[i].Size = new System.Drawing.Size(800, 18);
                    panelQuestions.Controls.Add(questions[i]);
                    //traço
                    traco[i] = new Label();
                    traco[i].Text = "___________________________________________________________________________________________________________________________________________________________________________";
                    traco[i].Location = new System.Drawing.Point(20, 25 * (i + 1) + 7);
                    traco[i].Size = new System.Drawing.Size(940, 21);
                    panelQuestions.Controls.Add(traco[i]);
                    i++;
                }
            }
        }

        private void buttonSearch_Click(object sender, EventArgs e)
        {
            String datestart = String.Format("{0:yyyy-MM-dd HH:mm:ss}", dateTimePickerStart.Value);
            String dateend = String.Format("{0:yyyy-MM-dd H:mm:ss}", dateTimePickerEnd.Value);
            DataTable reader = dbsqlite.GetDataTable("select cd.idquestions, qwc.questions, qwc.id, round((SUM(cd.rating) / count(qwc.id)),2) AS median from cooldown cd, questionwc qwc where cd.idquestions = qwc.id and cd.datequestions >= '" + datestart + "' and cd.datequestions <= '"+ dateend +"' group by qwc.id");
            int i = 0;
            foreach (RatingBar rt in rate)
            {
                panelQuestions.Controls.Remove(rt);
                panelQuestions.Controls.Remove(questions[i]);
                panelQuestions.Controls.Remove(traco[i]);
                i++;
            }
            LoadPanel(reader);
        }

    }
}
