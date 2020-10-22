<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    // Register scoped middleware for in scopes.
    $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httponly' => true,
    ]));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    $builder->applyMiddleware('csrf');

    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
     */
    $builder->connect('/default', ['controller' => 'Pages', 'action' => 'display', 'home']);

    $builder->connect('/changelang', ['controller' => 'App', 'action' => 'changeLang']);
    $builder->connect('/changelang-default', ['controller' => 'App', 'action' => 'changeLangDefault']);

    $builder->connect('/admin/login', [ 'prefix' => 'Admin', 'controller' => 'Authentication', 'action' => 'login', 'login']);
    $builder->connect('/admin/register', [ 'prefix' => 'Admin', 'controller' => 'Authentication', 'action' => 'register', 'register']);
    $builder->connect('/admin/logout', [ 'prefix' => 'Admin', 'controller' => 'Authentication', 'action' => 'logout']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    Router::prefix('admin', function (RouteBuilder $routes){
        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'home']);
        $routes->connect('/user', ['controller' => 'User', 'action' => 'index']);
        $routes->connect('/category', ['controller' => 'Category', 'action' => 'index']);
        $routes->connect('/commodity', ['controller' => 'Commodity', 'action' => 'index']);
    });

    Router::prefix('api', function (RouteBuilder $routes){
        $routes->connect('/login', ['controller' => 'Login', 'action' => 'login']);
        // User
        $routes->connect('/users/list', ['controller' => 'User', 'action' => 'getList']);
        $routes->connect('/users/get', ['controller' => 'User', 'action' => 'get']);
        $routes->connect('/users/save', ['controller' => 'User', 'action' => 'save']);
        $routes->connect('/users/delete', ['controller' => 'User', 'action' => 'delete']);

        // Category
        $routes->connect('/category/list', ['controller' => 'Category', 'action' => 'getList']);
        $routes->connect('/category/get', ['controller' => 'Category', 'action' => 'get']);
        $routes->connect('/category/save', ['controller' => 'Category', 'action' => 'save']);
        $routes->connect('/category/delete', ['controller' => 'Category', 'action' => 'delete']);

        //Commodity
        $routes->connect('/commodity/list', ['controller' => 'Commodity', 'action' => 'getList']);
        $routes->connect('/commodity/get', ['controller' => 'Commodity', 'action' => 'get']);
        $routes->connect('/commodity/save', ['controller' => 'Commodity', 'action' => 'save']);
        $routes->connect('/commodity/delete', ['controller' => 'Commodity', 'action' => 'delete']);
    });
    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
