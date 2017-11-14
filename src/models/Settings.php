<?php
/**
 * HTTP2 Server Push plugin for Craft CMS 3.x
 *
 * Automatically add HTTP2 Link headers for CSS, JS and image assets.
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\http2serverpush\models;

use superbig\http2serverpush\Http2ServerPush;

use Craft;
use craft\base\Model;

/**
 * @author    Superbig
 * @package   Http2ServerPush
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var integer|null
     */
    public $limit = null;

    /**
     * @var boolean
     */
    public $includeImages = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [ 'includeImages', 'boolean' ],
            [ 'includeImages', 'default', 'value' => false ],
        ];
    }
}
