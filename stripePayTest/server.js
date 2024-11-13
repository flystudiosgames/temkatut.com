// server.js
const express = require('express');
const stripe = require('stripe')('sk_test_51QKi7QFyq1me4Qfs9guRAXF6K4nK0TZ97d2Ls0TGumpeEJpQumkoYVZRVlQaHMHj5HcYzU3ymnG4prr5adQmFcEX00uGQUnTOl'); // Cheia secretă de test
const app = express();
app.use(express.static('public'));
app.use(express.json());

app.post('/create-checkout-session', async (req, res) => {
    try {
        const session = await stripe.checkout.sessions.create({
            payment_method_types: ['card'],
            line_items: [
                {
                    price_data: {
                        currency: 'usd',
                        product_data: {
                            name: 'Test Product',
                        },
                        unit_amount: 1000, // 10 USD in cents
                    },
                    quantity: 1,
                },
            ],
            mode: 'payment',
            success_url: `https://temkatut.com/stripePayTest/success.html`,
            cancel_url: `https://temkatut.com/stripePayTest/cancel.html`,
        });

        res.json({ id: session.id });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Ascultă pe portul oferit de serverul de găzduire sau pe 3000 în mod implicit
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
