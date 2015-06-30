/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Configuration;

import java.awt.Image;
import java.awt.Toolkit;
import java.sql.ResultSet;
import java.sql.SQLException;
import javax.swing.JFrame;

/**
 *
 * @author ricardo
 */
public class configurationJframe {
    
    private static String pathiconjframe = "";
    
    /*
     * Permite obter o icon dos jframe
     */
    public static Image getIconJframe()
    {
        try{
            return Toolkit.getDefaultToolkit().getImage(pathiconjframe);
        }catch (Exception e)
        {
            return null;
        }
    }
    
    /*
     * Permite alterar o icon dos jframe
     */
    public static void setIconJframe(String path)
    {
        pathiconjframe = path;
    } 
    
    /*
     * Configuração inicial dos jframe
     */
    public static void inicialConfiguration(JFrame frame) throws SQLException
    {
        if(pathiconjframe.equals(""))
        {
            ResultSet rs = (ResultSet)Db.DbData.getDataTable("configuration",
                    "conf_tipo", "JFrame", "", true);
            while (rs.next()) {
                if(rs.getString("conf_description").equals("setIconImage"))
                {
                    pathiconjframe = rs.getString("conf_value");                
                }
            }
        }
        frame.setIconImage(getIconJframe());
        frame.setLocationRelativeTo(null);
    }
    
    public static void fullScreen(JFrame jframe)
    {
        jframe.setSize(Toolkit.getDefaultToolkit().getScreenSize());
        jframe.validate();
    }
}
