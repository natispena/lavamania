<?php
/**
 * Created by PhpStorm.
 * User: smp
 * Date: 12/04/18
 * Time: 12:09 PM
 */

class WC_Payment_Subscription_Payu_Latam_SPL extends WC_Payment_Gateway
{
    public function __construct()
    {
        $this->id = 'subscription_payu_latam';
        $this->icon = suscription_payu_latam_pls()->plugin_url . 'assets/img/logoPayU.png';
        $this->method_title = __('Subscription Payu Latam', 'subscription-payu-latam');
        $this->method_description = __('Subscription Payu Latam of recurring payments.', 'subscription-payu-latam');
        $this->description  = $this->get_option( 'description' );
        $this->order_button_text = __('to subscribe', 'subscription-payu-latam');
        $this->has_fields = true;
        $this->supports = array(
            'subscriptions',
            'subscription_suspension',
            'subscription_reactivation',
            'subscription_cancellation',
            'subscription_date_changes'
        );
        $this->init_form_fields();
        $this->init_settings();
        $this->title = $this->get_option('title');

        $this->isTest = $this->get_option( 'environment' );
        $this->debug = $this->get_option( 'debug' );
        $this->currency = get_option('woocommerce_currency');

        if ($this->isTest){
            $this->merchant_id  = $this->get_option( 'sandbox_merchant_id' );
            $this->account_id  = $this->get_option( 'sandbox_account_id' );
            $this->apikey  = $this->get_option( 'sandbox_apikey' );
            $this->apilogin  = $this->get_option( 'sandbox_apilogin' );
        }else{
            $this->merchant_id  = $this->get_option( 'merchant_id' );
            $this->account_id  = $this->get_option( 'account_id' );
            $this->apikey  = $this->get_option( 'apikey' );
            $this->apilogin  = $this->get_option( 'apilogin' );
        }

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        add_action('woocommerce_subscription_status_cancelled', array($this, 'subscription_cancelled'));
        add_action('woocommerce_available_payment_gateways', array($this, 'disable_non_subscription'), 20);
        add_action('woocommerce_api_'.strtolower(get_class($this)), array($this, 'confirmation_ipn'));
    }


    public function is_available()
    {
        return parent::is_available() &&
            !empty( $this->merchant_id ) &&
            !empty( $this->account_id ) &&
            !empty( $this->apikey ) &&
            !empty( $this->apilogin );
    }

    public function init_form_fields()
    {

        $this->form_fields = require( dirname( __FILE__ ) . '/admin/payu-settings.php' );
    }

    public function admin_options()
    {
        ?>
        <h3><?php echo $this->title; ?></h3>
        <p><?php echo $this->method_description; ?></p>
        <table class="form-table">
            <?php
            if(!empty($this->merchant_id) &&
                !empty($this->account_id) &&
                !empty($this->apikey) &&
                !empty($this->apilogin)){
                $this->test_suscription_payu_latam();
            }else{
                do_action('notices_subscription_payu_latam_spl',
                    __('Could not perform any tests, because you have not entered all the required fields',
                        'subscription-payu-latam'));
            }
            $this->generate_settings_html();
            ?>
        </table>
        <?php
    }


    public function payment_fields()
    {

        if ( $description = $this->get_description() )
            echo wp_kses_post( wpautop( wptexturize( $description ) ) );

        ?>
        <div id="card-payu-latam-suscribir">
            <div class='card-wrapper'></div>
            <div id="form-payu-latam">
                <label for="number" class="label"><?php echo __('Data of card','subscription-payu-latam'); ?> *</label>
                <input placeholder="<?php echo __('Card number','subscription-payu-latam'); ?>" type="tel" name="subscriptionpayulatam_number" id="subscriptionpayulatam_number" required="" class="form-control">
                <input placeholder="<?php echo __('Cardholder','subscription-payu-latam'); ?>" type="text" name="subscriptionpayulatam_name" id="subscriptionpayulatam_name" required="" class="form-control">
                <input type="hidden" name="subscriptionpayulatam_type" id="subscriptionpayulatam_type">
                <input placeholder="MM/YY" type="tel" name="subscriptionpayulatam_expiry" id="subscriptionpayulatam_expiry" required="" class="form-control" >
                <input placeholder="123" type="number" name="subscriptionpayulatam_cvc" id="subscriptionpayulatam_cvc" required="" class="form-control" maxlength="4">
            </div>
            <div class="error-subscription-payu-latam" style="display: none">
                <span class="message"></span>
            </div>
        </div>
        <?php
    }

    public function process_payment($order_id)
    {
        $params = $_POST;
        $params['id_order'] = $order_id;

        $suscription = new Subscription_Payu_Latam_SPL();

        $data = $suscription->subscription_payu_latam($params);

        if($data['status']){
            wc_reduce_stock_levels($order_id);
            WC()->cart->empty_cart();
            return array(
                'result' => 'success',
                'redirect' => $data['url']
            );
        }else{
            wc_add_notice($data['message'], 'error' );
        }

        return parent::process_payment($order_id);

    }

    public function test_suscription_payu_latam()
    {
        $sucri = new Subscription_Payu_Latam_SPL();
        $sucri->executePayment();
    }

    public function subscription_cancelled($subscription)
    {

        $id = $subscription->get_id();
        $suscription_id = get_post_meta( $id, 'subscription_payu_latam_id', true );
        $idClient = get_post_meta($id, 'subscription_payu_latam_id_client', true);

        $sucri = new Subscription_Payu_Latam_SPL();
        $sucri->cancelSubscription($suscription_id);
        $sucri->deleteClient($idClient);

    }

    public function disable_non_subscription($availableGateways)
    {
        $enable = WC_Subscriptions_Cart::cart_contains_subscription();

        if (!$enable)
        {
            if (isset($availableGateways[$this->id]))
            {
                unset($availableGateways[$this->id]);
            }
        }
        return $availableGateways;
    }

    public function confirmation_ipn()
    {
        $body = file_get_contents('php://input');

        parse_str($body, $data);

        if ($this->debug === 'yes' && !$this->isTest){
            suscription_payu_latam_pls()->log('NOTIFICATION');
            suscription_payu_latam_pls()->log($data);
        }

        $reference_sale = $data['reference_sale'];
        $state_pol = $data['state_pol'];
        $sign =  $data['sign'];
        $value = $data['value'];

        if (!empty($data['extra1'])){
            $order_id = $data['extra1'];

            $value = $this->formattedAmount($value, 1);

            $subscription = new WC_Subscription($order_id);

            $dataSign = [
                'referenceSale' =>  $reference_sale,
                'amount' =>  $value,
                'currency' => $subscription->get_currency(),
                'state_pol' => $state_pol
            ];

            $signatureOrder = $this->getSignCreate($dataSign);

            $next_payment = $subscription->get_time( 'next_payment' );
            $next_payment = $this->convertDate($next_payment);
            $date_next_payment_payu = strtotime($data['date_next_payment']);
            $date_next_payment_payu = $this->convertDate($date_next_payment_payu);
            $period = $subscription->billing_period;

            $days_passed = $this->differenceDays($next_payment, $date_next_payment_payu);

            $note_reference_sale = sprintf(__('(Reference of sale: %s)',
                'subscription-payu-latam'), $reference_sale);

            if ($sign === $signatureOrder){

                if ($subscription->get_status() === 'pending' && $state_pol === '4'){
                    $subscription->payment_complete();
                    $subscription->add_order_note($note_reference_sale);
                    //$calculated_next_payment = $subscription->calculate_date('next_payment');
                    //$subscription->update_dates(['next_payment' => $calculated_next_payment]);
                }elseif ($subscription->get_status() === 'active' &&
                    ($state_pol !== '4' && $state_pol !== '7') &&
                    ($period === 'day' || $days_passed === 2)){
                    $subscription->cancel_order($note_reference_sale);
                }
            }

        }

        header("HTTP/1.1 200 OK");
    }


    public function formattedAmount($amount, $decimals = 2)
    {
        $amount = number_format($amount, $decimals,'.','');
        return $amount;
    }

    public function getSignCreate(array $data = [])
    {
        return md5(
        $this->apikey . "~" .
            $this->merchant_id . "~" .
            $data['referenceSale'] . "~".
            $data['amount'] . "~".
            $data['currency'] . "~".
            $data['state_pol']
        );
    }

    public function convertDate($time)
    {
        $date = date('Y/m/d', $time);
        return $date;
    }

    public function differenceDays($date, $date1)
    {
        $dStart = new DateTime($date);
        $dEnd  = new DateTime($date1);

        $dDiff = $dStart->diff($dEnd);
        return $dDiff->days;
    }
}