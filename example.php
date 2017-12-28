<?php

require_once 'vendor/autoload.php';

use Payopm\AddressBook\Contact;
use Payopm\Invoicing\Invoice;
use Payopm\Invoicing\Item;
use Payopm\InvoicingApi\Invoicing;

$apiConfiguration = array(
    'user_id' => '', // USER ID of the PAYOPM API configuration
    'username' => '', // Username of PAYOPM
    'api_key' => '' // API key of the PATOPM API configuration
);

$invoicing = new Invoicing(
    $apiConfiguration['user_id'],
    $apiConfiguration['username'],
    $apiConfiguration['api_key']
);

// Example: getting the existent address books.
$addressBookNames = array();
try {

    echo "Getting address book names... ";

    $addressBookNames = $invoicing->listAddressBooks();

    foreach ($addressBookNames as $addressBookName) {
        echo PHP_EOL . " $addressBookName";
    }

    echo PHP_EOL;

} catch (Exception $ex) {

    echo $ex->getMessage() . PHP_EOL;

}

// Example: creating a new address book.
$addressBookName = 'example';
try {
    echo "Create a new address book... ";

    if(!in_array($addressBookName, $addressBookNames)) {
        $invoicing->createAddressBook($addressBookName);
        echo "OK" . PHP_EOL;
    } else {
        echo "This address book already exists. There's no need to create another one :)" . PHP_EOL;
    }

} catch(Exception $ex) {

    echo $ex->getMessage() . PHP_EOL;

}

// Example: creating a contact
$contactEmail = 'example@example.com';
try {
    echo "Creating a contact... ";

    $contact = new Contact();

    $contact
        ->setFirstName('Contact')
        ->setLastName('Example')
        ->setEmail($contactEmail)
        ->setBusinessName('Contact Exmaple, Inc.')
        ->setCountry('US')
        ->setAddressLine1('963 Lovelace Road')
        ->setCity('Tampa Bay')
        ->setState('Florida')
        ->setPostalCode('25235')
        ->setAddressBookName($addressBookName);

    $invoicing->createContact($contact);

    echo "OK" . PHP_EOL;

} catch(Exception $ex) {

    echo $ex->getMessage() . PHP_EOL;

}

// Example: registering an invoice
try {
    echo "Registering an invoice... ";

    $invoice = new Invoice();

    $invoice
        ->setCustomerId('12345')
        ->setReference('REF-EXMAPLE-123')
        ->setCurrency('EUR')
        ->setInvoiceDate(new \DateTime())
        ->setPaymentDate(new \DateTime())
        ->setPaymentTerm(Invoice::PAYMENT_TERMS_DUE_ON_DATE)
        ->setGeneralTerms('General terms example')
        ->setRecipient($contactEmail)
        ->setRecipientNote('Recipient note example');

    $item1 = new Item();
    $item1
        ->setName('Item 1')
        ->setDescription('Description of item 1')
        ->setQuantity(1)
        ->setPrice(12.5);

    $item2 = new Item();
    $item2
        ->setName('Item 2')
        ->setDescription('Description of item 2')
        ->setQuantity(5)
        ->setPrice(5);

    $invoice->setItems(array($item1, $item2));

    $invoiceNumber = $invoicing->registerInvoice($invoice);

    echo "OK" . PHP_EOL;
    echo " Invoice number: " . $invoiceNumber . PHP_EOL;

    echo "Retrieving PDF version of the invoice... ";
    $pdfInvoice = $invoicing->getInvoice($invoiceNumber);

    $file = fopen(__DIR__ . '/invoice_' . $invoiceNumber . '.pdf', "wb");
    fwrite($file, $pdfInvoice);
    fclose($file);
    echo "OK. PDF file was saved in invoice_$invoiceNumber.pdf" . PHP_EOL;

} catch(Exception $ex) {

    echo $ex->getMessage() . PHP_EOL;

}

echo "Done!" . PHP_EOL;