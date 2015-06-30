/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Type;

/**
 *
 * @author ricardo
 */
public class Family {
    
    private int fam_id;
    private String fam_description;
    
    public Family(int fam_id, String fam_description)
    {
        this.fam_id = fam_id;
        this.fam_description = fam_description;
    }
    
    public int getFamId()
    {
        return this.fam_id;
    }
    
    public String getFamDescription()
    {
        return this.fam_description;
    }
    
    public String toString()
    {
        return fam_id+" - "+fam_description;
    }
    
}
