<?php

/**
 * Page de réglages du plugin
 *
 * @package LM_Widgets
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Classe de la page de réglages
 */
class LM_Widgets_Settings_Page
{

  /**
   * Constructeur
   */
  public function __construct()
  {
    add_action('admin_menu', [$this, 'add_admin_menu']);
    add_action('admin_init', [$this, 'register_settings']);
  }

  /**
   * Ajoute le menu dans l'admin WordPress
   */
  public function add_admin_menu()
  {
    add_menu_page(
      __('La Marketerie - Widgets', 'lm-widgets'),
      __('La Marketerie', 'lm-widgets'),
      'manage_options',
      'lm-widgets-settings',
      [$this, 'render_settings_page'],
      'dashicons-performance',
      90
    );
  }

  /**
   * Enregistre les réglages
   */
  public function register_settings()
  {
    register_setting(
      'lm_widgets_settings_group',
      'lm_widgets_settings',
      [$this, 'sanitize_settings']
    );
  }

  /**
   * Nettoie les données des réglages
   *
   * @param array $input Données à nettoyer.
   * @return array Données nettoyées
   */
  public function sanitize_settings($input)
  {
    $available_widgets = LM_Widgets_Plugin::get_available_widgets();
    $sanitized = [];

    foreach ($available_widgets as $widget_id => $widget_data) {
      $sanitized[$widget_id] = isset($input[$widget_id]) ? (bool) $input[$widget_id] : false;
    }

    return $sanitized;
  }

  /**
   * Affiche la page de réglages
   */
  public function render_settings_page()
  {
    if (! current_user_can('manage_options')) {
      return;
    }

    // Sauvegarde des réglages
    if (isset($_POST['lm_widgets_save_settings']) && check_admin_referer('lm_widgets_save_settings')) {
      $settings = isset($_POST['lm_widgets_settings']) ? $_POST['lm_widgets_settings'] : [];
      $sanitized_settings = $this->sanitize_settings($settings);
      update_option('lm_widgets_settings', $sanitized_settings);
      echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Réglages sauvegardés avec succès.', 'lm-widgets') . '</p></div>';
    }

    $settings = get_option('lm_widgets_settings', []);
    $available_widgets = LM_Widgets_Plugin::get_available_widgets();
?>
    <div class="wrap">
      <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

      <form method="post" action="">
        <?php wp_nonce_field('lm_widgets_save_settings'); ?>

        <table class="form-table" role="presentation">
          <tbody>
            <tr>
              <th scope="row"><?php esc_html_e('Widgets disponibles', 'lm-widgets'); ?></th>
              <td>
                <fieldset>
                  <legend class="screen-reader-text">
                    <span><?php esc_html_e('Widgets disponibles', 'lm-widgets'); ?></span>
                  </legend>
                  <?php foreach ($available_widgets as $widget_id => $widget_data) : ?>
                    <label for="lm_widget_<?php echo esc_attr($widget_id); ?>">
                      <input
                        type="checkbox"
                        id="lm_widget_<?php echo esc_attr($widget_id); ?>"
                        name="lm_widgets_settings[<?php echo esc_attr($widget_id); ?>]"
                        value="1"
                        <?php checked(isset($settings[$widget_id]) && $settings[$widget_id]); ?>>
                      <strong><?php echo esc_html($widget_data['title']); ?></strong>
                      <?php if (! empty($widget_data['description'])) : ?>
                        <br>
                        <span class="description"><?php echo esc_html($widget_data['description']); ?></span>
                      <?php endif; ?>
                    </label>
                    <br><br>
                  <?php endforeach; ?>
                </fieldset>
              </td>
            </tr>
          </tbody>
        </table>

        <?php submit_button(__('Enregistrer les modifications', 'lm-widgets'), 'primary', 'lm_widgets_save_settings'); ?>
      </form>
    </div>
<?php
  }
}
