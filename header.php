<?php
/**
 * @package WordPress
 * @subpackage customtheme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php wp_head(); ?>
    <style>
        .site-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
        }

        .site-logo {
            max-width: 100px;
            height: auto;
        }

        .site-navigation {
            display: flex;
            align-items: center;
        }

        .main-navigation {
            margin-left: 20px;
        }

        .main-navigation ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main-navigation li {
            margin-left: 20px;
            position: relative;
        }

        .main-navigation a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease-in-out;
        }

        .main-navigation a:hover {
            background-color: #f2f2f2;
        }

        .sub-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .sub-menu li {
            margin: 0;
        }

        .sub-menu a {
            padding: 10px;
            font-size: 14px;
            font-weight: normal;
            text-transform: none;
        }

        .sub-menu a:hover {
            background-color: #f2f2f2;
        }

        .menu-item-has-children:hover > .sub-menu {
            display: block;
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="site-logo">
            <?php if ( get_theme_mod( 'affsquare_logo' ) ) : ?>
                <a href="<?php echo home_url(); ?>"><img id="affsquare_logo_id" class="site-logo" src="<?php echo esc_url( get_theme_mod( 'affsquare_logo' ) ); ?>" alt="Site Logo"></a>
            <?php else : ?>
                <a href="<?php echo home_url(); ?>"><img id="affsquare_logo_id" class="site-logo" src="<?php echo get_template_directory_uri(); ?>/logo.png" alt="Site Logo"></a>
            <?php endif; ?>
        </div>
        <nav class="site-navigation">
            <div class="main-navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
            </div>
        </nav>
    </header>
    <div id="content" class="site-content">
        <!-- Your page content goes here -->
    </div>
    <?php wp_footer(); ?>
