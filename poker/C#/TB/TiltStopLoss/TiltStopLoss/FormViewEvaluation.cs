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
    public partial class FormViewEvaluation : Form
    {
        //db
        private SQLiteDatabase dbsqlite;
        
        public FormViewEvaluation(SQLiteDatabase db)
        {
            InitializeComponent();
            loadconfig();
            dbsqlite = db;
            //datetimepicker
            dateTimePickerStart.Value = DateTime.Now;
            dateTimePickerEnd.Value = DateTime.Now;
            labelEvaPhysical.Text = "--%";
            labelEvaMental.Text = "--%";
            labelEvaTechnical.Text = "--%";
            labelEvaPractive.Text = "--%";
        }

        private void ChangeEva(String start, String end)
        {
            //physical
            String value = dbsqlite.ExecuteScalar("select round((CAST(sum (questionsdone) AS REAL ) / sum (questionstotal)), 2) from warmup where subtype = 'physical' and datequestions >= '" + start + "' and datequestions <= '" + end + "'");
            if (value == "")
            {
                labelEvaPhysical.Text = "--%";
            }
            else
            {
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
            //mental
            value = dbsqlite.ExecuteScalar("select round((CAST(sum (questionsdone) AS REAL ) / sum (questionstotal)), 2) from warmup where subtype = 'mental' and datequestions >= '" + start + "' and datequestions <= '" + end + "'");
            if (value == "")
            {
                labelEvaMental.Text = "--%";
            }
            else
            {
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
            //technical
            value = dbsqlite.ExecuteScalar("select round((CAST(sum (questionsdone) AS REAL ) / sum (questionstotal)), 2) from warmup where subtype = 'technical' and datequestions >= '" + start + "' and datequestions <= '" + end + "'");
            if (value == "")
            {
                labelEvaTechnical.Text = "--%";
            }
            else
            {
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
            //practice
            value = dbsqlite.ExecuteScalar("select round((CAST(sum (questionsdone) AS REAL ) / sum (questionstotal)), 2) from warmup where subtype = 'practice' and datequestions >= '" + start + "' and datequestions <= '" + end + "'");
            if (value == "")
            {
                labelEvaPractive.Text = "--%";
            }
            else
            {
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
        }

        #region load and close form

        private void FormEvaluation_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_viewevaluation.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Close();
        }

        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_viewevaluation.txt";
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

        private void buttonSearch_Click(object sender, EventArgs e)
        {
            String datestart = String.Format("{0:yyyy-MM-dd HH:mm:ss}", dateTimePickerStart.Value);
            String dateend = String.Format("{0:yyyy-MM-dd H:mm:ss}", dateTimePickerEnd.Value);
            ChangeEva(datestart, dateend);
        }
    }
}
