## AWTracker

A monthly subscription-based website visitor tracking web application.

### Steps for installing this project on your local machine

Run the below commands one by one in your terminal or cmd.

```
git clone git@github.com:github.com/aw-tracker.git
cd aw-tracker
composer install
cp .env.example .env
// Update your database credentials in the .env file
// Update mailtrap credentials in the .env file
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run dev
php artisan serve
```


### Usage Flow

#### On Stripe

- Register/Login to [Stripe Dashboard](https://dashboard.stripe.com/login)
- Add the Stripe Keys in the env file
- [Add Product](https://dashboard.stripe.com/test/products/create) in Stripe. These products will be Subscription based which means recurring payments on monthly basis.

#### On our app

- User registers
- Verification email sent to registered user
- User verifies their email address
- User logs in
- User adds company name, and address. Note that the state and the country needs to be 2 letters only.
- Go to [Customer's details on Stripe](https://dashboard.stripe.com/test/customers). Customer is now added into your Stripe account. The Stripe Customer ID is has also been mapped with our user. Check it in `users` table under `stripe_customer_id` column.
- Go to Subscription page. Add the following Card details.
```
Card No: 42424 4242 4242 4242
CVV/CVC: <Any 3 digit number>
Expiry Month and Year: <Any Future Month and Year>
Postal/Zip/Pin Code: <Any 5 digit number>
```
- When you enter your Card details, just before submitting, Stripe.js will create a `stripeToken`. This token holds the information about the Card that was just added. Clicking on `Add Card` Button will send this token to Stripe, and it will attach it to our customer/user.
- Before attaching, this `stripeToken` is stored in the `company` table under the `stripe_token` column.
- Adding a credit card details will create a source in Stripe, and attach it to the customer, as a `default_source`, for future payments making it super convenient for the user. The user will then not have to insert Card details while making the payment.
- On the Subscription page, select a plan (plan is the products that you have added in the Stripe), and click on `Submit Payment` button
- Once the payment is done, you can verify the payment details by going to the [Payments Tab in Stripe](https://dashboard.stripe.com/test/payments). You will get the full details about the payment flow.
