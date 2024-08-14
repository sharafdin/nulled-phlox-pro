<?php

/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.2.0
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string  $url      - (required) must be uploaded using wp media uploader
 * @param int     $width    - (required)
 * @param int     $height   - (optional)
 * @param bool    $crop     - (optional) default to soft crop
 * @param bool    $single   - (optional) returns an array if false
 * @param bool    $upscale  - (optional) resizes smaller images
 * @uses  wp_get_upload_dir()
 * @uses  image_resize_dimensions()
 * @uses  wp_get_image_editor()
 *
 * @return str|array
 */

if( ! class_exists( 'Auxin_Aq_Resize' ) ) {

    class Auxin_Aq_Exception extends Exception {}

    class Auxin_Aq_Resize {
        /**
         * The singleton instance
         */
        static private $instance = null;

        /**
         * Should an Auxin_Aq_Exception be thrown on error?
         * If false (default), then the error will just be logged.
         */
        public $throwOnError = false;

        /**
         * No initialization allowed
         */
        private function __construct() {}

        /**
         * No cloning allowed
         */
        private function __clone() {}

        /**
         * For your custom default usage you may want to initialize an Auxin_Aq_Resize object by yourself and then have own defaults
         */
        static public function getInstance() {
            if(self::$instance == null) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Run, forest.
         */
        public function process( $url, $width = null, $height = null, $crop = null, $quality = 100, $single = true, $upscale = false ) {
            try {
                // Validate inputs.
                if (!$url)
                    throw new Auxin_Aq_Exception('$url parameter is required');
                if (!$width)
                    $width = null;
                if (!$height)
                    $height = null;

                // Caipt'n, ready to hook.
                if ( true === $upscale ) add_filter( 'image_resize_dimensions', array($this, 'aq_upscale'), 10, 6 );

                // Define upload path & dir.
                $upload_info = wp_get_upload_dir();
                $upload_dir = $upload_info['basedir'];
                $upload_url = $upload_info['baseurl'];

                $http_prefix = "http://";
                $https_prefix = "https://";
                $relative_prefix = "//"; // The protocol-relative URL

                /* if the $url scheme differs from $upload_url scheme, make them match
                   if the schemes differe, images don't show up. */
                if(!strncmp($url,$https_prefix,strlen($https_prefix))){ //if url begins with https:// make $upload_url begin with https:// as well
                    $upload_url = str_replace($http_prefix,$https_prefix,$upload_url);
                }
                elseif(!strncmp($url,$http_prefix,strlen($http_prefix))){ //if url begins with http:// make $upload_url begin with http:// as well
                    $upload_url = str_replace($https_prefix,$http_prefix,$upload_url);
                }
                elseif(!strncmp($url,$relative_prefix,strlen($relative_prefix))){ //if url begins with // make $upload_url begin with // as well
                    $upload_url = str_replace(array( 0 => "$http_prefix", 1 => "$https_prefix"),$relative_prefix,$upload_url);
                }

                // Check if $img_url is local.
                if ( false === strpos( $url, $upload_url ) )
                    return $url;

                // Define path of image.
                $rel_path = str_replace( $upload_url, '', $url );
                $img_path = $upload_dir . $rel_path;

                // Check if img path exists, and is an image indeed.
                if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) )
                    throw new Auxin_Aq_Exception('Image file does not exist (or is not an image): ' . $img_path);

                // Get image info.
                $info = pathinfo( $img_path );
                $ext = $info['extension'];
                list( $orig_w, $orig_h ) = getimagesize( $img_path );

                // auto calculate the width or height if it was set to 'auto'
                if( 'auto' === $height && is_numeric( $width ) ){
                    $height = $width * ( $orig_h / $orig_w );
                }
                if( 'auto' === $width && is_numeric( $height ) ){
                    $width = $height * ( $orig_w / $orig_h );
                }

                $width  = is_numeric( $width  ) ? round( $width  ) : $width;
                $height = is_numeric( $height ) ? round( $height ) : $height;

                // Get image size after cropping.
                $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
                
                if ( empty( $dims ) ) {
                    return $url;
                }
                
                $dst_w = $dims[4];
                $dst_h = $dims[5];

                if( null === $height ){
                    $dst_h  = $orig_h;
                    $height = $orig_h;
                }
                if( null === $width ){
                    $dst_w = $orig_w;
                    $width = $orig_w;
                }

                // Return the original image only if it exactly fits the needed measures.
                if ( ! $dims || ( ( ( null === $height && $orig_w <= $width ) xor ( null === $width && $orig_h <= $height ) ) xor ( ( $height >= $orig_h && $width >= $orig_w ) && ! $upscale ) ) ) {
                    $img_url = $url;
                    $dst_w = $orig_w;
                    $dst_h = $orig_h;
                } else {
                    // Use this to check if cropped image already exists, so we can return that instead.
                    $suffix = "{$dst_w}x{$dst_h}";
                    $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
                    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

                    if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
                        // Can't resize, so return false saying that the action to do could not be processed as planned.
                        // throw new Auxin_Aq_Exception('Unable to resize image because image_resize_dimensions() failed');
                        $img_url = $url;
                    }

                    // Else check if cache exists.
                    elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
                        $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
                    }
                    // Else, we resize the image and return the new resized image url.
                    else {
                        $editor = wp_get_image_editor( $img_path );

                        if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) ) {
                            if( method_exists( $editor, 'get_error_message' ) ){
                                throw new Auxin_Aq_Exception( 'Unable to get WP_Image_Editor: ' .
                                                   $editor->get_error_message() . ' (is GD or ImageMagick installed?)');
                            } else {
                                throw new Auxin_Aq_Exception( 'Unable to get WP_Image_Editor: is GD or ImageMagick installed?');
                            }
                        }

                        $editor->set_quality($quality);
                        $resized_file = $editor->save();

                        if ( ! is_wp_error( $resized_file ) ) {
                            $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                            $img_url = $upload_url . $resized_rel_path;

                        } elseif( method_exists( $editor, 'get_error_message' ) ){
                            throw new Auxin_Aq_Exception( 'Unable to save resized image file: ' . $editor->get_error_message() );
                        } else {
                            throw new Auxin_Aq_Exception( 'Unable to save resized image file.' );
                        }

                    }
                }

                // Okay, leave the ship.
                if ( true === $upscale ) remove_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ) );

                // Return the output.
                if ( $single ) {
                    // str return.
                    $image = $img_url;
                } else {
                    // array return.
                    $image = array (
                        0 => $img_url,
                        1 => $dst_w,
                        2 => $dst_h
                    );
                }

                return $image;
            }
            catch ( Auxin_Aq_Exception $ex ) {
                error_log('Auxin_Aq_Resize.process() error: ' . $ex->getMessage());

                if ($this->throwOnError) {
                    // Bubble up exception.
                    throw $ex;
                }
                else {
                    // Return false, so that this patch is backwards-compatible.
                    return false;
                }
            }
        }

        public function get_file_extension( $url ){
            return preg_replace( "#\?.*#", "", pathinfo( $url, PATHINFO_EXTENSION ) );
        }

        /**
         * Weather URL file extension matches or not
         *
         * @param [type] $url  URL
         * @param [type] $ext  Extension to be matched
         *
         * @return boolean
         */
        public function is_file_extension( $url, $ext ){
            return $this->get_file_extension( $url ) === $ext;
        }

        /**
         * Callback to overwrite WP computing of thumbnail measures
         */
        public function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {

            if ( ! $crop )
                return null; // Let the wordpress default function handle this.

            // Here is the point we allow to use larger image size than the original one.
            $aspect_ratio = $orig_w / $orig_h;
            $new_w = $dest_w;
            $new_h = $dest_h;

            if ( ! $new_w ) {
                $new_w = intval( $new_h * $aspect_ratio );
            }

            if ( ! $new_h ) {
                $new_h = intval( $new_w / $aspect_ratio );
            }

            $size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

            $crop_w = round( $new_w / $size_ratio );
            $crop_h = round( $new_h / $size_ratio );

            if ( ! is_array( $crop ) || count( $crop ) !== 2 ) {
                $crop = array( 'center', 'center' );
            }

            list( $x, $y ) = $crop;

            if ( 'left' === $x ) {
                $s_x = 0;
            } elseif ( 'right' === $x ) {
                $s_x = $orig_w - $crop_w;
            } else {
                $s_x = floor( ( $orig_w - $crop_w ) / 2 );
            }

            if ( 'top' === $y ) {
                $s_y = 0;
            } elseif ( 'bottom' === $y ) {
                $s_y = $orig_h - $crop_h;
            } else {
                $s_y = floor( ( $orig_h - $crop_h ) / 2 );
            }

            return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
        }

    }
}





/**
 * This is just a tiny wrapper function for the class above so that there is no
 * need to change any code in your own WP themes. Usage is still the same :)
 */
function auxin_aq_resize( $url, $width = null, $height = null, $crop = null, $quality = 100, $single = true, $upscale = false ) {
    $aq_resize = Auxin_Aq_Resize::getInstance();

    if( $aq_resize->is_file_extension( $url, 'svg' ) ){
        return $url;
    }

    /* WPML Fix */
    if ( function_exists('icl_object_id') ) {
        $current_language = apply_filters( 'wpml_current_language', NULL );
        $url = apply_filters( 'wpml_permalink', $url, $current_language, true );
    }

    /* PolyLang Fix */
    if( function_exists( 'pll_current_language' ) && $current_language = pll_current_language() ){
        $url = str_replace('/' . $current_language, '', $url );
    }

    $height = empty( $height ) && ! $crop ? 2300 : $height; // a hack to skip the height crop
    if( $width < 0 ){
        $width = null;
    }
    if( $height < 0 ){
        $height = null;
    }

    return $aq_resize->process( $url, $width, $height, $crop, $quality, $single, $upscale );
}
