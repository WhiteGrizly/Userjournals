<?php
e107::plugLan("userjournals_menu" , "admin/".e_LANGUAGE, false);
e107::plugLan("userjournals_menu" , e_LANGUAGE, false);

$search_info[] = array(
   'sfile'     => e_PLUGIN.'userjournals_menu/search.php',
   'qtype'     => UJ1,
   'refpage'   => 'userjournals.php'
);

?>
