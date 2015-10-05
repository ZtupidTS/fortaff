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

namespace CleanHH
{
    public partial class FormInicial : Form
    {
        private String folder;
        private String[] nickname;
        private String site = "";
        private int handnickname = 0;
        private Boolean continu = true;
        private int i = 0;
        private string[] filePaths;
        private int numfile;
        
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
            w.Close();
            //test
        }

        #endregion

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
                            String pathfinal = icon_path + "\\" + Path.GetFileName(fi);
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
                            String pathfinal = icon_path + "\\" + Path.GetFileName(fi);
                            StreamWriter w = new StreamWriter(pathfinal, true);
                            w.Write(textfile);
                            w.WriteLine();
                            w.Close();
                        }
                    }
                    //elimnar o ficheiro
                    File.Delete(fi);

                    textfile = "";
                    i++;
                });
            }
            else
            {
                String textfile2 = "";
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
                            String icon_path = new Uri(folder + "/new").LocalPath;
                            String pathfinal = icon_path + "\\" + Path.GetFileName(fi);
                            StreamWriter w = new StreamWriter(pathfinal, true);
                            w.Write(textfile2);
                            w.WriteLine();
                            w.Close();
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
                            String icon_path = new Uri(folder + "/new").LocalPath;
                            String pathfinal = icon_path + "\\" + Path.GetFileName(fi);
                            StreamWriter w = new StreamWriter(pathfinal, true);
                            w.Write(textfile2);
                            w.WriteLine();
                            w.Close();
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
            //aqui crio o novo ficheiro
            String icon_path = new Uri(folder + "/new").LocalPath;
            String dede = icon_path + "\\" + filename; 
            StreamWriter w = new StreamWriter(dede, true);
            w.Write(filefinal);
            w.WriteLine();
            w.Close();
        }

        /// <summary>
        /// choose folder
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

       

    }
}
