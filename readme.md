# Miva JSON API REST Wrapper

PHP library providing a RESTful interface for interacting with the Miva JSON API.

## Table Of Contents

- [Installation](#installation)
- [Getting Started](#getting-started)
  * [Web Server Setup](#web-server-setup)
  * [Configuration](#configuration)
  * [IP Whitelisting](#ip-whitelisting)
- [Issuing Requests](#issuing-requests)
  * [Request Authentication](#request-authentication)
  * [Function Permissions](#function-permissions)
  * [PUT And DELETE Requests](#put-and-delete-requests)
- [Filtering](#filtering)
  * [Count](#count)
  * [Offset](#offset)
  * [On Demand Columns](#on-demand-columns)
  * [Search](#search)
    + [Simple Searches](#simple-searches)
    + [AND Searches](#and-searches)
    + [OR Searches](#or-searches)
    + [PARENTHETICAL Comparisons](#parenthetical-comparisons)
  * [Show](#show)
  * [Sort](#sort)
  * [Assigned / Unassigned](#assigned---unassigned)
- [API Endpoints](#api-endpoints)
  * [Availability Group Endpoints](#availability-group-endpoints)
    + [Load Availability Groups List](#load-availability-groups-list)
    + [Load Availability Group](#load-availability-group)
    + [Update Availability Group Business Account Assignment](#update-availability-group-business-account-assignment)
    + [Update Availability Group Customer Account Assignment](#update-availability-group-customer-account-assignment)
    + [Update Availability Group Payment Method Assignment](#update-availability-group-payment-method-assignment)
    + [Update Availability Group Product Assignment](#update-availability-group-product-assignment)
    + [Update Availability Group Shipping Method Assignment](#update-availability-group-shipping-method-assignment)
  * [Category Endpoints](#category-endpoints)
    + [Load Categories List](#load-categories-list)
    + [Load Category](#load-category)
    + [Create Category](#create-category)
    + [Update Category](#update-category)
    + [Delete Category](#delete-category)
    + [Load Category Products List](#load-category-products-list)
    + [Update Category Product Assignment](#update-category-product-assignment)
    + [Load Category Subcategories List](#load-category-subcategories-list)
  * [Coupon Endpoints](#coupon-endpoints)
    + [Load Coupons List](#load-coupons-list)
    + [Load Coupon](#load-coupon)
    + [Create Coupon](#create-coupon)
    + [Update Coupon](#update-coupon)
    + [Delete Coupons](#delete-coupons)
    + [Load Coupon Price Group List](#load-coupon-price-group-list)
    + [Update Coupon Price Group Assignment](#update-coupon-price-group-assignment)
  * [Customer Endpoints](#customer-endpoints)
    + [Load Customers List](#load-customers-list)
    + [Load Customer](#load-customer)
    + [Create Customer](#create-customer)
    + [Update Customer](#update-customer)
    + [Delete Customer](#delete-customer)
    + [Load Customer Addresses List](#load-customer-addresses-list)
    + [Load Customer Price Groups List](#load-customer-price-groups-list)
  * [Note Endpoints](#note-endpoints)
    + [Load Notes List](#load-notes-list)
    + [Load Note](#load-note)
    + [Create Note](#create-note)
    + [Update Note](#update-note)
    + [Delete Note](#delete-note)
  * [Order Endpoints](#order-endpoints)
    + [Load Orders List](#load-orders-list)
    + [Load Order](#load-order)
    + [Create Order](#create-order)
    + [Delete Order](#delete-order)
    + [Update Order Customer Information](#update-order-customer-information)
    + [Create Order Item](#create-order-item)
    + [Update Order Item](#update-order-item)
    + [Cancel Order Items](#cancel-order-items)
    + [Delete Order Items](#delete-order-items)
    + [Backorder Order Items](#backorder-order-items)
    + [Load Orders Custom Fields List](#load-orders-custom-fields-list)
    + [Update Order Custom Field Values](#update-order-custom-field-values)
  * [Order Queue Endpoints](#order-queue-endpoints)
    + [Load Order Queue List](#load-order-queue-list)
    + [Create Order Queue Acknowledgement](#create-order-queue-acknowledgement)
  * [Payment Endpoints](#payment-endpoints)
    + [Capture Order Payment](#capture-order-payment)
    + [Refund Order Payment](#refund-order-payment)
    + [Void Order Payment](#void-order-payment)
  * [Price Group Endpoints](#price-group-endpoints)
    + [Load Price Groups List](#load-price-groups-list)
    + [Load Price Group](#load-price-group)
    + [Load Price Group Products List](#load-price-group-products-list)
    + [Update Price Group Product Assignment](#update-price-group-product-assignment)
    + [Update Price Group Customer Assignment](#update-price-group-customer-assignment)
  * [Product Endpoints](#product-endpoints)
    + [Load Products List](#load-products-list)
    + [Load Product](#load-product)
    + [Create Product](#create-product)
    + [Update Product](#update-product)
    + [Delete Product](#delete-product)
    + [Adjust Product List Inventory](#adjust-product-list-inventory)
    + [Create Product Image](#create-product-image)
    + [Delete Product Image](#delete-product-image)
    + [Load Product Variants List](#load-product-variants-list)
  * [Provisioning Endpoints](#provisioning-endpoints)
    + [Domain Level Provisioning](#domain-level-provisioning)
    + [Store Level Provisioning](#store-level-provisioning)
  * [Shipment Endpoints](#shipment-endpoints)
    + [Create Order Shipment](#create-order-shipment)
    + [Update Order Shipments](#update-order-shipments)

## Installation

Install via [Composer](https://getcomposer.org/).

```
$ composer create-project pdeans/miva-rest-api RestApi
```

## Getting Started

### Web Server Setup

The web server setup assumes a standard Miva Merchant installation on the server. Issuing the composer command above will download the library files into a directory named `RestApi`. This directory should then be uploaded to the web server's root directory via FTP. Alternatively, the composer command may be issued directly to the web server's root directory if installing via SSH.

**NOTE:** The project files should **NEVER** be placed in a public facing directory on the web server as this can expose API credentials. Typically, this is the `/httpdocs` directory.

Next, within the `/RestApi` directory root, locate the `/httpdocs` directory and copy or move the `/api` directory and all of its contents to the root of the web server's public directory. Again, the public directory is generally `/httpdocs` for standard Miva Merchant installations.

The directory and file structure should resemble the following from the web server root:

```
/httpdocs (public directory)
    |-- /api
        |-- .htaccess
        |-- index.php

/RestApi
    |-- Project Files

```

Essentially, the require statement in the `/httpdocs/api/index.php` file should link to the project's `/bootstrap/app.php` path.

```php
# /httpdocs/api/index.php
$app = require_once __DIR__.'/../../RestApi/bootstrap/app.php';
```

### Configuration

All of the configuration options for the project are stored in the `.env` file on the project root.

Here is a breakdown of the settings relevant to the Miva Merchant JSON API:

| Key | Required | Description |
| --- | --- | --- |
| MM_STORE_CODE | Yes | The store code. |
| MM_API_URL | Yes | The Api endpoint URL. |
| MM_API_TOKEN | Yes | The Api access token. |
| MM_API_KEY | Yes | The Api private key. |
| MM_API_HTTP_HEADERS | No | Http headers to issue on each API request. The header name and value are separated by a colon "<strong>:</strong>". Multiple headers can be issued via comma separated list.<br><br><strong>Example value:</strong><br>```"Auth: Basic dXNlcjpwYXNzd29yZA==, Custom: header-value"``` |
| MM_API_HTTP_CLIENT_OPTS | No | Curl options to set on the underlying http client. The curl option name and value are separated by a colon "<strong>:</strong>". Multiple options can be issued via comma separated list.<br><br><strong>Example value:</strong><br>```"CURLOPT_SSL_VERIFYPEER:0, CURLOPT_SSL_VERIFYHOST:0"``` |

### IP Whitelisting

The web server's IP address will need to be added to the **Allowed IP Address(es)** list under the API Tokens configuration in the Miva Merchant admin.

## Issuing Requests

The REST interface allows for making client and server sided requests to interact with Miva JSON API functions.

### Request Authentication

API request authentication is handled behind the scenes based on the credentials provided to the configuration settings in the project root's `.env` file. Each request to a REST API endpoint will automatically issue the `X-Miva-API-Authorization` and `Content-Type` headers, as well as the `Miva_Request_Timestamp` and `Store_Code` request body parameters. For this reason, these should be omitted in the requests issued to the REST API endpoints.

### Function Permissions

Each REST API endpoint maps to a specific JSON API function that must be assigned to the provided API Token in the Miva Merchant admin to enable the REST API endpoint. The [API Endpoints](#api-endpoints) definitions specifies the function to enable for each endpoint.

### PUT And DELETE Requests

`PUT` and `DELETE` http methods that target a single resource can omit the "identifier" parameter in the JSON body provided to the endpoint. These parameters are listed in the respective section of the [API Endpoints](#api-endpoints) definitions.

## Filtering

Filtering for list load and single load resource endpoints can be achieved through the query parameters listed below. See the [API Endpoints](#api-endpoints) definitions to see which filter options are supported for each individual endpoint. The filter query parameters may be combined as needed to generate the desired results.

### Count

The `count` query parameter may be issued to limit the number of records returned for list load endpoints.

Example: `?count=15`

### Offset

The `offset` query parameter may be issued to offset the first record returned for list load endpoints. The offset value is 0 based.

Example: `?offset=5`

### On Demand Columns

The `odc` query parameter may be issued to specify the on demand columns to be included for list load and single resource load endpoints that support the filter. Multiple columns should be provided via comma separated list.

Example: `?odc=categories,CustomField_Values:*`

### Search

The `search` query parameter may be issued on list load endpoints to filter by the provided search terms. The following is the basic pattern used for issuing searches:

```
search[<index>][values][<index>][field]=<field_code>
search[<index>][values][<index>][operator]=<operator>
search[<index>][values][<index>][value]=<search_value>
```

- **field** specifies the field code to target.
- **operator** specifies the search operator.
- **value** specifies the search value.

The search value may be provided as a comma separated list for operators that support a list of values (ex: **IN**).

Additionally, the **value** segment of the search parameter should be omitted for operators that do not require a value. Currently, these operators include:

- **TRUE**
- **FALSE**
- **NULL**

#### Simple Searches

The following is an example search query string to filter results by the "code" field equal to a value of "prod1":

`?search[0][values][0][field]=code&search[0][values][0][operator]=EQ&search[0][values][0][value]=prod1`

#### AND Searches

A logical **AND** search can be performed by providing multiple indexes for the `search[<index>]` portion of the query string. The pattern should resemble the following:

```
search[0][values][0][field]=<field_code>
search[0][values][0][operator]=<operator>
search[0][values][0][value]=<search_value>
search[1][values][0][field]=<field_code>
search[1][values][0][operator]=<operator>
search[1][values][0][value]=<search_value>
```

If we were to provide an additional **AND** search condition, we would issue a new `search` index of 2 in this example, `search[2]`. This pattern should be followed for each addtional **AND** condition.

The following is an example **AND** search query string that filters the results by category assignment and price criteria:

`?search[0][values][0][field]=Category&search[0][values][0][operator]=IN&search[0][values][0][value]=13707,13708&search[1][values][0][field]=price&search[1][values][0][operator]=GT&search[1][values][0][value]=19.86`

#### OR Searches

A logical **OR** search can be performed by providing multiple indexes for the `values[<index>]` portion of the query string. The pattern should resemble the following:

```
search[0][values][0][field]=<field_code>
search[0][values][0][operator]=<operator>
search[0][values][0][value]=<search_value>
search[0][values][1][field]=<field_code>
search[0][values][1][operator]=<operator>
search[0][values][1][value]=<search_value>
```

If we were to provide an additional **OR** search condition, we would issue a new `values` index of 2 in this example, `values[2]`. This pattern should be followed for each addtional **OR** condition.

The following is an example **OR** search query string that filters the results by records that match either value for the last name of a customer shipping address:

`?search[0][values][0][field]=ship_lname&search[0][values][0][operator]=EQ&search[0][values][0][value]=Griffin&search[0][values][1][field]=ship_lname&search[0][values][1][operator]=EQ&search[0][values][1][value]=Star`

#### PARENTHETICAL Comparisons

A parenthetical comparison can be performed by providing multidimensional indexes for the `values[<index>]` portion of the query string. The pattern should roughly resemble the following:

```
search[0][values][0][field]=<field_code>
search[0][values][0][operator]=<operator>
search[0][values][0][value]=<search_value>
search[0][values][1][field]=<field_code>
search[0][values][1][operator]=<operator>
search[0][values][1][value]=[]
search[0][values][1][0][field]=<field_code>
search[0][values][1][0][operator]=<operator>
search[0][values][1][0][value]=<search_value>
search[0][values][1][1][field]=<field_code>
search[0][values][1][1][operator]=<operator>
search[0][values][1][1][value]=<search_value>
```

The parenthetical portion of the search clause is first initiated by setting the `value` to `[]` on the `values` index:

```
search[0][values][1][value]=[]
```

Next, a new index dimension is provided to the `values` indices with the subsequent search criteria to build the desired comparison:

```
search[0][values][1][0][field]=<field_code>
search[0][values][1][0][operator]=<operator>
search[0][values][1][0][value]=<search_value>
search[0][values][1][1][field]=<field_code>
search[0][values][1][1][operator]=<operator>
search[0][values][1][1][value]=<search_value>
```

Take following search query for example:

```
?search[0][values][0][field]=ship_lname&search[0][values][0][operator]=EQ&search[0][values][0][value]=Griffin&search[0][values][1][field]=search_OR&search[0][values][1][operator]=SUBWHERE&search[0][values][1][value]=[]&search[0][values][1][0][field]=ship_fname&search[0][values][1][0][operator]=EQ&search[0][values][1][0][value]=Patrick&search[0][values][1][1][field]=ship_lname&search[0][values][1][1][operator]=EQ&search[0][values][1][1][value]=Star
```

This will generate the following search filter for the API request:

```json
"Filter": [
    {
        "name": "search",
        "value": [
            {
                "field": "ship_lname",
                "operator": "EQ",
                "value": "Griffin"
            },
            {
                "field": "search_OR",
                "operator": "SUBWHERE",
                "value": [
                    {
                        "field": "ship_fname",
                        "operator": "EQ",
                        "value": "Patrick"
                    },
                    {
                        "field": "ship_lname",
                        "operator": "EQ",
                        "value": "Star"
                    }
                ]
            }
        ]
    }
]
```

### Show

The `show` query parameter may be issued to filter list load results according to the provided value.

Example: `?show=Active`

### Sort

The `sort` query parameter may be issued to sort results by the provided column name. To sort the results in descending order, prepend the parameter value with the "-" character.

Example: `?sort=-code`

### Assigned / Unassigned

The `assigned` and `unassigned` query parameters may be issued to filter list load results according to their provided value.

## API Endpoints

The following section defines the endpoints available for the REST API. The endpoints are based off of the public path set for the REST API's public directory files. Follwing the [Web Server Setup](#web-server-setup), the base uri would be set to `/api`. The full url path would then be set as follows:

```
http(s)://www.yourdomain.com/api/<endpoint>
```

### Availability Group Endpoints

#### Load Availability Groups List

```
GET /availabilitygroups
```

**Enable Function:** `AvailabilityGroupList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /availabilitygroups | count<br>offset<br>search<br>sort |

---

#### Load Availability Group

```
GET /availabilitygroups/{id}
```

**Enable Function:** `AvailabilityGroupList_Load_Query`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /availabilitygroups/{id} | {id} = Availability Group Id |

---

#### Update Availability Group Business Account Assignment

```
PUT /availabilitygroups/{id}/businessaccounts
```

**Enable Function:** `AvailabilityGroupBusinessAccount_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter |
| :---: | :---: | :---: | :---: |
| PUT | /availabilitygroups/{id}/businessaccounts | {id} = Availability Group Id | AvailabilityGroup_ID |

**Example Request Body**

```json
{
    "BusinessAccount_Title": "Wholesale",
    "Assigned": true
}
```

---

#### Update Availability Group Customer Account Assignment

```
PUT /availabilitygroups/{id}/customers
```

**Enable Function:** `AvailabilityGroupCustomer_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter |
| :---: | :---: | :---: | :---: |
| PUT | /availabilitygroups/{id}/customers | {id} = Availability Group Id | AvailabilityGroup_ID |

**Example Request Body**

```json
{
    "Customer_Login": "pstearns",
    "Assigned": true
}
```

---

#### Update Availability Group Payment Method Assignment

```
PUT /availabilitygroups/{id}/paymentmethods
```

**Enable Function:** `AvailabilityGroupPaymentMethod_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter |
| :---: | :---: | :---: | :---: |
| PUT | /availabilitygroups/{id}/paymentmethods | {id} = Availability Group Id | AvailabilityGroup_ID |

**Example Request Body**

```json
{
    "Module_Code": "check",
    "Method_Code": "check",
    "Assigned": true
}
```

---

#### Update Availability Group Product Assignment

```
PUT /availabilitygroups/{id}/products
```

**Enable Function:** `AvailabilityGroupProduct_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter |
| :---: | :---: | :---: | :---: |
| PUT | /availabilitygroups/{id}/products | {id} = Availability Group Id | AvailabilityGroup_ID |

**Example Request Body**

```json
{
    "Product_Code": "prod1",
    "Assigned": true
}
```

---

#### Update Availability Group Shipping Method Assignment

```
PUT /availabilitygroups/{id}/shippingmethods
```

**Enable Function:** `AvailabilityGroupShippingMethod_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter |
| :---: | :---: | :---: | :---: |
| PUT | /availabilitygroups/{id}/shippingmethods | {id} = Availability Group Id | AvailabilityGroup_ID |

**Example Request Body**

```json
{
    "Module_Code": "flatrate",
    "Method_Code": "Standard",
    "Assigned": true
}
```

---

### Category Endpoints

#### Load Categories List

```
GET /categories
```

**Enable Function:** `CategoryList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /categories | count<br>odc<br>offset<br>search<br>show<br>sort |

---

#### Load Category

```
GET /categories/{id}
```

**Enable Function:** `CategoryList_Load_Query`

| HTTP Method | Endpoint | Path Identifier | Filter |
| :---: | :---: | :---: | :---: |
| GET | /categories/{id} | {id} = Category Id | odc |

---

#### Create Category

```
POST /categories
```

**Enable Function:** `Category_Insert`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /categories |

**Example Request Body**

```json
{
    "Category_Code": "sample",
    "Category_Name": "Sample Category",
    "Category_Active": true,
    "Category_Page_Title": "Sample Category Page Title",
    "Category_Parent_Category": "",
    "Category_Alternate_Display_Page": "",
    "CustomField_Values": {
        "customfields": {
            "category_h2": "Sample Cat -- Meow"
        }
    }
}
```

---

#### Update Category

```
PUT /categories/{id}
```

**Enable Function:** `Category_Update`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter |
| :---: | :---: | :---: | :---: |
| PUT | /categories/{id} | {id} = Category Id | Category_ID |

**Example Request Body**

```json
{
    "Category_Name": "Sample Categoryyy",
    "Category_Page_Title": "Sample Category Page Title Update"
}
```

---

#### Delete Category

```
DELETE /categories/{id}
```

**Enable Function:** `Category_Delete`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| DELETE | /categories/{id} | {id} = Category Id |

---

#### Load Category Products List

```
GET /categories/{id}/products
```

**Enable Function:** `CategoryProductList_Load_Query`

| HTTP Method | Endpoint | Path Identifier | Filters |
| :---: | :---: | :---: | :---: |
| GET | /categories/{id}/products | {id} = Category Id | count<br>odc<br>offset<br>search<br>show<br>sort<br>assigned<br>unassigned |

---

#### Update Category Product Assignment

```
PUT /categories/{id}/products
```

**Enable Function:** `CategoryProduct_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /categories/{id}/products | {id} = Category Id | Category_ID |

**Example Request Body**

```json
{
    "Product_Code": "prod1",
    "Assigned": true
}
```

---

#### Load Category Subcategories List

```
GET /categories/{id}/subcategories
```

**Enable Function:** `CategoryList_Load_Parent`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /categories/{id}/subcategories | {id} = Category Id |

---

### Coupon Endpoints

#### Load Coupons List

```
GET /coupons
```

**Enable Function:** `CouponList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /coupons | count<br>offset<br>search<br>sort |

---

#### Load Coupon

```
GET /coupons/{id}
```

**Enable Function:** `CouponList_Load_Query`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /coupons/{id} | {id} = Coupon Id |

---

#### Create Coupon

```
POST /coupons
```

**Enable Function:** `Coupon_Insert`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /coupons |

**Example Request Body**

```json
{
    "Code": "25OFF2019",
    "Description": "25 Percent Off",
    "CustomerScope": "A",
    "DateTime_Start": 0,
    "DateTime_End": 0,
    "Max_Use": 0,
    "Max_Per": 0,
    "Active": true,
    "PriceGroup_ID": 1
}
```

---

#### Update Coupon

```
PUT /coupons/{id}
```

**Enable Function:** `Coupon_Update`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /coupons/{id} | {id} = Coupon Id | Coupon_ID |

**Example Request Body**

```json
{
    "Description": "25 Percent Off 2019"
}
```

---

#### Delete Coupons

```
DELETE /coupons
```

**Enable Function:** `CouponList_Delete`

| HTTP Method | Endpoint |
| :---: | :---: |
| DELETE | /coupons |

**Example Request Body**

```json
{
    "Coupon_Ids": [49,50]
}
```

---

#### Load Coupon Price Group List

```
GET /coupons/{id}/pricegroups
```

**Enable Function:** `CouponPriceGroupList_Load_Query`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /coupons/{id}/pricegroups | {id} = Coupon Id |

---

#### Update Coupon Price Group Assignment

```
PUT /coupons/{id}/pricegroups
```

**Enable Function:** `CouponPriceGroup_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /coupons/{id}/pricegroups | {id} = Coupon Id | Coupon_Id |

**Example Request Body**

```json
{
    "PriceGroup_Name": "2OFF",
    "Assigned": true
}
```

---

### Customer Endpoints

#### Load Customers List

```
GET /customers
```

**Enable Function:** `CustomerList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /customers | count<br>offset<br>search<br>sort |

---

#### Load Customer

```
GET /customers/{id}
```

**Enable Function:** `CustomerList_Load_Query`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /customers/{id} | {id} = Customer Id |

---

#### Create Customer

```
POST /customers
```

**Enable Function:** `Customer_Insert`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /customers |

**Example Request Body**

```json
{
    "Customer_Login": "pstearns",
    "Customer_PasswordEmail": "noreply@email.com",
    "Customer_Password": "miva@123",
    "Customer_ShipResidential": 1,
    "Customer_ShipFirstName": "Teset",
    "Customer_ShipLastName": "Order",
    "Customer_ShipEmail": "noreply@email.com",
    "Customer_ShipCompany": "Miva, Inc",
    "Customer_ShipPhone": "555-555-5555",
    "Customer_ShipFax": "555-555-5555",
    "Customer_ShipAddress1": "123 abc",
    "Customer_ShipAddress2": "apt 123",
    "Customer_ShipCity": "San Diego",
    "Customer_ShipState": "CA",
    "Customer_ShipZip": "92127",
    "Customer_ShipCountry": "US",
    "Customer_BillFirstName": "Teset",
    "Customer_BillLastName": "Order",
    "Customer_BillEmail": "noreply@email.com",
    "Customer_BillCompany": "Miva, Inc",
    "Customer_BillPhone": "555-555-5555",
    "Customer_BillFax": "555-555-5555",
    "Customer_BillAddress1": "123 abc",
    "Customer_BillAddress2": "apt 123",
    "Customer_BillCity": "San Diego",
    "Customer_BillState": "CA",
    "Customer_BillZip": "92127",
    "Customer_BillCountry": "US",
    "Customer_Tax_Exempt": "1",
    "Customer_BusinessAccount": "Wholesale"
}
```

---

#### Update Customer

```
PUT /customers/{id}
```

**Enable Function:** `Customer_Update`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /customers/{id} | {id} = Customer Id | Customer_ID |

**Example Request Body**

```json
{
    "Customer_Login": "psteezy"
}
```

---

#### Delete Customer

```
DELETE /customers/{id}
```

**Enable Function:** `Customer_Delete`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| DELETE | /customers/{id} | {id} = Customer Id |

---

#### Load Customer Addresses List

```
GET /customers/{id}/addresses
```

**Enable Function:** `CustomerAddressList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /customers/{id}/addresses | count<br>offset<br>search<br>sort |

---

#### Load Customer Price Groups List

```
GET /customers/{id}/pricegroups
```

**Enable Function:** `CustomerPriceGroupList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /customers/{id}/pricegroups | count<br>offset<br>search<br>sort<br>assigned<br>unassigned |

---

### Note Endpoints

#### Load Notes List

```
GET /notes
```

**Enable Function:** `NoteList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /notes | count<br>offset<br>search<br>sort |

---

#### Load Note

```
GET /notes/{id}
```

**Enable Function:** `NoteList_Load_Query`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /notes/{id} | {id} = Note Id |

---

#### Create Note

```
POST /notes
```

**Enable Function:** `Note_Insert`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /notes |

**Example Request Body**

```json
{
    "NoteText": "This is a custom note for an order",
    "Order_ID": 97208
}
```

---

#### Update Note

```
PUT /notes/{id}
```

**Enable Function:** `Note_Update`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /notes/{id} | {id} = Note Id | Note_ID |

**Example Request Body**

```json
{
    "NoteText" : "This is an updated custom note for an order"
}
```

#### Delete Note

```
DELETE /notes/{id}
```

**Enable Function:** `Note_Delete`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| DELETE | /notes/{id} | {id} = Note Id |

---

### Order Endpoints

#### Load Orders List

```
GET /orders
```

**Enable Function:** `OrderList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /orders | count<br>odc<br>offset<br>search<br>sort |

---

#### Load Order

```
GET /orders/{id}
```

**Enable Function:** `OrderList_Load_Query`

| HTTP Method | Endpoint | Path Identifier | Filter |
| :---: | :---: | :---: | :---: |
| GET | /orders/{id} | {id} = Order Id | odc |

---

#### Create Order

```
POST /orders
```

**Enable Function:** `Order_Create`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /orders |

**Example Request Body**

```json
{
    "Customer_Login": "pstearns",
    "ShipFirstName": "John",
    "ShipLastName": "Smith",
    "ShipEmail": "noreply@superfakeemail.com",
    "ShipPhone": "8585551234",
    "ShipFax": "8585554321",
    "ShipCompany": "Miva, Inc.",
    "ShipAddress1": "12345 Beehive Ln",
    "ShipAddress2": "Suite 400",
    "ShipCity": "San Diego",
    "ShipState": "CA",
    "ShipZip": "92127",
    "ShipCountry": "US",
    "ShipResidential": false,
    "BillFirstName": "John",
    "BillLastName": "Smith",
    "BillEmail": "noreply@superfakeemail.com",
    "BillPhone": "8585555678",
    "BillFax": "8585558765",
    "BillCompany": "Umbrella Corp",
    "BillAddress1": "67890 End Of The Rd",
    "BillCity": "Stan Diego",
    "BillState": "CA",
    "BillZip": "92027",
    "BillCountry": "US",
    "Items": [
        {
            "status": 0,
            "code": "aaaaa",
            "name": "Item 3",
            "sku": "SKUITEM3",
            "price": 1.97,
            "weight": 0.08,
            "quantity": 2,
            "taxable": true,
            "upsold": false,
            "options": [
                {
                    "attr_code": "color",
                    "opt_code": "green",
                    "price": 0.28,
                    "weight": 0.01
                }
            ]
        }
    ],
    "Charges": [
        {
            "type": "SHIPPING",
            "descrip": "Standard Shipping",
            "amount": 5.00,
            "display_amount": 5.00,
            "tax_exempt": false
        },
        {
            "type": "TAX",
            "descrip": "Sales Tax",
            "amount": 1.25,
            "display_amount": 1.25,
            "tax_exempt": true
        }
    ],
    "CustomField_Values": {
        "customfields": {
            "order_instructions": "Leave it soaked in the pool please."
        }
    }
}
```

---

#### Delete Order

```
DELETE /orders/{id}
```

**Enable Function:** `Order_Delete`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| DELETE | /orders/{id} | {id} = Order Id |

---

#### Update Order Customer Information

```
PUT /orders/{id}/customers
```

**Enable Function:** `Order_Update_Customer_Information`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /orders/{id}/customers | {id} = Order Id | Order_ID |

**Example Request Body**

```json
{
    "Ship_FirstName": "Peter",
    "Ship_LastName": "Pan"
}
```

---

#### Create Order Item

```
POST /orders/{id}/items
```

**Enable Function:** `OrderItem_Add`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| POST | /orders/{id}/items | {id} = Order Id |

**Example Request Body**

```json
{   
    "Code": "custom-schmedium-pink-shirt",
    "Name": "Custom Schmedium T-Shrt",
    "SKU": "schmedium-pink-shirt",
    "Quantity": 3,
    "Price": 10.58,
    "Weight": 1,
    "Taxable": true,
    "Attributes": [
        {
            "attr_code": "size",
            "opt_code_or_data": "schmedium",
            "price": 0,
            "weight": 0
        },
        {
            "attr_code": "color",
            "opt_code_or_data": "pink",
            "price": 0,
            "weight": 0
        }
    ]
}
```

---

#### Update Order Item

```
PUT /orders/{id}/items/{line_id}
```

**Enable Function:** `OrderItem_Update`

| HTTP Method | Endpoint | Path Identifiers | Omit Request Parameters
| :---: | :---: | :---: | :---: |
| PUT | /orders/{id}/items/{line_id} | {id} = Order Id<br>{line_id} = Line Item Id | Order_ID<br>Line_ID |

**Example Request Body**

```json
{
    "Code": "tea-shirt",
    "Name": "Custom Tea Shirt"
}
```

---

#### Cancel Order Items

```
PUT /orders/{id}/items/cancel
```

**Enable Function:** `OrderItemList_Cancel`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /orders/{id}/items/cancel | {id} = Order Id | Order_ID |

**Example Request Body**

```json
{
    "Reason" : "Customer called to remove items",
    "line_ids": [9525]
}
```

---

#### Delete Order Items

```
PUT /orders/{id}/items/delete
```

**Enable Function:** `OrderItemList_Delete`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /orders/{id}/items/delete | {id} = Order Id | Order_ID |

**Example Request Body**

```json
{
    "line_ids": [9525, 9526]
}
```

---

#### Backorder Order Items

```
PUT /orders/{id}/items/backorder
```

**Enable Function:** `OrderItemList_Backorder`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /orders/{id}/items/backorder | {id} = Order Id | Order_ID |

**Example Request Body**

```json
{
    "Date_InStock" : 1550658619,
    "line_ids": [9524]
}
```

---

#### Load Orders Custom Fields List

```
GET /orders/customfields
```

**Enable Function:** `OrderCustomFieldList_Load`

| HTTP Method | Endpoint |
| :---: | :---: |
| GET | /orders/customfields |

---

#### Update Order Custom Field Values

```
PUT /orders/{id}/customfields
```

**Enable Function:** `OrderCustomFields_Update`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /orders/{id}/customfields | {id} = Order Id | Order_ID |

**Example Request Body**

```json
{
    "CustomField_Values": {
        "customfields": {
            "order_test": "Hola Mundo"
        }
    }
}
```

---

### Order Queue Endpoints

#### Load Order Queue List

```
GET /orderqueues/{code}
```

**Enable Function:** `QueueOrderList_Load_Query`

| HTTP Method | Endpoint | Path Identifier | Filters |
| :---: | :---: | :---: | :---: |
| GET | /orderqueues/{code} | {code} = Queue Code | count<br>odc<br>offset<br>search<br>sort |

---

#### Create Order Queue Acknowledgement

```
POST /orderqueues
```

**Enable Function:** `OrderList_Acknowledge`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /orderqueues |

**Example Request Body**

```json
{
    "Order_Ids": [97213, 97214]
}
```

---

### Payment Endpoints

#### Capture Order Payment

```
PUT /payments/{id}/capture
```

**Enable Function:** `OrderPayment_Capture`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /payments/{id}/capture | {id} = Order Payment Id | OrderPayment_ID |

**Example Request Body**

```json
{
    "Amount": 8.00
}
```

---

#### Refund Order Payment

```
PUT /payments/{id}/refund
```

**Enable Function:** `OrderPayment_Refund`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /payments/{id}/refund | {id} = Order Payment Id | OrderPayment_ID |

**Example Request Body**

```json
{
    "Amount": 8.00
}
```

---

#### Void Order Payment

```
PUT /payments/{id}/void
```

**Enable Function:** `OrderPayment_VOID`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /payments/{id}/void | {id} = Order Payment Id | OrderPayment_ID |

**Example Request Body**

```json
{
    "Amount": 8.00
}
```

---

### Price Group Endpoints

#### Load Price Groups List

```
GET /pricegroups
```

**Enable Function:** `PriceGroupList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /pricegroups | count<br>offset<br>search<br>sort |

---

#### Load Price Group

```
GET /pricegroups/{id}
```

**Enable Function:** `PriceGroupList_Load_Query`

| HTTP Method | Endpoint | Path Identifier | Filters |
| :---: | :---: | :---: | :---: |
| GET | /pricegroups/{id} | {id} = Price Group Id | count<br>odc<br>offset<br>search<br>show<br>sort<br>assigned<br>unassigned

---

#### Load Price Group Products List

```
GET /pricegroups/{id}/products
```

**Enable Function:** `PriceGroupProductList_Load_Query`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /pricegroups/{id}/products | {id} = Price Group Id |

---

#### Update Price Group Product Assignment

```
PUT /pricegroups/{id}/products
```

**Enable Function:** `PriceGroupProduct_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /pricegroups/{id}/products | {id} = Price Group Id | PriceGroup_ID |

**Example Request Body**

```json
{
    "Product_Code": "prod1",
    "Assigned": true
}
```

---

#### Update Price Group Customer Assignment

```
PUT /pricegroups/{id}/customers
```

**Enable Function:** `PriceGroupCustomer_Update_Assigned`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /pricegroups/{id}/customers | {id} = Price Group Id | PriceGroup_ID |

**Example Request Body**

```json
{
    "Customer_login": "psteezy",
    "Assigned": true
}
```

---

### Product Endpoints

#### Load Products List

```
GET /products
```

**Enable Function:** `ProductList_Load_Query`

| HTTP Method | Endpoint | Filters |
| :---: | :---: | :---: |
| GET | /products | count<br>odc<br>offset<br>search<br>show<br>sort |

---

#### Load Product

```
GET /products/{id}
```

**Enable Function:** `ProductList_Load_Query`

| HTTP Method | Endpoint | Path Identifier | Filter |
| :---: | :---: | :---: | :---: |
| GET | /products/{id} | {id} = Product Id | odc |

---

#### Create Product

```
POST /products
```

**Enable Function:** `Product_Insert`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /products |

**Example Request Body**

```json
{
    "Product_Code": "new-product",
    "Product_SKU": "555182",
    "Product_Name": "New Product",
    "Product_Description": "New descripion",
    "Product_Page_Title": "New Product",
    "Product_Price": 5.29,
    "Product_Cost": 1.27,
    "Product_Weight": 3.58,
    "Product_Inventory": 26,
    "Product_Taxable": true,
    "Product_Active": true,
    "CustomField_Values": {
        "customfields": {
            "marco": "polo"
        }
    }
}
```

---

#### Update Product

```
PUT /products/{id}
```

**Enable Function:** `Product_Update`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| PUT | /products/{id} | {id} = Product Id | Product_ID |

**Example Request Body**

```json
{
    "Product_Code": "new-new-product",
    "Product_Name": "New New Product",
    "Product_Description": "New new descripion",
    "Product_Page_Title": "New New Product",
    "Product_Price": 5.55
}
```

---

#### Delete Product

```
DELETE /products/{id}
```

**Enable Function:** `Product_Delete`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| DELETE | /products/{id} | {id} = Product Id |

---

#### Adjust Product List Inventory

```
POST /products/inventory
```

**Enable Function:** `ProductList_Adjust_Inventory`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /products/inventory |

**Example Request Body**

```json
{
    "Inventory_Adjustments": [
        {
            "product_code": "new-new-product",
            "adjustment": 9
        },
        {
            "product_code": "psteezy-deluxe",
            "adjustment": 50
        },
        {
            "product_code": "blk-shirt",
            "adjustment": -100
        }
    ]
}
```

---

#### Create Product Image

```
POST /products/{id}/images
```

**Enable Function:** `ProductImage_Add`

| HTTP Method | Endpoint | Path Identifier | Omit Request Parameter
| :---: | :---: | :---: | :---: |
| POST | /products/{id}/images | {id} = Product Id | Product_ID |

**Example Request Body**

```json
{
    "Filepath": "graphics/00000001/B1009.001.png",
    "ImageType_ID": 0
}
```

---

#### Delete Product Image

```
DELETE /products/images/{id}
```

**Enable Function:** `ProductImage_Delete`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| DELETE | /products/images/{id} | {id} = Product Image Id |

---

#### Load Product Variants List

```
GET /products/{id}/variants
```

**Enable Function:** `ProductVariantList_Load_Product`

| HTTP Method | Endpoint | Path Identifier |
| :---: | :---: | :---: |
| GET | /products/{id}/variants | {id} = Product Id |

---

### Provisioning Endpoints

#### Domain Level Provisioning

```
POST /provisioning/domain
```

**Enable Function:** `Provision_Domain`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /provisioning/domain |

**Example Request Body**

```json
{
   "xml": "<User_Add><Name>miva_merchant<\/Name><Password>password<\/Password><Administrator>Yes<\/Administrator><\/User_Add>"
}
```

---

#### Store Level Provisioning

```
POST /provisioning/store
```

**Enable Function:** `Provision_Store`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /provisioning/store |

**Example Request Body**

```json
{
   "xml": "<Product_CustomField module=\"baskinv\" field=\"total_inv\" product=\"test\">500</Product_CustomField>"
}
```

---

### Shipment Endpoints

#### Create Order Shipment

```
POST /shipments
```

**Enable Function:** `OrderItemList_CreateShipment`

| HTTP Method | Endpoint |
| :---: | :---: |
| POST | /shipments |

**Example Request Body**

```json
{
    "Order_Id": 97209,
    "line_ids": [9513, 9514]
}
```

---

#### Update Order Shipments

```
PUT /shipments
```

**Enable Function:** `OrderShipmentList_Update`

| HTTP Method | Endpoint |
| :---: | :---: |
| PUT | /shipments |

**Example Request Body**

```json
{
    "Shipment_Updates": [
        {
            "shpmnt_id": 287,
            "mark_shipped": true,
            "tracknum": "12345",
            "tracktype": "UPS",
            "cost": "5.00"
        }
    ]
}
```

---