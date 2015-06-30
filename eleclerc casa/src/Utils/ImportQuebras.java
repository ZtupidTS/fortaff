/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import Db.DbConnect;
import Db.DbData;
import com.mysql.jdbc.Connection;
import java.io.*;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * Class que me vai permitir importar o ficheiro das quebras
 * @author ricardo
 */
public class ImportQuebras {
    
    private static ArrayList<String> quebras;
    private static ArrayList dbquebra;
    private static String dateimport;
    
    public static boolean ImportQuebras(String pathfile, String date)
    {
        File fileexist = new File(pathfile);
        dateimport = date;
        
        if(!fileexist.exists()) 
        {
            return false;
        }
        //arraylist que vai conter as linhas do ficheiro
        quebras = new ArrayList<>();
        
        try
        {
            BufferedReader originfile = new BufferedReader(new FileReader(pathfile));
            String linefile;
            
            while((linefile = originfile.readLine())!= null)
            {
                quebras.add(linefile);
            }
            originfile.close();
            
            ArrayList ignorearraylist = getAlfabeto();
            String query = "";
            dbquebra = new ArrayList();
            int section = 0;
            int pontovirgula = 0;
            int line = 0;
            
            //aqui vou percorrer as linhas todas do ficheiro
            for(int i = 0; i<quebras.size();i++)
            {
                line++;                
                boolean fim = false;                
                char[] c = null;
                //c = a minha linha em char
                c = Utils.convertStringtoChar(quebras.get(i));
                //vou tratar da linha atual
                for(int ic = 0;ic<c.length;ic++)
                {
                    if(!ignorearraylist.contains(c[ic]))
                    {
                        boolean cok = true;
                        if(c[ic] == ';')
                        {
                            if(query != "")
                            {
                                if(pontovirgula == 0)
                                {
                                    section = Utils.convertStringToInt(query);
                                    query = "";
                                    cok = false;
                                    pontovirgula++;
                                }else{
                                    String[] qtdval = Utils.stringSplit(query, "-");
                                    if(pontovirgula > 1)
                                    {
                                        if(qtdval.length > 1)
                                        {
                                            int tq = typeQuebras(pontovirgula);
                                            dbquebra.add(section);                                            
                                            dbquebra.add(tq);
                                            dbquebra.add(Utils.convertStringToDouble(Utils.replaceString(qtdval[1], ',', '.')));
                                            dbquebra.add(Utils.convertStringToDouble(Utils.replaceString(qtdval[2], ',', '.')));
                                            dbquebra.add(dateimport);
                                            query = "";
                                            cok = false;  
                                        }else{
                                            query = "";
                                            cok = false;
                                        }
                                        pontovirgula++;
                                    }
                                }
                            }else{
                                pontovirgula++;
                                cok = false;
                            }
                        }
                        if(query.equals("00"))
                        {
                            if(c[ic] == '1' && pontovirgula == 0)
                            {
                                fim = true;
                                cok = false;
                            }
                        }
                        if(cok)
                        {
                            query += c[ic];
                        }
                    }
                    if(fim)
                        break;
                }
                
                if(line == 3 || query != "")
                {
                    pontovirgula = 0;
                    section = 0;
                    line = 0;
                    query = "";
                }
                //quando chego ao 001 paro a leitura porque não me interessa
                if(fim)
                    break;                                  
            }
            
            //aqui meter o método ou chamar para meter na DB.
            ArrayList tempdata = new ArrayList();
            ArrayList tempcolumn = new ArrayList();
            //preparo para o roolback
            DbConnect.setAutocommit(false);
            
            for (int ar = 0;ar<dbquebra.size();ar++)
            {
                tempdata.add(dbquebra.get(ar));
                tempdata.add(dbquebra.get(++ar));
                tempdata.add(dbquebra.get(++ar));
                tempdata.add(dbquebra.get(++ar));
                tempdata.add(dbquebra.get(++ar));
                tempcolumn.add("que_fam_id");
                tempcolumn.add("que_tq_id");
                tempcolumn.add("que_quantity");
                tempcolumn.add("que_valor");
                tempcolumn.add("que_date");
                
                if(!DbData.insertDatas("quebras", tempdata, tempcolumn))
                {
                    return false;
                }
                tempdata.clear();
                tempcolumn.clear();
            }
            Connection con = (Connection) DbConnect.getConnection();
            try {
                con.commit();
                DbConnect.setAutocommit(true);
                return true;
            } catch (SQLException ex) {
                try {
                    //Logger.getLogger(ImportQuebras.class.getName()).log(Level.SEVERE, null, ex);
                    con.rollback();
                    DbConnect.setAutocommit(true);
                    return false;
                } catch (SQLException ex1) {
                    //Logger.getLogger(ImportQuebras.class.getName()).log(Level.SEVERE, null, ex1);
                    DbConnect.setAutocommit(true);
                    return false;
                }
            }
        } catch (IOException ex) {
            //Logger.getLogger(ImportQuebras.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageError("Não foi possível carregar o ficheiro", "Erro");
            return false;
        }
    }
    
    /*
     * Método para criar o meu arraylist do alfabeto mais o '-' e ou ' '
     */
    private static ArrayList getAlfabeto()
    {
        ArrayList alf = new ArrayList();
        
        for (int i = 65; i < 91; i++)
        {  
            char a = (char) i;
            alf.add(a);            
        }
        for (int i = 97; i < 123; i++) {  
            char a = (char) i;
            alf.add(a);
        }
        alf.add(' ');        
        alf.add('/');
        alf.add('.');
        return alf;
    }
    
    /*
     * Switch para devolver o tipo de quebras
     */
    private static Integer typeQuebras(int pontvirgula)
    {
        switch(pontvirgula)
        {
            case 2:
                return 1;
            case 3:
                return 2;
            case 4:
                return 3;
            case 5:
                return 4;
            case 6:
                return 5;
            case 9:
                return 6;
            case 10:
                return 7;
            case 11:
                return 8;
            case 12:
                return 9;
            case 13:
                return 10;
            case 16:
                return 11;
            case 17:
                return 12;
            case 18:
                return 13;
            case 19:
                return 14;
            default:
                return null;
        }
    }
}
