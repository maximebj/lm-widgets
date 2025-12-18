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

    // Enregistrement des styles
    add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
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
      'lm_widget_cta' => [
        'name'        => 'lm_widget_cta',
        'title'       => __('CTA', 'lm-widgets'),
        'description' => __('Un bloc d’appel à l’action', 'lm-widgets'),
        'class'       => 'LM_Widgets_CTA',
        'file'        => 'widgets/class-cta-widget.php',
        'style'       => 'lm-widgets-cta',
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

  /**
   * Déclare automatiquement les styles des widgets activés
   */
  public function enqueue_styles()
  {
    // Récupérer les widgets activés
    $active_widgets = self::get_active_widgets();

    foreach ($active_widgets as $widget_id => $widget_data) {
      if (isset($widget_data['style'])) {
        wp_register_style($widget_data['style'], LM_WIDGETS_PLUGIN_URL . 'assets/css/' . $widget_data['style'] . '.css', [], LM_WIDGETS_VERSION);
      }
    }
  }
}
