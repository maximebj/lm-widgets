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
  }

  /**
   * Charge les dépendances
   */
  private function load_dependencies()
  {
    require_once LM_WIDGETS_PLUGIN_DIR . 'includes/class-elementor-integration.php';
    require_once LM_WIDGETS_PLUGIN_DIR . 'includes/class-settings-page.php';
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
    $default_settings = [
      'example_widget_1' => true,
      'example_widget_2' => true,
    ];

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
   * Récupère les widgets disponibles
   *
   * @return array Liste des widgets disponibles
   */
  public static function get_available_widgets()
  {
    return [
      'example_widget_1' => [
        'name'        => 'example_widget_1',
        'title'       => __('Widget Exemple 1', 'lm-widgets'),
        'description' => __('Premier widget d\'exemple pour démonstration', 'lm-widgets'),
        'class'       => 'LM_Widgets_Example_Widget_1',
        'file'        => 'widgets/class-example-widget-1.php',
      ],
      'example_widget_2' => [
        'name'        => 'example_widget_2',
        'title'       => __('Widget Exemple 2', 'lm-widgets'),
        'description' => __('Deuxième widget d\'exemple pour démonstration', 'lm-widgets'),
        'class'       => 'LM_Widgets_Example_Widget_2',
        'file'        => 'widgets/class-example-widget-2.php',
      ],
    ];
  }

  /**
   * Récupère les widgets activés
   *
   * @return array Liste des widgets activés
   */
  public static function get_active_widgets()
  {
    $settings = get_option('lm_widgets_settings', []);
    $available_widgets = self::get_available_widgets();
    $active_widgets = [];

    foreach ($available_widgets as $widget_id => $widget_data) {
      if (isset($settings[$widget_id]) && $settings[$widget_id]) {
        $active_widgets[$widget_id] = $widget_data;
      }
    }

    return $active_widgets;
  }
}
