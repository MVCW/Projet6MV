<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'font-awesome','simple-line-icons','oceanwp-style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION



// Fonction pour ajouter un lien "Admin" au milieu du menu si l'utilisateur est connecté et est un administrateur
function ajouter_lien_admin_au_menu_personnalise($items, $args) {
    // Vérifie si l'utilisateur est connecté et est un administrateur
    if (is_user_logged_in() && current_user_can('administrator')) {
        // Divise les éléments du menu en un tableau
        $items_array = explode('</li>', $items);
        
        // Retire le dernier élément vide après le dernier </li>
        array_pop($items_array);

        // Calcule l'index au milieu du tableau
        $milieu_index = ceil(count($items_array) / 2);

        // Prépare le lien "Admin"
        $admin_link = '<li class="menu-item admin-link"><a class="hfe-menu-item" href="' . admin_url() . '">Admin</a></li>';

        // Insère le lien "Admin" au milieu du tableau
        array_splice($items_array, $milieu_index, 0, $admin_link);

        // Réunit les éléments du tableau en une chaîne
        $items = implode('</li>', $items_array) . '</li>';
    }

    // Ajout de classes spécifiques pour les autres liens
    $items = str_replace('href="http://planty.local/nous-rencontrer"', 'class="hfe-menu-item nous-rencontrer-link" href="http://planty.local/nous-rencontrer"', $items);
    $items = str_replace('href="http://planty.local/commander"', 'class="hfe-menu-item commander-link" href="http://planty.local/commander"', $items);
    
    return $items;
}

// Fonction pour ajouter des classes CSS spécifiques aux éléments du menu
function ajouter_classes_au_menu_personnalise($classes, $item, $args) {
    // Ajoute des classes spécifiques aux liens du menu par titre
    if ($item->title === 'Nous Rencontrer') {
        $classes[] = 'nous-rencontrer-link';
    } elseif ($item->title === 'Commander') {
        $classes[] = 'commander-link';
    } elseif ($item->title === 'Admin' && is_user_logged_in() && current_user_can('administrator')) {
        $classes[] = 'admin-link';
    }

    return $classes;
}

// Utilise le hook 'nav_menu_css_class' pour ajouter des classes CSS spécifiques
add_filter('nav_menu_css_class', 'ajouter_classes_au_menu_personnalise', 10, 3);

// Utilise le hook wp_nav_menu_items pour modifier le menu
add_filter('wp_nav_menu_items', 'ajouter_lien_admin_au_menu_personnalise', 10, 2);
?>


