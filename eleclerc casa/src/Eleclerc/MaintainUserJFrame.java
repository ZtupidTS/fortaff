/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Eleclerc;

import Type.Users;
import Type.Menu;
import Configuration.configurationJframe;
import Db.DbConnect;
import Db.DbData;
import Utils.*;
import com.mysql.jdbc.Connection;
import java.awt.Color;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.*;

/**
 *
 * @author ricardo
 */
public class MaintainUserJFrame extends javax.swing.JFrame {

    private JTable jtable;
    private int columneditable;
    
    /**
     * Creates new form MaintainUserJFrame
     */
    public MaintainUserJFrame() {
        initComponents();
        
        this.setTitle("Gestão de Utilizadores");
        try {
            configurationJframe.inicialConfiguration(this);
        } catch (SQLException ex) {
            //Logger.getLogger(MainJFrame.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("MainJFrame : inicialização jframe");
        }
        fillJlist();        
    }

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jScrollPane2 = new javax.swing.JScrollPane();
        jListUsers = new javax.swing.JList();
        jButtonExit = new javax.swing.JButton();
        jScrollPaneAuthorization = new javax.swing.JScrollPane();
        jButtonSave = new javax.swing.JButton();
        jButtonCreateUser = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.DO_NOTHING_ON_CLOSE);

        jListUsers.setSelectionMode(javax.swing.ListSelectionModel.SINGLE_SELECTION);
        jListUsers.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jListUsersMouseClicked(evt);
            }
        });
        jScrollPane2.setViewportView(jListUsers);

        jButtonExit.setText("Fechar");
        jButtonExit.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonExitActionPerformed(evt);
            }
        });

        jScrollPaneAuthorization.setAutoscrolls(true);

        jButtonSave.setText("Gravar");
        jButtonSave.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonSaveActionPerformed(evt);
            }
        });

        jButtonCreateUser.setText("Criar Utilizador");
        jButtonCreateUser.setToolTipText("");
        jButtonCreateUser.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonCreateUserActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(19, 19, 19)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(jScrollPane2, javax.swing.GroupLayout.PREFERRED_SIZE, 157, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addGap(18, 18, 18)
                        .addComponent(jScrollPaneAuthorization, javax.swing.GroupLayout.DEFAULT_SIZE, 461, Short.MAX_VALUE))
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(jButtonCreateUser)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                        .addComponent(jButtonSave)
                        .addGap(18, 18, 18)
                        .addComponent(jButtonExit)))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(jScrollPaneAuthorization)
                    .addComponent(jScrollPane2, javax.swing.GroupLayout.DEFAULT_SIZE, 413, Short.MAX_VALUE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 11, Short.MAX_VALUE)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jButtonExit)
                    .addComponent(jButtonSave)
                    .addComponent(jButtonCreateUser))
                .addContainerGap())
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void jButtonExitActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonExitActionPerformed
        this.dispose();
    }//GEN-LAST:event_jButtonExitActionPerformed

    private void jListUsersMouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jListUsersMouseClicked
        try {
            ResultSet rs = (ResultSet)DbData.getDataTable("menumain", "", "", "menu_number", true);
            //adiciono no array os dados da DB
            ArrayList<Menu> menuarray = new ArrayList();
            while (rs.next())
            {
                menuarray.add(new Menu(rs.getInt("menu_id"), rs.getInt("menu_number"),
                        rs.getString("menu_description")));
            }
            
            Object[][] donnees = new Object[menuarray.size()][4];
            for(int i=0;i<menuarray.size();i++)
            {
                Menu us = menuarray.get(i);
                donnees[i][0] = us.getMenuId();
                donnees[i][1] = us.getMenuNumber();
                donnees[i][2] = us.getMenuDescription();
                if(Users.containMenuAuth(us.getMenuDescription(), jListUsers.getSelectedValue().toString()))
                {
                    donnees[i][3] = true;
                }else{
                    donnees[i][3] = false;
                }
            }
            String[] entetes = {"Menu id", "Menu Numero", "Menu Descrição", "Acesso"};
            //numero da minha colune que estou a editar para recuperar mais tarde
            columneditable = 3;
            jtable = new UtilsTable().FillJTable(donnees, entetes, columneditable, 1);
            jScrollPaneAuthorization.setViewportView(jtable);
            
        } catch (SQLException ex) {
            //Logger.getLogger(MaintainUserJFrame.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("MaintainUsers : jListUsersMouseClicked");
        }
    }//GEN-LAST:event_jListUsersMouseClicked

    private void jButtonSaveActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonSaveActionPerformed
        ArrayList menuok = new ArrayList();
        int user = 0;
        for(int i=0;i<jtable.getRowCount();i++)
        {
            if((Boolean)jtable.getValueAt(i, columneditable))
            {
                menuok.add(jtable.getValueAt(i, 0));
            }
            user = Users.getUserConfNow();
        }
        if(menuok.isEmpty())
        {
            if(DbData.deleteData("userauth", "usa_usr_id", Utils.convertIntegerToString(user)))
            {
                DbData.deleteData("users", "usr_id", Utils.convertIntegerToString(user));
                Messages.messageInformation("Utilizador eliminado", "Informação"); 
                fillJlist();
            }else{
                Messages.messageInformation("Utilizador Não eliminado, verificar problemas", "Informação"); 
                fillJlist();
            }
        }else{
            try {
                ArrayList tempdata = new ArrayList();
                ArrayList tempcolumn = new ArrayList();
                //preparo para o roolback
                DbConnect.setAutocommit(false);
                // vou primeiro eliminar os dados existentes
                ResultSet rs = (ResultSet) DbData.getDataTable("userauth", "usa_usr_id",
                        Utils.convertIntegerToString(user), "", true);
                //Verifico se o user já tem alguma autorização
                //se tem elimino
                if(rs.next())
                {
                    DbData.deleteDataWithRollB("userauth", "usa_usr_id",
                        Utils.convertIntegerToString(user));
                }
                for (int j=0;j<menuok.size();j++)
                {
                    tempdata.add(Utils.convertIntegerToString(user));
                    tempdata.add(menuok.get(j));
                    tempcolumn.add("usa_usr_id");
                    tempcolumn.add("usa_menu_id");
                    
                    DbData.insertDatas("userauth", tempdata, tempcolumn);
                    tempdata.clear();
                    tempcolumn.clear();
                }
                
                if(DbData.rollbakcCommit((Connection)DbConnect.getConnection()))
                {
                    Messages.messageInformation("Utilizador Atualizado", "Informação");
                }else{
                    Messages.messageError("Problema na atualização do utlizador", "Aviso");
                }
                
            } catch (SQLException ex) {
                //Logger.getLogger(MaintainUserJFrame.class.getName()).log(Level.SEVERE, null, ex);
                Messages.messageErrorDb("MaintainuserJframe : botão save");
            }
        }
    }//GEN-LAST:event_jButtonSaveActionPerformed

    private void jButtonCreateUserActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonCreateUserActionPerformed
        CreateUserJFrame cjf = new CreateUserJFrame();
        cjf.setVisible(true);
        this.dispose();
    }//GEN-LAST:event_jButtonCreateUserActionPerformed

    /*
     * Preeencha a jlist
     */
    private void fillJlist()
    {
        //permite preeencher a jlist com o nome dos users
        DefaultListModel model = new DefaultListModel();
        ArrayList<String> users = Users.allUsers();
        for (int i = 0;i<users.size();i++) 
        {
            model.addElement(users.get(i));
        }
        jListUsers.setModel(model);
    }
    
    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton jButtonCreateUser;
    private javax.swing.JButton jButtonExit;
    private javax.swing.JButton jButtonSave;
    private javax.swing.JList jListUsers;
    private javax.swing.JScrollPane jScrollPane2;
    private javax.swing.JScrollPane jScrollPaneAuthorization;
    // End of variables declaration//GEN-END:variables
}