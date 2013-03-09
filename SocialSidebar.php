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
    'name'           => 'SocialMediaIcons',
    'version'        => '0.1',
    'author'         => '[https://github.com/TamerShlash Tamer Shlash]',
    'description'    => 'Adds custom [https://www.twitter.com Twitter] and [https://www.facebook.com Facebook] links to the sidebar, fork of [https://www.mediawiki.org/wiki/User:Joa_ds Joachim De Schrijver\'s] [https://www.mediawiki.org/wiki/Extension:Social_Sidebar Social Sidebar]',
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
$wgTwitterWidth         = "";  // can be in pixels, e.g: "160px", or in percentage, e.g: "100%"
/* End of Twitter Settings */

/* Default Facebook Settings, for more details visit https://developers.facebook.com/docs/reference/plugins/like/ */
$wgFacebook             = ""; // The Complete Facebook Page URL
$wgFacebookSend         = "false";  // true or false
$wgFacebookFaces        = "false";  // true or false
$wgFacebookAction       = "like";   // "like" or "recommend"
$wgFacebookFont         = "arial";  // Possible values: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
$wgFacebookWidth        = "";
$wgFacebookColor        = "light";  // "light" or "dark"
$wgFacebookLayout       = "button_count";  // Possible values: standard, button_count, and box_count.
/* End of Facebook Settings */

/* Default Google+ Settings */
$wgGoogle               = "http://wikilogia.org"; // The URL to +1
$wgGoogleLang           = "en-US";  // https://developers.google.com/+/web/+1button/#available-languages
$wgGoogleSize           = "medium";  // small, medium, standard, tall
$wgGoogleAnnotation     = "bubble";  // none, bubble, inline
$wgGoogleWidth          = "";
$wgGoogleAlign          = "left";  // left or right
$wgGoogleRecommendations= "true";  // true or false
/* End of Google+ Settings */

// Hook to modify the sidebar
$wgHooks['SkinBuildSidebar'][] = 'SocialSideBar::Builder';

// Class & Functions
class SocialSidebar {        
    static function Builder($skin, &$bar) {

        global $wgFacebook, $wgTwitter, $wgGoogle;

        if (($wgFacebook . $wgTwitter . $wgGoogle) == '')
            return false;
        $bar['socialsidebar'] = SocialSidebar::FacebookBuilder();
        $bar['socialsidebar'] .= SocialSidebar::TwitterBuilder();
        $bar['socialsidebar'] .= SocialSidebar::GooglePlusBuilder();
        return true;
    }

    static function TwitterBuilder() {

        global $wgTwitter, $wgTwitterLocale, $wgTwitterSize, $wgTwitterAlignment,
        $wgTwitterWidth, $wgTwitterShowCount, $wgTwitterShowScreenName, $wgTwitterOptOut;

        if ($wgTwitter == '')
            return '';

        $result = '<div><a href="https://twitter.com/'.$wgTwitter.'" class="twitter-follow-button" '
                . 'data-show-screen-name="'.$wgTwitterShowScreenName.'" '
                . 'data-show-count="'.$wgTwitterShowCount.'" '
                . 'data-lang="'.$wgTwitterLocale.'" '
                . 'data-dnt="'.$wgTwitterOptOut.'" '
                . 'data-align="'.$wgTwitterAlignment.'" '
                . 'data-size="'.$wgTwitterSize.'" '
                . (($wgTwitterWidth=='')?'':'data-width="'.$wgTwitterWidth.'" ')
                . '>Follow @'.$wgTwitter.'</a>'
                . '<script>!function(d, s, id) {
                    var js,fjs=d.getElementsByTagName(s)[0];
                    if(!d.getElementById(id)) {
                    js=d.createElement(s);
                    js.id=id;
                    js.src="https://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js,fjs);
                    }
                    }(document,"script","twitter-wjs");</script>'
                .'</div>';
        return $result;
    }

    static function FacebookBuilder() {

        global $wgFacebook, $wgFacebookSend, $wgFacebookFaces, $wgFacebookAction,
        $wgFacebookFont, $wgFacebookWidth, $wgFacebookColor, $wgFacebookLayout;

        if ($wgFacebook == '')
            return '';

        $result = '<div id="fb-root"></div>
                    <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                    }(document, \'script\', \'facebook-jssdk\'));</script>'
                . '<div class="fb-like" data-href="'.$wgFacebook.'" '
                . 'data-send="'.$wgFacebookSend.'" '
                . 'data-show-faces="'.$wgFacebookFaces.'" '
                . 'data-action="'.$wgFacebookAction.'" '
                . 'data-font="'.$wgFacebookFont.'" '
                . 'data-colorscheme="'.$wgFacebookColor.'" '
                . 'data-layout="'.$wgFacebookLayout.'" '
                . (($wgFacebookWidth=='')?'':'data-width="'.$wgFacebookWidth.'" ')
                . '></div>';
        return $result;
    }

    static function GooglePlusBuilder() {

        global $wgGoogle, $wgGoogleLang, $wgGoogleSize, $wgGoogleAnnotation, $wgGoogleSize,
               $wgGoogleWidth, $wgGoogleAlign, $wgGoogleRecommendations;

        if ($wgGoogle == '')
            return '';

        $result = '<div class="g-plusone" data-href="'.$wgGoogle.'" '
                . 'data-size="'.$wgGoogleSize.'" '
                . 'data-align="'.$wgGoogleAlign.'" '
                . 'data-annotation="'.$wgGoogleAnnotation.'" '
                . 'data-recommendations="'.$wgGoogleRecommendations.'" '
                . (($wgGoogleWidth=='')?'':'data-width="'.$wgGoogleWidth.'" ')
                . '></div>'
                . '<script type="text/javascript">
                    window.___gcfg = {lang: \''.$wgGoogleLang.'\'};
                    (function() {
                        var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
                        po.src = \'https://apis.google.com/js/plusone.js\';
                        var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
                    })();
                   </script>';
        return $result;
    }

}