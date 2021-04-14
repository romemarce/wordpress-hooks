<?php

function disableMenuAndSubmenu(){
	global $submenu;
	//remove_menu_page( 'edit.php' ); // Posts
	// remove_menu_page( 'upload.php' ); // Media
	// remove_menu_page( 'link-manager.php' ); // Links
	// remove_menu_page( 'edit-comments.php' ); // Comments
	//remove_menu_page( 'edit.php?post_type=page' ); // Pages
	remove_menu_page( 'plugins.php' ); // Plugins
	remove_menu_page( 'themes.php' ); // Appearance
	//remove_menu_page( 'users.php' ); // Users
	remove_menu_page( 'tools.php' ); // Tools
	// remove_menu_page('options-general.php'); // Settings

	remove_submenu_page ( 'index.php', 'update-core.php' );    // Dashboard->Updates
	remove_submenu_page ( 'themes.php', 'themes.php' ); // Appearance-->Themes
	//remove_submenu_page ( 'themes.php', 'widgets.php' ); // Appearance-->Widgets
	remove_submenu_page ( 'themes.php', 'theme-editor.php' ); // Appearance-->Editor

	remove_submenu_page ( 'options-general.php', 'options-general.php' ); // Settings->General
	remove_submenu_page ( 'options-general.php', 'options-writing.php' ); // Settings->writing
	remove_submenu_page ( 'options-general.php', 'options-reading.php' ); // Settings->Reading
	remove_submenu_page ( 'options-general.php', 'options-discussion.php' ); // Settings->Discussion
	remove_submenu_page ( 'options-general.php', 'options-media.php' ); // Settings->Media
	remove_submenu_page ( 'options-general.php', 'options-privacy.php' ); // Settings->Privacy
}
add_action('admin_menu', 'disableMenuAndSubmenu', 102);