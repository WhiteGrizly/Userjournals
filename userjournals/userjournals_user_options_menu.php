<?php

// If UJ not active don't display anything at all
if (e107::pref('userjournals', 'userjournals_active') == "1")
{

	if (class_exists('UserJournals'))
	{
		$userjournals_user_options_menu = new UserJournals();
	}
	else
	{
		require_once e_PLUGIN . 'userjournals/userjournals_class.php';
		$userjournals_user_options_menu = new UserJournals();
	}

	$userjournals_user_options_menu->GetWriterMenu();

}
