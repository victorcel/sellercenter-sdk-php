<?php

use RocketLabs\SellerCenterSdk\Core\Client;
use RocketLabs\SellerCenterSdk\Core\Configuration;
use RocketLabs\SellerCenterSdk\Core\Response\ErrorResponse;
use RocketLabs\SellerCenterSdk\Endpoint\Endpoints;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

$client = Client::create(new Configuration(SC_API_URL, SC_API_USER, SC_API_KEY));

$productCollectionRequest = Endpoints::product()->productCreate();

// Example matching the desired XML structure
$productCollectionRequest->newProduct()
    ->setSellerSku('ASM_A80102')
    ->setParentSku(null)
    ->setName('Product')
    ->setPrimaryCategory(4)
    ->setCategories('2,3,5')
    ->setDescription('product description')
    ->setBrand('ASM')
    ->setShipmentType('dropshipping')
    ->setProductId('xyzabc')
    ->setCondition('new')
    ->setProductData([
        'Megapixels' => '490',
        'OpticalZoom' => '7',
        'SystemMemory' => '4',
        'NumberCpus' => '32',
        'Network' => 'This is network'
    ])
    ->addBusinessUnit(
        'facl',           // OperatorCode
        999.00,           // Price
        null,             // SpecialPrice (optional)
        null,             // SpecialFromDate (optional)
        null,             // SpecialToDate (optional)
        10,               // Stock
        'active'          // Status
    );

$response = $productCollectionRequest->build()->call($client);

if ($response instanceof ErrorResponse) {
    /** @var ErrorResponse $response */
    printf("ERROR !\n");
    printf("%s\n", $response->getMessage());
} else {
    printf("The feed `%s` has been created.\n", $response->getFeedId());
}