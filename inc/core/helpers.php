<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Asset Helper
|--------------------------------------------------------------------------
|
| Returns the full URL to an asset inside /assets
|
*/

function mytheme_asset($path)
{

    return MYTHEME_URI . '/assets/' . ltrim($path, '/');
}


/*
|--------------------------------------------------------------------------
| Image Helper
|--------------------------------------------------------------------------
|
| Returns the full URL to an image
|
*/

function mytheme_image($image)
{

    return mytheme_asset('images/' . $image);
}


/*
|--------------------------------------------------------------------------
| CSS Helper
|--------------------------------------------------------------------------
*/

function mytheme_css($file)
{

    return mytheme_asset('css/' . $file);
}


/*
|--------------------------------------------------------------------------
| JS Helper
|--------------------------------------------------------------------------
*/

function mytheme_js($file)
{

    return mytheme_asset('js/' . $file);
}
