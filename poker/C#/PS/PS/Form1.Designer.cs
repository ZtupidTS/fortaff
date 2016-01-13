namespace PS
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
            this.buttonStart = new System.Windows.Forms.Button();
            this.buttonStop = new System.Windows.Forms.Button();
            this.textBoxLogin = new System.Windows.Forms.TextBox();
            this.checkBoxLogin = new System.Windows.Forms.CheckBox();
            this.checkBoxDown = new System.Windows.Forms.CheckBox();
            this.checkBoxZoom = new System.Windows.Forms.CheckBox();
            this.textBoxVm = new System.Windows.Forms.TextBox();
            this.buttonConnectVpn = new System.Windows.Forms.Button();
            this.textBoxVpn1 = new System.Windows.Forms.TextBox();
            this.textBoxVpn2 = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.textBoxVpn3 = new System.Windows.Forms.TextBox();
            this.textBoxDrive = new System.Windows.Forms.TextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.listBox1 = new System.Windows.Forms.ListBox();
            this.label3 = new System.Windows.Forms.Label();
            this.SuspendLayout();
            // 
            // buttonStart
            // 
            this.buttonStart.Location = new System.Drawing.Point(13, 211);
            this.buttonStart.Name = "buttonStart";
            this.buttonStart.Size = new System.Drawing.Size(45, 23);
            this.buttonStart.TabIndex = 0;
            this.buttonStart.Text = "Start";
            this.buttonStart.TextAlign = System.Drawing.ContentAlignment.TopCenter;
            this.buttonStart.UseVisualStyleBackColor = true;
            this.buttonStart.Click += new System.EventHandler(this.buttonStart_Click);
            // 
            // buttonStop
            // 
            this.buttonStop.Location = new System.Drawing.Point(76, 211);
            this.buttonStop.Name = "buttonStop";
            this.buttonStop.Size = new System.Drawing.Size(97, 23);
            this.buttonStop.TabIndex = 1;
            this.buttonStop.Text = "Stop (close all)";
            this.buttonStop.TextAlign = System.Drawing.ContentAlignment.TopCenter;
            this.buttonStop.UseVisualStyleBackColor = true;
            this.buttonStop.Click += new System.EventHandler(this.buttonStop_Click);
            // 
            // textBoxLogin
            // 
            this.textBoxLogin.Location = new System.Drawing.Point(56, 182);
            this.textBoxLogin.Name = "textBoxLogin";
            this.textBoxLogin.Size = new System.Drawing.Size(122, 20);
            this.textBoxLogin.TabIndex = 2;
            // 
            // checkBoxLogin
            // 
            this.checkBoxLogin.AutoSize = true;
            this.checkBoxLogin.Location = new System.Drawing.Point(96, 284);
            this.checkBoxLogin.Name = "checkBoxLogin";
            this.checkBoxLogin.Size = new System.Drawing.Size(77, 17);
            this.checkBoxLogin.TabIndex = 3;
            this.checkBoxLogin.Text = "With Login";
            this.checkBoxLogin.UseVisualStyleBackColor = true;
            this.checkBoxLogin.Visible = false;
            // 
            // checkBoxDown
            // 
            this.checkBoxDown.AutoSize = true;
            this.checkBoxDown.Location = new System.Drawing.Point(94, 258);
            this.checkBoxDown.Name = "checkBoxDown";
            this.checkBoxDown.Size = new System.Drawing.Size(79, 17);
            this.checkBoxDown.TabIndex = 4;
            this.checkBoxDown.Text = "down to up";
            this.checkBoxDown.UseVisualStyleBackColor = true;
            this.checkBoxDown.Visible = false;
            // 
            // checkBoxZoom
            // 
            this.checkBoxZoom.AutoSize = true;
            this.checkBoxZoom.Location = new System.Drawing.Point(13, 258);
            this.checkBoxZoom.Name = "checkBoxZoom";
            this.checkBoxZoom.Size = new System.Drawing.Size(53, 17);
            this.checkBoxZoom.TabIndex = 5;
            this.checkBoxZoom.Text = "Zoom";
            this.checkBoxZoom.UseVisualStyleBackColor = true;
            this.checkBoxZoom.Visible = false;
            // 
            // textBoxVm
            // 
            this.textBoxVm.Location = new System.Drawing.Point(12, 281);
            this.textBoxVm.Name = "textBoxVm";
            this.textBoxVm.Size = new System.Drawing.Size(29, 20);
            this.textBoxVm.TabIndex = 6;
            this.textBoxVm.Visible = false;
            // 
            // buttonConnectVpn
            // 
            this.buttonConnectVpn.Location = new System.Drawing.Point(12, 337);
            this.buttonConnectVpn.Name = "buttonConnectVpn";
            this.buttonConnectVpn.Size = new System.Drawing.Size(160, 23);
            this.buttonConnectVpn.TabIndex = 7;
            this.buttonConnectVpn.Text = "Connect Vpn";
            this.buttonConnectVpn.UseVisualStyleBackColor = true;
            this.buttonConnectVpn.Visible = false;
            // 
            // textBoxVpn1
            // 
            this.textBoxVpn1.Location = new System.Drawing.Point(13, 367);
            this.textBoxVpn1.Name = "textBoxVpn1";
            this.textBoxVpn1.Size = new System.Drawing.Size(159, 20);
            this.textBoxVpn1.TabIndex = 8;
            // 
            // textBoxVpn2
            // 
            this.textBoxVpn2.Location = new System.Drawing.Point(12, 394);
            this.textBoxVpn2.Name = "textBoxVpn2";
            this.textBoxVpn2.Size = new System.Drawing.Size(160, 20);
            this.textBoxVpn2.TabIndex = 9;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(44, 163);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(35, 13);
            this.label1.TabIndex = 10;
            this.label1.Text = "Vm nº";
            // 
            // textBoxVpn3
            // 
            this.textBoxVpn3.Location = new System.Drawing.Point(13, 421);
            this.textBoxVpn3.Name = "textBoxVpn3";
            this.textBoxVpn3.Size = new System.Drawing.Size(159, 20);
            this.textBoxVpn3.TabIndex = 11;
            // 
            // textBoxDrive
            // 
            this.textBoxDrive.Location = new System.Drawing.Point(14, 447);
            this.textBoxDrive.Name = "textBoxDrive";
            this.textBoxDrive.Size = new System.Drawing.Size(27, 20);
            this.textBoxDrive.TabIndex = 12;
            this.textBoxDrive.Visible = false;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(47, 284);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(32, 13);
            this.label2.TabIndex = 13;
            this.label2.Text = "Drive";
            // 
            // listBox1
            // 
            this.listBox1.FormattingEnabled = true;
            this.listBox1.Location = new System.Drawing.Point(13, 13);
            this.listBox1.Name = "listBox1";
            this.listBox1.Size = new System.Drawing.Size(201, 147);
            this.listBox1.TabIndex = 14;
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(12, 185);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(41, 13);
            this.label3.TabIndex = 15;
            this.label3.Text = "IP vpn:";
            // 
            // FormInicial
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(226, 249);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.listBox1);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.textBoxDrive);
            this.Controls.Add(this.textBoxVpn3);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.textBoxVpn2);
            this.Controls.Add(this.textBoxVpn1);
            this.Controls.Add(this.buttonConnectVpn);
            this.Controls.Add(this.textBoxVm);
            this.Controls.Add(this.checkBoxZoom);
            this.Controls.Add(this.checkBoxDown);
            this.Controls.Add(this.checkBoxLogin);
            this.Controls.Add(this.textBoxLogin);
            this.Controls.Add(this.buttonStop);
            this.Controls.Add(this.buttonStart);
            this.Name = "FormInicial";
            this.Text = "PS";
            this.FormClosed += new System.Windows.Forms.FormClosedEventHandler(this.FormInicial_FormClosed);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button buttonStart;
        private System.Windows.Forms.Button buttonStop;
        private System.Windows.Forms.TextBox textBoxLogin;
        private System.Windows.Forms.CheckBox checkBoxLogin;
        private System.Windows.Forms.CheckBox checkBoxDown;
        private System.Windows.Forms.CheckBox checkBoxZoom;
        private System.Windows.Forms.TextBox textBoxVm;
        private System.Windows.Forms.Button buttonConnectVpn;
        private System.Windows.Forms.TextBox textBoxVpn1;
        private System.Windows.Forms.TextBox textBoxVpn2;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.TextBox textBoxVpn3;
        private System.Windows.Forms.TextBox textBoxDrive;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.ListBox listBox1;
        private System.Windows.Forms.Label label3;
    }
}

