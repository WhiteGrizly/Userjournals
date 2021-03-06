<?php
	if (!e107::getDb()->select("plugin", "*", "plugin_path='userjournals' AND plugin_installflag='1'")) {
	   // Plugin not installed
		return;
	}
 
	$LIST_CAPTION        = $arr[0];
	$LIST_DISPLAYSTYLE   = ($arr[2] ? "" : "none");

	$bullet = $this->getBullet($arr[6], $mode);

	if ($mode == "new_page" || $mode == "new_menu" ) {
	   $qry = "and userjournals_timestamp > ".$this->getlvisit();
	} else {
      $qry = "";
   }

   $qry = "select * from ".MPREFIX."userjournals
           where userjournals_is_blog_desc=0
             and userjournals_is_published=0
             $qry
	        order by userjournals_timestamp desc limit 0,".$arr[7]."
   ";

    e107::plugLan("userjournals" , "admin/".e_LANGUAGE, false);
    e107::plugLan("userjournals" , e_LANGUAGE, false);
    
    $results = e107::getDb()->retrieve($qry, true);

	if (!$results) {
		$LIST_DATA = UJ44;
	} else {
		foreach($results AS $row) {
			$rowheading	         = $this->parse_heading($row['userjournals_subject'], $mode);
			$ICON		            = $bullet;
			$HEADING	            = "<a href='".e_PLUGIN_ABS."userjournals/userjournals.php?blog.".$row['userjournals_id']."' title='".$row['userjournals_subject']."'>".$rowheading."</a>";
			//$user                = getx_user_data($row['userjournals_userid']);
			$user                = e107::user(row['userjournals_userid']);
			$AUTHOR	            = "<a href='".e_PLUGIN_ABS."userjournals/userjournals.php?blogger.".$row['userjournals_userid'].".".$row["userjournals_username"]."' title='".$row['userjournals_username']."'>".$user["user_name"]."</a>";
			$CATEGORY	         = "";
			$DATE		            = ($arr[5] ? ($row['userjournals_timestamp'] > 0 ? $this->getListDate($row['userjournals_timestamp'], $mode) : "") : "");
			$INFO		            = ""; //$row['description'];
			$LIST_DATA[$mode][]  = array($ICON, $HEADING, $AUTHOR, $CATEGORY, $DATE, $INFO);
		}
	}
?>