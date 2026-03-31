<?php
/**
 * Template Part: CTA Band
 * Usage: get_template_part('template-parts/cta-band')
 */
$cta_heading = get_theme_mod( 'scgi_cta_heading', 'Guiding You Towards a Bright Career' );
$cta_subtext = get_theme_mod( 'scgi_cta_subtext', 'Reach Out for Admissions, Queries & More' );
$cta_btn_text = get_theme_mod( 'scgi_cta_btn_text', 'Contact Us' );
$cta_btn_link = get_theme_mod( 'scgi_cta_btn_link', '' ) ?: home_url( '/contact' );
?>
<section class="banner-cta">
    <div class="container flex-cta">
        <div class="cta-text">
            <h3><?php echo esc_html( $cta_heading ); ?></h3>
            <p><?php echo esc_html( $cta_subtext ); ?></p>
        </div>
        <a href="<?php echo esc_url( $cta_btn_link ); ?>" class="btn-gold">
            <i class="fas fa-paper-plane"></i><?php echo esc_html( $cta_btn_text ); ?>
        </a>
    </div>
</section>
