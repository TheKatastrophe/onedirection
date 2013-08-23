# onedirection #
This is a PHP script which allows you to anonymously link to articles you have posted on your other social networks/sites, without allowing access to the entire profile.

For example, you can link to a post you have made on your Tumblr from a Tweet, but your Twitter followers will not (easily) be able to use that to get to the rest of your Tumblr posts.

## Caveats ##
This is not perfect, and doesn't account for the human factor. For example, if you link to other posts of yours from a post, then those links (at the moment) will not be rewritten, and will expose your blog. Similarly, if you use your username in a tag in a post, it will not detect this, so use with caution.

## Use ##
In the settings.php file, there are several configuration directives.

### Base URL ###
$URLbase is a string that specifies the base of the URL rewrite. If you intend to link to posts by using URLs like you.com/**social**/tumblr/12345 or you.com/**social**/twitter/12345, then the URLbase would be '/social/'. Later, you will have to make a rewrite rule for your webserver that reflects this. You can leave it blank, and use URLs like you.com/twitter/12345, but remember this will require a different rewrite rule.

### HTML Template ###
$template is a string that specifies the (relative) filename of the HTML template HTML file used to render the posts - the default is 'template.htm'.

The HTML file can be anything you like as long as it's a valid HTML file. The title of the post, if there is one, will be placed in the first element in the page with the ID '1d-title', and the post content will be placed in the first element in the page with the ID '1d-body'.

### Social Networks ###
$networks allows you to configure the links to your social networking accounts. This is an array of accounts containing arrays of settings, keyed by the name - this name can be anything, but should be URL-friendly, because it is used in generating the links. For example, you might want to call your tumblr account 'tumblr', which would generate links like you.com/social/**tumblr**/12345. Alternatively, you could also call it 'blog' which would generate a link like you.com/social/**blog**/12345.

Each of these names is the key to a settings array, containing two parameters. First, the "url", which is a string containing the base URL for your account - for Tumblr, this would be "you.tumblr.com" (or "yourtumblr.com" if you use your own domain). For a Twitter account, it would be "twitter.com/you".

Secondly, there is a "type" parameter that can be one of two things: "twitter", or "tumblr". This type decides how to format the URL to fetch your posts, and then how to get the content of the post out of the page. It also contains rules on how to sanitise the post of some sensitive information which could be an issue, and defines styling for the different types of posts. You can have multiple accounts of each type defined, as many as you like - as long as they all have different names!

The finished array should look like:

    $networks = array(
    	"my-blog" => array(
     		"url" => "http://you.tumblr.com",
    		"type" => "tumblr"
    	),
    	"twitter" => array(
    		"url" => "http://twitter.com/you",
    		"type" => "twitter"
    	),
    	"other-twitter" => array(
    		"url" => "http://twitter.com/you2",
    		"type" => "twitter"
     	)
    );

With this configurations, assuming the domain 'you.com' and $URLbase = "/social/" as before, your posts could be linked to as follows:

- Post 2432843 on you.tumblr.com: http://you.com/social/my-blog/2432843
- Post 32934848227332 on the Twitter account @you: http://you.com/social/twitter/32934848227332
- Post 39482347717636 on the Twitter account @you2: http://you.com/social/other-twitter/39482347717636

### Rewrite Rules ###
Included is a .htaccess with the basic rewrite rules required to use this. It is configured with a URL base of "/social/", but you can change this as needed. A lighttpd rule to match would be:

        url.rewrite-once = (
                "^/social/(.*)" => "/path/to/onedirection/index.php"
        )

## Done! ##
That's all there is to it really. I'm planning to add some more types of social networks and blogging platforms as I pick apart the DOMs they generate, and expand it's use. I want to do some better content santising, and maybe clean up the default template I've included with it. The one I've included uses Bootstrap 3 off of the NetDNA CDN, so it may break if Bootstrap 3 gets updated and I don't notice.

This is open-source, on the free culture compatible Creative Commons Attribution-ShareAlike 2.0 UK: England & Wales License. ([http://creativecommons.org/licenses/by-sa/2.0/uk/deed.en_GB](http://creativecommons.org/licenses/by-sa/2.0/uk/deed.en_GB))

If you like it, consider hosting it with CCPG Solutions: [http://ccpg.co.uk](http://ccpg.co.uk)

~ Kay (cmantito), http://kaycl.co.uk // CCPG Solutions: http://ccpg.co.uk
