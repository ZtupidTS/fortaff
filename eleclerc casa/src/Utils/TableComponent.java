/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.awt.Checkbox;
import java.awt.Color;
import java.awt.Component;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.table.DefaultTableCellRenderer;

/**
 *
 * @author ricardo
 */
public class TableComponent extends DefaultTableCellRenderer {
    
    @Override
    public Component getTableCellRendererComponent(JTable table,
	Object value, boolean isSelected, boolean hasFocus, int row,
	int column) {
                
        //Si la valeur de la cellule est un JButton, on transtype notre valeur
	if (value instanceof JButton)
        {
		return (JButton) value;
	}
        if (value instanceof Boolean)
        {
            JCheckBox cb = new JCheckBox();
            cb.setSelected(((Boolean) value).booleanValue());
            return cb;
        }
	if (value instanceof JCheckBox) {
                return (JCheckBox) value;
        }
        return new JTextField(value.toString());	
    }
    
}
