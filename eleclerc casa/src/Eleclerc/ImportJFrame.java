/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Eleclerc;

import Type.Quebras;
import Configuration.configurationJframe;
import Db.DbConnect;
import Db.DbData;
import Type.Vendas;
import Utils.*;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JTable;

/**
 *
 * @author ricardo
 */
public class ImportJFrame extends javax.swing.JFrame {

    private String origin;
    
    /**
     * Creates new form ImportJFrame
     */
    public ImportJFrame(String path, String origin) {
        initComponents();
        this.origin = origin;
        settextFieldPath(path);
        try {
            configurationJframe.inicialConfiguration(this);
        } catch (SQLException ex) {
            //Logger.getLogger(ImportJFrame.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("importquebrasjframe : inicialização");
        }
    }
    
    /*
     * Permite preencher o campo texto com o caminho do ficheiro
     */
    private void settextFieldPath(String path)
    {
        if(path == "")
        {
            jTextFieldPathFile.setEnabled(false);
        }else{
            jTextFieldPathFile.setText(path);
        }        
    }

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jTextFieldPathFile = new javax.swing.JTextField();
        jDateChooserDataImport = new com.toedter.calendar.JDateChooser();
        jButtonImport = new javax.swing.JButton();
        jButtonClose = new javax.swing.JButton();
        jLabelFile = new javax.swing.JLabel();
        jLabelDate = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.DO_NOTHING_ON_CLOSE);

        jTextFieldPathFile.setEditable(false);

        jDateChooserDataImport.setToolTipText("");
        jDateChooserDataImport.setDateFormatString("dd/MM/yyyy");
        jDateChooserDataImport.setFont(new java.awt.Font("Arial", 0, 12)); // NOI18N

        jButtonImport.setText("Importar");
        jButtonImport.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jButtonImportMouseClicked(evt);
            }
        });
        jButtonImport.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonImportActionPerformed(evt);
            }
        });

        jButtonClose.setText("Sair");
        jButtonClose.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonCloseActionPerformed(evt);
            }
        });

        jLabelFile.setText("Ficheiro");

        jLabelDate.setText("Data");

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addComponent(jLabelFile)
                    .addComponent(jLabelDate))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING, false)
                        .addGroup(layout.createSequentialGroup()
                            .addComponent(jButtonImport)
                            .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(jButtonClose))
                        .addComponent(jDateChooserDataImport, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.PREFERRED_SIZE, 157, javax.swing.GroupLayout.PREFERRED_SIZE))
                    .addComponent(jTextFieldPathFile, javax.swing.GroupLayout.PREFERRED_SIZE, 138, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addContainerGap(45, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(22, 22, 22)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jTextFieldPathFile, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jLabelFile))
                .addGap(27, 27, 27)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addComponent(jDateChooserDataImport, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jLabelDate))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 21, Short.MAX_VALUE)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jButtonClose)
                    .addComponent(jButtonImport))
                .addContainerGap())
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void jButtonCloseActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonCloseActionPerformed
        this.dispose();
    }//GEN-LAST:event_jButtonCloseActionPerformed
    
    private void jButtonImportMouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jButtonImportMouseClicked
        if(origin == "quebras")
        {
            importQuebras();
        }
        if(origin == "vendas")
        {
            importResults();
        }
        if(origin == "eliminarquebras")
        {
            deleteQuebras();
        }
        if(origin == "eliminarvendas")
        {
            deleteVendas();
        }        
    }//GEN-LAST:event_jButtonImportMouseClicked

    private void jButtonImportActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonImportActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_jButtonImportActionPerformed

    private void importQuebras()
    {
        //O jDateChooser devolve null caso a data esteja mal
        //Caso a data é bem inserida mas uma data obsoleta é feito a verificação na class
        //utilsdate
        if(jDateChooserDataImport.getDate() != null)
        {
            if(UtilsDate.verifyDate(jDateChooserDataImport.getDate()))
            {
                String date = UtilsDate.dateToStringMysql(jDateChooserDataImport.getDate());
                ResultSet rs = DbData.getDataTable("quebras", "que_date", date, "", true);
                try {
                    if(rs.next())
                    {
                        Messages.messageInformation("Já existe quebras para essa data", "Informação");
                    }else{
                        if(ImportQuebras.ImportQuebras(jTextFieldPathFile.getText().toString(), date))
                        {
                            //Messages.messageInformation("Dados importados com sucesso", "Informação");
                            //o que vou por a mais
                            ResultSet rsJtable = (ResultSet) DbData.getDataTable("quebras", "que_date", date, "", true);
                            ArrayList<Quebras> vendasarray = new ArrayList();
                            while (rsJtable.next())
                            {
                                vendasarray.add(new Quebras(rsJtable.getInt("que_id"), rsJtable.getInt("que_fam_id"),
                                        rsJtable.getInt("que_tq_id"), rsJtable.getInt("que_quantity"), rsJtable.getInt("que_valor"),
                                        rsJtable.getDate("que_date")));
                            }
                            
                            Object[][] donnees = new Object[vendasarray.size()][6];
                            for(int i=0;i<vendasarray.size();i++)
                            {
                                Quebras ve = vendasarray.get(i);
                                donnees[i][0] = ve.getId();
                                donnees[i][1] = ve.getFamId();
                                donnees[i][2] = ve.getTypeQuebras();
                                donnees[i][3] = ve.getQuantity();
                                donnees[i][4] = ve.getValor();
                                donnees[i][5] = ve.getDate();
                            }
                            String[] entetes = {"id", "Familia", "Tipo", "Quantidade", "Valor", "Data"};
                            JTable jtable = new UtilsTable().FillJTable(donnees, entetes, 99, 1);
                            TableDataJFrame tjf = new TableDataJFrame(jtable);
                            tjf.setVisible(true);
                            //fim
                            this.dispose();
                        }else{
                            Messages.messageError("Problema na inserção dos dados na DB", "Informação");                            
                        }
                        this.dispose();
                    }
                } catch (SQLException ex) {
                    //Logger.getLogger(ImportJFrame.class.getName()).log(Level.SEVERE, null, ex);
                    Messages.messageErrorDb("ImportQuebrasJFrame: botão import");
                }
            }else{
                Messages.messageInformation("Tem de seleccionar uma data ou inserir uma data correcta", "Informação");
            }
        }else{
            Messages.messageInformation("Tem de seleccionar uma data ou inserir uma data correcta", "Informação");
        }
    }
    
    private void importResults()
    {
        if(jDateChooserDataImport.getDate() != null)
        {
            if(UtilsDate.verifyDate(jDateChooserDataImport.getDate()))
            {
                String date = UtilsDate.dateToStringMysql(jDateChooserDataImport.getDate());
                ResultSet rs = DbData.getDataTable("vendas", "ve_date", date, "", true);
                try {
                    if(rs.next())
                    {
                        Messages.messageInformation("Já existe vendas para essa data", "Informação");
                    }else{
                        if(new ImportResults().ImportResults(jTextFieldPathFile.getText().toString(), date))
                        {
                            //Messages.messageInformation("Dados importados com sucesso", "Informação");
                            //o que vou por a mais
                            ResultSet rsJtable = (ResultSet) DbData.getDataTable("vendas", "ve_date", date, "", true);
                            ArrayList<Vendas> vendasarray = new ArrayList();
                            while (rsJtable.next())
                            {
                                vendasarray.add(new Vendas(rsJtable.getInt("ve_id"), rsJtable.getInt("ve_fam_id"),
                                        rsJtable.getDouble("ve_valor"), rsJtable.getDate("ve_date")));
                            }
                            
                            Object[][] donnees = new Object[vendasarray.size()][4];
                            for(int i=0;i<vendasarray.size();i++)
                            {
                                Vendas ve = vendasarray.get(i);
                                donnees[i][0] = ve.getId();
                                donnees[i][1] = ve.getFamId();
                                donnees[i][2] = ve.getValor();
                                donnees[i][3] = ve.getDate();
                            }
                            String[] entetes = {"id", "Familia", "Valor", "Data"};
                            JTable jtable = new UtilsTable().FillJTable(donnees, entetes, 99, 1);
                            TableDataJFrame tjf = new TableDataJFrame(jtable);
                            tjf.setVisible(true);
                            //fim
                            this.dispose();
                        }else{
                            Messages.messageError("Problema na inserção dos dados na DB", "Informação");                            
                        }
                        this.dispose();
                    }
                } catch (SQLException ex) {
                    //Logger.getLogger(ImportJFrame.class.getName()).log(Level.SEVERE, null, ex);
                    Messages.messageErrorDb("ImportQuebrasJFrame: botão import");
                }
            }else{
                Messages.messageInformation("Tem de seleccionar uma data ou inserir uma data correcta", "Informação");
            }
        }else{
            Messages.messageInformation("Tem de seleccionar uma data ou inserir uma data correcta", "Informação");
        }
    }
    
    /*
     * Caso pretendo eliminar as quebras de um dia
     */
    private void deleteQuebras()
    {
        if(jDateChooserDataImport.getDate() != null)
        {
            if(DbData.deleteData("quebras", "que_date", UtilsDate.dateToStringMysql(jDateChooserDataImport.getDate())))
            {
                Messages.messageInformation("Quebras Eliminadas", "Informação");
                this.dispose();
            }else{
                Messages.messageError("Problema na eliminaçãs das quebras", "aviso");
                this.dispose();
            }
        }else{
            Messages.messageInformation("Tem de seleccionar uma data", "Informação");
        }        
    }
    
    /*
     * Caso pretendo eliminar as vendas de um dia
     */
    private void deleteVendas()
    {
        if(jDateChooserDataImport.getDate() != null)
        {
            if(DbData.deleteData("vendas", "ve_date", UtilsDate.dateToStringMysql(jDateChooserDataImport.getDate())))
            {
                Messages.messageInformation("Vendas Eliminadas", "Informação");
                this.dispose();
            }else{
                Messages.messageError("Problema na eliminaçãs das vendas", "aviso");
                this.dispose();
            }
        }else{
            Messages.messageInformation("Tem de seleccionar uma data", "Informação");
        }        
    }
    
    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton jButtonClose;
    private javax.swing.JButton jButtonImport;
    private com.toedter.calendar.JDateChooser jDateChooserDataImport;
    private javax.swing.JLabel jLabelDate;
    private javax.swing.JLabel jLabelFile;
    private javax.swing.JTextField jTextFieldPathFile;
    // End of variables declaration//GEN-END:variables
}
