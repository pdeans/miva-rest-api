<?php

/*
|--------------------------------------------------------------------------
| Availability Group Routes
|--------------------------------------------------------------------------
*/
$router->get('/availabilitygroups', ['uses' => 'AvailabilityGroupController@readList']);
$router->get('/availabilitygroups/{id}', ['uses' => 'AvailabilityGroupController@readOne']);
// Update Assignments
$router->put('/availabilitygroups/{id}/businessaccounts', ['uses' => 'AvailabilityGroupController@updateBusinessAccount']);
$router->put('/availabilitygroups/{id}/customers', ['uses' => 'AvailabilityGroupController@updateCustomer']);
$router->put('/availabilitygroups/{id}/paymentmethods', ['uses' => 'AvailabilityGroupController@updatePaymentMethod']);
$router->put('/availabilitygroups/{id}/products', ['uses' => 'AvailabilityGroupController@updateProduct']);
$router->put('/availabilitygroups/{id}/shippingmethods', ['uses' => 'AvailabilityGroupController@updateShippingMethod']);

/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
*/
$router->get('/categories', ['uses' => 'CategoryController@readList']);
$router->get('/categories/{id}', ['uses' => 'CategoryController@readOne']);
$router->post('/categories', ['uses' => 'CategoryController@create']);
$router->put('/categories/{id}', ['uses' => 'CategoryController@update']);
$router->delete('/categories/{id}', ['uses' => 'CategoryController@delete']);
// Product List
$router->get('/categories/{id}/products', ['uses' => 'CategoryController@readProductsList']);
// Update Product Assignments
$router->put('/categories/{id}/products', ['uses' => 'CategoryController@updateProduct']);
// Subcategory List
$router->get('/categories/{id}/subcategories', ['uses' => 'CategoryController@readSubcategoriesList']);

/*
|--------------------------------------------------------------------------
| Coupon Routes
|--------------------------------------------------------------------------
*/
$router->get('/coupons', ['uses' => 'CouponController@readList']);
$router->get('/coupons/{id}', ['uses' => 'CouponController@readOne']);
$router->post('/coupons', ['uses' => 'CouponController@create']);
$router->put('/coupons/{id}', ['uses' => 'CouponController@update']);
$router->delete('/coupons', ['uses' => 'CouponController@delete']);
// Price Group List
$router->get('/coupons/{id}/pricegroups', ['uses' => 'CouponController@readPriceGroupsList']);
// Update Price Group Assignments
$router->put('/coupons/{id}/pricegroups', ['uses' => 'CouponController@updatePriceGroup']);

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
$router->get('/customers', ['uses' => 'CustomerController@readList']);
$router->get('/customers/{id}', ['uses' => 'CustomerController@readOne']);
$router->post('/customers', ['uses' => 'CustomerController@create']);
$router->put('/customers/{id}', ['uses' => 'CustomerController@update']);
$router->delete('/customers/{id}', ['uses' => 'CustomerController@delete']);
// Address Book List
$router->get('/customers/{id}/addresses', ['uses' => 'CustomerController@readAddressList']);
// Price Group List
$router->get('/customers/{id}/pricegroups', ['uses' => 'CustomerController@readPriceGroupList']);

/*
|--------------------------------------------------------------------------
| Note Routes
|--------------------------------------------------------------------------
*/
$router->get('/notes', ['uses' => 'NoteController@readList']);
$router->get('/notes/{id}', ['uses' => 'NoteController@readOne']);
$router->post('/notes', ['uses' => 'NoteController@create']);
$router->put('/notes/{id}', ['uses' => 'NoteController@update']);
$router->delete('/notes/{id}', ['uses' => 'NoteController@delete']);

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
*/
// Custom Fields
// Note: these routes must remain at the top to avoid a BadRouteException
$router->put('/orders/{id}/customfields', ['uses' => 'OrderController@updateCustomFields']);
$router->get('/orders/customfields', ['uses' => 'OrderController@readCustomFieldList']);
// Orders
$router->get('/orders', ['uses' => 'OrderController@readList']);
$router->get('/orders/{id}', ['uses' => 'OrderController@readOne']);
$router->post('/orders', ['uses' => 'OrderController@create']);
$router->delete('/orders/{id}', ['uses' => 'OrderController@delete']);
// Customer Info
$router->put('/orders/{id}/customers', ['uses' => 'OrderController@updateCustomer']);
// Order Items
$router->post('/orders/{id}/items', ['uses' => 'OrderController@createItem']);
$router->put('/orders/{id}/items/cancel', ['uses' => 'OrderController@updateCancelItemList']);
$router->put('/orders/{id}/items/delete', ['uses' => 'OrderController@updateDeleteItemList']);
$router->put('/orders/{id}/items/backorder', ['uses' => 'OrderController@updateBackorderItemList']);
$router->put('/orders/{id}/items/{line_id}', ['uses' => 'OrderController@updateItem']);

/*
|--------------------------------------------------------------------------
| Order Queue Routes
|--------------------------------------------------------------------------
*/
$router->get('/orderqueues/{code}', ['uses' => 'OrderQueueController@readList']);
$router->post('/orderqueues', ['uses' => 'OrderQueueController@createAcknowledge']);

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
*/
$router->put('/payments/{id}/capture', ['uses' => 'PaymentController@updateCapture']);
$router->put('/payments/{id}/refund', ['uses' => 'PaymentController@updateRefund']);
$router->put('/payments/{id}/void', ['uses' => 'PaymentController@updateVoid']);

/*
|--------------------------------------------------------------------------
| Price Group Routes
|--------------------------------------------------------------------------
*/
$router->get('/pricegroups', ['uses' => 'PriceGroupController@readList']);
$router->get('/pricegroups/{id}', ['uses' => 'PriceGroupController@readOne']);
// Products
$router->get('/pricegroups/{id}/products', ['uses' => 'PriceGroupController@readProductsList']);
$router->put('/pricegroups/{id}/products', ['uses' => 'PriceGroupController@updateProduct']);
// Customers
$router->put('/pricegroups/{id}/customers', ['uses' => 'PriceGroupController@updateCustomer']);

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
$router->get('/products', ['uses' => 'ProductController@readList']);
$router->get('/products/{id}', ['uses' => 'ProductController@readOne']);
$router->post('/products', ['uses' => 'ProductController@create']);
$router->put('/products/{id}', ['uses' => 'ProductController@update']);
$router->delete('/products/{id}', ['uses' => 'ProductController@delete']);
// Inventory
$router->post('/products/inventory', ['uses' => 'ProductController@createInventory']);
// Images
$router->post('/products/{id}/images', ['uses' => 'ProductController@createImage']);
$router->delete('/products/images/{id}', ['uses' => 'ProductController@deleteImage']);
// Variants
$router->get('/products/{id}/variants', ['uses' => 'ProductController@readVariantsList']);

/*
|--------------------------------------------------------------------------
| Provisioning Routes
|--------------------------------------------------------------------------
*/
$router->post('/provisioning/domain', ['uses' => 'ProvisionController@createDomain']);
$router->post('/provisioning/store', ['uses' => 'ProvisionController@createStore']);

/*
|--------------------------------------------------------------------------
| Shipment Routes
|--------------------------------------------------------------------------
*/
$router->post('/shipments', ['uses' => 'ShipmentController@create']);
$router->put('/shipments', ['uses' => 'ShipmentController@update']);
