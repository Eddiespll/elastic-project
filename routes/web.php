<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// SEARCH
$router->get('/', 'SearchController@index');
$router->get('/search', 'SearchController@search');
$router->post('/search/autocomplete', 'SearchController@autocomplete');
$router->post('/search/insert', 'SearchController@insert');
$router->post('/search/ranking', 'SearchController@ranking');
$router->get('/search/pagination', 'SearchController@pagination');

// LIST
$router->get('/list', 'ListController@index');
$router->get('/list/insert', 'ListController@insert');
$router->post('/list/insert', 'ListController@insert');
$router->get('/list/update', 'ListController@update');
$router->post('/list/update', 'ListController@update');
$router->get('/list/delete', 'ListController@delete');
$router->post('/list/delete', 'ListController@delete');
$router->get('/list/migrate', 'MigrateController@index');
$router->get('/list/config', 'ListController@config');
$router->post('/list/config', 'ListController@config');

//LINK 
$router->get('/list/link/insert', 'LinkController@insert');
$router->post('/list/link/insert', 'LinkController@insert');
$router->get('/list/link/delete', 'LinkController@delete');
$router->post('/list/link/delete', 'LinkController@delete');

//RULE
$router->get('/list/rule/insert', 'RuleController@insert');
$router->post('/list/rule/insert', 'RuleController@insert');

// INDEX
$router->get('/index/reset', 'IndexController@index');
$router->post('/index/reset', 'IndexController@reset');

//DOCUMENT
$router->get('/document/insert', 'DocumentController@insert');
$router->post('/document/insert', 'DocumentController@insert');



/*
$router->get('/list', 'ListController@index');

$router->get('/list/insert', 'ListController@insert');
$router->post('/list/insert', 'ListController@insert');
$router->put('/list/insert', 'ListController@update');



*/




