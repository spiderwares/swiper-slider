<div class="tnz_ss_slides_wrap">
    <ul class="tnz_ss_slides">
        <?php foreach( $images as $image ) : ?>
            <li>
                <img width="250" src="<?php echo wp_get_attachment_image_src( $image->ID, 'tnz_slideshow_thumbnail' )[0]; ?>" />
                <div class="tnz_slide_actions">
                    <a href="#" class="tnz_slide_move">
                        <span class="tooltip">Drag & Sort</span>
                        <i class="dashicons dashicons-move"></i>
                    </a>
                    <a href="#" class="tnz_slide_remove">
                        <span class="tooltip">Delete</span>
                        <i class="dashicons dashicons-trash"></i>
                    </a>
                </div>
                <input type="hidden" name="<?php echo $metaKey . "[]"; ?>" value="<?php echo $image->ID; ?>" />
            </li>
        <?php endforeach; ?>
    </ul>
    <div style="clear:both"></div>
    <?php wp_nonce_field( 'tnz_slideshow_metabox_data', 'tnz_slideshow_metabox_nonce' ); ?>
    <a href="#" class="button tnz_upload_slide">Add Slide</a>
</div>