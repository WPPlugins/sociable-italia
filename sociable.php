<?php
/*
Plugin Name: Sociable-italia
Plugin URI: http://andreapernici.com/wordpress/sociable-italia/
Description: Automatically add links on your posts, pages and RSS feed to your favorite social bookmarking sites. Go to <a href="options-general.php?page=Sociable-Italia">Settings -> Sociable-Italia</a> for setup. Extend the sociable plugin by Joost de Valk for italian bookmarking sites.
Version: 3.0.7
Author: Andrea Pernici
Author URI: http://www.andreapernici.com/

Copyright 2006 Peter Harkins (ph@malaprop.org)
Copyright 2008 Joost de Valk (joost@joostdevalk.nl)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * Determine the location
 */
$sociablepluginpath = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

/**
 * For backwards compatibility, esc_attr was added in 2.8
 */
if (! function_exists('esc_attr')) {
	function esc_attr( $text ) {
		return attribute_escape( $text );
	}
}

/**
 * This function makes sure Sociable is able to load the different language files from
 * the i18n subfolder of the Sociable directory
 **/
function sociable_init_locale(){
	global $sociablepluginpath;
	load_plugin_textdomain('sociable-italia', false, 'i18n');
}
add_filter('init', 'sociable_init_locale');


/**
 * @global array Contains all sites that Sociable supports, array items have 4 keys:
 * required favicon - the favicon for the site, a 16x16px PNG, to be found in the images subdirectory
 * required url - submit URL of the site, containing at least PERMALINK
 * description - description, used in several spots, but most notably as alt and title text for the link
 * awesm_channel - the channel awe.sm files the traffic under
 */
$sociable_known_sites = Array(
	
	'ghenghe' => Array(
		'favicon' => 'ghenghe.png',
		'url' => 'http://www.ghenghe.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),
	
	'digo' => Array(
		'favicon' => 'digo.png',
		'url' => 'http://www.digo.it/submit?url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),
	
	'casasocial' => Array(
		'favicon' => 'casasocial.png',
		'url' => 'http://www.casasocial.net/submit?url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),
	
	'ziczac' => Array(
		'favicon' => 'ziczac.png',
		'url' => 'http://ziczac.it/a/segnala/?url=PERMALINK',
	),
	
	'technotizie' => Array(
		'favicon' => 'technotizie.png',
		'url' => 'http://www.technotizie.it/posta_news?url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),
	
	'oknotizie' => Array(
		'favicon' => 'oknotizie.png',
		'url' => 'http://oknotizie.alice.it/post?url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),
	
	'tuttoblog' => Array(
		'favicon' => 'tuttoblog.png',
		'url' => 'http://www.tuttoblog.com/submit?url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),
	
	'segnalo' => Array(
		'favicon' => 'segnalo.png',
		'url' => 'http://www.segnalo.com/post.html.php?url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),
	
	'BarraPunto' => Array(
		'favicon' => 'barrapunto.png',
		'url' => 'http://barrapunto.com/submit.pl?subj=TITLE&amp;story=PERMALINK',
	),
	
	'Bitacoras.com' => Array(
		'favicon' => 'bitacoras.png',
		'url' => 'http://bitacoras.com/anotaciones/PERMALINK',
	),
	
	'BlinkList' => Array(
		'favicon' => 'blinklist.png',
		'url' => 'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=PERMALINK&amp;Title=TITLE',
	),

	'BlogMemes Fr' => Array(
		'favicon' => 'blogmemes.png',
		'url' => 'http://www.blogmemes.fr/post.php?url=PERMALINK&amp;title=TITLE',
	),

	'BlogMemes Sp' => Array(
		'favicon' => 'blogmemes.png',
		'url' => 'http://www.blogmemes.com/post.php?url=PERMALINK&amp;title=TITLE',
	),

	'blogmarks' => Array(
		'favicon' => 'blogmarks.png',
		'url' => 'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=PERMALINK&amp;title=TITLE',
	),

	'Blogosphere News' => Array(
		'favicon' => 'blogospherenews.png',
		'url' => 'http://www.blogospherenews.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'blogtercimlap' => Array(
		'favicon' => 'blogter.png',
		'url' => 'http://cimlap.blogter.hu/index.php?action=suggest_link&amp;title=TITLE&amp;url=PERMALINK',
	),

	'Faves' => Array(
		'favicon' => 'bluedot.png',
		'url' => 'http://faves.com/Authoring.aspx?u=PERMALINK&amp;title=TITLE',
	),

	'co.mments' => Array(
		'favicon' => 'co.mments.png',
		'url' => 'http://co.mments.com/track?url=PERMALINK&amp;title=TITLE',
	),

	'connotea' => Array(
		'favicon' => 'connotea.png',
		'url' => 'http://www.connotea.org/addpopup?continue=confirm&amp;uri=PERMALINK&amp;title=TITLE&amp;description=EXCERPT',
	),

	'Current' => Array(
		'favicon' => 'current.png',
		'url' => 'http://current.com/clipper.htm?url=PERMALINK&amp;title=TITLE'
	),
	
	'del.icio.us' => Array(
		'favicon' => 'delicious.png',
		'url' => 'http://delicious.com/post?url=PERMALINK&amp;title=TITLE&amp;notes=EXCERPT',
	),

	'Design Float' => Array(
		'favicon' => 'designfloat.png',
		'url' => 'http://www.designfloat.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'Digg' => Array(
		'favicon' => 'digg.png',
		'url' => 'http://digg.com/submit?phase=2&amp;url=PERMALINK&amp;title=TITLE&amp;bodytext=EXCERPT',
		'description' => 'Digg',
	),

	'Diigo' => Array(
		'favicon' => 'diigo.png',
		'url' => 'http://www.diigo.com/post?url=PERMALINK&amp;title=TITLE',
	),

	'DotNetKicks' => Array(
		'favicon' => 'dotnetkicks.png',
		'url' => 'http://www.dotnetkicks.com/kick/?url=PERMALINK&amp;title=TITLE',
	),

	'DZone' => Array(
		'favicon' => 'dzone.png',
		'url' => 'http://www.dzone.com/links/add.html?url=PERMALINK&amp;title=TITLE',
	),

	'eKudos' => Array(
		'favicon' => 'ekudos.png',
		'url' => 'http://www.ekudos.nl/artikel/nieuw?url=PERMALINK&amp;title=TITLE&amp;desc=EXCERPT',
	),

	'email' => Array(
		'favicon' => 'email_link.png',
		'url' => 'mailto:?subject=TITLE&amp;body=PERMALINK',
		'awesm_channel' => 'mailto',
		'description' => __('E-mail this story to a friend!','sociable'),
	),

	'Facebook' => Array(
		'favicon' => 'facebook.png',
		'awesm_channel' => 'facebook-post',
		'url' => 'http://www.facebook.com/share.php?u=PERMALINK&amp;t=TITLE',
	),

	'Fark' => Array(
		'favicon' => 'fark.png',
		'url' => 'http://cgi.fark.com/cgi/fark/farkit.pl?h=TITLE&amp;u=PERMALINK',
	),

	'Fleck' => Array(
		'favicon' => 'fleck.png',
		'url' => 'http://beta3.fleck.com/bookmarklet.php?url=PERMALINK&amp;title=TITLE',
	),

	'FriendFeed' => Array(
		'favicon' => 'friendfeed.png',
		'url' => 'http://www.friendfeed.com/share?title=TITLE&amp;link=PERMALINK',
	),

	'FSDaily' => Array(
		'favicon' => 'fsdaily.png',
		'url' => 'http://www.fsdaily.com/submit?url=PERMALINK&amp;title=TITLE',
	),

	'Global Grind' => Array (
		'favicon' => 'globalgrind.png',
		'url' => 'http://globalgrind.com/submission/submit.aspx?url=PERMALINK&amp;type=Article&amp;title=TITLE'
	),
	
	'Google' => Array (
		'favicon' => 'googlebookmark.png',
		'url' => 'http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=PERMALINK&amp;title=TITLE&amp;annotation=EXCERPT',
		'description' => 'Google Bookmarks'
	),
	
	'Gwar' => Array(
		'favicon' => 'gwar.png',
		'url' => 'http://www.gwar.pl/DodajGwar.html?u=PERMALINK',
	),

	'HackerNews' => Array(
		'favicon' => 'hackernews.png',
		'url' => 'http://news.ycombinator.com/submitlink?u=PERMALINK&amp;t=TITLE',
	),

	'Haohao' => Array(
		'favicon' => 'haohao.png',
		'url' => 'http://www.haohaoreport.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'HealthRanker' => Array(
		'favicon' => 'healthranker.png',
		'url' => 'http://healthranker.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'HelloTxt' => Array(
        'favicon' => 'hellotxt.png',
        'url' => 'http://hellotxt.com/?status=TITLE+PERMALINK',
    ),

	'Hemidemi' => Array(
		'favicon' => 'hemidemi.png',
		'url' => 'http://www.hemidemi.com/user_bookmark/new?title=TITLE&amp;url=PERMALINK',
	),

	'Hyves' => Array(
		'favicon' => 'hyves.png',
		'url' => 'http://www.hyves.nl/profilemanage/add/tips/?name=TITLE&amp;text=EXCERPT+PERMALINK&amp;rating=5',
	),

	'Identi.ca' => Array(
		'favicon' => 'identica.png',
		'url' => 'http://identi.ca/notice/new?status_textarea=PERMALINK',
	),

	'IndianPad' => Array(
		'favicon' => 'indianpad.png',
		'url' => 'http://www.indianpad.com/submit.php?url=PERMALINK',
	),

	'Internetmedia' => Array(
		'favicon' => 'im.png',
		'url' => 'http://internetmedia.hu/submit.php?url=PERMALINK'
	),

	'Kirtsy' => Array(
		'favicon' => 'kirtsy.png',
		'url' => 'http://www.kirtsy.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'laaik.it' => Array(
		'favicon' => 'laaikit.png',
		'url' => 'http://laaik.it/NewStoryCompact.aspx?uri=PERMALINK&amp;headline=TITLE&amp;cat=5e082fcc-8a3b-47e2-acec-fdf64ff19d12',
	),

	'LinkArena' => Array(
		'favicon' => 'linkarena.png',
		'url' => 'http://linkarena.com/bookmarks/addlink/?url=PERMALINK&amp;title=TITLE',
	),
	
	'LinkaGoGo' => Array(
		'favicon' => 'linkagogo.png',
		'url' => 'http://www.linkagogo.com/go/AddNoPopup?url=PERMALINK&amp;title=TITLE',
	),

	'LinkedIn' => Array(
		'favicon' => 'linkedin.png',
		'url' => 'http://www.linkedin.com/shareArticle?mini=true&amp;url=PERMALINK&amp;title=TITLE&amp;source=BLOGNAME&amp;summary=EXCERPT',
	),

	'Linkter' => Array(
		'favicon' => 'linkter.png',
		'url' => 'http://www.linkter.hu/index.php?action=suggest_link&amp;url=PERMALINK&amp;title=TITLE',
	),
	
	'Live' => Array(
		'favicon' => 'live.png',
		'url' => 'https://favorites.live.com/quickadd.aspx?marklet=1&amp;url=PERMALINK&amp;title=TITLE',
	),

	'Meneame' => Array(
		'favicon' => 'meneame.png',
		'url' => 'http://meneame.net/submit.php?url=PERMALINK',
	),
	
	'MisterWong' => Array(
		'favicon' => 'misterwong.png',
		'url' => 'http://www.mister-wong.com/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=soc',
	),

	'MisterWong.DE' => Array(
		'favicon' => 'misterwong.png',
		'url' => 'http://www.mister-wong.de/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=soc',
	),
	
	'Mixx' => Array(
		'favicon' => 'mixx.png',
		'url' => 'http://www.mixx.com/submit?page_url=PERMALINK&amp;title=TITLE',
	),
	
	'muti' => Array(
		'favicon' => 'muti.png',
		'url' => 'http://www.muti.co.za/submit?url=PERMALINK&amp;title=TITLE',
	),
	
	'MyShare' => Array(
		'favicon' => 'myshare.png',
		'url' => 'http://myshare.url.com.tw/index.php?func=newurl&amp;url=PERMALINK&amp;desc=TITLE',
	),

	'MySpace' => Array(
		'favicon' => 'myspace.png',
		'awesm_channel' => 'myspace',
		'url' => 'http://www.myspace.com/Modules/PostTo/Pages/?u=PERMALINK&amp;t=TITLE',
	),

	'MSNReporter' => Array(
		'favicon' => 'msnreporter.png',
		'url' => 'http://reporter.nl.msn.com/?fn=contribute&amp;Title=TITLE&amp;URL=PERMALINK&amp;cat_id=6&amp;tag_id=31&amp;Remark=EXCERPT',
		'description' => 'MSN Reporter'
	),
	
	'N4G' => Array(
		'favicon' => 'n4g.png',
		'url' => 'http://www.n4g.com/tips.aspx?url=PERMALINK&amp;title=TITLE',
	),
	
	'Netvibes' => Array(
		'favicon' => 'netvibes.png',
		'url' =>	'http://www.netvibes.com/share?title=TITLE&amp;url=PERMALINK',
	),
		
	'NewsVine' => Array(
		'favicon' => 'newsvine.png',
		'url' => 'http://www.newsvine.com/_tools/seed&amp;save?u=PERMALINK&amp;h=TITLE',
	),

	'Netvouz' => Array(
		'favicon' => 'netvouz.png',
		'url' => 'http://www.netvouz.com/action/submitBookmark?url=PERMALINK&amp;title=TITLE&amp;popup=no',
	),

	'NuJIJ' => Array(
		'favicon' => 'nujij.png',
		'url' => 'http://nujij.nl/jij.lynkx?t=TITLE&amp;u=PERMALINK&amp;b=EXCERPT',
	),
	
	'Ping.fm' => Array(
		'favicon' => 'ping.png',
		'awesm_channel' => 'pingfm',
		'url' => 'http://ping.fm/ref/?link=PERMALINK&amp;title=TITLE&amp;body=EXCERPT',
	),

	'Posterous' => Array(
		'favicon' => 'posterous.png',
		'url' => 'http://posterous.com/share?linkto=PERMALINK&amp;title=TITLE&amp;selection=EXCERPT',
	),
	
	'ppnow' => Array(
		'favicon' => 'ppnow.png',
		'url' => 'http://www.ppnow.net/submit.php?url=PERMALINK',
	),
	
	'PDF' => Array(
		'favicon' => 'pdf.png',
		'url' => 'http://www.printfriendly.com/print?url=PERMALINK&amp;partner=sociable',
		'description' => __('Turn this article into a PDF!', 'sociable'),
	),
	
	'Print' => Array(
		'favicon' => 'printfriendly.png',
		'url' => 'http://www.printfriendly.com/print?url=PERMALINK&amp;partner=sociable',
		'description' => __('Print this article!', 'sociable'),
	),
	
	'Propeller' => Array(
		'favicon' => 'propeller.png',
		'url' => 'http://www.propeller.com/submit/?url=PERMALINK',
	),

	'Ratimarks' => Array(
		'favicon' => 'ratimarks.png',
		'url' => 'http://ratimarks.org/bookmarks.php/?action=add&address=PERMALINK&amp;title=TITLE',
	),

	'Rec6' => Array(
		'favicon' => 'rec6.png',
		'url' => 'http://rec6.via6.com/link.php?url=PERMALINK&amp;=TITLE',
	),

	'Reddit' => Array(
		'favicon' => 'reddit.png',
		'url' => 'http://reddit.com/submit?url=PERMALINK&amp;title=TITLE',
	),

	'RSS' => Array(
		'favicon' => 'rss.png',
		'url' => 'FEEDLINK',
	),
	
	'Scoopeo' => Array(
		'favicon' => 'scoopeo.png',
		'url' => 'http://www.scoopeo.com/scoop/new?newurl=PERMALINK&amp;title=TITLE',
	),	

	'Segnalo' => Array(
		'favicon' => 'segnalo.png',
		'url' => 'http://segnalo.alice.it/post.html.php?url=PERMALINK&amp;title=TITLE',
	),

	'Simpy' => Array(
		'favicon' => 'simpy.png',
		'url' => 'http://www.simpy.com/simpy/LinkAdd.do?href=PERMALINK&amp;title=TITLE',
	),

	'Slashdot' => Array(
		'favicon' => 'slashdot.png',
		'url' => 'http://slashdot.org/bookmark.pl?title=TITLE&amp;url=PERMALINK',
	),

	'Socialogs' => Array(
		'favicon' => 'socialogs.png',
		'url' => 'http://socialogs.com/add_story.php?story_url=PERMALINK&amp;story_title=TITLE',
	),
	
	'SphereIt' => Array(
		'favicon' => 'sphere.png',
		'url' => 'http://www.sphere.com/search?q=sphereit:PERMALINK&amp;title=TITLE',
	),

	'Sphinn' => Array(
		'favicon' => 'sphinn.png',
		'url' => 'http://sphinn.com/index.php?c=post&m=submit&link=PERMALINK',
	),

	'StumbleUpon' => Array(
		'favicon' => 'stumbleupon.png',
		'url' => 'http://www.stumbleupon.com/submit?url=PERMALINK&amp;title=TITLE',
	),

	'Symbaloo' => Array(
		'favicon' => 'symbaloo.png',
		'url' => 'http://www.symbaloo.com/nl/add/url=PERMALINK&amp;title=TITLE&amp;icon=http%3A//static01.symbaloo.com/_img/favicon.png',
	),
	
	'Techmeme' => Array( 
		'favicon' => 'techmeme.png',
		'awesm_channel' => 'twitter-techmeme', 
		'url' => 'http://twitter.com/home/?status=tip%20@Techmeme%20PERMALINK%20TITLE', 
		'description' => 'Suggest to Techmeme via Twitter'
	), 

	'Technorati' => Array(
		'favicon' => 'technorati.png',
		'url' => 'http://technorati.com/faves?add=PERMALINK',
	),

	'ThisNext' => Array(
		'favicon' => 'thisnext.png',
		'url' => 'http://www.thisnext.com/pick/new/submit/sociable/?url=PERMALINK&amp;name=TITLE',
	),

	'Tipd' => Array(
		'favicon' => 'tipd.png',
		'url' => 'http://tipd.com/submit.php?url=PERMALINK',
	),
	
	'Tumblr' => Array(
		'favicon' => 'tumblr.png',
		'url' => 'http://www.tumblr.com/share?v=3&amp;u=PERMALINK&amp;t=TITLE&amp;s=EXCERPT',
	),
	
	'TwitThis' => Array(
		'favicon' => 'twitter.png',
		'awesm_channel' => 'twitter',
		'url' => 'http://twitter.com/home?status=TITLE%20-%20PERMALINK',
	),
	
	'Upnews' => Array(
			'favicon' => 'upnews.png',
			'url' => 'http://www.upnews.it/submit?url=PERMALINK&amp;title=TITLE',
	),

	'Twitter' => Array(
		'favicon' => 'twitter.png',
		'awesm_channel' => 'twitter',
		'url' => 'http://twitter.com/home?status=TITLE%20-%20PERMALINK',
	),

	'Upnews' => Array(
			'favicon' => 'upnews.png',
			'url' => 'http://www.upnews.it/submit?url=PERMALINK&amp;title=TITLE',
	),
	
	'Webnews.de' => Array(
        'favicon' => 'webnews.png',
        'url' => 'http://www.webnews.de/einstellen?url=PERMALINK&amp;title=TITLE',
    ),

	'Webride' => Array(
		'favicon' => 'webride.png',
		'url' => 'http://webride.org/discuss/split.php?uri=PERMALINK&amp;title=TITLE',
	),

	'Wikio' => Array(
		'favicon' => 'wikio.png',
		'url' => 'http://www.wikio.com/vote?url=PERMALINK',
	),

	'Wikio FR' => Array(
		'favicon' => 'wikio.png',
		'url' => 'http://www.wikio.fr/vote?url=PERMALINK',
	),

	'Wikio IT' => Array(
		'favicon' => 'wikio.png',
		'url' => 'http://www.wikio.it/vote?url=PERMALINK',
	),
	
	'Wists' => Array(
		'favicon' => 'wists.png',
		'url' => 'http://wists.com/s.php?c=&amp;r=PERMALINK&amp;title=TITLE',
		'class' => 'wists',
	),

	'Wykop' => Array(
		'favicon' => 'wykop.png',
		'url' => 'http://www.wykop.pl/dodaj?url=PERMALINK',
	),

	'Xerpi' => Array(
		'favicon' => 'xerpi.png',
		'url' => 'http://www.xerpi.com/block/add_link_from_extension?url=PERMALINK&amp;title=TITLE',
	),

	'YahooBuzz' => Array(
		'favicon' => 'yahoobuzz.png',
		'url' => 'http://buzz.yahoo.com/submit/?submitUrl=PERMALINK&amp;submitHeadline=TITLE&amp;submitSummary=EXCERPT&amp;submitCategory=science&amp;submitAssetType=text',
		'description' => 'Yahoo! Buzz',
	),
	
	'Yahoo! Bookmarks' => Array(
		'favicon' => 'yahoomyweb.png',
		'url' => 'http://bookmarks.yahoo.com/toolbar/savebm?u=PERMALINK&amp;t=TITLE&opener=bm&amp;ei=UTF-8&amp;d=EXCERPT',
	),

	'Yigg' => Array(
		'favicon' => 'yiggit.png',
		'url' => 'http://yigg.de/neu?exturl=PERMALINK&amp;exttitle=TITLE',
	 ),
);

/**
 * Returns the Sociable links list.
 *
 * @param array $display optional list of links to return in HTML
 * @global $sociable_known_sites array the list of sites that Sociable uses
 * @global $sociablepluginpath string the path to the plugin
 * @global $wp_query object the WordPress query object
 * @return string $html HTML for links list.
 */
function sociable_html($display=array()) {
	global $sociable_known_sites, $sociablepluginpath, $wp_query, $post; 

	if (get_post_meta($post->ID,'_sociableoff',true)) {
		return "";
	}

	/**
	 * Make it possible for other plugins or themes to add buttons to Sociable
	 */
	$sociable_known_sites = apply_filters('sociable_known_sites',$sociable_known_sites);

	$active_sites = get_option('sociable_active_sites');

	// If a path is specified where Sociable should find its images, use that, otherwise, 
	// set the image path to the images subdirectory of the Sociable plugin.
	// Image files need to be png's.
	$imagepath = get_option('sociable_imagedir');
	if ($imagepath == "")
		$imagepath = $sociablepluginpath.'images/';		

	// if no sites are specified, display all active
	// have to check $active_sites has content because WP
	// won't save an empty array as an option
	if (empty($display) and $active_sites)
		$display = $active_sites;
	// if no sites are active, display nothing
	if (empty($display))
		return "";

	// Load the post's and blog's data
	$blogname 	= urlencode(get_bloginfo('name')." ".get_bloginfo('description'));
	$blogrss	= get_bloginfo('rss2_url'); 
	$post 		= $wp_query->post;
	
	// Grab the excerpt, if there is no excerpt, create one
	$excerpt	= urlencode(strip_tags(strip_shortcodes($post->post_excerpt)));
	if ($excerpt == "") {
		$excerpt = urlencode(substr(strip_tags(strip_shortcodes($post->post_content)),0,250));
	}
	// Clean the excerpt for use with links
	$excerpt	= str_replace('+','%20',$excerpt);
	$permalink 	= urlencode(get_permalink($post->ID));
	$title 		= str_replace('+','%20',urlencode($post->post_title));
	
	$rss 		= urlencode(get_bloginfo('ref_url'));

	// Start preparing the output
	$html = "\n<div class=\"sociable\">\n";
	
	// If a tagline is set, display it above the links list
	$tagline = get_option("sociable_tagline");
	if ($tagline != "") {
		$html .= "<div class=\"sociable_tagline\">\n";
		$html .= stripslashes($tagline);
		$html .= "\n</div>";
	}
	
	/**
	 * Start the list of links
	 */
	$html .= "\n<ul>\n";

	$i = 0;
	$totalsites = count($display);
	foreach($display as $sitename) {
		/**
		 * If they specify an unknown or inactive site, ignore it.
		 */
		if (!in_array($sitename, $active_sites))
			continue;

		$site = $sociable_known_sites[$sitename];

		$url = $site['url'];

		/*if ($sitename == 'TwitThis') {
			$twitperma = file_get_contents('http://tinyurl.com/api-create.php?url='.$permalink);
			$url = str_replace('PERMALINK', $twitperma, $url);
		} else {
			$url = str_replace('PERMALINK', $permalink, $url);
			}*/
			
		$url = str_replace('TITLE', $title, $url);
		$url = str_replace('RSS', $rss, $url);
		$url = str_replace('BLOGNAME', $blogname, $url);
		$url = str_replace('EXCERPT', $excerpt, $url);
		$url = str_replace('FEEDLINK', $blogrss, $url);
		
		if (isset($site['description']) && $site['description'] != "") {
			$description = $site['description'];
		} else {
			$description = $sitename;
		}

		if (get_option('sociable_awesmenable') == true &! empty($site['awesm_channel']) ) {
			/**
			 * if awe.sm is enabled and it is an awe.sm supported site, use awe.sm
			 */
			$permalink = str_replace('&', '%2526', $permalink); 
			$destination = str_replace('PERMALINK', 'TARGET', $url);
			$destination = str_replace('&amp;', '%26', $destination);
			$channel = urlencode($site['awesm_channel']);

			$parentargument = '';
			if ($_GET['awesm']) {
				/**
				 * if the page was arrived at through an awe.sm URL, make that the parent
				 */ 
				$parent = $_GET['awesm'];
				$parentargument = '&p=' . $parent;
			} 

			if (strpos($channel, 'direct') != false) {
				$url = $sociablepluginpath.'awesmate.php?c='.$channel.'&t='.$permalink.'&d='.$destination.'&dir=true'.$parentargument;
			} else {
				$url = $sociablepluginpath.'awesmate.php?c='.$channel.'&t='.$permalink.'&d='.$destination.$parentargument;	
			}
		} else {
			/**
			 * if awe.sm is not used, simply replace PERMALINK with $permalink
			 */ 
			$url = str_replace('PERMALINK', $permalink, $url);		
		}

		/**
		 * Start building each list item. They're build up separately to allow filtering by other
		 * plugins.
		 * Give the first and last list item in the list an extra class to allow for cool CSS tricks
		 */
		if ($i == 0) {
			$link = '<li class="sociablefirst">';
		} else if ($totalsites == ($i+1)) {
			$link = '<li class="sociablelast">';
		} else {
			$link = '<li>';
		}
		
		/**
		 * Start building the link, nofollow it to make sure Search engines don't follow it, 
		 * and optionally add target=_blank to open in a new window if that option is set in the 
		 * backend.
		 */
		$link .= '<a rel="nofollow"';
		$link .= ' id="'.esc_attr(strtolower($sitename)).'"';
		if (get_option('sociable_usetargetblank')) {
			$link .= " target=\"_blank\"";
		}
		$link .= " href=\"javascript:window.location='".urlencode($url)."';\" title=\"$description\">";
		
		/**
		 * If the option to use text links is enabled in the backend, display a text link, otherwise, 
		 * display an image.
		 */
		if (get_option('sociable_usetextlinks')) {
			$link .= $description;
		} else {
			if (strpos($site['favicon'], 'http') === 0) {
				$imgsrc = $site['favicon'];
			} else {
				$imgsrc = $imagepath.$site['favicon'];
			}
			$link .= "<img src=\"".$imgsrc."\" title=\"$description\" alt=\"$description\" class=\"sociable-hovers";
			if (isset($site['class']) && $site['class'])
				$link .= " sociable_{$site['class']}";
			$link .= "\" />";
		}
		$link .= "</a></li>";
		
		/**
		 * Add the list item to the output HTML, but allow other plugins to filter the content first.
		 * This is used for instance in the Google Analytics for WordPress plugin to track clicks
		 * on Sociable links.
		 */
		$html .= "\t".apply_filters('sociable_link',$link)."\n";
		$i++;
	}

	$html .= "</ul>\n</div>\n";

	return $html;
}

/**
 * Hook the_content to output html if we should display on any page
 */
$sociable_contitionals = get_option('sociable_conditionals');
if (is_array($sociable_contitionals) and in_array(true, $sociable_contitionals)) {
	add_filter('the_content', 'sociable_display_hook');
	add_filter('the_excerpt', 'sociable_display_hook');
	
	/**
	 * Loop through the settings and check whether Sociable should be outputted.
	 */
	function sociable_display_hook($content='') {
		$conditionals = get_option('sociable_conditionals');
		if ((is_home()     and $conditionals['is_home']) or
		    (is_single()   and $conditionals['is_single']) or
		    (is_page()     and $conditionals['is_page']) or
		    (is_category() and $conditionals['is_category']) or
			(is_tag() 	   and $conditionals['is_tag']) or
		    (is_date()     and $conditionals['is_date']) or
			(is_author()   and $conditionals['is_author']) or
		    (is_search()   and $conditionals['is_search'])) {
			$content .= sociable_html();
		} elseif ((is_feed() and $conditionals['is_feed'])) {
			$sociable_html = sociable_html();
			$sociable_html = strip_tags($sociable_html,"<a><img>");
			$content .= $sociable_html . "<br/><br/>";
		}
		return $content;
	}
}

/**
 * Set the default settings on activation on the plugin.
 */
function sociable_activation_hook() {
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = 'sociableoff'");
	return sociable_restore_config(false);
}
register_activation_hook(__FILE__, 'sociable_activation_hook');

/**
 * Add the Sociable menu to the Settings menu
 * @param boolean $force if set to true, force updates the settings.
 */
function sociable_restore_config($force=false) {
	global $sociable_known_sites;

	if ($force or !is_array(get_option('sociable_active_sites')))
		update_option('sociable_active_sites', array(
			'Print',
			'Ghenghe',
			'Sphinn',
			'del.icio.us',
			'Facebook',
			'Mixx',
			'Google',
		));

	if ($force or !is_string(get_option('sociable_tagline')))
		update_option('sociable_tagline', "<strong>" . __("Share and Enjoy:", 'sociable') . "</strong>");

	if ($force or !is_array(get_option('sociable_conditionals')))
		update_option('sociable_conditionals', array(
			'is_home' => False,
			'is_single' => True,
			'is_page' => True,
			'is_category' => False,
			'is_tag' => False,
			'is_date' => False,
			'is_search' => False,
			'is_author' => False,
			'is_feed' => False,
		));

	if ( $force OR !( get_option('sociable_usecss') ) )
		update_option('sociable_usecss', true);
}

/**
 * Add the Sociable menu to the Settings menu
 */
function sociable_admin_menu() {
	add_options_page('Sociable-Italia', 'Sociable-Italia', 8, 'Sociable-Italia', 'sociable_submenu');
}
add_action('admin_menu', 'sociable_admin_menu');

/**
 * Make sure the required javascript files are loaded in the Sociable backend, and that they are only
 * loaded in the Sociable settings page, and nowhere else.
 */
function sociable_admin_js() {
	if (isset($_GET['page']) && $_GET['page'] == 'Sociable-Italia') {
		global $sociablepluginpath;
		
		wp_enqueue_script('jquery'); 
		wp_enqueue_script('jquery-ui-core',false,array('jquery')); 
		wp_enqueue_script('jquery-ui-sortable',false,array('jquery','jquery-ui-core')); 
		wp_enqueue_script('sociable-js',$sociablepluginpath.'sociable-admin.js', array('jquery','jquery-ui-core','jquery-ui-sortable')); 
	}
}
add_action('admin_print_scripts', 'sociable_admin_js');

/**
 * Make sure the required stylesheet is loaded in the Sociable backend, and that it is only
 * loaded in the Sociable settings page, and nowhere else.
 */
function sociable_admin_css() {
	global $sociablepluginpath;
	if (isset($_GET['page']) && $_GET['page'] == 'Sociable-Italia')
		wp_enqueue_style('sociable-css',$sociablepluginpath.'sociable-admin.css'); 
}
add_action('admin_print_styles', 'sociable_admin_css');

/**
 * If Wists is active, load it's js file. This is the only site that historically has had a JS file
 * in Sociable. For all other sites this has so far been refused.
 */
function sociable_js() {
	if (in_array('Wists', get_option('sociable_active_sites'))) {
		global $sociablepluginpath;
		wp_enqueue_script('sociable-wists',$sociablepluginpath.'wists.js'); 
	}	
}
add_action('wp_print_scripts', 'sociable_js');

/**
 * If the user has the (default) setting of using the Sociable CSS, load it.
 */
function sociable_css() {
	if (get_option('sociable_usecss') == true) {
		global $sociablepluginpath;
		wp_enqueue_style('sociable-front-css',$sociablepluginpath.'sociable.css'); 
	}
}
add_action('wp_print_styles', 'sociable_css');

/**
 * Update message, used in the admin panel to show messages to users.
 */
function sociable_message($message) {
	echo "<div id=\"message\" class=\"updated fade\"><p>$message</p></div>\n";
}

/**
 * Displays a checkbox that allows users to disable Sociable on a
 * per post or page basis.
 */
function sociable_meta() {
	global $post;
	$sociableoff = false;
	if (get_post_meta($post->ID,'_sociableoff',true)) {
		$sociableoff = true;
	} 
	?>
	<input type="checkbox" id="sociableoff" name="sociableoff" <?php checked($sociableoff); ?>/> <label for="sociableoff"><?php _e('Sociable disabled?','sociable') ?></label>
	<?php
}

/**
 * Add the checkbox defined above to post and page edit screens.
 */
function sociable_meta_box() {
	add_meta_box('sociable','Sociable-Italia','sociable_meta','post','side');
	add_meta_box('sociable','Sociable-Italia','sociable_meta','page','side');
}
add_action('admin_menu', 'sociable_meta_box');

/**
 * If the post is inserted, set the appropriate state for the sociable off setting.
 */
function sociable_insert_post($pID) {
	if (isset($_POST['sociableoff'])) {
		if (!get_post_meta($post->ID,'_sociableoff',true))
			add_post_meta($pID, '_sociableoff', true, true);
	} else {
		if (get_post_meta($post->ID,'_sociableoff',true))
			delete_post_meta($pID, '_sociableoff');
	}
}
add_action('wp_insert_post', 'sociable_insert_post');

/**
 * Displays the Sociable admin menu, first section (re)stores the settings.
 */
function sociable_submenu() {
	global $sociable_known_sites, $sociable_date, $sociablepluginpath;

	$sociable_known_sites = apply_filters('sociable_known_sites',$sociable_known_sites);
	
	if (isset($_REQUEST['restore']) && $_REQUEST['restore']) {
		check_admin_referer('sociable-config');
		sociable_restore_config(true);
		sociable_message(__("Restored all settings to defaults.", 'sociable'));
	} else if (isset($_REQUEST['save']) && $_REQUEST['save']) {
		check_admin_referer('sociable-config');
		$active_sites = Array();
		if (!$_REQUEST['active_sites'])
			$_REQUEST['active_sites'] = Array();
		foreach($_REQUEST['active_sites'] as $sitename=>$dummy)
			$active_sites[] = $sitename;
		update_option('sociable_active_sites', $active_sites);
		/**
		 * Have to delete and re-add because update doesn't hit the db for identical arrays
		 * (sorting does not influence associated array equality in PHP)
		 */
		delete_option('sociable_active_sites', $active_sites);
		add_option('sociable_active_sites', $active_sites);

		foreach ( array('usetargetblank', 'awesmenable', 'usecss', 'usetextlinks') as $val ) {
			if ( isset($_POST[$val]) && $_POST[$val] )
				update_option('sociable_'.$val,true);
			else
				update_option('sociable_'.$val,false);
		}
		
		foreach ( array('awesmapikey', 'tagline', 'imagedir') as $val ) {
			if ( !$_POST[$val] )
				update_option( 'sociable_'.$val, '');
			else
				update_option( 'sociable_'.$val, $_POST[$val] );
		}
		
		/**
		 * Update conditional displays
		 */
		$conditionals = Array();
		if (!$_POST['conditionals'])
			$_POST['conditionals'] = Array();
		
		$curconditionals = get_option('sociable_conditionals');
		if (!array_key_exists('is_feed',$curconditionals)) {
			$curconditionals['is_feed'] = false;
		}
		foreach($curconditionals as $condition=>$toggled)
			$conditionals[$condition] = array_key_exists($condition, $_POST['conditionals']);
			
		update_option('sociable_conditionals', $conditionals);

		sociable_message(__("Saved changes.", 'sociable'));
	}
	
	/**
	 * Show active sites first and in the right order.
	 */
	$active_sites = get_option('sociable_active_sites');
	$active = Array(); 
	$disabled = $sociable_known_sites;
	foreach( $active_sites as $sitename ) {
		$active[$sitename] = $disabled[$sitename];
		unset($disabled[$sitename]);
	}
	uksort($disabled, "strnatcasecmp");
	
	/**
	 * Display options.
	 */
?>
<form action="<?php echo attribute_escape( $_SERVER['REQUEST_URI'] ); ?>" method="post">
<?php
	if ( function_exists('wp_nonce_field') )
		wp_nonce_field('sociable-config');
?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php _e("Sociable Options", 'sociable'); ?></h2>
	<table class="form-table">
	<tr>
		<th>
			<?php _e("Sites", "sociable"); ?>:<br/>
			<small><?php _e("Spunta i siti che vuoi appaiano sul tuo sito. Sposta i siti per ordinarli.", 'sociable'); ?></small>
		</th>
		<td>
			<div style="width: 100%; height: 100%">
			<ul id="sociable_site_list">
				<?php foreach (array_merge($active, $disabled) as $sitename=>$site) { ?>
					<li id="<?php echo $sitename; ?>"
						class="sociable_site <?php echo (in_array($sitename, $active_sites)) ? "active" : "inactive"; ?>">
						<input
							type="checkbox"
							id="cb_<?php echo $sitename; ?>"
							name="active_sites[<?php echo $sitename; ?>]"
							<?php echo (in_array($sitename, $active_sites)) ? ' checked="checked"' : ''; ?>
						/>
						<?php
						$imagepath = get_option('sociable_imagedir');
						if ($imagepath == "")
							$imagepath = $sociablepluginpath.'images/';		
						
						if (strpos($site['favicon'], 'http') === 0) {
							$imgsrc = $site['favicon'];
						} else {
							$imgsrc = $imagepath.$site['favicon'];
						}
						?>
						<img src="<?php echo $imgsrc; ?>" width="16" height="16" alt="<?php echo $site['description'] ?>" />
						<?php echo $sitename; ?>
					</li>
				<?php } ?>
			</ul>
			</div>
			<input type="hidden" id="site_order" name="site_order" value="<?php echo join('|', array_keys($sociable_known_sites)) ?>" />
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("Tagline", "sociable"); ?>
		</th>
		<td>
			<?php _e("Cambia il testo che compare davanti alle icone. Per un personalizzazione completa, copia i contenuti di <em>sociable.css</em> nella directory plugin di Sociable nel tuo tema <em>style.css</em> e disabilita l'uso del foglio di stile di sociable-italia sotto.", 'sociable'); ?><br/>
			<input size="80" type="text" name="tagline" value="<?php echo attribute_escape(stripslashes(get_option('sociable_tagline'))); ?>" />
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("Posizione:", "sociable"); ?>
		</th>
		<td>
			<?php _e("Le icone che appaiono alla fine di ogni articolo del blog, e i post possono essere mostrati in diversi tipi di pagine.", 'sociable'); ?><br/>
			<br/>
			<?php
			/**
			 * Load conditions under which Sociable displays
			 */
			$conditionals 	= get_option('sociable_conditionals');
			?>
			<input type="checkbox" name="conditionals[is_home]"<?php checked($conditionals['is_home']); ?> /> <?php _e("Prima Pagina del Blog", 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_single]"<?php checked($conditionals['is_single']); ?> /> <?php _e("Articolo Singolo", 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_page]"<?php checked($conditionals['is_page']); ?> /> <?php _e('Pagina Singola WordPress', 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_category]"<?php checked($conditionals['is_category']); ?> /> <?php _e("Categorie", 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_tag]"<?php checked($conditionals['is_tag']); ?> /> <?php _e("Tag", 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_date]"<?php checked($conditionals['is_date']); ?> /> <?php _e("Archivi", 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_author]"<?php checked($conditionals['is_author']); ?> /> <?php _e("Autori", 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_search]"<?php checked($conditionals['is_search']); ?> /> <?php _e("Ricerca", 'sociable'); ?><br/>
			<input type="checkbox" name="conditionals[is_feed]"<?php checked($conditionals['is_feed']); ?> /> <?php _e("RSS feed", 'sociable'); ?><br/>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("Use CSS:", "sociable"); ?>
		</th>
		<td>
			<input type="checkbox" name="usecss" <?php checked( get_option('sociable_usecss'), true ); ?> /> <?php _e("Vuoi usare il foglio si stile di sociable-italia?", "sociable"); ?>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("Apri in una nuova finestra:", "sociable"); ?>
		</th>
		<td>
			<input type="checkbox" name="usetextlinks" <?php checked( get_option('sociable_usetextlinks'), true ); ?> /> <?php _e("Usa solo testo senza immagini ?", "sociable"); ?>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("Image directory", "sociable"); ?>
		</th>
		<td>
			<?php _e("Sociable viene fornito con una serie di immagini, se vuoi cambiarle puoi rimpiazzarle con quelle che preferisci, se le vuoi sostituire inserisci qui la URL e stai attento a lasciare gli stessi nomi delle immagini di default.", 'sociable'); ?><br/>
			<input size="80" type="text" name="imagedir" value="<?php echo attribute_escape(stripslashes(get_option('sociable_imagedir'))); ?>" />
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("Apri in una nuova finestra:", "sociable"); ?>
		</th>
		<td>
			<input type="checkbox" name="usetargetblank" <?php checked( get_option('sociable_usetargetblank'), true ); ?> /> <?php _e("Use <code>target=_blank</code> on links? (Forces links to open a new window)", "sociable"); ?>
		</td>		
	</tr>
	<tr>
		<th scope="row" valign="top">
			<?php _e("awe.sm:", "sociable"); ?>
		</th>
		<td>
			<?php _e("Puoi scegliere di avere i link che posti automaticamente accorciati via awe.sm e codificati sulla base del tuo canale e della tua chiave API.", 'sociable'); ?><br/>
			<input type="checkbox" name="awesmenable" <?php checked( get_option('sociable_awesmenable'), true ); ?> /> <?php _e("Abilita awe.sm URLs?", "sociable"); ?><br/>
			<?php _e("awe.sm API Key:", 'sociable'); ?> <input size="65" type="text" name="awesmapikey" value="<?php echo get_option('sociable_awesmapikey'); ?>" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<span class="submit"><input name="save" value="<?php _e("Salva cambiamenti", 'sociable'); ?>" type="submit" /></span>
			<span class="submit"><input name="restore" value="<?php _e("Ripristina i settaggi di default", 'sociable'); ?>" type="submit"/></span>
		</td>
	</tr>
</table>

<h2>Ti piace questo plugin?</h2>
<p><?php _e('Perch&egrave; non fare una delle seguenti cose:','sociable'); ?></p>
<ul class="sociablemenu">
	<li><?php _e('Linkare il plugin in modo che altre persone possano trovare informazioni su di esso.','sociable'); ?></li>
	<li><?php _e('<a href="http://wordpress.org/extend/plugins/sociable-italia/">Dare un bel voto</a> su WordPress.org.','sociable'); ?></li>
	<li><?php _e('<a href="http://www.ghenghe.com/">Usare Ghenghe</a> nel tuo blog,sito o browser.','sociable'); ?></li>
</ul>
<h2>Hai bisogno di supporto?</h2>
<p><?php _e(' Se hai qualche problema o buona idea, perfavore parlane nel <a href="http://wordpress.org/tags/sociable-italia">Forum di Supporto</a>.', 'sociable'); ?></p>

<h2>Credits</h2>
<p><?php _e('<a href="http://yoast.com/wordpress/sociable/">Sociable</a> &egrave; stato originariamente sviluppato da <a href="http://push.cx/">Peter Harkins</a> e &egrave; stato mantenuto da <a href="http://yoast.com/">Joost de Valk</a> fino all\'inizio del 2008. E\' rilasciato sotto la licenza GNU GPL versione 2.','Sociable'); ?></p>

</div>
</form>
<?php
}

/**
 * Add an icon for the Sociable plugin's settings page to the dropdown for Ozh's admin dropdown menu
 */
function sociable_add_ozh_adminmenu_icon( $hook ) {
	static $sociableicon;
	if (!$sociableicon) {
		$sociableicon = WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)). '/book_add.png';
	}
	if ($hook == 'Sociable') return $sociableicon;
	return $hook;
}
add_filter( 'ozh_adminmenu_icon', 'sociable_add_ozh_adminmenu_icon' );				

/**
 * Add a settings link to the Plugins page, so people can go straight from the plugin page to the
 * settings page.
 */
function sociable_filter_plugin_actions( $links, $file ){
	// Static so we don't call plugin_basename on every plugin row.
	static $this_plugin;
	if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);
	
	if ( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=Sociable-Italia">' . __('Settings') . '</a>';
		array_unshift( $links, $settings_link ); // before other links
	}
	return $links;
}
add_filter( 'plugin_action_links', 'sociable_filter_plugin_actions', 10, 2 );

/**
 * Add the Yoast.com RSS feed to the WordPress dashboard
 */
if (!function_exists('yst_db_widget')) {
	function yst_text_limit( $text, $limit, $finish = ' [&hellip;]') {
		if( strlen( $text ) > $limit ) {
	    	$text = substr( $text, 0, $limit );
			$text = substr( $text, 0, - ( strlen( strrchr( $text,' ') ) ) );
			$text .= $finish;
		}
		return $text;
	}
	
	function yst_db_widget($image = 'normal', $num = 3, $excerptsize = 250, $showdate = true) {
		require_once(ABSPATH.WPINC.'/rss.php');  
		if ( $rss = fetch_rss( 'http://feeds2.feedburner.com/joostdevalk' ) ) {
			echo '<div class="rss-widget">';
			if ($image == 'normal') {
				echo '<a href="http://yoast.com/" title="Go to Yoast.com"><img src="http://cdn.yoast.com/yoast-logo-rss.png" class="alignright" alt="Yoast"/></a>';			
			} else {
				echo '<a href="http://yoast.com/" title="Go to Yoast.com"><img width="80" src="http://cdn.yoast.com/yoast-logo-rss.png" class="alignright" alt="Yoast"/></a>';			
			}
			echo '<ul>';
			$rss->items = array_slice( $rss->items, 0, $num );
			foreach ( (array) $rss->items as $item ) {
				echo '<li>';
				echo '<a class="rsswidget" href="'.clean_url( $item['link'], $protocolls=null, 'display' ).'">'. htmlentities($item['title']) .'</a> ';
				if ($showdate)
					echo '<span class="rss-date">'. date('F j, Y', strtotime($item['pubdate'])) .'</span>';
				echo '<div class="rssSummary">'. yst_text_limit($item['summary'],$excerptsize) .'</div>';
				echo '</li>';
			}
			echo '</ul>';
			echo '<div style="border-top: 1px solid #ddd; padding-top: 10px; text-align:center;">';
			echo '<a href="http://feeds2.feedburner.com/joostdevalk"><img src="'.get_bloginfo('wpurl').'/wp-includes/images/rss.png" alt=""/> Subscribe with RSS</a>';
			if ($image == 'normal') {
				echo ' &nbsp; &nbsp; &nbsp; ';
			} else {
				echo '<br/>';
			}
			echo '<a href="http://yoast.com/email-blog-updates/"><img src="http://cdn.yoast.com/email_sub.png" alt=""/> Subscribe by email</a>';
			echo '</div>';
			echo '</div>';
		}
	}
 
	function yst_widget_setup() {
	    wp_add_dashboard_widget( 'yst_db_widget' , 'The Latest news from Yoast' , 'yst_db_widget');
	}
 
	add_action('wp_dashboard_setup', 'yst_widget_setup');
}
?>