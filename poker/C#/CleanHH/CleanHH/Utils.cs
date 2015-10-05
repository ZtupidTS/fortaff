using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.IO;

namespace CleanHH
{
    class Utils
    {
        /// <summary>
        /// String to int64
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public Int64 stringtoInt64(String value)
        {
            if (value.Equals(""))
            {
                return 0;
            }
            else
            {
                return Convert.ToInt64(value);
            }
        }

        /// <summary>
        /// String to double
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public Double stringtoDouble(String value)
        {
            int alphaCounter = Regex.Matches(value, @"[a-zA-Z]").Count;
            if (value.Equals("") || alphaCounter > 0)
            {
                //new Debug().LogMessage("Valeur de string to double:" + value);
                return 0.0;
            }
            else
            {
                return Convert.ToDouble(value);
            }
        }

        /// <summary>
        /// String to int32
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public Int32 stringtoInt32(String value)
        {
            if (value.Equals(""))
            {
                return 0;
            }
            else
            {
                return Convert.ToInt32(value);
            }
        }

        /// <summary>
        /// Para eliminar os ficheiro de erros com mais de 3 dias
        /// </summary>
        public void deletefileerrors()
        {
            String pathfinal = Directory.GetCurrentDirectory();
            string[] files = Directory.GetFiles(pathfinal + "\\error");

            foreach (string file in files)
            {
                FileInfo fi = new FileInfo(file);
                if (fi.LastWriteTime < DateTime.Now.AddDays(-3))
                    fi.Delete();
            }
        }

        
    }
}
