<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- FLOATING SIDEBAR -->
<div class="sticky-float">
  <a href="#enquire" class="sticky-admit highlight-admit">Admission open 2026, 2027</a>
  <a href="tel:<?php echo esc_attr(get_theme_mod('scgi_phone', '+919947915916')); ?>" class="sfi ph"><i class="fas fa-phone"></i></a>
  <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('scgi_whatsapp', '919769002277')); ?>" class="sfi wa" target="_blank"><i class="fab fa-whatsapp"></i></a>
  <a href="mailto:<?php echo esc_attr(get_theme_mod('scgi_email', 'info@scgi.in')); ?>" class="sfi em"><i class="fas fa-envelope"></i></a>
</div>

<!-- TOP BAR -->
<div class="top-bar">
  <div class="container wrap">
    <div class="tb-left">
      <a href="tel:<?php echo esc_attr(get_theme_mod('scgi_phone', '+919947915916')); ?>"><i class="fas fa-phone-alt"></i><?php echo esc_html(get_theme_mod('scgi_phone_display', '+91 99479 15916 / 97690 02277')); ?></a>
      <span class="tb-divider">|</span>
      <a href="mailto:<?php echo esc_attr(get_theme_mod('scgi_email', 'info@scgi.in')); ?>"><i class="fas fa-envelope"></i><?php echo esc_html(get_theme_mod('scgi_email', 'info@scgi.in')); ?></a>
    </div>
    <div class="tb-right">
      <span><i class="fas fa-map-marker-alt"></i><?php echo esc_html(get_theme_mod('scgi_address', 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Dodda Hasala Gram Panchayath, Kolar, Karnataka – 563102')); ?></span>
      <span class="tb-divider">|</span>
      <a href="#"><i class="fas fa-award"></i>RGUHS Affiliated</a>
      <span class="tb-divider">|</span>
      <a href="#"><i class="fas fa-star"></i>Govt. Recognised</a>
    <a href="#enquire" class="tb-gold-btn">Enquire Now</a></div>
  </div>
</div>

<!-- HEADER -->
<header id="hdr">
  <div class="container">
    <div class="nav-wrap">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link">
        <?php 
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        if ( has_custom_logo() ) {
            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
        } else {
            echo '<img src="' . get_template_directory_uri() . '/SCGI-Logo.png" alt="SCGI Logo">';
        }
        ?>
      </a>
      <nav>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_id'        => 'navMenu',
            'fallback_cb'    => false,
            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ) );
        ?>
      </nav>
      <div style="display:flex;align-items:center;gap:12px">
        <div class="hamburger" id="hbg"><span></span><span></span><span></span></div>
      </div>
    </div>
  </div>
</header>
