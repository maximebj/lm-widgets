<?php

/**
 * Auto-déclaration des widgets à partir du dossier includes/widgets
 *
 * @package LM_Widgets
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Classe d'auto-déclaration des widgets
 */
class LM_Widgets_Plugin_Activation
{
  public function __construct()
  {
    register_activation_hook(LM_WIDGETS_PLUGIN_FILE, [$this, 'activate']);
    register_deactivation_hook(LM_WIDGETS_PLUGIN_FILE, [$this, 'deactivate']);
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
}
