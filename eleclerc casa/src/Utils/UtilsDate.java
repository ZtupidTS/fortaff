/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

/**
 *
 * @author ricain
 */
public class UtilsDate {
    
    /*
     * Recebe uma date e converte em string para depois inserção na DB
     */
    public static String dateToStringMysql(Date date)
    {
        return String.format("%1$tY-%1$tm-%1$td", date);
    }
    
    /*
     * Verificar se a data recebida esta no intervalo de datas decentes
     */
    public static boolean verifyDate(Date date)
    {
        Calendar min = Calendar.getInstance();  
        min.set(Calendar.YEAR,1970);  
        min.set(Calendar.MONTH,1);  
        min.set(Calendar.DATE,1);
        
        Calendar max = Calendar.getInstance();  
        max.set(Calendar.YEAR,3000);  
        max.set(Calendar.MONTH,1);  
        max.set(Calendar.DATE,1);
        
        if(date.getTime() >= min.getTime().getTime())
        {
            if(date.getTime() <= max.getTime().getTime())
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    /*
     * Devolve a data do dia atual em string
     */
    public static String getToday()
    {
        DateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
        Date date = new Date();
        return dateFormat.format(date).toString();        
    }
    
    /*
     * Recebe um inteiro referente ao mês e devolve o numero de dias do mês
     */
    public static int dayOfMonth(int month)
    {
        Calendar cal = Calendar.getInstance();
        cal.set(Calendar.MONTH, month-1);
        return cal.getActualMaximum(Calendar.DAY_OF_MONTH);
    }
    
    /*
     * Devolve me o dia de uma data que vem do mysql
     */
    public static int getDay(Date date)
    {
        String newdate = dateToStringMysql(date);
        String str[] = newdate.split("-");
        return Utils.convertStringToInt(str[2]);
    }
    
    /*
     * Devolve me o mês de uma data que vem do mysql
     */
    public static int getMonth(Date date)
    {
        String newdate = dateToStringMysql(date);
        String str[] = newdate.split("-");
        return Utils.convertStringToInt(str[1]);
    }
    
    /*
     * Devolve me o ano de uma data que vem do mysql
     */
    public static int getYear(Date date)
    {
        String newdate = dateToStringMysql(date);
        String str[] = newdate.split("-");
        return Utils.convertStringToInt(str[0]);
    }
}
