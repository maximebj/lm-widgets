<div class="lm-widget-cta">

  <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true', 'class' => 'lm-widget-cta-icon']); ?>

  <?php if (! empty($settings['title']) && $settings['show_title'] === 'yes') : ?>
    <h2 class="lm-widget-cta-title"><?php echo $settings['title']; ?></h2>
  <?php endif; ?>

  <div class="lm-widget-cta-description"><?php echo $settings['description']; ?></div>
</div>