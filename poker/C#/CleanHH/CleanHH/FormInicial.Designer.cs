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
            this.tabControlMain = new System.Windows.Forms.TabControl();
            this.tabPageCleanHands = new System.Windows.Forms.TabPage();
            this.tabPageConvertHandsHive = new System.Windows.Forms.TabPage();
            this.checkBoxLogs = new System.Windows.Forms.CheckBox();
            this.labelStatusHiveHand = new System.Windows.Forms.Label();
            this.buttonStopConvertHandHive = new System.Windows.Forms.Button();
            this.buttonStartConvertHandHive = new System.Windows.Forms.Button();
            this.textBoxHandHiveConverted = new System.Windows.Forms.TextBox();
            this.label5 = new System.Windows.Forms.Label();
            this.buttonHandsHiveConverted = new System.Windows.Forms.Button();
            this.textBoxHandOriginalHive = new System.Windows.Forms.TextBox();
            this.labelFolderHandHiveOriginal = new System.Windows.Forms.Label();
            this.buttonFOlderHandHiveOriginal = new System.Windows.Forms.Button();
            this.labelHandsConverted = new System.Windows.Forms.Label();
            this.tabControlMain.SuspendLayout();
            this.tabPageCleanHands.SuspendLayout();
            this.tabPageConvertHandsHive.SuspendLayout();
            this.SuspendLayout();
            // 
            // textBoxFolder
            // 
            this.textBoxFolder.Enabled = false;
            this.textBoxFolder.Location = new System.Drawing.Point(82, 56);
            this.textBoxFolder.Name = "textBoxFolder";
            this.textBoxFolder.Size = new System.Drawing.Size(371, 20);
            this.textBoxFolder.TabIndex = 0;
            // 
            // labelFolder
            // 
            this.labelFolder.AutoSize = true;
            this.labelFolder.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelFolder.Location = new System.Drawing.Point(29, 57);
            this.labelFolder.Name = "labelFolder";
            this.labelFolder.Size = new System.Drawing.Size(47, 16);
            this.labelFolder.TabIndex = 1;
            this.labelFolder.Text = "Folder";
            // 
            // buttonChooseFolder
            // 
            this.buttonChooseFolder.Image = ((System.Drawing.Image)(resources.GetObject("buttonChooseFolder.Image")));
            this.buttonChooseFolder.Location = new System.Drawing.Point(459, 50);
            this.buttonChooseFolder.Name = "buttonChooseFolder";
            this.buttonChooseFolder.Size = new System.Drawing.Size(33, 30);
            this.buttonChooseFolder.TabIndex = 2;
            this.buttonChooseFolder.UseVisualStyleBackColor = true;
            this.buttonChooseFolder.Click += new System.EventHandler(this.buttonChooseFolder_Click);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(21, 99);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(55, 13);
            this.label1.TabIndex = 3;
            this.label1.Text = "Nickname";
            // 
            // textBoxNickName
            // 
            this.textBoxNickName.Location = new System.Drawing.Point(82, 96);
            this.textBoxNickName.Name = "textBoxNickName";
            this.textBoxNickName.Size = new System.Drawing.Size(248, 20);
            this.textBoxNickName.TabIndex = 4;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(51, 21);
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
            this.comboBoxSite.Location = new System.Drawing.Point(82, 18);
            this.comboBoxSite.Name = "comboBoxSite";
            this.comboBoxSite.Size = new System.Drawing.Size(248, 21);
            this.comboBoxSite.TabIndex = 6;
            this.comboBoxSite.SelectedIndexChanged += new System.EventHandler(this.comboBoxSite_SelectedIndexChanged);
            // 
            // buttonClean
            // 
            this.buttonClean.Location = new System.Drawing.Point(228, 187);
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
            this.label3.Location = new System.Drawing.Point(533, 277);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(28, 13);
            this.label3.TabIndex = 8;
            this.label3.Text = "v1.2";
            // 
            // progressBarHand
            // 
            this.progressBarHand.Location = new System.Drawing.Point(82, 151);
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
            this.labelWaiting.Location = new System.Drawing.Point(309, 192);
            this.labelWaiting.Name = "labelWaiting";
            this.labelWaiting.Size = new System.Drawing.Size(78, 13);
            this.labelWaiting.TabIndex = 10;
            this.labelWaiting.Text = "Waiting Please";
            // 
            // checkBoxMultiThread
            // 
            this.checkBoxMultiThread.AutoSize = true;
            this.checkBoxMultiThread.CheckAlign = System.Drawing.ContentAlignment.MiddleRight;
            this.checkBoxMultiThread.Location = new System.Drawing.Point(12, 125);
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
            this.label4.Location = new System.Drawing.Point(104, 126);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(208, 13);
            this.label4.TabIndex = 12;
            this.label4.Text = "*If checked, more fast but more cpu usage";
            // 
            // tabControlMain
            // 
            this.tabControlMain.Controls.Add(this.tabPageCleanHands);
            this.tabControlMain.Controls.Add(this.tabPageConvertHandsHive);
            this.tabControlMain.Location = new System.Drawing.Point(12, 12);
            this.tabControlMain.Name = "tabControlMain";
            this.tabControlMain.SelectedIndex = 0;
            this.tabControlMain.Size = new System.Drawing.Size(553, 262);
            this.tabControlMain.TabIndex = 13;
            // 
            // tabPageCleanHands
            // 
            this.tabPageCleanHands.BackColor = System.Drawing.SystemColors.Control;
            this.tabPageCleanHands.Controls.Add(this.label2);
            this.tabPageCleanHands.Controls.Add(this.label4);
            this.tabPageCleanHands.Controls.Add(this.textBoxFolder);
            this.tabPageCleanHands.Controls.Add(this.checkBoxMultiThread);
            this.tabPageCleanHands.Controls.Add(this.labelFolder);
            this.tabPageCleanHands.Controls.Add(this.labelWaiting);
            this.tabPageCleanHands.Controls.Add(this.buttonChooseFolder);
            this.tabPageCleanHands.Controls.Add(this.progressBarHand);
            this.tabPageCleanHands.Controls.Add(this.label1);
            this.tabPageCleanHands.Controls.Add(this.textBoxNickName);
            this.tabPageCleanHands.Controls.Add(this.buttonClean);
            this.tabPageCleanHands.Controls.Add(this.comboBoxSite);
            this.tabPageCleanHands.Location = new System.Drawing.Point(4, 22);
            this.tabPageCleanHands.Name = "tabPageCleanHands";
            this.tabPageCleanHands.Padding = new System.Windows.Forms.Padding(3);
            this.tabPageCleanHands.Size = new System.Drawing.Size(545, 236);
            this.tabPageCleanHands.TabIndex = 0;
            this.tabPageCleanHands.Text = "Clean Hands";
            // 
            // tabPageConvertHandsHive
            // 
            this.tabPageConvertHandsHive.BackColor = System.Drawing.SystemColors.Control;
            this.tabPageConvertHandsHive.Controls.Add(this.labelHandsConverted);
            this.tabPageConvertHandsHive.Controls.Add(this.checkBoxLogs);
            this.tabPageConvertHandsHive.Controls.Add(this.labelStatusHiveHand);
            this.tabPageConvertHandsHive.Controls.Add(this.buttonStopConvertHandHive);
            this.tabPageConvertHandsHive.Controls.Add(this.buttonStartConvertHandHive);
            this.tabPageConvertHandsHive.Controls.Add(this.textBoxHandHiveConverted);
            this.tabPageConvertHandsHive.Controls.Add(this.label5);
            this.tabPageConvertHandsHive.Controls.Add(this.buttonHandsHiveConverted);
            this.tabPageConvertHandsHive.Controls.Add(this.textBoxHandOriginalHive);
            this.tabPageConvertHandsHive.Controls.Add(this.labelFolderHandHiveOriginal);
            this.tabPageConvertHandsHive.Controls.Add(this.buttonFOlderHandHiveOriginal);
            this.tabPageConvertHandsHive.Location = new System.Drawing.Point(4, 22);
            this.tabPageConvertHandsHive.Name = "tabPageConvertHandsHive";
            this.tabPageConvertHandsHive.Padding = new System.Windows.Forms.Padding(3);
            this.tabPageConvertHandsHive.Size = new System.Drawing.Size(545, 236);
            this.tabPageConvertHandsHive.TabIndex = 1;
            this.tabPageConvertHandsHive.Text = "Convert Hands Hive";
            // 
            // checkBoxLogs
            // 
            this.checkBoxLogs.AutoSize = true;
            this.checkBoxLogs.Location = new System.Drawing.Point(20, 205);
            this.checkBoxLogs.Name = "checkBoxLogs";
            this.checkBoxLogs.Size = new System.Drawing.Size(49, 17);
            this.checkBoxLogs.TabIndex = 12;
            this.checkBoxLogs.Text = "Logs";
            this.checkBoxLogs.UseVisualStyleBackColor = true;
            this.checkBoxLogs.CheckedChanged += new System.EventHandler(this.checkBoxLogs_CheckedChanged);
            // 
            // labelStatusHiveHand
            // 
            this.labelStatusHiveHand.AutoSize = true;
            this.labelStatusHiveHand.ForeColor = System.Drawing.SystemColors.Control;
            this.labelStatusHiveHand.Location = new System.Drawing.Point(242, 210);
            this.labelStatusHiveHand.Name = "labelStatusHiveHand";
            this.labelStatusHiveHand.Size = new System.Drawing.Size(67, 13);
            this.labelStatusHiveHand.TabIndex = 11;
            this.labelStatusHiveHand.Text = "__________";
            // 
            // buttonStopConvertHandHive
            // 
            this.buttonStopConvertHandHive.Enabled = false;
            this.buttonStopConvertHandHive.Location = new System.Drawing.Point(293, 141);
            this.buttonStopConvertHandHive.Name = "buttonStopConvertHandHive";
            this.buttonStopConvertHandHive.Size = new System.Drawing.Size(164, 54);
            this.buttonStopConvertHandHive.TabIndex = 10;
            this.buttonStopConvertHandHive.Text = "Stop";
            this.buttonStopConvertHandHive.UseVisualStyleBackColor = true;
            this.buttonStopConvertHandHive.Click += new System.EventHandler(this.buttonStopConvertHandHive_Click);
            // 
            // buttonStartConvertHandHive
            // 
            this.buttonStartConvertHandHive.Location = new System.Drawing.Point(92, 141);
            this.buttonStartConvertHandHive.Name = "buttonStartConvertHandHive";
            this.buttonStartConvertHandHive.Size = new System.Drawing.Size(164, 54);
            this.buttonStartConvertHandHive.TabIndex = 9;
            this.buttonStartConvertHandHive.Text = "Start";
            this.buttonStartConvertHandHive.UseVisualStyleBackColor = true;
            this.buttonStartConvertHandHive.Click += new System.EventHandler(this.buttonStartConvertHandHive_Click);
            // 
            // textBoxHandHiveConverted
            // 
            this.textBoxHandHiveConverted.Enabled = false;
            this.textBoxHandHiveConverted.Location = new System.Drawing.Point(178, 76);
            this.textBoxHandHiveConverted.Name = "textBoxHandHiveConverted";
            this.textBoxHandHiveConverted.Size = new System.Drawing.Size(263, 20);
            this.textBoxHandHiveConverted.TabIndex = 6;
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label5.Location = new System.Drawing.Point(17, 77);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(155, 16);
            this.label5.TabIndex = 7;
            this.label5.Text = "Folder Hands Converted";
            // 
            // buttonHandsHiveConverted
            // 
            this.buttonHandsHiveConverted.Image = ((System.Drawing.Image)(resources.GetObject("buttonHandsHiveConverted.Image")));
            this.buttonHandsHiveConverted.Location = new System.Drawing.Point(447, 70);
            this.buttonHandsHiveConverted.Name = "buttonHandsHiveConverted";
            this.buttonHandsHiveConverted.Size = new System.Drawing.Size(33, 30);
            this.buttonHandsHiveConverted.TabIndex = 8;
            this.buttonHandsHiveConverted.UseVisualStyleBackColor = true;
            this.buttonHandsHiveConverted.Click += new System.EventHandler(this.buttonHandsHiveConverted_Click);
            // 
            // textBoxHandOriginalHive
            // 
            this.textBoxHandOriginalHive.Enabled = false;
            this.textBoxHandOriginalHive.Location = new System.Drawing.Point(178, 37);
            this.textBoxHandOriginalHive.Name = "textBoxHandOriginalHive";
            this.textBoxHandOriginalHive.Size = new System.Drawing.Size(263, 20);
            this.textBoxHandOriginalHive.TabIndex = 3;
            // 
            // labelFolderHandHiveOriginal
            // 
            this.labelFolderHandHiveOriginal.AutoSize = true;
            this.labelFolderHandHiveOriginal.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelFolderHandHiveOriginal.Location = new System.Drawing.Point(17, 38);
            this.labelFolderHandHiveOriginal.Name = "labelFolderHandHiveOriginal";
            this.labelFolderHandHiveOriginal.Size = new System.Drawing.Size(139, 16);
            this.labelFolderHandHiveOriginal.TabIndex = 4;
            this.labelFolderHandHiveOriginal.Text = "Folder Hands Original";
            // 
            // buttonFOlderHandHiveOriginal
            // 
            this.buttonFOlderHandHiveOriginal.Image = ((System.Drawing.Image)(resources.GetObject("buttonFOlderHandHiveOriginal.Image")));
            this.buttonFOlderHandHiveOriginal.Location = new System.Drawing.Point(447, 31);
            this.buttonFOlderHandHiveOriginal.Name = "buttonFOlderHandHiveOriginal";
            this.buttonFOlderHandHiveOriginal.Size = new System.Drawing.Size(33, 30);
            this.buttonFOlderHandHiveOriginal.TabIndex = 5;
            this.buttonFOlderHandHiveOriginal.UseVisualStyleBackColor = true;
            this.buttonFOlderHandHiveOriginal.Click += new System.EventHandler(this.buttonFOlderHandHiveOriginal_Click);
            // 
            // labelHandsConverted
            // 
            this.labelHandsConverted.AutoSize = true;
            this.labelHandsConverted.Location = new System.Drawing.Point(208, 115);
            this.labelHandsConverted.Name = "labelHandsConverted";
            this.labelHandsConverted.Size = new System.Drawing.Size(101, 13);
            this.labelHandsConverted.TabIndex = 13;
            this.labelHandsConverted.Text = "Hands converted: 0";
            // 
            // FormInicial
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(576, 296);
            this.Controls.Add(this.tabControlMain);
            this.Controls.Add(this.label3);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormInicial";
            this.Text = "Hand History";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.Main_FormClosed);
            this.tabControlMain.ResumeLayout(false);
            this.tabPageCleanHands.ResumeLayout(false);
            this.tabPageCleanHands.PerformLayout();
            this.tabPageConvertHandsHive.ResumeLayout(false);
            this.tabPageConvertHandsHive.PerformLayout();
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
        private System.Windows.Forms.TabControl tabControlMain;
        private System.Windows.Forms.TabPage tabPageCleanHands;
        private System.Windows.Forms.TabPage tabPageConvertHandsHive;
        private System.Windows.Forms.TextBox textBoxHandOriginalHive;
        private System.Windows.Forms.Label labelFolderHandHiveOriginal;
        private System.Windows.Forms.Button buttonFOlderHandHiveOriginal;
        private System.Windows.Forms.Button buttonStopConvertHandHive;
        private System.Windows.Forms.Button buttonStartConvertHandHive;
        private System.Windows.Forms.TextBox textBoxHandHiveConverted;
        private System.Windows.Forms.Label label5;
        private System.Windows.Forms.Button buttonHandsHiveConverted;
        private System.Windows.Forms.Label labelStatusHiveHand;
        private System.Windows.Forms.CheckBox checkBoxLogs;
        private System.Windows.Forms.Label labelHandsConverted;
    }
}

