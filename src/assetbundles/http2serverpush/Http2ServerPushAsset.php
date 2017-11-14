<?php
/**
 * HTTP2 Server Push plugin for Craft CMS 3.x
 *
 * Automatically add HTTP2 Link headers for CSS, JS and image assets.
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\http2serverpush\assetbundles\Http2ServerPush;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Superbig
 * @package   Http2ServerPush
 * @since     1.0.0
 */
class Http2ServerPushAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@superbig/http2serverpush/assetbundles/http2serverpush/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Http2ServerPush.js',
        ];

        $this->css = [
            'css/Http2ServerPush.css',
        ];

        parent::init();
    }
}
