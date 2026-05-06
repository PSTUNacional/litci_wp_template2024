<?php
$desktop = $attributes['backgroundImage'] ?? '';
$mobile  = $attributes['backgroundImageMobile'] ?? '';
$link    = $attributes['link'] ?? '#';

// Fallback: se uma das duas faltar, usa a outra
$desktopSrc = $desktop ?: $mobile;
$mobileSrc  = $mobile  ?: $desktop;
?>
<section>
    <div class="container">
        <div class="column">
            <a class="ads" href="<?= esc_url($link) ?>">
                <picture>
                    <source media="(max-width: 768px)" srcset="<?= esc_url($mobileSrc) ?>">
                    <source media="(min-width: 769px)" srcset="<?= esc_url($desktopSrc) ?>">
                    <img src="<?= esc_url($desktopSrc) ?>" alt="" loading="lazy">
                </picture>
            </a>
        </div>
    </div>
</section>