/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package EmailSender;

import Db.DbData;
import Utils.Messages;
import Utils.Utils;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * Permite formatar o conteúdo do mail
 * @author ricardo
 */
public class FormatContentMail {
    
    /*
     * Método para o mail de sugestão
     */
    public static String contentSugest(String section, int user, String content, String image)
    {
        ResultSet rs = (ResultSet) DbData.getDataTable("user_section", "usr_id",
                Utils.convertIntegerToString(user), "", true);
        
        String mailcontent = "<center>";
        mailcontent += "<table><tr><td>";
        mailcontent += "<img src="+image+"></tr></td>";
        
        try 
        {
            while (rs.next())
            {
                mailcontent += "<tr><td><b>Utilizador :</b> "+rs.getString("usr_login")+"</tr></td>";
                break;
            }
        } catch (SQLException ex) {
            //Logger.getLogger(FormatContentMail.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("formatcontentmail : contentsugest");
        }
        
        mailcontent += "<tr><td><b>Secção :</b> "+section+"</tr></td>";
        mailcontent += "<tr><td><b>Sugestão: </b>"+content+"</tr></td></table></center>";

        return mailcontent;
    }
}
