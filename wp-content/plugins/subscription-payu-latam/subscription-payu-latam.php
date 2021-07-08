<?php
/*
Plugin Name: Subscription Payu Latam
Description: payU latam subscription use sdk.
Version: 2.0.4
Author: Saul Morales Pacheco
Author URI: https://saulmoralespa.com
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: subscription-payu-latam
Domain Path: /languages/
WC tested up to: 4.4
WC requires at least: 4.0
*/

if (!defined( 'ABSPATH' )) exit;

if(!defined('SUBSCRIPTION_PAYU_LATAM_SPL_VERSION'))
    define('SUBSCRIPTION_PAYU_LATAM_SPL_VERSION', '2.0.4');

add_action('plugins_loaded','subscription_payu_latam_spl_init',0);

function subscription_payu_latam_spl_init(){

    load_plugin_textdomain('subscription-payu-latam', FALSE, dirname(plugin_basename(__FILE__)) .
        '/languages');

    if (!requeriments_subscription_payu_latam_spl()) return;

    suscription_payu_latam_pls()->run_payu_latam();

    if ( get_option( 'subscription_payu_latam_spl_redirect', false ) ) {
        delete_option( 'subscription_payu_latam_spl_redirect' );
        wp_redirect( admin_url( 'admin.php?page=subscription-payu-latam-install-setp' ) );
    }
}

add_action('notices_subscription_payu_latam_spl', 'subscription_payu_latam_spl_notices', 10, 1);

function subscription_payu_latam_spl_notices($notice){
    ?>
    <div class="error notice">
        <p><?php echo $notice; ?></p>
    </div>
    <?php
}

function requeriments_subscription_payu_latam_spl(){

    if ( version_compare( '5.6.0', PHP_VERSION, '>' ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            $php = __( 'Subscription Payu Latam: Requires php version 5.6.0 or higher.',
                'subscription-payu-latam' );
            add_action(
                'admin_notices',
                function() use($php) {
                    subscription_payu_latam_spl_notices($php);
                }
            );
        }
        return false;
    }

    $openssl_warning = __( 'Subscription Payu Latam: Requires OpenSSL >= 1.0.1 to be installed on your server',
        'subscription-payu-latam' );

    if ( ! defined( 'OPENSSL_VERSION_TEXT' ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            add_action(
                'admin_notices',
                function() use($openssl_warning) {
                    subscription_payu_latam_spl_notices($openssl_warning);
                }
            );
        }
        return false;
    }

    preg_match( '/^(?:Libre|Open)SSL ([\d.]+)/', OPENSSL_VERSION_TEXT, $matches );
    if ( empty( $matches[1] ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            add_action(
                'admin_notices',
                function() use($openssl_warning) {
                    subscription_payu_latam_spl_notices($openssl_warning);
                }
            );
        }
        return false;
    }

    if ( ! version_compare( $matches[1], '1.0.1', '>=' ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            add_action(
                'admin_notices',
                function() use($openssl_warning) {
                    subscription_payu_latam_spl_notices($openssl_warning);
                }
            );
        }
        return false;
    }

    if ( !in_array(
        'woocommerce/woocommerce.php',
        apply_filters( 'active_plugins', get_option( 'active_plugins' ) ),
        true
    ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            $woo = __( 'Subscription Payu Latam: Woocommerce must be installed and active.',
                'subscription-payu-latam' );
            add_action(
                'admin_notices',
                function() use($woo) {
                    subscription_payu_latam_spl_notices($woo);
                }
            );
        }
        return false;
    }

    if (!class_exists('WC_Subscriptions')){
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            $subs = __( 'Subscription Payu Latam: Woocommerce Subscriptions must be installed and active, ',
                    'subscription-payu-latam' ) .
                sprintf(__('%s', 'subscription-payu-latam' ),
                    '<a href="https://wordpress.org/plugins/subscription-payu-latam/#what%20else%20should%20i%20keep%20in%20mind%2C%20that%20you%20have%20not%20told%20me%20%3F">' .
                    __('check the documentation for help', 'subscription-payu-latam') . '</a>' );
            add_action(
                'admin_notices',
                function() use($subs) {
                    subscription_payu_latam_spl_notices($subs);
                }
            );
        }
    }

    $shop_currency = get_option('woocommerce_currency');

    if (!in_array($shop_currency, array('USD','BRL','COP','MXN','PEN'))){
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            $currency = __('Subscription Payu Latam: Requires one of these currencies USD, BRL, COP, MXN, PEN ',
                    'subscription-payu-latam' )  .
                sprintf(__('%s', 'subscription-payu-latam' ), '<a href="' . admin_url() .
                    'admin.php?page=wc-settings&tab=general#s2id_woocommerce_currency">' .
                    __('Click here to configure', 'subscription-payu-latam') . '</a>' );
            add_action(
                'admin_notices',
                function() use($currency) {
                    subscription_payu_latam_spl_notices($currency);
                }
            );
        }
        return false;
    }

    $woo_countries = new WC_Countries();
    $default_country = $woo_countries->get_base_country();
    if (!in_array($default_country, array('BR','CO','MX','PE'))){
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            $country = __('Subscription Payu Latam: It requires that the country of the store be some of these countries Brazil, Colombia, Mexico and Peru ',
                    'subscription-payu-latam' )  .
                sprintf(__('%s', 'subscription-payu-latam' ),
                    '<a href="' . admin_url() . 'admin.php?page=wc-settings&tab=general#s2id_woocommerce_currency">' .
                    __('Click here to configure', 'subscription-payu-latam') . '</a>' );
            add_action(
                'admin_notices',
                function() use($country) {
                    subscription_payu_latam_spl_notices($country);
                }
            );
        }
        return false;
    }
    return true;
}

function suscription_payu_latam_pls()
{
    static $plugin;
    if (!isset($plugin)){
        require_once('includes/class-subscription-payu-latam-plugin.php');
        $plugin = new Subscription_Payu_Latam_SPL_Plugin(__FILE__, SUBSCRIPTION_PAYU_LATAM_SPL_VERSION, 'subscription payu latam');
    }
    return $plugin;
}

function activation_subscription_payu_latam_spl(){
    wp_schedule_event( time(), 'hourly', 'subscription_payu_latam_spl' );
    add_option( 'subscription_payu_latam_spl_redirect', true );
}

function deactivation_subscription_payu_latam_spl(){
    global $wpdb;
    $table_name = $wpdb->prefix . "subscription_payu_latam_spl_transactions";
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option('subscription_payu_latam_spl_version');
    wp_clear_scheduled_hook( 'subscription_payu_latam_spl' );
}

register_activation_hook(__FILE__,'activation_subscription_payu_latam_spl');
register_deactivation_hook( __FILE__, 'deactivation_subscription_payu_latam_spl' );