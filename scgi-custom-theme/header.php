<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
    /* === DROPDOWN NAV FIX === */
    nav ul li{position:relative!important}
    nav ul li ul.sub-menu{display:none!important;position:absolute!important;top:100%!important;left:0!important;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 8px 32px rgba(13,36,99,.18);padding:8px 0;z-index:99999!important;list-style:none!important;margin:0!important;border-top:3px solid #c9a227;flex-direction:column!important}
    nav ul li:hover>ul.sub-menu{display:block!important}
    nav ul li ul.sub-menu li{width:100%!important;display:block!important;float:none!important}
    nav ul li ul.sub-menu li a{display:block!important;padding:10px 20px!important;font-size:.85rem!important;font-weight:500!important;color:#0d2463!important;border-radius:0!important;white-space:nowrap!important;background:transparent!important}
    nav ul li ul.sub-menu li a:hover{background:rgba(26,58,140,.06)!important;color:#c9a227!important}
    nav ul li ul.sub-menu li a::after{display:none!important}
    </style>

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
      <span><i class="fas fa-map-marker-alt"></i><?php echo esc_html(get_theme_mod('scgi_short_address', 'Kolar, Karnataka – 563102')); ?></span>
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
