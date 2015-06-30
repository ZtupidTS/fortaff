/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import javax.swing.table.DefaultTableCellRenderer;

/**
 *
 * @author ricardo
 */
public class CenterTableCellRenderer extends DefaultTableCellRenderer {
    public CenterTableCellRenderer() {
        setHorizontalAlignment(CENTER);
        setVerticalAlignment(CENTER);
        setHorizontalTextPosition(CENTER);        
    }
}
