<?php
/*
+---------------------------------------------------------------+
+---------------------------------------------------------------+
*/
   require_once("../../class2.php");
   require_once(e_ADMIN."auth.php");

   if (!getperms("P")) {
      header("location:../../index.php");
   }

   e107::plugLan("userjournals_menu" , "admin/".e_LANGUAGE, false);
   e107::plugLan("userjournals_menu" , e_LANGUAGE, false);

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

   $pageid     = JOURNAL_MENU_00;

   // Create a form using the helper classes
   $e107HelperForm->createFormFromXML("forms/conf");

   // Process the form
   $e107HelperForm->processForm(true, true);
   $text .= $e107HelperForm->getFormHTML();

   $ns -> tablerender(JOURNAL_MENU_00, $text);

   require_once(e_ADMIN."footer.php");
?>
