<?php
class AdiantiMenuBuilder
{
    public static function parse($file, $theme)
    {
        switch ($theme)
        {
            case 'theme1':
                ob_start();
                $callback = array('SystemPermission', 'checkPermission');
                $menu = TMenuBar::newFromXML('menu.xml', $callback);
                $menu->show();
                $menu_string = ob_get_clean();
                return $menu_string;
                break;
            case 'theme2':
                ob_start();
                $callback = array('SystemPermission', 'checkPermission');
                $xml = new SimpleXMLElement(file_get_contents('menu.xml'));
                $menu = new TMenu($xml, $callback, 1, 'nav collapse', '');
                $menu->class = 'nav';
                $menu->id    = 'side-menu';
                $menu->show();
                $menu_string = ob_get_clean();
                return $menu_string;
                break;
            case 'theme3':
                ob_start();
                $callback = array('SystemPermission', 'checkPermission');
                $xml = new SimpleXMLElement(file_get_contents('menu.xml'));
                $menu = new TMenu($xml, $callback, 1, 'treeview-menu', 'treeview', '');
                $menu->class = 'sidebar-menu';
                $menu->id    = 'side-menu';
                $menu->show();
                $menu_string = ob_get_clean();
                return $menu_string;
                break;
            default:
                ob_start();
                $callback = array('SystemPermission', 'checkPermission');
                $xml = new SimpleXMLElement(file_get_contents('menu.xml'));
                $menu = new TMenu($xml, $callback, 1, 'ml-menu', 'x', 'menu-toggle waves-effect waves-block');
                
                $li = new TElement('li');
                $li->{'class'} = 'active';
                $menu->add($li);
                
                $li = new TElement('li');
                $li->add('MENU');
                $li->{'class'} = 'header';
                $menu->add($li);
                
                $menu->class = 'list';
                $menu->style = 'overflow: hidden; width: auto; height: 390px;';
                $menu->show();
                $menu_string = ob_get_clean();
                return $menu_string;
                break;
        }
    }
}