<?php

/**
 * Classe principale du plugin
 *
 * @package LM_Widgets
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Classe principale du plugin La Marketerie - Widgets
 */
class LM_Widgets_Plugin
{

  /**
   * Instance unique du plugin (Singleton)
   *
   * @var LM_Widgets_Plugin
   */
  private static $instance = null;

  /**
   * Instance de l'intégration Elementor
   *
   * @var LM_Widgets_Elementor_Integration
   */
  public $elementor_integration;

  /**
   * Instance de la page de réglages
   *
   * @var LM_Widgets_Settings_Page
   */
  public $settings_page;

  /**
   * Récupère l'instance unique du plugin
   *
   * @return LM_Widgets_Plugin
   */
  public static function instance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Constructeur privé (Singleton)
   */
  private function __construct()
  {
    $this->init_hooks();
    $this->load_dependencies();
  }

  /**
   * Initialise les hooks WordPress
   */
  private function init_hooks()
  {
    // Activation du plugin
    register_activation_hook(LM_WIDGETS_PLUGIN_FILE, [$this, 'activate']);

    // Désactivation du plugin
    register_deactivation_hook(LM_WIDGETS_PLUGIN_FILE, [$this, 'deactivate']);

    // Initialisation après que WordPress soit chargé
    add_action('init', [$this, 'init']);

    // Ajout du lien "Réglages" dans la liste des plugins
    add_filter('plugin_action_links_' . plugin_basename(LM_WIDGETS_PLUGIN_FILE), [$this, 'add_settings_link']);
  }

  /**
   * Charge les dépendances
   */
  private function load_dependencies()
  {
    require_once LM_WIDGETS_PLUGIN_DIR . 'includes/helpers/class-widget-autoregistration.php';
    require_once LM_WIDGETS_PLUGIN_DIR . 'includes/hooks/class-elementor-integration.php';
    require_once LM_WIDGETS_PLUGIN_DIR . 'includes/settings/class-settings-page.php';
  }

  /**
   * Initialisation du plugin
   */
  public function init()
  {
    // Initialisation de la page de réglages
    $this->settings_page = new LM_Widgets_Settings_Page();

    // Initialisation de l'intégration Elementor
    $this->elementor_integration = new LM_Widgets_Elementor_Integration();
  }

  /**
   * Activation du plugin
   */
  public function activate()
  {
    // Initialisation des options par défaut si elles n'existent pas
    $available_widgets = LM_Widgets_Auto_Registration::get_available_widgets();
    $default_settings = [];

    // Activer tous les widgets disponibles par défaut
    foreach ($available_widgets as $widget_id => $widget_data) {
      $default_settings[$widget_id] = true;
    }

    if (! get_option('lm_widgets_settings')) {
      add_option('lm_widgets_settings', $default_settings);
    }

    // Flush rewrite rules si nécessaire
    flush_rewrite_rules();
  }

  /**
   * Désactivation du plugin
   */
  public function deactivate()
  {
    // Flush rewrite rules si nécessaire
    flush_rewrite_rules();
  }

  /**
   * Ajoute le lien "Réglages" dans la liste des plugins
   *
   * @param array $links Liens existants.
   * @return array Liens modifiés avec le lien "Réglages"
   */
  public function add_settings_link($links)
  {
    $settings_link = sprintf(
      '<a href="%s">%s</a>',
      esc_url(admin_url('admin.php?page=lm-widgets-settings')),
      esc_html__('Réglages', 'lm-widgets')
    );
    array_unshift($links, $settings_link);
    return $links;
  }
}
