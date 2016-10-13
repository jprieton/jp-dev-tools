<?php

namespace JPDevTools\Core\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Helpers\HtmlBuilder as Html;

/**
 * SettingsImporter class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SettingsImporter {

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    
  }

  /**
   * Output header html.
   *
   * @since   0.1.0
   */
  public function header() {
    echo Html::open_tag( 'div.wrap' ) . Html::tag( 'h2', __( 'Import Settings', JPDEVTOOLS_TEXTDOMAIN ) );
  }

  /**
   * Output footer html.
   *
   * @since   0.1.0
   */
  public function footer() {
    echo Html::close_tag( 'div' );
  }

  public function greet() {
    $action = 'admin.php?import=jpdevtools_settings_json&step=1';
    $bytes  = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
    $size   = size_format( $bytes );
    ?>
    <div><?php echo Html::a( admin_url( 'admin-ajax.php?action=jpdevtools_export_settings_json' ), __( 'Download settings file', JPDEVTOOLS_TEXTDOMAIN ) ) ?></div>
    <form enctype="multipart/form-data" id="import-upload-form" method="post" action="<?php echo esc_attr( wp_nonce_url( $action, 'import-upload' ) ); ?>">
      <table class="form-table">
        <tbody>
          <tr>
            <th>
              <label for="upload"><?php _e( 'Choose a file from your computer:', JPDEVTOOLS_TEXTDOMAIN ); ?></label>
            </th>
            <td>
              <input type="file" id="upload" name="import" size="25" />
              <input type="hidden" name="action" value="save" />
              <input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>" />
              <small><?php printf( __( 'Maximum size: %s', JPDEVTOOLS_TEXTDOMAIN ), $size ); ?></small>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="submit">
        <input type="submit" class="button" value="<?php esc_attr_e( 'Upload file and import', JPDEVTOOLS_TEXTDOMAIN ); ?>" />
      </p>
    </form>
    <?php
  }

  public function dispatch() {
    $this->header();
    $step = (int) filter_input( INPUT_GET, 'step', FILTER_SANITIZE_NUMBER_INT );

    switch ($step) {
      case 1:
        check_admin_referer( 'import-upload' );
        if ( $this->handle_upload() ) {
          if ( $this->id ) {
            $file = ( $this->id ) ? get_attached_file( $this->id ) : ABSPATH . $this->file_url;
          }
          $this->import( $file, $this->id );
        }
        break;

      case 0:
      default:
        $this->greet();
        break;
    }


    $this->footer();
  }

  public function import( $file, $id ) {
    if ( !is_file( $file ) ) {
      $this->import_error( __( 'The file does not exist, please try again.', JPDEVTOOLS_TEXDOMAIN ) );
    }

    $content = file_get_contents( $file );
    if ( $content === false ) {
      $this->import_error( __( 'Error on read file, please try again.', JPDEVTOOLS_TEXDOMAIN ) );
    }

    $settings = json_decode( $content );
    if ( !$settings ) {
      $this->import_error( __( 'JSON file error, please try again.', JPDEVTOOLS_TEXDOMAIN ) );
    }

    update_option( 'jpdevtools-settings', (array) $settings, false );
    wp_delete_attachment( $id, true );

    echo '<p>' . __( 'All done!', JPDEVTOOLS_TEXDOMAIN ) . '</p>';
    do_action( 'import_end' );
  }

  /**
   * Handles the JSON upload and initial parsing of the file to prepare for.
   *
   * @return bool False if error uploading or invalid file, true otherwise
   */
  public function handle_upload() {
    if ( empty( $_POST['file_url'] ) ) {

      $file = wp_import_handle_upload();

      if ( isset( $file['error'] ) ) {
        $this->import_error( $file['error'] );
      }

      $this->id = absint( $file['id'] );
    } elseif ( file_exists( ABSPATH . $_POST['file_url'] ) ) {
      $this->file_url = esc_attr( $_POST['file_url'] );
    } else {
      $this->import_error();
    }

    return true;
  }

  /**
   * Show import error and quit.
   * @param string $message
   */
  private function import_error( $message = '' ) {
    echo '<p><strong>' . __( 'Sorry, there has been an error.', JPDEVTOOLS_TEXTDOMAIN ) . '</strong><br />';
    if ( $message ) {
      echo esc_html( $message );
    }
    echo '</p>';
    $this->footer();
    die();
  }

}
