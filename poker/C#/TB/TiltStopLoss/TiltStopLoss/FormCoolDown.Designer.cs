namespace StopLoss
{
    partial class FormCoolDown
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormCoolDown));
            this.buttonSaveExit = new System.Windows.Forms.Button();
            this.labelTitle = new System.Windows.Forms.Label();
            this.bindingSourceCooldown = new System.Windows.Forms.BindingSource(this.components);
            this.panelQuestions = new System.Windows.Forms.Panel();
            this.label1 = new System.Windows.Forms.Label();
            ((System.ComponentModel.ISupportInitialize)(this.bindingSourceCooldown)).BeginInit();
            this.panelQuestions.SuspendLayout();
            this.SuspendLayout();
            // 
            // buttonSaveExit
            // 
            this.buttonSaveExit.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonSaveExit.Image = ((System.Drawing.Image)(resources.GetObject("buttonSaveExit.Image")));
            this.buttonSaveExit.Location = new System.Drawing.Point(1117, 373);
            this.buttonSaveExit.Name = "buttonSaveExit";
            this.buttonSaveExit.Size = new System.Drawing.Size(72, 33);
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
            this.panelQuestions.Location = new System.Drawing.Point(12, 32);
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
            // FormCoolDown
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.AutoScroll = true;
            this.AutoSize = true;
            this.AutoSizeMode = System.Windows.Forms.AutoSizeMode.GrowAndShrink;
            this.ClientSize = new System.Drawing.Size(1201, 418);
            this.ControlBox = false;
            this.Controls.Add(this.panelQuestions);
            this.Controls.Add(this.labelTitle);
            this.Controls.Add(this.buttonSaveExit);
            this.ForeColor = System.Drawing.SystemColors.ControlText;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "FormCoolDown";
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
    }
}