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

   // Include the e107 Helper classes
   if (file_exists(e_PLUGIN."e107helpers/e107Helper.php")) {
      require_once(e_PLUGIN."e107helpers/e107Helper.php");
   } else {
      print "Fatal error, cannot find e107Helper class";
   }

   if (file_exists(e_PLUGIN."userjournals_menu/userjournals_class.php")) {
      include(e_PLUGIN."userjournals_menu/userjournals_class.php");
   } else {
      print "Fatal error, cannot find UserJournals class";
   }

   $GLOBALS['userJournals']->UserJournals(true);
   require_once(FOOTERF);
?>
