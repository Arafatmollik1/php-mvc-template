<?php


$session = new Zebra_Session(
    $database,                          // mysqli link resource
    $config->session['security_code'], // security code
    $config->session['lifetime'],      // session lifetime
    $config->session['lock_to_user_agent'], // lock to user agent
    $config->session['lock_to_ip'],    // lock to IP
    900,                            // lock timeout
    'sessions',                     // session table name
    true                            // start session immediately
    // read_only parameter is not included in your configuration, you can set it to false or true based on your requirement
);
$createNewSession=false;
// Store user info in session
if ($createNewSession) {
  echo 'new session start';
}

