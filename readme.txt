=== Translate ===
Contributors: webdevtsu
Tags: translation, translator, free, website, blog, translate, translate this, google translate, babelfish, promt, freetranslations, freetranslation, gettext, i18n, l10n, localisation, localization, mo, po, productivity
Requires at least: 2.6.0
Tested up to: 4.4.2
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Translator to provide your post content in over 100 languages based on any user's language translation selection. "Translate" by Ackuna.

== Description ==

Allows your users to translate your blog into many different languages. The button is added to the top of every post.

Translate by Ackuna is a free **translation** button provided by [Ackuna Translate](http://ackuna.com/ "free translation service") allowing 
visitors to **translate** your website into 100 languages. Ackuna is powered by Google Translate and combines all its translation 
functionality into one small, easy to use button. Once installed, the button will appear at the top of the individual posts.

Ackuna supports over 100 languages.

Check out this video regarding Ackuna's app translation service:

[youtube http://www.youtube.com/watch?v=G39bPAS-Us4]

Ackuna launched as a platform for free, crowdsourced translation for apps, websites, and software over five years ago, and continues to grow today, with thousands of projects translated and tens of thousands of registered, volunteer translators.
As a means of bridging the gap for webmasters with less technical background, Ackuna has developed the Translate widget as a way to provide website translation fast and easy to install no matter what the skill level, and for bloggers on WordPress, this simple, easy-to-use plugin was created to make the process even more seamless.

And if you have a registered account on Ackuna's sister site, [ConveyThis](http://www.conveythis.com/), you can integrate it with the Translator plugin to provide even faster, better results!

== Installation ==

1. Upload ackuna-language-translation-plugin to the /wp-content/plugins/ directory
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to the settings page and update your blog's language and your button style preferences.
1. If your button does not function, you may want to check the "use valid jQuery" checkbox. (Caution: may cause conflicts with other plugins or themes.)
1. If you are using any caching plugins, such as WP Super Cache, you will need to clear your cached pages after updating your Translate settings.

== Screenshots ==

1. The button on a sample post.
2. The open menu on a sample post.

== Registered Users ==

The plugin works "out of the box" with no additional setup or registrations required, and is totally free.

Although you **do not** need a ConveyThis account or Google Translate API key to use the Translate by Ackuna plugin, registered users with a Google Translate API Key can translate their blog text directly on-page without redirecting through a separate frame.

If you have a registered account on Ackuna's sister site, [ConveyThis](http://www.conveythis.com/), you can enter your username into the plugin's **Settings** page to activate the account benefits on your WordPress blog Be sure your blog URL has been added to the approved domains list in your account settings.

Read more at the [ConveyThis help](http://www.conveythis.com/help.php#8) page.

= How to get a Google Translate API key =

First, make sure you read up on [how to create an API key](https://cloud.google.com/translate/v2/getting_started#setup), as this process can be a bit technical. Don't worry, ConveyThis will handle most of the hard stuff.

When creating an API key, choose the "browser key" option and leave the "accept requests from these HTTP referrers" option blank—your API key will not be visible by third-parties, and you can limit the sites that use the key directly from your ConveyThis account settings.

You will never be charged by **ConveyThis** for this service, but read up on [Google's pricing structure](https://cloud.google.com/translate/v2/pricing) for using their service if you want to incorporate this feature on your blog.

= Test it out first! =

Want to get a feel for how your blog will be translated with a registered ConveyThis account and Google Translate API key?

In the plugin's settings page, check the "try API-powered translation" checkbox and click save to begin your free trial without registering.

If you like what you see, follow the steps above to integrate it fully into your blog.

== Changelog ==

= 4.5.0 =
* Made branding optional.

= 4.4.0 =
* Images and javascript are now loaded directly from the plugins directory, rather than a remote URL.

= 4.3.0 =
* Fixed bug where button script was included in admin pages.
* Added "reset options" page.
* Included an optional free trial for Google API translation.

= 4.2.3 =
* Now supporting over 100 languages.

= 2.0.0 =
* Site language can now be set from the admin panel.
* Button functionality is improved and confirmed working with WordPress 4 blogs.

= 1.3.0 =
* Removed button text from excerpts.

== Upgrade Notice ==

= 4.3.0 =
Translator now includes an optional free trial for Google API translation!

= 4.2.3 =
Now supporting over 100 languages.

== Frequently Asked Questions ==

= When will you be adding support for new languages? =

Since the button uses Google Translate, we have no control of when new languages will be available. Once Google 
does add a new language, we try to add support for that language as quickly as possible.

= Google Translate added a new language, and it's not available through Translate by Ackuna. Why is that? =

When Google Translate adds a new language it is not automatically available through Ackuna. This is because we must make internal changes 
to our plugin script telling it the language is available and how to handle it. Also, we need to add a flag image for that language. We make 
every effort to keep the plugin's available language list as up to date as possible.