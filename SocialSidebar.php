<?php
/**
 * MediaWiki extension to add a social sidebar in a portlet in the sidebar.
 * Installation instructions can be found on
 * https://www.mediawiki.org/wiki/Extension:Social_Sidebar
 *
 * This extension will not add the Social Sidebar portlet to *any* skin
 * that is used with MediaWiki. Because of inconsistencies in the skin
 * implementation, it will not be add to the following skins:
 * cologneblue, standard, nostalgia
 *
 * @addtogroup Extensions
 * @author Joachim De Schrijver
 * @license LGPL
 *
 * Social Sidebar
 */

/**
 * Exit if called outside of MediaWiki
 */
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
 * SETTINGS
 * --------
 * The description of the portlet can be changed in [[MediaWiki:Socialsidebar]].
 *.
 * Variables should be set in the LocalSettings.php
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'Social Sidebar',
	'version'        => '0.2',
	'author'         => '[https://www.mediawiki.org/wiki/User:Joa_ds Joachim De Schrijver]',
	'description'    => 'Adds [https://www.twitter.com Twitter] and [https://www.facebook.com Facebook] links to the sidebar',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Social_Sidebar',
); 


$wgTwitter			= "";
$wgTwitterLocale	= "en_US";				// Get value from		


$wgFacebook			= "";
$wgFacebookLocale 	= "en_US";				// Get value from		https://www.facebook.com/translations/FacebookLocales.xml
$wgFacebookLikeStyle= "button_count";		// Can be: standard, button_count, and box_count.

// Hook to modify the sidebar
$wgHooks['SkinBuildSidebar'][] = 'SocialSidebar::FacebookTwitter';

// Class & Functions
class SocialSidebar {
	static function FacebookTwitter(&$bar ) {
		global $wgFacebook, $wgFacebookLocale, $wgFacebookLikeStyle;
		global $wgTwitter, $wgTwitterLocale;
		
		if ($wgFacebook != "")
			$bar['socialsidebar']  = '<iframe src="http://www.facebook.com/plugins/like.php?app_id=150743178336313&amp;locale='.$wgFacebookLocale.'&amp;href='.rawurlencode($wgFacebook).'&amp;send=false&amp;layout='.$wgFacebookLikeStyle.'&amp;width=135&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:135px; height:21px;" allowTransparency="true"></iframe>';
		if ($wgTwitter != "")
			$bar['socialsidebar'] .= '<a href="http://twitter.com/'.$wgTwitter.'" class="twitter-follow-button" data-show-count="false">Follow @'.$wgTwitter.'</a><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>';
		return true;
	}
	
	static function GooglePlus(&$bar
}