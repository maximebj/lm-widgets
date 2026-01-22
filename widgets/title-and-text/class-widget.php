<?php

/**
 * Widget Title and Text
 *
 * @package LM_Widgets
 */

if (! defined('ABSPATH')) {
  exit;
}

class Widget_Title_And_Text extends \Elementor\Widget_Base
{

  /**
   * Récupère le nom du widget
   *
   * @return string Nom du widget
   */
  public function get_name()
  {
    return 'title-and-text';
  }

  /**
   * Récupère le titre du widget
   *
   * @return string Titre du widget
   */
  public function get_title()
  {
    return __('Widget Exemple 1', 'lm-widgets');
  }

  /**
   * Récupère la description du widget
   *
   * @return string Description du widget
   */
  public function get_description()
  {
    return __('Widget pour afficher un titre et une description', 'lm-widgets');
  }

  /**
   * Récupère l'icône du widget
   *
   * @return string Icône du widget
   */
  public function get_icon()
  {
    return 'eicon-code';
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
    return ['exemple', 'demo', 'la marketerie'];
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
      'title',
      [
        'label'       => __('Titre', 'lm-widgets'),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => __('Titre d\'exemple', 'lm-widgets'),
        'placeholder' => __('Entrez votre titre', 'lm-widgets'),
      ]
    );

    $this->add_control(
      'description',
      [
        'label'       => __('Description', 'lm-widgets'),
        'type'        => \Elementor\Controls_Manager::TEXTAREA,
        'default'     => __('Ceci est un widget d\'exemple créé par La Marketerie.', 'lm-widgets'),
        'placeholder' => __('Entrez votre description', 'lm-widgets'),
        'rows'        => 5,
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
      'title_color',
      [
        'label'     => __('Couleur du titre', 'lm-widgets'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'default'   => '#333333',
        'selectors' => [
          '{{WRAPPER}} .lm-example-widget-1-title' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name'     => 'title_typography',
        'label'    => __('Typographie du titre', 'lm-widgets'),
        'selector' => '{{WRAPPER}} .lm-example-widget-1-title',
      ]
    );

    $this->add_control(
      'description_color',
      [
        'label'     => __('Couleur de la description', 'lm-widgets'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'default'   => '#666666',
        'selectors' => [
          '{{WRAPPER}} .lm-example-widget-1-description' => 'color: {{VALUE}};',
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

    require_once 'template.php';
  }

  /**
   * Déclare les styles du widget
   *
   * @return array Styles du widget
   */
  public function get_style_depends(): array
  {
    return [$this->get_name()];
  }

  /**
   * Affiche le widget en mode édition (live preview)
   */
  protected function _content_template()
  {
?>
    <div class="lm-example-widget-1">
      <# if ( settings.title ) { #>
        <h3 class="lm-example-widget-1-title">{{{ settings.title }}}</h3>
        <# } #>

          <# if ( settings.description ) { #>
            <div class="lm-example-widget-1-description">
              {{{ settings.description.replace(/\n/g, '<br>') }}}
            </div>
            <# } #>
    </div>
<?php
  }
}
