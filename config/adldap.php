<?php

return [
    'account_suffix' => "",

    'domain_controllers' => array(env('LDAP_DOMAIN')), // An array of domains may be provided for load balancing.

    'base_dn' =>  env('BASE_DN'),

    'admin_username' => env('LDAP_USERNAME'),

    'admin_password' => env('LDAP_PASSWORD'),

    'real_primary_group' => true, // Returns the primary group (an educated guess).

    'use_ssl' => false, // If TLS is true this MUST be false.

    'use_tls' => false, // If SSL is true this MUST be false.

    'recursive_groups' => false,
];