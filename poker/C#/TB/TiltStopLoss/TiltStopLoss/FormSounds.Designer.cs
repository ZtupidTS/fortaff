namespace StopLoss
{
    partial class FormSounds
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormSounds));
            this.label9 = new System.Windows.Forms.Label();
            this.buttonBrowseStopLoss = new System.Windows.Forms.Button();
            this.buttonDefaultStopLoss = new System.Windows.Forms.Button();
            this.textBoxSoundStopLoss = new System.Windows.Forms.TextBox();
            this.openFileDialogSounds = new System.Windows.Forms.OpenFileDialog();
            this.buttonOk = new System.Windows.Forms.Button();
            this.label15 = new System.Windows.Forms.Label();
            this.label12 = new System.Windows.Forms.Label();
            this.label8 = new System.Windows.Forms.Label();
            this.textBoxSoundStopHands = new System.Windows.Forms.TextBox();
            this.buttonDefaultStophands = new System.Windows.Forms.Button();
            this.buttonBrwoseStopHands = new System.Windows.Forms.Button();
            this.textBoxSoundStopTime = new System.Windows.Forms.TextBox();
            this.buttonDefaultStopTime = new System.Windows.Forms.Button();
            this.buttonBrowseStopTime = new System.Windows.Forms.Button();
            this.textBoxSoundStopWin = new System.Windows.Forms.TextBox();
            this.buttonStopWin = new System.Windows.Forms.Button();
            this.buttonBrowseStopWin = new System.Windows.Forms.Button();
            this.labelRepeatSound = new System.Windows.Forms.Label();
            this.checkBoxRepeatLoss = new System.Windows.Forms.CheckBox();
            this.checkBoxrepeatHands = new System.Windows.Forms.CheckBox();
            this.checkBoxRepeatTime = new System.Windows.Forms.CheckBox();
            this.checkBoxRepeatWin = new System.Windows.Forms.CheckBox();
            this.SuspendLayout();
            // 
            // label9
            // 
            this.label9.AutoSize = true;
            this.label9.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label9.ForeColor = System.Drawing.Color.Red;
            this.label9.Location = new System.Drawing.Point(7, 36);
            this.label9.Name = "label9";
            this.label9.Size = new System.Drawing.Size(59, 13);
            this.label9.TabIndex = 2;
            this.label9.Text = "StopLoss";
            // 
            // buttonBrowseStopLoss
            // 
            this.buttonBrowseStopLoss.Location = new System.Drawing.Point(315, 31);
            this.buttonBrowseStopLoss.Name = "buttonBrowseStopLoss";
            this.buttonBrowseStopLoss.Size = new System.Drawing.Size(57, 23);
            this.buttonBrowseStopLoss.TabIndex = 3;
            this.buttonBrowseStopLoss.Text = "Browse";
            this.buttonBrowseStopLoss.UseVisualStyleBackColor = true;
            this.buttonBrowseStopLoss.Click += new System.EventHandler(this.buttonBrowseStopLoss_Click);
            // 
            // buttonDefaultStopLoss
            // 
            this.buttonDefaultStopLoss.Location = new System.Drawing.Point(377, 31);
            this.buttonDefaultStopLoss.Name = "buttonDefaultStopLoss";
            this.buttonDefaultStopLoss.Size = new System.Drawing.Size(52, 23);
            this.buttonDefaultStopLoss.TabIndex = 4;
            this.buttonDefaultStopLoss.Text = "Default";
            this.buttonDefaultStopLoss.UseVisualStyleBackColor = true;
            this.buttonDefaultStopLoss.Click += new System.EventHandler(this.buttonDefaultStopLoss_Click);
            // 
            // textBoxSoundStopLoss
            // 
            this.textBoxSoundStopLoss.Location = new System.Drawing.Point(88, 31);
            this.textBoxSoundStopLoss.Name = "textBoxSoundStopLoss";
            this.textBoxSoundStopLoss.Size = new System.Drawing.Size(221, 20);
            this.textBoxSoundStopLoss.TabIndex = 5;
            // 
            // openFileDialogSounds
            // 
            this.openFileDialogSounds.FileName = "openFileDialogSound";
            // 
            // buttonOk
            // 
            this.buttonOk.Location = new System.Drawing.Point(220, 158);
            this.buttonOk.Name = "buttonOk";
            this.buttonOk.Size = new System.Drawing.Size(75, 23);
            this.buttonOk.TabIndex = 6;
            this.buttonOk.Text = "OK";
            this.buttonOk.UseVisualStyleBackColor = true;
            this.buttonOk.Click += new System.EventHandler(this.buttonOk_Click);
            // 
            // label15
            // 
            this.label15.AutoSize = true;
            this.label15.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label15.ForeColor = System.Drawing.Color.Green;
            this.label15.Location = new System.Drawing.Point(7, 118);
            this.label15.Name = "label15";
            this.label15.Size = new System.Drawing.Size(55, 13);
            this.label15.TabIndex = 15;
            this.label15.Text = "StopWin";
            // 
            // label12
            // 
            this.label12.AutoSize = true;
            this.label12.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label12.ForeColor = System.Drawing.Color.Blue;
            this.label12.Location = new System.Drawing.Point(7, 91);
            this.label12.Name = "label12";
            this.label12.Size = new System.Drawing.Size(60, 13);
            this.label12.TabIndex = 14;
            this.label12.Text = "StopTime";
            // 
            // label8
            // 
            this.label8.AutoSize = true;
            this.label8.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label8.Location = new System.Drawing.Point(7, 63);
            this.label8.Name = "label8";
            this.label8.Size = new System.Drawing.Size(69, 13);
            this.label8.TabIndex = 13;
            this.label8.Text = "StopHands";
            // 
            // textBoxSoundStopHands
            // 
            this.textBoxSoundStopHands.Location = new System.Drawing.Point(88, 60);
            this.textBoxSoundStopHands.Name = "textBoxSoundStopHands";
            this.textBoxSoundStopHands.Size = new System.Drawing.Size(221, 20);
            this.textBoxSoundStopHands.TabIndex = 18;
            // 
            // buttonDefaultStophands
            // 
            this.buttonDefaultStophands.Location = new System.Drawing.Point(377, 60);
            this.buttonDefaultStophands.Name = "buttonDefaultStophands";
            this.buttonDefaultStophands.Size = new System.Drawing.Size(52, 23);
            this.buttonDefaultStophands.TabIndex = 17;
            this.buttonDefaultStophands.Text = "Default";
            this.buttonDefaultStophands.UseVisualStyleBackColor = true;
            this.buttonDefaultStophands.Click += new System.EventHandler(this.buttonDefaultStophands_Click);
            // 
            // buttonBrwoseStopHands
            // 
            this.buttonBrwoseStopHands.Location = new System.Drawing.Point(315, 60);
            this.buttonBrwoseStopHands.Name = "buttonBrwoseStopHands";
            this.buttonBrwoseStopHands.Size = new System.Drawing.Size(57, 23);
            this.buttonBrwoseStopHands.TabIndex = 16;
            this.buttonBrwoseStopHands.Text = "Browse";
            this.buttonBrwoseStopHands.UseVisualStyleBackColor = true;
            this.buttonBrwoseStopHands.Click += new System.EventHandler(this.buttonBrwoseStopHands_Click);
            // 
            // textBoxSoundStopTime
            // 
            this.textBoxSoundStopTime.Location = new System.Drawing.Point(88, 88);
            this.textBoxSoundStopTime.Name = "textBoxSoundStopTime";
            this.textBoxSoundStopTime.Size = new System.Drawing.Size(221, 20);
            this.textBoxSoundStopTime.TabIndex = 21;
            // 
            // buttonDefaultStopTime
            // 
            this.buttonDefaultStopTime.Location = new System.Drawing.Point(377, 88);
            this.buttonDefaultStopTime.Name = "buttonDefaultStopTime";
            this.buttonDefaultStopTime.Size = new System.Drawing.Size(52, 23);
            this.buttonDefaultStopTime.TabIndex = 20;
            this.buttonDefaultStopTime.Text = "Default";
            this.buttonDefaultStopTime.UseVisualStyleBackColor = true;
            this.buttonDefaultStopTime.Click += new System.EventHandler(this.buttonDefaultStopTime_Click);
            // 
            // buttonBrowseStopTime
            // 
            this.buttonBrowseStopTime.Location = new System.Drawing.Point(315, 88);
            this.buttonBrowseStopTime.Name = "buttonBrowseStopTime";
            this.buttonBrowseStopTime.Size = new System.Drawing.Size(57, 23);
            this.buttonBrowseStopTime.TabIndex = 19;
            this.buttonBrowseStopTime.Text = "Browse";
            this.buttonBrowseStopTime.UseVisualStyleBackColor = true;
            this.buttonBrowseStopTime.Click += new System.EventHandler(this.buttonBrowseStopTime_Click);
            // 
            // textBoxSoundStopWin
            // 
            this.textBoxSoundStopWin.Location = new System.Drawing.Point(88, 115);
            this.textBoxSoundStopWin.Name = "textBoxSoundStopWin";
            this.textBoxSoundStopWin.Size = new System.Drawing.Size(221, 20);
            this.textBoxSoundStopWin.TabIndex = 24;
            // 
            // buttonStopWin
            // 
            this.buttonStopWin.Location = new System.Drawing.Point(377, 115);
            this.buttonStopWin.Name = "buttonStopWin";
            this.buttonStopWin.Size = new System.Drawing.Size(52, 23);
            this.buttonStopWin.TabIndex = 23;
            this.buttonStopWin.Text = "Default";
            this.buttonStopWin.UseVisualStyleBackColor = true;
            this.buttonStopWin.Click += new System.EventHandler(this.buttonStopWin_Click);
            // 
            // buttonBrowseStopWin
            // 
            this.buttonBrowseStopWin.Location = new System.Drawing.Point(315, 115);
            this.buttonBrowseStopWin.Name = "buttonBrowseStopWin";
            this.buttonBrowseStopWin.Size = new System.Drawing.Size(57, 23);
            this.buttonBrowseStopWin.TabIndex = 22;
            this.buttonBrowseStopWin.Text = "Browse";
            this.buttonBrowseStopWin.UseVisualStyleBackColor = true;
            this.buttonBrowseStopWin.Click += new System.EventHandler(this.buttonBrowseStopWin_Click);
            // 
            // labelRepeatSound
            // 
            this.labelRepeatSound.AutoSize = true;
            this.labelRepeatSound.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelRepeatSound.Location = new System.Drawing.Point(418, 9);
            this.labelRepeatSound.Name = "labelRepeatSound";
            this.labelRepeatSound.Size = new System.Drawing.Size(55, 13);
            this.labelRepeatSound.TabIndex = 25;
            this.labelRepeatSound.Text = "Repeat?";
            // 
            // checkBoxRepeatLoss
            // 
            this.checkBoxRepeatLoss.AutoSize = true;
            this.checkBoxRepeatLoss.Location = new System.Drawing.Point(443, 37);
            this.checkBoxRepeatLoss.Name = "checkBoxRepeatLoss";
            this.checkBoxRepeatLoss.Size = new System.Drawing.Size(15, 14);
            this.checkBoxRepeatLoss.TabIndex = 26;
            this.checkBoxRepeatLoss.UseVisualStyleBackColor = true;
            // 
            // checkBoxrepeatHands
            // 
            this.checkBoxrepeatHands.AutoSize = true;
            this.checkBoxrepeatHands.Location = new System.Drawing.Point(443, 63);
            this.checkBoxrepeatHands.Name = "checkBoxrepeatHands";
            this.checkBoxrepeatHands.Size = new System.Drawing.Size(15, 14);
            this.checkBoxrepeatHands.TabIndex = 27;
            this.checkBoxrepeatHands.UseVisualStyleBackColor = true;
            // 
            // checkBoxRepeatTime
            // 
            this.checkBoxRepeatTime.AutoSize = true;
            this.checkBoxRepeatTime.Location = new System.Drawing.Point(443, 91);
            this.checkBoxRepeatTime.Name = "checkBoxRepeatTime";
            this.checkBoxRepeatTime.Size = new System.Drawing.Size(15, 14);
            this.checkBoxRepeatTime.TabIndex = 28;
            this.checkBoxRepeatTime.UseVisualStyleBackColor = true;
            // 
            // checkBoxRepeatWin
            // 
            this.checkBoxRepeatWin.AutoSize = true;
            this.checkBoxRepeatWin.Location = new System.Drawing.Point(443, 118);
            this.checkBoxRepeatWin.Name = "checkBoxRepeatWin";
            this.checkBoxRepeatWin.Size = new System.Drawing.Size(15, 14);
            this.checkBoxRepeatWin.TabIndex = 29;
            this.checkBoxRepeatWin.UseVisualStyleBackColor = true;
            // 
            // FormSounds
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.White;
            this.ClientSize = new System.Drawing.Size(485, 189);
            this.Controls.Add(this.checkBoxRepeatWin);
            this.Controls.Add(this.checkBoxRepeatTime);
            this.Controls.Add(this.checkBoxrepeatHands);
            this.Controls.Add(this.checkBoxRepeatLoss);
            this.Controls.Add(this.labelRepeatSound);
            this.Controls.Add(this.textBoxSoundStopWin);
            this.Controls.Add(this.buttonStopWin);
            this.Controls.Add(this.buttonBrowseStopWin);
            this.Controls.Add(this.textBoxSoundStopTime);
            this.Controls.Add(this.buttonDefaultStopTime);
            this.Controls.Add(this.buttonBrowseStopTime);
            this.Controls.Add(this.textBoxSoundStopHands);
            this.Controls.Add(this.buttonDefaultStophands);
            this.Controls.Add(this.buttonBrwoseStopHands);
            this.Controls.Add(this.label15);
            this.Controls.Add(this.label12);
            this.Controls.Add(this.label8);
            this.Controls.Add(this.buttonOk);
            this.Controls.Add(this.textBoxSoundStopLoss);
            this.Controls.Add(this.buttonDefaultStopLoss);
            this.Controls.Add(this.buttonBrowseStopLoss);
            this.Controls.Add(this.label9);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormSounds";
            this.Text = "Sounds";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.FormSounds_FormClosed);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Label label9;
        private System.Windows.Forms.Button buttonBrowseStopLoss;
        private System.Windows.Forms.Button buttonDefaultStopLoss;
        private System.Windows.Forms.TextBox textBoxSoundStopLoss;
        private System.Windows.Forms.OpenFileDialog openFileDialogSounds;
        private System.Windows.Forms.Button buttonOk;
        private System.Windows.Forms.Label label15;
        private System.Windows.Forms.Label label12;
        private System.Windows.Forms.Label label8;
        private System.Windows.Forms.TextBox textBoxSoundStopHands;
        private System.Windows.Forms.Button buttonDefaultStophands;
        private System.Windows.Forms.Button buttonBrwoseStopHands;
        private System.Windows.Forms.TextBox textBoxSoundStopTime;
        private System.Windows.Forms.Button buttonDefaultStopTime;
        private System.Windows.Forms.Button buttonBrowseStopTime;
        private System.Windows.Forms.TextBox textBoxSoundStopWin;
        private System.Windows.Forms.Button buttonStopWin;
        private System.Windows.Forms.Button buttonBrowseStopWin;
        private System.Windows.Forms.Label labelRepeatSound;
        private System.Windows.Forms.CheckBox checkBoxRepeatLoss;
        private System.Windows.Forms.CheckBox checkBoxrepeatHands;
        private System.Windows.Forms.CheckBox checkBoxRepeatTime;
        private System.Windows.Forms.CheckBox checkBoxRepeatWin;
    }
}