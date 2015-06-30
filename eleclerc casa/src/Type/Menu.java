/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package Type;

/**
 *
 * @author ricardo
 */
public class Menu {
    
    private int menu_id;
    private int menu_number;
    private String menu_description;
    
    public Menu(int menu_id, int menu_number, String menu_description)
    {
        this.menu_id = menu_id;
        this.menu_number = menu_number;
        this.menu_description = menu_description;
    }
    
    public int getMenuId()
    {
        return this.menu_id;
    }
    
    public int getMenuNumber()
    {
        return this.menu_number;
    }
    
    public String getMenuDescription()
    {
        return this.menu_description;
    }
}
