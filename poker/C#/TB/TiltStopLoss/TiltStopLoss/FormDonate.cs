using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace StopLoss
{
    public partial class FormDonate : Form
    {
        public FormDonate()
        {
            InitializeComponent();
            String[] cur = getCurrency();
            foreach (String c in cur)
            {
                comboBoxCurrency.Items.Add(c);
            }
        }

        private String[] getCurrency()
        {
            String[] cur = new String[] {"AUD - Australian Dollar", 
                            "CAD - Canadian Dollar", 
                            "CZK - Czech Koruna",
                            "DKK - Danish Krone",
                            "EUR - Euro",
                            "HKD - Hong Kong Dollar",
                            "HUF - Hungarian Forint",
                            "JPY - Japanese Yen",
                            "NOK - Norwegian Krone",
                            "NZD - New Zealand Dollar",
                            "PLN - Polish Zloty",
                            "GBP - Pound Sterling",
                            "SGD - Singapore Dollar",
                            "SEK - Swedish Krona",
                            "CHF - Swiss Franc",
                            "USD - U.S. Dollar" };

            return cur;            
        }

        private void buttonGoPaypal_Click(object sender, EventArgs e)
        {
            if (comboBoxCurrency.SelectedIndex == -1)
            {
                MessageBox.Show("Select currency please.");
            }
            else
            {
                int ds = comboBoxCurrency.SelectedIndex;
                if (comboBoxCurrency.SelectedItem.ToString().Equals(""))
                {
                    MessageBox.Show("Select currency please.");
                }
                else
                {
                    System.Diagnostics.Process.Start("https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=stoploss59@gmail.com&currency_code=" +
                        comboBoxCurrency.SelectedItem.ToString().Substring(0, 3) +
                        "&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted");
                    this.Close();
                }
            }
        }
    }
}
