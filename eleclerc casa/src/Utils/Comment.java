/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

/**
 *
 * @author ricardo
 */
public class Comment {
    
    private String login;
    private String section;
    private String comment;
    private int id;
    
    public Comment(int id, String login, String section, String comment)
    {
        this.login = login;
        this.section = section;
        this.comment = comment;
        this.id = id;
    }
    
    public String getLogin()
    {
        return this.login;
    }
    
    public String getSection()
    {
        return this.section;
    }
    
    public String getComment()
    {
        return this.comment;
    }
    
    public int getId()
    {
        return this.id;
    }
}
