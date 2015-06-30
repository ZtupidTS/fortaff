/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package EmailSender;

import javax.mail.Authenticator;
import javax.mail.PasswordAuthentication;

/*
 * Class usada pela class emailsender
 */
public class SMTPAuthenticator extends Authenticator{
    private String username;
    private String password;
    private boolean needAuth;

    public SMTPAuthenticator(String username, String password,boolean needAuth)
    {
        this.username = username;
        this.password = password;
        this.needAuth = needAuth;
    }

    @Override
    protected PasswordAuthentication getPasswordAuthentication() {
        if (needAuth)
            return new PasswordAuthentication(username, password);
                else return null;
    }
}
