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
abstract class LM_Widgets_Auto_Registration
{

  /**
   * Récupère les widgets disponibles
   *
   * @return array Liste des widgets disponibles
   */
  public static function get_available_widgets()
  {
    $widgets = [];
    $widgets_dir = LM_WIDGETS_PLUGIN_DIR . 'widgets/';

    // Vérifier que le dossier existe
    if (! is_dir($widgets_dir)) {
      return new WP_Error('widgets_directory_missing', 'Le dossier des widgets n\'existe pas : ' . $widgets_dir);
    }

    // Scanner le dossier des widgets
    $directories = array_filter(glob($widgets_dir . '*'), 'is_dir');

    foreach ($directories as $widget_dir) {
      $widget_name = basename($widget_dir);
      $widget_file = $widget_dir . '/class-widget.php';

      // Vérifier que le fichier class-widget.php existe
      if (! file_exists($widget_file)) {
        continue;
      }

      // Lire le fichier pour extraire le nom de la classe
      $file_content = file_get_contents($widget_file);
      if (preg_match('/class\s+([a-zA-Z0-9_]+)\s+extends\s+\\\\?Elementor\\\\Widget_Base/', $file_content, $matches)) {
        $class_name = $matches[1];

        // Charger le fichier pour pouvoir utiliser la classe
        if (! class_exists($class_name)) {
          require_once $widget_file;
        }

        // Obtenir le titre et la description depuis la classe
        $title = '';
        $description = '';

        if (class_exists($class_name)) {
          try {
            $reflection = new ReflectionClass($class_name);
            if ($reflection->isSubclassOf('\Elementor\Widget_Base')) {
              // Créer une instance temporaire pour obtenir le titre
              $widget_instance = new $class_name();
              if (method_exists($widget_instance, 'get_title')) {
                $title = $widget_instance->get_title();
              }
              if (method_exists($widget_instance, 'get_description')) {
                $description = $widget_instance->get_description();
              }
            }
          } catch (Exception $e) {
            // En cas d'erreur, utiliser des valeurs par défaut
            $title = ucwords(str_replace(['-', '_'], ' ', $widget_name));
          }
        }

        // Générer un ID unique pour le widget basé sur le nom de la classe
        $widget_id = strtolower($class_name);
        if (empty($widget_id)) {
          $widget_id = str_replace('-', '_', $widget_name);
        }

        $widgets[$widget_id] = [
          'name'        => $widget_name,
          'title'       => $title ?: ucwords(str_replace(['-', '_'], ' ', $widget_name)),
          'description' => $description ?: '',
          'class'       => $class_name,
          'file'        => 'widgets/' . $widget_name . '/class-widget.php',
        ];
      }
    }

    return $widgets;
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
