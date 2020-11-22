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

   $pageid = JOURNAL_MENU_01;

   // Create a form using the helper classes
   $e107HelperForm->createFormFromXML("forms/categories");

   // Process the form
   $e107HelperForm->processForm(true, true);
   $text .= $e107HelperForm->getFormHTML();

   $ns -> tablerender(JOURNAL_MENU_00, $text);

   require_once(e_ADMIN."footer.php");
?>
