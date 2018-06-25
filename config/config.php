<?php

Config::set('site_name', 'The Berg');

Config::set('languages', array('ua','en'));

Config::set('routes', array(
    'default' => '',
    'admin' => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_language', 'ua');
Config::set('default_controller', 'videos');
Config::set('default_action', 'index');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.db_name', 'mvc');

Config::set('salt', 'djksfnsd88sdf7fgf');