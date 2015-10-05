namespace StopLoss
{
    partial class FormEvaCoolDown
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormEvaCoolDown));
            this.buttonSaveExit = new System.Windows.Forms.Button();
            this.labelTitle = new System.Windows.Forms.Label();
            this.bindingSourceCooldown = new System.Windows.Forms.BindingSource(this.components);
            this.panelQuestions = new System.Windows.Forms.Panel();
            this.label1 = new System.Windows.Forms.Label();
            this.dateTimePickerStart = new System.Windows.Forms.DateTimePicker();
            this.labelStartDate = new System.Windows.Forms.Label();
            this.labelEnd = new System.Windows.Forms.Label();
            this.dateTimePickerEnd = new System.Windows.Forms.DateTimePicker();
            this.buttonSearch = new System.Windows.Forms.Button();
            ((System.ComponentModel.ISupportInitialize)(this.bindingSourceCooldown)).BeginInit();
            this.panelQuestions.SuspendLayout();
            this.SuspendLayout();
            // 
            // buttonSaveExit
            // 
            this.buttonSaveExit.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonSaveExit.Image = ((System.Drawing.Image)(resources.GetObject("buttonSaveExit.Image")));
            this.buttonSaveExit.Location = new System.Drawing.Point(1151, 429);
            this.buttonSaveExit.Name = "buttonSaveExit";
            this.buttonSaveExit.Size = new System.Drawing.Size(38, 33);
            this.buttonSaveExit.TabIndex = 0;
            this.buttonSaveExit.UseVisualStyleBackColor = true;
            this.buttonSaveExit.Click += new System.EventHandler(this.buttonSaveExit_Click);
            // 
            // labelTitle
            // 
            this.labelTitle.AutoSize = true;
            this.labelTitle.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelTitle.ForeColor = System.Drawing.Color.Blue;
            this.labelTitle.Location = new System.Drawing.Point(12, 9);
            this.labelTitle.Name = "labelTitle";
            this.labelTitle.Size = new System.Drawing.Size(90, 20);
            this.labelTitle.TabIndex = 3;
            this.labelTitle.Text = "CoolDown";
            // 
            // panelQuestions
            // 
            this.panelQuestions.AutoScroll = true;
            this.panelQuestions.Controls.Add(this.label1);
            this.panelQuestions.Location = new System.Drawing.Point(12, 88);
            this.panelQuestions.Name = "panelQuestions";
            this.panelQuestions.Size = new System.Drawing.Size(1177, 335);
            this.panelQuestions.TabIndex = 4;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 9F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.ForeColor = System.Drawing.Color.Green;
            this.label1.Location = new System.Drawing.Point(954, 0);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(74, 15);
            this.label1.TabIndex = 5;
            this.label1.Text = "Evaluation";
            // 
            // dateTimePickerStart
            // 
            this.dateTimePickerStart.CustomFormat = "yyyy-MM-dd H:mm:ss";
            this.dateTimePickerStart.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.dateTimePickerStart.Location = new System.Drawing.Point(47, 52);
            this.dateTimePickerStart.Name = "dateTimePickerStart";
            this.dateTimePickerStart.Size = new System.Drawing.Size(143, 20);
            this.dateTimePickerStart.TabIndex = 5;
            this.dateTimePickerStart.Value = new System.DateTime(2014, 10, 18, 20, 12, 10, 0);
            // 
            // labelStartDate
            // 
            this.labelStartDate.AutoSize = true;
            this.labelStartDate.Location = new System.Drawing.Point(13, 55);
            this.labelStartDate.Name = "labelStartDate";
            this.labelStartDate.Size = new System.Drawing.Size(29, 13);
            this.labelStartDate.TabIndex = 6;
            this.labelStartDate.Text = "Start";
            // 
            // labelEnd
            // 
            this.labelEnd.AutoSize = true;
            this.labelEnd.Location = new System.Drawing.Point(205, 55);
            this.labelEnd.Name = "labelEnd";
            this.labelEnd.Size = new System.Drawing.Size(26, 13);
            this.labelEnd.TabIndex = 7;
            this.labelEnd.Text = "End";
            // 
            // dateTimePickerEnd
            // 
            this.dateTimePickerEnd.CustomFormat = "yyyy-MM-dd H:mm:ss";
            this.dateTimePickerEnd.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.dateTimePickerEnd.Location = new System.Drawing.Point(237, 52);
            this.dateTimePickerEnd.Name = "dateTimePickerEnd";
            this.dateTimePickerEnd.Size = new System.Drawing.Size(140, 20);
            this.dateTimePickerEnd.TabIndex = 8;
            this.dateTimePickerEnd.Value = new System.DateTime(2014, 10, 18, 20, 13, 13, 0);
            // 
            // buttonSearch
            // 
            this.buttonSearch.Location = new System.Drawing.Point(389, 50);
            this.buttonSearch.Name = "buttonSearch";
            this.buttonSearch.Size = new System.Drawing.Size(75, 23);
            this.buttonSearch.TabIndex = 9;
            this.buttonSearch.Text = "Search";
            this.buttonSearch.UseVisualStyleBackColor = true;
            this.buttonSearch.Click += new System.EventHandler(this.buttonSearch_Click);
            // 
            // FormEvaCoolDown
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.AutoScroll = true;
            this.AutoSize = true;
            this.AutoSizeMode = System.Windows.Forms.AutoSizeMode.GrowAndShrink;
            this.ClientSize = new System.Drawing.Size(1201, 474);
            this.ControlBox = false;
            this.Controls.Add(this.buttonSearch);
            this.Controls.Add(this.dateTimePickerEnd);
            this.Controls.Add(this.labelEnd);
            this.Controls.Add(this.labelStartDate);
            this.Controls.Add(this.dateTimePickerStart);
            this.Controls.Add(this.panelQuestions);
            this.Controls.Add(this.labelTitle);
            this.Controls.Add(this.buttonSaveExit);
            this.ForeColor = System.Drawing.SystemColors.ControlText;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormEvaCoolDown";
            this.Text = "Cool Down";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.FormCoolDown_FormClosed);
            ((System.ComponentModel.ISupportInitialize)(this.bindingSourceCooldown)).EndInit();
            this.panelQuestions.ResumeLayout(false);
            this.panelQuestions.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button buttonSaveExit;
        private System.Windows.Forms.Label labelTitle;
        private System.Windows.Forms.BindingSource bindingSourceCooldown;
        private System.Windows.Forms.Panel panelQuestions;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.DateTimePicker dateTimePickerStart;
        private System.Windows.Forms.Label labelStartDate;
        private System.Windows.Forms.Label labelEnd;
        private System.Windows.Forms.DateTimePicker dateTimePickerEnd;
        private System.Windows.Forms.Button buttonSearch;
    }
}