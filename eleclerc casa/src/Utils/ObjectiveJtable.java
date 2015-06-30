/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.awt.Color;
import java.awt.Component;
import javax.swing.JLabel;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.table.DefaultTableCellRenderer;

/**
 *
 * @author ricardo
 */
public class ObjectiveJtable extends DefaultTableCellRenderer{
    
    public Component getTableCellRendererComponent
                     (JTable table,Object value,boolean isSelected,boolean hasFocus,int row,int column){
                
        Component component = super.getTableCellRendererComponent(table, value, isSelected, hasFocus, row, column);
        
        //Dependente da coluna altero a cor
        if (column == 0) {
            component.setBackground(Color.orange);            
        }
        if (column == 1)
        {
            component.setBackground(Color.white);             
        }
        if(column > 1 && value instanceof Double)
        {
           Double i = Utils.convertStringToDouble(value.toString());
           if(i == 0.0)
           {
               component.setBackground(Color.white);
           }else{
                if(i > 0 && i <= 2)
                {
                    component.setBackground(new Color(217,236,214));
                }
                if(i > 2)
                {
                    component.setBackground(new Color(64,200,79)); 
                }
                if(i < 0)
                {
                    component.setBackground(Color.red);
                }
           }           
        }
        
        setHorizontalAlignment(CENTER);
        setHorizontalTextPosition(CENTER);
        return component;
    }
}