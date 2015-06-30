/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import Db.DbConnect;
import Db.DbData;
import com.mysql.jdbc.Connection;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.sql.SQLException;
import java.util.ArrayList;

/**
 *
 * @author ricardo
 */
public class ImportResults {
    
    private ArrayList<String> resultsfile;
    private ArrayList resultfinal;
    private String dateimport;
    
    public boolean ImportResults(String pathfile, String date)
    {
        File fileexist = new File(pathfile);
        dateimport = date;
        
        if(!fileexist.exists()) 
        {
            return false;
        }
        //arraylist que vai conter as linhas do ficheiro
        resultsfile = new ArrayList<>();
        
        try
        {
            BufferedReader originfile = new BufferedReader(new FileReader(pathfile));
            String linefile;
            
            while((linefile = originfile.readLine())!= null)
            {
                resultsfile.add(linefile);
            }
            originfile.close();
            
            ArrayList ignorearraylist = getAlfabeto();
            String query = "";
            resultfinal = new ArrayList();
            int section = 0;
            int pontovirgula = 0;
            
            //aqui vou percorrer as linhas todas do ficheiro
            for(int i = 0; i<resultsfile.size();i++)
            {
                boolean fim = false;                
                char[] c = null;
                //c = a minha linha em char
                c = Utils.convertStringtoChar(resultsfile.get(i));
                //vou tratar da linha atual
                for(int ic = 0;ic<c.length;ic++)
                {
                    boolean cok = true;
                    if(!ignorearraylist.contains(c[ic]))
                    {    
                        if(c[ic] == ';')
                        {
                            if(pontovirgula == 0)
                            {
                                section = Utils.convertStringToInt(query);
                            }
                            if(pontovirgula == 2)
                            {
                                if(query == "")
                                {
                                    fim = true;
                                }else{
                                    resultfinal.add(section);
                                    resultfinal.add(Utils.convertStringToDouble(Utils.replaceString(query, ',', '.')));
                                    resultfinal.add(dateimport);
                                    fim = true;
                                }
                            }
                            query = "";
                            cok = false;
                            pontovirgula++;
                        }
                        if(cok)
                        {
                            query += c[ic];
                        }
                    }
                    if(fim)
                        break;                    
                }
                pontovirgula = 0;
                int lastsection = section;
                section = 0;
                query = "";
                //se chego a linha 308 paro porque cheguei ao fim do ficheiro e não
                // quero repetir o numero pgc = loja
                if(lastsection == 6)
                    break;                                  
            }
            
            //aqui meter o método ou chamar para meter na DB.
            ArrayList tempdata = new ArrayList();
            ArrayList tempcolumn = new ArrayList();
            //preparo para o roolback
            DbConnect.setAutocommit(false);
            
            for (int ar = 0;ar<resultfinal.size();ar++)
            {
                tempdata.add(resultfinal.get(ar));
                tempdata.add(resultfinal.get(++ar));
                tempdata.add(resultfinal.get(++ar));
                tempcolumn.add("ve_fam_id");
                tempcolumn.add("ve_valor");
                tempcolumn.add("ve_date");
                
                if(!DbData.insertDatas("vendas", tempdata, tempcolumn))
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
                    //Logger.getLogger(Importresultsfile.class.getName()).log(Level.SEVERE, null, ex);
                    con.rollback();
                    DbConnect.setAutocommit(true);
                    return false;
                } catch (SQLException ex1) {
                    //Logger.getLogger(Importresultsfile.class.getName()).log(Level.SEVERE, null, ex1);
                    DbConnect.setAutocommit(true);
                    return false;
                }
            }
        } catch (IOException ex) {
            //Logger.getLogger(Importresultsfile.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageError("Não foi possível carregar o ficheiro", "Erro");
            return false;
        }
    }
    
    /*
     * Método para criar o meu arraylist do alfabeto mais o '-' e ou ' '
     */
    private ArrayList getAlfabeto()
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
}
