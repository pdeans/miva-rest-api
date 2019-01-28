# Miva JSON Api REST Wrapper

PHP library providing a RESTful interface for interacting with the Miva JSON API.

## Installation

Install via [Composer](https://getcomposer.org/).

```
$ composer create-project pdeans/miva-rest-api
```

## Getting Started

### Web Server Setup

The web server setup assumes a standard Miva Merchant installation on the server. After downloading the project files, create a directory named `RestApi` on the web server's root directory and place the project files in the directory.

**NOTE:** The project files should **NEVER** be placed in a public facing directory on the web server as this can expose API credentials. Typically, this is the `/httpdocs` directory.

Within the project root, locate the `/httpdocs` directory and copy or move the `/api` directory and all of its contents to the root of the web server's public directory. Again, the public directory is generally `/httpdocs` for standard Miva Merchant installations.

The directory and file structure should resemble the following from the web server root:

```
/httpdocs
    |-- api
        |-- .htaccess
        |-- index.php

/RestApi
    |-- Project Files

```

Essentially, the require statement in the `/httpdocs/api/index.php` file should link to the project's `/bootstrap/app.php` path.

### Configuration

All of the configuration options for the project are stored in the `.env` file on the project root.

Here is a breakdown of the settings relevant to the Miva Merchant JSON Api:

| Key | Required | Description |
| --- | --- | --- |
| MM_API_URL | Yes | The Api endpoint URL. |
| MM_STORE_CODE | Yes | The store code. |
| MM_API_TOKEN | Yes | The Api access token. |
| MM_API_KEY | Yes | The Api private key. |
| MM_API_HTTP_HEADERS | No | Http headers to issue on each API request. The header name and value are separated by a colon "<strong>:</strong>". Multiple headers can be issued via comma separated list.<br><br><strong>Example value:</strong><br>```"Auth: Basic dXNlcjpwYXNzd29yZA==, Custom: header-value"``` |
| MM_API_HTTP_CLIENT_OPTS | No | Curl options to set on the underlying http client. The curl option name and value are separated by a colon "<strong>:</strong>". Multiple options can be issued via comma separated list.<br><br><strong>Example value:</strong><br>```"CURLOPT_SSL_VERIFYPEER:0, CURLOPT_SSL_VERIFYHOST:0"``` |

## Routes

The following section defines the routes available for the REST Api.

#### Availability Group Routes

**GET** `/availabilitygroups`<br>
**GET** `/availabilitygroups/{id}`<br>
**PUT** `/availabilitygroups/{id}/businessaccounts`<br>
**PUT** `/availabilitygroups/{id}/customers`<br>
**PUT** `/availabilitygroups/{id}/paymentmethods`<br>
**PUT** `/availabilitygroups/{id}/products`<br>
**PUT** `/availabilitygroups/{id}/shippingmethods`<br>

#### Category Routes

**GET** `/categories`<br>
**GET** `/categories/{id}`<br>
**POST** `/categories`<br>
**PUT** `/categories/{id}`<br>
**DELETE** `/categories/{id}`<br>
**GET** `/categories/{id}/products`<br>
**PUT** `/categories/{id}/products`<br>
**GET** `/categories/{id}/subcategories`<br>

#### Coupon Routes

**GET** `/coupons`<br>
**GET** `/coupons/{id}`<br>
**POST** `/coupons`<br>
**PUT** `/coupons/{id}`<br>
**DELETE** `/coupons`<br>
**GET** `/coupons/{id}/pricegroups`<br>
**PUT** `/coupons/{id}/pricegroups`<br>

#### Customer Routes

**GET** `/customers`<br>
**GET** `/customers/{id}`<br>
**POST** `/customers`<br>
**PUT** `/customers/{id}`<br>
**DELETE** `/customers/{id}`<br>
**GET** `/customers/{id}/addresses`<br>
**GET** `/customers/{id}/pricegroups`<br>

#### Note Routes

**GET** `/notes`<br>
**GET** `/notes/{id}`<br>
**POST** `/notes`<br>
**PUT** `/notes/{id}`<br>
**DELETE** `/notes/{id}`<br>

#### Order Routes

**PUT** `/orders/{id}/customfields`<br>
**GET** `/orders/customfields`<br>
**GET** `/orders`<br>
**GET** `/orders/{id}`<br>
**POST** `/orders`<br>
**DELETE** `/orders/{id}`<br>
**PUT** `/orders/{id}/customers`<br>
**POST** `/orders/{id}/items`<br>
**PUT** `/orders/{id}/items/cancel`<br>
**PUT** `/orders/{id}/items/delete`<br>
**PUT** `/orders/{id}/items/backorder`<br>
**PUT** `/orders/{id}/items/{line_id}`<br>

#### Order Queue Routes

**GET** `/orderqueues/{code}`<br>
**POST** `/orderqueues`<br>

#### Payment Routes

**PUT** `/payments/{id}/capture`<br>
**PUT** `/payments/{id}/refund`<br>
**PUT** `/payments/{id}/void`<br>

#### Price Group Routes

**GET** `/pricegroups`<br>
**GET** `/pricegroups/{id}`<br>
**GET** `/pricegroups/{id}/products`<br>
**PUT** `/pricegroups/{id}/products`<br>
**PUT** `/pricegroups/{id}/customers`<br>

#### Product Routes

**GET** `/products`<br>
**GET** `/products/{id}`<br>
**POST** `/products`<br>
**PUT** `/products/{id}`<br>
**DELETE** `/products/{id}`<br>
**POST** `/products/inventory`<br>
**POST** `/products/{id}/images`<br>
**DELETE** `/products/images/{id}`<br>
**GET** `/products/{id}/variants`<br>

#### Provisioning Routes

**POST** `/provisioning/domain`<br>
**POST** `/provisioning/store`<br>

#### Shipment Routes

**POST** `/shipments`<br>
**PUT** `/shipments`<br>

## Coming Soon

- Better documentation :)
- Support for the "filter" parameter