<?php
/**
 * Template Part: Breadcrumb Bar
 * Usage: get_template_part('template-parts/breadcrumb', null, $args)
 *
 * $args:
 *   'items' => array of ['label' => '', 'url' => ''] — last item has no url
 */
$items = $args['items'] ?? array();
if ( empty( $items ) ) return;
?>
<div class="breadcrumb-bar">
    <div class="container">
        <div class="breadcrumb">
            <?php foreach ( $items as $i => $item ) :
                $is_last = ( $i === count( $items ) - 1 );
            ?>
                <?php if ( $i > 0 ) : ?><i class="fas fa-circle"></i><?php endif; ?>
                <?php if ( ! $is_last && ! empty( $item['url'] ) ) : ?>
                    <a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
                <?php else : ?>
                    <span><?php echo esc_html( $item['label'] ); ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
