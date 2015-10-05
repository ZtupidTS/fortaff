namespace StopLoss
{
    partial class FormWarmup
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormWarmup));
            this.dataGridViewWarmup = new System.Windows.Forms.DataGridView();
            this.bindingSourceWarmup = new System.Windows.Forms.BindingSource(this.components);
            this.labelTitle = new System.Windows.Forms.Label();
            this.buttonNext = new System.Windows.Forms.Button();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridViewWarmup)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.bindingSourceWarmup)).BeginInit();
            this.SuspendLayout();
            // 
            // dataGridViewWarmup
            // 
            this.dataGridViewWarmup.AllowUserToAddRows = false;
            this.dataGridViewWarmup.AllowUserToDeleteRows = false;
            this.dataGridViewWarmup.AutoSizeRowsMode = System.Windows.Forms.DataGridViewAutoSizeRowsMode.DisplayedCells;
            this.dataGridViewWarmup.BackgroundColor = System.Drawing.Color.White;
            this.dataGridViewWarmup.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            this.dataGridViewWarmup.Location = new System.Drawing.Point(13, 35);
            this.dataGridViewWarmup.Name = "dataGridViewWarmup";
            this.dataGridViewWarmup.Size = new System.Drawing.Size(1101, 324);
            this.dataGridViewWarmup.TabIndex = 0;
            // 
            // labelTitle
            // 
            this.labelTitle.AutoSize = true;
            this.labelTitle.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelTitle.ForeColor = System.Drawing.Color.Blue;
            this.labelTitle.Location = new System.Drawing.Point(12, 9);
            this.labelTitle.Name = "labelTitle";
            this.labelTitle.Size = new System.Drawing.Size(57, 20);
            this.labelTitle.TabIndex = 1;
            this.labelTitle.Text = "label1";
            // 
            // buttonNext
            // 
            this.buttonNext.Image = ((System.Drawing.Image)(resources.GetObject("buttonNext.Image")));
            this.buttonNext.Location = new System.Drawing.Point(1049, 365);
            this.buttonNext.Name = "buttonNext";
            this.buttonNext.RightToLeft = System.Windows.Forms.RightToLeft.No;
            this.buttonNext.Size = new System.Drawing.Size(65, 37);
            this.buttonNext.TabIndex = 2;
            this.buttonNext.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            this.buttonNext.UseVisualStyleBackColor = true;
            this.buttonNext.Click += new System.EventHandler(this.buttonNext_Click);
            // 
            // FormWarmup
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.AutoScroll = true;
            this.AutoSize = true;
            this.AutoSizeMode = System.Windows.Forms.AutoSizeMode.GrowAndShrink;
            this.ClientSize = new System.Drawing.Size(1126, 409);
            this.ControlBox = false;
            this.Controls.Add(this.buttonNext);
            this.Controls.Add(this.labelTitle);
            this.Controls.Add(this.dataGridViewWarmup);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormWarmup";
            this.Text = "Warmup";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.FormWarmup_FormClosed);
            ((System.ComponentModel.ISupportInitialize)(this.dataGridViewWarmup)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.bindingSourceWarmup)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.DataGridView dataGridViewWarmup;
        private System.Windows.Forms.BindingSource bindingSourceWarmup;
        private System.Windows.Forms.Label labelTitle;
        private System.Windows.Forms.Button buttonNext;
    }
}