<?php

namespace JPDevTools\Core\Init;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Singleton;
use JPDevTools\Core\Factory\SettingFactory;
use JPDevTools\Helpers\HtmlBuilder as Html;

/**
 * InitPublic class
 *
 * @package        Core
 * @subpackage     Init
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class PublicInit extends Singleton {

  /**
   * Option group data
   *
   * @since 0.1.0
   *
   * @var JPDevTools\Core\SettingGroup;
   */
  private $setting_group;

  /**
   * Static instance of this class
   *
   * @since 0.1.0
   *
   * @var PublicInit;
   */
  protected static $instance;

  /**
   * Not found image url
   *
   * @since 0.1.0
   *
   * @var string
   */
  protected $not_found_image;

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  protected function __construct() {
    parent::__construct();
    $this->setting_group = SettingFactory::setting_group( 'jpdevtools-settings' );
  }

  /**
   * Disable WordPress Admin Bar in frontend in specific roles.
   *
   * @since 0.1.0
   */
  public function disable_admin_bar_by_role() {
    $disabled_roles = (array) $this->setting_group->get_option( 'admin-bar-disabled-roles', array() );
    $user           = wp_get_current_user();

    // By default is enabled in all roles.
    if ( empty( $disabled_roles ) || !$user ) {
      return;
    }

    foreach ( $user->roles as $user_rol ) {
      if ( in_array( $user_rol, $disabled_roles ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
        break;
      }
    }
  }

  /**
   * Register & enqueue plugin scripts
   *
   * @since 0.1.0
   */
  public function enqueue_scripts() {
    $scripts = array(
        'bootstrap'  => array(
            'local'     => JPDEVTOOLS_URL . 'assets/js/bootstrap.min.js',
            'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
            'deps'      => array( 'jquery' ),
            'ver'       => '3.3.7',
            'in_footer' => true,
            'autoload'  => false
        ),
        'jpdevtools' => array(
            'local'     => JPDEVTOOLS_URL . 'assets/js/public.js',
            'deps'      => array( 'jquery', 'jquery-form' ),
            'ver'       => '0.1.0',
            'in_footer' => true,
            'autoload'  => true
        ),
        'modernizr'  => array(
            'local'    => JPDEVTOOLS_URL . 'assets/js/modernizr.min.js',
            'remote'   => '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
            'ver'      => '2.8.3',
            'autoload' => true
        ),
    );

    /**
     * Filter plugin scripts
     *
     * @since   0.1.0
     * @param   array   $scripts
     */
    $scripts = apply_filters( 'jpdevtools_register_scripts', $scripts );

    $defaults = array(
        'local'     => '',
        'remote'    => '',
        'deps'      => array(),
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false
    );

    $use_cdn = $this->setting_group->get_bool_option( 'enable-cdn' );

    foreach ( $scripts as $handle => $script ) {
      $script = wp_parse_args( $script, $defaults );

      if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
        $src = $script['remote'];
      } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
        $src = $script['local'];
      } else {
        continue;
      }

      $deps      = $script['deps'];
      $ver       = $script['ver'];
      $in_footer = $script['in_footer'];

      /* Register scripts */
      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
        /* Enqueue scripts if autolad in enabled */
        wp_enqueue_script( $handle );
      }
    }

    /**
     * Filter localize scripts
     *
     * @since   0.1.0
     * @param   array   $localize_script
     */
    $localize_script = apply_filters( 'jpdevtools_localize_scripts', array() );

    wp_localize_script( 'jpdevtools', 'JPDevTools', $localize_script );
  }

  /**
   * Register & enqueue plugin styles
   *
   * @since 0.1.0
   */
  public function enqueue_styles() {
    /**
     * Plugin styles
     *
     * @since 0.1.0
     */
    $styles = array(
        'bootstrap'    => array(
            'remote' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
            'ver'    => '3.3.7',
        ),
        'font-awesome' => array(
            'remote' => '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
            'ver'    => '4.6.3',
        ),
        'animate'      => array(
            'local'  => JPDEVTOOLS_URL . 'assets/css/animate.min.css',
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
            'ver'    => '3.5.2',
            'media'  => 'screen',
        ),
        'hover'        => array(
            'local'  => JPDEVTOOLS_URL . 'assets/css/hover.min.css',
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/hover.css/2.0.2/css/hover-min.css',
            'ver'    => '2.0.2',
            'media'  => 'screen',
        ),
        'jpdevtools'   => array(
            'local'    => JPDEVTOOLS_URL . 'assets/css/public.css',
            'ver'      => '0.1.0',
            'autoload' => true
        ),
    );

    /**
     * Filter styles
     *
     * @since   0.1.0
     * @param   array   $styles
     */
    $styles = apply_filters( 'jpdevtools_register_styles', $styles );

    $defaults = array(
        'local'    => '',
        'remote'   => '',
        'deps'     => array(),
        'ver'      => null,
        'media'    => 'all',
        'autoload' => false
    );

    $use_cdn = $this->setting_group->get_bool_option( 'enable-cdn' );

    foreach ( $styles as $handle => $style ) {
      $style = wp_parse_args( $style, $defaults );

      if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
        $src = $style['remote'];
      } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
        $src = $style['local'];
      } else {
        continue;
      }

      $deps  = $style['deps'];
      $ver   = $style['ver'];
      $media = $style['media'];

      /* Register styles */
      wp_register_style( $handle, $src, (array) $deps, $ver, $media );

      if ( $style['autoload'] ) {
        /* Enqueue styles if autolad in enabled */
        wp_enqueue_style( $handle );
      }
    }
  }

  /**
   * Shows Google Tag Manager script
   *
   * @since 0.1.0
   */
  public function google_tag_manager() {
    $google_tag_manager = $this->setting_group->get_option( 'google-tag-manager', '' );
    if ( !empty( $google_tag_manager ) ) {
      echo (string) $google_tag_manager;
    }
  }

  /**
   * Shows Google Universal Analytics script
   *
   * @since 0.1.0
   */
  public function google_universal_analytics() {
    $google_universal_analytics = $this->setting_group->get_option( 'google-universal-analytics', '' );
    if ( !empty( $google_universal_analytics ) ) {
      echo (string) $google_universal_analytics;
    }
  }

  /**
   * Shows Bing Site Verification code
   *
   * @since 0.1.0
   */
  public function bing_site_verification() {
    // If is Yoast active do nothing;
    if ( defined( 'WPSEO_VERSION' ) ) {
      return;
    }

    $bing_site_verification = $this->setting_group->get_option( 'bing-site-verification', '' );
    if ( !empty( $bing_site_verification ) ) {
      $bing_site_verification = strip_tags( $bing_site_verification );
      echo Html::tag( 'script', $bing_site_verification );
    }
  }

  /**
   * Shows Google Site Verification code
   *
   * @since 0.1.0
   */
  public function google_site_verification() {
    // If is Yoast active do nothing;
    if ( defined( 'WPSEO_VERSION' ) ) {
      return;
    }

    $google_site_verification = $this->setting_group->get_option( 'google-site-verification', '' );
    if ( !empty( $google_site_verification ) ) {
      $google_site_verification = strip_tags( $google_site_verification );
      echo Html::meta( 'google-site-verification', $google_site_verification );
    }
  }

  /**
   * Remove WordPress Version Number from header and feeds
   *
   * @since 0.1.0
   */
  public function remove_wordpress_version() {
    if ( !$this->setting_group->get_bool_option( 'remove-wordpress-version' ) ) {
      return;
    }

    remove_action( 'wp_head', 'wp_generator' );
    add_filter( 'the_generator', '__return_empty_string' );

    $remove_version = function ( $src, $handle ) {
      $src = remove_query_arg( 'ver', $src );
      return $src;
    };

    if ( !$this->setting_group->get_bool_option( 'remove-wordpress-version-all' ) ) {
      return;
    }

    add_filter( 'style_loader_src', $remove_version, 10, 2 );
    add_filter( 'script_loader_src', $remove_version, 10, 2 );
  }

  /**
   * Returns the fallback not found image
   *
   * @since 0.1.0
   *
   * @return string
   */
  public function get_not_found_image_url() {
    if ( empty( $this->not_found_image ) ) {
      $locale = substr( get_locale(), 0, 2 );

      if ( empty( $locale ) || !file_exists( JPDEVTOOLS_DIR . '/assets/images/not-available-' . $locale . '.png' ) ) {
        $this->not_found_image = JPDEVTOOLS_URL . 'assets/images/not-available-en.png';
      } else {
        $this->not_found_image = JPDEVTOOLS_URL . 'assets/images/not-available-' . $locale . '.png';
      }

      $this->not_found_image = $this->setting_group->get_option( 'not-found-image', $this->not_found_image );
    }

    return $this->not_found_image;
  }

  /**
   * Shows a default image when the post don't have featured image
   *
   * @since 0.1.0
   *
   * @staticvar    string    $not_found_image
   * @param        string    $html
   * @param        int       $post_id
   * @param        int       $post_thumbnail_id
   * @param        string    $size
   * @param        array     $attr
   * @return       string
   */
  public function post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    if ( !empty( $html ) ) {
      return $html;
    }

    $attr['alt'] = __( 'Image not available', JPDEVTOOLS_TEXTDOMAIN );
    return Html::img( $this->get_not_found_image_url(), $attr );
  }

  /**
   * Add Open Graph meta tags to header
   *
   * @since 0.1.0
   */
  public function open_graph_tags() {
    // If is Yoast active do nothing;
    if ( defined( 'WPSEO_VERSION' ) ) {
      return;
    }

    // If OpenGraph is disabled do nothing;
    if ( !$this->setting_group->get_bool_option( 'open-graph-enabled' ) ) {
      return;
    }

    $meta_tags = array(
        array( 'property' => 'og:site_name', 'content' => get_bloginfo( 'name' ) ),
    );

    if ( is_page() || is_singular() ) {
      $post = get_post();

      $meta_tags[] = array(
          'property' => 'og:title',
          'content'  => esc_attr( $post->post_title )
      );
      $meta_tags[] = array(
          'property' => 'og:description',
          'content'  => esc_attr( $post->post_excerpt )
      );
      $meta_tags[] = array(
          'property' => 'og:url',
          'content'  => get_permalink( $post )
      );

      $attachment_id = get_post_thumbnail_id( $post->ID );

      if ( $attachment_id ) {
        $attachment  = wp_get_attachment_image_src( $attachment_id, 'full' );
        $meta_tags[] = array(
            'property' => 'og:image',
            'content'  => $attachment[0]
        );
        $meta_tags[] = array(
            'property' => 'og:image:width',
            'content'  => $attachment[1]
        );
        $meta_tags[] = array(
            'property' => 'og:image:width',
            'content'  => $attachment[2]
        );
      }

      if ( !is_front_page() ) {
        $meta_tags[] = array(
            'property' => 'og:type',
            'content'  => 'article'
        );
        $meta_tags[] = array(
            'property' => 'article:published_time',
            'content'  => mysql2date( 'c', $post->post_date ),
        );
        $meta_tags[] = array(
            'property' => 'article:modified_time',
            'content'  => mysql2date( 'c', $post->post_modified )
        );
      } else {
        $meta_tags[] = array(
            'property' => 'og:type',
            'content'  => 'website'
        );
      }
    } else {
      $meta_tags[] = array(
          'property' => 'og:type',
          'content'  => 'website'
      );
    }

    $meta_tags = apply_filters( 'open_graph_tags', $meta_tags );

    echo "\n<!-- Open Graph -->\n";
    foreach ( $meta_tags as $attributes ) {
      echo Html::tag( 'meta', false, $attributes );
    }
  }

  /**
   * Add Twitter cards meta tags to header
   *
   * @since 0.1.0
   */
  public function twitter_card_tags() {
    // If is Yoast active do nothing;
    if ( defined( 'WPSEO_VERSION' ) ) {
      return;
    }

    // If Twitter Cards is disabled do nothing;
    if ( !$this->setting_group->get_bool_option( 'twitter-card-enabled' ) ) {
      return;
    }

    $meta_tags = array();

    if ( is_page() || is_singular() ) {
      $post          = get_post();
      $attachment_id = get_post_thumbnail_id( $post->ID );

      $meta_tags[] = array(
          'name'    => 'twitter:title',
          'content' => esc_attr( $post->post_title )
      );
      $meta_tags[] = array(
          'name'    => 'twitter:description',
          'content' => esc_attr( $post->post_excerpt )
      );
      $meta_tags[] = array(
          'name'    => 'twitter:url',
          'content' => get_permalink( $post )
      );


      if ( $attachment_id ) {
        $attachment  = wp_get_attachment_image_src( $attachment_id, 'full' );
        $meta_tags[] = array(
            'name'    => 'twitter:card',
            'content' => 'summary_large_image'
        );
        $meta_tags[] = array(
            'name'    => 'twitter:image:src',
            'content' => $attachment[0]
        );
        $meta_tags[] = array(
            'name'    => 'twitter:image:width',
            'content' => $attachment[1]
        );
        $meta_tags[] = array(
            'name'    => 'twitter:image:width',
            'content' => $attachment[2]
        );
      } else {
        $meta_tags[] = array(
            'name'    => 'twitter:card',
            'content' => 'summary'
        );
      }

      $twitter_profile = $this->setting_group->get_option( 'social-twitter' );
      $explode         = (array) explode( '/', $twitter_profile );
      $profile         = (string) end( $explode );
      if ( !empty( $profile ) && $profile != '#' ) {
        $meta_tags[] = array(
            'name'    => 'twitter:site',
            'content' => '@' . $profile
        );
      }
    } else {
      $meta_tags[] = array(
          'name'    => 'twitter:card',
          'content' => 'summary'
      );
    }

    $meta_tags = apply_filters( 'twitter_card_tags', $meta_tags );

    echo "\n<!-- Twitter cards -->\n";
    foreach ( $meta_tags as $attributes ) {
      echo Html::tag( 'meta', false, $attributes );
    }
  }

  /**
   * Add Twitter cards meta tags to header
   *
   * @since 0.1.0
   */
  public function facebook_tags() {
    // If is Yoast active do nothing;
    if ( defined( 'WPSEO_VERSION' ) ) {
      return;
    }

    $meta_tags = array();

    $facebook_admins = $this->setting_group->get_option( 'facebook-admins', null );
    $fb_explode      = (array) explode( ',', $facebook_admins );
    foreach ( $fb_explode as $admin ) {
      $meta_tags[] = array(
          'property' => 'fb:admins',
          'content'  => $admin
      );
    }

    $facebook_app_id = $this->setting_group->get_option( 'facebook-app-id', false );
    if ( $facebook_app_id ) {
      $meta_tags[] = array(
          'property' => 'fb:app_id',
          'content'  => $facebook_app_id
      );
    }

    echo "\n<!-- Facebook -->\n";
    foreach ( $meta_tags as $attributes ) {
      echo Html::tag( 'meta', false, $attributes );
    }
  }

}
