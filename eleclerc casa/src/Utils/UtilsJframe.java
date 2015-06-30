/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import Db.DbData;
import Type.Family;
import Type.TypeQuebras;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JComboBox;

/**
 *
 * @author ricardo
 */
public class UtilsJframe {
    
    /*
     * Permite preencher os combobx da jframe
     * jcb = jcombobox
     * selectable = se a combo esta bloqueada ou não
     * comboselect = se esta selecionado logo naquele posição
     * table = tabela da DB
     * column = coluna da Db que queres os dados.
     */
    public void fillCombo(JComboBox jcb, boolean selectable, String comboselect, String table,
            String column)
    {
        try {
            ResultSet rs = (ResultSet) Db.DbData.getDataTable(table, "", "", "", true);
            while (rs.next()) 
            {
                jcb.addItem(rs.getString(column));
            }   
            if(comboselect != "")
            {
                jcb.setSelectedItem(comboselect);
            }            
            if(selectable)
            {
                jcb.setEnabled(true);
            }            
        } catch (SQLException ex) {
            //Logger.getLogger(AnonymousJFrame.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("AnonymousJFrame : fillcombo");
        }
    }
    
    /*
     * Preenche mas com objeto
     */
    public void fillComboObject(JComboBox jcb, boolean selectable, String table, String column, String column2)
    {
        try {
            ResultSet rs = (ResultSet) Db.DbData.getDataTable(table, "", "", "", true);
            while (rs.next()) 
            {
                //aqui é que ponho o meu objecto
                //jcb.addItem(rs.getString(column));
                if(table == "family")
                {
                    jcb.addItem(new Family(rs.getInt(column), rs.getString(column2)));
                }
                if(table == "tipo_quebras")
                {
                    jcb.addItem(new TypeQuebras(rs.getInt(column), rs.getString(column2)));
                }
            }   
            if(selectable)
            {
                jcb.setEnabled(true);
            }            
        } catch (SQLException ex) {
            //Logger.getLogger(AnonymousJFrame.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("AnonymousJFrame : fillComboObject");
        }
    }
    
    //devolve me um array de objecto familia para as jtable
    public ArrayList arFamily()
    {
        try {
            ResultSet rsFam = (ResultSet) DbData.getDataTable("family", new UtilsDb().getWhere("fam_id", 11),
                        "", "fam_id", true);
            ArrayList arFam = new ArrayList();
            while(rsFam.next())
            {
                arFam.add(new Family(rsFam.getInt("fam_id"), rsFam.getString("fam_description")));
            }
            return arFam;
        } catch (SQLException ex) {
            //Logger.getLogger(UtilsJframe.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("UtilsJframe : arFamily");
            return null;
        }
    }
    
    //devolve me um array de objecto familia para as jtable
    public ArrayList arSubSection()
    {
        try {
            ResultSet rsFam = (ResultSet) DbData.getDataTable("family", new UtilsDb().getWhereSubsection("fam_id"),
                        "", "fam_id", true);
            ArrayList arSubSection = new ArrayList();
            while(rsFam.next())
            {
                arSubSection.add(new Family(rsFam.getInt("fam_id"), rsFam.getString("fam_description")));
            }
            return arSubSection;
        } catch (SQLException ex) {
            //Logger.getLogger(UtilsJframe.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("UtilsJframe : arFamily");
            return null;
        }
    }
    
}
