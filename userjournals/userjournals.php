<?php
/*
+---------------------------------------------------------------+
+---------------------------------------------------------------+
 */
require_once "../../class2.php";
$WYSIWYG = $pref['wysiwyg'];
$e_wysiwyg = "journal_entry";

$plugPrefs = e107::getPlugPref('userjournals');

// If UJ not active don't display anything at all
if (e107::pref('userjournals', 'userjournals_active') != '1')
{
	e107::redirect();
	exit;
}

// Check that the viewing journals is allowed
if (!check_class(e107::pref('userjournals', 'userjournals_readers')) && !check_class(e107::pref('userjournals', 'userjournals_writers')))
{
	e107::redirect();
	exit;
}

require_once HEADERF;
 
require_once e_PLUGIN . 'userjournals/userjournals_class.php';

$global_userJournals = new UserJournals(true);
$global_userJournals->render();
require_once FOOTERF;
