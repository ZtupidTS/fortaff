/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.util.ArrayList;
import javax.swing.JComponent;
import javax.swing.JTable;
import javax.swing.ListSelectionModel;
import javax.swing.table.TableColumn;

/**
 * Class que permite realizar operações nas jtable
 * @author ricardo
 */
public class UtilsTable {
    
    private JTable table;
    
    /*
     * Permite preencher um jtable com os dados recebidos
     */
    public JTable FillJTable(Object[][] donnees, String[] entetes, int columneditable, int type)
    {
        switch(type)
        {
            case 0://jtable objective
                CreateTableObjective ctoJtable = new CreateTableObjective(donnees, entetes, columneditable);
                table = new JTable(ctoJtable);
                //configurar single selection
                table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
                //configurar a jtable e propriedades da jtable
                //faço esses 3 métodos porque assim dou os diferentes objectos relativos a minha
                //jtable de objetivos
                table.setDefaultRenderer(String.class, new ObjectiveJtable());
                table.setDefaultRenderer(Integer.class, new ObjectiveJtable());
                table.setDefaultRenderer(Double.class, new ObjectiveJtable());
                break;
            case 1://jtable para qualquer coisa
                CreateTable ctJtable = new CreateTable(donnees,entetes,columneditable);
                table = new JTable(ctJtable);
                //configurar single selection
                table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
                //configura a maneira de aparecer dos dados nas colunas
                table.setDefaultRenderer(JComponent.class, new TableComponent());
                //Mete o texto ao centro das colunas
                table.setDefaultRenderer(Object.class, new CenterTableCellRenderer()); 
                break;
            case 2://jtable para mostrar os resultados dos objetivos
                CreateTableObjective ctoViewJtable = new CreateTableObjective(donnees, entetes, columneditable);
                table = new JTable(ctoViewJtable);
                //configurar single selection
                table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
                //configurar a jtable e propriedades da jtable
                table.setDefaultRenderer(Integer.class, new ObjectiveViewJtable());
                table.setDefaultRenderer(String.class, new ObjectiveViewJtable());
                table.setDefaultRenderer(Double.class, new ObjectiveViewJtable());
                break;
            case 3://jtable para mostrar objetivos de quebras
                CreateTableObjective ctoQueJtable = new CreateTableObjective(donnees, entetes, columneditable);
                table = new JTable(ctoQueJtable);
                //configurar single selection
                table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
                //configurar a jtable e propriedades da jtable
                table.setDefaultRenderer(Integer.class, new ObjectiveViewQuebrasJtable());
                table.setDefaultRenderer(String.class, new ObjectiveViewQuebrasJtable());
                table.setDefaultRenderer(Double.class, new ObjectiveViewQuebrasJtable());
                break;
                
                
        }
        return table;
    }
    
    /*
     * Permite preencher um jtable com os dados recebidos
     * E permite dizer quais as colunas editável
     */
    public JTable FillJTable(Object[][] donnees, String[] entetes, int[] columneditable, int type)
    {
        switch(type)
        {
            case 0://objectif jtable
                CreateTableObjective ctoJtable = new CreateTableObjective(donnees, entetes, columneditable);
                table = new JTable(ctoJtable);
                //configurar single selection
                table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
                //configurar a jtable e propriedades da jtable
                //faço esses 3 métodos porque assim dou os diferentes objectos relativos a minha
                //jtable de objetivos
                table.setDefaultRenderer(String.class, new ObjectiveJtable());
                table.setDefaultRenderer(Integer.class, new ObjectiveJtable());
                table.setDefaultRenderer(Double.class, new ObjectiveJtable());
                break;                            
        }                
        return table;
    }
    
    public JTable adjustColumn(JTable jtable, int[] column, int[] width)
    {
        for(int i=0;i<column.length;i++)
        {
            TableColumn col = jtable.getColumnModel().getColumn(column[i]);
            col.setPreferredWidth(width[i]);
        }
        return jtable;
    }
    
    /*
     * columndata = as colunas a não tomar en conta na obtenção dos dados do jtable
     */
    public ArrayList getDataJtable(JTable jtable, int[] columnnodata)
    {
        //meto num array as colunas de dados que não me interessa
        ArrayList columnnointerest = Utils.intArraytoArrayList(columnnodata);
        //crio um array no qual vou guardar os meu dados da tabela
        ArrayList datajtable = new ArrayList();
        //ciclo no qual vou percorrer linhas
        for(int i=0;i<jtable.getRowCount();i++)
        {
            //ciclo no qual vou percorrer as colunas da linhas atual
            for(int j=0;j < jtable.getColumnCount(); j++)
            {
                if(!columnnointerest.contains(j))
                {
                    datajtable.add(jtable.getValueAt(i, j));
                }                
            }            
        }
        return datajtable;
    }
}
