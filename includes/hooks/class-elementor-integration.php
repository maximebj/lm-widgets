<?php

/**
 * Intégration avec Elementor
 *
 * @package LM_Widgets
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Classe d'intégration avec Elementor
 */
class LM_Widgets_Elementor_Integration
{

  /**
   * Constructeur
   */
  public function __construct()
  {
    add_action('elementor/elements/categories_registered', [$this, 'register_category'], 1);
    add_action('elementor/elements/categories_registered', [$this, 'reorder_categories'], 999);
    add_action('elementor/widgets/register', [$this, 'register_widgets']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
  }

  /**
   * Enregistre la catégorie "La Marketerie" dans Elementor
   *
   * @param \Elementor\Elements_Manager $elements_manager Gestionnaire d'éléments Elementor.
   */
  public function register_category($elements_manager)
  {
    $elements_manager->add_category(
      'la-marketerie',
      [
        'title' => __('La Marketerie', 'lm-widgets'),
        'icon'  => 'fa fa-plug',
      ]
    );
  }

  /**
   * Réorganise les catégories pour placer "La Marketerie" en premier
   *
   * @param \Elementor\Elements_Manager $elements_manager Gestionnaire d'éléments Elementor.
   */
  public function reorder_categories($elements_manager)
  {
    $categories = $elements_manager->get_categories();

    if (isset($categories['la-marketerie'])) {
      $la_marketerie = $categories['la-marketerie'];
      unset($categories['la-marketerie']);

      // Réorganiser : La Marketerie en premier, puis les autres
      $reordered = ['la-marketerie' => $la_marketerie] + $categories;

      // Utiliser la réflexion pour modifier l'ordre des catégories
      $reflection = new \ReflectionClass($elements_manager);
      $property = $reflection->getProperty('categories');
      $property->setValue($elements_manager, $reordered);
    }
  }

  /**
   * Enregistre les widgets actifs
   *
   * @param \Elementor\Widgets_Manager $widgets_manager Gestionnaire de widgets Elementor.
   */
  public function register_widgets($widgets_manager)
  {
    $active_widgets = LM_Widgets_Auto_Registration::get_active_widgets();

    foreach ($active_widgets as $widget_id => $widget_data) {
      // Chargement du fichier du widget
      $widget_file = LM_WIDGETS_PLUGIN_DIR . $widget_data['file'];
      if (file_exists($widget_file)) {
        require_once $widget_file;

        // Vérification que la classe existe
        if (class_exists($widget_data['class'])) {
          $widgets_manager->register(new $widget_data['class']());
        }
      }
    }
  }

  /**
   * Déclare automatiquement les styles des widgets activés
   */
  public function enqueue_styles()
  {
    $active_widgets = LM_Widgets_Auto_Registration::get_active_widgets();

    foreach ($active_widgets as $widget_id => $widget_data) {
      wp_register_style($widget_data['name'], LM_WIDGETS_PLUGIN_URL . 'includes/widgets/' . $widget_data['name'] .  '/style.css', [], LM_WIDGETS_VERSION);
    }
  }
}
