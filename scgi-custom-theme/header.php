<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
    /* === DROPDOWN NAV - Exact HTML Match === */
    nav ul li { position: relative !important; }

    /* Top-level: Courses chevron-down in the link */
    nav ul li.menu-item-has-children > a::after {
      font-family: "Font Awesome 6 Free" !important;
      font-weight: 900 !important;
      content: "\f078" !important; /* fa-chevron-down */
      font-size: 0.7em !important;
      margin-left: 4px !important;
      display: inline !important;
      position: static !important;
      width: auto !important; height: auto !important;
      border: none !important; background: none !important;
      transform: none !important;
    }

    /* The dropdown box - gold LEFT border, white bg, shadow */
    nav ul li ul.sub-menu {
      display: none !important;
      position: absolute !important;
      top: 100% !important;
      left: 0 !important;
      min-width: 260px !important;
      background: #fff !important;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
      z-index: 99999 !important;
      border-radius: 0 !important;
      border-left: 4px solid #c9a227 !important;
      padding: 10px 0 !important;
      list-style: none !important;
      margin: 0 !important;
      flex-direction: column !important;
    }
    nav ul li:hover > ul.sub-menu { display: block !important; }
    nav ul li ul.sub-menu li { display: block !important; float: none !important; width: 100% !important; position: relative !important; }
    nav ul li ul.sub-menu li a {
      color: #0d2463 !important;
      padding: 14px 24px !important;
      font-size: 0.95rem !important;
      font-weight: 500 !important;
      display: block !important;
      border-radius: 0 !important;
      transition: all 0.2s !important;
      background: transparent !important;
      white-space: nowrap !important;
    }
    nav ul li ul.sub-menu li a::after { display: none !important; }
    nav ul li ul.sub-menu li a:hover {
      background-color: #f8f9fc !important;
      color: #c9a227 !important;
      padding-left: 28px !important;
    }

    /* Chevron-right on submenu parent items */
    nav ul li ul.sub-menu li.menu-item-has-children > a::after {
      font-family: "Font Awesome 6 Free" !important;
      font-weight: 900 !important;
      content: "\f054" !important; /* fa-chevron-right */
      float: right !important;
      margin-top: 3px !important;
      font-size: 0.7em !important;
      opacity: 0.7 !important;
      display: inline !important;
      position: static !important;
      width: auto !important; height: auto !important;
      border: none !important; background: none !important;
      transform: none !important;
    }

    /* Nested sub-menu appears to the RIGHT, same left-gold-border style */
    nav ul li ul.sub-menu li ul.sub-menu {
      top: 0 !important;
      left: 100% !important;
      border-left: 4px solid #c9a227 !important;
      margin-top: 0 !important;
    }
    nav ul li ul.sub-menu li:hover > a {
      background-color: #f8f9fc !important;
      color: #c9a227 !important;
    }
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
