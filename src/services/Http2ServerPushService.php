<?php
/**
 * HTTP2 Server Push plugin for Craft CMS 3.x
 *
 * Automatically add HTTP2 Link headers for CSS, JS and image assets.
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\http2serverpush\services;

use Illuminate\Support\Collection;
use superbig\http2serverpush\Http2ServerPush;

use Craft;
use craft\base\Component;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author    Superbig
 * @package   Http2ServerPush
 * @since     1.0.0
 */
class Http2ServerPushService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * The DomCrawler instance.
     *
     * @var Crawler
     */
    protected $crawler;

    /**
     * Handle an incoming request.
     *
     * @param string $output
     *
     * @return mixed
     */
    public function output ($output)
    {
        $request = Craft::$app->getRequest();

        if ( $request->isCpRequest || $request->isLivePreview || $request->getAcceptsJson() ) {
            return $output;
        }

        return $this->generateAndAttachLinkHeaders($output);
    }

    /**
     * @param string $output
     *
     * @return string
     */
    protected function generateAndAttachLinkHeaders ($output)
    {
        $settings = Http2ServerPush::$plugin->getSettings();

        $headers = $this->fetchLinkableNodes($output, $settings->includeImages)
                        ->flatten(1)
                        ->map(function ($url) {
                            return $this->buildLinkHeaderString($url);
                        })
                        ->filter()
                        ->take($settings->limit)
                        ->implode(',');

        if ( !empty(trim($headers)) ) {
            $this->addLinkHeader($headers);
        }

        return $output;
    }

    /**
     * Get the DomCrawler instance.
     *
     * @param string $output
     *
     * @return Crawler
     */
    protected function getCrawler (string $output)
    {
        if ( $this->crawler ) {
            return $this->crawler;
        }

        return $this->crawler = new Crawler($output);
    }

    /**
     * Get all nodes we are interested in pushing.
     *
     * @param string $output
     *
     * @return Collection
     */
    protected function fetchLinkableNodes ($output, $includeImages = false)
    {
        $crawler = $this->getCrawler($output);
        $filter  = 'link, script[src]';

        if ( $includeImages ) {
            $filter .= ', img[src]';
        }

        return new Collection($crawler->filter($filter)->extract([ 'src', 'href' ]));
    }

    /**
     * Build out header string based on asset extension.
     *
     * @param string $url
     *
     * @return string
     */
    private function buildLinkHeaderString ($url)
    {
        $linkTypeMap = [
            '.CSS'  => 'style',
            '.JS'   => 'script',
            '.BMP'  => 'image',
            '.GIF'  => 'image',
            '.JPG'  => 'image',
            '.JPEG' => 'image',
            '.PNG'  => 'image',
            '.TIFF' => 'image',
        ];
        $type        = (new Collection($linkTypeMap))->first(function ($type, $extension) use ($url) {
            return $this->contains(strtoupper($url), $extension);
        });

        return is_null($type) ? null : "<{$url}>; rel=preload; as={$type}";
    }

    /**
     * Add Link Header
     *
     * @param                           $link
     */
    private function addLinkHeader ($link)
    {
        $headers = Craft::$app->getResponse()->getHeaders();

        if ( $headers->get('Link') ) {
            $link = $headers->get('Link') . ',' . $link;
        }

        $headers->set('Link', $link);
    }

    /**
     * @param $haystack
     * @param $needles
     *
     * @return bool
     */
    private function contains ($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ( $needle !== '' && mb_strpos($haystack, $needle) !== false ) {
                return true;
            }
        }

        return false;
    }
}
