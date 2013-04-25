=== Eazyest Gallery ===
Contributors: macbrink
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=22A3Y8ZUGR6PE
Tags: media,photo,album,picture,lazyest,image,gallery,easy,exif,subfolders,widget,ftp,upload,schortcode,comment
Tested up to: 3.5.1
Requires at least: 3.5
Stable tag: 0.1.2
License: GPLv3

Eazyest Gallery extends WordPress media featuring folders, subfolders, comments, slideshows, ftp-upload, and many more features.

== Description ==
Eazyest Gallery extends WordPress Media by adding folders and subfolders.

Eazyest Gallery is the successor to [Lazyest Gallery](http://wordpress.org/extend/plugins/lazyest-gallery/). Lazyest Gallery users please read [how to upgrade to Eazyest Gallery](http://brimosoft.nl/2013/02/27/how-to-move-from-lazyest-gallery-to-eazyest-gallery/)

Please read the [User Guide Posts](http://brimosoft.nl/category/galleries/eazyest-gallery/user-guide-eazyest-gallery/) and the [Release Post](http://brimosoft.nl/2013/04/09/eazyest-gallery-0-1-0-is-out/) at the Plugin Web Site.



= Eazyest Gallery features =
* __Fully integrated in Admin and Media management__ 
	
	The plugin stores your all your folder information in the WordPress database as custom post types. This will allow you to easily find, retrieve, edit, and show your folders. You can add tags to your folders. The folders will display in tag archives. All images link to the folders as normal WordPress attachments. You can access all images in the WordPress media manager. You can even build WordPress default galleries from Eazyest Gallery images. The plugin uses the WordPress Image Editor and Media Manager. If uploading and re-sizing works in WordPress, it will work in Eazyest Gallery. The plugin includes templates for the WordPress default themes TwentyTen, TwentyEleven and TwentyTwelve. You may copy and adjust these templates to your (child) theme.

* __Unlimited number of images in unlimited number of nested folders__
	
	Just like WordPress pages, you can add child and parent folders. Eazyest Gallery builds a directory structure on your server to match your folder hierarchy. The WordPress Menu Editor shows all folders. You can easily add folders to your site's menu.

* __Comment on folders and images__
	
	Comments on folders and images are only limited by your discussion settings. If you allow visitors to comment on posts, they will be able to comment on folders and on individual images. You can switch commenting on and off per folder.

* __Widgets__
	
	You can show your images anywhere on your site by using the widgets.
	* You have a widget to list all your folders,
	* a widget to show randomly chosen images,
	* a widget to show your latest added folders,
	* a widget to show your latest added images,
	* a widget to show a continuously running slideshow of randomly chosen thumbnails.

* __Shortcodes__
	
	Eazyest Gallery adds three shortcodes to show your gallery in posts or pages.
	`[eazyest_gallery]` to show the gallery root page, `[eazyest_folder]` to show your folder contents and `[eazyest_slideshow]`		 to show images from a folder as slideshow.
	Don't worry if you update from Lazyest Gallery, Eazyest Gallery supports all `[lg_gallery]`, `[lg_folder]`, `[lg_slideshow]`, and `[lg_image]` shortcodes.

* __Automatic indexing of (ftp) uploaded folders and images__
	
	You don't have to use the WordPress media manager to add folders or to upload images. The plugin indexes folders and images as soon as you open the the Eazyest Gallery menu. It will sanitize folder names and image file names to create 'clean' permalinks for folders and images, and will use the unsanitized version as folder or image title. *Please be aware that WordPress should have write access to your FTP uploaded folders.*
	
* __Expandable by plugins and themes__
  Eazyest Gallery uses the WordPress `[gallery]` function to output the thumbnails views. Plugins that change the gallery display, like [Jetpack](http://wordpress.org/extend/plugins/jetpack/) and [Eazyest Slides](http://wordpress.org/extend/plugins/eazyest-slides/), will work also with Eazyest Gallery. 	
	
* __Upgrade/Import tool for Lazyest Gallery__
	
	I won't develop new features for Lazyest Gallery, in favor of Eazyest Gallery. The plugin includes an updater to import all your Lazyest Gallery content and comments to the new custom post-type folder structure.

* __Many actions and filters to interact with Eazyest Gallery__
	
	The plugin offers theme and plugin builders many action [hooks and filters](http://brimosoft.nl/eazyest/gallery/actions-and-filters-for-eazyest-gallery/) to interact with the inner workings and output.

== Installation ==

1. Install eazyest-gallery using the WordPress plugin installer
2. Confirm your Gallery folder in Settings -> Eazyest Gallery

== Frequently Asked Questions ==

= My thumbnail gallery does not display as expected =
Eazyest Gallery uses the gallery shortcode function of WordPress to display the images in a folder. This makes it easier for you to use plugins or themes to change the appearance. [Jetpack](http://wordpress.org/extend/plugins/jetpack/) and [Eazyest Slides](http://wordpress.org/extend/plugins/eazyest-slides/) have nice slideshows that work with your galleries.
However, some themes override the gallery output in a way it overrides your columns setting or your sort order. 
If something seems wrong, please try first with a default theme like [TwentyTwelve](http://wordpress.org/extend/themes/twentytwelve) before you start a new support thread.

= My FTP uploaded folders do not show up in Eazyest Gallery =

Eazyest Gallery will index your new folders when you open the __All Folders__ menu in WordPress Admin. If they do not show, please check if WordPress (PHP) has [write permissions](http://codex.wordpress.org/Changing_File_Permissions) to your new folders.

= When I click an attachment picture, my full size image does not show in lightbox =

The attachment view behavior depends on the code in the attachment template. Eazyest Gallery searches for a template called `eazyest-image.php`. Please copy a template from a theme in `eazyest-gallery/themes` as an example to build a template for your theme.

= How do I remove the Eazyest Gallery breadcrumb trail? =

Add this code to your child theme functions.php:
`function remove_eazyest_gallery_breadcrumb() {
  remove_action('eazyest_gallery_before_attachment',     'ezg_breadcrumb', 5);
  remove_action('eazyest_gallery_before_folder_content', 'ezg_breadcrumb', 5);
}
add_action( 'eazyest_gallery_ready', 'remove_eazyest_gallery_breadcrumb', 1 );` 

= How do I remove the Slideshow link/button? =
Add this code to your child theme functions.php:
`function remove_eazyest_gallery_slideshow_button() {
  remove_action('eazyest_gallery_before_folder_content', 'ezg_slideshow_button', 9);
}
add_action( 'eazyest_gallery_ready', 'remove_eazyest_gallery_slideshow_button', 1 );`

== Screenshots ==

1. Eazyest Gallery menu, below WordPress Media menu
2. Manually sorting folders in the Gallery Admin screen
3. The gallery folder edit screen
4. Upload images with the WordPress Media uploader
5. A Gallery folder in Twenty Twelve with random image widget
6. Camera slideshow by [Manuel Masia](http://www.pixedelic.com/plugins/camera/) included
7. Upgrade tool for Lazyest Gallery users

== Upgrade Notice ==

= 0.1.2 =
* __0.1.2__ fixes fatal error on Settings Page 

== Changelog ==

= 0.1.2 =
* Bug Fix: fatal error on Settings Page

= 0.1.1 =
* Bug Fix: No captions display because of `style="display:none"`

= 0.1.0 = 
* Bug Fix: Match new or deleted folders when folder has new parent
* Bug Fix: Output of Thumbnails and Breadcrumb trail when post is password protected
* Bug Fix: Javascript error in All Folders screen
* Bug Fix: Link is broken when Folder icon is set to 'Title only'
* Bug Fix: Allow thumbnails to be ordered by excerpt (caption).
* Bug Fix: Allow not-logged-in users to use the More Folders - AJAX refresh.
* Bug Fix: Do not collect folders when doing ajax
* Changed: Improved information from AJAX collect images script
* Changed: Do not slideUp after ajax images collect 
* Changed: Show subfolders instead of subdirectories in manually ordered Admin tables.
* Changed: Use post name instead of gallery path for Edit-Folder Path display
* Changed: Do not output gallery-caption when content is empty
* Changed: Show About page only at first activation. 
* Changed: Remove link anchors when on-click is set to 'nothing' 
* Changed: Use simpleFade as single transition effect for slideshow, crop images for complete fill and set timing to 5 seconds.
* Added: Filters for tables in Edit - Folder
* Added: Filter for Camera Slideshow skin.
* Removed: Option to not show captions in thumbnail view, because WordPress offers no filters

= 0.1.0-RC-14 =
* Bug Fix: Duplicate entries in folder table after bulk edit
* Bug Fix: PHP notice in home_dir() function

= 0.1.0-RC-13 =
* Bug Fix: Prevent PHP notices on path functions
* Bug Fix: Hide Folder Navigation title in non-twenty themes
* Bug Fix: If number of folders is set to 0 `[eazyest_gallery]` shortcode should show all folders
* Bug Fix: Message "Please check your server settings to solve this error: next"
* Bug fix: HTML error in folder thumbnail on archive pages (props mr_sven)
* Changed: Default gallery folder is now `wp-content/uploads/gallery`
* Changed: By default, new Gallery Folders will not appear in Recent Posts widgets
* Changed: Use should confirm gallery folder even when default folder exists.
* For more information about this release, please check the [Plugin Blog](http://brimosoft.nl/2013/04/02/eazyest-gallery-0-1-0-rc-13/)

= 0.1.0-RC-12 =
* Bug Fix: Do not allow upload directory as gallery folder

= 0.1.0-RC-11 =
* Bug Fix: Fatal error due to debug function

= 0.1.0-RC-10 =
* Bug Fix: Broken thumbnails in Upload screen.
* Added: Collect images on the Media Library screen.
* Added: Display full gallery folder path in Settings screen.

= 0.1.0-RC-9 =
* Bug Fix: Update subfolders on opening Edit - Folder screen
* Changed: When file system directory does not exist, or cannot be read, Folder post gets trashed instead of premanently deleted.
* Changed: More checks before deleting folders from file system
* Changed: Allow users to select featured image from all images in Wordpress media 
* Changed: Do not use deprecated jQuery `.live()`

= 0.1.0-RC-8 =
* Bug Fix: Users had unusable Lazyest Gallery roles after upgrade
* Bug Fix: Incorrect number of images and columns after clicking More Thumbnails in shortcode
* Bug Fix: Attachment caption displayed on top and bottom of attachment image.
* Bug fix: Random Image widget did not save options.
* Bug Fix: Directories get inadvertently deleted when a directory scan fails
* Bug Fix: Featured Image shows full size in Folder Editor
* Bug Fix: Attachment on-click setting were not used 
* Added: Attachments and Folders show in Recent Posts Widget
* Added: Attachments and Folders show in Recent Comments Widget
* Added: Warning message in Upgrade Screen

= 0.1.0-RC-7 =
* Bug Fix: Auto index made subfolders root folders
* Bug Fix: Incorrect number of columns when more than one gallry/folder/widget on one page
* Bug Fix: Wrong canonical permalink for attachment pages
* Bug Fix: Delete cross did not woirk for extra fields admin
* Bug Fix: Setting for number of folders did not apply to subfolders
* Bug Fix: Thumbnails pagination when extra-fields enabled
* Bug Fix: Double thumbnail display when single-galleryfolder.php is in child theme only
* Changed: H3 Gallery title does not show for `[eazyest_gallery]` or `[lg_gallery]` shortcodes
* Changed: No 'Add subfolder' link for draft folders
* Added: Parent folder link for draft subfolders 
* Added: Pagination for subfolders
* Added: Check if slug is not an existing directory
* Added: Count option for `[eazyest_folder]` and `[lg_folder]` shortcodes 


 = 0.1.0-RC-6 =
* Bug Fix: Fatal error due to leftover debug func. 

= 0.1.0-RC-5 =
* Bug Fix: Incorrect filename for auto-indexed images
* Bug Fix: Could not manually sort subfolders in Edit Folder screen
* Bug Fix: [lg_folder] shortcode did not resolve folder option
* Bug Fix: Hide navigation text in non-Twenty... themes

= 0.1.0-RC-4 =
* Added: Support for Weaver II

= 0.1.0-RC-3 =
* Bug fix: Auto-index did not remove attachments from database
* Bug fix: New folder inserted when user changes post slug
* Bug fix: Recent folders widget show all folders


= 0.1.0-RC-2 =
* Bug Fix: Sharing button did not work on attachment page for some settings
* Bug Fix: Folder got emptied and regenerated when attached to another parent folder
* Bug Fix: Attachment page appeared in lightbox
* Changed: Gallery styling for themes using non-default galery styling like twentythirteen

= 0.1.0-RC-1 =
* Bug Fix: Only full size image could be inserted in posts
* Bug Fix: Auto-index did not start in minified javascript
* Bug Fix: Strip slashes in image captions 
* Bug Fix: Thumbnail sorting settings in Frontend
* Bug Fix: Thumbnails view for shortcodes in Pages
* Bug Fix: Output buffer for slideshow shortcode
* Bug Fix: Thumbnail navigation for non-pretty-permalinks
* Changed: Batch size for importing images to prevent out-of-execution-time errors
* Added: Filter to accomodate Watermark plugins
* Localizations: __String Freeze__

= 0.1.0-beta-5 =
* Bug Fix: Error in auto-index message

= 0.1.0-beta-4 =
* Bug fix: Double set of thumbs in non-Twenty themes
* Bug Fix: Out-of-execution-time error in upgrade and auto-index
* Bug Fix: Gallery folder dropdown did noit show all folders from web root
* Bug Fix: Could not find resized images
* Changed: More information during upgrade/import/auto-index processes
* Changed: Auto-index script is stoppable
* Changed: Aspect ratio for slideshow
* Changed: Do not show -Insert from URL- in media view


= 0.1.0-beta-3 =
* Bug Fix: Zombie folders came back as published after they were permanently deleted
* Bug Fix: Thumbnails did not show if you selected 'medium' or 'large' for Thumbnail click
* Bug Fix: Camera slideshow did not work in non-Twenty themes
* Bug Fix: File tree dropdown did not unfold on some browsers
* Changed: No link in breadcrumb trail for trashed parent folders
* Changed: Admin Searching indicator is now on top of the folders list

= 0.1.0-beta-2 =
* Bug Fix: Sort order did not apply to manually sorted folders
* Bug Fix: Responsive display folder columns = 0
* Bug Fix: Incorrect import and sanitize of Lazyest gallery folders
* Added: Thumbnail navigation or AJAX "More thumbnails" for Folder display
* Changed: Maximum number of icons/thumbnails is now full rows times columns

= 0.1.0-beta-1 =
* Bug Fix: Split-up of imported folders with many images
* Added: About page
* Added: post_status 'hidden'
* Added: Include folders in post tag archives
* Added Slideshow button for folders in frontend
* Added: Exif on attachment page
* Added: Support for header images from eazyest gallery images
* Changed: Lazyest Gallery cache slides/ thumbs/ will not be deleted
* Changed: Menu icons
* Changed: You cannot change root gallery folder after you have inserted a folder

= 0.1.0-alpha-5 =
* Changed: Image and subfolder list tables visible when empty
* Added: Widgets
* Added: Display Exif data on attachment page
* Added: Slideshow
* Added: Support for Header images from Eazyest Gallery images
* Changed: Use iptc/exif created timestamp for attachment post_date

= 0.1.0-alpha-4 =
* Changed: All resized images now stored in subdirectory _cache
* Changed: Folder path now saved in postmeta as key '_gallery_path' instead of 'gallery_path'

== Copyright ==

* Copyright (c) 2013 Marcel Brinkkemper
* TableDnD plug-in for JQuery, Copyright (c) Denis Howlett
* JQuery File Tree, Copyright (c) 2008, A Beautiful Site, LLC
* Camera slideshow v1.3.3, Copyright (c) 2012 by Manuel Masia - www.pixedelic.com
* Jigsoar icons, Handcrafted by Benjamin Humphrey for Jigsoar - www.jigsoaricons.com

== License ==

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see [http://www.gnu.org/licenses/](http://www.gnu.org/licenses/).