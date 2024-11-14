<?php

/**
 * Add a new options page named "OS Tema".
 */
function theme_admin_page()
{
    add_menu_page(
        'Estatísticas do portal', // Page title
        'Dados', // Menu title
        'manage_options', // Capabilities
        'os_stats', // Menu slug
        'render_theme_stats', // Function
        'dashicons-chart-line' // Icon URL
        // Position
    );
}

add_action('admin_menu', 'theme_admin_page');

include get_template_directory() . '/includes/admin/stats.php';