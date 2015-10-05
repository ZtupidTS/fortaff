namespace StopLoss
{
    partial class FormViewEvaluation
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormViewEvaluation));
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label3 = new System.Windows.Forms.Label();
            this.label4 = new System.Windows.Forms.Label();
            this.labelEvaPhysical = new System.Windows.Forms.Label();
            this.labelEvaMental = new System.Windows.Forms.Label();
            this.labelEvaTechnical = new System.Windows.Forms.Label();
            this.labelEvaPractive = new System.Windows.Forms.Label();
            this.buttonSearch = new System.Windows.Forms.Button();
            this.dateTimePickerEnd = new System.Windows.Forms.DateTimePicker();
            this.labelEnd = new System.Windows.Forms.Label();
            this.labelStartDate = new System.Windows.Forms.Label();
            this.dateTimePickerStart = new System.Windows.Forms.DateTimePicker();
            this.SuspendLayout();
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.ForeColor = System.Drawing.Color.Blue;
            this.label1.Location = new System.Drawing.Point(133, 59);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(124, 31);
            this.label1.TabIndex = 0;
            this.label1.Text = "Physical";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label2.ForeColor = System.Drawing.Color.Blue;
            this.label2.Location = new System.Drawing.Point(133, 106);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(101, 31);
            this.label2.TabIndex = 1;
            this.label2.Text = "Mental";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label3.ForeColor = System.Drawing.Color.Blue;
            this.label3.Location = new System.Drawing.Point(133, 150);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(140, 31);
            this.label3.TabIndex = 2;
            this.label3.Text = "Technical";
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label4.ForeColor = System.Drawing.Color.Blue;
            this.label4.Location = new System.Drawing.Point(133, 194);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(121, 31);
            this.label4.TabIndex = 3;
            this.label4.Text = "Practice";
            // 
            // labelEvaPhysical
            // 
            this.labelEvaPhysical.AutoSize = true;
            this.labelEvaPhysical.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelEvaPhysical.Location = new System.Drawing.Point(279, 59);
            this.labelEvaPhysical.Name = "labelEvaPhysical";
            this.labelEvaPhysical.Size = new System.Drawing.Size(71, 31);
            this.labelEvaPhysical.TabIndex = 4;
            this.labelEvaPhysical.Text = "90%";
            // 
            // labelEvaMental
            // 
            this.labelEvaMental.AutoSize = true;
            this.labelEvaMental.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelEvaMental.Location = new System.Drawing.Point(279, 106);
            this.labelEvaMental.Name = "labelEvaMental";
            this.labelEvaMental.Size = new System.Drawing.Size(71, 31);
            this.labelEvaMental.TabIndex = 5;
            this.labelEvaMental.Text = "90%";
            // 
            // labelEvaTechnical
            // 
            this.labelEvaTechnical.AutoSize = true;
            this.labelEvaTechnical.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelEvaTechnical.Location = new System.Drawing.Point(279, 150);
            this.labelEvaTechnical.Name = "labelEvaTechnical";
            this.labelEvaTechnical.Size = new System.Drawing.Size(71, 31);
            this.labelEvaTechnical.TabIndex = 6;
            this.labelEvaTechnical.Text = "90%";
            // 
            // labelEvaPractive
            // 
            this.labelEvaPractive.AutoSize = true;
            this.labelEvaPractive.Font = new System.Drawing.Font("Microsoft Sans Serif", 20.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelEvaPractive.Location = new System.Drawing.Point(279, 194);
            this.labelEvaPractive.Name = "labelEvaPractive";
            this.labelEvaPractive.Size = new System.Drawing.Size(71, 31);
            this.labelEvaPractive.TabIndex = 7;
            this.labelEvaPractive.Text = "90%";
            // 
            // buttonSearch
            // 
            this.buttonSearch.Location = new System.Drawing.Point(398, 18);
            this.buttonSearch.Name = "buttonSearch";
            this.buttonSearch.Size = new System.Drawing.Size(75, 23);
            this.buttonSearch.TabIndex = 14;
            this.buttonSearch.Text = "Search";
            this.buttonSearch.UseVisualStyleBackColor = true;
            this.buttonSearch.Click += new System.EventHandler(this.buttonSearch_Click);
            // 
            // dateTimePickerEnd
            // 
            this.dateTimePickerEnd.CustomFormat = "yyyy-MM-dd H:mm:ss";
            this.dateTimePickerEnd.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.dateTimePickerEnd.Location = new System.Drawing.Point(246, 20);
            this.dateTimePickerEnd.Name = "dateTimePickerEnd";
            this.dateTimePickerEnd.Size = new System.Drawing.Size(140, 20);
            this.dateTimePickerEnd.TabIndex = 13;
            this.dateTimePickerEnd.Value = new System.DateTime(2014, 10, 18, 20, 13, 13, 0);
            // 
            // labelEnd
            // 
            this.labelEnd.AutoSize = true;
            this.labelEnd.Location = new System.Drawing.Point(214, 23);
            this.labelEnd.Name = "labelEnd";
            this.labelEnd.Size = new System.Drawing.Size(26, 13);
            this.labelEnd.TabIndex = 12;
            this.labelEnd.Text = "End";
            // 
            // labelStartDate
            // 
            this.labelStartDate.AutoSize = true;
            this.labelStartDate.Location = new System.Drawing.Point(22, 23);
            this.labelStartDate.Name = "labelStartDate";
            this.labelStartDate.Size = new System.Drawing.Size(29, 13);
            this.labelStartDate.TabIndex = 11;
            this.labelStartDate.Text = "Start";
            // 
            // dateTimePickerStart
            // 
            this.dateTimePickerStart.CustomFormat = "yyyy-MM-dd H:mm:ss";
            this.dateTimePickerStart.Format = System.Windows.Forms.DateTimePickerFormat.Custom;
            this.dateTimePickerStart.Location = new System.Drawing.Point(56, 20);
            this.dateTimePickerStart.Name = "dateTimePickerStart";
            this.dateTimePickerStart.Size = new System.Drawing.Size(143, 20);
            this.dateTimePickerStart.TabIndex = 10;
            this.dateTimePickerStart.Value = new System.DateTime(2014, 10, 18, 20, 12, 10, 0);
            // 
            // FormViewEvaluation
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(483, 250);
            this.Controls.Add(this.buttonSearch);
            this.Controls.Add(this.dateTimePickerEnd);
            this.Controls.Add(this.labelEnd);
            this.Controls.Add(this.labelStartDate);
            this.Controls.Add(this.dateTimePickerStart);
            this.Controls.Add(this.labelEvaPractive);
            this.Controls.Add(this.labelEvaTechnical);
            this.Controls.Add(this.labelEvaMental);
            this.Controls.Add(this.labelEvaPhysical);
            this.Controls.Add(this.label4);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.label1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormViewEvaluation";
            this.Text = "Evaluation";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.FormEvaluation_FormClosed);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.Label labelEvaPhysical;
        private System.Windows.Forms.Label labelEvaMental;
        private System.Windows.Forms.Label labelEvaTechnical;
        private System.Windows.Forms.Label labelEvaPractive;
        private System.Windows.Forms.Button buttonSearch;
        private System.Windows.Forms.DateTimePicker dateTimePickerEnd;
        private System.Windows.Forms.Label labelEnd;
        private System.Windows.Forms.Label labelStartDate;
        private System.Windows.Forms.DateTimePicker dateTimePickerStart;
    }
}