# WordPress-UDEMY

**Side Notes**
1. ``debugging print_r(get_defined_vars( ) )exit( )``


###Steps to creating a wordpress site:
1. Download MAMP, Wordpress, MySQL and phpAdmin
1. Create new folder “udemy" within htdocs; unzip and paste Wordpress content into it 
1. Go to http://localhost:8888/phpMyAdmin and create a new database under the name "udemy" with the ``utf8_general_ci`` as the collation
1. Go to http://localhost:8888/udemy to set and configure Wordpress.
    * Once signed into Wordpress set up permalink to be post. Go to ``Settings > Permalinks``
1. Go to into ``htdocs`` under ``udemy > wp_content > themes`` and create a ``udemy`` theme folder with a ``style.css`` and ``index.php`` within it
1. Go onto dashboard of Wordpress and select the new theme: ``udemy`` under > ``Appearance > Themes > udemy``
1. Go to http://localhost:8888/udemy/ to see your layout. 
1. Add/ edit code in the ``index.php`` file to make sure it renders
1. Go back into ``style.css`` and add the meta information -- follow along on https://codex.wordpress.org/File_Header
    * The theme URI is a link where the users can view the where the theme can be found officially - going to remove it for now (usually under the **Theme Name: Udemy**)
    * **Author URI**: is the url to your personal (author’s) site
    * **Text Domain** is important to specify since it’s the “ID” if you will for your page… it’s best practice to name it the same as your folder
1. You can have a screen shot for the theme and paste in the same folder as Screenshot.png recommended size is 880px by 660px

```
/*
Theme Name: Udemy
Author: Crystal
Author URI: http://omaracrystal.com
Description: A simple bootrap wordpress theme
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: bootstrap, responsive, flat, simple, mobile ready
Text Domain: udemy

Extra notes just in case
*/
```

###FILE STRUCTURE
1. create a folder called ``assets`` and unzip the contents of the theme’s static template information and paste it into the ``assets`` folder
1. Copy and paste info from index.html into the index.php up one folder… the page is broken because the links to the css files are now off. We could go through manually and fix all of this or utilize some built in functions within Wordpress to handle this. Create a function.php file within the same area where index.php is.
1. echo a message just to make sure it is coming through
1. Delete the echo message and follow these comments:
    ```
    <?php 
    // Set up
    // Includes
    // Action & Filter Hooks
    // Shortcuts
    ```
1. There are many many hooks to choose from… here we will explore our options: http://codex.wordpress.org/Plugin_API/Hooks - There are two types of Hooks: Action and Filter 
1. ``wp_enqueue_scripts`` is the proper hook to use when **enqueuing** items that are meant to appear on the **frontend**. Despite the name, it is used for enqueuing both **scripts and styles**.
1. Under the ``//Action & Filter`` Hooks comment add (cu = crystal udemy):
``add_action('wp_enqueue_scripts', ‘cu_enqueue’);``
    * Takes up to 4 parameters: 
        1. ``$tag`` (string, Required):
            - The name of the action to with the $function_to_add is hooked
        1. ``$function_to_add`` (callable, Required):
            - The name of the function you wish to be called
        1. ``$priority`` (int, Optional):
            - Used to specify the order in which the functions associated with a particular action are executed. Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action. 
            *Default Value: 10*
        1. ``$accepted_args`` (int, Optional). 
            - The number of arguments the function accepts. *Default Value: 1*
    * more info: https://developer.wordpress.org/reference/functions/add_action/
    * add_action ( string $tag, callable $function_to_add, int $priority = 10, int $accepted_args = 1 )
1. Create folders/files under ``udemy > includes > front > enqueue.php``
1. Under ``enqueue.php`` we call the action within the ``functions.php`` file:
``<?php function cu_enqueue( ) { }``
1. Under ``//Includes`` comment in ``functions.php`` we include the above file:
``include( get_template_directory() . '/includes/front/enquue.php' );``

###ADDING STYLES THROUGH HOOKS
**Only 2 steps to required to add styles to your pages**

1. Register style:
    *  ``wp_enqueue_scripts`` action ``$handle`` ``$src``
    * https://codex.wordpress.org/Function_Reference/wp_register_style
    * ``wp_register_style( 'cu_bootstrap', get_template_directory_uri() . '/assets/styles/bootstrap.css');``
1. Then enqueue the style:
    * ``wp_enqueue_style( 'cu_bootstrap' );``
    * add php to html after ``<title></title>`` tags
    * ``<?php wp_head(); ?>``
1. Add remaining styles and any font urls if needed

###ADDING SCRIPTS THROUGH HOOKS
1. Add in html right above closing tags for ``</body>`` and ``</html>``
    * ``<?php wp_footer( ); ?>``
    * Add scripts same way as styles by **Registering** them then **Enqueue**

1. **Register**: 
    ```
    wp_register_script( 'cu_fastclick', get_template_directory_uri() . '/assets/vendor/fastclick/fastclick.js' );
    wp_register_script( 'cu_bootstrap', get_template_directory_uri() . '/assets/scripts/bootstrap.min.js', array(), false, true );
    ```

1. **Enqueue** *(note ‘jquery')*:
    * ``wp_enqueue_script( 'jquery’);``
    * https://developer.wordpress.org/reference/functions/wp_register_script/
    ```
    wp_enqueue_script('cu_fastclick’);
    wp_enqueue_script('cu_bootstrap’);
    ```

###ADDING DUMMY CONTENT
1. ``Dashboard > Plugins > Add New > FakerPress``
1. ``Fakerpress > posts >`` choose **quantity** (6/12) and **featured image rate** (100) ``Page > Add New > About > Publish``

###ADD THEME SUPPORT
1. **Register** the menu: 
    * https://codex.wordpress.org/Function_Reference/add_theme_support
    * **Setup** under ``functions.php`` > ``add_theme_support( 'menus' );``
    * **create file** under ``includes > setup.php ``
1. **Double underscore __** is a built in function in word press. It allows for text to be translated into various languages. Wordpress comes with function that translates various strings. Double underscore is one of the more common functions to use which takes two arguments:
        1. The **string** you would like to translate i.e. ``‘Primary Menu’``
        1. The **text domain** that translation is using. The text domain is basically the name of the theme folder i.e.: ``‘udemy’`` (or see it as an ID)
    ```
    function cu_setup_theme () {
        register_nav_menu( 'primary', __( 'Primary Menu', 'udemy') );
    }
    ```
        * https://developer.wordpress.org/reference/functions/wp_nav_menu/
1. **Display the menu**
    * ``wp_nav_menu ( array $args = array( ) )``
    * https://developer.wordpress.org/reference/functions/wp_nav_menu/
    *Very powerful and flexible. This function allows us to render the menu wherever we call it in code.*
    * ``index`` > find ``<nav>`` tags… highlight and replace the ``<ul>`` with ``class="nav navbar-nav”`` :

    ```
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'nav navbar-nav'
    ));
    ?>
    ```

    *if left empty default is used*

1. Refresh page and nothing! Well that’s because we need to let Wordpress know to render it by going to:
    * ``Appearance > Menus >`` and create a menu > assign **theme location**
    * **make sure that within the functions.php the setup.php and any other files are included**
    * ``include( get_template_directory() . '/includes/setup.php' );``


###CREATING HEADERS AND FOOTERS
1. create file ``header.php`` in ``themes`` folder
1. create file ``footer.php``
1. Call these files within the ``index.php``
    * ``<?php get_header(); ?>``
    * ``<?php get_footer(); ?>``
1. *NOTE* if you want to name your header.php something else that's fine, just make sure that **header** is within the name such as ``header-about.php.`` Then when you are calling the header you write ``<?php get_header('about'); ?>``

###CREATING WIDGET AREAS
####SIDEBAR
1. register_sidebar
    * https://codex.wordpress.org/Function_Reference/register_sidebar
    *This site recommends adding the action **'widgets_init'*
1. In ``functions.php`` under the ``//Action & Filter Hooks`` comment add:
    ```
    add_action( 'widgets_init', cu_widgets' );
    ```
1. Add file ``widgets.php`` under the ``includes`` folder
1. Include this file ^ it in the ``functions.php`` file
1. Define the function within ``widgets.php`` file
    ```
    function ju_widgets() {
        register_sidebar(array(
            'name' => __( 'My First Theme Sidebar', 'udemy'),
            'id' => 'cu_sidebar', //note be careful to use unique id (not something already used in wordpress)
            'description' => __( 'Sidebar for the theme Udemy', 'udemy'),
            'class' => '',
        ))
    }
    ```
1. Go to ``Dashboard > Appearance > Widgets`` the item should appear. Then drag and drop the widgets in to the sidebar on the right.
1. Refresh page, but still not there! Well that's because we need to call the function within the template. So let's create a ``sidebar.php`` just like the ``header.php`` and ``footer.php``
    * Add ``<?php get_sidebar(); ?>`` wherever you would like to call the template. 
1. Within the ``sidebar.php`` 
        ```
        <?php

        if( is_active_sidebar('cu_sidebar') ){
            dynamic_sidebar('cu_sidebar');
        }
        ```
1. HTML doesn't go well with theme - so we can fix that!
    * Within the ``widgets.php`` file we can add **four** more keys to the ``register_sidebar`` function. 
    ```
    <?php $args = array(
        'name'          => __( 'My First Theme Sidebar', 'udemy'),
        'id'            => 'cu_sidebar',
        'description'   => __( 'Sidebar for the theme Udemy', 'udemy'),
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="card %2$s">',
        'after_widget'  => '</div></div></div>',
        'before_title'  => '<div class="card-header bg-primary"><span class="card-title">',
        'after_title'   => '</span></div><div class="card-content"><div class="widget">'
        )); 
    ?>
    ```

####SEARCH BAR
1. Add ``searchform.php`` file under ``udemy`` theme folder
1. Add markup:

    ```
    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url('/'); ?>">
        <div class="input-group">
            <input type="text" placeholder="Search" class="input-sm form-control" name="s" id="search" value="<?php the_search_query(); ?>">
            <span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary rippler rippler-default btn-flat with-border">
                <i class="fa fa-search"></i>
            </span>
        </div>
    </form>
    ```

1. read more: https://developer.wordpress.org/reference/functions/get_search_form/
1. Breaking down the search html markup
    * make sure it's wrapped in ``<form>`` tags and that the **id** and **class** are labeled ``searchform`` so this allows any plugins to hook into this form if needed. 
        * **method** should always be ``get`` (this is recommended by wordpress)
        * the **action** attribute should be the **url** to the home page. The ``home_url()`` function is built into wordpress.
    * The **name** of the ``<input>`` should always be ``s`` - wordpress uses this name called the ``loop`` 
        * the **id** should be ``search``
        * the **value** shoule call the built in wordpress function ``the_search_query()``

###The Loop
1. https://codex.wordpress.org/The_Loop
1. The Loop is PHP code used by WordPress to display posts. Using The Loop, WordPress processes each post to be displayed on the current page, and formats it according to how it matches specified criteria within The Loop tags. Any HTML or PHP code in the Loop will be processed on each post.
1. Add **theme support** within the ``functions.php`` file under ``//Set up``
    ``add_theme_support( 'post-thumbnails' );``
1. Find within the ``index.php`` (or whatever file) and find the ``<section>`` with the ``id="blog-posts"`` this is where we will want to run **the loop**
1. Add markup:
    ```
    <?php

    if( have_posts() {
        while(have_posts()) {
            the_post();
            ?>
            <article class="card" ... > //how it is to be rendered
            <?php>
        }
    })
    ```
1. On **Dashboard** Within ``Settings > Reading`` set the limit of the "**Blog pages show at most**" to 4 (to set up pagination in a little bit), and chose radio bullet "**Summary**" for this exercise. This is display a short hand of the **excerpt** portion for the post. By default wordpress will have [...] to show this. With **Filters** we can get rid of these **brackets** []. 
1. Functons you can use within the loop: https://codex.wordpress.org/Template_Tags such as:
    * in place of ``<img>`` tags ``<?php the_post_thumbnail(); ?>``
    * The ``the_post_thubnail()`` function can take two arguments= Size and array of attributes
        - ``<?php the_post_thumbnail( 'full', array('class => 'img-responsive)); ?>``
        - https://codex.wordpress.org/Post_Thumbnails
    * Note not all posts will have images so you should wrap the code with a conditonal ``if()`` statement.
    ```
        <?php
            if( has_post_thumbnail() ) {
        ?>
            <div class="card-image">
                <?php the_post_thumbnail( 'full', array('class => 'img-responsive)); ?>
            </div>
        <?php>
            }
        ?>
    ```

###Template tags inside the Loop 
**making the post more dynamic!**

1. Time and Date
    * https://codex.wordpress.org/Formatting_Date_and_Time
    * ``<span class"date"><?php the_time( 'd M' ); ?></span>``
    * ``<span class="time"><?php the_time( ' g:i a'); ?></span>``
1. Title
    * ``<a href="<?php the_permalink(); ?>" title=""><?php the_title(); ?></a>``
1. Category
    * ``<span class="tag"><?php the_category(); ?></span>``
    * By default if no argument is passed into ``the_category()`` function - wordpress will render the categories as an unordered list ``<ul>``
    * ``the_category(',')`` this will now seperate them with a comma instead.
1. Author
    * ``<span class="post-author">by<a href="<php the_author_link(); ?>"><?php the_author(); ?></a></span>``
1. Excerpt
    * ``<p class="post-excerpt"></p>`` 

###Pagination
1. https://codex.wordpress.org/Pagination
    ```
    <nav class="text-center">
        <ul class="pagination">
            <li>
                <?php previous_posts_link('<i class"fa fa-chevron-left"></i>' ); ?>
            </li>
            <li>
                <?php next_posts_link('<i class"fa fa-chevron-right"></i>' ); ?>
            </li>
        </ul>
    </nav>
    ```

###Template Hierarchy
1. https://developer.wordpress.org/themes/basics/template-hierarchy/
![alt text](https://developer.wordpress.org/files/2014/10/template-hierarchy.png)

###Single Posts
1. When you click on a post wordpress automatically beings you to a seperate page that only shows that post... however the excerpt is still being cut off from previous conditions. We can add logic to indicate when it's a single post to avoid that OR just creat a whole new template. Which is what we will do:
1. Create ``single.php`` under the theme folder ``udemy``
1. Copy and paste the template from index then edit the following
    * delete the tags for the **"Read More"** button
    * delete ``<p>`` tag with the **excerpt** function
    * **CONTENT** replace the above with ``<?php the_content(); ?>``
    * **TAGS** add below content ^ ``<?php the_tags(); ?>``
    * Refresh page (tags are not displayed but that's because we can **Edit** the post and add them)
1. On upper bar click ``edit post`` add tags (right column) Add and Save!
1. Read up on Single Posts: https://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29 ]
1. **Quick tags**... within Wordpress under Edit Post switch from **Visual** tab to **Text** tab
    * inserting the following comment code within the template on Wordpress will tell where Pagination will take place
        ``<!--nextpage-->``
    * The above will not work right away - that's because we need to call the ``wp_link_pages()`` function from the Single Posts documentation recommendation: https://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29 ]
    * Call this function within the ``the_content()`` and ``the_tags()`` functions within ``single.php``
    **BEFORE**
    ```
    <?php the_content(); ?>
    <?php wp_link_pages(); ?>
    <?php the_tags(); ?>
    ```
    * https://codex.wordpress.org/Function_Reference/wp_link_pages
    * Some suggestions include adding and **Edit** option - but because it's already there for this particular post - it's not needed to add. 
    **text-center AFTER for pagination**
```
    <?php the_content(); ?>
    <?php wp_link_pages(array (
        'before'           => '<p class="text-center">' . __( 'Pages:' ),
    ); ?>
    <?php the_tags(); ?>
</div>
<nav class="text-center">
    <ul class="pagination">
        <li>
            <?php previous_post_link('%link', '<i class"fa fa-chevron-left"></i> %title' ); ?>
        </li>
        <li>
            <?php next_post_link('%link', '%title <i class"fa fa-chevron-right"></i>' ); ?>
        </li>
    </ul>
</nav>
```

* **PAGINATION** *note that the previous and next post links are now singular and not plural as listed above (posts vs post)* ``single.php`` 

###COMMENTS TEMPLATE
1. In ``single.php`` add this code below the ``</nav>`` = ``<?php comments_template(); ?>``
1. This above php function looks for a file called ``comments.php`` create that file now. 
1. Add in ``comments.php`` this code: The single _e just outputs the translated string whereas double __e will return the translated string to the language defined in wp-config.php
    ```
    <?php 

    if(comments_open()) {

    }else{
        _e('Comments are closed', 'udemy' );
    }
    ```
1. Within the if statement past the html markup of the comment form (remmember to close out php beore doing this and initiating it again for the else statement) such as:
```
    <?php
if(comments_open()) {
?>

    <h4>Leave a comment</h4>
    <form action="<php eco site_url('wp-comments-posts.php'); ?>" method="post" id="commentform">
        <input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" id="comment_post_ID"></input>
        <div class="form-group">
            <label>Name / Alias (required)</label>
            <input type="text" name="author" class="form-control"></input>
        </div>
        <div class="form-group">
            <label>Email Address (required, not shown)</label>
            <input type="text" name="email" class="form-control"></input>
        </div>
        <div class="form-group">
            <label>Website (optional)</label>
            <input type="text" name="url" class="form-control"></input>
        </div>
        <div class="form-group">
            <label>Comment</label>
            <textarea rows="7" cols="60" name="comment" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </div>
    </form>

<?php
}else{
    _e('Comments are closed', 'udemy' );
}
```
1. Adjust the markup to be wordpress compatible:
1. Within the ``<form>`` you need to set the action and **method** attributes. Action being **post** and action being the **url**
1. Next look at the input fields - the most important part is the name of the input field.
1. Also take note of ``$post`` in first input above. Here is a link to documentation: https://codex.wordpress.org/Function_Reference/$post which= "Contains data from the current post in The Loop."
1. The above form should now work, however we still need to add logic to output it to the DOM
1. Above all this code (above) include this comment wrapper=
```
    <div class="comments-wrap">
    <?php
    foreach($comments as $comment) {
        ?>
        <h4><a href="<?php comment_author_url(); ?>"<?php comment_author(); ?></a> - <small><?php comment_date(); ?></small></h4>
        <div class="comment-body">
            <p><?php comment_text(); ?></p>
        </div>
        <?php
    }
    ?>
    </div>
```


##PAGE TEMPLATE
1. create file in themes > udemy > ``page.php``
1. copy and paste info from single.php into this new folder
1. https://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
1. Include the main things and done

##404 PAGE
1. create file ``404.php``
1. Copy code from ``page.php`` and paste into the ``404.php``
1. Get rid of loop completely
1. Get rid of side-bar
1. Change ``class="col-sm-8"`` to ``"col-sm-12"`` on ``<section>`` tag
1. Customize template - done!
```
    <?php get_header(); ?>
        <section id="blog" class="section">
            <div class="container">
                <section id="blog-posts" class="col-sm-12">
                    <article class="card">
                        <div class="card-content">
                            <h1 class="text-center text-danger">
                                <i class="fa fa-frown-o"></i> <br>
                                <?php _e('404! Page not found!', 'udemy' ); ?>
                            </h1>
                        </div>
                    </article>
                </section>
            </div>
        </section>
    <?php get_footer(); ?>
```

##CATEGORY TEMPLATE
1. create file ``category.php``
1. copy and paste from ``index.php`` into ``category.php``
1. refresh page to see the category widget appear on the sidebar
1. On Dashboard go into one of the posts - on the right hand sidebar column you'll see Categories - add a new category then select it > update
1. This will then display posts by category


##SEARCH TEMPLATE
1. https://codex.wordpress.org/Theme_Development#Search_Results_.28search.php.29
1. create ``search.php`` file
1. Key code within "card" class div tags from index.php template:
```
    <div class="card-content">
        <h3><?php _e('Search', 'udemy'); ?></h3>
        <?php get_search_form(); ?>
        <hr>
        <h4>
            <?php _e('Search Results for', 'myfirsttheme'); ?>:
            <span class="text-info"><?php the_search_query(); ?></span>
        </h4>
    </div>
```

##CUSTOM TEMPLATES
1. create php template whatever you want ``name-of-template.php``
1. add file header within comments after ``<?php`` tag
```
/*
    * Template Name: Name of Template
*/
```

##Title
1. ``<title><?php wp_title(); ?></title>``
2. in ``functions.php`` file add ``add_theme_support('title-tag');``
3. Change logo, you can use ``<?php bloginfo(); ?>`` This function takes in a string which is what piece of information we want. Go to https://developer.wordpress.org/reference/functions/bloginfo/ for parameter suggestions. 

##WORDPRESS APIs
1. https://codex.wordpress.org/WordPress_APIs
2. Available for plugins and or themes
3. in ``functions.php`` add a hook ``add_action( 'after_switch_theme', 'cu_activate')
4. Within the   ``includes.php`` folder create a file ``activate.php`` add a function for ``cu_activate`` :
    ```
    function cu_activate () {
        if( version_compare( get_bloginfo( 'version' ), '4.2, '<' ) {
            wp_die(__('You must have a minimum version of 4.2 to use this theme.') );
        }
        //add theme options api (see below)
    }
    ```
5. Include the above file withing the ``function.php`` file:
    ``include( get_template_directory() . '/includes/activate.php' );``
6. Both ``version_compare()`` vs ``compare()`` and ``get_bloginfo`` vs ``bloginfo()`` are built in Wordpress functions. The ``get`` will return the value and the no get function will output the value. This is the first perameter for the ``cu_activate`` function. Second perameter is the minimum value of the version. The third perameter is the comparitive operator "<" less than. ``wp_die`` kills the script and outputs message
7. Activate it by switching the Appearance theme on the Dashboard from one back to the original. 

###OPTIONS API
1. https://codex.wordpress.org/Options_API
2. What is it? The Options API is a simple and standardized way of storing data in the database. The API makes it easy to create, access, update, and delete options. All the data is stored in the wp_options table under a given custom name. This page contains the technical documentation needed to use the Options API. A list of default options can be found in the Option Reference.
3. within the ``activate.php`` file add theme options then test to make sure their aren't any errors by toggling themes within Apperance. Then test one last time in phpMyAdmin, from there navigate to ``wp_options`` table under "structure" tab. Navigate to the last row in the table to see the "option_name" have the one you just created "cu_opts"
    ```
    function cu_activate () {
        if( version_compare( get_bloginfo( 'version' ), '4.2, '<' ) {
            wp_die(__('You must have a minimum version of 4.2 to use this theme.') );
        }
        $theme_opts         =   get_option( 'cu_opts' );

        if( !$theme_opts ){
            $opts           = array(
                'facebook'  =>  '',
                'twitter'   =>  '',
                'youtube'   =>  '',
                'logo_type' =>  1,
                'logo_img'  =>  '',
                'footer'    =>  ''
            );

            add_option( 'cu_opts', $opts );

        }
    }
    ```

###ADDING A MENU PAGE TO WORDPRESS ADMIN
1.  ``add_menu_page`` : https://developer.wordpress.org/reference/functions/add_menu_page/
2.  It is recommended to use the hook ``admin_menu`` so in ``functions.php`` : ``add_action( ('admin_menu', 'ju_admin_menus' ) );
3.  Create ``admin`` folder within the ``includes`` folder and add the file ``menus.php``
4.  Then include the file within the ``functions.php`` file : ``include( get_template_directory() . '/includes/admin/menus.php' );``
5.  Within the ``menus.php`` file add the function ``add_menu_page`` which takes the following parameters: (title of this page, name that appears in sidebar, capability = : https://codex.wordpress.org/Roles_and_Capabilities (what a user can and can't do) (6 defaults roles and you can view the "Capabiliy vs Role" section under contents) ). Forth parameter is menu_slug basically the url - should be unique. The 5th paramenter is the function that will be called.
    ```
    <?php

    function ju_admin_menus(){
        add_menu_page(
            'Udemy_Theme_Options',
            'Theme_Options',
            'edit_theme_options',
            'cu_theme_opts',
            'cu_theme_opts_page',
        )
    }
    ```
6. For the 5th parameter we need the file that matches. Create a file ``options-page.php`` under the ``admin`` folder
7. Next include the file in ``functions.php`` = ``include( get_template directory( . '/includes/admin/options-page.php'))``
8. Last let's define the function within the ``options-page.php`` file: 
    ```
    <?php
    function cu_thme_opts_page(){
    ?>
        <div class="wrap">
        </div>
    <?php
    }
    ?>
    ```




