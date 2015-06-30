/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Type;

import Db.DbData;
import Utils.Messages;
import Utils.Utils;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import sun.font.TrueTypeGlyphMapper;

/**
 *
 * @author ricardo
 */
public class Users {
    
    private static int intuser;
    private static String loginuser;
    private static String section;
    private static ArrayList<String> authorization;
    private static int numberUserConfNow;
    
    public static void Users(int numuser, String nameuser, int sec)
    {
        intuser = numuser;
        loginuser = nameuser;
        
        ResultSet rs = (ResultSet) DbData.getDataTable("section", "sec_id",
                Utils.convertIntegerToString(sec), "", true);
        try 
        {
            if(rs.next())
            {
                section = rs.getString("sec_description");
            }
            ResultSet rsAuth = (ResultSet) DbData.getDataTable("user_authorization_menu", "usa_usr_id",
                Utils.convertIntegerToString(intuser), "", true);
            authorization = new ArrayList<>();
            while(rsAuth.next())
            {
                authorization.add(rsAuth.getString("menu_description"));
            }
        } catch (SQLException ex) {
            //Logger.getLogger(Utils.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("users : get section");            
        }
    }
    
    public Users(int numuser, String nameuser)
    {
        intuser = numuser;
        loginuser = nameuser;
    }
    
    public static String getLogin()
    {
        return loginuser;
    }
    
    public static int getNumber()
    {
        return intuser;
    }
    
    public static String getSection()
    {
        return section;
    }
    
    public static int getUserConfNow()
    {
        return numberUserConfNow;
    }
    
    /*
     * Devolve true ou false se o user tem autorização ao menu
     */
    public static boolean getAuthorization(String nameMenu)
    {
        if(authorization.contains(nameMenu))
        {
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * Devolve a lista de todos os users criados no sistema num arraylist
     */
    public static ArrayList<String> allUsers()
    {
        ResultSet rs = (ResultSet) DbData.getDataTable("users", "", "", "usr_login", true);
        try {
            ArrayList<String> tempuser = new ArrayList();
            while (rs.next())
            {
                tempuser.add(rs.getString("usr_login"));
            }
            return tempuser;
        } catch (SQLException e) {
            Messages.messageErrorDb("Users: allUsers");
            return null;
        }
    }
    
    /*
     * Método que me devolve true ou false se o user tem autorização
     * Esse método é só para a configuração dos acessos na configuração do user
     */
    public static boolean containMenuAuth(String nameMenu, String user)
    {
        ResultSet rsAuthTemp = (ResultSet) DbData.getDataTable("user_authorization_menu", "usr_login",
                user, "", true);
        ArrayList<String> authtemp = new ArrayList<>();
        try {
            while(rsAuthTemp.next())
            {
                authtemp.add(rsAuthTemp.getString("menu_description"));                
            }
            ResultSet rsNumUser = (ResultSet) DbData.getDataTable("users", "usr_login",
                user, "", true);
            
            while(rsNumUser.next())
            {
                numberUserConfNow = rsNumUser.getInt("usr_id");
            }
        } catch (SQLException ex) {
            //Logger.getLogger(Users.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("users : containMenuAuth");
        }
        
        if(authtemp.contains(nameMenu))
        {
            return true;
        }else{
            return false;
        }
    }
}
