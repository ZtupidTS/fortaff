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
public class ObjectiveViewQuebrasJtable extends DefaultTableCellRenderer{
    
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
        if(column == 2)
        {
           Double i = Utils.convertStringToDouble(value.toString());
           Double j = (Double) table.getValueAt(row, column+1);
           if(i > j)
           {
               component.setBackground(Color.red);
           }else{
               if(i < j)
               {
                   component.setBackground(Color.green);
               }
               if(i == j)
               {
                   component.setBackground(Color.white);
               }               
           }           
        }
        if(column == 3)
        {
            component.setBackground(Color.white);
        }
        
        setHorizontalAlignment(CENTER);
        setHorizontalTextPosition(CENTER);
        return component;
    }
}