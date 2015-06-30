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
public class Vendas {
    
    private int ve_id;
    private int ve_fam_id;
    private double ve_valor;
    private Date ve_date;
    
    public Vendas(int ve_id, int ve_fam_id, double ve_valor, Date ve_date)
    {
        this.ve_id = ve_id;
        this.ve_fam_id = ve_fam_id;
        this.ve_valor = ve_valor;
        this.ve_date = ve_date;
    }
    
    public int getId()
    {
        return this.ve_id;
    }
    
    public int getFamId()
    {
        return this.ve_fam_id;
    }
    
    public double getValor()
    {
        return this.ve_valor;
    }
    
    public Date getDate()
    {
        return this.ve_date;
    }
}
