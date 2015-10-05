using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using StopLoss.DB;
using System.IO;
using System.Runtime.InteropServices;
using TiltStopLoss;

namespace StopLoss
{
    public partial class FormWCConfig : Form
    {
        //crio vario textbox
        private TextBox[] tboxphysical = new TextBox[0];
        private TextBox[] tboxmental = new TextBox[0];
        private TextBox[] tboxtechnical = new TextBox[0];
        private TextBox[] tboxpractice = new TextBox[0];
        private TextBox[] tboxcooldown = new TextBox[0];
        private CheckBox[] checkphysical = new CheckBox[0];
        private CheckBox[] checkmental = new CheckBox[0];
        private CheckBox[] checktechnical = new CheckBox[0];
        private CheckBox[] checkpractice = new CheckBox[0];
        private CheckBox[] checkcooldown = new CheckBox[0];
        private Int32[] idphysical = new Int32[0];
        private Int32[] idmental = new Int32[0];
        private Int32[] idtechnical = new Int32[0];
        private Int32[] idpractice = new Int32[0];
        private Int32[] idcooldown = new Int32[0];
        //databse
        SQLiteDatabase dbsqlite;
        //boolean
        Boolean resultinsert = true;
        
        public FormWCConfig(SQLiteDatabase sqlite)
        {
            InitializeComponent();
            dbsqlite = sqlite;
            loadconfig();
            //faz o load da base dados
            LoadQuestions();
        }
        
        #region button create more questions

        /// <summary>
        /// Create more questions
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonQuestionPhysical_Click(object sender, EventArgs e)
        {
            //textbox
            createQuestions("physical", tboxphysical, tabPagePhysical, checkphysical, idphysical); 
           
        }

        private void buttonQuestionMental_Click(object sender, EventArgs e)
        {
            createQuestions("mental", tboxmental, tabPageMental, checkmental, idmental);            
        }

        private void buttonQuestionTechnical_Click(object sender, EventArgs e)
        {
            createQuestions("technical", tboxtechnical, tabPageTechnical, checktechnical, idtechnical);
        }

        private void buttonQuestionPractice_Click(object sender, EventArgs e)
        {
            createQuestions("practice", tboxpractice, tabPagePractice, checkpractice, idpractice);
        }

        private void buttonQuestionCooldown_Click(object sender, EventArgs e)
        {
            createQuestions("cooldown", tboxcooldown, tabPageCooldown, checkcooldown, idcooldown);
        }

        #endregion

        #region Save and close the questions

        private void buttonSave_Click(object sender, EventArgs e)
        {
            SaveAll();
        }

        private void SaveAll()
        {
            //para que o user não carrega muitas vezes
            buttonClose.Visible = false;
            buttonSave.Visible = false;
            buttonSaveExit.Visible = false;
            //tenho que ir a todos o separadores, para isso guardar na DB os array
            int i = 0;
            Dictionary<String, String> data;
            //physical
            foreach (TextBox tb in tboxphysical)
            {
                if (tb.Text != "")
                {
                    if (i <= (idphysical.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "physical");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkphysical[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idphysical[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                    }
                    else
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "physical");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkphysical[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Insert("questionwc", data);
                        String lastid = dbsqlite.ExecuteScalar("select max(id) from questionwc");
                        //add in checkbox
                        Array.Resize(ref idphysical, idphysical.Length + 1);
                        int j = idphysical.Length - 1;
                        idphysical[j] = new Utils().stringtoInt32(lastid);
                        if (!results && resultinsert) resultinsert = false;
                    }
                }
                else
                {
                    if (i <= (idphysical.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("deleted", "1");
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idphysical[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                        tb.Visible = false;
                        checkphysical[i].Visible = false;
                    }
                }
                i++;
            }
            //mental
            i = 0;
            foreach (TextBox tb in tboxmental)
            {
                if (tb.Text != "")
                {
                    if (i <= (idmental.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "mental");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkmental[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idmental[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                    }
                    else
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "mental");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkmental[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Insert("questionwc", data);
                        String lastid = dbsqlite.ExecuteScalar("select max(id) from questionwc");
                        //add in checkbox
                        Array.Resize(ref idmental, idmental.Length + 1);
                        int j = idmental.Length - 1;
                        idmental[j] = new Utils().stringtoInt32(lastid);
                        if (!results && resultinsert) resultinsert = false;
                    }
                }
                else
                {
                    if (i <= (idmental.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("deleted", "1");
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idmental[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                        tb.Visible = false;
                        checkmental[i].Visible = false;
                    }
                }
                i++;
            }
            //tecnhical
            i = 0;
            foreach (TextBox tb in tboxtechnical)
            {
                if (tb.Text != "")
                {
                    if (i <= (idtechnical.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "technical");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checktechnical[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idtechnical[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                    }
                    else
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "technical");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checktechnical[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Insert("questionwc", data);
                        String lastid = dbsqlite.ExecuteScalar("select max(id) from questionwc");
                        //add in checkbox
                        Array.Resize(ref idtechnical, idtechnical.Length + 1);
                        int j = idtechnical.Length - 1;
                        idtechnical[j] = new Utils().stringtoInt32(lastid);
                        if (!results && resultinsert) resultinsert = false;
                    }
                }
                else
                {
                    if (i <= (idtechnical.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("deleted", "1");
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idtechnical[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                        tb.Visible = false;
                        checktechnical[i].Visible = false;
                    }
                }
                i++;
            }
            //practice
            i = 0;
            foreach (TextBox tb in tboxpractice)
            {
                if (tb.Text != "")
                {
                    if (i <= (idpractice.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "practice");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkpractice[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idpractice[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                    }
                    else
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "warmup");
                        data.Add("subtype", "practice");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkpractice[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Insert("questionwc", data);
                        String lastid = dbsqlite.ExecuteScalar("select max(id) from questionwc");
                        //add in checkbox
                        Array.Resize(ref idpractice, idpractice.Length + 1);
                        int j = idpractice.Length - 1;
                        idpractice[j] = new Utils().stringtoInt32(lastid);
                        if (!results && resultinsert) resultinsert = false;
                    }
                }
                else
                {
                    if (i <= (idpractice.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("deleted", "1");
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idpractice[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                        tb.Visible = false;
                        checkpractice[i].Visible = false;
                    }
                }
                i++;
            }
            //cooldown
            i = 0;
            foreach (TextBox tb in tboxcooldown)
            {
                if (tb.Text != "")
                {
                    if (i <= (idcooldown.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "cooldown");
                        data.Add("subtype", "cooldown");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkcooldown[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idcooldown[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                    }
                    else
                    {
                        data = new Dictionary<String, String>();
                        data.Add("type", "cooldown");
                        data.Add("subtype", "cooldown");
                        data.Add("questions", tb.Text.Replace("'", "''"));
                        if (checkcooldown[i].Checked)
                        {
                            data.Add("enabled", "1");
                        }
                        else
                        {
                            data.Add("enabled", "0");
                        }
                        Boolean results = dbsqlite.Insert("questionwc", data);
                        String lastid = dbsqlite.ExecuteScalar("select max(id) from questionwc");
                        //add in checkbox
                        Array.Resize(ref idcooldown, idcooldown.Length + 1);
                        int j = idcooldown.Length - 1;
                        idcooldown[j] = new Utils().stringtoInt32(lastid);
                        if (!results && resultinsert) resultinsert = false;
                    }
                }
                else
                {
                    if (i <= (idcooldown.Length - 1))
                    {
                        data = new Dictionary<String, String>();
                        data.Add("deleted", "1");
                        Boolean results = dbsqlite.Update("questionwc", data, "id = " + idcooldown[i].ToString());
                        if (!results && resultinsert) resultinsert = false;
                        tb.Visible = false;
                        checkcooldown[i].Visible = false;
                    }
                }
                i++;
            }
            //if error
            if (!resultinsert)
            {
                MessageBox.Show("Error, not insert in database. Try again");
            }
            buttonClose.Visible = true;
            buttonSave.Visible = true;
            buttonSaveExit.Visible = true;
        }

        private void buttonClose_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void buttonSaveExit_Click(object sender, EventArgs e)
        {
            SaveAll();
            if(resultinsert) this.Close();
        }

        #endregion
        
        #region load and close

        private void FormWCConfig_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config/config_wcconfig.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Close();
        }

        private void loadconfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config/config_wcconfig.txt";
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
        /// load the questions from the DB on load
        /// </summary>
        private void LoadQuestions()
        {
            //fazer o load das perguntas e guardar os id
            //physical
            DataTable dt = dbsqlite.GetDataTable("select * from questionwc where type = 'warmup' and subtype = 'physical' and deleted = 0");
            if (dt.Rows.Count > 0)
            {
                foreach (DataRow rows in dt.Rows)
                {
                    if(rows.ItemArray[4].ToString() == "True")
                    {
                        createQuestions("physical", tboxphysical, tabPagePhysical, checkphysical, idphysical, rows.ItemArray[3].ToString(), true, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }else{
                        createQuestions("physical", tboxphysical, tabPagePhysical, checkphysical, idphysical, rows.ItemArray[3].ToString(), false, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }                    
                }
            }
            //mental
            dt = dbsqlite.GetDataTable("select * from questionwc where type = 'warmup' and subtype = 'mental' and deleted = 0");
            if (dt.Rows.Count > 0)
            {
                foreach (DataRow rows in dt.Rows)
                {
                    if (rows.ItemArray[4].ToString() == "True")
                    {
                        createQuestions("mental", tboxmental, tabPageMental, checkmental, idmental, rows.ItemArray[3].ToString(), true, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                    else
                    {
                        createQuestions("mental", tboxmental, tabPageMental, checkmental, idmental, rows.ItemArray[3].ToString(), false, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                }
            }
            //technical
            dt = dbsqlite.GetDataTable("select * from questionwc where type = 'warmup' and subtype = 'technical' and deleted = 0");
            if (dt.Rows.Count > 0)
            {
                foreach (DataRow rows in dt.Rows)
                {
                    if (rows.ItemArray[4].ToString() == "True")
                    {
                        createQuestions("technical", tboxtechnical, tabPageTechnical, checktechnical, idtechnical, rows.ItemArray[3].ToString(), true, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                    else
                    {
                        createQuestions("technical", tboxtechnical, tabPageTechnical, checktechnical, idtechnical, rows.ItemArray[3].ToString(), false, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                }
            }
            //practice
            dt = dbsqlite.GetDataTable("select * from questionwc where type = 'warmup' and subtype = 'practice' and deleted = 0");
            if (dt.Rows.Count > 0)
            {
                foreach (DataRow rows in dt.Rows)
                {
                    if (rows.ItemArray[4].ToString() == "True")
                    {
                        createQuestions("practice", tboxpractice, tabPagePractice, checkpractice, idpractice, rows.ItemArray[3].ToString(), true, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                    else
                    {
                        createQuestions("practice", tboxpractice, tabPagePractice, checkpractice, idpractice, rows.ItemArray[3].ToString(), false, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                }
            }
            //cooldown
            dt = dbsqlite.GetDataTable("select * from questionwc where type = 'cooldown' and deleted = 0");
            if (dt.Rows.Count > 0)
            {
                foreach (DataRow rows in dt.Rows)
                {
                    if (rows.ItemArray[4].ToString() == "True")
                    {
                        createQuestions("cooldown", tboxcooldown, tabPageCooldown, checkcooldown, idcooldown, rows.ItemArray[3].ToString(), true, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                    else
                    {
                        createQuestions("cooldown", tboxcooldown, tabPageCooldown, checkcooldown, idcooldown, rows.ItemArray[3].ToString(), false, new Utils().stringtoInt32(rows.ItemArray[0].ToString()));
                    }
                }
            }
        }

        /// <summary>
        /// create questions physical
        /// </summary>
        /// <param name="a"></param>
        private void createQuestions(String type, TextBox[] tb, TabPage tp, CheckBox[] cb, Int32[] idarray, String textboxtext = "", Boolean check = false, Int32 id = 0)
        {
            //textbox
            Array.Resize(ref tb, tb.Length + 1);

            int i = tb.Length - 1;

            tb[i] = new TextBox();
            if (textboxtext != "")
            {
                tb[i].Text = textboxtext;
            }
            tb[i].Top = 40 * (i + 1);
            tb[i].Left = 20;
            tb[i].MaxLength = 150;
            tb[i].Margin = new Padding(20);
            tb[i].Size = new Size(700, 20);
            Controls.Add(tb[i]);

            tp.Controls.Add(tb[i]);

            //checkbox
            Array.Resize(ref cb, cb.Length + 1);
            i = cb.Length - 1;

            cb[i] = new CheckBox();
            cb[i].Top = 40 * (i + 1);
            cb[i].Left = 740;
            if (check)
            {
                cb[i].Checked = true;
            }
            Controls.Add(cb[i]);

            tp.Controls.Add(cb[i]); 

            //int do id
            if (textboxtext != "")
            {
                Array.Resize(ref idarray, idarray.Length + 1);
                i = idarray.Length - 1;
                idarray[i] = id;
            }

            //não sei porque não assumia
            switch (type)
            {
                case "physical":
                    labelActivatep.Visible = true;
                    tboxphysical = tb;
                    checkphysical = cb;
                    idphysical = idarray;
                    break;
                case "mental":
                    labelActivatem.Visible = true;
                    tboxmental = tb;
                    checkmental = cb;
                    idmental = idarray;
                    break;
                case "technical":
                    labelActivatet.Visible = true;
                    tboxtechnical = tb;
                    checktechnical = cb;
                    idtechnical = idarray;
                    break;
                case "practice":
                    labelActivatepr.Visible = true;
                    tboxpractice = tb;
                    checkpractice = cb;
                    idpractice = idarray;
                    break;
                case "cooldown":
                    labelActivateCooldown.Visible = true;
                    tboxcooldown = tb;
                    checkcooldown = cb;
                    idcooldown = idarray;
                    break;                    
                default:
                    break;
            }

        }

        #region Tooltip

        private void buttonSave_MouseHover(object sender, EventArgs e)
        {
            toolTipHelp.SetToolTip(this.buttonSave, "Save");
        }

        private void buttonSaveExit_MouseHover(object sender, EventArgs e)
        {
            toolTipHelp.SetToolTip(this.buttonSaveExit, "Save and Close");
        }

        private void buttonClose_MouseHover(object sender, EventArgs e)
        {
            toolTipHelp.SetToolTip(this.buttonClose, "Close Without Save");
        }

        #endregion

        

    }
}
