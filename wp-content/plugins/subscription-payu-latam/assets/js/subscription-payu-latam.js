jQuery( function( $ ) {
    'use strict';

    const checkout_form = $( 'form.checkout, form#order_review' );

    $(document.body).on('checkout_error', function () {
        checkout_form.find('input[name=subscription_payu_latam_card]').remove();
    });

    $(document.body).on( 'updated_checkout', function() {

        $('input[name="payment_method"]').change(function(){
            if (checkout_form.find('#form-payu-latam').is(":visible"))
            {
                new Card({
                    // a selector or DOM element for the form where users will
                    // be entering their information
                    form: document.querySelector('#form-payu-latam'), // *required*
                    // a selector or DOM element for the container
                    // where you want the card to appear
                    container: '.card-wrapper', // *required*

                    formSelectors: {
                        numberInput: 'input#subscriptionpayulatam_number', // optional — default input[name="number"]
                        expiryInput: 'input#subscriptionpayulatam_expiry', // optional — default input[name="expiry"]
                        cvcInput: 'input#subscriptionpayulatam_cvc', // optional — default input[name="cvc"]
                        nameInput: 'input#subscriptionpayulatam_name' // optional - defaults input[name="name"]
                    },

                    width: 200, // optional — default 350px
                    formatting: true, // optional - default true

                    // Strings for translation - optional
                    messages: {
                        validDate: 'expire\ndate',
                        monthYear: 'mm/yyyy', // optional - default 'month/year'
                    },

                    // Default placeholders for rendered fields - optional
                    placeholders: {
                        number: '•••• •••• •••• ••••',
                        name: 'Full Name',
                        expiry: '••/••',
                        cvc: '•••'
                    },

                    masks: {
                        cardNumber: '•' // optional - mask card number
                    },

                    // if true, will log helpful messages for setting up Card
                    debug: false // optional - default false
                });
            }
        }).change();

    });

    function subscriptionPayuFormHandler(){
        if($('form[name="checkout"] input[name="payment_method"]:checked').val() === 'subscription_payu_latam'){

            if (!$( 'input[name=subscription_payu_latam_card]' ).length){

                if(subscriptionPayuLatamValidator()){

                    checkout_form.find('div.error-subscription-payu-latam').hide();
                    checkout_form.find('div.error-subscription-payu-latam span.message').text('');

                    let number_card = checkout_form.find('#subscriptionpayulatam_number').val();
                    let card_holder = checkout_form.find('#subscriptionpayulatam_name').val();
                    let card_expire = checkout_form.find('#subscriptionpayulatam_expiry').val();
                    let card_cvv = checkout_form.find('#subscriptionpayulatam_cvc').val();

                    card_expire = card_expire.replace(/ /g, '');
                    card_expire = card_expire.split('/');
                    let month = card_expire[0];
                    if (month.length === 1) month = `0${month}`;

                    let date = new Date();
                    let year = date.getFullYear();
                    year = year.toString();
                    let lenYear = year.substr(0, 2);
                    let yearEnd = 0;

                    if(card_expire[1]){
                        yearEnd = card_expire[1].length === 4 ? card_expire[1]  : lenYear + card_expire[1].substr(-2);
                        card_expire = `${yearEnd}/${month}`;
                    }

                    checkout_form.append($('<input name="subscriptionpayulatam_number" type="hidden" />' ).val( number_card ));
                    checkout_form.append($('<input name="subscriptionpayulatam_name" type="hidden" />' ).val( card_holder ));
                    checkout_form.append($('<input name="subscriptionpayulatam_type" type="hidden" />' ).val( getTypeCard() ));
                    checkout_form.append($('<input name="subscriptionpayulatam_expiry" type="hidden" />' ).val( card_expire ));
                    checkout_form.append($('<input name="subscriptionpayulatam_cvc" type="hidden" />' ).val( card_cvv ));

                    let errorCard;

                    if (!number_card || !card_holder || getTypeCard(checkout_form) === null || !card_expire || !card_cvv || !(card_cvv.length >= 3 && card_cvv.length < 5)){
                        errorCard = payu_latam_suscription.msjEmptyInputs;
                    }else if (!checkCard()){
                        errorCard = payu_latam_suscription.msjNoCard;
                    }else if(!valid_credit_card(number_card)){
                        errorCard = payu_latam_suscription.msjNoCardValidate;
                    }else if (!validateDate(yearEnd, month)){
                        errorCard = payu_latam_suscription.msgValidateDate;
                    }

                    if(errorCard){
                        checkout_form.find('div.error-subscription-payu-latam').show();
                        checkout_form.find('div.error-subscription-payu-latam span.message').text(errorCard);
                        checkout_form.append( '<input type="hidden" class="form_errors" name="form_errors_subscription_payu_latam" value="1">' );
                    }else{
                        checkout_form.find('input[name=form_errors_subscription_payu_latam]').remove();
                        checkout_form.append($('<input name="subscription_payu_latam_card" type="hidden" />' ).val( 1 ));
                        checkout_form.submit();
                    }

                    return false;
                }
            }

        }

        return true;
    }

    function subscriptionPayuLatamValidator(){

        return !(checkout_form.find('div.error-subscription-payu-latam span.message').text() && !checkout_form.find('input[name=form_errors_subscription_payu_latam]').length);

    }

    function checkCard(){
         let countryCode = payu_latam_suscription.country;
         let classCard = $(".jp-card-identified" ).attr( "class" );
         let inputCard = $("input[name=subscriptionpayulatam_type]");

         let  isAcceptableCard = false;

         switch(true) {
             case (classCard.indexOf('visa') !== -1 && countryCode !== 'PA'):
                 $(inputCard).val('VISA');
                 isAcceptableCard = true;
                 break;
             case (classCard.indexOf('mastercard') !== -1):
                 $(inputCard).val('MASTERCARD');
                 isAcceptableCard = true;
                 break;
             case (classCard.indexOf('amex') !== -1 && countryCode !== 'PA'):
                 $(inputCard).val('AMEX');
                 isAcceptableCard = true;
                 break;
             case (classCard.indexOf('diners') !== -1 && (countryCode !== 'MX' || countryCode !== 'PA') ):
                 $(inputCard).val('DINERS');
                 isAcceptableCard = true;
         }

         return isAcceptableCard;

     }

    function getTypeCard(){
         let classCard = checkout_form.find(".jp-card-identified" ).attr( "class" );

         if (typeof classCard === 'undefined')
             return null;

         let classTypeCard = classCard.split(' ');
         let typeCard = classTypeCard[1].split('jp-card-');
         return typeCard[1].toUpperCase();
     }

    function valid_credit_card(value) {
        // accept only digits, dashes or spaces
        if (/[^0-9-\s]+/.test(value)) return false;

        // The Luhn Algorithm. It's so pretty.
        var nCheck = 0, nDigit = 0, bEven = false;
        value = value.replace(/\D/g, "");

        for (var n = value.length - 1; n >= 0; n--) {
            var cDigit = value.charAt(n);
                nDigit = parseInt(cDigit, 10);

            if (bEven) {
                if ((nDigit *= 2) > 9) nDigit -= 9;
            }

            nCheck += nDigit;
            bEven = !bEven;
     }

        return (nCheck % 10) === 0;
    }

    function validateDate(yearEnd, month){

        let date = new Date();
        let currentMonth = ("0" + (date.getMonth() + 1)).slice(-2);
        let year = date.getFullYear();

        return (parseInt(yearEnd) > year) || (parseInt(yearEnd) === year && month >= currentMonth);
    }

    $( 'form.checkout' ).on( 'checkout_place_order', subscriptionPayuFormHandler );

    // Pay Page Form
    $( 'form#order_review' ).on( 'submit', subscriptionPayuFormHandler );

});