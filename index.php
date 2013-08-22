<?php

require 'vendor/autoload.php';
require 'app/functions.php';

// Get database settings 

$config = parse_ini_file("config/app.ini");

$settings = array(
    'driver' => 'mysql',
    'host' => $config['database.host'],
    'database' => $config['database.dbname'],
    'username' => $config['database.username'],
    'password' => $config['database.password'],
    'collation' => 'utf8_general_ci',
    'charset'   => "utf8",
    'prefix' => '',
    'port'      => 3306,
);


// Bootstrap Eloquent ORM

$app->db = Capsule\Database\Connection::make('default', $settings, true);
 
 
/**
 *@todo add log settings  
 */
$app = new \Slim\Slim(array(
    'mode' => 'development',
    'debug' => true,
));


// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

require_once 'app/routes/users.php';
require_once 'app/routes/locations.php';

$app->run();
?>
