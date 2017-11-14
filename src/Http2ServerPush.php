<?php
/**
 * HTTP2 Server Push plugin for Craft CMS 3.x
 *
 * Automatically add HTTP2 Link headers for CSS, JS and image assets.
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\http2serverpush;

use craft\events\TemplateEvent;
use craft\web\View;
use superbig\http2serverpush\services\Http2ServerPushService as Http2ServerPushServiceService;
use superbig\http2serverpush\models\Settings;

use Craft;
use craft\base\Plugin;

use yii\base\Event;

/**
 * Class Http2ServerPush
 *
 * @author    Superbig
 * @package   Http2ServerPush
 * @since     1.0.0
 *
 * @property  Http2ServerPushServiceService $http2ServerPushService
 * @method    Settings getSettings()
 *
 */
class Http2ServerPush extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Http2ServerPush
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init ()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            View::class,
            View::EVENT_AFTER_RENDER_PAGE_TEMPLATE,
            function (TemplateEvent $event) {
                $event->output = $this->http2ServerPushService->output($event->output);
            }
        );

        Craft::info(
            Craft::t(
                'http2-server-push',
                '{name} plugin loaded',
                [ 'name' => $this->name ]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel ()
    {
        return new Settings();
    }
}
