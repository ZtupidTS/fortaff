using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using StopLoss.DB;
using System.Data.SQLite;
using System.IO;

namespace StopLoss
{
    public partial class FormWarmup : Form
    {
        //db
        private SQLiteDatabase dbsqlite;
        DataTable table = new DataTable();
        //boolean
        private Boolean havequestions = false;
        //variable
        String timephysical = "";
        String timemental = "";
        String timetechnical = "";
        String timepractice = "";
        
        public FormWarmup(SQLiteDatabase db)
        {
            InitializeComponent();
            dbsqlite = db;
            loadconfig();
            //load from DB
            LoadPhysical();            
        }

        #region load questions to dgv

        /// <summary>
        /// load questions physical
        /// </summary>
        private void LoadPhysical()
        {
            //label
            labelTitle.Text = "Physical";
            ///physical
            //SQLiteDataReader reader = dbsqlite.GetDataReaderTable("select questions from questionwc where type = 'warmup' and subtype = 'physical' and deleted = 0 and enabled = 1");
            DataTable reader = dbsqlite.GetDataTable("select questions from questionwc where type = 'warmup' and subtype = 'physical' and deleted = 0 and enabled = 1");
            //if (reader.HasRows)
            if(reader.Rows.Count > 0)
            {
                LoadDgv(reader);
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                havequestions = true;
            }
            else
            {
                //vou ao proximo
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                LoadMental();                
            }
        }

        /// <summary>
        /// load questions mental
        /// </summary>
        private void LoadMental()
        {
            //label
            labelTitle.Text = "Mental";
            ///physical
            DataTable reader = dbsqlite.GetDataTable("select questions from questionwc where type = 'warmup' and subtype = 'mental' and deleted = 0 and enabled = 1");
            if (reader.Rows.Count > 0)
            {
                LoadDgv(reader);
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                havequestions = true;
            }
            else
            {
                //vou ao proximo
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                LoadTecnhical();                
            }
        }

        /// <summary>
        /// load questions Tecnhical
        /// </summary>
        private void LoadTecnhical()
        {
            //label
            labelTitle.Text = "Tecnhical";
            ///physical
            DataTable reader = dbsqlite.GetDataTable("select questions from questionwc where type = 'warmup' and subtype = 'technical' and deleted = 0 and enabled = 1");
            if (reader.Rows.Count > 0)
            {
                LoadDgv(reader);
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                havequestions = true;
            }
            else
            {
                //vou ao proximo
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                LoadPractice();
            }
        }

        /// <summary>
        /// load questions practice
        /// </summary>
        private void LoadPractice()
        {
            //label
            labelTitle.Text = "Practice";
            ///physical
            DataTable reader = dbsqlite.GetDataTable("select questions from questionwc where type = 'warmup' and subtype = 'practice' and deleted = 0 and enabled = 1");
            if (reader.Rows.Count > 0)
            {
                LoadDgv(reader);
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                havequestions = true;
            }
            else
            {
                //aqui fecho o form 
                //reader.Close();
                //dbsqlite.CloseCnnmeu();
                ToNoteWarmup();
            }
        }

        /// <summary>
        /// load dgv
        /// </summary>
        /// <param name="reader"></param>
        //private void LoadDgv(SQLiteDataReader reader)
        private void LoadDgv(DataTable reader)
        {
            table = reader;
            //dataGridViewWarmup.Rows.Clear();
            //config dgv
            //table.Columns.Add("Questions", typeof(String));
            table.Columns.Add("Done", typeof(Boolean));
            //load dgv
            //table.Load(reader);
            //reader.Close();
            bindingSourceWarmup.DataSource = table;
            dataGridViewWarmup.DataSource = bindingSourceWarmup;
            //config dgv
            dataGridViewWarmup.AutoResizeColumns();
            dataGridViewWarmup.AutoResizeRows();
            dataGridViewWarmup.Columns[0].Width = 915;
            dataGridViewWarmup.Columns[0].HeaderCell.Style.Alignment = DataGridViewContentAlignment.TopCenter;
            dataGridViewWarmup.Columns[1].HeaderCell.Style.Alignment = DataGridViewContentAlignment.TopCenter;
        }

        #endregion

        #region load and close form

        private void FormWarmup_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_warmup.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Close();
        }

        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_warmup.txt";
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

        /// <summary>
        /// button next
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonNext_Click(object sender, EventArgs e)
        {
            Dictionary<String, String> data;
            DateTime hh = DateTime.Now;
            String hhfinal = String.Format("{0:yyyy-MM-dd HH:mm:ss}", hh);
            //aqui tenho que guardar e já que tenho o switch aproveitar            
            switch (labelTitle.Text)
            {
                case "Physical":
                    //to db
                    data = new Dictionary<String, String>();
                    data.Add("subtype", "physical");
                    data.Add("datequestions", hhfinal);
                    data.Add("questionsdone", getDoneQuestions());
                    data.Add("questionstotal", dataGridViewWarmup.Rows.Count.ToString());
                    if(!dbsqlite.Insert("warmup", data))
                    {
                        MessageBox.Show("Warmup: Error, not insert in database");
                    }
                    timephysical = hhfinal;
                    //next
                    LoadMental();
                    break;
                case "Mental":
                    //to db
                    data = new Dictionary<String, String>();
                    data.Add("subtype", "mental");
                    data.Add("datequestions", hhfinal);
                    data.Add("questionsdone", getDoneQuestions());
                    data.Add("questionstotal", dataGridViewWarmup.Rows.Count.ToString());
                    if (!dbsqlite.Insert("warmup", data))
                    {
                        MessageBox.Show("Warmup: Error, not insert in database");
                    }
                    timemental = hhfinal;
                    LoadTecnhical();
                    break;
                case "Tecnhical":
                    //to db
                    data = new Dictionary<String, String>();
                    data.Add("subtype", "technical");
                    data.Add("datequestions", hhfinal);
                    data.Add("questionsdone", getDoneQuestions());
                    data.Add("questionstotal", dataGridViewWarmup.Rows.Count.ToString());
                    if (!dbsqlite.Insert("warmup", data))
                    {
                        MessageBox.Show("Warmup: Error, not insert in database");
                    }
                    timetechnical = hhfinal;
                    LoadPractice();
                    break;
                case "Practice":
                    //to db
                    data = new Dictionary<String, String>();
                    data.Add("subtype", "practice");
                    data.Add("datequestions", hhfinal);
                    data.Add("questionsdone", getDoneQuestions());
                    data.Add("questionstotal", dataGridViewWarmup.Rows.Count.ToString());
                    if (!dbsqlite.Insert("warmup", data))
                    {
                        MessageBox.Show("Warmup: Error, not insert in database");
                    }
                    timepractice = hhfinal;
                    ToNoteWarmup();
                    break;
                default:
                    if (!havequestions)
                    {
                        MessageBox.Show("You haven't configure warmup");
                    }
                    this.Close();
                    break;
            }
        }

        /// <summary>
        /// return done questions
        /// </summary>
        /// <returns></returns>
        private String getDoneQuestions()
        {
            int donequestions = 0;
            foreach (DataGridViewRow row in dataGridViewWarmup.Rows)
            {
                if (row.Cells[1].Value.ToString() == "True")
                {
                    donequestions++;
                }
            }
            return donequestions.ToString();
        }

        /// <summary>
        /// go to form evaluations
        /// </summary>
        private void ToNoteWarmup()
        {
            if (!havequestions)
            {
                MessageBox.Show("You haven't configure warmup");
            }
            else
            {
                String[] time = { timephysical, timemental, timetechnical, timepractice };
                FormEvaluation fe = new FormEvaluation(dbsqlite, time);
                fe.Show();
                this.Close();
            }
        }

    }
}