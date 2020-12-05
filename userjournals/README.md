# userjournals plugin

Originally developed under name userjournals_menu by Burgrain and others. See README.txt for more information.


## Version 2.1.0 :
- updated for php 7.2 except addons support

==============================================================================================
#####  Purpose:
This plugin allows the e107 CMS to support individual journals for
registered/logged-in users. Each user gets their own journal, and
can write, edit, and delete their entries. Admin has the option of
totally disabling User Journals, as well as restricting access to
logged-in users only.

THIS PLUGIN IS ONLY KNOWN TO WORK WITH e_107 VERSION 2.3.0!

==============================================================================================

##### Version History:

## Version 2.1.0 :

- updated shortcodes for new standards
- added Nuke look template
- added list of latest journals
- added option label to mood
- added option to display mods with icons in editing
- separated default (plugin frontpage) and allblogs page


Before:
Journal Directory = List all bloggers, 
List All Journals = allblogs, template $UJ_BLOG_SHORT 
List all categories = allcats, template UJ_CATEGORY_LIST
List all bloggers = bloggers, template UJ_BLOGGERS_LIST

Now: 

Journal Directory = plugin frontpage 
  $USERJOURNALS_TEMPLATE['journals_list'] + start,items, end

List All Journals = allblogs, template $UJ_BLOG_SHORT 

List all categories = allcats, template UJ_CATEGORY_LIST

List all bloggers = bloggers, template UJ_BLOGGERS_LIST

$USERJOURNALS_TEMPLATE['bloggers_list'] + start,items, end


## Version 2.0.1 :
- not released
- fixed: user avatar 

## Version 2.0.0 :
- updated for php 7.2 except addons support

==============================================================================================



##### Versioning Guidelines

All versioning should attempt to follow the [Semantic Versioning guidelines](http://semver.org/).

Given a version number MAJOR.MINOR.PATCH (e.g v0.0.0), increment the:

1. MAJOR version when you make incompatible API changes,
2. MINOR version when you add functionality in a backwards-compatible manner, and
3. PATCH version when you make backwards-compatible bug fixes.