<?php
/**
 * @package PepFeed
 * @version 0.3
 */
/*
Plugin Name: PepFeed Instant Monetization
Plugin URI: http://pepfeed.com
Description: Get instant access to the most relevant content about the gadgets you're browsing
Author: PepFeed
Version: 0.3
Author URI: http://pepfeed.com
*/

defined('ABSPATH') or die('No script kiddies please!');
include_once("pepfeed_widget.php"); //load widget

//Running plugin for the first time? Let's set up some variables
function pepfeed_define_default_variables()
{
    add_option("pepfeed_first_time", "1");
    add_option("pepfeed_agreement", "0");
    add_option("pepfeed_currency", "usd");
    add_option("pepfeed_sort_shops_by", "cheapest");
    add_option("pepfeed_price_difference", "fixed");
    add_option("pepfeed_region", "us");
    add_option("pepfeed_amazon_affiliate_id", "pep07-20");
    add_option("pepfeed_display_format", "widget_format");
    add_option("pepfeed_show_powered_by", "0");
    add_option("pepfeed_show_all_stores", "1");
    add_option("pepfeed_button_footer_message", (string) rand(0, 1));
    add_option("pepfeed_widget_footer_message", (string) rand(0, 1));
}


function pepfeed_widget_footer_messages(){
    $pepfeed_footer_messages = array(
    	'<a href="http://www.pepfeed.com/wordpress" target="_blank">Best deals</a> brought to you by <a href="http://www.pepfeed.com/wordpress" target="_blank">PepFeed</a>.',
    	'<a href="http://www.pepfeed.com/wordpress" target="_blank">Price comparison</a> tool by <a href="http://www.pepfeed.com/wordpress" target="_blank">PepFeed</a>.',
    	);
    return $pepfeed_footer_messages;
}

function pepfeed_button_footer_messages(){
    $pepfeed_footer_messages = array(
    	'Brought to you by <a href="http://www.pepfeed.com/wordpress" target="_blank">PepFeed</a>',
    	'Powered by <a href="http://www.pepfeed.com/wordpress" target="_blank">PepFeed</a>',
    	);
    return $pepfeed_footer_messages;
}

function pepfeed_testing_is_first_running()
{
    if (get_option("pepfeed_first_time") != 1)
        pepfeed_define_default_variables();
}
add_action('init', 'pepfeed_testing_is_first_running');


//They must accept terms and conditions to see the admin page
function pepfeed_admin()
{
    if (get_option('pepfeed_agreement') == 1)
        include('pepfeed_import_admin.php');
    else
        include('pepfeed_terms_and_conditions.php');
}

function pepfeed_admin_actions()
{
    add_options_page("PepFeed", "PepFeed Settings", "read", "pepfeed", "pepfeed_admin");
}
add_action('admin_menu', 'pepfeed_admin_actions');


function pepfeed_echo_powered_by_widget()
{
	$assigned_message = get_option('pepfeed_widget_footer_message');
    return '<small>'. pepfeed_widget_footer_messages()[$assigned_message] .'</small>';
}

function pepfeed_echo_powered_by_button()
{
	$assigned_message = get_option('pepfeed_button_footer_message');
    return '<small>'. pepfeed_button_footer_messages()[$assigned_message] .'</small>';
}


//Getting last post title and url for the case where people are visiting the homepage
function pepfeed_get_most_recent_post(){
    $args = array( 'numberposts' => '1',  'post_status' => 'publish');
    return wp_get_recent_posts($args);
}


//Testing if post is singular or is in THE loop
function pepfeed_get_title(){
    if(!is_singular() && !in_the_loop())
        return pepfeed_get_most_recent_post()[0]["post_title"];
    if(is_singular() && !in_the_loop())
        return get_the_title();
    if(in_the_loop())
        return get_the_title();
}

function pepfeed_get_url(){
    if(!is_singular() && !in_the_loop())
        return get_permalink(pepfeed_get_most_recent_post()[0]["ID"]);
    if(is_singular() && !in_the_loop())
        return get_permalink();
    if(in_the_loop())
        return get_permalink();
}

//Returns widget iframe code
function pepfeed_getproducts_widget()
{
    if (get_option("pepfeed_agreement") != 1)
        return; //kill
    
    $pepfeed_title = pepfeed_get_title();
    $pepfeed_url = pepfeed_get_url();

    $query = array(
        "user" => "fd478c0712d841d5984805e4b81be828",
        "type" => "offers",
        "price" => "0",
        "region" => get_option("pepfeed_region"),
        "query" => $pepfeed_title,
        "q" => $pepfeed_title,
        "url" => $pepfeed_url,
        "currency" => get_option("pepfeed_currency"),
        "sort" => get_option("pepfeed_sort_shops_by"),
//        "difference" => get_option("pepfeed_price_difference"),
        "affiliate_id" => get_option("pepfeed_amazon_affiliate_id"),
        "showallstores" => get_option("pepfeed_show_all_stores") ? "1" : "0",
    );
    
    $query_string = http_build_query($query);
    //$pepfeed_api  = "http://127.0.0.1:5500/embed/List/?";
    $pepfeed_api  = 'http://www.pepfeed.com/embed/List/?';
    
    return '<iframe src="' . $pepfeed_api . $query_string . 
    '"width height="250" scrolling="no" frameborder="0" allowtransparency="true"></iframe>' . 
    (get_option("pepfeed_show_powered_by") == 0 ? pepfeed_echo_powered_by_widget() : "")
    ;
}


/*
//load another version of jquery for the dropdown
function pepfeed_init_jquery() {
    if (!is_admin()) {
        // comment out the next two lines to load the local copy of jQuery
        wp_deregister_script('jquery'); 
        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false, '2.1.4'); 
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'pepfeed_init_jquery');
*/


//add javascript for the dropdown
function pepfeed_js_include_function() {
    wp_enqueue_script( 'pepfeed_jquery.js', wp_make_link_relative(plugin_dir_url(__FILE__)) . 'pepfeed_jquery.js', array('jquery') );
}
add_action('wp_enqueue_scripts', 'pepfeed_js_include_function');


//add stylesheet for the dropdown
function pepfeed_dropdown_enqueue_style()
{
    wp_enqueue_style("pepfeed_dropdown.css", wp_make_link_relative(plugin_dir_url(__FILE__)) . 'pepfeed_dropdown.css');
}
add_action('wp_enqueue_scripts', 'pepfeed_dropdown_enqueue_style');

//Find best price (for the button)
function pepfeed_find_best_price()
{
    $query_bestprice = array(
        "v" => "3.1",
        "q" => get_the_title(),
        "url" => get_permalink(),
        "user" => "123",
        "type" => "offers",
        "price" => "0",
        "region" => get_option("pepfeed_region"),
        "currency" => get_option("pepfeed_currency"),
        "sort" => get_option("pepfeed_sort_shops_by"),
//        "difference" => get_option("pepfeed_price_difference"),
        "affiliate_id" => get_option("pepfeed_amazon_affiliate_id"),
        "showallstores" => get_option("pepfeed_show_all_stores") ? "1" : "0",
    );
   
    $q_string                = http_build_query($query_bestprice);
    $pepfeed_api             = 'http://www.pepfeed.com/search/store_offers?';

    return $pepfeed_api . $q_string;
}

//Returns button code --- Disabled for now
function pepfeed_getproducts_button()
{
    if (get_option("pepfeed_agreement") != 1)
        return; //kill
    
    $query = array(
        "user" => "fd478c0712d841d5984805e4b81be828",
        "type" => "offers",
        "price" => "0",
        "region" => get_option("pepfeed_region"),
        "query" => get_the_title(),
        "q" => get_the_title(),
        "url" => get_permalink(),
        "currency" => get_option("pepfeed_currency"),
        "sort" => get_option("pepfeed_sort_shops_by"),
//        "difference" => get_option("pepfeed_price_difference"),
        "affiliate_id" => get_option("pepfeed_amazon_affiliate_id"),
        "showallstores" => get_option("pepfeed_show_all_stores") ? "1" : "0",
    );   

    $query_string = http_build_query($query);
    $pepfeed_api  = 'http://www.pepfeed.com/embed/List/?';
    
    return '<div class="pepfeed-dropdown" id="pepfeed-div-for-dropdown-1">    
<a class="pepfeed-button-class" id="pepfeed-button-1" href="#" data-pepfeed="' . pepfeed_find_best_price() . '">Save Money with PepFeed</a>
<iframe class="pepfeed-dropdown" id="pepfeed-iframe-1" src="' . $pepfeed_api . $query_string . '" width="300" height="250" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
</div><br>' .
    (get_option("pepfeed_show_powered_by") == 0 ? pepfeed_echo_powered_by_button() : "")
    ;
}


//Shortcode for widget
add_action('init', 'pepfeed_register_shortcodes');

function pepfeed_register_shortcodes()
{
    add_shortcode("pepfeed-widget", "pepfeed_getproducts_widget");
}


//Shortcode for pepfeed button
add_action('init', 'pepfeed_register_shortcode_button');

function pepfeed_register_shortcode_button()
{
    add_shortcode("pepfeed-button", "pepfeed_getproducts_button");
}

//Adds a shortcut to PepFeed settings in plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'pepfeed_plugin_action_links');

function pepfeed_plugin_action_links($links)
{
    $links[] = '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=pepfeed')) . '">Settings</a>';
    return $links;
}


//Adds a pepfeed button to rich media interface --- Disabled for now
function pepfeed_add_button()
{
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
        return;
    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_pepfeed_tinymce_plugin');
        add_filter('mce_buttons', 'register_pepfeed_button');
    }
}
//add_action('init', 'pepfeed_add_button');

function register_pepfeed_button($buttons)
{
    array_push($buttons, "|", "pepfeed");
    return $buttons;
}

function add_pepfeed_tinymce_plugin($plugin_array)
{
    $plugin_array['pepfeed'] = wp_make_link_relative(plugin_dir_url(__FILE__)) . 'pepfeed_editor.js';
    return $plugin_array;
}

function my_refresh_mce($ver)
{
    $ver += 3;
    return $ver;
}
//add_filter( 'tiny_mce_version', 'my_refresh_mce');


//Returns plugin version
function pepfeed_cc_author_admin_init()
{
    $plugin_data    = get_plugin_data(__FILE__);
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}
add_action('admin_init', 'pepfeed_cc_author_admin_init');
