/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import Configuration.configurationJframe;
import java.awt.BorderLayout;
import java.util.ArrayList;
import javax.swing.JPanel;
import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartFrame;
import org.jfree.chart.ChartPanel;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.PlotOrientation;
import org.jfree.data.category.DefaultCategoryDataset;
import org.jfree.data.general.DefaultPieDataset;

/**
 *
 * @author ricardo
 */
public class UtilsGraph {
    
    public void CreatePie()
    {
        DefaultPieDataset data=new DefaultPieDataset();
        data.setValue("Category1",43.2);
        data.setValue("Category2",27.9);
        data.setValue("Category3",79.5);

        //create a chart...
        JFreeChart chart=ChartFactory.createPieChart( "SamplePieChart", data, true/*legend?*/,true/*tooltips?*/, false/*URLs?*/);

        //create and display a frame...
        ChartFrame frame=new ChartFrame("First",chart);
        frame.pack();
        frame.setVisible(true);
    }
    
    /*
     * Cria um frafico de barras simples
     */
    public ChartPanel CreateBarSimple(ArrayList<Number> data, int dayofmonth, String legend, String title, String x,
            String y )
    {
        DefaultCategoryDataset dataset = new DefaultCategoryDataset();

        for (int i = 0; i < dayofmonth; i++) {
                dataset.setValue(data.get(i), legend, new Integer(i+1));
        }
        

        JFreeChart barChart = ChartFactory.createBarChart(title, x, y, 
                                dataset, PlotOrientation.VERTICAL, true, true, false);
        
        ChartPanel cpanel = new ChartPanel(barChart, true, true,true,true,true);
        return cpanel;
    }
}
