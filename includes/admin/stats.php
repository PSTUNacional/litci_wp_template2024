<?php
/*========================================

    PAGE RENDER

========================================*/

function render_theme_stats()
{
    $options = $GLOBALS['options'];
?>

    <h1>Estatísticas do site</h1>
    <?php settings_errors(); // Exibe alertas na página 

    $url = $_SERVER['REQUEST_URI']; // Obtém o caminho da URL atual

    // Verifica se "/pt" está presente na URL
    if (strpos($url, '/pt') !== false) {
        ?>
        <iframe width="1200" height="2200" src="https://lookerstudio.google.com/embed/reporting/983e8dd1-4b65-4c95-82fd-7706b0858e78/page/p_d9yoyfx7jd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
        <?php
    }

    if (strpos($url, '/es') !== false) {
        ?>
        <iframe width="1200" height="2200" src="https://lookerstudio.google.com/embed/reporting/da8b54fb-4264-40e1-815d-0fb484391f25/page/Xvn1B" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
        <?php
    }

    
}
