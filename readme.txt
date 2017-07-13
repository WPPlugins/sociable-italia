=== Sociable-Italia ===
Contributors: andreapernici
Donate link: http://yoast.com/donate/
Tags: social, bookmark, bookmarks, bookmarking, social bookmarking, social bookmarks
Requires at least: 2.6
Tested up to: 2.8.4
stable tag: 3.0.7

Automatically add links on your posts, pages and RSS feed to your favorite social bookmarking sites.

== Description ==
Automatically add links to your favorite social bookmarking sites on your posts, pages and in your RSS feed. You can choose from 105 different social bookmarking sites!
Extension of joostdevalk plugin sociable for italian bookmarking sites.

More info:

* More info on [Sociable-italia](http://www.andreapernici.com/wordpress/sociable-italia/), with info on how to add sites to it, and how to integrate it into your WordPress in other ways.
* Check out the other [Wordpress plugins](http://www.andreapernici.com/wordpress/) by the same author, and read his blog: [Andrea](http://www.andreapernici.com).
* More info on [Sociable](http://yoast.com/wordpress/sociable/), the original plugin.
* Example of social bookmarking site [Ghenghe](http://www.ghenghe.com/)

**Changelog**

= 3.0.7 =
* Added Digo, Ziczac, Technotizie, casasocial
* Another fix for the sociableoff dilemma's, no backwards compatibility unfortunately, so disable sociable again on pages where you want to disable it.
* Fixed the bug mentioned [here](http://wordpress.org/support/topic/288487) and [here](http://wordpress.org/support/topic/290753) that made it impossible to disable Sociable on a per post/page basis (for real, now).
* Added a site specific id to each links anchor tag.
* Fixed the bug mentioned [here](http://wordpress.org/support/topic/288487) and [here](http://wordpress.org/support/topic/290753) that made it impossible to disable Sociable on a per post/page basis. 
* "Reintroduced" TwitThis as Twitter.
* Fixed the Sphinn submit link.
* Added the option to add a site to Sociable through a filter, read [How to add a site to Sociable](http://yoast.com/add-sites-to-sociable/).
* Fixed the option to disable Sociable on a per post / page basis.
* More bugfixery.
* Reverted plugin URL fix because of too many people on old WordPress installations complaining. (Upgrade, people, upgrade!)
* Added PHPDoc throughout the plugins code.
* Added a Hyves button.
* Fixed MSN Reporter button.
* Fixed RSS.
* Brought back Tumblr
* Updated PDF link
* Added Posterous
* Smushed all images using [Smush.it](http://smush.it/), reducing the total image file size with 31.72 KB (42.03%)!
* Removed pre - 2.6 compatibility code
* Added new option to use pure text links, instead of image links.
* Fixed small issue with using target=blank links and the new awe.sm options.
* Allowed for usage without an awe.sm API key, as awe.sm falls back to "default" awe.sm shortlinks.
* Code cleanup for more efficiency in the backend on saving options.
* General code cleanup.
* Moved to the new default Changelog markup.
* Added awe.sm integration and some sites.
* Removed the last bit of non jQuery javascript.
* Improved styling and visual feedback when selecting a site.
* Moved style loading to admin_print_styles and scripts to admin_print_scripts.
* Fixed a bug with printing styles in 2.8 beta.
This is a MAJOR update to Sociable. Major Thanks to Jean-Paul of [iPhoneclub](http://www.iphoneclub.nl/) for all his work in looking up all the sites. The full list of changes:

* Restored sociable-admin.js, as it got accidentally removed.
* Added `class="sociablefirst"` to the first site in the list and `class="sociablelast"` to the last one.
* Added:
	* An RSS button, which links to your sites RSS feed
	* Printfriendly.com for both printing and creating a PDF, replacing the original "Print" function, which didn't work from RSS
	* Current
	* FriendFeed
	* MSN Reporter.nl 
	* FS Daily
	* Hello TXT
* Removed the following sites that were no longer working or active:
	* BlinkBits
	* Blogmemes.cn, .net, .jp
	* Blogsvine
	* Book.mark.hu
	* Bumpzee
	* Del.irio.us
	* Feed Me Links
	* Furl (replaced by Diigo)
	* GeenRedactie
	* Kick.ie
	* Leonaut
	* Magnolia
	* Plug IM
	* Pownce
	* Salesmarks
	* Scuttle
	* Shadows
	* Smarking
	* Spurl
	* Taggly
	* Tailrank
	* Tumblr (due to the change to a POST API, which we, unfortunately, can't support with Sociable)
* Updated the following sites to include the excerpt when submitting:
	* Connotea
	* Delicious
	* Digg
	* Ekudos
	* Google Bookmarks
	* NuJij
	* Ping.fm
* Otherwise updated:
	* Google Bookmarks (new icon)
	* Fleck (New URL)
	* Rec6 (new URL)
* Fixed bug with stylesheet introduced in 3.1.
* Converted all images to PNG.
* Cleaned up usage of javascript in the backend and switched to the jquery library that comes with WordPress.
* Allowed for usage of an external image directory.
* Removed pre 2.6 compatibility fixes.
* Fixed xhtml bug in Netvibes integration.
* Added Bitacoras.
* Added Identi.ca.
* Fixed a bug in Yoast Posts widget.
* Added Netvibes.
* Security enhancements, thx to Mark Jaquith.

* 3.0.5 Added TinyUrl feature to Twitter posting
* 3.0.4 Fixed some versioning problem
* 3.0.3 Removed Kipapa
* 3.0.2 Added Italian Social Bookmarks
* 3.0.2 Fixed CSS bug introduced in 3.0
* 3.0.1 Removed some other, now obsolete, code, reducing the code size by another 4KB.
* 3.0 Fixed IE bug in admin. Cleaned up Admin Area and changed support messages. Removed directory checking for all images (speeds up incredibly). Made display: inline !important to prevent vertical icon display. Updated Wykop icon.
* 2.9.15 Added a fallback for strip_shortcodes to maintain backwards compatibility with WordPress 2.3 and below.
* 2.9.14 Make sure there are no tags or shortcodes in the excerpt, added ping.fm, removed indiagram (shut down).
* 2.9.13 Changed Facebook link from sharer.php (meant for a popup window) to share.php (which has the actual menu on it etc.)
* 2.9.12 Added Tip'd
* 2.9.11 Added settings link and Ozh admin menu icon
* 2.9.10 Fixes issue with excerpt not being urlencoded
* 2.9.9 Fixes for the custom fields issue.
* 2.9.8 Fixes for WP 2.7
* 2.9.6 Added Symbaloo, Tumblr,
* 2.9.5 Fixed Fark & Propeller links, added missing i18n strings, added Yahoo Buzz 
* 2.9.4 Removed PopCurrent and Rawsugar as they no longer exist, renamed BlueDot to Faves
* 2.9.3 Added Leonaut, MySpace, fixed plugin description, added option to disable Sociable on a per post basis, added option to display sociable on tag pages, added extra security to config page, fixed print button, fixed Twitter functionality.
* 2.9.2 Added Swedish and Chinese localisations, thx to [Mikael Jorhult](http://www.mishkin.se/) and [Hugo Chen](http://take-ez.com/)
* 2.9.1 Fixed bug where jQuery UI would be loaded twice.
* 2.9 Removed Tool-Man in favor of jQuery, thx to Martin Joosse.
* 2.8.4 Bugfixes.
* 2.8.3 Added wikio.it, upnews.it, muti.co.za, makes LinkedIn work even better, and makes opening in a new window optional
* 2.8.2 Now adds icons to feeds with excerpts too, added LinkedIn
* 2.8.1 Fixed some small issues and made sure tagline shows up again
* 2.8 Added option to show bookmark icons in feed, added Ratimarks, fixed xhtml compliance, fixed blue dot bug
* 2.6.9 Fixed WP 2.6 compatibility
* 2.6.8 Updated documentation
* 2.6.7 Renamed Sk*rt to Kirtsy, Added designfloat, fixed description
* 2.5.4 Added HealthRanker, N4G, Meneame, BarraPunto, Laaik.it and E-mail option
* 2.5.3 Added Global Grind, Salesmarks, Webnews.de, Xerpi, Yigg
* 2.5.2 Added NuJIJ, eKudos, Sk-rt, Socialogs and MisterWong.de
* 2.5.1 Swapped Netscape for Propeller

Special thanks to [Robert Harm](http://www.die-truppe.com/) for coming up with loads of nice ideas.
Special thanks to [Giorgio Taverniti] (http://blog.giorgiotave.it/) for great social-friendly ideas. 

== Installation ==

Download, Upgrading, Installation:

Upgrade

1. First deactivate Sociable-Italia
1. Remove the `sociable-italia` directory

**Install**

1. Unzip the `sociable-italia.zip` file. 
1. Upload the the `sociable-italia` folder (not just the files in it!) to your `wp-contents/plugins` folder. If you're using FTP, use 'binary' mode.

**Activate**

1. In your WordPress administration, go to the Plugins page
1. Activate the Sociable plugin and a subpage for Sociable will appear
   in your Options menu.

If you find any bugs or have any ideas, please mail me.

**Advanced Users**

For advanced use of the plugin, see the [Sociable-Italia](http://www.andreapernici.com/wordpress/sociable-italia/) page on [Andrea](http://www.andreapernici.com/)
