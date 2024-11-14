<?php

// By default WP expose sensitive data unecessarily through login errors
function litci_hide_login_errors()
{
    return __('Nome de usuário ou senha inválidos');
}
add_filter('login_errors', 'litci_hide_login_errors');

// Crawlers use WP version to exploit vunerabilities
function litci_hide_version()
{
    return '';
}
add_filter('the_generator', 'litci_hide_version');

// Disable Users route in WP API
add_filter('rest_endpoints', function( $endpoints ) {
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
});