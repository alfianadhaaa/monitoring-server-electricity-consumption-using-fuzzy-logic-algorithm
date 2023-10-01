<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard/showAlert/(:num)', 'Dashboard::showAlert/$1');

// Monitoring
$routes->get('/monitoring', 'Monitoring::index');
$routes->get('/monitoring/real-time-chart', 'Monitoring::realTimeChart');

// Device
$routes->delete('/device/(:num)', 'Device::delete/$1');
$routes->post('/device/save', 'Device::save');
$routes->get('/device', 'Device::index');
$routes->get('/device/create', 'Device::create');
$routes->get('/device/edit/(:num)', 'Device::edit/$1');
$routes->post('/device/update/(:num)', 'Device::update/$1');

// Take Data From Sensor
$routes->get('/sensor/(:segment)/(:segment)', 'Sensor::get_data_sensor/$1/$2');
$routes->get('/sensor-detail/(:segment)/(:segment)', 'Sensor::sensor_detail/$1/$2');
$routes->get('/insert-sensor-detail', 'Sensor::insertData');

// Alert
$routes->post('/alert/update/(:num)', 'Alert::updateAlert/$1');
$routes->post('/alert/updatedata', 'Alert::updatedata');
$routes->get('/alert', 'Alert::index');
$routes->post('/alert/checkAlert', 'Alert::checkAlert');
$routes->get('/alertupdate', 'Alert::updateTypeAlert');
$routes->get('/insert-alert-detail', 'Alert::insertData');
$routes->post('/alert/filter', 'Alert::filter');
$routes->get('/alert-export-pdf/(:any)/(:any)', 'Alert::exportPDF/$1/$2');

//Test section
$routes->get('/monitoring/test', 'Monitoring::test_query');
//End test section

// Fuzzy Logic
$routes->get('/fuzzy', 'FuzzyLogic::index');
$routes->get('/fuzzy-update-alert', 'FuzzyLogic::updateAlertType');

// Report
$routes->get('/report', 'Report::index');
$routes->post('/report/filter', 'Report::filter');
// $routes->get('/download-report', 'Report::exportPDF');
$routes->get('/export-pdf/(:any)/(:any)', 'Report::exportPDF/$1/$2');
$routes->get('/export-excel/(:any)/(:any)', 'Report::exportExcel/$1/$2');
$routes->get('/report-chart', 'Report::chart');
$routes->post('/report-chart-filter', 'Report::filterChart');

// $routes->group('monitoring', ['namespace' => 'App\Controllers'], function ($routes) {
//     // Rute pertama
//     $routes->get('/monitoring', 'Dashboard::index');

//     // Rute kedua
//     // $routes->get('/fuzzy', 'FuzzyLogic::index');
//     $routes->get('/alertupdate', 'Alert::updateTypeAlert');
// });

$routes->get('chart', 'Dashboard::chartDashboard');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
