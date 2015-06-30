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
public class Quebras {
    
    private int que_id;
    private int que_fam_id;
    private int que_tp_id;
    private double que_quantity;
    private double que_valor;
    private Date que_date;
    
    public Quebras(int que_id, int que_fam_id, int que_tp_id, double que_quantity,
            double que_valor, Date que_date)
    {
        this.que_id = que_id;
        this.que_fam_id = que_fam_id;
        this.que_tp_id = que_tp_id;
        this.que_quantity = que_quantity;
        this.que_valor = que_valor;
        this.que_date = que_date;
    }
    
    public int getId()
    {
        return this.que_id;
    }
    
    public int getFamId()
    {
        return this.que_fam_id;
    }
    
    public int getTypeQuebras()
    {
        return this.que_tp_id;
    }
    
    public double getQuantity()
    {
        return this.que_quantity;
    }
    
    public double getValor()
    {
        return this.que_valor;
    }
    
    public Date getDate()
    {
        return this.que_date;
    }
}
