<?php
/**
 * PWA hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_pwa_manifest_builder() {
    if (negarshop_option('pwa_status') !== 'true') {
        return;
    }
    $site_url = str_replace([
        'https://',
        'http://',
        $_SERVER['SERVER_NAME']
    ], '', site_url());

    $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $manifestUrl = site_url('/manifest.json');
    $manifestUrl = str_replace(['https://', 'http://'], '', $manifestUrl);
    $myTheme = wp_get_theme();
    $icon192 = negarshop_option('icons_192');
    $icon512 = negarshop_option('icons_512');
    $data = [
        "short_name" => negarshop_option('app_title'),
        "name" => negarshop_option('app_full_title'),
        "icons" => [
            [
                "src" => $icon192['url'],
                "type" => "image/png",
                "sizes" => "192x192",
                "purpose" => "any maskable"
            ],
            [
                "src" => $icon512['url'],
                "type" => "image/png",
                "sizes" => "512x512",
                "purpose" => "any maskable"
            ]
        ],
        "display" => negarshop_option('display_format'),
        "start_url" => $site_url . '/',
        "lang" => "fa-IR",
        "description" => negarshop_option('app_desc'),
        "background_color" => negarshop_option('pwa_bg_color'),
        "theme_color" => negarshop_option('pwa_primary_color'),
        "scope" => $site_url . '/',
        "prefer_related_applications" => false,
        "version" => $myTheme->get('Version')
    ];

    negarshop_smart_file_builder(ABSPATH . 'manifest.json', json_encode($data));
}

function negarshop_pwa_offline_page_builder() {
    if (negarshop_option('pwa_status') !== 'true') {
        return;
    }
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title><?php _e('نسخه آفلاین', 'negarshop'); ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#3f51b5">
        <link rel="manifest" href="/manifest.json">
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
                -webkit-font-smoothing: antialiased;
            }

            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            h1, div {
                text-align: center;
                padding: 30px;
            }
        </style>
    </head>
    <body>
    <h1><?php _e('اینترنت خود را متصل کنید.', 'negarshop'); ?></h1>
    </body>
    </html>
    <?php
    $data = ob_get_clean();
    negarshop_smart_file_builder(ABSPATH . 'offline.html', $data);
}

function negarshop_smart_file_builder($path, $content) {
    $getOption = get_option('ns_' . md5($path), '');
    if (file_exists($path) && sha1($content) === $getOption) {
        return;
    }

    if (file_put_contents($path, $content) !== false) {
        update_option('ns_' . md5($path), sha1_file($path), true);
    }
}

function negarshop_pwa_service_worker_builder() {
    if (negarshop_option('pwa_status') !== 'true') {
        return;
    }
    $urlsToCache = [
        get_theme_file_uri('statics/css/bootstrap.min.css'),
        get_theme_file_uri('statics/css/owl.carousel.min.css'),
        get_theme_file_uri('statics/css/core.css'),
        get_theme_file_uri('statics/js/bootstrap.min.js'),
        get_theme_file_uri('statics/js/script.js')
    ];
    ob_start();
    ?>
    const CACHE_NAME = 'offline';
    const OFFLINE_URL = '<?php echo site_url('offline.html'); ?>';
    const urlsToCache = <?php echo str_replace('\/', '/', json_encode($urlsToCache)); ?>;

    self.addEventListener('install', function(event) {
    event.waitUntil((async () => {
    const cache = await caches.open(CACHE_NAME);
    // Setting {cache: 'reload'} in the new request will ensure that the response
    // isn't fulfilled from the HTTP cache; i.e., it will be from the network.
    cache.addAll(urlsToCache);
    await cache.add(new Request(OFFLINE_URL, {cache: 'reload'}));
    })());

    self.skipWaiting();
    });

    self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
    // Enable navigation preload if it's supported.
    // See https://developers.google.com/web/updates/2017/02/navigation-preload
    if ('navigationPreload' in self.registration) {
    await self.registration.navigationPreload.enable();
    }
    })());

    // Tell the active service worker to take control of the page immediately.
    self.clients.claim();
    });

    self.addEventListener('fetch', function(event) {
    // console.log('[Service Worker] Fetch', event.request.url);
    if (event.request.mode === 'navigate') {
    event.respondWith((async () => {
    try {
    const preloadResponse = await event.preloadResponse;
    if (preloadResponse) {
    return preloadResponse;
    }

    const networkResponse = await fetch(event.request);
    return networkResponse;
    } catch (error) {
    console.log('[Service Worker] Fetch failed; returning offline page instead.', error);

    const cache = await caches.open(CACHE_NAME);
    const cachedResponse = await cache.match(OFFLINE_URL);
    return cachedResponse;
    }
    })());
    }
    });
    <?php

    $data = ob_get_clean();
    negarshop_smart_file_builder(ABSPATH . 'service-worker.js', $data);
}

function negarshop_pwa_manifest_loader() {
    if (negarshop_option('pwa_status') !== 'true') {
        return;
    }
    ?>
    <link rel="manifest" href="<?= site_url('/manifest.json') ?>">
    <?php
}

add_action('init', 'negarshop_pwa_manifest_builder');
add_action('init', 'negarshop_pwa_offline_page_builder');
add_action('init', 'negarshop_pwa_service_worker_builder');
add_action('wp_head', 'negarshop_pwa_manifest_loader');
