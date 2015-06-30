/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Db;

import Utils.Messages;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author ricardo
 */
public class DbData {
    
    /*
     * Permite ir a BD buscar uma tabela com um clausula where.
     * order = true = ASC
     * order = false = DESC
     */
    public static ResultSet getDataTable(String table, String columnwhere,String where,
                    String orderby, boolean order)
    {
        try {
            if(!where.equals("") && !columnwhere.equals("") && !orderby.equals(""))
            {
                if(order)
                {
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" = '"+where+"' ORDER BY "+orderby+" ASC");
                }else{
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" = '"+where+"' ORDER BY "+orderby+" DESC");
                }
            }
            if(where.equals("") && columnwhere.equals("") && !orderby.equals(""))
            {
                if(order)
                {
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" ORDER BY "+orderby+" ASC");
                }else{
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" ORDER BY "+orderby+" DESC");
                }
            }
            if(where.equals("") && !columnwhere.equals("") && !orderby.equals(""))
            {
                if(order)
                {
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" ORDER BY "+orderby+" ASC");
                }else{
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" ORDER BY "+orderby+" DESC");
                }                
            }
            if(where.equals("") && !columnwhere.equals("") && orderby.equals(""))
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                    "SELECT * FROM "+table+" WHERE "+columnwhere);
            }
            if(where.equals("") && columnwhere.equals("") && orderby.equals(""))
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table);
            }
            //if(!where.equals("") && !columnwhere.equals("") && orderby.equals(""))
            else
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" = '"+where+"'");
            }
        } catch (SQLException ex) {
            Messages.messageErrorDb("DbData: getDataTable");
            return null;
        }
    }
    
    public static ResultSet getDataTableGroupBy(String table, String columnwhere,String where,
                    String orderby, String groupby, boolean order)
    {
        try {
            if(!where.equals("") && !columnwhere.equals("") && !orderby.equals(""))
            {
                if(order)
                {
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" = '"+where+"' GROUP BY "+groupby+" ORDER BY "+orderby+" ASC" );
                }else{
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" = '"+where+"' GROUP BY "+groupby+" ORDER BY "+orderby+" DESC");
                }
            }
            if(where.equals("") && columnwhere.equals("") && !orderby.equals(""))
            {
                if(order)
                {
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" GROUP BY "+groupby+" ORDER BY "+orderby+" ASC");
                }else{
                    return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" GROUP BY "+groupby+" ORDER BY "+orderby+" DESC");
                }
            }
            if(where.equals("") && columnwhere.equals("") && orderby.equals(""))
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" GROUP BY "+groupby);
            }
            //if(!where.equals("") && !columnwhere.equals("") && orderby.equals(""))
            else
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                        "SELECT * FROM "+table+" WHERE "+columnwhere+" = '"+where+"' GROUP BY "+groupby);
            }
        } catch (SQLException ex) {
            Messages.messageErrorDb("DbData: getDataTableGroupBy");
            return null;
        }
    }
    
    public static ResultSet getDataTableGroupByDistinct(String table, String columnwhere,String where,
                    String orderby, String groupby, String distinct, String[] colunas, boolean order)
    {
        try {
            String column = "";
            for(int i=0;i<colunas.length;i++)
            {
                column += ", "+colunas[i];
            }
            
            return (ResultSet) DbConnect.stmt.executeQuery(
                            "SELECT DISTINCT "+distinct+""+column+" FROM "+table+" WHERE "+columnwhere+" = '"+where+"' GROUP BY "+groupby+" ORDER BY "+orderby+" ASC" );
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData: getDataTableGroupByDistinct");
            return null;
        }
    }
    
    /*
     * Se distinct = "" não toma em consideração
     */
    public static ResultSet getDataTableGroupByDistinctMoreWhere(String table, String[] where,
                    String orderby, String groupby, String distinct, String[] colunas, boolean order)
    {
        try {
            String column = "";
            for(int i=0;i<colunas.length;i++)
            {
                if(distinct == "" && i == 0)
                {
                    column += colunas[i];
                }else{
                    column += ", "+colunas[i];
                }
            }
            String wherequery = "";
            for(int i=0;i<where.length;i++)
            {
                boolean par =  Utils.Utils.isPar(i);
                
                if(par)
                {
                    if(i+1 < where.length)
                    {
                        wherequery += where[i]+ " = ";
                    }else{
                        wherequery += where[i];
                    }                    
                }else{
                    wherequery += "'"+where[i]+"'";
                }
                if(i+1 < where.length && !par)
                {
                    wherequery += " AND ";
                }
            }
            if(distinct == "")
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                            "SELECT "+column+" FROM "+table+" WHERE "+wherequery+" GROUP BY "+groupby+" ORDER BY "+orderby+" ASC" );
            }else{
                return (ResultSet) DbConnect.stmt.executeQuery(
                            "SELECT DISTINCT "+distinct+""+column+" FROM "+table+" WHERE "+wherequery+" GROUP BY "+groupby+" ORDER BY "+orderby+" ASC" );
            }
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData: getDataTableGroupByDistinct");
            return null;
        }
    }
    
    /*
     * Fazer a soma do valor de uma coluna 
     */
    public static ResultSet getSumColuna(String table, String[] where,
                    String coluna)
    {
        try {
            String wherequery = "";
            for(int i=0;i<where.length;i++)
            {
                boolean par =  Utils.Utils.isPar(i);
                
                if(par && i+1 < where.length)
                {
                    wherequery += where[i]+ " = ";
                }else{
                    if(i+1 < where.length)
                    {
                        wherequery += "'"+where[i]+"'";
                    }else{
                        wherequery += where[i];
                    }
                }
                if(i+1 < where.length && !par)
                {
                    wherequery += " AND ";
                }
            }
            return (ResultSet) DbConnect.stmt.executeQuery(
                "SELECT SUM("+coluna+") AS "+coluna+" FROM "+table+" WHERE "+wherequery);
            
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData: getSumColuna");
            return null;
        }
    }
    
    /*
     * Faz a soma de uma coluna 
     * no coluna = o primeiro elemento é aquele que se pretende a soma
     */
    public static ResultSet getSumColunaMore(String table, String[] where,
                    String coluna[], String groupby, String orderby)
    {
        try {
            String wherequery = "";
            for(int i=0;i<where.length;i++)
            {
                boolean par =  Utils.Utils.isPar(i);
                
                if(par && i+1 < where.length)
                {
                    wherequery += where[i]+ " = ";
                }else{
                    if(i+1 < where.length)
                    {
                        wherequery += "'"+where[i]+"'";
                    }else{
                        wherequery += where[i];
                    }
                }
                if(i+1 < where.length && !par)
                {
                    wherequery += " AND ";
                }
            }
            String select = "";
            for(int j=0;j<coluna.length;j++)
            {
                if(j == 0)
                {
                    select += "SUM("+coluna[j]+") AS "+coluna[j];
                }else{
                    select += ", "+coluna[j];
                }                
            }
            if(groupby == "" && orderby == "")
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                    "SELECT "+select+" FROM "+table+" WHERE "+wherequery);
            }
            if(groupby != "" && orderby == "")
            {
                return (ResultSet) DbConnect.stmt.executeQuery(
                    "SELECT "+select+" FROM "+table+" WHERE "+wherequery+" GROUP BY "+groupby);
            }else{
                return (ResultSet) DbConnect.stmt.executeQuery(
                    "SELECT "+select+" FROM "+table+" WHERE "+wherequery+" GROUP BY "+groupby+" ORDER BY "+orderby);
            }
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData: getSumColunaMore");
            return null;
        }
    }
    
    /*
     * Devolve o valor que queremos da tabela
     */
    public static String getValueTable (String table, String columnwhere, String where,
            String column)
    {
        try {
            ResultSet rs = (ResultSet) DbConnect.stmt.executeQuery(
                            "SELECT * FROM "+table+" WHERE "+columnwhere+" = '"+where+"'");
            String res = "";
            while(rs.next())
            {
                res = rs.getString(column);
            }
            return res;
            
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("dbData : getValueTable");
            return null;
        }        
    }
    

    /*
     * Esse método é o melhor para só uma linha, para vários usar o outro por causa do rollback
     * Permite inserir dados numa BD
     * data = arraylist com os dados dos campos
     * column = colunas onde vão esse dados
     */
    public static int insertData(String table, ArrayList data, ArrayList column)
    {
        try {
            String values = "Values (";
            String coldb = " (";

            for(int i = 0;i<data.size();i++)
            {
                values += "'"+data.get(i)+"'";
                if(i+1 < data.size())
                {
                    values += ", ";
                }
            }
            for(int i = 0;i<column.size();i++)
            {
                coldb += column.get(i);
                if(i+1 < column.size())
                {
                    coldb += ", ";
                }
            }
            coldb += ")";
            values += ")";
            return DbConnect.stmt.executeUpdate("INSERT "+table+""+coldb+" "+values);
            
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData : insertData");
            return 0;
        }
    }
    
    /*
     * Métodos para inserir várias linhas e com rollback
     */
    public static boolean insertDatas(String table, ArrayList data, ArrayList column)
    {
        try {
            String values = "Values (";
            String coldb = " (";

            for(int i = 0;i<data.size();i++)
            {
                values += "'"+data.get(i)+"'";
                if(i+1 < data.size())
                {
                    values += ", ";
                }
            }
            for(int i = 0;i<column.size();i++)
            {
                coldb += column.get(i);
                if(i+1 < column.size())
                {
                    coldb += ", ";
                }
            }
            coldb += ")";
            values += ")";
            Connection con = (Connection) DbConnect.getConnection();
            PreparedStatement pst = (PreparedStatement) con.prepareStatement("INSERT INTO "+table+""+coldb+" "+values);
            pst.execute();
            pst.close();
            return true;
            //DbConnect.stmt.executeUpdate("INSERT INTO "+table+""+coldb+" "+values);
            
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData : insertDatas");
            return false;
        }
    }
    
    /*
     * Elimna dados de uma tabela e devolve true se foi eliminado
     */
    public static boolean deleteData(String table, String columnwhere, String where)
    {
        try {
            int query = DbConnect.stmt.executeUpdate("DELETE FROM "+table+" WHERE "+columnwhere+" = '"+where+"'");
            if(query > 0)
            {
                return true;
            }else{
                return false;
            }
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData: deletedata");
            return false;
        }
    }
    
    /*
     * Método com rollback
     * Elimna dados de uma tabela e devolve true se foi eliminado
     */
    public static boolean deleteDataWithRollB(String table, String columnwhere, String where)
    {
        try {
            Connection con = (Connection) DbConnect.getConnection();
            PreparedStatement pst;
            if(where.equals(""))
            {
                pst = (PreparedStatement) con.prepareStatement("DELETE FROM "+table+" WHERE "+columnwhere);
            }else{
                pst = (PreparedStatement) con.prepareStatement("DELETE FROM "+table+" WHERE "+columnwhere+" = '"+where+"'");
            }            
            pst.execute();
            pst.close();
            return true;
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("DbData: deletedataWithRollB");
            return false;
        }
    }

    /*
     * Devolve a linha do ultimo id inserido na DB
     */
    public static ResultSet getLastId(String table, String column)
    {
        try {
            return (ResultSet) DbConnect.stmt.executeQuery("SELECT * FROM "+table+
                                    " WHERE "+column+" = (SELECT MAX("+column+") FROM "+table+")");
        } catch (SQLException ex) {
            //Logger.getLogger(DbData.class.getName()).log(Level.SEVERE, null, ex);
            Messages.messageErrorDb("dbData : getLastId");
            return null;
        }
    }
    
    /*
     * commit com rollback
     */
    public static boolean rollbakcCommit(Connection con)
    {
        try 
        {
            con.commit();
            DbConnect.setAutocommit(true);
            return true;
        } catch (SQLException ex) {
            try {
                //Logger.getLogger(ImportQuebras.class.getName()).log(Level.SEVERE, null, ex);
                con.rollback();
                DbConnect.setAutocommit(true);
                return false;
            } catch (SQLException ex1) {
                //Logger.getLogger(ImportQuebras.class.getName()).log(Level.SEVERE, null, ex1);
                DbConnect.setAutocommit(true);
                return false;
            }
        }
    }
}
