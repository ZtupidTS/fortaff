namespace TiltStopLoss
{
    partial class Stoploss
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        public System.ComponentModel.IContainer components = null;

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
        public void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Stoploss));
            this.buttonStop = new System.Windows.Forms.Button();
            this.labelTimer = new System.Windows.Forms.Label();
            this.labelBb = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.labelHands = new System.Windows.Forms.Label();
            this.buttonSet = new System.Windows.Forms.Button();
            this.labelStop = new System.Windows.Forms.Label();
            this.buttonRageQuit = new System.Windows.Forms.Button();
            this.buttonSnooze = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // buttonStop
            // 
            this.buttonStop.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonStop.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F);
            this.buttonStop.Location = new System.Drawing.Point(153, 29);
            this.buttonStop.Name = "buttonStop";
            this.buttonStop.Size = new System.Drawing.Size(37, 23);
            this.buttonStop.TabIndex = 0;
            this.buttonStop.Text = "Stop";
            this.buttonStop.UseVisualStyleBackColor = true;
            this.buttonStop.Click += new System.EventHandler(this.buttonStop_Click);
            // 
            // labelTimer
            // 
            this.labelTimer.AutoSize = true;
            this.labelTimer.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelTimer.Location = new System.Drawing.Point(131, 7);
            this.labelTimer.Name = "labelTimer";
            this.labelTimer.Size = new System.Drawing.Size(56, 16);
            this.labelTimer.TabIndex = 1;
            this.labelTimer.Text = "00:00:00";
            this.labelTimer.Click += new System.EventHandler(this.labelTimer_Click);
            // 
            // labelBb
            // 
            this.labelBb.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.labelBb.AutoSize = true;
            this.labelBb.Font = new System.Drawing.Font("Arial Rounded MT Bold", 15.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelBb.ForeColor = System.Drawing.SystemColors.Window;
            this.labelBb.Location = new System.Drawing.Point(21, 7);
            this.labelBb.Name = "labelBb";
            this.labelBb.Size = new System.Drawing.Size(71, 24);
            this.labelBb.TabIndex = 2;
            this.labelBb.Text = "label1";
            this.labelBb.MouseLeave += new System.EventHandler(this.labelBb_MouseLeave);
            this.labelBb.MouseHover += new System.EventHandler(this.labelBb_MouseHover);
            // 
            // label1
            // 
            this.label1.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.Location = new System.Drawing.Point(5, 37);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(51, 16);
            this.label1.TabIndex = 3;
            this.label1.Text = "Hands:";
            // 
            // labelHands
            // 
            this.labelHands.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.labelHands.AutoSize = true;
            this.labelHands.Font = new System.Drawing.Font("Microsoft Sans Serif", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelHands.Location = new System.Drawing.Point(52, 37);
            this.labelHands.Name = "labelHands";
            this.labelHands.Size = new System.Drawing.Size(15, 16);
            this.labelHands.TabIndex = 4;
            this.labelHands.Text = "0";
            // 
            // buttonSet
            // 
            this.buttonSet.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonSet.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F);
            this.buttonSet.Location = new System.Drawing.Point(117, 29);
            this.buttonSet.Name = "buttonSet";
            this.buttonSet.Size = new System.Drawing.Size(31, 23);
            this.buttonSet.TabIndex = 5;
            this.buttonSet.Text = "Set";
            this.buttonSet.UseVisualStyleBackColor = true;
            this.buttonSet.Click += new System.EventHandler(this.buttonSet_Click);
            // 
            // labelStop
            // 
            this.labelStop.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.labelStop.AutoSize = true;
            this.labelStop.Font = new System.Drawing.Font("Microsoft Sans Serif", 6.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.labelStop.ForeColor = System.Drawing.Color.White;
            this.labelStop.Location = new System.Drawing.Point(38, 61);
            this.labelStop.Name = "labelStop";
            this.labelStop.Size = new System.Drawing.Size(113, 12);
            this.labelStop.TabIndex = 6;
            this.labelStop.Text = "__________________";
            // 
            // buttonRageQuit
            // 
            this.buttonRageQuit.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonRageQuit.Font = new System.Drawing.Font("Microsoft Sans Serif", 6.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.buttonRageQuit.Location = new System.Drawing.Point(2, 57);
            this.buttonRageQuit.Name = "buttonRageQuit";
            this.buttonRageQuit.Size = new System.Drawing.Size(36, 23);
            this.buttonRageQuit.TabIndex = 7;
            this.buttonRageQuit.Text = "Rage";
            this.buttonRageQuit.UseVisualStyleBackColor = true;
            this.buttonRageQuit.Click += new System.EventHandler(this.buttonRageQuit_Click);
            // 
            // buttonSnooze
            // 
            this.buttonSnooze.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)
                        | System.Windows.Forms.AnchorStyles.Right)));
            this.buttonSnooze.Location = new System.Drawing.Point(163, 57);
            this.buttonSnooze.Name = "buttonSnooze";
            this.buttonSnooze.Size = new System.Drawing.Size(27, 23);
            this.buttonSnooze.TabIndex = 8;
            this.buttonSnooze.Text = "sn";
            this.buttonSnooze.UseVisualStyleBackColor = true;
            this.buttonSnooze.Click += new System.EventHandler(this.buttonSnooze_Click);
            // 
            // Stoploss
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.SystemColors.Window;
            this.ClientSize = new System.Drawing.Size(196, 85);
            this.Controls.Add(this.buttonSnooze);
            this.Controls.Add(this.buttonRageQuit);
            this.Controls.Add(this.labelStop);
            this.Controls.Add(this.buttonSet);
            this.Controls.Add(this.labelHands);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.labelBb);
            this.Controls.Add(this.labelTimer);
            this.Controls.Add(this.buttonStop);
            this.Font = new System.Drawing.Font("Microsoft Sans Serif", 8.25F);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "Stoploss";
            this.Text = "Poker BRM";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.Stoploss_FormClosed);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        public System.Windows.Forms.Button buttonStop;
        private System.Windows.Forms.Label labelTimer;
        private System.Windows.Forms.Label labelBb;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label labelHands;
        private System.Windows.Forms.Button buttonSet;
        private System.Windows.Forms.Label labelStop;
        private System.Windows.Forms.Button buttonRageQuit;
        private System.Windows.Forms.Button buttonSnooze;
    }
}