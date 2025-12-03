<?php

/**
 * Plugin Name: La Marketerie - Widgets
 * Plugin URI: https://lamarketerie.fr
 * Description: Les widgets Elementor sur mesure de La Marketerie.
 * Version: 1.0.0
 * Author: La Marketerie
 * Author URI: https://lamarketerie.fr
 * Text Domain: lm-widgets
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Elementor tested up to: 3.0.0
 * Elementor requires at least: 3.0.0
 */

// Si ce fichier est appelé directement, on sort.
if (! defined('ABSPATH')) {
  exit;
}

// Définition des constantes du plugin
define('LM_WIDGETS_VERSION', '1.0.0');
define('LM_WIDGETS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LM_WIDGETS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LM_WIDGETS_PLUGIN_FILE', __FILE__);

/**
 * Vérification de la présence d'Elementor
 */
function lm_widgets_check_elementor()
{
  if (! did_action('elementor/loaded')) {
    add_action('admin_notices', 'lm_widgets_elementor_missing_notice');
    return false;
  }
  return true;
}

/**
 * Notice d'erreur si Elementor n'est pas installé
 */
function lm_widgets_elementor_missing_notice()
{
  $message = sprintf(
    /* translators: 1: Plugin Name 2: Elementor */
    esc_html__('"%1$s" nécessite "%2$s" pour fonctionner. Veuillez installer et activer Elementor.', 'lm-widgets'),
    '<strong>' . esc_html__('La Marketerie - Widgets', 'lm-widgets') . '</strong>',
    '<strong>' . esc_html__('Elementor', 'lm-widgets') . '</strong>'
  );
  printf('<div class="notice notice-error"><p>%1$s</p></div>', $message);
}

/**
 * Initialisation du plugin
 */
function lm_widgets_init()
{
  // Vérification d'Elementor
  if (! lm_widgets_check_elementor()) {
    return;
  }

  // Chargement des fichiers nécessaires
  require_once LM_WIDGETS_PLUGIN_DIR . 'includes/class-plugin.php';

  // Initialisation du plugin
  LM_Widgets_Plugin::instance();
}

// Hook d'initialisation
add_action('plugins_loaded', 'lm_widgets_init');
