<?php

 
if (!class_exists("UserJournals")) {
   e107::plugLan("userjournals_menu" , "admin/".e_LANGUAGE, false);
   e107::plugLan("userjournals_menu" , e_LANGUAGE, false);

   require_once(e_PLUGIN."userjournals_menu/userjournals_shortcodes.php");
    
   global $pref;
 
   class UserJournals {

      var $cats;
      var $mood;
	  var $user;
	  var $editor;

      function __construct($mainpage=false) {
		 global $sql, $ns;
		 $this->editor =  "bbcode";
         $this->mood = array(
            //''           => UJ68,
            'happy'      => UJ69,
            'sad'        => UJ70,
            'alienated'  => UJ71,
            'beat_up'    => UJ72,
            'angry'      => UJ73,
            'annoyed'    => UJ74,
            'chicken'    => UJ75,
            'confused'   => UJ76,
            'crying'     => UJ77,
            'doh'        => UJ78,
            'evil'       => UJ79,
            'funny'      => UJ80,
            'greedy'     => UJ81,
            'hungry'     => UJ82,
            'puzzled'    => UJ83,
            'innocent'   => UJ84,
            'shocked'    => UJ85,
            'sick'       => UJ86,
            'sleepy'     => UJ87,
            'very_happy' => UJ88,
         );
		 
		 $this->setMode($mainpage);
		 
		 $this->user = false;

         // Get all categories - we need these all ove rthe place
		 $result = e107::getDb()->retrieve("userjournals_categories", "*", "ORDER BY userjournals_cat_name ASC", true);
 
         foreach($result AS $row) {
            $this->cats[$row["userjournals_cat_id"]] = $row;
		 }
		 
		 $plugPrefs = e107::getPlugPref('userjournals_menu');

		 $template_file =  e107::getParser()->replaceConstants($plugPrefs["userjournals_template"]);
   
		 if (file_exists($template_file)) {   
			require_once($template_file);
		 } else {
			require_once(e_PLUGIN."userjournals_menu/templates/default.php");
		 }
	}

	function init($mode = true) {
		$this->setMode($mode);

	}

	private function getMode()
    {
        return vartrue($this->get['mode']);
	}
 
    private function setMode($mode)
    {
        $this->get['mode'] = $mode;
	}
 
	/**
     * Render the userjournals pages
     *
     * @return string
     */
    public function render()
    {
		$mainpage = $this->getMode();  
		$ns = e107::getRender();
         // Only process URL parameters if this is a main page (i.e. not a menu)
         if ($mainpage) {
            $qs   = explode(".", e_QUERY);
            if (is_numeric($qs[0])) {
               // Switch params round if 1st is numeric - e107 Next/Prev class inisists on "page number" as 1st URL parameter
               $temp = array_shift($qs);
               array_push($qs, $temp);
            }

            $ujop = varset($qs[0], "bloggers");
            $ujp1 = varset(intval($qs[1]), 0);
            $ujp2 = varset(intval($qs[2]), 0);
                        
            switch ($ujop) {
               case "blogger" : {
                  //$user = getx_user_data($ujp1);
                  $user = e107::user($ujp1); 
                  $page = $this->BloggerPage($ujp1, $user["user_name"], $ujp2);
                  break;
               }
               case "blog" : {
                  $page = $this->BlogPage($ujp1);
                  break;
               }
               case "allblogs" : {
                  $page = $this->AllBlogsPage($ujp1);
                  break;
               }
               case "add" : {
                  $page = $this->BlogAddEdit();
                  break;
               }
               case "edit" : {
                  $page = $this->BlogAddEdit($ujp1);
                  break;
               }
               case "save" : {
                  $page = $this->BlogSave();
                  break;
               }
               case "update" : {
                  $page = $this->BlogUpdate($ujp1);
                  break;
               }
               case "delete" : {
                  $page = $this->BlogDelete($ujp1);
                  break;
               }
               case "synopsis" : {
                  $page = $this->BlogSynopsis();
                  break;
               }
               case "synopsissave" : {
                  $page = $this->BlogSynopsisSave();
                  break;
               }
               case "synopsisupdate" : {
                  $page = $this->BlogSynopsisUpdate();
                  break;
               }
               case "cat" : {
                  $page = $this->CategoryPage($ujp1);
                  break;
               }
               case "allcats" : {
                  $page = $this->AllCategoriesPage();
                  break;
               }
               case "report" : {
                  $page = $this->ReportPage($ujp1);
                  break;
               }
               case "reportit" : {
                  $page = $this->ReportItPage($ujp1);
                  break;
               }
               case "bloggers" : {
                  $page = $this->DefaultPage($ujp1);
                  break;
               }
               default : {
                  $page = $this->DefaultPage(1);
                  break;
               }
            }
 
            //$ns = new e107table();          
           // print_a($page[0]);            
            $ns->tablerender($page[0], $page[1]);
         }
      }

      function DefaultPage($start=1) {
         global $sql, $tp, $uj_blog, $userjournals_shortcodes, $UJ_BLOGGERS_LIST;
 
		 $plugPrefs = e107::getPlugPref('userjournals_menu');
		 $sql = new db();

		 $text = "";
		 
		 $start = $start ? $start - 1 : 0;

         if ($plugPrefs["userjournals_bloggers_per_page"]) {
			$start = $start *  $plugPrefs["userjournals_bloggers_per_page"];
            $limit = " limit $start ,".$plugPrefs["userjournals_bloggers_per_page"];
         }
         $qry = "userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=0 group by userjournals_userid order by userjournals_timestamp desc";
              
         if ($count = $sql->gen("SELECT distinct(userjournals_userid) as userjournals_userid, max(userjournals_timestamp) as userjournals_timestamp FROM #userjournals WHERE ".$qry.$limit, true )) {
             
            while($uj_blog = $sql->fetch()) {
               $text .= $tp->parseTemplate($UJ_BLOGGERS_LIST, FALSE, $userjournals_shortcodes);
            }
         } else {
            $text = UJ44;
		 }
		 
		   
         if ($plugPrefs["userjournals_bloggers_per_page"]) {
			$count = $sql->select("userjournals", "distinct(userjournals_userid) as id, max(userjournals_timestamp) as ts", $qry );
			 
            include_once(e_PLUGIN."userjournals_menu/handlers/np_class.php");
            $np = new nextprev();
             
			$text .= $np->nextprev(e_SELF, $start, $plugPrefs["userjournals_bloggers_per_page"], $count, "", "bloggers", true);
			 
		 }
		  
         return array(UJ43, $text);
      }

      function BloggerPage($bloggerid, $bloggername, $start=1, $msg=false) {
         global $sql, $tp, $uj_message, $uj_synopsis, $userjournals_shortcodes, $UJ_MESSAGE, $UJ_BLOGGER_SYNOPSIS;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');

		 $_msg = $_SESSION['userjournals']['_msg'];
		 unset($_SESSION['userjournals']['_msg']);

 
         $caption = $plugPrefs["userjournals_page_title"].UJ25.$bloggername;
         $text = "";
         if ($sql->select("userjournals", "userjournals_userid, userjournals_entry", "userjournals_is_blog_desc=1 AND userjournals_userid=".$bloggerid)) {
            if ($uj_synopsis = $sql->fetch()) {
               //$user = getx_user_data($bloggerid);
               $user = e107::user($bloggerid);
               $text .= $tp->parseTemplate($UJ_BLOGGER_SYNOPSIS, TRUE, $userjournals_shortcodes);
            }
         }
		 
         $start = $start ? $start - 1 : 0;
         if ($plugPrefs["userjournals_blogs_per_page"]) {
			$start = $start * $plugPrefs["userjournals_blogs_per_page"];
            $limit = " limit $start,".$plugPrefs["userjournals_blogs_per_page"];
         }  
         $qry = "userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=0 AND userjournals_userid=$bloggerid order by userjournals_timestamp DESC";
         if ($sql->select("userjournals", "*", $qry.$limit)){
            while ($row = $sql->fetch()){
               $text .= $this->GetBlog($row, $plugPrefs["userjournals_len_preview"]);
            }
         } else {
            $text = $this->Message( UJ28);
         }

         if ($_msg) {
            $text = $_msg.$text;
		 }
		 if ($msg) {
            $text = $msg.$text;
         }

         if ($plugPrefs["userjournals_blogs_per_page"]) {
            $count = $sql->select("userjournals", "*", $qry);
            include_once(e_PLUGIN."userjournals_menu/handlers/np_class.php");
                       
            $np = new nextprev();
            $text .= $np->nextprev(e_SELF, $start, $plugPrefs["userjournals_blogs_per_page"], $count, "", "blogger.$bloggerid", true);
         }
         return array($caption, $text);
      }

      function BlogPage($blogid) {
		 global $sql;
		 
         $plugPrefs = e107::getPlugPref('userjournals_menu');                    
 
		 $_msg = $_SESSION['userjournals']['_msg'];
		 unset($_SESSION['userjournals']['_msg']);

		 if ($sql->select("userjournals", "*", "userjournals_id=$blogid")){
            $text = "";
            if ($row = $sql->fetch()){
               $text .= $this->GetBlog($row);
            } else {
               $text = $this->Message("232".UJ28);
            }
         } else {
            $text = $this->Message("235".UJ28);
         }
 
         if ($_msg) {
            $text = $_msg.$text;
		 }
		 	 
         //$user = getx_user_data($row["userjournals_userid"]);
         $user = e107::user($row["userjournals_userid"]);
         $caption = $plugPrefs["userjournals_page_title"].UJ25.$user["user_name"];
         return array($caption, $text);
      }

      function AllBlogsPage($start = 1 ) {
		 global $sql;
		 
		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         $caption = $plugPrefs["userjournals_page_title"];
		 $start = $start ? $start - 1 : 0;
         if ($plugPrefs["userjournals_blogs_per_page"]) {
			$start =  $start * $plugPrefs["userjournals_blogs_per_page"];
            $limit = " limit $start,".$plugPrefs["userjournals_blogs_per_page"];
         }      
         
		 $qry = "  userjournals_is_blog_desc=0 AND userjournals_is_published=0 ORDER BY userjournals_timestamp DESC";
		  
         if ($rows = $sql->retrieve("userjournals", "*", $qry.$limit, true  )) {
			$text = "";
			foreach($rows AS $row) {
               $text .= $this->GetBlog($row, $plugPrefs["userjournals_len_preview"])."<br/>"; 
            }
         } else {
            $text = $this->Message(UJ28);
         }

         if ($plugPrefs["userjournals_blogs_per_page"]) {
            $count = $sql->select("userjournals", "*", $qry );
            include_once(e_PLUGIN."userjournals_menu/handlers/np_class.php");
            $np = new nextprev();
            $text .= $np->nextprev(e_SELF, $start, $plugPrefs["userjournals_blogs_per_page"], $count, "", "allblogs", true);
 
         }
         return array($caption, $text);
      }

      function GetBlog($blog, $limit=false) {
         global $uj_blog, $uj_categories, $userjournals_shortcodes, $UJ_BLOG, $UJ_BLOG_SHORT;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');
		 $tp = e107::getParser();

         $uj_blog = $blog;  
		 $uj_categories = $this->cats;   
 
         if ($limit) {        
            $text = $tp->parseTemplate($UJ_BLOG_SHORT, FALSE, $userjournals_shortcodes);
         } else {
            $text = $tp->parseTemplate($UJ_BLOG, FALSE, $userjournals_shortcodes);
         }
         return $text;
      }

      function BlogAddEdit($blogid=false) {
		 global   $sql ;

		 $frm = e107::getForm();
		 $plugPrefs = e107::getPlugPref('userjournals_menu');
		 
                  
         if (check_class($plugPrefs["userjournals_writers"])) {            
            $text = "<form action='".e_SELF."?save' method='post'>";
            if ($blogid) {
               if ($sql->select("userjournals", "*", "userjournals_id=$blogid")){
                  if ($result = $sql->fetch()){
                     extract($result);
                     $text = "<form action='".e_SELF."?update.$blogid' method='post'>";
                  }
               }
            } else {
               $userjournals_subject = "";
               $userjournals_is_published = "";
               $userjournals_categories = "";
               $userjournals_playing = "";
               $userjournals_mood = "";
               $userjournals_entry = "";
            }

            $text .= "<table border='0'>";
            $text .= "<tr><td class='forumheader3' style='width:20%'>".UJ6."</td>";
            $text .= "<td class='forumheader3'>";
            $text .=  e107::getForm()->text("journal_title" , $userjournals_subject,  "200", "size=42");
            $text .= "</td></tr>";
            $checked = $userjournals_is_published==0 ? "checked='checked'" : "";
            $text .= "<tr><td class='forumheader3'>".UJ62."</td>";
            $text .= "<td class='forumheader3'><input type='checkbox' class='tbox' name='journal_published' value='0' $checked/><span class='smalltext'>".UJ63."</span></td></tr>";
            
            if ($plugPrefs["userjournals_show_cats"] != 0) {  //multicheck
               $userjournals_categories = explode(",", $userjournals_categories);
               $text .= "<tr><td class='forumheader3'>".UJ91."</td>";
			   $text .= "<td class='forumheader3'><div class='search-checkboxes'>";
			   foreach($this->cats AS $row) {
                     extract($row);
                     $checked = in_array($userjournals_cat_id, $userjournals_categories) ? " checked='checked'" : "";
                     $text .= "<span class='search-checkbox'><input type='checkbox' class='tbox' name='journal_cat[$userjournals_cat_id]' value='$userjournals_cat_id'$checked/>$userjournals_cat_name</span>"; 
               }
               $text .= "</div></td></tr>";
            }
            if ($plugPrefs["userjournals_show_playing"] == 1) {
               $text .= "<tr><td class='forumheader3'>".UJ41."</td>";
               $text .= "<td class='forumheader3'>";
               $text .=  e107::getForm()->text("journal_playing" , $userjournals_playing,  "200", "size=42");
               $text .= "<br/><span class='smalltext'>".UJ64."</span></td></tr>";
                        
            }
            if ($plugPrefs["userjournals_show_mood"] == 1) {
               $text .= "<tr><td class='forumheader3'>".UJ42."</td><td class='forumheader3'><select class='tbox form-control' name='journal_mood' size='1'>";
               $keys = array_keys($this->mood);
               $selected = $userjournals_mood == "" ? " selected='selected'" : "";
               $text .= "<option value=''$selected></option>";
               foreach ($keys as $key) {
                  $selected = $userjournals_mood == $key ? " selected='selected'" : "";
                  $text .= "<option value='$key'$selected>".$this->mood[$key]."</option>";
               }
               $text .= "</select><br/><span class='smalltext'>".UJ65."</span></td></tr>";
            }
			$text .= "<tr><td class='forumheader3'>".UJ7."</td><td class='forumheader3'>";
 
			//function getTextarea($tatext="", $name="e107xheleprTA", $class="tbox", $rows="15", $cols=false, $width=false, $showBBCodes=false, $showEmotes=false, $resize=false)
			//function bbarea($name, $value, $template = '', $mediaCat='_common', $size = 'large', $options = array())

			//$text .= $frm->getTextarea($userjournals_entry, "journal_entry", "tbox", 15, false, "98%", 2, $pref["smiley_activate"]);
			$text .=   e107::getForm()->bbarea('journal_entry',$userjournals_entry, NULL, '_common', 'medium', array('id' => 'journal_entry', 'wysiwyg' => $this->editor)) ;
			$text .=  "</td></tr>";
			
            if ($blogid) {
               $text .= "<tr><td class='forumheader3'>".UJ96."</td><td class='forumheader3'>";
               $text .= "<input type='checkbox' class='tbox' name='journal_update_date' value='1' checked='checked'/><span class='smalltext'>".UJ97."</span>";
               $text .= "</td></tr>";
            }
            $text .= "<tr><td colspan='2' class='forumheader3' style='text-align:center;'>";
            if ($blogid) {
               $text .= "<input type='submit' class='button' value='".UJ51."' name='update'/> ";
            } else {
               $text .= "<input type='submit' class='button' value='".UJ2."' name='save'/> ";
            }
            $text .= "<input type='button' class='button' value='".UJ3."' name='cancel' onclick='window.history.back()'/>";
            $text .= "</td></tr></table></form>";   
         } else {
            $text = $this->Message(UJ17);
         }

         return array($plugPrefs["userjournals_page_title"], $text);
      }

      function BlogSave() {

		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         // Only allow blog writers to save entries
         if (check_class($plugPrefs["userjournals_writers"])) {
            if ($_POST["journal_title"] != "" and $_POST["journal_entry"] != "") {
               $tp = e107::getParser();
               
               $journal_title       = $tp->toDB($_POST['journal_title']);
               $journal_published   = isset($_POST['journal_published']) ? 0 : 1;
               $journal_playing     = $tp->toDB($_POST['journal_playing']);
               $journal_mood        = $tp->toDB($_POST['journal_mood']);
               $journal_entry       = $tp->toDB($_POST['journal_entry']);
               $journal_cats        = $tp->toDB($_POST["journal_cat"]);
               $journal_cats        = implode(",", $journal_cats);
               $journal_cats        = varset($journal_cats, '');
               
               $thetime = time();
               $thedate = e107::getDate()->convert_date($thetime, "forum");
               $the_sql = array(
                    'userjournals_id'                => NULL,
        		    'userjournals_userid'            => USERID,        
                    'userjournals_subject'           => $journal_title,
        		    'userjournals_categories'        => $journal_cats,
        		    'userjournals_playing'           => $journal_playing,
        	  	    'userjournals_mood'              => $journal_mood,         
        			'userjournals_entry'             => $journal_entry,    
                    'userjournals_date'              => $thedate,  
                    'userjournals_timestamp'         => $thetime,  
                    'userjournals_is_comment'        => 0,  
                    'userjournals_comment_parent'    => 0,      
                    'userjournals_is_blog_desc'      => 0,  
                    'userjournals_is_published'      => $journal_published,   
             );
     
               if (e107::getDb()->insert('userjournals', $the_sql)){
				  $text = $this->Message(UJ13);
				  e107::redirect(e_PLUGIN."userjournals_menu/userjournals.php?blogger.".USERID);
				  exit;
               } else {
                  $text = $this->Message(UJE02, "1. SQL ($the_sql) " . e107::getDb()->getLastErrorText() );
               }
            } else {
               $text = $this->Message(UJ23.' '.UJ21);
            }
         } else {
            $text = $this->Message(UJ17);
         }
		 
         return $this->BloggerPage(USERID, USERNAME, 0, $text);
      }

      function BlogUpdate($blogid) {
		$plugPrefs = e107::getPlugPref('userjournals_menu');
		$sql = e107::getDb();

         // Only allow blog writers to update entries
         if (check_class($plugPrefs["userjournals_writers"])) {
            // Make sure user is only updating their own entries
            if ($sql->select("userjournals", "*", "userjournals_id=$blogid")){
               if ($result = $sql->fetch()){
                  extract($result);
                  if ($userjournals_userid != USERID) {
                     return $this->BloggerPage(USERID, USERNAME, 0, $this->Message(UJ17));
                  }
               }
            }

            if ($_POST["journal_title"] != "" and $_POST["journal_entry"] != "") {
               $tp = e107::getParser();
               $journal_title    = $tp->toDB($_POST['journal_title']);
               $journal_published = isset($_POST['journal_published']) ? 0 : 1;
               $journal_playing  = $tp->toDB($_POST['journal_playing']);
               $journal_mood     = $tp->toDB($_POST['journal_mood']);
               $journal_entry    = $tp->toDB($_POST['journal_entry']);
               $journal_cats     = $_POST["journal_cat"];
               $journal_cats     = implode(",", $journal_cats);

               if ($_POST["journal_update_date"]) {
                  $thetime = time();
                  $thedate = e107::getDate()->convert_date($thetime, "forum");
                  $datesql = ", userjournals_timestamp='$thetime$'";
               } else {
                  $datesql = "";
               }

               $the_sql = "userjournals_subject='$journal_title', userjournals_categories='$journal_cats', userjournals_playing='$journal_playing', userjournals_mood='$journal_mood', userjournals_entry='$journal_entry', userjournals_is_published='$journal_published' $datesql where userjournals_id=$blogid";
               if ($sql->db_Update('userjournals', $the_sql)){
				  $text = $this->Message(UJ13);
				  $_SESSION['userjournals']['_msg'] = $text;
				  e107::redirect(e_PLUGIN."userjournals_menu/userjournals.php?blog.".$blogid);
				  exit; 
               } else {
                  $text = $this->Message(UJE02, "2. SQL ($the_sql) ". e107::getDb()->getLastErrorText()   );
               }
            } else {
               $text = $this->Message(UJ23.' '.UJ21);
            }
         } else {
            $text = $this->Message(UJ17);
         }

         return $this->BloggerPage(USERID, USERNAME, 0, $text);
      }

      function BlogDelete($blogid) {
		 global $sql,$plugPrefs;
		 
		 $plugPrefs = e107::getPlugPref('userjournals_menu');
 
         // Only allow blog writers to delete entries
         if (check_class($plugPrefs["userjournals_writers"]) || ADMIN) {
            // Make sure user is only deleting their own entries
            if ($sql->select("userjournals", "*", "userjournals_id=$blogid")){
               if ($result = $sql->fetch()){
                  extract($result);
                  if ($userjournals_userid != USERID && !ADMIN) {
                     return $this->BloggerPage(USERID, USERNAME, 0, $this->Message(UJ17));
                  }
               }
            }

            // Do the delete
            if (!$sql->db_Delete("userjournals", "userjournals_id='$blogid' OR userjournals_comment_parent='$blogid'")){
               $text = $this->Message("SQL ".UJ23 );
            }
            // Delete any comments for this entry
            $sql->db_Delete("comments", "comment_item_id='$blogid' and comment_type='userjourna'");
         } else {
            $text = $this->Message(UJ17);
         }

         return $this->BloggerPage(USERID, USERNAME, 0, $text);
      }

      function BlogSynopsis() {
         global  $pref, $sql;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');
         if (check_class($plugPrefs["userjournals_writers"])) {
            $text = "<form action='".e_SELF."?synopsissave' method='post'>";

            if ($sql->select("userjournals", "*", "userjournals_userid=".USERID." and userjournals_is_blog_desc='1'")){
               if ($row = $sql->fetch()){
                  extract($row);
                  $text = "<form action='".e_SELF."?synopsisupdate.".USERID."' method='post'>";
               }
            } else {
               $userjournals_entry = "";
            }

            $text .= "<table border='0'>";
            $text .= "<tr><td class='forumheader3' colspan='2'>".UJ55."</td>";
            $text .= "<tr><td class='forumheader3'>".UJ52."</td><td class='forumheader3'>";
			//$text .= $e107xHelper->getTextarea($userjournals_entry, "journal_synopsis", "tbox", 10, false, "98%", 2, $pref["smiley_activate"]);
			
			$text .=   e107::getForm()->bbarea('journal_synopsis',$userjournals_entry, NULL, '_common', 'medium', array('id' => 'journal_synopsis', 'wysiwyg' => $this->editor)) ;

            $text .= "</td></tr><tr><td colspan='2' class='forumheader3' style='text-align:center;'>";
            if (isset($blogid)) {
               $text .= "<input type='submit' class='button' value='".UJ51."' name='synopsisupdate'/> ";
            } else {
               $text .= "<input type='submit' class='button' value='".UJ2."' name='synopsissave'/> ";
            }
            $text .= "<input type='button' class='button' value='".UJ3."' name='cancel' onclick='window.history.back()'/>";
            $text .= "</td></tr></table></form>";
         } else {
            $text = $this->Message(UJ17);
         }

         return array($plugPrefs["userjournals_page_title"]." : ".UJ52.UJ53.USERNAME, $text);
      }

      function BlogSynopsisSave() {
         global $sql;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         // Only allow blog writers to save a synopsis
         if (check_class($plugPrefs["userjournals_writers"])) {
            if ($_POST["journal_synopsis"] != "") {
               $tp = e107::getParser();
               $journal_synopsis = $tp->toDB($_POST['journal_synopsis']);

               $thetime = time();
               $thedate = e107::getDate()->convert_date($thetime, "forum");
      
               $the_sql =  array(
        		    'userjournals_id'                => NULL,
        		    'userjournals_userid'            => USERID,
        		    'userjournals_subject'           => USERNAME,
        		    'userjournals_categories'        => '',
        		    'userjournals_playing'           => '',
        			'userjournals_mood'              => '',
        			'userjournals_entry'             => $journal_synopsis,    
                    'userjournals_date'              => $thedate,  
                    'userjournals_timestamp'         => $thetime,  
                    'userjournals_is_comment'       => 0,  
                    'userjournals_comment_parent'    => 0,      
                    'userjournals_is_blog_desc'      => 1,  
                    'userjournals_is_published'      => 0,                                     
        		);
          
               if ($sql->insert('userjournals', $the_sql)){
				  $text = $this->Message(UJ54);
				  $_SESSION['userjournals']['_msg'] = $text;
				  e107::redirect(e_PLUGIN."userjournals_menu/userjournals.php?blogger.".USERID); 
				  exit;
               } else {
                  $text = $this->Message(UJE01, "1. SQL ($the_sql) " . e107::getDb()->getLastErrorText() );
               }
            } else {
               return $this->BlogSynopsisDelete();
            }
         } else {
            $text = $this->Message(UJ17);
         }

         return $this->BloggerPage(USERID, USERNAME, 0, $text);
      }

      function BlogSynopsisUpdate() {
         global $sql;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         // Only allow blog writers to update a synopsis
         if (check_class($plugPrefs["userjournals_writers"])) {

            if ($_POST["journal_synopsis"]) {

               $tp = e107::getParser();
               $journal_synopsis = $tp->toDB($_POST['journal_synopsis']);

               $thetime = time();
               $thedate = e107::getDate()->convert_date($thetime, "forum");

               $the_sql = "userjournals_entry='$journal_synopsis', userjournals_date='$thedate', userjournals_timestamp='$thetime' where userjournals_userid=".USERID." and userjournals_is_blog_desc=1";
               if ($sql->db_Update('userjournals', $the_sql)){
				  $text = $this->Message(UJ54); 
				  $_SESSION['userjournals']['_msg'] = $text;
				  e107::redirect(e_PLUGIN."userjournals_menu/userjournals.php?blogger.".USERID);  
                  
               } else {
                  $text = $this->Message("SQL ".UJ23 );
               }
            } else {
               return $this->BlogSynopsisDelete();
            }
         } else {
            $text = $this->Message(UJ17);
         }

         return $this->BloggerPage(USERID, USERNAME, 0, $text);
      }

      function BlogSynopsisDelete() {
         global $sql;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         // Only allow blog writers to delete entries
         if (check_class($plugPrefs["userjournals_writers"])) {

            // Do the delete
            if ($sql->db_Delete("userjournals", "userjournals_userid='".USERID."' and userjournals_is_blog_desc='1'")){
               $text = $this->Message(UJ89);
            } else {
               $text = $this->Message("SQL ".UJ23 );
            }
         } else {
            $text = $this->Message(UJ17);
         }

         return $this->BloggerPage(USERID, USERNAME, 0, $text);
      }

      function ReportPage($blogid, $msg=false) {
		 global $sql;
		 
		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         if (USERID && $plugPrefs['userjournals_report_blog']) {
            $text = "<form action='".e_SELF."?reportit.$blogid' method='post'>";
            $text .= "<table class='forumheader' border='0' style='width:100%;'>";
            $text .= "<tr><td class='forumheader2' style='text-align:center;'>".UJ101."</td></tr>";
            if ($msg) {
               $text .= "<tr><td class='forumheader3' style='text-align:center;'>$msg</td></tr>";
            }
            $text .= "<tr><td class='forumheader3'><p>".UJ102."</p>";
           // $text .= "<p>".UJ103." ".UJ104." </strong>".$_SERVER['REMOTE_ADDR']."</strong>, ".UJ105." <strong>".gethostbyaddr($_SERVER['REMOTE_ADDR'])."</strong>.</p>";
            $text .= "</td></tr>";
            $text .= "<tr><td class='forumheader3'>".UJ106." ".USERNAME."<br/>";
			//$text .= $e107xHelper->getcTextarea($_POST['journal_report'], "journal_report", "tbox", 15, false, "100%", 0);
	    	$text .=   e107::getForm()->bbarea('journal_report',$_POST['journal_report'], NULL, '_common', 'medium', array('id' => 'journal_report', 'wysiwyg' => $this->editor)) ;
            $text .= "</td></tr>";
            $text .= "<tr><td class='forumheader3' style='text-align:center;'>";
            $text .= "<input type='submit' class='button' value='".UJ101."' name='report_blog'/> ";
            $text .= "</td></tr>";
            $text .= "</table>";
            $text .= "</form>";
         } else {
            $text = $this->Message(UJ17);
         }

         return array($plugPrefs["userjournals_page_title"], $text);
      }

      function ReportItPage($blogid) {
		 global $sql, $tp;
		 
		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         if (USERID && $plugPrefs['userjournals_report_blog']) {
	         if (isset($_POST['journal_report']) && strlen($_POST['journal_report']) > 0) {
	            $subject = "UserJournals ".UJ101;
               $message = UJ107." ".e_SELF."?blog$blogid ID=$blogid.<br/>";
               $message .= UJ106;
               $message .= " ".USERNAME.".";
               $message .= " ".UJ104." ".$_SERVER['REMOTE_ADDR'].".";
               $message .= " ".UJ105." ".gethostbyaddr($_SERVER['REMOTE_ADDR']).".<br/>";
               $message .= UJ101.": ".$tp->toDB($_POST['journal_report']);
               if ($plugPrefs['userjournals_report_blog'] == 1 || $plugPrefs['userjournals_report_blog'] == 3) {
                  e107::getDb()->log("UserJournals", $message, "UserJournals");
               }
               if ($plugPrefs['userjournals_report_blog'] == 2 || $plugPrefs['userjournals_report_blog'] == 3) {
         			require_once(e_HANDLER."mail.php");
			         sendemail(SITEADMINEMAIL, $subject, $message);
		         }
            } else {
               return $this->ReportPage($blogid, UJ108);
            }

            $text .= "<table class='forumheader' border='0' style='width:100%;'>";
            $text .= "<tr><td class='forumheader2' style='text-align:center;'>".UJ101."</td></tr>";
            $text .= "<tr><td class='forumheader3' style='text-align:center;'>";
            $text .= UJ109."<br/><a href='".e_SELF."?blog.$blogid'>".UJ110."</a>.<br/>";
            $text .= "</td></tr>";
            $text .= "</table>";
         } else {
            $text = $this->Message(UJ17);
         }

         return array($plugPrefs["userjournals_page_title"], $text);
      }

      function GetReaderMenu() {
		 global $sql, $userjournals_shortcodes, $UJ_MENU_READER, $UJ_RSS;
		 
		 	$ns = e107::getRender();
		 	$plugPrefs = e107::getPlugPref('userjournals_menu');
			$tp = e107::getParser();

			$uj_categories = $this->cats;
		 
            $text = $tp->parseTemplate($UJ_MENU_READER, FALSE, $userjournals_shortcodes);
			 
            if (strlen($text) > 0) {
               $ns->tablerender($plugPrefs["userjournals_menu_title"], $text);
            } else {
               $ns->tablerender($plugPrefs["userjournals_menu_title"], UJ44);
            }
      }

      /**
       * Display a menu for users that are allowed to write blogs
       * @param  class an instance of the e107table class
       */
      function GetWriterMenu() {
		 global  $sql,  $userjournals_shortcodes, $UJ_MENU_WRITER;
		 
		 $ns = e107::getRender();
		 $plugPrefs = e107::getPlugPref('userjournals_menu');
		 $tp = e107::getParser();

		 // Check if user is a UJ writer
         if (check_class( e107::pref('userjournals_menu', 'userjournals_writers'))) {
            $text = $tp->parseTemplate($UJ_MENU_WRITER, FALSE, $userjournals_shortcodes);
            $ns->tablerender(UJ39.$plugPrefs["userjournals_menu_title"], $text);
         }
      }

	  /* fix: it is menu, use the same shortcode for menus, bullets are part of template */
      function GetCategoriesMenu() {
         global $userjournals_shortcodes, $uj_category;

		 $ns = e107::getRender();
		 $plugPrefs = e107::getPlugPref('userjournals_menu');
		 $tp = e107::getParser();

         // Check if user is a UJ reader
         if (check_class($plugPrefs["userjournals_readers"]) || check_class($plugPrefs["userjournals_writers"])) {
            if ($plugPrefs["userjournals_show_cats"] == 2) {
               if (count($this->cats) > 0) {
                  $text = "<a href='".e_PLUGIN_ABS."userjournals_menu/userjournals.php?allcats'>".UJ92."</a><br/><br/>";
                  $text .= "<strong>".UJ91."</strong>";
				  $keys = array_keys($this->cats);  
                  foreach ($keys as $key) {    
                     $uj_category = $this->cats[$key];
					 $text .= $tp->parseTemplate("{UJ_CATEGORY_MENU_LINK}", FALSE, $userjournals_shortcodes);
                  }
                  $ns->tablerender($plugPrefs["userjournals_cat_menu_title"], $text);
               } else {
                  $ns->tablerender($plugPrefs["userjournals_cat_menu_title"], UJ93);
			   }
			   
            }
         }
      }

      function CategoryPage($catid, $msg=false) {
         global $sql;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         $caption = $plugPrefs["userjournals_page_title"].UJ95.$this->cats[$catid]["userjournals_cat_name"];
         $cats_sql = "AND userjournals_categories='$catid' or userjournals_categories regexp '^$catid,' or userjournals_categories regexp ',$catid,' or userjournals_categories regexp ',$catid'";

         if ($sql->select("userjournals", "*", "userjournals_is_comment=0 AND userjournals_is_blog_desc=0 AND userjournals_is_published=0 $cats_sql ORDER BY userjournals_timestamp DESC")){
            $text = "";
            while ($row = $sql->fetch()){
               $text .= $this->GetBlog($row, $plugPrefs["userjournals_len_preview"])."<br/>";
            }
         } else {
            $text = $this->Message("731".UJ28);
         }

         if ($msg) {
            $uj_message = $msg;
            $text = $tp->parseTemplate($UJ_MESSAGE, TRUE, $userjournals_shortcodes).$text;
         }

         return array($caption, $text);
      }

      function AllCategoriesPage() {
		 global $sql, $tp, $uj_categories, $uj_category, $userjournals_shortcodes, $UJ_CATEGORY, $UJ_CATEGORY_LIST;

		 $plugPrefs = e107::getPlugPref('userjournals_menu');

         $caption = $plugPrefs["userjournals_page_title"]." : ".UJ91;
         $keys = array_keys($this->cats);
         $uj_categories = "";
         foreach ($keys as $key) {
            $uj_category = $this->cats[$key];
            $uj_categories .= $tp->parseTemplate($UJ_CATEGORY, FALSE, $userjournals_shortcodes);
         }

         $text = $tp->parseTemplate($UJ_CATEGORY_LIST, FALSE, $userjournals_shortcodes);
         return array($caption, $text);
      }

      function Message($msg, $moretext=false) {
         global $tp, $uj_message, $uj_message2, $userjournals_shortcodes, $UJ_MESSAGE, $UJ_MESSAGE_EXTRA;
         $uj_message = $msg;
         $uj_message2 = $moretext;
         $text = "";
         $text = $tp->parseTemplate($UJ_MESSAGE, TRUE, $userjournals_shortcodes);
         $text .= $tp->parseTemplate($UJ_MESSAGE_EXTRA, TRUE, $userjournals_shortcodes);
         return $text;
      }

 
   }
 
}
 