using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Profumi.Json
{
    class Sms
    {
        public String Result { get; set; }
        public Int64 LastSMSID { get; set; }
        public Int64 NrOfInsertedMessages { get; set; }
        public List<Smsids> SMSIDs { get; set; }
        public MessageInfo MessageInfo { get; set; }
    }
}
