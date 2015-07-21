using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Xml;
using System.IO;
using System.Xml.Serialization;

namespace MoneyLover
{
    public partial class FormMain : Form
    {
        public FormMain()
        {
            InitializeComponent();
        }

        private void openToolStripMenuItem_Click(object sender, EventArgs e)
        {
            openFileDialogMoneyLoverFile.Filter = "File mlx|*.mlx";
            openFileDialogMoneyLoverFile.FileName = "";
            openFileDialogMoneyLoverFile.ShowDialog();
            if (!openFileDialogMoneyLoverFile.FileName.Equals(""))
            {

                ListBox listBox1 = new ListBox();
                

                //Aqui tenho que criar tudo o preciso para a consulta.
                //XmlReader xReader = XmlReader.Create(new StringReader(openFileDialogMoneyLoverFile.FileName));
                
                //while (xReader.Read())
                //{
                //    if (xReader.IsStartElement())
                //    {
                //        switch (xReader.NodeType)
                //        {
                //            case XmlNodeType.Element:
                //                listBox1.Items.Add("<" + xReader.Name + ">");
                //                break;
                //            case XmlNodeType.Text:
                //                listBox1.Items.Add(xReader.Value);
                //                break;
                //            case XmlNodeType.EndElement:
                //                listBox1.Items.Add("");
                //                break;
                //        }
                //    }
                //}

                //DataSet ds = new DataSet();
                //XmlSerializer xmlSerializer = new XmlSerializer(typeof(DataSet));
                //FileStream readStream = new FileStream(openFileDialogMoneyLoverFile.FileName, FileMode.Open);
                //ds = (DataSet)xmlSerializer.Deserialize(readStream);
                //readStream.Close();
                //dataGridView1.DataSource = ds.Tables[0];

                //XmlDocument xmlDoc = new XmlDocument();
                //xmlDoc.Load(openFileDialogMoneyLoverFile.FileName);

                //DataSet ds = new DataSet();
                //XmlNodeReader xnr = new XmlNodeReader(xmlDoc);
                //ds.ReadXml(xnr);

                //dataGridView1.DataSource = ds;

                //XmlDocument doc = new XmlDocument();
                //doc.Load(openFileDialogMoneyLoverFile.FileName);
                //foreach (XmlNode est in doc.ChildNodes)
                //{
                // Console.WriteLine(est.Name);
                //}
                //foreach (XmlNode est in doc.DocumentElement.ChildNodes)
                //{
                // Console.WriteLine(" " +est.Name +" id= " +est.Attributes["id"].Value +"Nom= " +est.Attributes[1].Value);
                // foreach (XmlNode i in est.ChildNodes)
                // {
                // Console.WriteLine(" " + i.Name +" Valeur : " +
                //i.InnerText);
                // }
                // Console.WriteLine("\n\n");
                //}
                //Console.Read();

                //DataSet ds = new DataSet();
                //ds.ReadXml(openFileDialogMoneyLoverFile.FileName);

                //XmlDocument doc = new XmlDocument();
                //doc.Load(openFileDialogMoneyLoverFile.FileName);

                //for (int i = 0; i <= ds.Tables.Count - 1; i++)
                //{
                //    dataGridView1.DataSource = ds.Tables[i].TableName);
                //}


                //dataGridView1.DataSource = ds.Tables["transactions"];
                //dataGridView1.DataSource = ds.Tables[1].Rows[10];

                //int sd = ds.Tables["transactions"].Rows.Count;

                int f = 0;
                //int a = doc.ChildNodes.Count;
                //int b = doc.DocumentType["transactions"].ChildNodes.Count;
                //Boolean fe = doc.HasChildNodes;

               // dataGridView1.DataSource = ds.Tables["transactions"];

                //foreach (XmlNode est in doc.ChildNodes)
                //{
                //    Console.WriteLine(est.Name);
                //    int i = 0;
                //}

                //DataTable table = new DataTable("XmlData");
                //try
                //{
                //    //open the file using a Stream
                //    using (Stream stream = new FileStream(openFileDialogMoneyLoverFile.FileName, FileMode.Open, FileAccess.Read))
                //    {
                //        //create the table with the appropriate column names
                //        //table.Columns.Add("Name", typeof(string));
                //        //table.Columns.Add("Power", typeof(int));
                //        //table.Columns.Add("Location", typeof(string));

                //        //use ReadXml to read the XML stream
                //        table.ReadXml(stream);

                //        dataGridView1.DataSource = table;
                //        //return the results
                //        ///return table;
                //    }
                //}
                //catch (Exception ex)
                //{
                //   // return table;
                //}

                //DataTable table = new DataTable("XmlDemo");
                ////PrintValues(table, "Original table");

                //string fileName = "C:\\TestData.xml";
                //table.WriteXml(openFileDialogMoneyLoverFile.FileName, XmlWriteMode.WriteSchema);

                //DataTable newTable = new DataTable();
                //newTable.ReadXml(openFileDialogMoneyLoverFile.FileName);

                // Print out values in the table.
                //PrintValues(newTable, "New table");

                //textBoxSoundStopWin.Text = System.IO.Path.GetFileName(openFileDialogSounds.FileName);
                //new Utils().copyFile(openFileDialogSounds.FileName);

                //Server.MapPath - serve para pegar o caminho completo no sistema.
                //Server.MapPath("~/contatos.xml") = c:\inetpub\wwwroot\site\contatos.xml
                //string sCaminhoDoArquivo = Server.MapPath("~/contatos.xml");

                XmlDocument xmlDoc = new XmlDocument();
                xmlDoc.Load(openFileDialogMoneyLoverFile.FileName); //Carregando o arquivo

                //Pegando elemento pelo nome da TAG
                XmlNodeList xnList = xmlDoc.GetElementById("transactions").ChildNodes;
                //xmlDoc.GetElementsByTagName("");

                int de = xnList.Count;

                //Usando for para imprimir na tela
                for (int i = 0; i < xnList.Count; i++)
                {
                    string sNome = xnList[i]["id"].InnerText;
                    string sEmail = xnList[i]["amount"].InnerText;

                    //Response.Write("Nome: " + sNome + " Email: " + sEmail + "<br />");
                }

                //Usando foreach para imprimir na tela
                //foreach (XmlNode xn in xnList)
                //{
                //    string sNome = xn["nome"].InnerText;
                //    string sEmail = xn["email"].InnerText;

                //    Response.Write("Nome: " + sNome + " Email: " + sEmail + "<br />");
                //}


            }
        }
    }


}
