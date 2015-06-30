/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Type;

/**
 *
 * @author ricardo
 */
public class TypeQuebras {
    
    private int tq_id;
    private String tq_description;
    
    public TypeQuebras(int tq_id, String tq_description)
    {
        this.tq_id = tq_id;
        this.tq_description = tq_description;
    }
    
    public int getTypeQuebrasId()
    {
        return this.tq_id;
    }
    
    public String getTypeQuebrasDescription()
    {
        return this.tq_description;
    }
    
    public String toString()
    {
        return tq_id+" - "+tq_description;
    }
}
