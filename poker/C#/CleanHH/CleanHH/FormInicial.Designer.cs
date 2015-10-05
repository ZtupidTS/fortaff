namespace CleanHH
{
    partial class FormInicial
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormInicial));
            this.textBoxFolder = new System.Windows.Forms.TextBox();
            this.labelFolder = new System.Windows.Forms.Label();
            this.folderBrowserDialogHand = new System.Windows.Forms.FolderBrowserDialog();
            this.buttonChooseFolder = new System.Windows.Forms.Button();
            this.label1 = new System.Windows.Forms.Label();
            this.textBoxNickName = new System.Windows.Forms.TextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.comboBoxSite = new System.Windows.Forms.ComboBox();
            this.buttonClean = new System.Windows.Forms.Button();
            this.label3 = new System.Windows.Forms.Label();
            this.progressBarHand = new System.Windows.Forms.ProgressBar();
            this.backgroundWorkerProgressBar = new System.ComponentModel.BackgroundWorker();
            this.labelWaiting = new System.Windows.Forms.Label();
            this.checkBoxMultiThread = new System.Windows.Forms.CheckBox();
            this.label4 = new System.Windows.Forms.Label();
            this.SuspendLayout();
            // 
            // textBoxFolder
            // 
            this.textBoxFolder.Enabled = false;
            this.textBoxFolder.Location = new System.Drawing.Point(74, 63);
            this.textBoxFolder.Name = "textBoxFolder";
            this.textBoxFolder.Size = new System.Drawing.Size(371, 20);
            this.textBoxFolder.TabIndex = 0;
            // 
            // labelFolder
            // 
            this.labelFolder.AutoSize = true;
            this.labelFolder.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelFolder.Location = new System.Drawing.Point(21, 64);
            this.labelFolder.Name = "labelFolder";
            this.labelFolder.Size = new System.Drawing.Size(47, 16);
            this.labelFolder.TabIndex = 1;
            this.labelFolder.Text = "Folder";
            // 
            // buttonChooseFolder
            // 
            this.buttonChooseFolder.Image = ((System.Drawing.Image)(resources.GetObject("buttonChooseFolder.Image")));
            this.buttonChooseFolder.Location = new System.Drawing.Point(451, 57);
            this.buttonChooseFolder.Name = "buttonChooseFolder";
            this.buttonChooseFolder.Size = new System.Drawing.Size(33, 30);
            this.buttonChooseFolder.TabIndex = 2;
            this.buttonChooseFolder.UseVisualStyleBackColor = true;
            this.buttonChooseFolder.Click += new System.EventHandler(this.buttonChooseFolder_Click);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(13, 106);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(55, 13);
            this.label1.TabIndex = 3;
            this.label1.Text = "Nickname";
            // 
            // textBoxNickName
            // 
            this.textBoxNickName.Location = new System.Drawing.Point(74, 103);
            this.textBoxNickName.Name = "textBoxNickName";
            this.textBoxNickName.Size = new System.Drawing.Size(248, 20);
            this.textBoxNickName.TabIndex = 4;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(43, 28);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(25, 13);
            this.label2.TabIndex = 5;
            this.label2.Text = "Site";
            // 
            // comboBoxSite
            // 
            this.comboBoxSite.FormattingEnabled = true;
            this.comboBoxSite.Items.AddRange(new object[] {
            "PokerStars"});
            this.comboBoxSite.Location = new System.Drawing.Point(74, 25);
            this.comboBoxSite.Name = "comboBoxSite";
            this.comboBoxSite.Size = new System.Drawing.Size(248, 21);
            this.comboBoxSite.TabIndex = 6;
            this.comboBoxSite.SelectedIndexChanged += new System.EventHandler(this.comboBoxSite_SelectedIndexChanged);
            // 
            // buttonClean
            // 
            this.buttonClean.Location = new System.Drawing.Point(220, 194);
            this.buttonClean.Name = "buttonClean";
            this.buttonClean.Size = new System.Drawing.Size(75, 23);
            this.buttonClean.TabIndex = 7;
            this.buttonClean.Text = "Clean HH";
            this.buttonClean.UseVisualStyleBackColor = true;
            this.buttonClean.Click += new System.EventHandler(this.buttonClean_Click);
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(473, 207);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(28, 13);
            this.label3.TabIndex = 8;
            this.label3.Text = "v1.0";
            // 
            // progressBarHand
            // 
            this.progressBarHand.Location = new System.Drawing.Point(74, 158);
            this.progressBarHand.Name = "progressBarHand";
            this.progressBarHand.Size = new System.Drawing.Size(410, 23);
            this.progressBarHand.TabIndex = 9;
            // 
            // backgroundWorkerProgressBar
            // 
            this.backgroundWorkerProgressBar.DoWork += new System.ComponentModel.DoWorkEventHandler(this.backgroundWorkerProgressBar_DoWork);
            this.backgroundWorkerProgressBar.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.backgroundWorkerProgressBar_ProgressChanged);
            this.backgroundWorkerProgressBar.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.backgroundWorkerProgressBar_RunWorkerCompleted);
            // 
            // labelWaiting
            // 
            this.labelWaiting.AutoSize = true;
            this.labelWaiting.ForeColor = System.Drawing.Color.Red;
            this.labelWaiting.Location = new System.Drawing.Point(301, 199);
            this.labelWaiting.Name = "labelWaiting";
            this.labelWaiting.Size = new System.Drawing.Size(78, 13);
            this.labelWaiting.TabIndex = 10;
            this.labelWaiting.Text = "Waiting Please";
            // 
            // checkBoxMultiThread
            // 
            this.checkBoxMultiThread.AutoSize = true;
            this.checkBoxMultiThread.CheckAlign = System.Drawing.ContentAlignment.MiddleRight;
            this.checkBoxMultiThread.Location = new System.Drawing.Point(4, 132);
            this.checkBoxMultiThread.Name = "checkBoxMultiThread";
            this.checkBoxMultiThread.Size = new System.Drawing.Size(85, 17);
            this.checkBoxMultiThread.TabIndex = 11;
            this.checkBoxMultiThread.Text = "Multi-Thread";
            this.checkBoxMultiThread.UseVisualStyleBackColor = true;
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label4.ForeColor = System.Drawing.Color.Red;
            this.label4.Location = new System.Drawing.Point(96, 133);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(208, 13);
            this.label4.TabIndex = 12;
            this.label4.Text = "*If checked, more fast but more cpu usage";
            // 
            // FormInicial
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(513, 228);
            this.Controls.Add(this.label4);
            this.Controls.Add(this.checkBoxMultiThread);
            this.Controls.Add(this.labelWaiting);
            this.Controls.Add(this.progressBarHand);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.buttonClean);
            this.Controls.Add(this.comboBoxSite);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.textBoxNickName);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.buttonChooseFolder);
            this.Controls.Add(this.labelFolder);
            this.Controls.Add(this.textBoxFolder);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormInicial";
            this.Text = "CleanHH";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.Main_FormClosed);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox textBoxFolder;
        private System.Windows.Forms.Label labelFolder;
        private System.Windows.Forms.FolderBrowserDialog folderBrowserDialogHand;
        private System.Windows.Forms.Button buttonChooseFolder;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.TextBox textBoxNickName;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.ComboBox comboBoxSite;
        private System.Windows.Forms.Button buttonClean;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.ProgressBar progressBarHand;
        private System.ComponentModel.BackgroundWorker backgroundWorkerProgressBar;
        private System.Windows.Forms.Label labelWaiting;
        private System.Windows.Forms.CheckBox checkBoxMultiThread;
        private System.Windows.Forms.Label label4;
    }
}

