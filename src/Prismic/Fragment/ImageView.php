<?php
/**
 * This file is part of the Prismic PHP SDK
 *
 * Copyright 2013 Zengularity (http://www.zengularity.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prismic\Fragment;

use DOMDocument;

/**
 * This class embodies an image view.
 * An image in prismic.io is made of views: a main unnamed one, and optional named ones.
 * Typically, views are different sizes of the same image ("icon", "large", ...),
 * but not necessarily.
 */
class ImageView
{
    /**
     * @var string  the image view's URL
     */
    private $url;
    /**
     * @var string  the image view's alternative text
     */
    private $alt;
    /**
     * @var string  the image view's copyright
     */
    private $copyright;
    /**
     * @var integer the image view's width
     */
    private $width;
    /**
     * @var integer the image view's height
     */
    private $height;

    /**
     * Constructs an image view.
     *
     * @param string  $url          the image view's URL
     * @param string  $alt          the image view's URL
     * @param string  $copyright    the image view's URL
     * @param string  $width        the image view's URL
     * @param string  $height       the image view's URL
     */
    public function __construct($url, $alt, $copyright, $width, $height)
    {
        $this->url = $url;
        $this->alt = $alt;
        $this->copyright = $copyright;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Builds a HTML version of the image view.
     *
     * @api
     *
     * @param \Prismic\LinkResolver $linkResolver the link resolver
     * @param array                 $attributes   associative array of HTML attributes to add to the <img> tag
     *
     * @return string the HTML version of the image view
     */
    public function asHtml($linkResolver = null, $attributes = array())
    {
        $doc = new DOMDocument();
        $img = $doc->createElement('img');
        $attributes = array_merge(array(
            'src' => $this->getUrl(),
            'alt' => htmlentities($this->getAlt()),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
        ), $attributes);
        foreach ($attributes as $key => $value) {
            $img->setAttribute($key, $value);
        }
        $doc->appendChild($img);

        return trim($doc->saveHTML()); // trim removes trailing newline
    }

    /**
     * Returns the ratio of the image view.
     *
     * @api
     *
     * @return integer  the image view's ratio
     */
    public function ratio()
    {
        return $this->width / $this->height;
    }

    /**
     * Returns the URL of the image view.
     *
     * @api
     *
     * @return string  the image view's URL
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns the alternative text of the image view.
     *
     * @api
     *
     * @return string  the image view's alternative text
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Returns the copyright text of the image view.
     *
     * @api
     *
     * @return string  the image view's copyright text
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Returns the width of the image view.
     *
     * @api
     *
     * @return integer  the image view's width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Returns the height of the image view.
     *
     * @api
     *
     * @return integer  the image view's height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Parses a given image view fragment. Not meant to be used except for testing.
     *
     * @param  \stdClass                    $json the json bit retrieved from the API that represents an image view.
     * @return \Prismic\Fragment\ImageView  the manipulable object for that image view.
     */
    public static function parse($json)
    {
        return new ImageView(
            $json->url,
            $json->alt,
            $json->copyright,
            $json->dimensions->width,
            $json->dimensions->height
        );
    }
}
