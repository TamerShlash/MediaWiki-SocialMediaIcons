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
if (!defined('MEDIAWIKI')) {
        echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
        die(1);
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

/* Default Twitter Settings, for more details visit https://dev.twitter.com/docs/follow-button */
$wgTwitter              = "";  // The Username, for example, "mediawiki" for https://twitter.com/mediawiki
$wgTwitterLocale        = "en";  // Two letter code from http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
$wgTwitterShowCount     = "false";  // true or false, false by default
$wgTwitterShowScreenName= "true";      // true or false, true by default
$wgTwitterOptOut        = "false";  // boolean
$wgTwitterAlignment     = "left";       // left or right
$wgTwitterSize          = "medium";       // "medium" and "large", medium is the default
$wgTwitterWidth         = "";  // can be in pixels, e.g: "300px", or in percentage, e.g: "120%"
/* End of Twitter Settings */

/* Facebook Settings */
$wgFacebook             = "https://facebook.com/wikilogia"; // The Complete Facebook Page URL
$wgFacebookLocale       = "en_US";  // Get value from https://www.facebook.com/translations/FacebookLocales.xml
$wgFacebookLikeStyle    = "button_count";  // Possible values: standard, button_count, and box_count.
/* End of Facebook Settings */

// Hook to modify the sidebar
$wgHooks['SkinBuildSidebar'][] = 'SocialSideBar::Builder';

// Class & Functions
class SocialSidebar {        
        static function Builder($skin, &$bar) {
                global $wgFacebook, $wgFacebookLocale, $wgFacebookLikeStyle;
                global $wgTwitter, $wgTwitterLocale;
                
                if ($wgFacebook != "")
                        $bar['socialsidebar']  = '<iframe src="http://www.facebook.com/plugins/like.php?app_id=150743178336313&amp;locale='
                        .$wgFacebookLocale
                        .'&amp;href='.rawurlencode($wgFacebook)
                        .'&amp;send=false&amp;layout='.$wgFacebookLikeStyle
                        .'&amp;width=135&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:135px; height:21px;" allowTransparency="true"></iframe>';
                $bar['socialsidebar'] .= SocialSidebar::TwitterBuilder();
                return true;
        }

        static function TwitterBuilder() {
                global $wgTwitter, $wgTwitterLocale, $wgTwitterSize, $wgTwitterAlignment,
                       $wgTwitterWidth, $wgTwitterShowCount, $wgTwitterShowScreenName, $wgTwitterOptOut;
                if ($wgTwitter == '')
                        return '';
                $result = '<a href="https://twitter.com/'.$wgTwitter.'" class="twitter-follow-button" '
                        . 'data-show-screen-name="'.$wgTwitterShowScreenName.'" '
                        . 'data-show-count="'.$wgTwitterShowCount.'" '
                        . 'data-lang="'.$wgTwitterLocale.'" '
                        . 'data-dnt="'.$wgTwitterOptOut.'" '
                        . 'data-align="'.$wgTwitterAlignment.'" '
                        . 'data-size="'.$wgTwitterSize.'" '
                        . (($wgTwitterWidth=='')?'':'data-width="'.$wgTwitterWidth.'" ')
                        .'>Follow @'.$wgTwitter.'</a>'
                        .'<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>'
                        ;
                return $result;
        }

        static function GooglePlus(&$bar) {

        }

}