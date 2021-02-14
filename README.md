ShipX PHP SDK
=============

by Michał Biarda

## 1. Introduction

This package was created so you could easily connect your PHP app with Inpost ShipX API.

The documentation of ShipX API may be found here: https://docs.inpost24.com/display/PL/API+ShipX

The library is open sourced. Feel free to contribute!

## 2. Installation

The recommended way to install this package is through [Composer](https://getcomposer.org/).

```
composer require michalbiarda/shipx-php-sdk
```

**Watchout:** This package uses [HTTPlug](http://docs.php-http.org/en/latest/httplug/introduction.html) for HTTP client abstraction.
Please check their [official documentation](http://docs.php-http.org/en/latest/httplug/users.html) to understand how to configure it properly with your project.

## 3. Anatomy of SDK

### 3.1. API client creation

All calls to ShipX API are made through `\MB\ShipXSDK\Client\Client` object.
To create it, you need to provide API URL (production or sandbox) and your API key (for some actions API key is not needed).

```php
$client = new \MB\ShipXSDK\Client\Client(
    'https://sandbox-api-shipx-pl.easypack24.net',
    'y0urs3cr3tc0d3'
);
```

### 3.2. Calling API endpoints

To call the API endpoint you need to use `callMethod` method of the client.
It takes the following arguments:

* `$method` - API method that you want to run; all methods can be found in subfolders of `src/Method/` folder; you can add your own methods if you need
* `$uriParams` - array of URI params needed for specific method; you can find required params in method's `getUriTemplate` method; example: for URI template `/v1/organizations/:organization_id/address_books` the required URI param is `organization_id`
* `$queryParams` - array of query params that may be used for some methods to make your call more specific:
  * if a method implements `\MB\ShipXSDK\Method\WithPaginatedResultsInterface` you can use the following params:
    * `page` - to specify which page of multipaged result you'd like to get,
  * if a method implements `\MB\ShipXSDK\Method\WithSortableResultsInterface` you can use the following params:
    * `sort_by` - to specify by which field should the results be sorted; possible values might be found in method's `getSortableFields` method,
    * `sort_order` - to specify the direction of sorting; possible values are `asc` and `desc`,
  * if a method implements `\MB\ShipXSDK\Method\WithFilterableResultsInterface` you:
    * can use all the params defined in method's `getFilters` method,
  * if a method implements `\MB\ShipXSDK\Method\WithQueryParamsInterface` you:
    * have to use all the params defined in method's `getRequiredQueryParams` method,
    * can use all the params defined in method's `getOptionalQueryParams` method
* `$payload` - data transfer object (`\MB\ShipXSDK\DataTransferObject\DataTransferObject`) required for all methods that implement `\MB\ShipXSDK\Method\WithJsonRequestInterface`; the name of required object might be found in method's `getRequestPayloadModelName` name.

`callMethod` method returns `\MB\ShipXSDK\Response\Response` object.
You can check if the call was successful by running response's `getSuccess` method.
The body of the response might be taken by running response's `getPayload` method. It will be one of the following:
* `\MB\ShipXSDK\Model\Error` object if error occurred,
* `\MB\ShipXSDK\Model\BinaryContent` object if method implements `\MB\ShipXSDK\Method\WithBinaryResponseInterface` and correct binary file was returned by API,
* data transfer object which name can be found in method's `getResponsePayloadModelName` method, if method implements `\MB\ShipXSDK\Method\WithJsonResponseInterface`,
* `null` if error haven't occurred and method doesn't expect any body.

`callMethod` method might throw:
* `\MB\ShipXSDK\Exception\InvalidModelException` if the response body doesn't match expected data transfer object,
* `\GuzzleHttp\Exception\GuzzleException` if something went wrong with the connection.

### 3.3. Exemplary API call

```php
$response = $client->callMethod(
new \MB\ShipXSDK\Method\Shipment\CreateOffer(),
    ['organization_id' => '1234'],
    [],
    new \MB\ShipXSDK\Form\CreateShipmentOffer([
        'receiver' => new \MB\ShipXSDK\Model\Receiver([
            'phone' => '123456789',
            'email' => 'some.guy@gmail.com',
            'address' => new \MB\ShipXSDK\Model\Address([
                'line1' => '',
                'city' => 'Warszawa',
                'post_code' => '01-234',
                'country_code' => 'PL',
                'street' => 'Testowa 11',
                'building_number' => '12/23'
            ])
        ]),
        'parcels' => [
            new \MB\ShipXSDK\Model\ParcelsSimple([
                'dimensions' => new \MB\ShipXSDK\Model\DimensionsSimple([
                    'height' => 21.5,
                    'length' => 2.1,
                    'width' => 1.7
                ]),
                'weight' => new \MB\ShipXSDK\Model\WeightSimple([
                    'amount' => 2.0
                ]),
                'is_non_standard' => false
            ])
        ],
        'additional_services' => [],
        'service' => 'inpost_locker_standard',
        'custom_attributes' => new \MB\ShipXSDK\Model\ShipmentCustomAttributes([
            'target_point' => 'BOL01A'
        ])
    ])
);
if ($response->getSuccess()) {
    /** @var \MB\ShipXSDK\Model\Shipment $payload */
    $payload = $response->getPayload();
    echo 'Shipment ID is ' . $payload->id;
}
```

## 4. API endpoints coverage

Endpoints covered: 42/56

Endpoints with integration tests: 29/56

### 4.1. Shipments

#### 4.1.1. Creating a shipment in the simplified mode

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.9.0%5D+Creating+a+shipment+in+the+simplified+mode)

Method: `\MB\ShipXSDK\Method\Shipment\Create`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulSimpleFlow`

#### 4.1.2. Creating a shipment in the offer mode

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.9.0%5D+Creating+a+shipment+in+the+offer+mode)

Method: `\MB\ShipXSDK\Method\Shipment\CreateOffer`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulOfferFlow`

##### 4.1.2.1. Paying for shipment

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.3%5D+Paying+for+shipment)

Method: `\MB\ShipXSDK\Method\Shipment\Buy`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulOfferFlow`

##### 4.1.2.2. Bulk selection of offers

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Bulk+selection+of+offers)

Method: `\MB\ShipXSDK\Method\Shipment\SelectOffers`

Integration test: No

##### 4.1.2.3. Selecting offer

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Selecting+offer)

Method: `\MB\ShipXSDK\Method\Shipment\SelectOffer`

Integration test: No

##### 4.1.2.4. Bulk payment for shipments

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6%5D+Bulk+payment+for+shipments)

Method: `\MB\ShipXSDK\Method\Shipment\BuyBulk`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulBatchFlowWithoutBuying`

#### 4.1.3. Creating and viewing multiple shipments

##### 4.1.3.1. Creating multiple shipments

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.4%5D+Creating+and+viewing+multiple+shipments#id-[1.6.4]Creatingandviewingmultipleshipments-Creatingmultipleshipments)

Method: `\MB\ShipXSDK\Method\Shipment\CreateBatch`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulBatchFlowWithBuying`

##### 4.1.3.2. Viewing multiple shipments

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.4%5D+Creating+and+viewing+multiple+shipments#id-[1.6.4]Creatingandviewingmultipleshipments-Viewingmultipleshipments)

Method: `\MB\ShipXSDK\Method\Shipment\GetBatch`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulBatchFlowWithBuying`

#### 4.1.4. Cancelling a shipment

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5D+Cancelling+a+shipment)

Method: `\MB\ShipXSDK\Method\Shipment\Cancel`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulCancellation`

Note: From time to time Sandbox API responds with empty body instead of error payload.
Empty body is expected for successful call.

#### 4.1.5. Updating a shipment

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.9.0%5D+Updating+a+shipment)

Method: No

Integration test: No

#### 4.1.6. Recalculating shipment prices

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.7.0%5D+Recalculating+shipment+prices)

Method: No

Integration test: No

#### 4.1.7. Collecting the shipment label

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Collecting+the+shipment+label)

Method: `\MB\ShipXSDK\Method\Shipment\GetLabel`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulSimpleFlow`

#### 4.1.8. Collecting many labels

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Collecting+many+labels)

Method: `\MB\ShipXSDK\Method\Shipment\GetLabels`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulBatchFlowWithBuying`

#### 4.1.9. Collecting return labels

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Collecting+return+labels)

Method: `\MB\ShipXSDK\Method\Shipment\GetReturnLabels`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testSuccessfulSimpleFlow`

#### 4.1.10. Searching shipments

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Collecting+return+labels)

Method: `\MB\ShipXSDK\Method\Shipment\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ShipmentResourceTest::testGetListSuccessCall`

Note: Quite often Sandbox shipment search cannot find shipment by ID,
even though it is reachable using standard get method.

### 4.2. Statuses

#### 4.2.1. List of statuses

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5D+Statuses#id-[1.2.0]Statuses-Listofstatuses)

Method: `\MB\ShipXSDK\Method\Status\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\StatusResourceTest::testGetListSuccessfulCall`

### 4.3. Tracking a shipment

#### 4.3.1. Shipment history

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.7.3%5D+Tracking+a+shipment#id-[1.7.3]Trackingashipment-Shipmenthistory)

Method: `\MB\ShipXSDK\Method\Tracking\Read`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\TrackingResourceTest::testReadSuccessfulCall`

Note: Sandbox API constantly responds with "Resource not found" error.

#### 4.3.2. Shipment service history

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.7.3%5D+Tracking+a+shipment#id-[1.7.3]Trackingashipment-Shipmentservicehistory)

Method: No

Integration test: No

### 4.4. Users

#### 4.4.1. List of users

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Users)

Method: `\MB\ShipXSDK\Method\User\GetList`

Integration test: No

Note: Sandbox API constantly responds with "Resource not found" error.

### 4.5. Organizations

#### 4.5.1. Getting information about the Organization

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Organizations#id-[1.6.0]Organizations-GettinginformationabouttheOrganization)

Method: `\MB\ShipXSDK\Method\Organization\Read`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\OrganizationResourceTest::testReadSuccessfulCall`

#### 4.5.2. List all organizations

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Organizations#id-[1.6.0]Organizations-Listallorganizations)

Method: `\MB\ShipXSDK\Method\Organization\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\OrganizationResourceTest::testGetListSuccessfulCall`

#### 4.5.3. Organization's statistics

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Organizations#id-[1.6.0]Organizations-Organization'sstatistics)

Method: No

Integration test: No

### 4.6. Shipment templates

#### 4.6.1. Downloading template

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5D+Shipment+templates#id-[1.2.0]Shipmenttemplates-Downloadingtemplate)

Method: No

Integration test: No

#### 4.6.2. List of templates

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5D+Shipment+templates#id-[1.2.0]Shipmenttemplates-Listoftemplates)

Method: No

Integration test: No

#### 4.6.3. Adding a template

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5D+Shipment+templates#id-[1.2.0]Shipmenttemplates-Addingatemplate)

Method: No

Integration test: No

#### 4.6.4. Removing a template

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5D+Shipment+templates#id-[1.2.0]Shipmenttemplates-Removingatemplate)

Method: No

Integration test: No

#### 4.6.5. Editing a template

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5D+Shipment+templates#id-[1.2.0]Shipmenttemplates-Editingatemplate)

Method: No

Integration test: No

#### 4.6.6. Searching shipment templates

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.0%5DSearching+shipment+templates)

Method: No

Integration test: No

### 4.7. Dispatch points

#### 4.7.1. Collecting information about the point

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.5%5D+Dispatch+points#id-[1.2.5]Dispatchpoints-Collectinginformationaboutthepoint)

Method: `\MB\ShipXSDK\Method\DispatchPoint\Read`

Integration test: No

#### 4.7.2. List of dispatch points

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.2.5%5D+Dispatch+points#id-[1.2.5]Dispatchpoints-Listofdispatchpoints)

Method: `\MB\ShipXSDK\Method\DispatchPoint\GetList`

Integration test: No

### 4.8. Dispatch Order

#### 4.8.1. Creating a new collection order

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Dispatch+Order#id-[1.6.0]DispatchOrder-Creatinganewcollectionorder)

Method: `\MB\ShipXSDK\Method\DispatchOrder\Create`

Integration test: No

#### 4.8.2. Collecting information about a collection order

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Dispatch+Order#id-[1.6.0]DispatchOrder-Collectinginformationaboutacollectionorder)

Method: `\MB\ShipXSDK\Method\DispatchOrder\Read`

Integration test: No

#### 4.8.3. Removing a collection order

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Dispatch+Order#id-[1.6.0]DispatchOrder-Removingacollectionorder)

Method: `\MB\ShipXSDK\Method\DispatchOrder\Delete`

Integration test: No

#### 4.8.4. List of collection orders

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Dispatch+Order#id-[1.6.0]DispatchOrder-Listofcollectionorders)

Method: `\MB\ShipXSDK\Method\DispatchOrder\GetList`

Integration test: No

#### 4.8.5. Creating a comment to a collection order

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Dispatch+Order#id-[1.6.0]DispatchOrder-Creatingacommenttoacollectionorder)

Method: `\MB\ShipXSDK\Method\DispatchOrder\CreateComment`

Integration test: No

#### 4.8.6. Updating a comment to a collection order

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Dispatch+Order#id-[1.6.0]DispatchOrder-Updatingacommenttoacollectionorder)

Method: `\MB\ShipXSDK\Method\DispatchOrder\UpdateComment`

Integration test: No

#### 4.8.7. Delete comment to the dispatch order

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Dispatch+Order#id-[1.6.0]DispatchOrder-Deletecommenttothedispatchorder)

Method: `\MB\ShipXSDK\Method\DispatchOrder\DeleteComment`

Integration test: No

#### 4.8.8. Calculating prices of dispatch orders

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Calculating+prices+of+dispatch+orders)

Method: `\MB\ShipXSDK\Method\DispatchOrder\Calculate`

Integration test: No

#### 4.8.9. Printing dispatch orders

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.0%5D+Printing+dispatch+orders)

Method: No

Integration test: No

### 4.9. Address book

#### 4.9.1. List of addresses in address book

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.4%5D+Address+book#id-[1.6.4]Addressbook-Listofaddressesinaddressbook)

Method: `\MB\ShipXSDK\Method\AddressBook\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\AddressBookResourceTest::testSuccessfulCrudFlow`

#### 4.9.2. Collecting information about address

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.4%5D+Address+book#id-[1.6.4]Addressbook-Collectinginformationaboutaddress)

Method: `\MB\ShipXSDK\Method\AddressBook\Read`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\AddressBookResourceTest::testSuccessfulCrudFlow`

#### 4.9.3. Adding a new address

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.4%5D+Address+book#id-[1.6.4]Addressbook-Addinganewaddress)

Method: `\MB\ShipXSDK\Method\AddressBook\Create`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\AddressBookResourceTest::testSuccessfulCrudFlow`

#### 4.9.4. Updating address

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.4%5D+Address+book#id-[1.6.4]Addressbook-Updatingaddress)

Method: `\MB\ShipXSDK\Method\AddressBook\Update`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\AddressBookResourceTest::testSuccessfulCrudFlow`

#### 4.9.4. Removing address

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.6.4%5D+Address+book#id-[1.6.4]Addressbook-Removingaddress)

Method: `\MB\ShipXSDK\Method\AddressBook\Delete`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\AddressBookResourceTest::testSuccessfulCrudFlow`

### 4.10. Services

#### 4.10.1. List of services

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.7.0%5D+Services#id-[1.7.0]Services-Listofservices)

Method: `\MB\ShipXSDK\Method\Service\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ServiceResourceTest::testGetListSuccessfulCall`

### 4.11. Mapping files

#### 4.11.1. List of mappings

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.7.6%5D+Mapping+files)

Method: No

Integration test: No

#### 4.11.2. Export a mapping to xfile

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.7.6%5D+Mapping+files#id-[1.7.6]Mappingfiles-Exportamappingtoxfile)

Method: No

Integration test: No

#### 4.11.3. Export view

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.7.6%5D+Mapping+files#id-[1.7.6]Mappingfiles-Exportview)

Method: No

Integration test: No

### 4.12. Sending method

#### 4.12.1. List of sending methods

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.8.1%5D+Sending+method#id-[1.8.1]Sendingmethod-Listofsendingmethods)

Method: `\MB\ShipXSDK\Method\SendingMethod\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\SendingMethodResourceTest::testGetListSuccessfulCall`

### 4.13. Cost centers MPK

#### 4.13.1. Downloading the collection of cost centers

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.10.0%5D+Cost+centers+MPK#id-[1.10.0]CostcentersMPK-Downloadingthecollectionofcostcenters)

Method: `\MB\ShipXSDK\Method\Mpk\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\MpkResourceTest::testSuccessfulCruFlow`

#### 4.13.2. Creating a cost center

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.10.0%5D+Cost+centers+MPK#id-[1.10.0]CostcentersMPK-Creatingacostcenter)

Method: `\MB\ShipXSDK\Method\Mpk\Create`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\MpkResourceTest::testSuccessfulCruFlow`

#### 4.13.3. Updating a cost center

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.10.0%5D+Cost+centers+MPK#id-[1.10.0]CostcentersMPK-Updatingtheplaceofcollectionorder)

Method: `\MB\ShipXSDK\Method\Mpk\Update`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\MpkResourceTest::testSuccessfulCruFlow`

#### 4.13.4. Downloading a single object

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.10.0%5D+Cost+centers+MPK#id-[1.10.0]CostcentersMPK-Downloadingasingleobject)

Method: `\MB\ShipXSDK\Method\Mpk\Read`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\MpkResourceTest::testSuccessfulCruFlow`

### 4.14. Reports

#### 4.14.1. Collecting COD report

Documentation: [Link](https://docs.inpost24.com/pages/viewpage.action?pageId=18513968#id-[1.4.0]COD'-CollectingCODreport)

Method: `\MB\ShipXSDK\Method\Report\GetCod`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\ReportResourceTest::testGetCodSuccessfulCall`

### 4.15. Points resource

#### 4.15.1. List of points

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.16.5%5D+Points+resource#id-[1.16.5]Pointsresource-Listofpoints)

Method: `\MB\ShipXSDK\Method\Point\GetList`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\PointResourceTest::testGetListSuccessfulCall`

#### 4.15.2. Point details

Documentation: [Link](https://docs.inpost24.com/display/PL/%5B1.16.5%5D+Points+resource#id-[1.16.5]Pointsresource-Pointdetails)

Method: `\MB\ShipXSDK\Method\Point\Read`

Integration test: `\MB\ShipXSDK\Test\Integration\Client\PointResourceTest::testReadSuccessfulCall`