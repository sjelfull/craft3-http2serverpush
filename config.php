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
 * @author    Superbig
 * @package   Http2ServerPush
 * @since     1.0.0
 */

/**
 * Http2ServerPush config.php
 *
 * This file exists only as a template for the Http2ServerPush settings.
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
    // Limit how many tags to include in the Link tag
    'limit'     => null,

    // Include images
    'includeImages' => false,
];