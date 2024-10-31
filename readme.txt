=== Passle Embedded Posts Plugin ===
 
Contributors: PassleMe
Tags: passle, blog, blogging, embedded blog, embedded posts, embedded passle blog, embed passle, bookmarklet, micro-blog, social media 
Requires at least: 2.8.0
Tested up to: 4.1
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Passle is an easy to use content platform for knowledge businesses. This plugin allows embedding a number of Passle posts into a WordPress site.
 
== Description ==
 
What is Passle?
 
Passle is a simple and effective way to get all the highly knowledgeable but time poor professionals in an organisation to create content for your on-line presence.
 
By using a Chrome extension or Bookmarklet embedded in your browser (which takes 2 or 3 seconds), you and your colleagues can create engaging posts in 5 or so minutes rather than 3 or 4 hours.
 
How to use Passle?
 
1. Capture the Key Point of an article by highlighting a piece of text, image or video.
2. Hit the Passle button (extension or bookmarklet).
3. Comment with your own (expert) viewpoint, then select an image and give your post a title.
4. Add perspective by choosing tweets to go alongside.
5. And that's your post done.
 
Now you can use the in-built tools to feed your Twitter, Facebook, LinkedIn and Google+ presences.
 
What does Passle Embedded Posts Plugin do?
 
The Passle Embedded Posts Plugin allows you embed a chosen number of posts into any container in the page of your WordPress website using the signature Passle grid layout. The layout is responsive and will adjust itself to the size of any container.
 
== Installation ==
 
1. Upload the `passle-embedded-posts` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. To display the Passle Posts on your site, add this shortcode to the chosen page, post or section:
[passle key="xxxx" number_of_posts="y"]
Replace 'xxxx' with your Passle shortcode ID which could be found in your Passle account. To find the short code go to: 
Passle menu > Settings > Display this Passle on your website > Integrate this Passle with your Wordpress site. You can then adjust the number of posts you want to display to suit your layout by replacing 'y' with the number of posts you wish to display.
4. Update the changes to your WordPress post or page.

Please NOTE: for this plugin to work, you will need to include jQuery (version 1.8.3 or higher) on your WordPress site.
 
== Frequently Asked Questions ==
 
How do I find the Page ID of my Passle blog?
 
Log into your Passle Account. Go to the chosen Passle > Settings. You will find your shortcode ID in the `Display this Passle on your website > Integrate this Passle with your Wordpress site` section. It will consist of minimum 4 characters, e.g. 29ha.
 
Can I display multiple Passle blogs on my site?
 
Not in the same container, you would need to create two separate pages / containers with 2 unique shortcode IDs.

How can I edit the styles of my feed? 

The styles of the post boxes in the grid view can be set up in your Passle account. Please refer to Passle menu > Customise > Style tab. Page background colour is inherited from your WordPress website styles. 

If you need to overwrite Passle default styles as specified above, refer to css/front-end.css stylesheet located in the plugin folder, where you can apply further changes to font styles (e.g. font face and font sizes) in the grid view. 
 
Can I display the posts from a Passle Private Group?
 
Not at the moment. The Private Group is private for a reason!
 
== Screenshots ==
 
1. An example of Passle posts integrated as a full page layout in a Wordpress website.
 
2. An example of Passle posts integrated in a container in a Wordpress website. 
 
3. The way to embed your Passle posts into a page in the Admin interface using the shortcode provided in the Passle menu settings.

== Changelog ==

= v 0.3 =
* A stylesheet file has been added to unable users to overwrite Passle default font styling.



