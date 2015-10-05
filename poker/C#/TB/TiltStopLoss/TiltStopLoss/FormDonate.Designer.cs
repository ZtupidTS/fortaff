namespace StopLoss
{
    partial class FormDonate
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormDonate));
            this.label1 = new System.Windows.Forms.Label();
            this.comboBoxCurrency = new System.Windows.Forms.ComboBox();
            this.buttonGoPaypal = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(1, 21);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(85, 13);
            this.label1.TabIndex = 0;
            this.label1.Text = "Select Currency:";
            // 
            // comboBoxCurrency
            // 
            this.comboBoxCurrency.FormattingEnabled = true;
            this.comboBoxCurrency.Location = new System.Drawing.Point(92, 18);
            this.comboBoxCurrency.Name = "comboBoxCurrency";
            this.comboBoxCurrency.Size = new System.Drawing.Size(159, 21);
            this.comboBoxCurrency.TabIndex = 0;
            // 
            // buttonGoPaypal
            // 
            this.buttonGoPaypal.Location = new System.Drawing.Point(81, 55);
            this.buttonGoPaypal.Name = "buttonGoPaypal";
            this.buttonGoPaypal.Size = new System.Drawing.Size(113, 40);
            this.buttonGoPaypal.TabIndex = 2;
            this.buttonGoPaypal.Text = "To Paypal";
            this.buttonGoPaypal.UseVisualStyleBackColor = true;
            this.buttonGoPaypal.Click += new System.EventHandler(this.buttonGoPaypal_Click);
            // 
            // FormDonate
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.White;
            this.ClientSize = new System.Drawing.Size(263, 107);
            this.Controls.Add(this.buttonGoPaypal);
            this.Controls.Add(this.comboBoxCurrency);
            this.Controls.Add(this.label1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormDonate";
            this.Text = "Donate";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.ComboBox comboBoxCurrency;
        private System.Windows.Forms.Button buttonGoPaypal;
    }
}