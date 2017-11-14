<?php
/**
 * HTTP2 Server Push plugin for Craft CMS 3.x
 *
 * Automatically add HTTP2 Link headers for CSS, JS and image assets.
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

/**
 * HTTP2 Server Push config.php
 *
 * This file exists only as a template for the HTTP2 Server Push settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'http2-server-push.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [

    // Limit how many assets to include as Link headers
    "limit"         => null,

    // Don't parse image tags by default
    "includeImages" => false,

];
