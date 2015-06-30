/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package EmailSender;

import Utils.Messages;
import Db.DbData;
import Utils.Utils;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

/**
 * Class de envio de mail
 * @author ricardo
 */
public class EmailSender {

    private String smtpServer;
    private String port;
    private String user;
    private String password;
    private String auth;
    private String from;
    private String[] to;
    private String charset;
    private String imagesug;

    public EmailSender()
    {
        ResultSet rs = (ResultSet) DbData.getDataTable("configuration", "conf_tipo", "Email", "", true);
        ArrayList stringto = new ArrayList();
        try {
            while(rs.next())
            {
                if(rs.getString("conf_description").equals("port"))
                {
                    this.port = rs.getString("conf_value");
                }
                if(rs.getString("conf_description").equals("smtpserver"))
                {
                    this.smtpServer = rs.getString("conf_value");
                }
                if(rs.getString("conf_description").equals("user"))
                {
                    this.user = rs.getString("conf_value");
                }
                if(rs.getString("conf_description").equals("password"))
                {
                    this.password = rs.getString("conf_value");
                }
                if(rs.getString("conf_description").equals("auth"))
                {
                    this.auth = rs.getString("conf_value");
                }
                if(rs.getString("conf_description").equals("from"))
                {
                    this.from = rs.getString("conf_value");
                }
                if(rs.getString("conf_description").equals("to"))
                {
                    stringto.add(rs.getString("conf_value"));
                }
                if(rs.getString("conf_description").equals("charset"))
                {
                    this.charset = rs.getString("conf_value");
                }
                if(rs.getString("conf_description").equals("imagesug"))
                {
                    this.imagesug = rs.getString("conf_value");
                }
            }
            to = Utils.arraylistToString(stringto);
            
        } catch (SQLException ex) {
            //Logger.getLogger(EmailSender.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("Emailsender : emailsender");
        }        
    }

    /*
     * Prepara as propriedades
     */
    private Properties prepareProperties()
    {
        Properties props = new Properties();
        props.setProperty("mail.smtp.host", smtpServer);
        props.setProperty("mail.smtp.port", port);
        props.setProperty("mail.smtp.user", user);
        props.setProperty("mail.smtp.password", password);
        props.setProperty("mail.smtp.auth", auth);

        return props;
     }

    /*
     * Prepare o mail
     */
    private MimeMessage prepareMessage(Session mailSession,
             String from, String subject,String HtmlMessage,String[] recipient) 
    {
        //Multipurpose Internet Mail Extensions
        MimeMessage message = null;
        try {
            message = new MimeMessage(mailSession);
            message.setFrom(new InternetAddress(from));
            message.setSubject(subject);
            for (int i=0;i<recipient.length;i++)
                message.addRecipient(Message.RecipientType.TO, new InternetAddress(recipient[i]));
            message.setContent(HtmlMessage, "text/html; charset=\""+this.charset+"\"");
            
        } catch (Exception ex) {
            Logger.getLogger(EmailSender.class.getName()).log(Level.SEVERE, null, ex);
        }
        return message;
    }

    /*
     * método genérico de envio de email
     */
    public void sendEmail(String subject,String HtmlMessage,String[] to)
    {
        Transport transport = null;
        try {
            Properties props = prepareProperties();
            Session mailSession = Session.getDefaultInstance(
                            props, new SMTPAuthenticator(from, password, true));
            transport =  mailSession.getTransport("smtp");
            MimeMessage message = prepareMessage(mailSession, from, subject,
                                        HtmlMessage, to);
            transport.connect();
            Transport.send(message);
        } catch (Exception ex) {    
        }
        finally{
            try {
                transport.close();
            } catch (MessagingException ex) {
                Logger.getLogger(EmailSender.class.getName()).
                                                    log(Level.SEVERE, null, ex);
            }
        }
    }

    /*
     * método para enviar o mail da sugestão, porque o "to" vou recuperar o mesmo a BD
     */
    public void sendEmail(String subject, int user, String title, String content)
    {
        Transport transport = null;
        try {
            Properties props = prepareProperties();
            Session mailSession = Session.getDefaultInstance(
                            props, new SMTPAuthenticator(from, password, true));
            transport =  mailSession.getTransport("smtp");
            String htmlmessage = FormatContentMail.contentSugest(title, user, content, this.imagesug);
            MimeMessage message = prepareMessage(mailSession,from, subject,
                                        htmlmessage, this.to);
            transport.connect();
            Transport.send(message);
        } catch (Exception ex) {
            Messages.messageError("Erro ao enviar o mail (emailsender: sendemail sugestão)", "Erro de Envio");
        }
        finally{
            try {
                transport.close();
            } catch (MessagingException ex) {
                Logger.getLogger(EmailSender.class.getName()).
                                                    log(Level.SEVERE, null, ex);
            }
        }
    }
}
