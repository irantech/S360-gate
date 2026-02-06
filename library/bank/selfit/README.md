# SELFiT Payment Gateway Integration

This module integrates the SELFiT payment gateway with the GDS system. The SELFiT gateway provides a secure and reliable way to process payments using the SELFiT API.

## Features

- Authentication using API credentials
- Payment request generation
- Payment verification
- Payment cancellation
- Transaction tracking

## Setup

1. Go to Admin Panel > Bank Management > Add Bank
2. Select "درگاه سلفیت (SELFiT)" from the dropdown
3. Enter your SELFiT API credentials:
   - Username: Your SELFiT API username
   - Password: Your SELFiT API password
4. Select the appropriate service
5. Set currency option
6. Save the bank settings

## API Parameters

- **Username (param1)**: Your SELFiT API username
- **Password (param2)**: Your SELFiT API password
- **Custom Data (param3)**: Optional parameters (not required for basic integration)

## API Endpoint

The SELFiT API endpoints are:

- Authentication: `https://api.selfit.ir/api/ThirdParty/v1/Authentication`
- Payment URL: `https://api.selfit.ir/api/ThirdParty/v1/Pay/GetPaymentUrl`
- Inquiry: `https://api.selfit.ir/api/ThirdParty/v1/Pay/Inquiry`
- Cancel: `https://api.selfit.ir/api/ThirdParty/v1/Pay/Cancel`

## Transaction Flow

1. User selects SELFiT as the payment method
2. System authenticates with SELFiT API
3. System generates a payment URL
4. User is redirected to SELFiT payment page
5. After payment, user is redirected back to the callback URL
6. System verifies the payment status
7. Transaction status is updated accordingly

## Logs

All SELFiT API interactions are logged in the `selfit_log` file for debugging and tracking purposes.

## Support

For any issues or questions, please contact the SELFiT API support:
- Email: ma.amrollahi@hiweb.ir
- Mobile: +98 919 00 919 97 