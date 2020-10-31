/**
 * This is the code to create a Stripe element. To have this work you'll need to 
 * push  <script src="https://js.stripe.com/v3/"></script> to your scripts
 */

$(function e() {    
    if (window.hasOwnProperty('Stripe')) {
        if ("fbq" in window) {
            fbq('track', 'AddToCart', {
                currency: cartInfo.currency, 
                value: cartInfo.total,
            });

            ga('require', 'ec');
            
            ga('ec:addProduct', {
                'id': cartInfo.id,
                'name': cartInfo.name,
                'category': cartInfo.category,
                'price': cartInfo.price,
                'quantity': cartInfo.quantity
            });

            ga('ec:setAction', 'add');

            ga('send', 'event', 'UX', 'click', 'add to cart');            
        }
        var stripe = Stripe(process.env.MIX_STRIPE_KEY);
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        // Create an instance of the card Element.
        var card = elements.create('card', {
            style: style
        });
        card.mount('#card-element');
        card.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            if ("fbq" in window) {
                fbq('track', 'Purchase', {
                    currency: cartInfo.currency, 
                    value: cartInfo.total,
                });

                ga('ec:addProduct', {
                    'id': cartInfo.id,
                    'name': cartInfo.name,
                    'category': cartInfo.category,
                    'price': cartInfo.price,
                    'quantity': cartInfo.quantity
                });

                ga('ec:setAction', 'purchase', {
                    'id': cartInfo.id,
                    'affiliation': 'Treiner.co',
                    'revenue': cartInfo.total,
                  });

                ga('send', 'pageview');             
            }
            if (document.getElementById('payment-method').getAttribute('value') == 'cash') {
                form.submit();
            }

            event.preventDefault();
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });
        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            // Submit the form
            form.submit();
        }
    }
});

