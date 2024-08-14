<?php
    $main_frame_classes  = 'tiles' != $layout ? 'aux-frame-mask-plain '  : '';
    $main_frame_classes .= 'grid'  == $layout ? 'aux-frame-ratio ' : '';

    $inner_frame_classes  = 'aux-frame-ratio-inner aux-frame-darken ';
    $inner_frame_classes .= $add_lightbox ? 'aux-lightbox-btn ': '';

    $hover_scale_class  = 'grid' == $layout ? 'aux-hover-scale-circle-plus2' : 'aux-hover-scale-circle-plus';
?>
    <figure class="gallery-item aux-hover-active <?php echo esc_attr( $isotope_item_classes . ' ' . $item_classes ); ?>">
            <div class="<?php echo esc_attr( $main_frame_classes ); ?>">
                <a href="<?php echo esc_url( $attachment_url ); ?>" class="<?php echo esc_attr( $inner_frame_classes ); ?>" <?php echo $lightbox_attrs; // already escaped ?>>
            <?php if ( $add_lightbox ) { ?>
                    <div class="<?php echo esc_attr( $hover_scale_class ); ?>">
                        <span class="aux-symbol-plus"></span>
                        <span class="aux-symbol-circle"></span>
                    </div>
            <?php } ?>
            <?php echo $attachment_media; ?>
                </a>
            </div>
            <?php if ( $add_caption ) { ?>
            <figcaption class="wp-caption-text gallery-caption">
                <?php echo $attachment_caption ?>
            </figcaption>
            <?php } ?>
    </figure>
