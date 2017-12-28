# PAYOPM Invoicing API client usage

This example shows how to use the invoicing API provided by [PAYOPM](https://www.payopm.com). Please follow the instructions to work with this invoicing service.

## Installation

1. Download or clone [this repository](https://github.com/payopm/invoicing-api-client-php-example).
2. Execute `composer install` into the root directory. If you don't have Composer, [install it](https://getcomposer.org/).

It will download the required source code to interact against the PAYOPM invoicing API.

## Run the example

1. Get the API credentials from the [API manager](https://www.payopm.com/en/account/apimanager/).
2. Open the `example.php` file and fill `$apiConfiguration` with your API credentials.
3. Execute `php example.php` and see how the script interacts with the PAYOPM API.

You can create an additional account to test and try your own implementation before use your production account.

Read the code to become familiar with the API and its usage.

## Check the documentation

You can check the API documentation ()and implement your own API client if you want) checking the
`Payopm\InvoicingApi\Invoicing` class, located in `vendor/payopm/invoicing-api/src/InvoicingApi/Invoicing.php`.

## Troubleshooting

Be sure to have installed Composer, PHP 5.3 or above with the cURL extension. If you don't have all this requirements in your system, you can't use our API. If you're using another language than PHP, you must write your own API client. Download the package and check the source code for documentation and more information about writing another API client for our web services.