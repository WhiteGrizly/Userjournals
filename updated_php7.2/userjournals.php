<?php
/*
+---------------------------------------------------------------+
+---------------------------------------------------------------+
*/
   require_once("../../class2.php");
   $WYSIWYG = $pref['wysiwyg'];
   $e_wysiwyg = "journal_entry";
   
   $plugPrefs = e107::getPlugPref('userjournals_menu');
         
   // If UJ not active don't display anything at all
   if (e107::pref('userjournals_menu', 'userjournals_active') != '1'){        
      header("location:../../index.php");
      exit;
   }

   // Check that the viewing journals is allowed
   if (!check_class(e107::pref('userjournals_menu', 'userjournals_readers') ) && !check_class(e107::pref('userjournals_menu', 'userjournals_writers') ) ) {
      header("location:../../index.php");
      exit;
   }

   require_once(HEADERF);
   // waiting for shortcodes ?
   //$global_userJournals = e107::getSingleton('UserJournals', e_PLUGIN.'userjournals_menu/userjournals_class.php');
   
   require_once(HEADERF);
   
   require_once(e_PLUGIN.'userjournals_menu/userjournals_class.php');
   $global_userJournals = new UserJournals(true);
   $global_userJournals->render();
   require_once(FOOTERF);
 
