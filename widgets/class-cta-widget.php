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

  protected function register_controls()
  {

    $this->start_controls_section(
      'content_section',
      [
        'label' => __('Contenu', 'lm-widgets'),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => __('Titre', 'lm-widgets'),
        'description' => __('Le titre du CTA', 'lm-widgets'),
        'placeholder' => __('Entrez le titre du CTA', 'lm-widgets'),
        'label_block' => true,
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Titre du CTA', 'lm-widgets'),
        'dynamic' => ['active' => true],
        'ai' => ['active' => false],
      ]
    );

    $this->add_control(
      'show_title',
      [
        'label' => esc_html__('Afficher le titre', 'textdomain'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Oui', 'textdomain'),
        'label_off' => esc_html__('Non', 'textdomain'),
        'separator' => 'after',
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'description',
      [
        'label' => esc_html__('Description', 'textdomain'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => esc_html__('Default description', 'textdomain'),
        'separator' => 'after',
        'placeholder' => esc_html__('Type your description here', 'textdomain'),
      ]
    );

    $this->add_control(
      'icon',
      [
        'label' => esc_html__('Icon', 'textdomain'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
          'value' => 'fas fa-circle',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'circle',
            'dot-circle',
            'square-full',
          ],
          'fa-regular' => [
            'circle',
            'dot-circle',
            'square-full',
          ],
        ],
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'style_section',
      [
        'label' => __('Couleurs', 'lm-widgets'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'text_color',
      [
        'label' => esc_html__('Text Color', 'textdomain'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .lm-widget-cta-title' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'icon_color',
      [
        'label' => esc_html__('Couleur de l\'icône', 'textdomain'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .lm-widget-cta-icon' => 'fill: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'style_section',
      [
        'label' => __('Espacements', 'lm-widgets'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    // Version responsive du champ (alternative : ajouter 'responsive' => true dans les arguments)
    $this->add_responsive_control(
      'text_size',
      [
        'label' => esc_html__('espacement interne', 'textdomain'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1000,
            'step' => 5,
          ],
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'default' => [
          'unit' => '%',
          'size' => 50,
        ],
        'selectors' => [
          '{{WRAPPER}} .lm-widget-cta' => 'padding: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    // Debug pour voir les settings
    // ini_set('xdebug.var_display_max_depth', 5);
    // ini_set('xdebug.var_display_max_children', 256);
    // ini_set('xdebug.var_display_max_data', 1024 * 16);

    // var_dump($settings);
    // die();

    require_once LM_WIDGETS_PLUGIN_DIR . 'templates/template-cta-widget.php';
  }

  public function get_style_depends(): array
  {
    return ['lm-widgets-cta'];
  }
}
