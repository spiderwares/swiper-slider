<div class="swiper <?php echo $slideshow_main_class; ?>" data-attr="<?php echo $slideshowAttr; ?>">
    <div class="swiper-wrapper">
        <?php foreach( $slides as $slide ) : ?>
            <div class="swiper-slide">
                <img src="<?php echo wp_get_attachment_image_url( $slide->ID, 'full' ); ?>" />
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-<?php echo $slideshow_ID; ?>-next"></div>
    <div class="swiper-<?php echo $slideshow_ID; ?>-prev"></div>
</div>