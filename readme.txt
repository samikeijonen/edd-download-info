=== EDD Download Info ===
Contributors: sami.keijonen
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=E65RCFVD3QGYU
Tags: EDD, download, downloads, add-on, digital, easy 
Requires at least: 3.4
Tested up to: 3.6
Stable tag: 0.1.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds download features and widgets for Easy Digital Download plugin.

== Description ==

EDD Download Info is add-on plugin for [Easy Digital Downloads](http://wordpress.org/extend/plugins/easy-digital-downloads/) plugin. You need to install
that first.

= Plugin Features =

This plugin is mainly for WordPress Themes and Plugins shop with some added features.

1. Adds metabox where you can add URL for your demo, document and support site. There is also updated date because this is not normally same as updated date of your download 'post'.
1. Adds download features (custom taxonomy).
1. Adds two widgets. One widget is for showing download info like purchase link, demo, document and support site links, version number, download count and updated date. 
And another widget is for download features.
1. Adds shortcode for "Free Download" button. This is for downloads which you want to give away free and host in wordpress.org for example, but still have them on your site as a download.

= Widgets usage =

Under Appearance >> Widgets you can find two widgets: Download Features and Download Info.

Using Download Features is easy. Just drag it into a widget area and write title. You can also check whether to use links or not in features.

In Download Info widget you get version number, download count, updated date, demo, support and documentation link.

1. Version number comes from EDD version or EDD Software Licence Plugin.
1. Download count comes from EDD `edd_get_download_sales_stats` function.
1. You can set demo link to show as button and you can change default demo link style under Downloads >> Settings >> Styles.
1. You can set demo, support and documentation link and updated date when you're editing download. There is metabox Download Info on the right.
1. You can also show purchase link in button and open link in a new window.

= Shortcode usage =

This plugin register shortcode `[edd_download_info_link]`. This gives you download button with custom link. There are couple of attributes in this shortcode.

1. url: you definitely want to use this because default url link is empty. This is the url you want go when you click this button. 
1. open: By default link opens in new window. If you set attribute to no, link opens in the same window.
1. text: default text is Download.
1. style: default style is button.
1. color: default style is blue or what you have set under Downloads >> Settings >> Styles for Default button color.
1. class: default is edd-submit.

Example usage.

`
[edd_download_info_link text="Download Free" url="http://wordpress.org/extend/plugins/edd-download-info" color="gray" open="no"]
`

== Installation ==

1. Upload `edd-download-info` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Why was this plugin created? =

I needed this feature and someone else might need it too.

== Screenshots ==

1. Download Info
2. Download Features
3. Download Info Widget
4. Download Features Widget

== Changelog ==

= 0.1.7 =

* Update demo link color setting.

= 0.1.6 =

* Changelog link added in metabox.
* Language files updated.
* Taxonomy download feature register fire at priority 0. It was having 404 page.

= 0.1.5.2 =

* Repository link added in metabox. This is useful for free products.
* Language files updated.

= 0.1.5.1 =

* Add div around purchase and demo link so that themes can use style them more easily.

= 0.1.5 =

* Add purchase and demo link functions what themes can use.
* You can now put translation files also to `/wp-content/languages/edd-download-info` folder. This is the same idea and code
what is used in Easy Digital Download Plugin.

= 0.1.4 =

* Add $slug variable in case EDD_SLUG has been changed. Thanks to @sumobi.

= 0.1.3 =
* Added option to show or not to show download count.

= 0.1.2 =
* Datepicker styles fixed.

= 0.1.1 =
* Language files updated.

= 0.1 =
* Everything's brand new.