<?php
/**
 * Userjournals Shortcodes
 * @todo SEF
 */

class userjournals_shortcodes extends e_shortcode
{

	public $plugPrefs;
	var $cats;
 

	public function __construct()
	{
		$this->plugPrefs = e107::getPlugPref('userjournals');
	}

	function sc_user_profile_url($parm='')
	{
	    $uparams = array('id' => $this->var['userjournals_userid'], 'name' => $this->var['user_name']);
	    return e107::getUrl()->create('user/profile/view', $uparams);
	}

	/* {USER_NAME_LINK}  */
	function sc_user_name_link($parm='')  
	{
	   $url = $this->sc_user_profile_url(); 
	   return "<a href='".$url."'><img src='images/user_with_smile.svg' width='32px' alt='"._MEMBERPROFILE."' title='"._MEMBERPROFILE."' ></a>";
	}


	public function sc_UJ_BLOGGER_NAME($parm = '')
	{
		$text = "";
		//if ($row = getx_user_data($this->var["userjournals_userid"])) {
		if ($row = e107::user($this->var["userjournals_userid"]))
		{
			$text = $row["user_name"];
		}
		return $text;
	}

	public function sc_UJ_BLOGGER_TIMESTAMP($parm = '')
	{

		return e107::getDate()->convert_date($this->var["userjournals_timestamp"], "long");
	}

	public function sc_UJ_BLOGGER_LINK($parm = '')
	{

		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?blogger." . $this->var["userjournals_userid"] . "'>" . UJ90 . "</a>";
	}

	public function sc_UJ_BLOGGER_MENU_LINK($parm = '')
	{

		//if ($row = getx_user_data($this->var["userjournals_userid"])) {
		if ($row = e107::user($this->var["userjournals_userid"]))
		{
			return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?blogger." . $this->var["userjournals_userid"] . "'>" . $row["user_name"] . "</a><br/>" . e107::getDate()->convert_date($this->var["userjournals_timestamp"], "short");
		}
		return "";
	}

	public function sc_uj_blogger_picture($parm = '')
	{
		$text = e107::getParser()->toAvatar($this->var);
		return $text;
	}

	public function sc_uj_blogger_synopsis($parm = '')
	{
		return e107::getParser()->toHTML($this->var["userjournals_entry"], true, 'DESCRIPTION');
	}

	public function sc_UJ_BLOG_LINK($parm = '')
	{

		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?blog." . $this->var["userjournals_id"] . "'>" . UJ48 . "</a>";
	}

	public function sc_uj_blog_mood($parm = '')
	{

		$text = "";
		if (strlen($this->var["userjournals_mood"]) > 0)
		{
			
			parse_str($parm, $parms);
			if (array_key_exists("label", $parms))
			{
				$text .= UJ42 . " ";
			}

			$text .= "<img src='" . e_PLUGIN_ABS . "userjournals/images/" . $this->var["userjournals_mood"] . ".gif' alt='*'/>";
		}
		return $text;
	}

	public function sc_UJ_BLOG_SUBJECT($parm = '')
	{

		return $this->var["userjournals_subject"];
	}

	public function sc_UJ_BLOG_DATE($parm = '')
	{

		$text = "";
		parse_str($parm, $parms);
		if (array_key_exists("label", $parms))
		{
			$text .= UJ46;
		}
		$text .= e107::getDate()->convert_date($this->var["userjournals_timestamp"], "short");
		return $text;
	}

	public function sc_UJ_BLOG_CATEGORIES($parm = '')
	{
 
		$text = "";
		$plugPrefs = e107::getPlugPref('userjournals_menu');
		
		$uj_categories = $this->var['uj_categories'];
 
		if ($this->plugPrefs["userjournals_show_cats"] != 0 && strlen($this->var["userjournals_categories"]) > 0) {
			parse_str($parm, $parms);
			if (array_key_exists("label", $parms)) {
				$text .= UJ91.": ";
			}
			$userjournals_categories = explode(",", $this->var["userjournals_categories"]);
			for ($i=0; $i<count($userjournals_categories); $i++) {  
				$uj_category = $uj_categories[$userjournals_categories[$i]];
				$this->var['uj_category'] = $uj_category;
		  
				$text .=  $this->sc_uj_category_link();

				if ($i<count($userjournals_categories)-1) {
					$text .= ", ";
				}
			}
		}
		return $text;
 
	}

	public function sc_UJ_BLOG_NOW_PLAYING($parm = '')
	{

		$text = "";
		if (!$limit && strlen($this->var["userjournals_playing"]) > 0)
		{
			parse_str($parm, $parms);
			if (array_key_exists("label", $parms))
			{
				$text .= UJ41 . " ";
			}
			$text .= $this->var["userjournals_playing"];
		}
		return $text;
	}

	public function sc_UJ_BLOG_EDIT_LINK($parm = '')
	{
		$blog_id = $this->var["userjournals_id"];
		$text = "";
		if ($this->var["userjournals_userid"] == USERID  )
		{
			$text .= "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?edit." . $blog_id . "'>" . UJ4 . "</a>";
		}
		return $text;
	}

	public function sc_UJ_BLOG_ADMIN_LINK($parm = '')
	{
		$blog_id = $this->var["userjournals_id"];
		if(getperms('0')) 
		{
			$text .= "<a href='" . e_PLUGIN_ABS . "userjournals/admin/admin_config.php?mode=main&action=edit&id=" . $blog_id . "'> Admin</a>";
		}
		return $text;
	}

	public function sc_UJ_BLOG_DELETE_LINK($parm = '')
	{

		$text = "";
		if ($this->var["userjournals_userid"] == USERID || ADMIN)
		{
			$text .= "<a href='#' onclick='UJConfirmDelete(\"" . UJ60 . "\", \"" . e_PLUGIN_ABS . "userjournals/userjournals.php?delete." . $this->var["userjournals_id"] . "\");'>" . UJ19 . "</a>";
		}
		return $text;
	}

	public function sc_UJ_BLOG_REPORT_LINK($parm = '')
	{

		$text = "";
		if (USERID && e107::pref('userjournals', 'userjournals_report_blog'))
		{
			$text .= "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?report." . $this->var["userjournals_id"] . "'>" . UJ101 . "</a>";
		}
		return $text;
	}

	public function sc_UJ_BLOG_BLOGGER_LINK($parm = '')
	{

		//$user = getx_user_data($this->var["userjournals_userid"]);
		$user = e107::user($this->var["userjournals_userid"]);
		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?blogger." . $this->var["userjournals_userid"] . "'>" . $user["user_name"] . " " . UJ1 . "</a>";
	}

	public function sc_UJ_BLOG_ENTRY($parm = '')
	{

		$text = e107::getParser()->toHTML($this->var["userjournals_entry"], TRUE, 'DESCRIPTION');
		return $text;
	}

	public function sc_UJ_BLOG_ENTRY_SHORT($parm = '')
	{

		$text = e107::getParser()->toHTML($this->var["userjournals_entry"], TRUE, 'DESCRIPTION');
		$limit = e107::pref('userjournals', 'userjournals_len_preview');
		$text = e107::getParser()->html_truncate($text, $limit, "...");
		return $text;
	}

	public function sc_UJ_BLOG_RATINGS($parm = '')
	{

		$text = "";
		if (check_class(e107::pref('userjournals', 'userjournals_allowratings')))
		{
			$frm = e107::getForm();
			$options = array('label' => ' ', 'template' => 'RATE|VOTES|STATUS');
			$text .= $frm->rate("userjourna", $this->var["userjournals_id"], $options);
		}
		return $text;
	}

	public function sc_UJ_BLOG_COMMENTS($parm = '')
	{

		$text = "";
 
		if (check_class($this->plugPrefs["userjournals_allowcomments"]))
		{
			$title = e107::getParser()->post_toHTML($this->var["userjournals_subject"], true); //has to be unique todo fix this
			//function compose_comment($table, $action, $id, $width, $subject, $rate = FALSE, $return = FALSE, $tablerender = TRUE)
			$text .= e107::getComment()->compose_comment('userjourna', 'comment', $this->var["userjournals_id"], null, $title, false, 'html');
		}
		return $text;
	}

	public function sc_UJ_BLOG_COMMENTS_TOTAL($parm = '')
	{

		$text = "";
 
		parse_str($parm, $parms);
		if (array_key_exists("label", $parms))
		{
			$text .= UJ30 . " ";
		}
		if (check_class($this->plugPrefs["userjournals_allowcomments"]))
		{
			$text .= e107::getComment()->count_comments('userjourna', $this->var["userjournals_id"]);
		}
		return $text;
	}

	public function sc_UJ_CATEGORY_LIST($parm = '')
	{
		 
		return $this->var['uj_categories'];
	}

	public function sc_UJ_CATEGORY_LIST_HEADING($parm = '')
	{
		return UJ98;
	}

	public function sc_uj_category_link($parm = '')
	{
		$uj_category = $this->var['uj_category']; 
 
		$text =  "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?cat." . $uj_category["userjournals_cat_id"] . "'>" . $uj_category["userjournals_cat_name"] . "</a>";
		
		return $text;
	}

	public function sc_UJ_CATEGORY_MENU_LINK($parm = '')
	{
		 
		global $uj_category;
		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?cat." . $uj_category["userjournals_cat_id"] . "'>" . $uj_category["userjournals_cat_name"] . "</a>";
	}

	public function sc_UJ_CATEGORY_START($parm = '')
	{
		return " ";
	}

	public function sc_UJ_CATEGORY_END($parm = '')
	{
		return " ";
	}

	public function sc_UJ_CATEGORY_ICON($parm = '')
	{
		global $uj_category;
		$text = "";
		if (strlen($uj_category["userjournals_cat_icon"]) > 0 && file_exists(e_IMAGE . $uj_category["userjournals_cat_icon"]))
		{
			$text .= "<img src='" . e_IMAGE . $uj_category["userjournals_cat_icon"] . "'> ";
		}
		return $text;
	}

	public function sc_UJ_MENU_READER($parm = '')
	{
		global $userjournals_shortcodes, $UJ_BLOGGER_LIST;
		$text = "";
 
		if (check_class($this->plugPrefs["userjournals_readers"]) || check_class($this->plugPrefs["userjournals_writers"]))
		{
			$text .= "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?allblogs'>" . UJ61 . "</a><br/>";
			$text .= "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php'>" . UJ50 . "</a><br/>";
			if ($this->plugPrefs["userjournals_show_cats"] == 1)
			{
				$text .= "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?allcats'>" . UJ92 . "</a><br/>";
			}
		}
		return $text;
	}

	public function sc_UJ_MENU_READER_CATEGORIES($parm = '')
	{
		global  $uj_category,  $UJ_BLOGGER_LIST;
		$text = "";
	 
		if (check_class($this->plugPrefs["userjournals_readers"]) || check_class($this->plugPrefs["userjournals_writers"]))
		{
			if ($this->plugPrefs["userjournals_show_cats"] == 1)
			{
				$keys = array_keys($this->cats);
				foreach ($keys as $key)
				{
					$uj_category = $this->cats[$key];
					$text .= e107::getParser()->parseTemplate("{UJ_CATEGORY_MENU_LINK}", FALSE, $this->sc);
				}
			}
		}
		return $text;
	}

	public function sc_UJ_MENU_READER_BLOGGERS($parm = '')
	{
		global $userjournals_shortcodes;

		$text = "";
 
		if (check_class($this->plugPrefs["userjournals_readers"]) || check_class($this->plugPrefs["userjournals_writers"]))
		{
			$limit = "";
			if (isset($this->plugPrefs["userjournals_bloggers_menu_max"]) && $this->plugPrefs["userjournals_bloggers_menu_max"] > 0)
			{
				$limit = "limit " . $this->plugPrefs["userjournals_bloggers_menu_max"];
			}
			$results = e107::getDb()->retrieve("userjournals", "distinct(userjournals_userid) as id, max(userjournals_timestamp) as ts", "userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=0 group by id order by ts desc $limit", true);
			if ($results)
			{
				foreach ($results AS $row)
				{
					$text .= e107::getParser()->parseTemplate("{UJ_BLOGGER_MENU_LINK}", FALSE, $this-sc);
				}
			}
			else
			{
				$text .= " " . UJ28;
			}
		}
		return $text;
	}

	public function sc_UJ_RSS($parm = '')
	{
		global $userjournals_shortcodes;
		$text = "";
		if (e107::pref('userjournals', 'userjournals_show_rss') == 1)
		{
			$text .= e107::getParser()->parseTemplate("{UJ_RSS_1}", FALSE, $userjournals_shortcodes);
			$text .= e107::getParser()->parseTemplate("{UJ_RSS_2}", FALSE, $userjournals_shortcodes);
			$text .= e107::getParser()->parseTemplate("{UJ_RSS_3}", FALSE, $userjournals_shortcodes);
		}
		return $text;
	}

	public function sc_UJ_RSS_1($parm = '')
	{
		return "<a href='" . e_PLUGIN_ABS . "rss_menu/rss.php?userjournals.1'><img src='" . e_PLUGIN_ABS . "rss_menu/images/rss1.png' alt='rss1'/></a>";
	}

	public function sc_UJ_RSS_2($parm = '')
	{
		return "<a href='" . e_PLUGIN_ABS . "rss_menu/rss.php?userjournals.2'><img src='" . e_PLUGIN_ABS . "rss_menu/images/rss2.png' alt='rss2'/></a>";
	}

	public function sc_UJ_RSS_3($parm = '')
	{
		return "<a href='" . e_PLUGIN_ABS . "rss_menu/rss.php?userjournals.3'><img src='" . e_PLUGIN_ABS . "rss_menu/images/rss3.png' alt='rdf'/></a>";
	}

	public function sc_UJ_MENU_WRITER_OPTIONS($parm = '')
	{
		global $userjournals_shortcodes;
		$text = "";
 
		if (check_class($this->plugPrefs["userjournals_writers"]))
		{
			$text .= "&bull;<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?blogger." . USERID . "'>" . UJ11 . "</a><br/>";
			$text .= "&bull;<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?add'>" . UJ10 . "</a><br/>";
			$text .= "&bull;<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?synopsis'>" . UJ52 . "</a><br/>";
		}
		return $text;
	}

	public function sc_UJ_MENU_WRITER_RECENT($parm = '')
	{
		global $userjournals_shortcodes;

		$text = "";
 
		$limit = $this->plugPrefs["userjournals_recent_entries"];
		$results = e107::getDb()->retrieve("userjournals", "*", "userjournals_userid='" . USERID . "' AND userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=0 ORDER BY userjournals_timestamp DESC LIMIT " . $limit, true);
		if ($results)
		{
			foreach ($results AS $row)
			{
				extract($row);
				if (strlen($userjournals_subject) > $this->plugPrefs["userjournals_len_subject"])
				{
					$userjournals_subject = substr($userjournals_subject, 0, $this->plugPrefs["userjournals_len_subject"]) . " ...";
				}
				$text .= "&bull;<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?blog.$userjournals_id'>$userjournals_subject</a><br/>";
				$text .= "<div style='padding-left:8px;'>" . e107::getDate()->convert_date($userjournals_timestamp, "short") . "</div>";
			}
		}
		else
		{
			$text .= UJ28 . "<br/>";
		}
		return $text;
	}

	public function sc_UJ_MENU_WRITER_UNPUBLISHED($parm = '')
	{
		global $userjournals_shortcodes;
 

		$text = "";
		$limit = $this->plugPrefs["userjournals_recent_entries"];

		$results = e107::getDb()->retrieve("userjournals", "*", "userjournals_userid='" . USERID . "' AND userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=1 ORDER BY userjournals_timestamp DESC LIMIT " . $limi, true);

		if ($results)
		{
			foreach ($results AS $row)
			{
				extract($row);
				if (strlen($userjournals_subject) > $this->plugPrefs["userjournals_len_subject"])
				{
					$userjournals_subject = substr($userjournals_subject, 0, $this->plugPrefs["userjournals_len_subject"]) . " ...";
				}
				$text .= "&bull;<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?edit.$userjournals_id'>$userjournals_subject</a><br/>";
				$text .= "<div style='padding-left:8px;'>" . e107::getDate()->convert_date($userjournals_timestamp, "short") . "</div>";
			}
		}
		else
		{
			$text .= UJ67;
		}
		return $text;
	}

	public function sc_UJ_MESSAGE($parm = '')
	{
		global $uj_message;
		return $uj_message;
	}

	public function sc_UJ_MESSAGE_EXTRA($parm = '')
	{
		global $uj_message2;
		$text = "";
		if ($uj_message2 !== false)
		{
			$text = $uj_message2;
		}
		$uj_message2 = "";
		return $text;
	}

	/* 
		* @return string 
		* @example {JOURNAL_DIRECTORY}
	*/
	public function sc_journal_directory($parm = '')
	{
		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php'>" . _JOURNALDIR . "</a>";
	}

	/* 
		 * @return string 
		 * @example {YOURJOURNAL}
	*/
	public function sc_yourjournal($parm = '')
	{
		/*  scenario: 
			 1. you are user and you have permission to write
			 2. you are user but you don't have permission to write
			 3. you are not user 
		*/
		if (USERID)
		{
			if (check_class($this->plugPrefs["userjournals_writers"]))
			{
			$text = "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?blogger." . USERID . "'>" . _YOURJOURNAL . "</a>";  
			$text .= "| <a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?add'>" . UJ10 . "</a>";
			$text .= "| <a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?synopsis'>" . UJ52 . "</a>";
            
                 
			}
		}
		else
		{
			$text = "<a href='" . e_SIGNUP . "'>" . _CREATEACCOUNT . "</a>";
		}
		return $text;
	}

	/* do you dislike this? remove this shortcode in theme template */
	/* {MEMBERSCAN} */

	public function sc_memberscan()
	{
		if (USERID)
		{

		}
		else
		{
			if ($this->plugPrefs["userjournals_writers"] = "253")
			{
				return _MEMBERSCAN;
			}
		}
	}

	public function sc_LISTALLJOURNALS()
	{
		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?allblogs'>" . _LISTALLJOURNALS . "</a>";
	}
	public function sc_LISTALLCATEGORIES()
	{
		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?allcats'>" . UJ92 . "</a>";
	}
	public function sc_LISTALLBLOGGERS()
	{
		return "<a href='" . e_PLUGIN_ABS . "userjournals/userjournals.php?bloggers'>" . UJ50 . "</a>";
	}
}