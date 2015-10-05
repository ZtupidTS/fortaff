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

namespace StopLoss
{
    public partial class FormCoolDown : Form
    {
        //databse
        SQLiteDatabase dbsqlite;
        //DataTable table;
        RatingBar[] rate;
        String[] idquestions;
        Label[] questions;
        Label[] traco;

        public FormCoolDown(SQLiteDatabase sqlite)
        {
            InitializeComponent();
            loadconfig();
            //db
            dbsqlite = sqlite;
            //load questions
            DataTable reader = dbsqlite.GetDataTable("select id, questions from questionwc where type = 'cooldown' and deleted = 0 and enabled = 1");
            if (reader.Rows.Count > 0)
            {
                rate = new RatingBar[reader.Rows.Count];
                idquestions = new String[reader.Rows.Count];
                questions = new Label[reader.Rows.Count];
                traco = new Label[reader.Rows.Count];
                int i = 0;
                foreach (DataRow row in reader.Rows)
                {
                    //rating
                    rate[i] = new RatingBar();
                    rate[i].Location = new System.Drawing.Point(900, 25 * (i + 1));
                    rate[i].Size = new System.Drawing.Size(185, 18);
                    rate[i].IconsCount = ((byte)(5));
                    //rate[i].Rate = 3;
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

        #region load and close form

        private void FormCoolDown_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_cooldown.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Close();
        }

        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_cooldown.txt";
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
            buttonSaveExit.Visible = false;            
            Dictionary<String, String> data;
            DateTime hh = DateTime.Now;
            String hhfinal = String.Format("{0:yyyy-MM-dd H:mm:ss}", hh);
            //to db
            int i = 0;
            foreach (String id in idquestions)
            {
                data = new Dictionary<String, String>();
                data.Add("datequestions", hhfinal);
                data.Add("idquestions", id.ToString());
                String temprate = rate[i].Rate.ToString();
                data.Add("rating", temprate.Replace(",", "."));
                if (!dbsqlite.Insert("cooldown", data))
                {
                    MessageBox.Show("Warmup: Error, not insert in database");
                }
                i++;
            }
            this.Close();            
        }

    }
}
