using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using TiltStopLoss;

namespace StopLoss
{
    public partial class FormSounds : Form
    {
        private Main wmain;
        
        public FormSounds(Main wmain, String[] sounds, Boolean[] repeat)
        {
            InitializeComponent();
            textBoxSoundStopLoss.Text = sounds[0];
            textBoxSoundStopTime.Text = sounds[1];
            textBoxSoundStopWin.Text = sounds[2];
            textBoxSoundStopHands.Text = sounds[3];
            checkBoxRepeatLoss.Checked = repeat[0];
            checkBoxRepeatTime.Checked = repeat[1];
            checkBoxRepeatWin.Checked = repeat[2];
            checkBoxrepeatHands.Checked = repeat[3];
            this.wmain = wmain;
        }

        #region browse sounds
        
        private void buttonBrowseStopLoss_Click(object sender, EventArgs e)
        {
            chooseFile();
            if (!openFileDialogSounds.FileName.Equals(""))
            {
                textBoxSoundStopLoss.Text = System.IO.Path.GetFileName(openFileDialogSounds.FileName);
                new Utils().copyFile(openFileDialogSounds.FileName);            
            }
        }
        
        private void buttonBrwoseStopHands_Click(object sender, EventArgs e)
        {
            chooseFile();
            if (!openFileDialogSounds.FileName.Equals(""))
            {
                textBoxSoundStopHands.Text = System.IO.Path.GetFileName(openFileDialogSounds.FileName);
                new Utils().copyFile(openFileDialogSounds.FileName);
            }
        }

        private void buttonBrowseStopTime_Click(object sender, EventArgs e)
        {
            chooseFile();
            if (!openFileDialogSounds.FileName.Equals(""))
            {
                textBoxSoundStopTime.Text = System.IO.Path.GetFileName(openFileDialogSounds.FileName);
                new Utils().copyFile(openFileDialogSounds.FileName);
            }
        }

        private void buttonBrowseStopWin_Click(object sender, EventArgs e)
        {
            chooseFile();
            if (!openFileDialogSounds.FileName.Equals(""))
            {
                textBoxSoundStopWin.Text = System.IO.Path.GetFileName(openFileDialogSounds.FileName);
                new Utils().copyFile(openFileDialogSounds.FileName);
            }
        }

        private void chooseFile()
        {
            openFileDialogSounds.Filter = "Sound Wave,MP3|*.wav;*.mp3";
            openFileDialogSounds.FileName = "";
            openFileDialogSounds.ShowDialog();
        }

        #endregion

        #region default sounds

        private void buttonDefaultStopLoss_Click(object sender, EventArgs e)
        {
            textBoxSoundStopLoss.Text = "alarm.wav";
        }

        private void buttonDefaultStophands_Click(object sender, EventArgs e)
        {
            textBoxSoundStopHands.Text = "alarm.wav";
        }

        private void buttonDefaultStopTime_Click(object sender, EventArgs e)
        {
            textBoxSoundStopTime.Text = "alarm.wav";
        }

        private void buttonStopWin_Click(object sender, EventArgs e)
        {
            textBoxSoundStopWin.Text = "alarm.wav";
        }

        #endregion

        /// <summary>
        /// close form
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void buttonOk_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void FormSounds_FormClosed(object sender, FormClosedEventArgs e)
        {
            Boolean[] repeat = new Boolean[] { checkBoxRepeatLoss.Checked, checkBoxRepeatTime.Checked, checkBoxRepeatWin.Checked, checkBoxrepeatHands.Checked };
            wmain.setSounds(textBoxSoundStopLoss.Text, textBoxSoundStopHands.Text, textBoxSoundStopTime.Text, textBoxSoundStopWin.Text, repeat);
            wmain.Visible = true;            
        }
    }
}
