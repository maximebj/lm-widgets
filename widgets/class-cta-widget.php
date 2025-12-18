<?php

/**
 * Widget Elementor Exemple 1
 *
 * @package LM_Widgets
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Widget Elementor Exemple 1
 */
class LM_Widgets_CTA extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'lm_widget_cta';
  }

  public function get_title()
  {
    return __('CTA', 'lm-widgets');
  }

  public function get_icon()
  {
    return 'eicon-call-to-action';
  }

  public function get_categories()
  {
    return ['la-marketerie'];
  }

  public function get_keywords()
  {
    return ['cta', 'call to action', 'appel à l\'action', 'la marketerie'];
  }

  protected function register_controls() {}

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    require_once LM_WIDGETS_PLUGIN_DIR . 'templates/template-cta-widget.php';
  }

  public function get_style_depends(): array
  {
    return ['lm-widgets-cta'];
  }
}
