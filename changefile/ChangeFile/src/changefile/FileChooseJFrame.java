/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package changefile;

import javax.swing.filechooser.FileNameExtensionFilter;

/**
 *
 * @author ricardo
 */
public class FileChooseJFrame extends javax.swing.JFrame {

    /**
     * Creates new form FileChooseJFrame
     */
    public String FileChooseJFrame() {
        initComponents();
        
        //jFileChooser.setFileFilter(new FileNameExtensionFilter("Ficheiro xls", "xls"));
        
        if (jFileChooser.showOpenDialog(this) == jFileChooser.APPROVE_OPTION)
        {
            String filename = jFileChooser.getSelectedFile().getName().toString();
            this.dispose();
            return jFileChooser.getSelectedFile().getPath().toString();
            //ImportJFrame iq = new ImportJFrame(jFileChooser.getSelectedFile().getPath(), origin);
            //iq.setVisible(true);             
        }else{
            this.dispose();
            return "";
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

        jFileChooser = new javax.swing.JFileChooser();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        jFileChooser.setCurrentDirectory(new java.io.File("L:\\"));
            jFileChooser.setFileFilter(null);

            javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
            getContentPane().setLayout(layout);
            layout.setHorizontalGroup(
                layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                .addComponent(jFileChooser, javax.swing.GroupLayout.DEFAULT_SIZE, 723, Short.MAX_VALUE)
            );
            layout.setVerticalGroup(
                layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                .addGroup(layout.createSequentialGroup()
                    .addComponent(jFileChooser, javax.swing.GroupLayout.PREFERRED_SIZE, 595, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addGap(0, 0, Short.MAX_VALUE))
            );

            pack();
        }// </editor-fold>//GEN-END:initComponents

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JFileChooser jFileChooser;
    // End of variables declaration//GEN-END:variables
}
