<?php
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Custom install/uninstall/update routines for userjournals plugin
**
*/

 e107::plugLan("userjournals" , "admin/".e_LANGUAGE, false);
 e107::plugLan("userjournals" , e_LANGUAGE, false);

if(!class_exists("userjournals_setup"))
{
	class userjournals_setup
	{

	    function install_pre($var)
		{

		}

		/**
		 * For inserting default database content during install after table has been created by the userjournals_sql.php file.
		 */
		function install_post($var)
		{
			$sql = e107::getDb();
			$mes = e107::getMessage();
		}

		function uninstall_options()
		{

		 
		}


		function uninstall_post($var)
		{
 
		}


		/*
		 * Call During Upgrade Check. May be used to check for existance of tables etc and if not found return TRUE to call for an upgrade.
		 *
		 * @return bool true = upgrade required; false = upgrade not required
		 */
		function upgrade_required()
		{
 
             $eplug_prefs = array(
               "userjournals_active"            => "userjournals_active",
               "userjournals_allowratings"      => "userjournals_allowratings",
               "userjournals_allowcomments"     => "userjournals_allowcomments",
               "userjournals_bloggers_menu_max" => "userjournals_bloggers_menu_max",
               "userjournals_bloggers_per_page" => "userjournals_bloggers_per_page",
               "userjournals_blogs_per_page"    => "userjournals_blogs_per_page",
               "userjournals_cat_menu_title"    => "userjournals_cat_menu_title",
               "userjournals_len_subject"       => "userjournals_len_subject",
               "userjournals_len_preview"       => "userjournals_len_preview",
               "userjournals_title"        => "userjournals_title",                                                      
               "userjournals_page_title"        => "userjournals_page_title",
               "userjournals_readers"           => "userjournals_readers",
               "userjournals_recent_entries"    => "userjournals_recent_entries",     
               "userjournals_report_blog"       => "userjournals_report_blog",        //???    missing from plugin.php   
               "userjournals_show_cats"         => "userjournals_show_cats", 
               "userjournals_show_mood"         => "userjournals_show_mood",
               "userjournals_show_playing"      => "userjournals_show_playing",
               "userjournals_show_rss"          => "userjournals_show_rss",
               "userjournals_template"          => "userjournals_template",
               "userjournals_writers"           => "userjournals_writers", 
            );

			$old_eplug_prefs = e107::getConfig('core')->getPref(); 
             
			if(isset($old_eplug_prefs['userjournals_active']))
			{
                if($newPrefs = e107::getConfig()->migrateData($eplug_prefs,true)) // returns new array with values and deletes core pref. 
                {
                    $result = e107::getPlugConfig('userjournals')->setPref($newPrefs)->save(false,true,false); // save new prefs to 'myplugin'. 
                }
			}

			return false;
		}


		function upgrade_post($var)
		{
			// $sql = e107::getDb();
		}

	}

}

/* help
$plugPrefs = e107::getPlugPref('userjournals');
e107::pref('userjournals', 'userjournals_active')
e107::pref('userjournals', 'userjournals_allowratings')
e107::pref('userjournals', 'userjournals_allowcomments')
e107::pref('userjournals', 'userjournals_bloggers_menu_max')
e107::pref('userjournals', 'userjournals_bloggers_per_page')
e107::pref('userjournals', 'userjournals_blogs_per_page'>')
e107::pref('userjournals', 'userjournals_cat_menu_title'>')
e107::pref('userjournals', 'userjournals_len_subject'>')
e107::pref('userjournals', 'userjournals_len_preview'>')
e107::pref('userjournals', 'userjournals_title'>')
e107::pref('userjournals', 'userjournals_page_title'>')
e107::pref('userjournals', 'userjournals_readers')
e107::pref('userjournals', 'userjournals_recent_entries'>')
e107::pref('userjournals', 'userjournals_report_blog')
e107::pref('userjournals', 'userjournals_show_cats')
e107::pref('userjournals', 'userjournals_show_mood')
e107::pref('userjournals', 'userjournals_show_playing')
e107::pref('userjournals', 'userjournals_show_rss')
e107::pref('userjournals', 'userjournals_writers')
e107::pref('userjournals', 'userjournals_template')

e107::redirect(e_PLUGIN."userjournals/userjournals.php?blog.".$blogid);

*/