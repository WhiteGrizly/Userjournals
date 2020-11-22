<?php

// Generated e107 Plugin Admin Area 

require_once('../../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('userjournals_menu',true);
 
require_once 'admin_leftmenu.php';
 
				
class userjournals_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'UserJournals';
		protected $pluginName		= 'userjournals_menu';
	//	protected $eventName		= 'userjournals_menu-userjournals'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'userjournals';
		protected $pid				= 'userjournals_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'userjournals_id DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array (),  'writeParms' =>  array (),),
			'userjournals_id'         => array (  'title' => LAN_ID,  'data' => 'int',  'width' => '5%',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_userid'     => array (  'title' => LAN_AUTHOR,  'type' => 'user',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_subject'    => array (  'title' => LAN_TITLE,  'type' => 'text',  'data' => 'int',  'width' => 'auto',  'inline' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_categories' => array (  'title' => 'Categories',  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'batch' => true,  'filter' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_playing'    => array (  'title' => 'Playing',  'type' => 'text',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_mood'       => array (  'title' => 'Mood',  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'batch' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',  'filter' => false,),
			'userjournals_entry'      => array (  'title' => 'Entry',  'type' => 'textarea',  'data' => 'str',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_date'       => array (  'title' => LAN_DATESTAMP,  'type' => 'text',  'data' => 'int',  'width' => 'auto',  'filter' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_timestamp'  => array (  'title' => 'Timestamp',  'type' => 'text',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_is_comment' => array (  'title' => 'Is Comment',  'type' => 'boolean',  'data' => 'int',  'width' => '40%',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_comment_parent'=> array (  'title' => 'Parent',  'type' => 'number',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_is_blog_desc'=> array (  'title' => 'Is Description',  'type' => 'boolean',  'data' => 'int',  'width' => 'auto',  'batch' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_is_published'=> array (  'title' => 'Is Published',  'type' => 'boolean',  'data' => 'int',  'width' => 'auto',  'batch' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' =>  array (),  'writeParms' =>  array (),),
		);		
		
		protected $fieldpref = array('userjournals_id', 'userjournals_userid', 'userjournals_subject', 'userjournals_mood', 'userjournals_date');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'userjournals_active'		=> array('title'=> 'Userjournals_active', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_page_title'		=> array('title'=> 'Userjournals_page_title', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_menu_title'		=> array('title'=> 'Userjournals_menu_title', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_cat_menu_title'		=> array('title'=> 'Userjournals_cat_menu_title', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_writers'		=> array('title'=> 'Userjournals_writers', 'tab'=>0, 'type'=>'userclass', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_readers'		=> array('title'=> 'Userjournals_readers', 'tab'=>0, 'type'=>'userclass', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_allowcomments'		=> array('title'=> 'Userjournals_allowcomments', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_allowratings'		=> array('title'=> 'Userjournals_allowratings', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_len_subject'		=> array('title'=> 'Userjournals_len_subject', 'tab'=>0, 'type'=>'number', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_len_preview'		=> array('title'=> 'Userjournals_len_preview', 'tab'=>0, 'type'=>'number', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_recent_entries'		=> array('title'=> 'userjournals_recent_entries', 'tab'=>0, 'type'=>'number', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_allowratings'		=> array('title'=> 'userjournals_show_rss', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'', 'writeParms' => array()),		 
			'userjournals_allowratings'		=> array('title'=> 'userjournals_show_playing', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'', 'writeParms' => array()),		 
			'userjournals_show_mood'		=> array('title'=> 'userjournals_show_playing', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'', 'writeParms' => array()),			 
			'userjournals_show_cats'		=> array('title'=> 'userjournals_show_cats', 'tab'=>0, 'type'=>'boolean', 'data' => 'str', 'help'=>'', 'writeParms' => array()),	 
			'userjournals_template'		=> array('title'=> 'userjournals_template', 'tab'=>0, 'type'=>'text', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_bloggers_menu_max'		=> array('title'=> 'userjournals_bloggers_menu_max', 'tab'=>0, 'type'=>'number', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_bloggers_per_page'		=> array('title'=> 'userjournals_bloggers_per_page', 'tab'=>0, 'type'=>'number', 'data' => 'str', 'help'=>'', 'writeParms' => array()),
			'userjournals_blogs_per_page'		=> array('title'=> 'userjournals_blogs_per_page', 'tab'=>0, 'type'=>'number', 'data' => 'str', 'help'=>'', 'writeParms' => array()),	 
		); 

	
		public function init()
		{
			// This code may be removed once plugin development is complete. 
			if(!e107::isInstalled('userjournals_menu'))
			{
				e107::getMessage()->addWarning("This plugin is not yet installed. Saving and loading of preference or table data will fail.");
			}
			
			// Set drop-down values (if any). 
			$this->fields['userjournals_categories']['writeParms']['optArray'] = array('userjournals_categories_0','userjournals_categories_1', 'userjournals_categories_2'); // Example Drop-down array. 
			$this->fields['userjournals_mood']['writeParms']['optArray'] = array('userjournals_mood_0','userjournals_mood_1', 'userjournals_mood_2'); // Example Drop-down array. 
	
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
		// left-panel help menu area. (replaces e_help.php used in old plugins)
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = 'Some help text';

			return array('caption'=>$caption,'text'=> $text);

		}
			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
		
	
		
		
	*/
			
}
				


class userjournals_form_ui extends e_admin_form_ui
{

}		
		

				
class userjournals_categories_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'UserJournals';
		protected $pluginName		= 'userjournals_menu';
	//	protected $eventName		= 'userjournals_menu-userjournals_categories'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'userjournals_categories';
		protected $pid				= 'userjournals_cat_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'userjournals_cat_id DESC';
	
		protected $fields 		= array (
			'checkboxes'              => array (  'title' => '',  'type' => null,  'data' => null,  'width' => '5%',  'thclass' => 'center',  'forced' => true,  'class' => 'center',  'toggle' => 'e-multiselect',  'readParms' =>  array (),  'writeParms' =>  array (),),
			'userjournals_cat_id'     => array (  'title' => LAN_ID,  'data' => 'int',  'width' => '5%',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_cat_name'   => array (  'title' => LAN_TITLE,  'type' => 'text',  'data' => 'int',  'width' => 'auto',  'inline' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_cat_icon'   => array (  'title' => LAN_ICON,  'type' => 'icon',  'data' => 'int',  'width' => 'auto',  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'userjournals_cat_parent_id'=> array (  'title' => LAN_PARENT,  'type' => 'dropdown',  'data' => 'int',  'width' => 'auto',  'batch' => true,  'filter' => true,  'help' => '',  'readParms' =>  array (),  'writeParms' =>  array (),  'class' => 'left',  'thclass' => 'left',),
			'options'                 => array (  'title' => LAN_OPTIONS,  'type' => null,  'data' => null,  'width' => '10%',  'thclass' => 'center last',  'class' => 'center last',  'forced' => true,  'readParms' =>  array (),  'writeParms' =>  array (),),
		);		
		
		protected $fieldpref = array('userjournals_cat_id', 'userjournals_cat_name', 'userjournals_cat_icon', 'userjournals_cat_parent_id');
		
	
		public function init()
		{
			// This code may be removed once plugin development is complete. 
			if(!e107::isInstalled('userjournals_menu'))
			{
				e107::getMessage()->addWarning("This plugin is not yet installed. Saving and loading of preference or table data will fail.");
			}
			
			// Set drop-down values (if any). 
			$this->fields['userjournals_cat_parent_id']['writeParms']['optArray'] = array('userjournals_cat_parent_id_0','userjournals_cat_parent_id_1', 'userjournals_cat_parent_id_2'); // Example Drop-down array. 
	
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
		// left-panel help menu area. (replaces e_help.php used in old plugins)
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = 'Some help text';

			return array('caption'=>$caption,'text'=> $text);

		}
			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
		
	
		
		
	*/
			
}
				


class userjournals_categories_form_ui extends e_admin_form_ui
{

}		
		
		
new leftmenu_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

