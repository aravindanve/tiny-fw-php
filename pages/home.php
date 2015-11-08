<?php defined('APPPATH') or die('No script access'); ?>
<div class="normal-page">
    <h1>Welcome to <span class="logo">TinyFW <span>2</span></span></h1>
    <div class="quote">Quickly whip up a small static website in no time.</div>
    <p>
        TinyFW is a simple and flexible framework for deploying small static websites.
        It also provides basic page routing and functionalities such as templates
        and partials. You can download it here: <a href="https://github.com/aravindanve/tiny-fw/archive/master.zip">Get TinyFW</a>
    </p>
    <h2>SETUP</h2>
    <p>
        This framework requires <span class="code">Apache</span> with 
        <span class="code">mod_rewrite</span> enabled.
    </p>
<pre><code class="bash"># enable mod_rewrite in bash
a2enmod rewrite

# restart apache
service apache2 restart</code></pre>
    <p>
        And if the routing doesnt work properly, create an apache directive in your
        <span class="code">apache2.conf</span> or <span class="code">httpd.conf</span>
    </p>
<pre><code class="apache"># Allow override for .htaccess to work
&lt;Directory /var/www/html/yourproject/&gt;
    AllowOverride all
&lt;/Directory&gt;</code></pre>
    <h2>CONFIG</h2>
    <p>
        Open up <span class="code">index.php</span> and you'll see some basic configuration.<br><br>
    </p>
    <p>
        <pre><code class="php">$_['base_url'] = 'http://www.example.com';</code></pre>
    </p>
    <p>
        This is where you set your base url if your domain was <span class="code">www.example.com</span>. 
        If you leave it empty, TinyFW will try to guess your url. <b>You can leave this 
        blank (works in most deployments)</b>.<br><br>
    </p>
    <p>
        <pre><code class="php">$_page['version'] = '1.34';</code></pre>
    </p>
    <p>
        This is the css version for your page. This number will be appended to all your static paths 
        like <span class="code">http://www.example.com/static/css/style.css?v=1.34</span>. This tells the 
        browser to download a fresh version of the stylesheet rather than using the cached version. You 
        should always increment this number when you make a major change to your stylesheet.<br><br>
    </p>
    <p>
        <pre><code class="php">$_page['title'] = 'My Site';</code></pre>
    </p>
    <p>
        This is your site name. This will appear on your title bar as <b>My Site</b> or if you set a 
        custom page title it will appear as <b>My custom page title - My Site</b>.
    </p>
    <p>
        <br>
        <b>MORE OPTIONS: </b><br><br>
        You can change other things like your static files directory, pages 
        directory, etc. Its quite self explainatory really. So we are not going to get into that now.
    </p>
    <p>
        <br>
        <b>SEPARATE CONFIG FILE: </b><br><br>
        To separate your config you can create a file called <span class="code">config.php</span>
        in the same folder and add your configuration like this.
    </p>
<pre><code class="php">&lt;?php defined('APPPATH') or die('No script access');

# config
$_['page_dir']      = 'pages/';
$_['template_dir']  = 'templates/';
$_['partial_dir']   = 'partials/';

$_['template_file']  = 'base';      // in templates
$_['404_file']       = 'notfound';  // in partials
$_['403_file']       = 'forbidden'; // in partials
$_['home_file']      = 'home';      // in pages

$_['base_url']      = '';           // auto sets if empty
$_['static_url']    = 'static/';

# page settings
$_page['version']   = '0.2';
$_page['title']     = 'TinyFW 2';</code></pre>
    <p>
        Additionally you can have another config file called
        <span class="code">local.php</span> (this will override <span class="code">config.php</span>). This
        is for development configuration on your local machine. If you notice, this file is included
        in <span class="code">.gitignore</span> and therefore will not be pushed to your git repository.
    </p>
    <h2>TEMPLATES, PAGES, PARTIALS</h2>
    <p>
        All your page templates, partials and pages reside in their respective directories as
        defined by your config.
    </p>
    <p>
        I strongly recommend you have this line at the beginning of every file to disallow
        direct script access to your templates, pages and partials.
    </p>
<pre><code class="php">&lt;?php defined('APPPATH') or die('No script access'); ?&gt;</code></pre>
    <p>
        <br>
        <b>TEMPLATES: </b><br><br>
        By default all your templates would go in the <span class="code">templates/</span> folder.
    </p>
    <p>
        As per our config, the default template is <span class="code">templates/base.php</span>
        which will look something like this.
    </p>
<?php $base_php_contents = 
'<?php defined(\'APPPATH\') or die(\'No script access\'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $PAGE_TITLE; ?></title>

    <link rel="stylesheet" href="<?php echo static_url(\'css/style.css\'); ?>">
</head>
<body>
    <div id="body-wrapper">

        <!-- header -->
        <?php include partial(\'header\'); ?>
        
        <!-- page-body -->
        <?php echo $PAGE_BODY; ?>
        
        <!-- footer -->
        <?php include partial(\'footer\'); ?>

    </div>

    <!-- scripts -->
    <script src="<?php echo static_url(\'js/script.js\'); ?>"></script>
</body>
</html>'; ?> 
<pre><code class="php"><?php echo htmlentities($base_php_contents); ?></code></pre>
    <p>
        Note that all global variables are exposed to the template. Including
        <span class="code">$_</span> (config), <span class="code">$PAGE_TITLE</span>, and
        the contents of your page are contained in <span class="code">$PAGE_BODY</span>
    </p>
    <p>
        <br>
        <b>PAGES: </b><br><br>
        By default all your pages would go in the <span class="code">pages/</span> folder.
    </p>
    <p>
    TinyFW has a basic routing system. The url 
    <span class="code">http://www.example.com/mypage</span> will look for a file 
    named <span class="code">mypage.php</span> in your pages folder 
    (<span class="code">pages/</span> by default). <span class="code">http://www.example.com/</span>
    will render your default home file from the config <span class="code">$_['home_file'] = 'home';</span>
    </p>
    <p>
        Your pages are rendered using the default template specified in the config.
        If you want a custom template for one particular page or if you want to set
        the page title, then you can define <span class="code">$TEMPLATE</span> 
        and <span class="code">$PAGE_TITLE</span> variables respectively. This 
        can appear anywhere on the page. For Example
    </p>
<?php $page_php_contents = 
'<?php defined(\'APPPATH\') or die(\'No script access\');

    # this will render this page with custom-template.php from \'templates/\'
    $TEMPLATE = \'custom-template\'; 

    # this will set the page title to \'My First Page - My Site\'
    $PAGE_TITLE = page_title(\'My First Page\');

    /* 
    alternatively if you dont want your sitename to appear 
    in the title, this will set the page title to \'My First Page\' 
    */
    $PAGE_TITLE = \'My First Page\';
?>
<div class="wrapper">
    <h1>My First Page</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>'; ?> 
<pre><code class="html"><?php echo htmlentities($page_php_contents); ?></code></pre>
    <p>
        <br>
        <b>PARTIALS: </b><br><br>
        By default all your partials would go in the <span class="code">partials/</span> folder.
    </p>
    <p>
        You may put your partials like <span class="code">header.php</span>, 
        <span class="code">footer.php</span> and other elements such as sidebars,
        social sharing widgets etc in files such as <span class="code">sidebar.php</span>,
        <span class="code">share-and-like-widget.php</span>
    </p>
    <p>
        Now you can include any partial in your pages by calling the 
        <span class="code">partial()</span> helper funcation. For example
    </p>
<pre><code class="php">/*
in your template file
you can include the common page header like this
*/

&lt;?php 
    # includes the header.php file from 'partials/'
    include partial('header');
?&gt;

/*
or in your page 
you can include other partials
*/

&lt;?php 
    # includes the sidebar.php file from 'partials/'
    include partial('sidebar'); 

    # includes the share-and-like-widget.php file from 'partials/'
    include partial('share-and-like-widget'); 
?&gt;
</code></pre>
    <h2>HELPER FUNCTIONS</h2>
    <p>
        TinyFW has some basic helper functions to make things easier for you.
    </p>
    <h3><span class="code">base_url(<i>[url]</i>)</span></h3>
    <p>This function returns your website's base url. Here are some examples.</p>

<?php $helper_base_url_contents_1 = 
'<!-- to echo a link to your \'about\' page you can do this -->
<a href="<?php echo base_url(\'about\'); ?>">About Us</a>'; ?>
<pre><code class="html"><?php echo htmlentities($helper_base_url_contents_1); ?></code></pre>
<?php $helper_base_url_contents_2 = 
'echo base_url(); // outputs http://www.example.com/

echo base_url(\'contact\'); // outputs http://www.example.com/contact'; ?>
<pre><code class="php"><?php echo htmlentities($helper_base_url_contents_2); ?></code></pre>

    <h3><span class="code">static_url(url)</span></h3>
    <p>This function returns the url with the page version number for use with 
    your static files. Here are some examples.</p>

<?php $helper_static_url_contents_1 = 
'<!-- to include your stylesheet \'style.css\' you can do this -->
<link rel="stylesheet" href="<?php echo static_url(\'css/style.css\'); ?>">'; ?>
<pre><code class="html"><?php echo htmlentities($helper_static_url_contents_1); ?></code></pre>
<?php $helper_static_url_contents_2 = 
'# the following outputs http://www.example.com/static/css/style.css?v=1.34
echo static_url(\'css/style.css\');'; ?>
<pre><code class="php"><?php echo htmlentities($helper_static_url_contents_2); ?></code></pre>

    <h3><span class="code">partial(file)</span></h3>
    <p>This function returns the full path of the partial file and you can include it
    like <span class="code"><b>include</b> partial('header');</span></p>


    <h3><span class="code">page_title(<i>[title]</i>)</span></h3>
    <p>This function returns the text hypenated with the site name.</p>
<?php $helper_page_title_contents = 
'echo page_title(\'Sample\'); // outputs \'Sample - My Site\'

echo page_title(); // outputs \'My Site\''; ?>
<pre><code class="php"><?php echo htmlentities($helper_page_title_contents); ?></code></pre>

    <h2>DOWNLOAD</h2>
    <p>
        You can download TinyFW here: <a href="https://github.com/aravindanve/tiny-fw/archive/master.zip">Get TinyFW</a>
    </p>
    <h2>REPORT BUGS</h2>
    <p>
        Feel free to report any bugs you find here: 
        <a href="https://github.com/aravindanve/tiny-fw/issues">TinyFW Issues</a>.
    </p>
</div>