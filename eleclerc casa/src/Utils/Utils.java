/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import Type.Users;
import Db.DbData;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * Permite várias funções
 * @author ricardo
 */
public class Utils {

    /*
     * Transforme um arraylist num string[]
     */
    public static String[] arraylistToString(ArrayList ar)
    {
        String[] sa = new String[ar.size()];
        for(int i=0;i<ar.size();i++)
        {
            sa[i] = (String)ar.get(i);
        }

        return sa;
    }
    
    /*
     * Converte de inteiro para string
     */
    public static String convertIntegerToString(int i)
    {
        return Integer.toString(i);
    }
    
    /*
     * Converte de double para string
     */
    public static String convertDoubleToString(Double i)
    {
        return Double.toString(i);
    }
    
    /*
     * Verifica se o login existe e se o user esta ativo
     */
    public static boolean checkLogin(String login, char[] password)
    {
        if(login.equals("") || password.length <= 0)
        {
            return false;
        }
        
        String escapelogin = "";
        
        try {
            escapelogin = EscapeString.stringEscape(login);
        } catch (Exception ex) {
            //Logger.getLogger(Utils.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageError("Problema no escape login", "Alerta");
        }
        
        ResultSet rs = (ResultSet) DbData.getDataTable("users", "usr_login", escapelogin, "", true);
        
        try {
            if(rs.next())
            {
                if(rs.getBoolean("usr_enable"))
                {
                   if(rs.getString("usr_password").equals(convertCharToString(password)))
                    {
                        Users.Users(rs.getInt("usr_id"), rs.getString("usr_login"), rs.getInt("usr_section"));
                        return true;
                    } 
                }
            }
            return false;
        } catch (SQLException ex) {
            //Logger.getLogger(Utils.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("utils : checklogin");
            return false;
        }        
    }
    
    /*
     * Char[] to string
     */
    public static String convertCharToString(char[] c)
    {
        String newString = "";
        for(int i = 0; i<c.length;i++)
        {
            newString += c[i];
        }
        return newString;
    }
    
    /*
     * String to char[]
     */
    public static char[] convertStringtoChar(String st)
    {
        char[] c = st.toCharArray();
        return c;
    }
    
    /*
     * Permite verificar se o ficheiro escolhido é da mesma extensão que queremos.
     */
    public static boolean equalExtension(String find, String choose)
    {
        int i = find.lastIndexOf('.');

        if(i > 0 &&  i < find.length() - 1) 
        {
            String res = find.substring(i+1).toLowerCase();
            if(res.equals(choose))
            {
                return true;
            }            
        }else{
            return false;
        }
        return false;
    }
    
    /*
     * convert string to int
     */
    public static int convertStringToInt(String st)
    {
         return Integer.parseInt(st);
    }
    
    /*
     * convert string to decimal
     */
    public static double convertStringToDouble(String st)
    {
        return Double.parseDouble(st);
    }
    
    /*
     * Permite criar um string[] a partir de um caractetre definido
     */
    public static String[] stringSplit(String st, String delimiter)
    {
        return st.split(delimiter);
    }
    
    /*
     * Permite mudar um caractere de um string
     */
    public static String replaceString(String original, char old, char newstring)
    {
        return original.replace(old, newstring);
    }
    
    /* 
     * Ver se um numero é par ou impar
     * par devolve true
     * impar devolve false
     */
    public static boolean isPar(int i)
    {
        if(i % 2 == 0) 
        {
            return true;
        }else{
            return false;
        }
    }
    
    public static ArrayList intArraytoArrayList(int[] number)
    {
        ArrayList numberarray = new ArrayList();
        for(int i=0;i<number.length;i++)
        {
            numberarray.add(number[i]);
        }
        return numberarray;
    }
    
    /*
     * pega num double e limita ao numero de decimal
     */
    public static Double nummberDecimalDouble(Double dou, int decimal)
    {
        Double augmentation = Math.pow(10, decimal);
        return Math.round(dou * augmentation) / augmentation;
    }
}
