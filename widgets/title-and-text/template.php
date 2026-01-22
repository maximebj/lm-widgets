<div class="lm-example-widget-1">
  <?php if (! empty($settings['title'])) : ?>
    <h3 class="lm-example-widget-1-title"><?php echo esc_html($settings['title']); ?></h3>
  <?php endif; ?>

  <?php if (! empty($settings['description'])) : ?>
    <div class="lm-example-widget-1-description">
      <?php echo wp_kses_post(wpautop($settings['description'])); ?>
    </div>
  <?php endif; ?>
</div>