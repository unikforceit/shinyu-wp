<?php

// add_action('wp_head', 'amano_add_favicon');
// add_action('login_head', 'amano_add_favicon');
// add_action('admin_head', 'amano_add_favicon');

function amano_add_favicon() {
	echo '<link rel="apple-touch-icon" sizes="57x57" href="' . STATIC_URI .  '/favicon/apple-icon-57x57.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="60x60" href="' . STATIC_URI .  '/favicon/apple-icon-60x60.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="72x72" href="' . STATIC_URI .  '/favicon/apple-icon-72x72.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="76x76" href="' . STATIC_URI .  '/favicon/apple-icon-76x76.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="114x114" href="' . STATIC_URI .  '/favicon/apple-icon-114x114.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="120x120" href="' . STATIC_URI .  '/favicon/apple-icon-120x120.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="144x144" href="' . STATIC_URI .  '/favicon/apple-icon-144x144.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="152x152" href="' . STATIC_URI .  '/favicon/apple-icon-152x152.png">' . PHP_EOL;
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . STATIC_URI .  '/favicon/apple-icon-180x180.png">' . PHP_EOL;
	echo '<link rel="icon" type="image/png" sizes="192x192"  href="' . STATIC_URI .  '/favicon/android-icon-192x192.png">' . PHP_EOL;
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . STATIC_URI .  '/favicon/favicon-32x32.png">' . PHP_EOL;
	echo '<link rel="icon" type="image/png" sizes="96x96" href="' . STATIC_URI .  '/favicon/favicon-96x96.png">' . PHP_EOL;
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . STATIC_URI .  '/favicon/favicon-16x16.png">' . PHP_EOL;
	echo '<meta name="msapplication-TileImage" content="' . STATIC_URI . '/favicon/ms-icon-144x144".png">' . PHP_EOL;
}