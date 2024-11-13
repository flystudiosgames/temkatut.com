var stripe = null;
var form = document.getElementById('payment-form');
var formBtn = document.querySelector('button');
var formBtnText = document.querySelector('#button-text');
var formSpinner = document.querySelector('#spinner');
var cardErrorContainer = document.getElementById('card-errors');
var errorContainer = document.querySelector('.sr-field-error');
var resultContainer = document.querySelector('.sr-result');
var preContainer = document.querySelector('pre');

function parse_query_string(query)
{
	var vars = query.split("&");
	var query_string = {};

	for (var i = 0; i < vars.length; i++) 
	{
		var pair = vars[i].split("=");
		var key = decodeURIComponent(pair[0]);
		var value = decodeURIComponent(pair[1]);

		if (typeof query_string[key] === "undefined")
		{
			query_string[key] = decodeURIComponent(value);
		}
		else if (typeof query_string[key] === "string") 
		{
			var arr = [query_string[key], decodeURIComponent(value)];
			query_string[key] = arr;
		} 
		else
		{
			query_string[key].push(decodeURIComponent(value));
		}
	}
	return query_string;
}

document.addEventListener('DOMContentLoaded', function () 
{
	var stripePublicKey = form.dataset.stripePublicKey;
	stripe = Stripe(stripePublicKey);
	var card = stripe.elements().create('card', 
	{
		hidePostalCode: true,
		style: 
		{
			base: 
			{
				color: '#32325d',
				fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
				fontSmoothing: 'antialiased',
				fontSize: '16px',
				'::placeholder': 
				{
					color: '#aab7c4',
				},
			},
			invalid: 
			{
				color: '#fa755a',
				iconColor: '#fa755a',
			},
		},
	});

	card.mount('#card-element');

	card.addEventListener('change', function (e) 
	{
		if (e.error) 
		{
			cardErrorContainer.classList.add('show');
			cardErrorContainer.textContent = e.error.message;
		}
		else
		{
			cardErrorContainer.classList.remove('show');
			cardErrorContainer.textContent = '';
		}
	});

	form.addEventListener('submit', function (event) 
	{
		event.preventDefault();
		pay(stripe, card);
	});
});

var pay = function (stripe, card) 
{
	changeLoadingState(true);

	var qs = parse_query_string(window.location.search.substring(1));

	stripe
		.createPaymentMethod('card', card)
		.then(function (result)
		{
			if (result.error) 
			{
				showError(result.error.message);
				throw result.error.message;
			}
			else
			{
				return fetch('/payment', 
				{
					method: 'POST',
					headers: 
					{
						'Content-Type': 'application/json',
					},
					body: JSON.stringify({
						paymentMethodId: result.paymentMethod.id,
						product: qs.product,
					}),
				});
			}
		})
		.then(function (result) 
		{
			return result.json();
		})
		.then(function (paymentData) 
		{
			if (paymentData.requiresAction) 
			{
				handleAction(paymentData.clientSecret);
			}
			else if (paymentData.error) 
			{
				showError(paymentData.error);
			}
			else
			{
				orderComplete(paymentData.clientSecret);
			}
		})
		.catch(function (error) 
		{
			console.log(error);
		});
};

var handleAction = function (clientSecret) 
{
	var qs = parse_query_string(window.location.search.substring(1));

	stripe
		.handleCardAction(clientSecret)
		.then(function (data) 
		{
			if (data.error) 
			{
				showError('Your card hasn\'t been authenticated, please try again.');
			} 
			else if (data.paymentIntent.status === 'requires_confirmation') 
			{
				fetch('/payment', 
				{
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify({
						paymentIntentId: data.paymentIntent.id,
						product: qs.product,
					}),
				})
				.then(function (result) 
				{
					return result.json();
				})
				.then(function (response) 
				{
					if (response.error) 
					{
						showError(response.error);
					}
					else 
					{
						orderComplete(clientSecret);
					}
				});
			}
		});
};

var orderComplete = function (clientSecret) 
{
	stripe
		.retrievePaymentIntent(clientSecret)
		.then(function (result) 
		{
			form.classList.add('hidden');
			resultContainer.classList.remove('hidden');

			changeLoadingState(false);
		});
};

var showError = function (errorMsgText) 
{
	changeLoadingState(false);

	errorContainer.textContent = errorMsgText;

	setTimeout(function () 
	{
		errorContainer.textContent = '';
	}, 4000);
};

var changeLoadingState = function (isLoading) 
{
	if (isLoading) 
	{
		formBtn.disabled = true;
		formSpinner.classList.remove('hidden');
		formBtnText.classList.add('hidden');
	}
	else
	{
		formBtn.disabled = false;
		formSpinner.classList.add('hidden');
		formBtnText.classList.remove('hidden');
	}
};
