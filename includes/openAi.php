<?php

add_action('admin_menu', function () {
    add_options_page(
        'OpenAI Settings',
        'OpenAI Settings',
        'manage_options',
        'openai-settings',
        'openai_settings_page'
    );
});

// Renderiza a página
function openai_settings_page()
{
?>
    <div class="wrap">
        <h1>Configurações OpenAI</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('openai_settings_group');
            do_settings_sections('openai-settings');
            $token = esc_attr(get_option('openai_api_token'));
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Token da API</th>
                    <td><input type="text" name="openai_api_token" value="<?php echo $token; ?>" style="width:400px;" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Registra a opção
add_action('admin_init', function () {
    register_setting('openai_settings_group', 'openai_api_token');
});
