<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * WordPress Replace Image URL
 *
 * Replaces image url content of the WordPress post content.
 *
 * PHP version 5
 * WordPress version 3.5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   UWTHEME
 * @package    UW
 * @author     Upeksha Wisidagama <upeksha@php-sri-lanka.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.0.0
 * @link       https://gist.github.com/upekshawisidagama
 * @since      1.0.0
 */

/**
 * This function is designed to work with WordPress and
 * direct access is not allowed.
 */
if( !defined( 'ABSPATH' ) )
{
    header( 'HTTP/1.0 403 Forbidden' );
    die( 'No Direct Access is Allowed!' );
}

/**
 * define the class if it doesn't already exist.
 */
if ( !class_exists( 'WP_Replace_Image_URL' ) )
{

class WP_Replace_Image_URL
{
    /**
     * New URL
     * 
     * New URL of the Site.
     * 
     * @var string
     * @access private
     */
    private $new_url;
    
    /**
     * Old URL
     * 
     * Old URL of the site.
     * 
     * @var string
     * @access private
     */
    private $old_url;
    
    /**
     * Constructor.
     * 
     * Add a filter to 'the_content' filter hook.
     */
    public function __construct( $old_url, $new_url ) 
    {
        $this->old_url = $old_url;
        $this->new_url = $new_url;
        add_filter( 'the_content', array( $this, 'replace_image_url' ));
    }

    /**
     * Replace Image URL
     * 
     * Filter content and replace image urls.
     * 
     * This function is to be attached to the 'the_content' filter
     * hook. Filters $content and replaces the urls using 
     * 'preg_replace_callback'.
     * 
     * @uses 'preg_replace_callback'
     * @access public
     * @param $content
     * @return $content
     */
    public function replace_image_url( $content )
    {
        /**
         * Regexp to search and fill $matches array.
         */
        $regexp = '#\<img(.+?)src="http:\/\/(.+?)\/images(.+?)\/\>#s';
        
        /**
         * Replace the matched content of the post.
         * @link http://php.net/manual/en/function.preg-replace-callback.php preg_replace_callback
         */
        return preg_replace_callback(
                $regexp, 
                array( $this, replace_url ), 
                $content
        );
    }

    /**
     * Replace URL
     * 
     * Replace new url with the old url
     * 
     * Old url is where the images currently resides. They are not 
     * available in the new url yet. To access the old images replace
     * the new image url with the old image url.
     * 
     * @access public
     * @param array $matches
     * @return string
     */
    private function replace_url( $matches )
    {
        $new_url = $this->new_url;
        $old_url = $this->old_url;    

        if( strpos( $matches[2], $new_url ) !== false )
        {
          return '<img' .  $matches[1] 
            . 'src="http://'
            . $old_url . '/images' 
            . $matches[3]
            . '/>';      
        } 

        return $matches[0];  
    }

}
}

$GLOBALS['wp-replace-image-url'] = new WP_Replace_Image_URL( 
        'AAA.ABCD.com/BBB' , 
        'www.NEWSITE.com' 
);
?>