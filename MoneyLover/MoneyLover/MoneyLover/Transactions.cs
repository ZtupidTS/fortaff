using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace MoneyLover
{
    class Transactions
    {
        public int id { get; set; }
        public Double amount { get; set; }
        public DateTime created_date { get; set; }
        public DateTime display_date { get; set; }
        public int cat_id { get; set; }
        public string note { get; set; }
        public string longtitude { get; set; }
        public string latitude { get; set; }
        public string address { get; set; }
        public int account_id { get; set; }
        public string uuid { get; set; }
        public Boolean flag { get; set; }
        public Boolean remind_date { get; set; }
        public string parent_id { get; set; }
        public string search_note { get; set; }
        public int bill_id { get; set; }
        public Boolean exclude_report { get; set; }
        public string permalink { get; set; }

    }
}
