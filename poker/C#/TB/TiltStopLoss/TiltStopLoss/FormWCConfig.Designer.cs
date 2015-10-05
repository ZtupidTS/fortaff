namespace StopLoss
{
    partial class FormWCConfig
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
            this.components = new System.ComponentModel.Container();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormWCConfig));
            this.tabControlWarmup = new System.Windows.Forms.TabControl();
            this.tabPagePhysical = new System.Windows.Forms.TabPage();
            this.labelActivatep = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.buttonQuestionPhysical = new System.Windows.Forms.Button();
            this.tabPageMental = new System.Windows.Forms.TabPage();
            this.labelActivatem = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.buttonQuestionMental = new System.Windows.Forms.Button();
            this.tabPageTechnical = new System.Windows.Forms.TabPage();
            this.labelActivatet = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.buttonQuestionTechnical = new System.Windows.Forms.Button();
            this.tabPagePractice = new System.Windows.Forms.TabPage();
            this.labelActivatepr = new System.Windows.Forms.Label();
            this.label4 = new System.Windows.Forms.Label();
            this.buttonQuestionPractice = new System.Windows.Forms.Button();
            this.tabControlWarmupCooldown = new System.Windows.Forms.TabControl();
            this.tabPageWarmup = new System.Windows.Forms.TabPage();
            this.tabPageCooldown = new System.Windows.Forms.TabPage();
            this.labelActivateCooldown = new System.Windows.Forms.Label();
            this.label6 = new System.Windows.Forms.Label();
            this.buttonQuestionCooldown = new System.Windows.Forms.Button();
            this.buttonClose = new System.Windows.Forms.Button();
            this.buttonSaveExit = new System.Windows.Forms.Button();
            this.buttonSave = new System.Windows.Forms.Button();
            this.toolTipHelp = new System.Windows.Forms.ToolTip(this.components);
            this.label5 = new System.Windows.Forms.Label();
            this.tabControlWarmup.SuspendLayout();
            this.tabPagePhysical.SuspendLayout();
            this.tabPageMental.SuspendLayout();
            this.tabPageTechnical.SuspendLayout();
            this.tabPagePractice.SuspendLayout();
            this.tabControlWarmupCooldown.SuspendLayout();
            this.tabPageWarmup.SuspendLayout();
            this.tabPageCooldown.SuspendLayout();
            this.SuspendLayout();
            // 
            // tabControlWarmup
            // 
            this.tabControlWarmup.Controls.Add(this.tabPagePhysical);
            this.tabControlWarmup.Controls.Add(this.tabPageMental);
            this.tabControlWarmup.Controls.Add(this.tabPageTechnical);
            this.tabControlWarmup.Controls.Add(this.tabPagePractice);
            this.tabControlWarmup.Location = new System.Drawing.Point(3, 6);
            this.tabControlWarmup.Name = "tabControlWarmup";
            this.tabControlWarmup.SelectedIndex = 0;
            this.tabControlWarmup.Size = new System.Drawing.Size(870, 400);
            this.tabControlWarmup.TabIndex = 1;
            // 
            // tabPagePhysical
            // 
            this.tabPagePhysical.AutoScroll = true;
            this.tabPagePhysical.Controls.Add(this.labelActivatep);
            this.tabPagePhysical.Controls.Add(this.label1);
            this.tabPagePhysical.Controls.Add(this.buttonQuestionPhysical);
            this.tabPagePhysical.Location = new System.Drawing.Point(4, 22);
            this.tabPagePhysical.Name = "tabPagePhysical";
            this.tabPagePhysical.Padding = new System.Windows.Forms.Padding(3);
            this.tabPagePhysical.Size = new System.Drawing.Size(862, 374);
            this.tabPagePhysical.TabIndex = 0;
            this.tabPagePhysical.Text = "Physical";
            this.tabPagePhysical.UseVisualStyleBackColor = true;
            // 
            // labelActivatep
            // 
            this.labelActivatep.AutoSize = true;
            this.labelActivatep.Location = new System.Drawing.Point(725, 17);
            this.labelActivatep.Name = "labelActivatep";
            this.labelActivatep.Size = new System.Drawing.Size(46, 13);
            this.labelActivatep.TabIndex = 2;
            this.labelActivatep.Text = "Activate";
            this.labelActivatep.Visible = false;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.ForeColor = System.Drawing.Color.Red;
            this.label1.Location = new System.Drawing.Point(123, 14);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(281, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "*Only Save the fields fill. Leave in blank for delete on save";
            // 
            // buttonQuestionPhysical
            // 
            this.buttonQuestionPhysical.Location = new System.Drawing.Point(6, 6);
            this.buttonQuestionPhysical.Name = "buttonQuestionPhysical";
            this.buttonQuestionPhysical.Size = new System.Drawing.Size(111, 29);
            this.buttonQuestionPhysical.TabIndex = 0;
            this.buttonQuestionPhysical.Text = "Create Questions";
            this.buttonQuestionPhysical.UseVisualStyleBackColor = true;
            this.buttonQuestionPhysical.Click += new System.EventHandler(this.buttonQuestionPhysical_Click);
            // 
            // tabPageMental
            // 
            this.tabPageMental.AutoScroll = true;
            this.tabPageMental.Controls.Add(this.labelActivatem);
            this.tabPageMental.Controls.Add(this.label2);
            this.tabPageMental.Controls.Add(this.buttonQuestionMental);
            this.tabPageMental.Location = new System.Drawing.Point(4, 22);
            this.tabPageMental.Name = "tabPageMental";
            this.tabPageMental.Padding = new System.Windows.Forms.Padding(3);
            this.tabPageMental.Size = new System.Drawing.Size(862, 374);
            this.tabPageMental.TabIndex = 1;
            this.tabPageMental.Text = "Mental";
            this.tabPageMental.UseVisualStyleBackColor = true;
            // 
            // labelActivatem
            // 
            this.labelActivatem.AutoSize = true;
            this.labelActivatem.Location = new System.Drawing.Point(725, 17);
            this.labelActivatem.Name = "labelActivatem";
            this.labelActivatem.Size = new System.Drawing.Size(46, 13);
            this.labelActivatem.TabIndex = 3;
            this.labelActivatem.Text = "Activate";
            this.labelActivatem.Visible = false;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label2.ForeColor = System.Drawing.Color.Red;
            this.label2.Location = new System.Drawing.Point(123, 14);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(281, 13);
            this.label2.TabIndex = 2;
            this.label2.Text = "*Only Save the fields fill. Leave in blank for delete on save";
            // 
            // buttonQuestionMental
            // 
            this.buttonQuestionMental.Location = new System.Drawing.Point(6, 6);
            this.buttonQuestionMental.Name = "buttonQuestionMental";
            this.buttonQuestionMental.Size = new System.Drawing.Size(111, 29);
            this.buttonQuestionMental.TabIndex = 1;
            this.buttonQuestionMental.Text = "Create Questions";
            this.buttonQuestionMental.UseVisualStyleBackColor = true;
            this.buttonQuestionMental.Click += new System.EventHandler(this.buttonQuestionMental_Click);
            // 
            // tabPageTechnical
            // 
            this.tabPageTechnical.AutoScroll = true;
            this.tabPageTechnical.Controls.Add(this.labelActivatet);
            this.tabPageTechnical.Controls.Add(this.label3);
            this.tabPageTechnical.Controls.Add(this.buttonQuestionTechnical);
            this.tabPageTechnical.Location = new System.Drawing.Point(4, 22);
            this.tabPageTechnical.Name = "tabPageTechnical";
            this.tabPageTechnical.Size = new System.Drawing.Size(862, 374);
            this.tabPageTechnical.TabIndex = 2;
            this.tabPageTechnical.Text = "Technical";
            this.tabPageTechnical.UseVisualStyleBackColor = true;
            // 
            // labelActivatet
            // 
            this.labelActivatet.AutoSize = true;
            this.labelActivatet.Location = new System.Drawing.Point(725, 17);
            this.labelActivatet.Name = "labelActivatet";
            this.labelActivatet.Size = new System.Drawing.Size(46, 13);
            this.labelActivatet.TabIndex = 4;
            this.labelActivatet.Text = "Activate";
            this.labelActivatet.Visible = false;
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label3.ForeColor = System.Drawing.Color.Red;
            this.label3.Location = new System.Drawing.Point(123, 14);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(281, 13);
            this.label3.TabIndex = 3;
            this.label3.Text = "*Only Save the fields fill. Leave in blank for delete on save";
            // 
            // buttonQuestionTechnical
            // 
            this.buttonQuestionTechnical.Location = new System.Drawing.Point(6, 6);
            this.buttonQuestionTechnical.Name = "buttonQuestionTechnical";
            this.buttonQuestionTechnical.Size = new System.Drawing.Size(111, 29);
            this.buttonQuestionTechnical.TabIndex = 2;
            this.buttonQuestionTechnical.Text = "Create Questions";
            this.buttonQuestionTechnical.UseVisualStyleBackColor = true;
            this.buttonQuestionTechnical.Click += new System.EventHandler(this.buttonQuestionTechnical_Click);
            // 
            // tabPagePractice
            // 
            this.tabPagePractice.AutoScroll = true;
            this.tabPagePractice.Controls.Add(this.labelActivatepr);
            this.tabPagePractice.Controls.Add(this.label4);
            this.tabPagePractice.Controls.Add(this.buttonQuestionPractice);
            this.tabPagePractice.Location = new System.Drawing.Point(4, 22);
            this.tabPagePractice.Name = "tabPagePractice";
            this.tabPagePractice.Size = new System.Drawing.Size(862, 374);
            this.tabPagePractice.TabIndex = 3;
            this.tabPagePractice.Text = "Practice";
            this.tabPagePractice.UseVisualStyleBackColor = true;
            // 
            // labelActivatepr
            // 
            this.labelActivatepr.AutoSize = true;
            this.labelActivatepr.Location = new System.Drawing.Point(725, 17);
            this.labelActivatepr.Name = "labelActivatepr";
            this.labelActivatepr.Size = new System.Drawing.Size(46, 13);
            this.labelActivatepr.TabIndex = 4;
            this.labelActivatepr.Text = "Activate";
            this.labelActivatepr.Visible = false;
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label4.ForeColor = System.Drawing.Color.Red;
            this.label4.Location = new System.Drawing.Point(123, 14);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(281, 13);
            this.label4.TabIndex = 3;
            this.label4.Text = "*Only Save the fields fill. Leave in blank for delete on save";
            // 
            // buttonQuestionPractice
            // 
            this.buttonQuestionPractice.Location = new System.Drawing.Point(6, 6);
            this.buttonQuestionPractice.Name = "buttonQuestionPractice";
            this.buttonQuestionPractice.Size = new System.Drawing.Size(111, 29);
            this.buttonQuestionPractice.TabIndex = 2;
            this.buttonQuestionPractice.Text = "Create Questions";
            this.buttonQuestionPractice.UseVisualStyleBackColor = true;
            this.buttonQuestionPractice.Click += new System.EventHandler(this.buttonQuestionPractice_Click);
            // 
            // tabControlWarmupCooldown
            // 
            this.tabControlWarmupCooldown.Controls.Add(this.tabPageWarmup);
            this.tabControlWarmupCooldown.Controls.Add(this.tabPageCooldown);
            this.tabControlWarmupCooldown.Location = new System.Drawing.Point(12, 12);
            this.tabControlWarmupCooldown.Name = "tabControlWarmupCooldown";
            this.tabControlWarmupCooldown.SelectedIndex = 0;
            this.tabControlWarmupCooldown.Size = new System.Drawing.Size(887, 438);
            this.tabControlWarmupCooldown.TabIndex = 2;
            // 
            // tabPageWarmup
            // 
            this.tabPageWarmup.Controls.Add(this.tabControlWarmup);
            this.tabPageWarmup.Location = new System.Drawing.Point(4, 22);
            this.tabPageWarmup.Name = "tabPageWarmup";
            this.tabPageWarmup.Padding = new System.Windows.Forms.Padding(3);
            this.tabPageWarmup.Size = new System.Drawing.Size(879, 412);
            this.tabPageWarmup.TabIndex = 0;
            this.tabPageWarmup.Text = "Warmup";
            this.tabPageWarmup.UseVisualStyleBackColor = true;
            // 
            // tabPageCooldown
            // 
            this.tabPageCooldown.AutoScroll = true;
            this.tabPageCooldown.Controls.Add(this.labelActivateCooldown);
            this.tabPageCooldown.Controls.Add(this.label6);
            this.tabPageCooldown.Controls.Add(this.buttonQuestionCooldown);
            this.tabPageCooldown.Location = new System.Drawing.Point(4, 22);
            this.tabPageCooldown.Name = "tabPageCooldown";
            this.tabPageCooldown.Padding = new System.Windows.Forms.Padding(3);
            this.tabPageCooldown.Size = new System.Drawing.Size(879, 412);
            this.tabPageCooldown.TabIndex = 1;
            this.tabPageCooldown.Text = "Cooldown";
            this.tabPageCooldown.UseVisualStyleBackColor = true;
            // 
            // labelActivateCooldown
            // 
            this.labelActivateCooldown.AutoSize = true;
            this.labelActivateCooldown.Location = new System.Drawing.Point(725, 17);
            this.labelActivateCooldown.Name = "labelActivateCooldown";
            this.labelActivateCooldown.Size = new System.Drawing.Size(46, 13);
            this.labelActivateCooldown.TabIndex = 5;
            this.labelActivateCooldown.Text = "Activate";
            this.labelActivateCooldown.Visible = false;
            // 
            // label6
            // 
            this.label6.AutoSize = true;
            this.label6.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label6.ForeColor = System.Drawing.Color.Red;
            this.label6.Location = new System.Drawing.Point(123, 14);
            this.label6.Name = "label6";
            this.label6.Size = new System.Drawing.Size(281, 13);
            this.label6.TabIndex = 4;
            this.label6.Text = "*Only Save the fields fill. Leave in blank for delete on save";
            // 
            // buttonQuestionCooldown
            // 
            this.buttonQuestionCooldown.Location = new System.Drawing.Point(6, 6);
            this.buttonQuestionCooldown.Name = "buttonQuestionCooldown";
            this.buttonQuestionCooldown.Size = new System.Drawing.Size(111, 29);
            this.buttonQuestionCooldown.TabIndex = 3;
            this.buttonQuestionCooldown.Text = "Create Questions";
            this.buttonQuestionCooldown.UseVisualStyleBackColor = true;
            this.buttonQuestionCooldown.Click += new System.EventHandler(this.buttonQuestionCooldown_Click);
            // 
            // buttonClose
            // 
            this.buttonClose.Image = ((System.Drawing.Image)(resources.GetObject("buttonClose.Image")));
            this.buttonClose.ImageAlign = System.Drawing.ContentAlignment.TopLeft;
            this.buttonClose.Location = new System.Drawing.Point(862, 456);
            this.buttonClose.Name = "buttonClose";
            this.buttonClose.Size = new System.Drawing.Size(37, 36);
            this.buttonClose.TabIndex = 3;
            this.buttonClose.UseVisualStyleBackColor = true;
            this.buttonClose.Click += new System.EventHandler(this.buttonClose_Click);
            this.buttonClose.MouseHover += new System.EventHandler(this.buttonClose_MouseHover);
            // 
            // buttonSaveExit
            // 
            this.buttonSaveExit.Image = ((System.Drawing.Image)(resources.GetObject("buttonSaveExit.Image")));
            this.buttonSaveExit.ImageAlign = System.Drawing.ContentAlignment.TopLeft;
            this.buttonSaveExit.Location = new System.Drawing.Point(781, 456);
            this.buttonSaveExit.Name = "buttonSaveExit";
            this.buttonSaveExit.Size = new System.Drawing.Size(75, 36);
            this.buttonSaveExit.TabIndex = 4;
            this.buttonSaveExit.UseVisualStyleBackColor = true;
            this.buttonSaveExit.Click += new System.EventHandler(this.buttonSaveExit_Click);
            this.buttonSaveExit.MouseHover += new System.EventHandler(this.buttonSaveExit_MouseHover);
            // 
            // buttonSave
            // 
            this.buttonSave.Image = ((System.Drawing.Image)(resources.GetObject("buttonSave.Image")));
            this.buttonSave.ImageAlign = System.Drawing.ContentAlignment.TopLeft;
            this.buttonSave.Location = new System.Drawing.Point(740, 456);
            this.buttonSave.Name = "buttonSave";
            this.buttonSave.Size = new System.Drawing.Size(35, 36);
            this.buttonSave.TabIndex = 5;
            this.buttonSave.UseVisualStyleBackColor = true;
            this.buttonSave.Click += new System.EventHandler(this.buttonSave_Click);
            this.buttonSave.MouseHover += new System.EventHandler(this.buttonSave_MouseHover);
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label5.ForeColor = System.Drawing.Color.Green;
            this.label5.Location = new System.Drawing.Point(220, 8);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(530, 15);
            this.label5.TabIndex = 6;
            this.label5.Text = "Is preferable no change questions and create new for the database and future upda" +
                "te, thank you.";
            // 
            // FormWCConfig
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.AutoSizeMode = System.Windows.Forms.AutoSizeMode.GrowAndShrink;
            this.ClientSize = new System.Drawing.Size(906, 498);
            this.ControlBox = false;
            this.Controls.Add(this.label5);
            this.Controls.Add(this.buttonSave);
            this.Controls.Add(this.buttonSaveExit);
            this.Controls.Add(this.buttonClose);
            this.Controls.Add(this.tabControlWarmupCooldown);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormWCConfig";
            this.Text = "Configuration Warmup and Cooldown";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.FormWCConfig_FormClosed);
            this.tabControlWarmup.ResumeLayout(false);
            this.tabPagePhysical.ResumeLayout(false);
            this.tabPagePhysical.PerformLayout();
            this.tabPageMental.ResumeLayout(false);
            this.tabPageMental.PerformLayout();
            this.tabPageTechnical.ResumeLayout(false);
            this.tabPageTechnical.PerformLayout();
            this.tabPagePractice.ResumeLayout(false);
            this.tabPagePractice.PerformLayout();
            this.tabControlWarmupCooldown.ResumeLayout(false);
            this.tabPageWarmup.ResumeLayout(false);
            this.tabPageCooldown.ResumeLayout(false);
            this.tabPageCooldown.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TabControl tabControlWarmup;
        private System.Windows.Forms.TabPage tabPagePhysical;
        private System.Windows.Forms.TabPage tabPageMental;
        private System.Windows.Forms.TabPage tabPageTechnical;
        private System.Windows.Forms.TabPage tabPagePractice;
        private System.Windows.Forms.Button buttonQuestionPhysical;
        private System.Windows.Forms.Button buttonQuestionMental;
        private System.Windows.Forms.Button buttonQuestionTechnical;
        private System.Windows.Forms.Button buttonQuestionPractice;
        private System.Windows.Forms.TabControl tabControlWarmupCooldown;
        private System.Windows.Forms.TabPage tabPageWarmup;
        private System.Windows.Forms.TabPage tabPageCooldown;
        private System.Windows.Forms.Button buttonClose;
        private System.Windows.Forms.Button buttonSaveExit;
        private System.Windows.Forms.Button buttonSave;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.ToolTip toolTipHelp;
        private System.Windows.Forms.Label labelActivatep;
        private System.Windows.Forms.Label labelActivatem;
        private System.Windows.Forms.Label labelActivatet;
        private System.Windows.Forms.Label labelActivatepr;
        private System.Windows.Forms.Label labelActivateCooldown;
        private System.Windows.Forms.Label label6;
        private System.Windows.Forms.Button buttonQuestionCooldown;
        private System.Windows.Forms.Label label5;

    }
}