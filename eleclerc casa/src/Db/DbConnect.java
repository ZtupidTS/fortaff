/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Db;

import Utils.Messages;
import com.mysql.jdbc.Statement;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JFrame;

/**
 *
 * @author ricardo
 */
public class DbConnect {
    
    private static Connection con;
    public static Statement stmt;
    private static boolean connect = false;
    private static boolean trabalho = true;

    /*
     * Método que permite se ligar a DB
     */
    public static boolean dbConnect()
    {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            if(trabalho)
            {
                con = DriverManager.getConnection("jdbc:mysql://219.21.221.211:3306/eleclerc",
                                   "root",
                                   "ame59100");
            }else{
                con = DriverManager.getConnection("jdbc:mysql://localhost:3306/eleclerc",
                                   "root",
                                   "");
            }            
            stmt = (Statement) con.createStatement();
            connect = true;
            return true;
        } catch (SQLException | ClassNotFoundException e) 
        {
            //return "SQL Exception: "+ e.toString();
            return false;
        }
    }

    /*
     * O botão fechar dos jframe
     */
    public static void dbDisconnect(JFrame jframe)
    {
        try {
            if(connect)
            {
                //stmt.close();
                con.close();
            }           
            jframe.dispose();
        } catch (SQLException ex) {
            Messages.messageClose();
        }        
    }

    /*
     * Método que permite se desligar da DB caso houve ligação anterior.
     */
    public static void dbDisconnect()
    {
        try {
            if(connect)
            {
                //stmt.close();
                con.close();
            }
        } catch (SQLException ex) {
            Messages.messageClose();
        }
    }
    
    /*
     * Vai me permitir realizar o roolback
     */
    public static void setAutocommit(boolean bool)
    {
        try {
            con.setAutoCommit(bool);
        } catch (SQLException ex) {
            //Logger.getLogger(DbConnect.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("SetAutoCommit");
        }
    }
    
    /*
     * Devolve a connection a BD
     */
    public static Connection getConnection()
    {
        return con;
    }
}
