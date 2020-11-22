<?php
if (!defined('e107_INIT')) { exit; }
include_once(e_HANDLER.'shortcode_handler.php');
if (!isset($tp)) {
   $tp = new e_parse();
   $tp->e_sc = new e_shortcode();
}
global $userjournals_shortcodes;
$userjournals_shortcodes = $tp->e_sc->parse_scbatch(__FILE__);

$plugPrefs = e107::getPlugPref('userjournals_menu');
/*

// ---------------------------------------------------------------------------------------------------------------------------------------------------
 

SC_BEGIN USER_LEVEL
global $user, $pref;
require_once(e_HANDLER."level_handler.php");
$ldata = get_level($user['user_id'], $user['user_forums'], $user['user_comments'], $user['user_chats'], $user['user_visits'], $user['user_join'], $user['user_admin'], $user['user_perms'], $pref);

if (strstr($ldata[0], "IMAGE_rank_main_admin_image")) {
	return LAN_417;
}
else if(strstr($ldata[0], "IMAGE")) {
	return LAN_418;
}
else
{
	return $USER_LEVEL = $ldata[1];
}
SC_END

SC_BEGIN USER_LASTVISIT
global $user;
$gen = new convert;
return $user['user_currentvisit'] ? $gen->convert_date($user['user_currentvisit'], "long") : "<i>".LAN_401."</i>";
SC_END

SC_BEGIN USER_LASTVISIT_LAPSE
global $user;
$gen = new convert;
return $user['user_currentvisit'] ? "( ".$gen -> computeLapse($user['user_currentvisit'])." ".LAN_426." )" : '';
SC_END

SC_BEGIN USER_VISITS
global $user;
return $user['user_visits'];
SC_END

SC_BEGIN USER_JOIN
global $user;
$gen = new convert;
return $gen->convert_date($user['user_join'], "forum");
SC_END

SC_BEGIN USER_DAYSREGGED
global $user;
$gen = new convert;
return $gen -> computeLapse($user['user_join'])." ".LAN_426;
SC_END

SC_BEGIN USER_REALNAME_ICON
if(defined("USER_REALNAME_ICON"))
{
	return USER_REALNAME_ICON;
}
if(file_exists(THEME."images/user_realname.png"))
{
	return "<img src='".THEME_ABS."images/user_realname.png' alt='' style='border:0px;vertical-align:middle;' /> ";
}
return "<img src='".e_IMAGE_ABS."user_icons/user_realname_".IMODE.".png' alt='' style='border:0px;vertical-align:middle;' /> ";
SC_END

SC_BEGIN USER_REALNAME
global $user;
return $user['user_login'] ? $user['user_login'] : "<i>".LAN_401."</i>";
SC_END

SC_BEGIN USER_EMAIL_ICON
if(defined("USER_EMAIL_ICON"))
{
	return USER_EMAIL_ICON;
}
if(file_exists(THEME."images/email.png"))
{
	return "<img src='".THEME_ABS."images/email.png' alt='' style='vertical-align:middle;' /> ";
}
return "<img src='".e_IMAGE_ABS."generic/".IMODE."/email.png' alt='' style='vertical-align:middle;' /> ";
SC_END

SC_BEGIN USER_EMAIL_LINK
global $user, $tp;
return ($user['user_hideemail'] && !ADMIN) ? "<i>".LAN_143."</i>" : $tp->parseTemplate("{email={$user['user_email']}-link}");
SC_END

SC_BEGIN USER_EMAIL
global $user,$tp;
return ($user['user_hideemail'] && !ADMIN) ? "<i>".LAN_143."</i>" : $tp->toHTML($user['user_email'],FALSE,"no_replace");
SC_END

SC_BEGIN USER_ICON
if(defined("USER_ICON"))
{
	return USER_ICON;
}
if(file_exists(THEME."images/user.png"))
{
	return "<img src='".THEME_ABS."images/user.png' alt='' style='border:0px;vertical-align:middle;' /> ";
}
return "<img src='".e_IMAGE_ABS."user_icons/user_".IMODE.".png' alt='' style='border:0px;vertical-align:middle;' /> ";
SC_END

SC_BEGIN USER_ICON_LINK
global $user;
if(defined("USER_ICON"))
{
	$icon = USER_ICON;
}
else if(file_exists(THEME."images/user.png"))
{
	$icon = "<img src='".THEME_ABS."images/user.png' alt='' style='border:0px;vertical-align:middle;' /> ";
}
else
{
	$icon = "<img src='".e_IMAGE_ABS."user_icons/user_".IMODE.".png' alt='' style='border:0px;vertical-align:middle;' /> ";
}
return "<a href='".e_SELF."?id.{$user['user_id']}'>{$icon}</a>";
SC_END

SC_BEGIN USER_ID
global $user;
return $user['user_id'];
SC_END

SC_BEGIN USER_IP
global $user;
if(ADMIN)
{
	return $user['user_ip'];
}
SC_END 


SC_BEGIN USER_NAME
global $user;
return $user['user_name'];
SC_END

SC_BEGIN USER_NAME_LINK
global $user;
return "<a href='".e_SELF."?id.{$user['user_id']}'>".$user['user_name']."</a>";
SC_END

SC_BEGIN USER_LOGINNAME
global $user;
if(ADMIN && getperms("4")) {
	return $user['user_loginname'];
}
SC_END

SC_BEGIN USER_BIRTHDAY_ICON
if(defined("USER_BIRTHDAY_ICON"))
{
	return USER_BIRTHDAY_ICON;
}
if(file_exists(THEME."images/user_birthday.png"))
{
	return "<img src='".THEME_ABS."images/user_birthday.png' alt='' style='vertical-align:middle;' /> ";
}
return "<img src='".e_IMAGE_ABS."user_icons/user_birthday_".IMODE.".png' alt='' style='vertical-align:middle;' /> ";
SC_END

SC_BEGIN USER_BIRTHDAY
global $user;
if ($user['user_birthday'] != "" && $user['user_birthday'] != "0000-00-00" && preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $user['user_birthday'], $regs))
{
	return "$regs[3].$regs[2].$regs[1]";
}
else
{
	return "<i>".LAN_401."</i>";
}
SC_END

SC_BEGIN USER_SIGNATURE
global $tp, $user;
return $user['user_signature'] ? $tp->toHTML($user['user_signature'], TRUE) : "";
SC_END

SC_BEGIN USER_COMMENTS_LINK
global $user;
return $user['user_comments'] ? "<a href='".e_HTTP."userposts.php?0.comments.".$user['user_id']."'>".LAN_423."</a>" : "";
SC_END

SC_BEGIN USER_FORUM_LINK
global $user;
return $user['user_forums'] ? "<a href='".e_HTTP."userposts.php?0.forums.".$user['user_id']."'>".LAN_424."</a>" : "";
SC_END

SC_BEGIN USER_SENDPM
global $pref, $tp, $user;
if(isset($pref['plug_installed']['pm']) && ($user['user_id'] > 0))
{
  return $tp->parseTemplate("{SENDPM={$user['user_id']}}");
}
SC_END

SC_BEGIN USER_RATING
global $pref, $user;
if($pref['profile_rate'] && USER)
{
	include_once(e_HANDLER."rate_class.php");
	$rater = new rater;
	$ret = "<span>";
	if($rating = $rater->getrating('user', $user['user_id']))
	{
		$num = $rating[1];
		for($i=1; $i<= $num; $i++)
		{
			$ret .= "<img src='".e_IMAGE_ABS."user_icons/user_star_".IMODE.".png' style='border:0' alt='' />";
		}
	}
	if(!$rater->checkrated('user', $user['user_id']))
	{
		$ret .= " &nbsp; &nbsp;".$rater->rateselect('', 'user', $user['user_id']);
	}
	$ret .= "</span>";
	return $ret;
}
return "";
SC_END

SC_BEGIN USER_UPDATE_LINK
global $user;
if (USERID == $user['user_id']) {
	return "<a href='".e_HTTP."usersettings.php'>".LAN_411."</a>";
}
else if(ADMIN && getperms("4") && !$user['user_admin']) {
	return "<a href='".e_HTTP."usersettings.php?".$user['user_id']."'>".LAN_412."</a>";
}
SC_END

SC_BEGIN USER_JUMP_LINK
global $sql, $user, $full_perms;
if (!$full_perms) return;
if(!$userjump = getcachedvars('userjump'))
{
//  $sql->db_Select("user", "user_id, user_name", "`user_id` > ".intval($user['user_id'])." AND `user_ban`=0 ORDER BY user_id ASC LIMIT 1 ");
  $sql->db_Select_gen("SELECT user_id, user_name FROM `#user` FORCE INDEX (PRIMARY) WHERE `user_id` > ".intval($user['user_id'])." AND `user_ban`=0 ORDER BY user_id ASC LIMIT 1 ");
  if ($row = $sql->db_Fetch())
  {
	$userjump['next']['id'] = $row['user_id'];
	$userjump['next']['name'] = $row['user_name'];
  }
//  $sql->db_Select("user", "user_id, user_name", "`user_id` < ".intval($user['user_id'])." AND `user_ban`=0 ORDER BY user_id DESC LIMIT 1 ");
  $sql->db_Select_gen("SELECT user_id, user_name FROM `#user` FORCE INDEX (PRIMARY) WHERE `user_id` < ".intval($user['user_id'])." AND `user_ban`=0 ORDER BY user_id DESC LIMIT 1 ");
  if ($row = $sql->db_Fetch())
  {
	$userjump['prev']['id'] = $row['user_id'];
	$userjump['prev']['name'] = $row['user_name'];
  }
  cachevars('userjump', $userjump);
}
if($parm == 'prev')
{
	return $userjump['prev']['id'] ? "&lt;&lt; ".LAN_414." [ <a href='".e_SELF."?id.".$userjump['prev']['id']."'>".$userjump['prev']['name']."</a> ]" : "&nbsp;";
}
else
{
	return $userjump['next']['id'] ? "[ <a href='".e_SELF."?id.".$userjump['next']['id']."'>".$userjump['next']['name']."</a> ] ".LAN_415." &gt;&gt;" : "&nbsp;";
}
SC_END

SC_BEGIN USER_PICTURE
global $user;
if ($user['user_sess'] && file_exists(e_FILE."public/avatars/".$user['user_sess']))
{
	return "<img src='".e_FILE_ABS."public/avatars/".$user['user_sess']."' alt='' />";
}
else
{
	return LAN_408;
}
SC_END

SC_BEGIN USER_AVATAR
global $user, $tp;
if ($user['user_image'])
{
	return $tp->parseTemplate("{USER_AVATAR=".$user['user_image']."}", true);
}
else
{
	return LAN_408;
}
SC_END


SC_BEGIN USER_PICTURE_NAME
global $user;
if (ADMIN && getperms("4"))
{
	return $user['user_sess'];
}
SC_END

SC_BEGIN USER_PICTURE_DELETE
if (USERID == $user['user_id'] || (ADMIN && getperms("4")))
{
	return "
	<form method='post' action='".e_SELF."?".e_QUERY."'>
	<input class='button' type='submit' name='delp' value='".LAN_413."' />
	</form>
	";
}
SC_END

SC_BEGIN USER_EXTENDED_ALL

global $user, $tp, $sql;
global $EXTENDED_CATEGORY_START, $EXTENDED_CATEGORY_END, $EXTENDED_CATEGORY_TABLE;
$qry = "SELECT f.*, c.user_extended_struct_name AS category_name, c.user_extended_struct_id AS category_id FROM #user_extended_struct as f
	LEFT JOIN #user_extended_struct as c ON f.user_extended_struct_parent = c.user_extended_struct_id
	ORDER BY c.user_extended_struct_order ASC, f.user_extended_struct_order ASC
";



require_once(e_HANDLER."user_extended_class.php");

$ue = new e107_user_extended;
$ueCatList = $ue->user_extended_get_categories();
$ueFieldList = $ue->user_extended_get_fields();
$ueCatList[0][0] = array('user_extended_struct_name' => LAN_410);
$ret = "";
foreach($ueCatList as $catnum => $cat)
{
	$key = $cat[0]['user_extended_struct_name'];
	$cat_name = $tp->parseTemplate("{USER_EXTENDED={$key}.text.{$user['user_id']}}", TRUE);
	if($cat_name != FALSE && count($ueFieldList[$catnum]))
	{

		$ret .= str_replace("{EXTENDED_NAME}", $key, $EXTENDED_CATEGORY_START);
		foreach($ueFieldList[$catnum] as $f)
		{
			$key = $f['user_extended_struct_name'];
			if($ue_name = $tp->parseTemplate("{USER_EXTENDED={$key}.text.{$user['user_id']}}", TRUE))
			{
				$extended_record = str_replace("EXTENDED_ICON","USER_EXTENDED={$key}.icon", $EXTENDED_CATEGORY_TABLE);
			 	$extended_record = str_replace("{EXTENDED_NAME}", $tp->toHTML($ue_name,"","defs"), $extended_record);
				$extended_record = str_replace("EXTENDED_VALUE","USER_EXTENDED={$key}.value.{$user['user_id']}", $extended_record);
				if(HIDE_EMPTY_FIELDS === TRUE)
				{
					$this_value = $tp->parseTemplate("{USER_EXTENDED={$key}.value.{$user['user_id']}}", TRUE);
					if($this_value != "")
					{
						$ret .= $tp->parseTemplate($extended_record, TRUE);
					}
				}
				else
				{
					$ret .= $tp->parseTemplate($extended_record, TRUE);
				}
			}
		}
	}
	$ret .= $EXTENDED_CATEGORY_END;
}
return $ret;
SC_END

SC_BEGIN PROFILE_COMMENTS
global $user, $pref, $sql, $ns;
if($pref['profile_comments'])
{
	include_once(e_HANDLER."comment_class.php");
	$cobj = new comment;
	$qry = "
	SELECT c.*, u.*, ue.* FROM #comments AS c
	LEFT JOIN #user AS u ON c.comment_author = u.user_id
	LEFT JOIN #user_extended AS ue ON c.comment_author = ue.user_extended_id
	WHERE c.comment_item_id='".intval($user['user_id'])."'
	AND c.comment_type='profile'
	AND c.comment_pid='0'
	ORDER BY c.comment_datestamp
	";

	if($comment_total = $sql->db_Select_gen($qry))
	{
		while($row = $sql->db_Fetch())
		{
			$ret .= $cobj->render_comment($row);
		}
	}
	return $ns->tablerender(COMLAN_5, $ret, 'profile_comments', TRUE);
}
return "";
SC_END

SC_BEGIN PROFILE_COMMENT_FORM
global $pref, $user;
if($pref['profile_comments'])
{
	include_once(e_HANDLER."comment_class.php");
	$cobj = new comment;
	$ret = "";
	if(ADMIN === TRUE)
	{
		$ret .= "<a href='".e_BASE.e_ADMIN."modcomment.php?profile.{$user['user_id']}'>".COMLAN_314."</a><br /><br />";
	}
	$ret .= $cobj->form_comment("comment", "profile", $user['user_id'], $user['user_name'], "", TRUE);
	return $ret;
}
SC_END

SC_BEGIN TOTAL_USERS
global $users_total;
return $users_total;
SC_END

SC_BEGIN USER_FORM_RECORDS
global $records, $user_frm;
$ret = $user_frm->form_select_open("records");
for($i=10; $i<=30; $i+=10)
{
	$sel = ($i == $records ? true: false);
	$ret .= $user_frm->form_option($i, $sel, $i);
}
$ret .= $user_frm->form_select_close();
return $ret;
SC_END


SC_BEGIN USER_FORM_ORDER
global $order;
if ($order == "ASC")
{
	$ret = "<select name='order' class='tbox'>
	<option value='DESC'>".LAN_420."</option>
	<option value='ASC' selected='selected'>".LAN_421."</option>
	</select>";
}
else
{
	$ret = "<select name='order' class='tbox'>
	<option value='DESC' selected='selected'>".LAN_420."</option>
	<option value='ASC'>".LAN_421."</option>
	</select>";
}
return $ret;
SC_END


SC_BEGIN USER_FORM_START
global $from;
return "
<form method='post' action='".e_SELF."'>
<input type='hidden' name='from' value='$from' />
";
SC_END

SC_BEGIN USER_FORM_END
return "</form>";
SC_END

SC_BEGIN USER_FORM_SUBMIT
return "<input class='button' type='submit' name='submit' value='".LAN_422."' />";
SC_END

SC_BEGIN UJ_BLOGGER_NAME
   global $uj_blog;
   $text = "";
   //if ($row = getx_user_data($uj_blog["userjournals_userid"])) {
   if ($row = e107::user($uj_blog["userjournals_userid"])) { 
      $text = $row["user_name"];
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOGGER_TIMESTAMP
   global $uj_blog;
   $gen2 = new convert();
   return $gen2->convert_date($uj_blog["userjournals_timestamp"], "long");
SC_END

SC_BEGIN UJ_BLOGGER_LINK
   global $uj_blog;
   return "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?blogger.".$uj_blog["userjournals_userid"]."'>".UJ90."</a>";
SC_END

SC_BEGIN UJ_BLOGGER_MENU_LINK
   global $uj_blog;
   $gen2 = new convert();
   //if ($row = getx_user_data($uj_blog["userjournals_userid"])) {
   if ($row = e107::user($uj_blog["userjournals_userid"])) {
      return "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?blogger.".$uj_blog["userjournals_userid"]."'>".$row["user_name"]."</a><br/>".$gen2->convert_date($uj_blog["userjournals_timestamp"], "short");
   }
   return "";
SC_END

SC_BEGIN UJ_BLOGGER_PICTURE
   global $pref, $tp, $uj_synopsis, $user, $user_shortcodes;
   $text = "";
   if (isset($pref['photo_upload']) && $pref['photo_upload']) {
      //if ($user = getx_user_data($uj_synopsis["userjournals_userid"])) {
      if ($user = e107::user($uj_synopsis["userjournals_userid"])) {
         $text = $tp->parseTemplate("{USER_PICTURE}", TRUE, $user_shortcodes);
         if ($text == "LAN_408") {
            $text = "";
         }
      }
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOGGER_SYNOPSIS
   global $e107Helper, $uj_synopsis;
   return $e107Helper->tp_toHTML($uj_synopsis["userjournals_entry"], true);
SC_END

SC_BEGIN UJ_BLOG_LINK
   global $uj_blog;
   return "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?blog.".$uj_blog["userjournals_id"]."'>".UJ48."</a>";
SC_END

SC_BEGIN UJ_BLOG_MOOD
   global $uj_blog;
   $text = "";
   if (strlen($uj_blog["userjournals_mood"]) > 0) {
      $text = "<img src='".e_PLUGIN."userjournals_menu/images/".$uj_blog["userjournals_mood"].".gif' alt='*'/>";
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_SUBJECT
   global $uj_blog;
   return $uj_blog["userjournals_subject"];
SC_END

SC_BEGIN UJ_BLOG_DATE
   global $uj_blog;
   $gen2 = new convert();
   $text = "";
   parse_str($parm, $parms);
   if (array_key_exists("label", $parms)) {
      $text .= UJ46;
   }
   $text .= $gen2->convert_date($uj_blog["userjournals_timestamp"], "short");
   return $text;
SC_END

SC_BEGIN UJ_BLOG_CATEGORIES
   global $plugPrefs, $tp, $uj_blog, $uj_categories, $uj_category, $userJournals;
   $text = "";
   if ($plugPrefs["userjournals_show_cats"] != 0 && strlen($uj_blog["userjournals_categories"]) > 0) {
      parse_str($parm, $parms);
      if (array_key_exists("label", $parms)) {
         $text .= UJ91.": ";
      }
      $userjournals_categories = explode(",", $uj_blog["userjournals_categories"]);
      for ($i=0; $i<count($userjournals_categories); $i++) {
         $uj_category = $uj_categories[$userjournals_categories[$i]];
         $text .= $tp->parseTemplate("{UJ_CATEGORY_LINK}", FALSE, $userjournals_shortcodes);

         if ($i<count($userjournals_categories)-1) {
            $text .= ", ";
         }
      }
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_NOW_PLAYING
   global $uj_blog;
   $text = "";
   if (!$limit && strlen($uj_blog["userjournals_playing"]) > 0) {
      parse_str($parm, $parms);
      if (array_key_exists("label", $parms)) {
         $text .= UJ41." ";
      }
      $text .= $uj_blog["userjournals_playing"];
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_EDIT_LINK
   global $uj_blog;
   $text = "";
   if ($uj_blog["userjournals_userid"] == USERID) {
      $text .= "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?edit.".$uj_blog["userjournals_id"]."'>".UJ4."</a>";
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_DELETE_LINK
   global $uj_blog;
   $text = "";
   if ($uj_blog["userjournals_userid"] == USERID || ADMIN) {
      $text .= "<a href='#' onclick='e107Helper.confirmDelete(\"".UJ60."\", \"".e_PLUGIN."userjournals_menu/userjournals.php?delete.".$uj_blog["userjournals_id"]."\");'>".UJ19."</a>";
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_REPORT_LINK
   global $uj_blog, $plugPrefs;
   $text = "";
   if (USERID && $plugPrefs['userjournals_report_blog']) {
      $text .= "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?report.".$uj_blog["userjournals_id"]."'>".UJ101."</a>";
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_BLOGGER_LINK
   global $uj_blog;
   //$user = getx_user_data($uj_blog["userjournals_userid"]);
   $user = e107::user($uj_blog["userjournals_userid"]);
   return "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?blogger.".$uj_blog["userjournals_userid"]."'>".$user["user_name"]." ".UJ1."</a>";
SC_END

SC_BEGIN UJ_BLOG_ENTRY
   global $e107Helper, $uj_blog;
   $text = $e107Helper->tp_toHTML($uj_blog["userjournals_entry"], true);
   return $text;
SC_END

SC_BEGIN UJ_BLOG_ENTRY_SHORT
   global $e107Helper, $pref, $tp, $uj_blog;
   $text = $e107Helper->tp_toHTML($uj_blog["userjournals_entry"], true);
   // use this when e107 helkpers 0.7+ released $userjournals_entry = $e107Helper->tp_toHTML($userjournals_entry, true, $limit, "");
   $text = $tp->html_truncate($text, $plugPrefs["userjournals_len_preview"], "...");
   return $text;
SC_END

SC_BEGIN UJ_BLOG_RATINGS
   global $e107Helper, $plugPrefs, $uj_blog;
   $text = "";
   if (check_class($plugPrefs["userjournals_allowratings"])) {
      $text .= $e107Helper->getRating2("userjourna", $uj_blog["userjournals_id"]);
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_COMMENTS
   global $e107Helper, $plugPrefs, $uj_blog;
   $text = "";
   if (check_class($plugPrefs["userjournals_allowcomments"])) {
      $text .= $e107Helper->getComment("userjourna", $uj_blog["userjournals_id"]);
   }
   return $text;
SC_END

SC_BEGIN UJ_BLOG_COMMENTS_TOTAL
   global $e107Helper, $plugPrefs, $uj_blog;
   $text = "";
   parse_str($parm, $parms);
   if (array_key_exists("label", $parms)) {
      $text .= UJ30." ";
   }
   if (check_class($plugPrefs["userjournals_allowcomments"])) {
      $text .= $e107Helper->getCommentTotal("userjourna", $uj_blog["userjournals_id"]);
   }
   return $text;
SC_END

SC_BEGIN UJ_CATEGORY_LIST
   global $uj_categories;
   return $uj_categories;
SC_END

SC_BEGIN UJ_CATEGORY_LIST_HEADING
   return UJ98;
SC_END

SC_BEGIN UJ_CATEGORY_LINK
   global $uj_category;
   return "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?cat.".$uj_category["userjournals_cat_id"]."'>".$uj_category["userjournals_cat_name"]."</a>";
SC_END

SC_BEGIN UJ_CATEGORY_MENU_LINK
   global $uj_category;
   return "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?cat.".$uj_category["userjournals_cat_id"]."'>".$uj_category["userjournals_cat_name"]."</a>";
SC_END

SC_BEGIN UJ_CATEGORY_START
   return " ";
SC_END

SC_BEGIN UJ_CATEGORY_END
   return " ";
SC_END

SC_BEGIN UJ_CATEGORY_ICON
   global $uj_category;
   $text = "";
   if (strlen($uj_category["userjournals_cat_icon"]) > 0 && file_exists(e_IMAGE.$uj_category["userjournals_cat_icon"])) {
      $text .= "<img src='".e_IMAGE.$uj_category["userjournals_cat_icon"]."'> ";
   }
   return $text;
SC_END

SC_BEGIN UJ_MENU_READER
   global $plugPrefs, $sql, $tp, $uj_blog, $userjournals_shortcodes, $UJ_BLOGGER_LIST;
   $text = "";
   if (check_class($plugPrefs["userjournals_readers"]) || check_class($plugPrefs["userjournals_writers"])) {
      $text .= "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?allblogs'>".UJ61."</a><br/>";
      $text .= "<a href='".e_PLUGIN."userjournals_menu/userjournals.php'>".UJ50."</a><br/>";
      if ($plugPrefs["userjournals_show_cats"] == 1) {
         $text .= "<a href='".e_PLUGIN."userjournals_menu/userjournals.php?allcats'>".UJ92."</a><br/>";
      }
   }
   return $text;
SC_END

SC_BEGIN UJ_MENU_READER_CATEGORIES
   global $plugPrefs, $sql, $tp, $uj_categories, $uj_category, $uj_blog, $userjournals_shortcodes, $UJ_BLOGGER_LIST;
   $text = "";
   if (check_class($plugPrefs["userjournals_readers"]) || check_class($plugPrefs["userjournals_writers"])) {
      if ($plugPrefs["userjournals_show_cats"] == 1) {
         $keys = array_keys($uj_categories);
         foreach ($keys as $key) {
            $uj_category = $uj_categories[$key];
            $text .= $tp->parseTemplate("{UJ_CATEGORY_MENU_LINK}", FALSE, $userjournals_shortcodes);
         }
      }
   }
   return $text;
SC_END

SC_BEGIN UJ_MENU_READER_BLOGGERS
   global $plugPrefs, $tp, $uj_blog, $userjournals_shortcodes;
   $sql2 = new db();
   $text = "";
   if (check_class($plugPrefs["userjournals_readers"]) || check_class($plugPrefs["userjournals_writers"])) {
      $limit = "";
      if (isset($plugPrefs["userjournals_bloggers_menu_max"]) && $plugPrefs["userjournals_bloggers_menu_max"] > 0) {
         $limit = "limit ".$plugPrefs["userjournals_bloggers_menu_max"];
      }
      if ($count = $sql2->db_Select("userjournals", "distinct(userjournals_userid) as id, max(userjournals_timestamp) as ts", "userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=0 group by id order by ts desc $limit")){
         while($uj_blog = $sql2->db_Fetch()) {
            $text .= $tp->parseTemplate("{UJ_BLOGGER_MENU_LINK}", FALSE, $userjournals_shortcodes);
         }
      } else {
         $text .= UJ28;
      }
   }
   return $text;
SC_END

SC_BEGIN UJ_RSS
   global $plugPrefs, $tp, $userjournals_shortcodes;
   $text = "";
   if ($plugPrefs["userjournals_show_rss"] == 1) {
      $text .= $tp->parseTemplate("{UJ_RSS_1}", FALSE, $userjournals_shortcodes);
      $text .= $tp->parseTemplate("{UJ_RSS_2}", FALSE, $userjournals_shortcodes);
      $text .= $tp->parseTemplate("{UJ_RSS_3}", FALSE, $userjournals_shortcodes);
   }
   return $text;
SC_END

SC_BEGIN UJ_RSS_1
   return "<a href='".e_PLUGIN."rss_menu/rss.php?userjournals.1'><img src='".e_PLUGIN."rss_menu/images/rss1.png' alt='rss1'/></a>";
SC_END

SC_BEGIN UJ_RSS_2
   return "<a href='".e_PLUGIN."rss_menu/rss.php?userjournals.2'><img src='".e_PLUGIN."rss_menu/images/rss2.png' alt='rss2'/></a>";
SC_END

SC_BEGIN UJ_RSS_3
   return "<a href='".e_PLUGIN."rss_menu/rss.php?userjournals.3'><img src='".e_PLUGIN."rss_menu/images/rss3.png' alt='rdf'/></a>";
SC_END

SC_BEGIN UJ_MENU_WRITER_OPTIONS
   global $plugPrefs, $sql, $tp, $uj_blog, $userjournals_shortcodes;
   $text = "";
   if (check_class($plugPrefs["userjournals_writers"])) {
      $text .= "&bull;<a href='".e_PLUGIN."userjournals_menu/userjournals.php?blogger.".USERID."'>".UJ11."</a><br/>";
      $text .= "&bull;<a href='".e_PLUGIN."userjournals_menu/userjournals.php?add'>".UJ10."</a><br/>";
      $text .= "&bull;<a href='".e_PLUGIN."userjournals_menu/userjournals.php?synopsis'>".UJ52."</a><br/>";
   }
   return $text;
SC_END

SC_BEGIN UJ_MENU_WRITER_RECENT
   global $plugPrefs, $sql, $tp, $uj_blog, $userjournals_shortcodes;
   $gen2 = new convert;
   $text ="";
   if ($sql->db_Select("userjournals", "*", "userjournals_userid='".USERID."' AND userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=0 ORDER BY userjournals_timestamp DESC LIMIT ".$plugPrefs["userjournals_recent_entries"])){
      while($row = $sql->db_Fetch()){
         extract($row);
         if (strlen($userjournals_subject) > $plugPrefs["userjournals_len_subject"]){
            $userjournals_subject = substr($userjournals_subject,0,$plugPrefs["userjournals_len_subject"])." ...";
         }                                                                                                                                                   
         $text .= "&bull;<a href='".e_PLUGIN."userjournals_menu/userjournals.php?blog.$userjournals_id'>$userjournals_subject</a><br/>";
         $text .= "<div style='padding-left:8px;'>".$gen2->convert_date($userjournals_timestamp, "short")."</div>";
      }
   } else {
      $text .= UJ28."<br/>";
   }
   return $text;
SC_END


SC_BEGIN UJ_MENU_WRITER_UNPUBLISHED
   global $plugPrefs, $sql, $tp, $uj_blog, $userjournals_shortcodes;
   $gen2 = new convert;
   $text ="";
   if ($sql->db_Select("userjournals", "*", "userjournals_userid='".USERID."' AND userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=1 ORDER BY userjournals_timestamp DESC LIMIT ".$plugPrefs["userjournals_recent_entries"])){
      while($row = $sql->db_Fetch()){
         extract($row);
         if (strlen($userjournals_subject) > $plugPrefs["userjournals_len_subject"]){
            $userjournals_subject = substr($userjournals_subject,0,$plugPrefs["userjournals_len_subject"])." ...";
         }
         $text .= "&bull;<a href='".e_PLUGIN."userjournals_menu/userjournals.php?edit.$userjournals_id'>$userjournals_subject</a><br/>";
         $text .= "<div style='padding-left:8px;'>".$gen2->convert_date($userjournals_timestamp, "short")."</div>";
      }
   } else {
      $text .= UJ67;
   }
   return $text;
SC_END

SC_BEGIN UJ_MESSAGE
   global $uj_message;
   return $uj_message;
SC_END

SC_BEGIN UJ_MESSAGE_EXTRA
   global $uj_message2;
   $text = "";
   if ($uj_message2 !== false) {
      $text = $uj_message2;
   }
   $uj_message2 = "";
   return $text;
SC_END

*/
?>
