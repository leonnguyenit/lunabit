<?php

defined('LUNA_SYSTEM') or die('Hacking attempt!');

// Load routes from database cache file if it is existed.
$routes_file = LUNA_CACHEPATH . '/data/routes.php';
if (file_exists($routes_file)) {
	require_once $routes_file;
}

// System Routes
$app->get('/system', 'Luna\Controllers\System\Base');
$app->get('/setup/db/creates', 'Luna\Controllers\System\SetupDB:addTables');
$app->get('/setup/db/drops', 'Luna\Controllers\System\SetupDB:dropTables');


// Frontend routes
$app->get('/', 'Luna\Controllers\Home');

// Backend routes
$app->get('/admin', 'Luna\Controllers\Admin\Dashboard');
$app->get("/admin/routes", "Luna\Controllers\Admin\Routes");
$app->get("/admin/routes/add", "Luna\Controllers\Admin\Routes:add");
$app->post("/admin/routes/add", "Luna\Controllers\Admin\Routes:add");
$app->get("/admin/routes/edit/{id:[0-9]+}", "Luna\Controllers\Admin\Routes:edit");
$app->post("/admin/routes/edit/{id:[0-9]+}", "Luna\Controllers\Admin\Routes:edit");
$app->get("/admin/routes/delete/{id:[0-9]+}", "Luna\Controllers\Admin\Routes:delete");

// RESTS API routes
$app->group('/api', function (){

    // API Version 1.0
    $this->group('/v1', function(){

        // About app rests
        $this->get('/intro', 'Luna\Controllers\Rests\Intro');

    });

});