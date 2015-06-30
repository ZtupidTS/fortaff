/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

/**
 *
 * @author ricardo
 */
public class UtilsDb {
    
    /*
     * Dou um numero e o nome da coluna e devolve uma string para a query
     */
    public String getWhere(String column, int number)
    {
        if(number < 10)
        {
            return column+" > '0' AND "+column+" < '10'";
        }
        if(number > 10 && number < 1000)
        {
            return column+" > '10' AND "+column+" < '1000'";
        }
        else
        //if (number > 100000 && number < 1000000)
        {
            return column+" > '100000' AND "+column+" < '1000000'";
        }
    }
    
    /*
     * Dou o nome da coluna e devolve uma string para a query
     */
    public String getWhereSubsection(String column)
    {
        return column+" > '0' AND "+column+" < '900'";        
    }
}
