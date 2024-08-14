<?php
/**
 * Class for loading and managing fonts
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

if( ! class_exists('Auxin_Fonts') ){

/**
*
*/
class Auxin_Fonts {

  /**
   * Instance of this class.
   *
   * @var      object
   */
    protected static $instance = null;

    // List of parsed selected fonts
    public $selected_fonts     = array();
    // List of selected fonts (not parsed)
    public $selected_raw_fonts = array();
    // List of URLs for loading selected fonts
    public $enqueue_font_urls  = array();

    public $special_chars      = '';

    public $googleFontsPrefix  = '_gof_';          // Google fonts prefix
    public $systemFontsPrefix  = '_sys_';          // System fonts prefix
    public $geaFontsPrefix     = '_gea_';          // Google Early Access fonts prefix
    public $customFontsPrefix  = '_cus_';          // Custom fonts prefix

    public $force_all_weights = true;
    public $complete_weights  = '400,900italic,900,800italic,800,700italic,700,600italic,600,500italic,500,400italic,300italic,300,200italic,200,100italic,100';

    public $default_fonts     = array();

    private $extra_google_fonts_to_load = array();



    function __construct(){

    }


    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    /**
     * Get all fonts list
     *
     * @return array    Fonts list
     */
    public function get_fonts_list(){

        $fonts_list = array();

        $fonts_list['system'] = array(
            'title' => __('System Fonts', 'phlox-pro' ),
            'faces' => array(
                array( 'name' => 'arial'      , 'title' => 'Arial'      , 'thickness' => 'normal,bold' ),
                array( 'name' => 'verdana'    , 'title' => 'Verdana'    , 'thickness' => 'normal,bold' ),
                array( 'name' => 'trebuchet'  , 'title' => 'Trebuchet'  , 'thickness' => 'normal,bold' ),
                array( 'name' => 'georgia'    , 'title' => 'Georgia'    , 'thickness' => 'normal,bold' ),
                array( 'name' => 'times'      , 'title' => 'Times'      , 'thickness' => 'normal,bold' ),
                array( 'name' => 'tahoma'     , 'title' => 'Tahoma'     , 'thickness' => 'normal,bold' ),
                array( 'name' => 'palatino'   , 'title' => 'Palatino'   , 'thickness' => 'normal,bold' ),
                array( 'name' => 'helvetica'  , 'title' => 'Helvetica'  , 'thickness' => 'normal,bold' )
            )
        );

        $fonts_list['google_early'] = array(

            'title' => __('Google Early Access', 'phlox-pro' ),
            'faces' => array(
                array( 'name' => 'Alef Hebrew'     , 'title' => 'Alef Hebrew (Hebrew)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/alefhebrew.css' ),
                array( 'name' => 'Amiri'     , 'title' => 'Amiri (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/amiri.css' ),
                array( 'name' => 'Dhurjati'     , 'title' => 'Dhurjati (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/dhurjati.css' ),
                array( 'name' => 'Dhyana'     , 'title' => 'Dhyana (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/dhyana.css' ),
                array( 'name' => 'Droid Arabic Kufi'     , 'title' => 'Droid Arabic Kufi (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/droidarabickufi.css' ),
                array( 'name' => 'Droid Arabic Naskh'     , 'title' => 'Droid Arabic Naskh (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/droidarabicnaskh.css' ),
                array( 'name' => 'Droid Sans Ethiopic'     , 'title' => 'Droid Sans Ethiopic (Ethiopic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/droidsansethiopic.css' ),
                array( 'name' => 'Droid Sans Tamil'     , 'title' => 'Droid Sans Tamil (Tamil)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/droidsanstamil.css' ),
                array( 'name' => 'Droid Sans Thai'     , 'title' => 'Droid Sans Thai (Thai)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/droidsansthai.css' ),
                array( 'name' => 'Droid Serif Thai'     , 'title' => 'Droid Serif Thai (Thai)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/droidserifthai.css' ),
                array( 'name' => 'Gidugu'     , 'title' => 'Gidugu (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/gidugu.css' ),
                array( 'name' => 'Gurajada'     , 'title' => 'Gurajada (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/gurajada.css' ),
                array( 'name' => 'Hanna'     , 'title' => 'Hanna (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/hanna.css' ),
                array( 'name' => 'Jeju Gothic'     , 'title' => 'Jeju Gothic (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/jejugothic.css' ),
                array( 'name' => 'Jeju Hallasan'     , 'title' => 'Jeju Hallasan (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/jejuhallasan.css' ),
                array( 'name' => 'Jeju Myeongjo'     , 'title' => 'Jeju Myeongjo (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/jejumyeongjo.css' ),
                array( 'name' => 'Karla Tamil Inclined'     , 'title' => 'Karla Tamil Inclined (Tamil)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/karlatamilinclined.css' ),
                array( 'name' => 'Karla Tamil Upright'     , 'title' => 'Karla Tamil Upright (Tamil)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/karlatamilupright.css' ),
                array( 'name' => 'KoPub Batang'     , 'title' => 'KoPub Batang (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/kopubbatang.css' ),
                array( 'name' => 'Lakki Reddy'     , 'title' => 'Lakki Reddy (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/lakkireddy.css' ),
                array( 'name' => 'Lao Muang Don'     , 'title' => 'Lao Muang Don (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/laomuangdon.css' ),
                array( 'name' => 'Lao Muang Khong'     , 'title' => 'Lao Muang Khong (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/laomuangkhong.css' ),
                array( 'name' => 'Lao Sans Pro'     , 'title' => 'Lao Sans Pro (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/laosanspro.css' ),
                array( 'name' => 'Lateef'     , 'title' => 'Lateef (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/lateef.css' ),
                array( 'name' => 'Lohit Bengali'     , 'title' => 'Lohit Bengali (Bengali)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/lohitbengali.css' ),
                array( 'name' => 'Lohit Devanagari'     , 'title' => 'Lohit Devanagari (Hindi)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/lohitdevanagari.css' ),
                array( 'name' => 'Lohit Tamil'     , 'title' => 'Lohit Tamil (Tamil)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/lohittamil.css' ),
                array( 'name' => 'Mallanna'     , 'title' => 'Mallanna (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/mallanna.css' ),
                array( 'name' => 'Mandali'     , 'title' => 'Mandali (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/mandali.css' ),
                array( 'name' => 'Myanmar Sans Pro'     , 'title' => 'Myanmar Sans Pro (Myanmar)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/myanmarsanspro.css' ),
                array( 'name' => 'NATS'     , 'title' => 'NATS (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/nats.css' ),
                array( 'name' => 'NTR'     , 'title' => 'NTR (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/ntr.css' ),
                array( 'name' => 'Nanum Brush Script'     , 'title' => 'Nanum Brush Script (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/nanumbrushscript.css' ),
                array( 'name' => 'Nanum Gothic'     , 'title' => 'Nanum Gothic (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/nanumgothic.css' ),
                array( 'name' => 'Nanum Gothic Coding'     , 'title' => 'Nanum Gothic Coding (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/nanumgothiccoding.css' ),
                array( 'name' => 'Nanum Myeongjo'     , 'title' => 'Nanum Myeongjo (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/nanummyeongjo.css' ),
                array( 'name' => 'Nanum Pen Script'     , 'title' => 'Nanum Pen Script (Korean)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/nanumpenscript.css' ),
                array( 'name' => 'Noto Kufi Arabic'     , 'title' => 'Noto Kufi Arabic (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notokufiarabic.css' ),
                array( 'name' => 'Noto Naskh Arabic'     , 'title' => 'Noto Naskh Arabic (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notonaskharabic.css' ),
                array( 'name' => 'Noto Nastaliq Urdu Draft'     , 'title' => 'Noto Nastaliq Urdu Draft (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notonastaliqurdudraft.css' ),
                array( 'name' => 'Noto Sans Armenian'     , 'title' => 'Noto Sans Armenian (Armenian)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansarmenian.css' ),
                array( 'name' => 'Noto Sans Bengali'     , 'title' => 'Noto Sans Bengali (Bengali)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansbengali.css' ),
                array( 'name' => 'Noto Sans Cherokee'     , 'title' => 'Noto Sans Cherokee (Cherokee)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanscherokee.css' ),
                array( 'name' => 'Noto Sans Devanagari'     , 'title' => 'Noto Sans Devanagari (Hindi)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansdevanagari.css' ),
                array( 'name' => 'Noto Sans Devanagari UI'     , 'title' => 'Noto Sans Devanagari UI (Hindi)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansdevanagariui.css' ),
                array( 'name' => 'Noto Sans Ethiopic'     , 'title' => 'Noto Sans Ethiopic (Ethiopic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansethiopic.css' ),
                array( 'name' => 'Noto Sans Georgian'     , 'title' => 'Noto Sans Georgian (Georgian)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansgeorgian.css' ),
                array( 'name' => 'Noto Sans Gujarati'     , 'title' => 'Noto Sans Gujarati (Gujarati)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansgujarati.css' ),
                array( 'name' => 'Noto Sans Gurmukhi'     , 'title' => 'Noto Sans Gurmukhi (Gurmukhi)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansgurmukhi.css' ),
                array( 'name' => 'Noto Sans Hebrew'     , 'title' => 'Noto Sans Hebrew (Hebrew)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanshebrew.css' ),
                array( 'name' => 'Noto Sans Japanese'     , 'title' => 'Noto Sans Japanese (Japanese)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansjapanese.css' ),
                array( 'name' => 'Noto Sans Kannada'     , 'title' => 'Noto Sans Kannada (Kannada)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanskannada.css' ),
                array( 'name' => 'Noto Sans Khmer'     , 'title' => 'Noto Sans Khmer (Khmer)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanskhmer.css' ),
                array( 'name' => 'Noto Sans Kufi Arabic'     , 'title' => 'Noto Sans Kufi Arabic (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanskufiarabic.css' ),
                array( 'name' => 'Noto Sans Lao'     , 'title' => 'Noto Sans Lao (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanslao.css' ),
                array( 'name' => 'Noto Sans Lao UI'     , 'title' => 'Noto Sans Lao UI (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanslaoui.css' ),
                array( 'name' => 'Noto Sans Malayalam'     , 'title' => 'Noto Sans Malayalam (Malayalam)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansmalayalam.css' ),
                array( 'name' => 'Noto Sans Myanmar'     , 'title' => 'Noto Sans Myanmar (Myanmar)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansmyanmar.css' ),
                array( 'name' => 'Noto Sans Osmanya'     , 'title' => 'Noto Sans Osmanya (Osmanya)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansosmanya.css' ),
                array( 'name' => 'Noto Sans Sinhala'     , 'title' => 'Noto Sans Sinhala (Sinhala)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanssinhala.css' ),
                array( 'name' => 'Noto Sans Tamil'     , 'title' => 'Noto Sans Tamil (Tamil)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanstamil.css' ),
                array( 'name' => 'Noto Sans Tamil UI'     , 'title' => 'Noto Sans Tamil UI (Tamil)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanstamilui.css' ),
                array( 'name' => 'Noto Sans Telugu'     , 'title' => 'Noto Sans Telugu (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosanstelugu.css' ),
                array( 'name' => 'Noto Sans Thai'     , 'title' => 'Noto Sans Thai (Thai)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansthai.css' ),
                array( 'name' => 'Noto Sans Thai UI'     , 'title' => 'Noto Sans Thai UI (Thai)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notosansthaiui.css' ),
                array( 'name' => 'Noto Serif Armenian'     , 'title' => 'Noto Serif Armenian (Armenian)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notoserifarmenian.css' ),
                array( 'name' => 'Noto Serif Georgian'     , 'title' => 'Noto Serif Georgian (Georgian)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notoserifgeorgian.css' ),
                array( 'name' => 'Noto Serif Khmer'     , 'title' => 'Noto Serif Khmer (Khmer)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notoserifkhmer.css' ),
                array( 'name' => 'Noto Serif Lao'     , 'title' => 'Noto Serif Lao (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notoseriflao.css' ),
                array( 'name' => 'Noto Serif Thai'     , 'title' => 'Noto Serif Thai (Thai)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/notoserifthai.css' ),
                array( 'name' => 'Open Sans Hebrew'     , 'title' => 'Open Sans Hebrew (Hebrew)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/opensanshebrew.css' ),
                array( 'name' => 'Open Sans Hebrew Condensed'     , 'title' => 'Open Sans Hebrew Condensed (Hebrew)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/opensanshebrewcondensed.css' ),
                array( 'name' => 'Padauk'     , 'title' => 'Padauk (Myanmar)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/padauk.css' ),
                array( 'name' => 'Peddana'     , 'title' => 'Peddana (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/peddana.css' ),
                array( 'name' => 'Phetsarath'     , 'title' => 'Phetsarath (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/phetsarath.css' ),
                array( 'name' => 'Ponnala'     , 'title' => 'Ponnala (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/ponnala.css' ),
                array( 'name' => 'Ramabhadra'     , 'title' => 'Ramabhadra (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/ramabhadra.css' ),
                array( 'name' => 'Ravi Prakash'     , 'title' => 'Ravi Prakash (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/raviprakash.css' ),
                array( 'name' => 'Scheherazade'     , 'title' => 'Scheherazade (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/scheherazade.css' ),
                array( 'name' => 'Souliyo'     , 'title' => 'Souliyo (Lao)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/souliyo.css' ),
                array( 'name' => 'Sree Krushnadevaraya'     , 'title' => 'Sree Krushnadevaraya (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/sreekrushnadevaraya.css' ),
                array( 'name' => 'Suranna'     , 'title' => 'Suranna (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/suranna.css' ),
                array( 'name' => 'Suravaram'     , 'title' => 'Suravaram (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/suravaram.css' ),
                array( 'name' => 'Tenali Ramakrishna'     , 'title' => 'Tenali Ramakrishna (Telugu)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/tenaliramakrishna.css' ),
                array( 'name' => 'Thabit'     , 'title' => 'Thabit (Arabic)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/thabit.css' ),
                array( 'name' => 'Tharlon'     , 'title' => 'Tharlon (Myanmar)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/tharlon.css' ),
                array( 'name' => 'cwTeXFangSong'     , 'title' => 'cwTeXFangSong (Chinese_traditional)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/cwtexfangsong.css' ),
                array( 'name' => 'cwTeXHei'     , 'title' => 'cwTeXHei (Chinese-traditional)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/cwtexhei.css' ),
                array( 'name' => 'cwTeXKai'     , 'title' => 'cwTeXKai (Chinese_traditional)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/cwtexkai.css' ),
                array( 'name' => 'cwTeXMing'     , 'title' => 'cwTeXMing (Chinese_traditional)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/cwtexming.css' ),
                array( 'name' => 'cwTeXYen'     , 'title' => 'cwTeXYen (Chinese_traditional)'   , 'thickness' => '400,700' , 'url' => '//fonts.googleapis.com/earlyaccess/cwtexyen.css' )
            )
        );

        $fonts_list['custom'] = array(
            'title' => __('Custom Fonts', 'phlox-pro' ),
            'faces' => array(
                array( 'name' => 'mj_casablanca'   ,'title' => 'Casablanca Farsi'   , 'thickness' => 'normal,bold' )
            )
        );

        return apply_filters( 'auxin_get_fonts_list', $fonts_list );
    }

    /**
     * Get all fonts list
     *
     * @return array    Fonts list
     */
    public function get_default_fonts(){
        return apply_filters( 'auxin_get_default_fonts_info', $this->default_fonts );
    }

    /**
     * A string containing list name of special charecters
     *
     * @return string      A string containing these words: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext
     */
    public function get_special_charecters(){
        return auxin_get_option( 'include_latin_chars' ) ? 'latin,latin-ext' : '';
    }


    /**
     * Update the list name of special charecters
     * this method will be called during saving options
     *
     * @return void
     */
    public function update_special_charecters(){
        set_theme_mod( 'font_subsets', $this->get_special_charecters() );
    }


    /**
     * Gets font query/info and extracts the font components
     *
     * @param  string  $font_info  A query containing font info like type,family, weight, .. (example: _gof_Roboto:400)
     * @return void
     */
    public function extract_font( $font_info, $option_id = '' ){
        $components = array();

        if( isset( $font_info['font'] ) ){
            $font_info = $font_info['font'];
        }

        // if prefixed by googleFontsPrefix
        if( strpos( $font_info, $this->googleFontsPrefix ) !== false ){
            $components = $this->extract_components( $font_info, $this->googleFontsPrefix, 'google' );
            $this->create_typography_options( $option_id, $components, $wrap_by_quote = true );

        // if prefixed by systemFontsPrefix
        } elseif( strpos( $font_info, $this->systemFontsPrefix ) !== false ){
            $components = $this->extract_components( $font_info, $this->systemFontsPrefix, 'others' );
            $this->create_typography_options( $option_id, $components, $wrap_by_quote = false );

        // if prefixed by geaFontsPrefix
        } elseif( strpos( $font_info, $this->geaFontsPrefix ) !== false ){
            $components = $this->extract_components( $font_info, $this->geaFontsPrefix   , 'others' );
            $this->create_typography_options( $option_id, $components, $wrap_by_quote = true );

        // if prefixed by customFontsPrefix
        } elseif( strpos( $font_info, $this->customFontsPrefix ) !== false ){
            $components = $this->extract_components( $font_info, $this->customFontsPrefix, 'others' );
            $this->create_typography_options( $option_id, $components, $wrap_by_quote = true );
        }

        return $components;
    }


    /**
     * Generate and store corresponding (face, weight) typography options. For example option_name[_face], option_name[_weight]
     *
     * @param  string  $option_id     The main typography option ID
     * @param  array   $components    The parsed font components
     * @param  boolean $wrap_by_quote Whether to wrap font face name by single quote or not
     * @return void
     */
    public function create_typography_options( $option_id, $components, $wrap_by_quote = false ){

        // Dont save parsed options in theme options if theme options are not saved yet. #theme-standards
        if( $option_id && false !== get_option( THEME_ID.'_theme_options' ) ){
            $face    = $wrap_by_quote ? '"'.$components['face'].'"' : $components['face'];

            auxin_update_option( $option_id.'_face'  , $face      );
            auxin_update_option( $option_id.'_weight', $components['thickness'] );
            auxin_update_option( $option_id.'_style' , $components['style'] );
        }
    }


    /**
     * Gets font query/info with type and prefix and extracts font components
     *
     * @param  string $font_info  A query containing font info like type,family, weight, .. (example: _gof_Roboto:400)
     * @param  string $prefix     A prefix which indicates the font type
     * @param  string $category   Indicates whether it's google font or not
     * @return void
    */
    public function extract_components( $font_info, $prefix = '', $category = 'others' ){

        $link_query = trim( $font_info );
        $link_query = trim( $link_query, $prefix );

        $thickness  = substr( $link_query,    strpos( $link_query, ':' ) + 1 );
        $face       = substr( $link_query, 0, strpos( $link_query, ':' )     );
        $style      = strpos( $thickness, 'italic' ) !== false ? 'italic' : '';

        $link_query = str_replace( ' ', '+', $link_query );
        $url        = $this->get_font_url( $face, $link_query, $category );

        $thickness  = str_replace( "italic", "", $thickness );

        $selected_font = array(
            'face'       => $face,       // font-face
            'thickness'  => $thickness,  // font-weight
            'style'      => $style,      // font-style
            'link_query' => $link_query, // css link query
            'url'        => $url         // URL to load the font
        );

        $this->selected_fonts[ $category ][ $face ] = $selected_font;

        return $selected_font;
    }


    /**
     * Returns a url for loading font
     *
     * @param  string $face       The font name
     * @param  string $link_query The font name and weight
     * @param  string $category   The category to which the font belongs
     * @return string         A url for loading font
     */
    public function get_font_url( $face, $link_query, $category = 'others' ){

        if( 'google' == $category ){
            return '//fonts.googleapis.com/css?family='.$link_query;
        } else {

            $font_dic = $this->get_fonts_list();

            foreach ( $font_dic as $group_id => $group ) {
                if( isset( $group['faces'] ) ){

                    foreach ( $group['faces'] as $font_info ) {

                        if( $font_info['name'] == $face ){
                            return isset( $font_info['url'] ) ? $font_info['url'] : '';
                        }
                    }
                }
            }
        }

        return '';
    }


    public function load_font( $font_id, $font_query ){
        $this->extra_google_fonts_to_load[ $font_id ] = $font_query;
    }


    public function collect_font_urls(){

        // collects google font queries
        $google_fonts_queries = '';

        // Loop through all font groups
        foreach ( $this->selected_fonts as $group_fonts_id => $group_fonts ) {
            foreach ( $group_fonts as $font_info ) {

                if( 'google' == $group_fonts_id ){
                    $font_id = str_replace( ' ', '+', $font_info['face'] );
                    if( $font_id && $this->force_all_weights ){
                        $font_id .= ':' . $this->complete_weights;
                    }
                    $google_fonts_queries .= $font_id ? $font_id . '|' : '';

                } elseif( $font_info['url'] ) {
                    $face = 'auxin-font-'. sanitize_title( $font_info['face'] );
                    $this->enqueue_font_urls[ $face ] = $font_info['url'];
                }

            }
        }

        foreach ( $this->extra_google_fonts_to_load as $google_font_query ) {
            $google_fonts_queries .= $google_font_query . '|';
        }

        if( $google_fonts_queries ){
            $google_fonts_queries = trim( $google_fonts_queries, '|' );

            if( $ext_chars = $this->get_special_charecters() ){
                $google_fonts_queries .= '&subset='. $ext_chars;
            }
            $this->enqueue_font_urls[ 'auxin-fonts-google' ] = '//fonts.googleapis.com/css?family='. $google_fonts_queries;
        }
    }



   /**
    * Creates and stores links for loading selected fonts, and registers css to enqueue by wp
    *
    * @return void
    */
    public function parse_typography(){

        // google: List of google font load query, like: Open+Sans:400,700
        // others: Url of loading font face, like: //fonts.googleapis.com/earlyaccess/alefhebrew.css
        $this->selected_fonts = array(
            'google'  => array(),
            'others'  => array()
        );

        $this->selected_raw_fonts = array();


        // Collects the list of URLs for loading selected fonts
        $this->enqueue_font_urls  = array();

        // Gets and updates special charecter sets
        $this->update_special_charecters();

        // Includes all defined options
        $options = Auxin_Option::api()->data->fields;

        // loop through all options and get typography elements
        // then store google fonts in an array ($enq_fonts)
        if( auxin_get_option( 'enable_custom_typography', 0 ) ){
            foreach ( $options as $option ) {
                if( isset( $option['type'] ) && $option['type'] == 'typography' ){
                    // get stored font name
                    $font_info = auxin_get_option( $option['id'] );

                    if( ! empty( $font_info ) ){
                        $this->extract_font( $font_info, $option['id'] );
                        $this->selected_raw_fonts[ $option['id'] ] = $font_info;
                    }
                }
            }
        }

        // get the default fonts info
        $default_fonts = $this->get_default_fonts();

        foreach ( $default_fonts as $font_id => $font_info ) {
            if( ! empty( $font_info ) ){
                $this->extract_font( $font_info, '' );
                $this->selected_raw_fonts[ $font_id ] = $font_info;
            }
        }

        // parse and collect the fonts link
        $this->collect_font_urls();

        // You can use this filter hook to modify the list of font URLs before saving
        $this->enqueue_font_urls = apply_filters( 'auxin_enqueue_font_urls', $this->enqueue_font_urls );

        // Store font URLs as option
        set_theme_mod( 'font_urls'  , $this->enqueue_font_urls );

        do_action( 'auxin_parse_typography', $this->selected_fonts, $this->selected_raw_fonts );
    }

}


}
