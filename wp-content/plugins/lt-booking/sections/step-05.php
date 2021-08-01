<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

/**
 * Booking Total and Form
 */

if ( !function_exists( 'lt_booking_step_05_shortcode' ) ) {

	function lt_booking_step_05_shortcode( $atts ) {

		$out = '';
		$num = '05';

		$id = $atts['id'];

		$config = fw_get_db_post_option( $id );		

    $config['domain'] = get_site_url();

    $config['ltb-sid'] = md5(time() . 'ltb');

		$out = ltb_section_start( $config, $num );

		$out .= '<div class="row row-centered">';

			$out .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';

				$out .= ltb_the_total_grid($config);

			$out .= '</div>';

			$out .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';

				$out .= ltb_the_form($config, $id);

        // Stripe Payments Button
				if ( !empty($config['payments']['payments']) AND
             ($config['payments']['payments'] == 'stripe') AND
             !empty($config['payments']['stripe']['stripe-pk']) AND
             !empty($config['payments']['stripe']['stripe-sk']) ) {

            wp_localize_script( 'lt-booking', 'ltb_stripe', array(
              'pk'      =>  $config['payments']['stripe']['stripe-pk'],
              'domain'  =>  get_site_url(),
            ) );          

					$out .= '<div class="ltb-payment-btn-wrapper"><input type="submit" id="ltb-payment-submit" data-domain="'.esc_attr($config['domain']).'" class="btn btn-lg btn-main color-hover-white" value="'.esc_html($config['payments']['stripe']['stripe-button-header']).'"></div>';
				}


        // Payfast Payments Button
        if ( !empty($config['payments']['payments']) AND
             ($config['payments']['payments'] == 'payfast') AND
             !empty($config['payments']['payfast']['payfast-id']) AND
             !empty($config['payments']['payfast']['payfast-key']) ) {

              if ( !empty($config['payments']['payfast']['payfast-sandbox']) ) {

                $payfast_url = 'https://sandbox.payfast.co.za/eng/process';
              }
                else {

                $payfast_url = 'ttps://www.payfast.co.za/eng/process';
              }

              $cancel_url = ltb_get_local_url($config['payments']['payfast']['payfast-cancel-url'], $config['domain']);
              $return_url = ltb_get_local_url($config['payments']['payfast']['payfast-success-url'], $config['domain']);

              $out .= '<div class="ltb-payment-btn-wrapper ltb-payfast-amount">
                <form action="'.esc_url($payfast_url).'" method="post">
                   <input type="hidden" name="merchant_id" value="'.esc_attr($config['payments']['payfast']['payfast-id']).'">
                   <input type="hidden" name="merchant_key" value="'.esc_attr($config['payments']['payfast']['payfast-key']).'">
                   <input type="hidden" name="amount" id="ltb-amount" value="0">
                   <input type="hidden" name="item_name" value="'.esc_attr($config['payments']['payfast']['payfast-id']).'">

                  <input type="hidden" name="return_url" value="'.esc_url($return_url).'">
                  <input type="hidden" name="notify_url" value="'.esc_url($config['domain'] . '/ltb-success/').'">
                  <input type="hidden" name="cancel_url" value="'.esc_url($cancel_url).'">

                  <input type="hidden" name="custom_str1" value="'.esc_attr($config['ltb-sid']).'">  

                   <input type="submit" id="ltb-payment-submit" data-domain="'.esc_attr($config['domain']).'" class="btn btn-lg btn-main color-hover-white" value="'.esc_html($config['payments']['payfast']['payfast-button-header']).'">
                </form>
              </div>';          
        }

			$out .= '</div>';

		$out .= '</div>';

		$out .= ltb_section_end( $config, $num );

		return $out;
	}
}
add_shortcode( 'lt-booking-step-05', 'lt_booking_step_05_shortcode' );


add_action( 'init', function() {
    add_rewrite_endpoint( 'ltb-create-checkout-session', EP_PERMALINK );
    add_rewrite_endpoint( 'ltb-success', EP_PERMALINK );
//    add_rewrite_endpoint( 'ltb-cancel', EP_PERMALINK );
} );


add_action( 'template_redirect', function() {

  global $wp_query;

  if ( ! isset( $wp_query->query_vars['name']) OR $wp_query->query_vars['name'] != 'ltb-success' ) {
      return;
  }

  lt_booking_success();
});

if ( !function_exists( 'lt_booking_success' ) ) {

  function lt_booking_success( ) {

    global $wpdb;

    if ( !empty($_GET['session_id']) ) {

      $session_id = $_GET['session_id'];
      $results = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE `meta_value` LIKE '%".esc_sql($session_id)."%' LIMIT 4" );

      if ( !empty($results->post_id) AND !empty($results->post_id) ) {

        fw_set_db_post_option($results->post_id, 'payment', 2);

        $point = fw_get_db_post_option($results->post_id, 'point');
        $config = fw_get_db_post_option($point);

        wp_safe_redirect( $config['payments']['stripe']['stripe-success-url'] );
        die();
      }
    }
      else
    if ( !empty($_POST['pf_payment_id']) ) {

      $session_id = $_POST['custom_str1'];
      $results = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE `meta_value` LIKE '%".esc_sql($session_id)."%' LIMIT 4" );

      if ( !empty($results->post_id) AND !empty($results->post_id) ) {

        fw_set_db_post_option($results->post_id, 'payment', 2);

        $point = fw_get_db_post_option($results->post_id, 'point');
        $config = fw_get_db_post_option($point);

        wp_safe_redirect( $config['payments']['stripe']['stripe-success-url'] );
        die();
      }
    }
  }
}


add_action( 'template_redirect', function() {

  global $wp_query;

  if ( ! isset( $wp_query->query_vars['name']) OR $wp_query->query_vars['name'] != 'ltb-create-checkout-session' ) {
      return;
  }

  lt_booking_checkout_register();

});

if ( !function_exists( 'lt_booking_checkout_register' ) ) {

  function lt_booking_checkout_register( ) {

    if ( !class_exists('Stripe\Stripe') ) {

	    require LTB_PLUGIN_DIR . 'vendor/stripe/stripe-php/init.php';
    }

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $input = file_get_contents('php://input');
      $body = json_decode($input);  
    }

    $config = fw_get_db_post_option($body->point);
    $order = fw_get_db_post_option($body->id);

    \Stripe\Stripe::setApiKey($config['payments']['stripe']['stripe-sk']);


    $quantity = 1;

    $config['domain'] = get_site_url();

    $cancel_url = ltb_get_local_url($config['payments']['stripe']['stripe-cancel-url'], $config['domain']);

    if ( empty($config['payments']['stripe']['stripe-tax-id']) ) {

      $config['payments']['stripe']['stripe-tax-id'] = null;
    } 
      else {

        $config['payments']['stripe']['stripe-tax-id'] = array(esc_html($config['payments']['stripe']['stripe-tax-id']));
    }

    $payment_method = explode(',', str_replace(' ', '', $config['payments']['stripe']['stripe-payment-method']));

    if ( empty($payment_method) OR (is_array($payment_method)) AND empty($payment_method[0]) ) $payment_method = ['card'];

    $checkout_session = \Stripe\Checkout\Session::create([
      'success_url' => $config['domain'] . '/ltb-success/?session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => $cancel_url,
      'payment_method_types' => $payment_method,
      'mode' => 'payment',
      'line_items' => [[
        'name' => esc_html($config['payments']['stripe']['stripe-payment-name']),
        'amount' => (int)($order['price'] * 100),
        'quantity' => $quantity,
        'currency' => esc_html($config['payments']['stripe']['stripe-currency']),
        'tax_rates' =>  $config['payments']['stripe']['stripe-tax-id'],
      ]]
    ]);

    fw_set_db_post_option((int)($body->id), 'ltb-payment-session', $checkout_session['id']);
    fw_set_db_post_option((int)($body->id), 'payment', 1);
      
    echo json_encode(['sessionId' => $checkout_session['id']]);
    die();
  }
}


