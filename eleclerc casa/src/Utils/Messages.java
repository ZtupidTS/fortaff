/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import Db.DbConnect;
import javax.swing.JOptionPane;

/**
 *
 * @author ricardo
 */
public class Messages {
    
    /*
     * Mensagem de erro
     */
    public static void messageError(String context, String namewindow)
    {
        JOptionPane.showMessageDialog(null, context, namewindow, JOptionPane.ERROR_MESSAGE);
    }
    
    /*
     * Mensagem de informação
     */
    public static void messageInformation(String context, String namewindow)
    {
        JOptionPane.showMessageDialog(null, context, namewindow, JOptionPane.INFORMATION_MESSAGE);
    } 
    
    /*
     * Mensagem de erro de ligação a Bd
     */
    public static void messageErrorDb(String nameclass)
    {
        JOptionPane.showMessageDialog(null, "Problema na obtenção de dados ("+nameclass+")",
                "Erro na ligação ", JOptionPane.ERROR_MESSAGE);
        DbConnect.dbDisconnect();
        System.exit(-1);                
    }

    /*
     * Mensagem para avisar que não existe ligação a DB ao abrir a aplicação
     */
    public static void messageClose()
    {
        messageError("Problema ao fechar o programa\n\r Informa o administrador sff",
                "Erro ao fechar");
        //Db.DbConnect.dbDisconnect();
        System.exit(-1);
    }

    /*
     * Devolve 0 se ok
     * Devolve 2 se cancel
     */
    public static int messageQuestion(String context, String namewindow)
    {
        return JOptionPane.showConfirmDialog(null, context, namewindow, JOptionPane.OK_CANCEL_OPTION);
    }
}
