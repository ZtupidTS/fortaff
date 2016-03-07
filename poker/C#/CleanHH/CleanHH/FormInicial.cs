using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Threading;
using System.Threading.Tasks;
using CleanHH.DB;
using System.Text.RegularExpressions;

namespace CleanHH
{
    //serve para executar task noutro thread
    delegate void SetTextCallback(string text);
    
    public partial class FormInicial : Form
    {
        //convert hands
        private SQLiteDatabase dbsqlite = new SQLiteDatabase();
        //clean HH
        private String folder;
        private String[] nickname;
        private String site = "";
        private int handnickname = 0;
        private Boolean continu = true;
        private int i = 0;
        private string[] filePaths;
        private int numfile;
        private long newhandnumberhandDB;
        //convert hive hands
        private String folderoriginalhive = "";
        private String folderconvertedhive = "";
        private Thread hiveconvert;
        private Boolean continuconverthive = false;
        private int handconverted = 0;
        //logs
        private Boolean logs;
        private Boolean hivehandsotherdb;
        
        public FormInicial()
        {
            InitializeComponent();
            labelWaiting.Visible = false;
            //eliminar ficheiros de erro com mais de 3 dias
            new Utils().deletefileerrors();
            //depois disso volto ao soft caso diz que não
            loadConfig();
            //progress bar
            backgroundWorkerProgressBar.WorkerReportsProgress = true;
            backgroundWorkerProgressBar.WorkerSupportsCancellation = true;
        }

        #region Save and load config

        /// <summary>
        /// Permite guardar os dados inseridos no software
        /// </summary>
        private void loadConfig()
        {
            String path = Directory.GetCurrentDirectory();
            String filepath = path + "/config.txt";
            string line;
            // Read the file and display it line by line.
            if (File.Exists(filepath))
            {
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
                    int x = 0;
                    int y = 0;
                    if (int.Parse(loc[0]) > 0) x = int.Parse(loc[0]);
                    if (int.Parse(loc[1]) > 0) y = int.Parse(loc[1]);                    
                    this.Location = new Point(x, y);
                    break;
                case "comboBoxSite":
                    comboBoxSite.SelectedIndex = new Utils().stringtoInt32(line[1].ToString());
                    break;
                case "textBoxFolder":
                    textBoxFolder.Text = line[1].ToString();
                    break;
                case "textBoxNickName":
                    textBoxNickName.Text = line[1].ToString();
                    break; 
                case "multithread":
                    if(line[1].ToString().Equals("True"))
                    {
                        checkBoxMultiThread.Checked = true;
                    }else{
                        checkBoxMultiThread.Checked = false;
                    }
                    break;
                case "folderoriginalhive":
                    textBoxHandOriginalHive.Text = line[1].ToString();
                    folderoriginalhive = line[1].ToString();
                    break;
                case "folderconvertedhive":
                    textBoxHandHiveConverted.Text = line[1].ToString();
                    folderconvertedhive = line[1].ToString();
                    break;
                case "checkBoxLogs":
                    if (line[1].ToString().Equals("True"))
                    {
                        checkBoxLogs.Checked = true;
                        logs = true;
                    }
                    else
                    {
                        checkBoxLogs.Checked = false;
                        logs = false;
                    }
                    break;
                case "checkBoxHiveHandsOtherDb":
                    if (line[1].ToString().Equals("True"))
                    {
                        checkBoxHiveHandsOtherDb.Checked = true;
                        hivehandsotherdb = true;
                    }
                    else
                    {
                        checkBoxHiveHandsOtherDb.Checked = false;
                        hivehandsotherdb = false;
                    }
                    break;
                default:
                    break;
            }
        }

        private void Main_FormClosed(object sender, FormClosedEventArgs e)
        {
            String location = this.Location.X.ToString() + ',' + this.Location.Y.ToString();
            String path = Directory.GetCurrentDirectory();
            StreamWriter w = new StreamWriter(path + "/config.txt", false);
            w.Write("Location=" + location);
            w.WriteLine();
            w.Write("textBoxFolder=" + textBoxFolder.Text.ToString());
            w.WriteLine();
            w.Write("textBoxNickName=" + textBoxNickName.Text.ToString());
            w.WriteLine();
            w.Write("comboBoxSite=" + comboBoxSite.SelectedIndex);
            w.WriteLine();
            w.Write("multithread=" + checkBoxMultiThread.Checked.ToString());
            w.WriteLine();
            w.Write("folderoriginalhive=" + textBoxHandOriginalHive.Text.ToString());
            w.WriteLine();
            w.Write("folderconvertedhive=" + textBoxHandHiveConverted.Text.ToString());
            w.WriteLine();
            w.Write("checkBoxLogs=" + checkBoxLogs.Checked.ToString());
            w.WriteLine();
            w.Write("checkBoxHiveHandsOtherDb=" + checkBoxHiveHandsOtherDb.Checked.ToString());
            w.WriteLine();
            w.Close();
            //test
        }

        #endregion

        #region clean HH

        /// <summary>
        /// clean HH
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonClean_Click(object sender, EventArgs e)
        {
            continu = true;
            //folder
            if (textBoxFolder.Text.Equals(""))
            {
                MessageBox.Show("Choose folder files hands");
                continu = false;
            }
            else
            {
                folder = textBoxFolder.Text;
            }
            //nickname
            if (textBoxNickName.Text.Equals("") && continu)
            {
                MessageBox.Show("Write your nickname");
                continu = false;
            }
            else
            {
                if (textBoxNickName.Text.Contains(","))
                {
                    nickname = textBoxNickName.Text.Split(',');                    
                }
                else
                {
                    nickname = new String[] { textBoxNickName.Text };
                }
                
            }
            //site
            if (comboBoxSite.SelectedIndex == -1 && site == "" && continu)
            {
                MessageBox.Show("Choose the site");
                continu = false;
            }
            else
            {
                site = comboBoxSite.SelectedItem.ToString();
            }
            buttonClean.Enabled = false;
            labelWaiting.Visible = true;
            //ciclo
            if(continu)
            {
                Thread startapp = new Thread(new ThreadStart(this.getFiles));
                startapp.Start();

                if (backgroundWorkerProgressBar.IsBusy != true)
                {
                    // Start the asynchronous operation.
                    backgroundWorkerProgressBar.RunWorkerAsync();
                }                
            }
        }

        /// <summary>
        /// obtenho a lista de ficheiros
        /// </summary>
        private void getFiles()
        {
            //criar a pasta new
            if (!Directory.Exists(folder + "/new"))
            {
                // Try to create the directory.
                try
                {
                    DirectoryInfo di = Directory.CreateDirectory(folder + "/new");
                }
                catch (IOException ex)
                {
                    new Debug().LogMessage("Erro na criação da pasta new: " + ex.ToString());
                }
            }

            //obter todos a lista de ficheiro
            filePaths = Directory.GetFiles(@"" + folder, "*.txt");
            numfile = filePaths.Count();
            
            //multithread
            if (checkBoxMultiThread.Checked)
            {
                String pathfinal = "";
                Parallel.ForEach(filePaths, fi =>
                {
                    String textfile = "";
                    using (StreamReader streamReader = new StreamReader(fi, Encoding.UTF8))
                    {
                        textfile = streamReader.ReadToEnd();
                    }
                    if (nickname.Length > 1)
                    {
                        if (textfile.Contains(nickname[0]) || textfile.Contains(nickname[1]))
                        {
                            cleanfile(textfile, Path.GetFileName(fi));
                        }
                        else
                        {
                            String icon_path = new Uri(folder + "/new").LocalPath;
                            pathfinal = icon_path + "\\" + Path.GetFileName(fi);
                            StreamWriter w = new StreamWriter(pathfinal, true);
                            w.Write(textfile);
                            w.WriteLine();
                            w.Close();
                        }
                    }
                    else
                    {
                        if (textfile.Contains(nickname[0]))
                        {
                            cleanfile(textfile, Path.GetFileName(fi));
                        }
                        else
                        {
                            String icon_path = new Uri(folder + "/new").LocalPath;
                            pathfinal = icon_path + "\\" + Path.GetFileName(fi);
                            StreamWriter w = new StreamWriter(pathfinal, true);
                            w.Write(textfile);
                            w.WriteLine();
                            w.Close();
                            
                        }
                    }
                    //eliminar o ficheiro
                    File.Delete(fi);

                    textfile = "";
                    pathfinal = "";
                    i++;
                });
            }
            else
            {
                String textfile2 = "";
                String pathfinal = "";
                foreach (String fi in filePaths)
                {
                    using (StreamReader streamReader = new StreamReader(fi, Encoding.UTF8))
                    {
                        textfile2 = streamReader.ReadToEnd();
                    }
                    if (nickname.Length > 1)
                    {
                        if (textfile2.Contains(nickname[0]) || textfile2.Contains(nickname[1]))
                        {
                            cleanfile(textfile2, Path.GetFileName(fi));
                        }
                        else
                        {
                            if (!hivehandsotherdb)
                            {
                                String icon_path = new Uri(folder + "/new").LocalPath;
                                pathfinal = icon_path + "\\" + Path.GetFileName(fi);
                                StreamWriter w = new StreamWriter(pathfinal, true);
                                w.Write(textfile2);
                                w.WriteLine();
                                w.Close();
                            }
                            else
                            {
                                changeNumberHandHive(textfile2, Path.GetFileName(fi));
                            }

                        }
                    }
                    else
                    {
                        if (textfile2.Contains(nickname[0]))
                        {
                            cleanfile(textfile2, Path.GetFileName(fi));
                        }
                        else
                        {
                            if (!hivehandsotherdb)
                            {
                                String icon_path = new Uri(folder + "/new").LocalPath;
                                pathfinal = icon_path + "\\" + Path.GetFileName(fi);
                                StreamWriter w = new StreamWriter(pathfinal, true);
                                w.Write(textfile2);
                                w.WriteLine();
                                w.Close();
                            }
                            else
                            {
                                changeNumberHandHive(textfile2, Path.GetFileName(fi));
                            }
                        }
                    }
                    //elimnar o ficheiro
                    File.Delete(fi);

                    textfile2 = "";
                    i++;
                }
            }            
            continu = false;
            //buttonClean.Enabled = true;
            //labelWaiting.Visible = false;
        }

        private void changeNumberHandHive(String file, String filename)
        {
            String[] splitfile = file.Split(new string[] { "PokerStars Hand #" }, StringSplitOptions.RemoveEmptyEntries);
            String filefinal = "";

            //aqui ler ao contrario assim se o numero das hands se repete tipo 3x paro :)
            //foreach (String fi in splitfile)
            for (int l = (splitfile.Length - 1); l > 0; l--)
            {
                String hand = splitfile[l];
                //obter o numero antigo da hand
                long oldnumberhand = new Utils().getOldNumberHandsHive(hand);
                //novo numero da hand
                long newhandnumber = newHandNumber(oldnumberhand);

                Boolean verifynewnumber = true;
                while (verifynewnumber)
                {
                    if (newhandnumberhandDB < newhandnumber && newhandnumberhandDB != newhandnumber)
                    {
                        newhandnumberhandDB = newhandnumber;
                        verifynewnumber = false;
                    }
                    else
                    {
                        newhandnumber++;
                    }
                }

                if (newhandnumber > 0)
                {
                    //vou mudar o numero na hand
                    hand = hand.Replace(oldnumberhand.ToString(), newhandnumber.ToString());
                    filefinal += "PokerStars Hand #" + hand;
                    handconverted++;
                }
            }
            //aqui crio o novo ficheiro
            if (!filefinal.Equals(""))
            {
                String icon_path = new Uri(folder + "/new").LocalPath;
                String pathfinal = icon_path + "\\" + filename;
                StreamWriter w = new StreamWriter(pathfinal, true);
                w.Write(filefinal);
                w.WriteLine();
                w.Close();
            }
        }

        /// <summary>
        /// limpeza das hands
        /// </summary>
        /// <param name="file"></param>
        /// <param name="filename"></param>
        private void cleanfile(String file, String filename)
        {
            String[] splitfile = file.Split(new string[] { site }, StringSplitOptions.RemoveEmptyEntries);
            String filefinal = "";
            foreach (String fi in splitfile)
            {
                if (nickname.Length > 1)
                {
                    if (!fi.Contains(nickname[0]))
                    {
                        if (!fi.Contains(nickname[1]))
                        {
                            filefinal += site + fi;
                        }
                        else
                        {
                            handnickname++;
                        }                        
                    }
                    else
                    {
                        handnickname++;
                    }
                }
                else
                {
                    if (!fi.Contains(nickname[0]))
                    {
                        filefinal += site + fi;
                    }
                    else
                    {
                        handnickname++;
                    }
                }
            }
            if (!filefinal.Equals(""))
            {
                if (!hivehandsotherdb)
                {
                    //aqui crio o novo ficheiro
                    String icon_path = new Uri(folder + "/new").LocalPath;
                    String dede = icon_path + "\\" + filename;
                    StreamWriter w = new StreamWriter(dede, true);
                    w.Write(filefinal);
                    w.WriteLine();
                    w.Close();
                }
                else
                {
                    changeNumberHandHive(filefinal, filename);
                }
            }
        }

        /// <summary>
        /// choose folder to clean hands
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonChooseFolder_Click(object sender, EventArgs e)
        {
            folderBrowserDialogHand.ShowDialog();
            textBoxFolder.Text = folderBrowserDialogHand.SelectedPath.ToString();
            folder = folderBrowserDialogHand.SelectedPath.ToString();
        }

        /// <summary>
        /// quando se muda a selecção na combobox site
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void comboBoxSite_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (comboBoxSite.SelectedIndex != -1)
            {
                site = comboBoxSite.SelectedItem.ToString();
            }
        }

        /// <summary>
        /// trabalho em 2º plano
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void backgroundWorkerProgressBar_DoWork(object sender, DoWorkEventArgs e)
        {
            BackgroundWorker worker = sender as BackgroundWorker;
            
            int tempi = i;
            while (continu)
            {
                if (tempi != i)
                {
                    worker.ReportProgress(i);
                    tempi = i;
                }

            }
            backgroundWorkerProgressBar.CancelAsync();
        }

        private void backgroundWorkerProgressBar_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            progressBarHand.Maximum = numfile;
            progressBarHand.Value = i;
        }

        private void backgroundWorkerProgressBar_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            progressBarHand.Value = progressBarHand.Maximum;
            MessageBox.Show("Finish Clean HH, Have " + handnickname + " hands with nickname");
            this.Close();
        }

        #endregion


        #region convert hive hands

        /// <summary>
        /// button folder hive original
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonFOlderHandHiveOriginal_Click(object sender, EventArgs e)
        {
            folderBrowserDialogHand.ShowDialog();
            textBoxHandOriginalHive.Text = folderBrowserDialogHand.SelectedPath.ToString();
            folderoriginalhive = folderBrowserDialogHand.SelectedPath.ToString();
        }

        /// <summary>
        /// button folder hive converted
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonHandsHiveConverted_Click(object sender, EventArgs e)
        {
            folderBrowserDialogHand.ShowDialog();
            textBoxHandHiveConverted.Text = folderBrowserDialogHand.SelectedPath.ToString();
            folderconvertedhive = folderBrowserDialogHand.SelectedPath.ToString();
        }

        /// <summary>
        /// button start convert hive hands
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonStartConvertHandHive_Click(object sender, EventArgs e)
        {
            if (folderoriginalhive.Equals("") || folderconvertedhive.Equals(""))
            {
                MessageBox.Show("Choose first folder original hands and converted hands");
            }
            else
            {
                continuconverthive = true;
                labelStatusHiveHand.Text = "STARTED";
                labelStatusHiveHand.ForeColor = Color.Green;
                hiveconvert = new Thread(new ThreadStart(this.convertHandsHive));
                hiveconvert.Start();
            }
            buttonStartConvertHandHive.Enabled = false;
            buttonStopConvertHandHive.Enabled = true;
        }

        /// <summary>
        /// button stop convert hive hands
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonStopConvertHandHive_Click(object sender, EventArgs e)
        {
            continuconverthive = false;
            labelStatusHiveHand.Text = "STOPPED";
            labelStatusHiveHand.ForeColor = Color.Red;
            hiveconvert.Abort();
            buttonStopConvertHandHive.Enabled = false;
            buttonStartConvertHandHive.Enabled = true;
        }

        private void convertHandsHive()
        {
            string[] folders;
            string[] filehands;
            
            while (continuconverthive)
            {
                try
                {
                    //ober a lista de directorios
                    folders = Directory.GetDirectories(folderoriginalhive);
                    //obter dados de cada pasta
                    foreach (String fo in folders)
                    {
                        //aqui obtenho o tamanho da pasta
                        long sizedirectory = sizeDir(fo);
                        //agora se não existe na DB vou meter ou verificar se há mudanças
                        Boolean folderboo = folderChanges(fo, sizedirectory);
                        //true = ler directorio
                        //false = ir para outro directorio

                        if (folderboo)
                        {
                            //vou passar a ir novamente a todos os ficheiros
                            filehands = Directory.GetFiles(@"" + fo, "*.txt");

                            String textfile2 = "";
                            foreach (String fi in filehands)
                            {
                                //antes de ir ler o ficheiro ver se tem o mesmo tamanho
                                FileInfo info = new FileInfo(fi);
                                Boolean fileboo = fileChanges(Path.GetFileName(fi), info.Length);

                                //true = ler file
                                //false = ir para outro
                                if (fileboo)
                                {
                                    //vou copiar o ficheiro original
                                    String tempfile = new Debug().pathApp() + "\\tempfile\\" + info.Name;

                                    //File.SetAttributes(tempfile, FileAttributes.Normal);
                                    File.Copy(fi, tempfile, true);
                                    File.SetAttributes(tempfile, FileAttributes.Normal);

                                    using (StreamReader streamReader = new StreamReader(tempfile, Encoding.UTF8))
                                    {
                                        textfile2 = streamReader.ReadToEnd();
                                        streamReader.Close();
                                        streamReader.Dispose();                                        
                                    }
                                    handHive(textfile2, info.Name);
                                    //aqui vou mudar o numero de hands convertidas
                                    if (this.labelHandsConverted.InvokeRequired)
                                    {
                                        SetTextCallback d = new SetTextCallback(SetTextHandsConverted);
                                        this.Invoke(d, new object[] { "Hands converted: " + handconverted });
                                    }
                                    else
                                    {
                                        // It's on the same thread, no need for Invoke
                                        this.labelHandsConverted.Text = "Hands converted: " + handconverted;
                                    }

                                    //vou eliminar todos os ficheiros presente na pasta tempfile
                                    var dir = new DirectoryInfo(new Debug().pathApp() + "\\tempfile\\");
                                    foreach (var file in dir.GetFiles())
                                    {
                                        try
                                        {
                                            file.Delete();
                                        }
                                        catch (IOException ex)
                                        {
                                            //file is currently locked
                                            if(logs) new Debug().LogMessage("Problem no catch delete: " + ex.ToString());
                                        }
                                    }
                                    //File.Delete(tempfile);
                                }
                                textfile2 = "";
                            }

                        }
                    }
                }
                catch (Exception e)
                {
                    if (logs) new Debug().LogMessage("Problem no handconverthive: " + e.ToString());
                    //convertHandsHive();
                }
            }
            
        }

        /// <summary>
        /// get size dir
        /// </summary>
        /// <param name="dir"></param>
        /// <returns></returns>
        private long sizeDir(String dir)
        {
            string[] a = Directory.GetFiles(dir, "*.*");
            long b = 0;
            foreach (string name in a)
            {
                FileInfo info = new FileInfo(name);
                b += info.Length;
            }
            return b;
        }

        /// <summary>
        /// verify if folder has changed
        /// </summary>
        /// <param name="dir"></param>
        /// <param name="sizedir"></param>
        /// <returns></returns>
        private Boolean folderChanges(String dir, long sizedir)
        {
            DataTable dt = dbsqlite.GetDataTable("select * from folders where name = '"+dir+"'");
            if (dt.Rows.Count > 0)
            {
                //aqui vou ver se o tamamnho é o mesmo
                foreach (DataRow rows in dt.Rows)
                {
                    long sizedb = (long)rows.ItemArray[2];
                    if (sizedb.Equals(sizedir))
                    {
                        return false;
                    }
                }
                return true;
            }
            else
            {
                //aqui tenho que inserir e de pois devolvo o true
                Dictionary<String, String> data = new Dictionary<String, String>();
                data.Add("name", dir);
                data.Add("size", sizedir.ToString());
                Boolean results = dbsqlite.Insert("folders", data);
                return true;
            }
        }

        /// <summary>
        /// verify if file has changed
        /// </summary>
        /// <param name="dir"></param>
        /// <param name="sizedir"></param>
        /// <returns></returns>
        private Boolean fileChanges(String fil, long sizedir)
        {
            DataTable dt = dbsqlite.GetDataTable("select * from files where name = '" + fil + "'");
            if (dt.Rows.Count > 0)
            {
                //aqui vou ver se o tamamnho é o mesmo
                foreach (DataRow rows in dt.Rows)
                {
                    long sizedb = (long)rows.ItemArray[2];
                    if (sizedb.Equals(sizedir))
                    {
                        return false;
                    }
                    else
                    {
                        return true;
                    }
                }
                return true;
            }
            else
            {
                //aqui tenho que inserir e de pois devolvo o true
                Dictionary<String, String> data = new Dictionary<String, String>();
                data.Add("name", fil);
                data.Add("size", sizedir.ToString());
                Boolean results = dbsqlite.Insert("files", data);
                return true;
            }
        }

        /// <summary>
        /// ver all hands file and create new file
        /// </summary>
        /// <param name="file"></param>
        /// <param name="filename"></param>
        private void handHive(String file, String filename)
        {
            String[] splitfile = file.Split(new string[] { "Hive Poker Game #" }, StringSplitOptions.RemoveEmptyEntries);
            String filefinal = "";

            //aqui ler ao contrario assim se o numero das hands se repete tipo 3x paro :)
            //foreach (String fi in splitfile)
            int repeathand = 0;
            for(int l = (splitfile.Length -1);l > 0;l--)
            {
                //Mulla 6-max - Blinds 0.01EUR/0.02EUR - No Limit Hold'em
                String limitplayed = new Utils().getNlHive(splitfile[l]);
                //String[] splitchangenametable = splitfile[l].Split(new string[] { "Table " }, StringSplitOptions.RemoveEmptyEntries);

                //String abc = removeBetween(splitchangenametable[1].ToString(), 'a', 'a');
                //String[] splitone = splitfile[l].Split(new string[] { ":" }, StringSplitOptions.RemoveEmptyEntries);

                //long oldnumberhand = Convert.ToInt64(splitone[0]);
                //tendo o numero antigo vou guardar na DB e dar o novo


                //string da hand
                String hand = splitfile[l];
                //obter o numero antigo da hand
                long oldnumberhand = new Utils().getOldNumberHandsHive(hand);
                //novo numero da hand
                long newhandnumber = newHandNumber(oldnumberhand);

                if (newhandnumber > 0)
                {
                    //vou mudar o numero na hand
                    hand = hand.Replace(oldnumberhand.ToString(), newhandnumber.ToString());
                    //agora mudar o nome da mesa
                    String oldnametable = new Utils().getNameTableHive(hand);
                    //change table name
                    hand = hand.Replace(oldnametable, oldnametable + limitplayed);
                    //filefinal += "PokerStars Hand #" + newhandnumber;
                    //for (int k = 1; k < splitone.Length; k++)
                    //{
                    //    filefinal += ":" + splitone[k];
                    //}
                    filefinal += "PokerStars Hand #" + hand;
                    handconverted++;
                }
                else
                {
                    repeathand++;
                }

                if (repeathand > 4) l = 0;

                //essa linha é só para testar o hud depois retirar
                //filefinal += "PokerStars Hand #" + fi;                
            }
            //aqui crio o novo ficheiro
            if (!filefinal.Equals(""))
            {
                String icon_path = new Uri(folderconvertedhive).LocalPath;
                String dede = icon_path + "\\" + filename;
                StreamWriter w = new StreamWriter(dede, true);
                w.Write(filefinal);
                w.WriteLine();
                w.Close();
            }
        }

        

        /// <summary>
        /// 0: hands exists
        /// num hand : new number
        /// </summary>
        /// <param name="oldnumhand"></param>
        /// <returns></returns>
        private long newHandNumber(long oldnumhand)
        {
            DataTable dt = dbsqlite.GetDataTable("select * from numberhands where numberhand = '" + oldnumhand + "'");
            if (dt.Rows.Count > 0)
            {
                return 0;                    
            }
            else
            {
                //como não existe a hand vou inserir na DB
                //mas antes ter o ultimo numero inserido
                dt = dbsqlite.GetDataTable("select * from numberhands order by id DESC limit 1");
                long newid = 100;
                if (dt.Rows.Count > 0)
                {
                    //aqui vou ver se o tamamnho é o mesmo
                    foreach (DataRow rows in dt.Rows)
                    {
                        newid = (long)rows.ItemArray[0] + 100;
                    }
                }

                Boolean results = false;
                while(!results)
                {
                    Dictionary<String, String> data = new Dictionary<String, String>();
                    data.Add("numberhand", oldnumhand.ToString());
                    data.Add("newnumber", newid.ToString());
                    results = dbsqlite.Insert("numberhands", data);
                }
                return newid;
            }
        }

        #endregion

        /// <summary>
        /// change in checkbox logs
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void checkBoxLogs_CheckedChanged(object sender, EventArgs e)
        {
            if (checkBoxLogs.Checked)
            {
                logs = true;
            }
            else
            {
                logs = false;
            }
        }

        /// <summary>
        /// Metodo para mudar o numero de hands convertidas
        /// </summary>
        /// <param name="text"></param>
        private void SetTextHandsConverted(string text)
        {
            this.labelHandsConverted.Text = text;
        }

        /// <summary>
        /// when checked change multithread
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void checkBoxHiveHandsOtherDb_CheckedChanged(object sender, EventArgs e)
        {
            if (checkBoxHiveHandsOtherDb.Checked)
            {
                checkBoxMultiThread.Checked = false;
            }
            else
            {
                checkBoxMultiThread.Checked = true;
            }
        }

        /// <summary>
        /// when checked change checkbox hivehand
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void checkBoxMultiThread_CheckedChanged(object sender, EventArgs e)
        {
            if (checkBoxMultiThread.Checked)
            {
                checkBoxHiveHandsOtherDb.Checked = false;
            }
            else
            {
                checkBoxHiveHandsOtherDb.Checked = true;
            }
        }

        
        
    }
}
