/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.util.ArrayList;
import javax.swing.table.AbstractTableModel;

/**
 *
 * @author ricardo
 */
public class CreateTable extends AbstractTableModel{
    
    private final Object[][] data;
    private final String[] header;
    private final int columnEditable;
    private final ArrayList<Integer> colEdit = new ArrayList<>();

    /*
     * Constructor
     */
    public CreateTable(Object[][] data, String[] header, int numColumnEditable) {
        super();
        this.data = data;
        this.header = header;
        this.columnEditable = numColumnEditable;
    }
    
    /*
     * Constructor
     */
    public CreateTable(Object[][] data, String[] header, int[] numColumnEditable) {
        super();
        this.data = data;
        this.header = header;
        columnEditable = 1000;
        for(int i = 0;i<numColumnEditable.length;i++)
        {
            colEdit.add(numColumnEditable[i]);
        }
    }
    
    /*
     * Dá o numero de linha da tabela
     */
    @Override
    public int getRowCount() {
        return data.length;
    }

    /*
     * Numero de coluna da tabela
     */
    @Override
    public int getColumnCount() {
        return header.length;
    }

    /*
     * Nome das colunas
     */
    @Override
    public String getColumnName(int columnIndex) {
        return header[columnIndex];
    }

    /*
     * Devolve o valor da celula
     */
    @Override
    public Object getValueAt(int rowIndex, int columnIndex) {
        return data[rowIndex][columnIndex];
    }
    
    /**
    * Retourne la classe de la donnée de la colonne
    * @param col
    */
    @Override
    public Class getColumnClass(int col){
            //On retourne le type de la cellule à la colonne demandée
            //On se moque de la ligne puisque les données sur chaque ligne sont les mêmes
            //On choisit donc la première ligne
            return this.data[0][col].getClass();
    }
    
    /**
    * Retourne vrai si la cellule est éditable : celle-ci sera donc éditable
    * @return boolean
    * columnEditable = 1000 isso quer dizer que construi com um array de coluna editável
    */
    @Override
    public boolean isCellEditable(int row, int col){
        if(this.columnEditable == 1000)
        {
            if(colEdit.contains(col))
            {
                return true;
            }else{
                return false;
            }
        }else{
            if(col == this.columnEditable)
            {
                return true;
            }else{
                return false; 
            }
        }                
    }
    
    /*
     * Permite alterar o valor de uma celula
     */
    @Override
    public void setValueAt(Object value, int row, int col) {
        data[row][col] = value;
        fireTableCellUpdated(row, col);
    }
}