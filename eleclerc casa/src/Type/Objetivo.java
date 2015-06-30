/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Type;

import java.util.Date;

/**
 *
 * @author ricardo
 */
public class Objetivo {
 
    private int obj_id;
    private int obj_fam_id;
    private Date obj_date;
    private String obj_type;
    
    public Objetivo(int obj_id, int obj_fam_id, Date obj_date, String obj_type)
    {
        this.obj_id = obj_id;
        this.obj_fam_id = obj_fam_id;
        this.obj_date = obj_date;
        this.obj_type = obj_type;
    }
    
    public int getObjId()
    {
        return this.obj_id;
    }
    
    public int getObjFamId()
    {
        return this.obj_fam_id;
    }
    
    public Date getObjDate()
    {
        return this.obj_date;
    }
    
    public String getObjType()
    {
        return this.obj_type;
    }
}
