<?php
/**
 * @package XpertAccess
 * @version 3.2
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
// no direct access
defined('_JEXEC') or die;

class modXpertAccessHelper
{
    static function getReturnURL($params, $type)
    {
        $app	= JFactory::getApplication();
        $router = $app->getRouter();
        $url = null;
        if ($itemid =  $params->get($type))
        {
            $db		= JFactory::getDbo();
            $query	= $db->getQuery(true);

            $query->select($db->quoteName('link'));
            $query->from($db->quoteName('#__menu'));
            $query->where($db->quoteName('published') . '=1');
            $query->where($db->quoteName('id') . '=' . $db->quote($itemid));

            $db->setQuery($query);
            if ($link = $db->loadResult()) {
                if ($router->getMode() == JROUTER_MODE_SEF) {
                    $url = 'index.php?Itemid='.$itemid;
                }
                else {
                    $url = $link.'&Itemid='.$itemid;
                }
            }
        }
        if (!$url)
        {
            // stay on the same page
            $uri = clone JFactory::getURI();
            $vars = $router->parse($uri);
            unset($vars['lang']);
            if ($router->getMode() == JROUTER_MODE_SEF)
            {
                if (isset($vars['Itemid']))
                {
                    $itemid = $vars['Itemid'];
                    $menu = $app->getMenu();
                    $item = $menu->getItem($itemid);
                    unset($vars['Itemid']);
                    if (isset($item) && $vars == $item->query) {
                        $url = 'index.php?Itemid='.$itemid;
                    }
                    else {
                        $url = 'index.php?'.JURI::buildQuery($vars).'&Itemid='.$itemid;
                    }
                }
                else
                {
                    $url = 'index.php?'.JURI::buildQuery($vars);
                }
            }
            else
            {
                $url = 'index.php?'.JURI::buildQuery($vars);
            }
        }

        return base64_encode($url);
    }

    static function getType()
    {
        $user = JFactory::getUser();
        return (!$user->get('guest')) ? 'logout' : 'login';
    }

    static function loadScripts(&$params)
    {
        static $script_loaded;

        $app = JFactory::getApplication('site', array(), 'J');

        $version = '1.10.2';
        $cdn = $params->get('jquery_source') ? $params->get('jquery_source') : 'local';

        $filename = 'jquery-1.10.2.min.js';

        $file = '//ajax.googleapis.com/ajax/libs/jquery/'.$version.'/jquery.min.js';

        // joomla 2.5 check
        if ( version_compare(JVERSION, '2.5', 'ge') && version_compare(JVERSION, '3.0', 'lt') )
        {
            if( $params->get('jquery_enabled') OR $params->get('load_jquery') )
            {
                if( !$app->get('jQuery') )
                {
                    if( $cdn == 'local')
                    {
                        $file = JURI::root(true).'/modules/mod_xpertaccess/assets/js/'.$filename;
                    }

                    $app->set('jQuery',$version);
                    JFactory::getDocument()->addScript($file);
                }
            }

        }else{
            JHtml::_('jquery.framework');
        }

        if( !$script_loaded ){
            //add modal js file
            JFactory::getDocument()->addScript(JURI::root(true).'/modules/mod_xpertaccess/assets/js/xkmodal.min.js');
            $script_loaded = TRUE;
        }
    }

    static function loadStyles($params)
    {
        $app            = JFactory::getApplication('site', array(), 'J');
        $template       = $app->getTemplate();

        static $base_css_loaded;

        if (file_exists( JPATH_SITE. '/templates/' . $template . '/css/xpertaccess.css') )
        {
           JFactory::getDocument()->addStyleSheet( JURI::root(true).'/templates/'.$template.'/css/xpertaccess.css' );
        }
        else {
            if(!$base_css_loaded)
            {
                JFactory::getDocument()->addStyleSheet( JURI::root(true). '/modules/mod_xpertaccess/assets/css/xpertaccess.css' );
                $base_css_loaded = TRUE;
            }
        }

    }


}
