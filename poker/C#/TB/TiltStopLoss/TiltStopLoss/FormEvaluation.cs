using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using StopLoss.DB;
using TiltStopLoss;

namespace StopLoss
{
    public partial class FormEvaluation : Form
    {
        //db
        private SQLiteDatabase dbsqlite;
        //variable
        private String[] timesql;
        
        public FormEvaluation(SQLiteDatabase db, String[] time)
        {
            InitializeComponent();
            loadconfig();
            dbsqlite = db;
            timesql = time;
            //physical
            if (time[0] != "")
            {
                String value = dbsqlite.ExecuteScalar("select CAST(questionsdone AS REAL) / questionstotal from warmup where subtype = 'physical' and datequestions = '" + time[0] + "'");
                Double evaphysical = new Utils().stringtoDouble(value) * 100;
                labelEvaPhysical.Text = evaphysical.ToString() + "%";
                if (evaphysical <= 50)
                {
                    labelEvaPhysical.ForeColor = Color.Red;
                }
                else
                {
                    if (evaphysical > 50 && evaphysical < 75)
                    {
                        labelEvaPhysical.ForeColor = Color.Orange;
                    }
                    else
                    {
                        labelEvaPhysical.ForeColor = Color.Green;
                    }
                }
            }
            else
            {
                labelEvaPhysical.Text = "--%";
            }
            //mental
            if (time[1] != "")
            {
                String value = dbsqlite.ExecuteScalar("select CAST(questionsdone AS REAL) / questionstotal from warmup where subtype = 'mental' and datequestions = '" + time[1] + "'");
                Double evaphysical = new Utils().stringtoDouble(value) * 100;
                labelEvaMental.Text = evaphysical.ToString() + "%";
                if (evaphysical <= 50)
                {
                    labelEvaMental.ForeColor = Color.Red;
                }
                else
                {
                    if (evaphysical > 50 && evaphysical < 75)
                    {
                        labelEvaMental.ForeColor = Color.Orange;
                    }
                    else
                    {
                        labelEvaMental.ForeColor = Color.Green;
                    }
                }
            }
            else
            {
                labelEvaMental.Text = "--%";
            }
            //technical
            if (time[2] != "")
            {
                String value = dbsqlite.ExecuteScalar("select CAST(questionsdone AS REAL) / questionstotal from warmup where subtype = 'technical' and datequestions = '" + time[2] + "'");
                Double evaphysical = new Utils().stringtoDouble(value) * 100;
                labelEvaTechnical.Text = evaphysical.ToString() + "%";
                if (evaphysical <= 50)
                {
                    labelEvaTechnical.ForeColor = Color.Red;
                }
                else
                {
                    if (evaphysical > 50 && evaphysical < 75)
                    {
                        labelEvaTechnical.ForeColor = Color.Orange;
                    }
                    else
                    {
                        labelEvaTechnical.ForeColor = Color.Green;
                    }
                }
            }
            else
            {
                labelEvaTechnical.Text = "--%";
            }
            //practice
            if (time[3] != "")
            {
                String value = dbsqlite.ExecuteScalar("select CAST(questionsdone AS REAL) / questionstotal from warmup where subtype = 'practice' and datequestions = '" + time[3] + "'");
                Double evaphysical = new Utils().stringtoDouble(value) * 100;
                labelEvaPractive.Text = evaphysical.ToString() + "%";
                if (evaphysical <= 50)
                {
                    labelEvaPractive.ForeColor = Color.Red;
                }
                else
                {
                    if (evaphysical > 50 && evaphysical < 75)
                    {
                        labelEvaPractive.ForeColor = Color.Orange;
                    }
                    else
                    {
                        labelEvaPractive.ForeColor = Color.Green;
                    }
                }
            }
            else
            {
                labelEvaPractive.Text = "--%";
            }

        }

        #region load and close form

        private void FormEvaluation_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_evaluation.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Close();
        }

        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_evaluation.txt";
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
    }
}
