<?php

/**
 * Widget Elementor Exemple 2
 *
 * @package LM_Widgets
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Widget Elementor Exemple 2
 */
class LM_Widgets_Example_Widget_2 extends \Elementor\Widget_Base
{

  /**
   * Récupère le nom du widget
   *
   * @return string Nom du widget
   */
  public function get_name()
  {
    return 'lm_example_widget_2';
  }

  /**
   * Récupère le titre du widget
   *
   * @return string Titre du widget
   */
  public function get_title()
  {
    return __('Widget Exemple 2', 'lm-widgets');
  }

  /**
   * Récupère l'icône du widget
   *
   * @return string Icône du widget
   */
  public function get_icon()
  {
    return 'eicon-button';
  }

  /**
   * Récupère les catégories du widget
   *
   * @return array Catégories du widget
   */
  public function get_categories()
  {
    return ['la-marketerie'];
  }

  /**
   * Récupère les mots-clés du widget
   *
   * @return array Mots-clés du widget
   */
  public function get_keywords()
  {
    return ['exemple', 'bouton', 'la marketerie'];
  }

  /**
   * Enregistre les contrôles du widget
   */
  protected function register_controls()
  {
    // Section Contenu
    $this->start_controls_section(
      'content_section',
      [
        'label' => __('Contenu', 'lm-widgets'),
        'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'button_text',
      [
        'label'       => __('Texte du bouton', 'lm-widgets'),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => __('Cliquez ici', 'lm-widgets'),
        'placeholder' => __('Entrez le texte du bouton', 'lm-widgets'),
      ]
    );

    $this->add_control(
      'button_link',
      [
        'label'       => __('Lien', 'lm-widgets'),
        'type'        => \Elementor\Controls_Manager::URL,
        'placeholder' => __('https://votre-lien.com', 'lm-widgets'),
        'show_external' => true,
        'default'     => [
          'url'         => '',
          'is_external' => false,
          'nofollow'    => false,
        ],
      ]
    );

    $this->end_controls_section();

    // Section Style
    $this->start_controls_section(
      'style_section',
      [
        'label' => __('Style', 'lm-widgets'),
        'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'button_color',
      [
        'label'     => __('Couleur du bouton', 'lm-widgets'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'default'   => '#0073aa',
        'selectors' => [
          '{{WRAPPER}} .lm-example-widget-2-button' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_text_color',
      [
        'label'     => __('Couleur du texte', 'lm-widgets'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'default'   => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .lm-example-widget-2-button' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name'     => 'button_typography',
        'label'    => __('Typographie', 'lm-widgets'),
        'selector' => '{{WRAPPER}} .lm-example-widget-2-button',
      ]
    );

    $this->add_responsive_control(
      'button_padding',
      [
        'label'      => __('Espacement', 'lm-widgets'),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors'  => [
          '{{WRAPPER}} .lm-example-widget-2-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default'    => [
          'top'    => '12',
          'right'  => '24',
          'bottom' => '12',
          'left'   => '24',
        ],
      ]
    );

    $this->add_responsive_control(
      'button_border_radius',
      [
        'label'      => __('Rayon des bordures', 'lm-widgets'),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors'  => [
          '{{WRAPPER}} .lm-example-widget-2-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default'    => [
          'top'    => '4',
          'right'  => '4',
          'bottom' => '4',
          'left'   => '4',
        ],
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Affiche le widget
   */
  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if (empty($settings['button_text'])) {
      return;
    }

    $target = $settings['button_link']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $settings['button_link']['nofollow'] ? ' rel="nofollow"' : '';
    $url = ! empty($settings['button_link']['url']) ? $settings['button_link']['url'] : '#';

    require_once LM_WIDGETS_PLUGIN_DIR . 'templates/template-example-widget-2.php';
  }


  public function get_style_depends(): array
  {
    return ['example-widget-2'];
  }

  /**
   * Affiche le widget en mode édition (live preview)
   */
  protected function _content_template()
  {
?>
    <div class="lm-example-widget-2">
      <# if ( settings.button_text ) { #>
        <a href="{{{ settings.button_link.url || '#' }}}" class="lm-example-widget-2-button"
          <# if ( settings.button_link.is_external ) { #>target="_blank"<# } #>
            <# if ( settings.button_link.nofollow ) { #>rel="nofollow"<# } #>
                >
                {{{ settings.button_text }}}
        </a>
        <# } #>
    </div>
<?php
  }
}
