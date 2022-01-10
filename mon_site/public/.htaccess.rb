# For a symfony application to work properly, you MUST store this .htaccess in
# the same directory as your front controller, index.php, in a standard symfony
# web application is under the "public" project subdirectory.

# Use the front controller as index file.
DirectoryIndex index.php

# Uncomment the following line if you install assets as symlinks or if you 
# experience problems related to symlinks when compiling LESS/Sass/CoffeScript.
# Options +FollowSymlinks

# Disabling MultiViews prevents unwanted negotiation, e.g. "/index" should not resolve
# to the front controller "/index.php" but be rewritten to "/index.php/index".
<IfModule mod_negotiation.c>
    Options -MultiViews
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On

    # This RewriteRule is used to dynamically discover the RewriteBase path.
    # See https://httpd.apache.org/docs/current/mod/mod_rewrite.html#rewriterule
    # Here we will compare the stripped per-dir path *relative to the filesystem
    # path where the .htaccess file is read from* with the URI of the request.
    # 
    # If a match is found, the prefix path is stored into an ENV var that is later 
    # used to properly prefix the URI of the front controller index.php.
    # This is what makes it possible to host a Symfony application under a subpath,
    # such as example.com/subpath

    # The convoluted rewrite condition means:
    #   1. Match all current URI in the RewriteRule and backreference it using $0
    #   2. Strip the request uri the per-dir path and use ir as REQUEST_URI.
    #      This is documented in https://bit.ly/3zDm3SI ("What is matched?")
    #   3. Evaluate the RewriteCond, assuming your DocumentRoot is /var/www/html,
    #      this .htaccess is in the /var/www/html/public dir and your request URI
    #      is /public/hello/world:
    #      * strip per-dir prefix: /var/www/html/public/hello/world -> hello/world
    #      * applying pattern '.*' to uri 'hello/world'
    #      * RewriteCond: input='/public/hello/world::hello/world' pattern='^(/.+)/(.*)::\\2$' => matched
    #   4. Execute the RewriteRule:
    #      * The %1 in the RewriteRule flag E=BASE:%1 refers to the first group captured in the RewriteCond ^(/.+)/(.*)
    #      * setting env variable 'BASE' to '/public'
    RewriteCond %{REQUEST_URI}::$0 ^(/.+)/(.*)::\2$
    RewriteRule .* - [E=BASE:%1]

    # Sets the HTTP_AUTHORIZATION header removed by Apache
    RewriteCond %{HTTP:Authorization} .+
    RewriteRule ^ - [E=HTTP_AUTHORIZATION:%0]

    # Removes the /index.php/ part from a URL, if present
    RewriteCond %{ENV:REDIRECT_STATUS} =""
    RewriteRule ^index\.php(?:/(.*)|$) %{ENV:BASE}/$1 [R=301,L]

    # If the requested filename exists, simply serve it.
    # Otherwise rewrite all other queries to the front controller.
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ %{ENV:BASE}/index.php [L]
</IfModule>

<IfModule !mod_rewrite.c>
    <IfModule mod_alias.c>
        # When mod_rewrite is not available, we instruct a temporary redirect 
        # to the front controller explicitly so that the website
        RedirectMatch 307 ^/$ /index.php/
    </IfModule>
</IfModule>