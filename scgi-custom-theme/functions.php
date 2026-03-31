<?php
/**
 * SCGI Custom Theme — functions.php
 * Production-ready. No ACF dependency. All content via Customizer + native metaboxes.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ═══════════════════════════════════════════════════
   1. THEME SETUP
═══════════════════════════════════════════════════ */
function scgi_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

    add_image_size( 'course-card',  640, 480, true );
    add_image_size( 'hero-banner', 1920, 900, true );
    add_image_size( 'logo-thumb',  200, 200, false );

    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Navigation', 'scgi-custom' ),
        'footer'  => esc_html__( 'Footer Courses Menu', 'scgi-custom' ),
    ) );
}
add_action( 'after_setup_theme', 'scgi_setup' );

/* ═══════════════════════════════════════════════════
   2. ENQUEUE ASSETS
═══════════════════════════════════════════════════ */
function scgi_scripts() {
    // Styles
    wp_enqueue_style( 'scgi-google-fonts',
        'https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&display=swap',
        array(), null );
    wp_enqueue_style( 'scgi-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(), '6.5.0' );
    wp_enqueue_style( 'scgi-main-style', get_stylesheet_uri(), array(), '2.0' );

    // Scripts
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'scgi-main-js',
        get_template_directory_uri() . '/js/main.js',
        array( 'jquery' ), '2.0', true );

    // Pass data to JS
    wp_localize_script( 'scgi-main-js', 'scgi_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'scgi_nonce' ),
        'home_url' => home_url( '/' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'scgi_scripts' );

/* ═══════════════════════════════════════════════════
   3. CUSTOM POST TYPES
═══════════════════════════════════════════════════ */

// Hero Sliders
function scgi_register_cpts() {

    register_post_type( 'scgi_slider', array(
        'labels'      => array( 'name' => 'Hero Sliders', 'singular_name' => 'Slider' ),
        'public'      => true,
        'has_archive' => false,
        'supports'    => array( 'title', 'thumbnail', 'page-attributes' ),
        'menu_icon'   => 'dashicons-images-alt2',
        'rewrite'     => array( 'slug' => 'slider' ),
        'show_in_rest' => true,
    ) );

    // Courses
    register_post_type( 'scgi_course', array(
        'labels'       => array(
            'name'               => 'Courses',
            'singular_name'      => 'Course',
            'add_new_item'       => 'Add New Course',
            'edit_item'          => 'Edit Course',
            'view_item'          => 'View Course',
            'search_items'       => 'Search Courses',
            'not_found'          => 'No courses found.',
            'not_found_in_trash' => 'No courses found in trash.',
        ),
        'public'       => true,
        'has_archive'  => true,
        'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'menu_icon'    => 'dashicons-welcome-learn-more',
        'rewrite'      => array( 'slug' => 'courses' ),
        'show_in_rest' => true,
    ) );

    // Course Category Taxonomy
    register_taxonomy( 'course_category', 'scgi_course', array(
        'label'        => 'Course Categories',
        'rewrite'      => array( 'slug' => 'course-category' ),
        'hierarchical' => true,
        'show_in_rest' => true,
    ) );

    // Logos / Accreditation
    register_post_type( 'scgi_logo', array(
        'labels'      => array( 'name' => 'Accreditation Logos', 'singular_name' => 'Logo' ),
        'public'      => true,
        'supports'    => array( 'title', 'thumbnail', 'page-attributes' ),
        'menu_icon'   => 'dashicons-awards',
        'show_in_rest' => true,
    ) );

    // Gallery
    register_post_type( 'scgi_gallery', array(
        'labels'      => array( 'name' => 'Gallery', 'singular_name' => 'Gallery Item' ),
        'public'      => true,
        'supports'    => array( 'title', 'thumbnail', 'page-attributes' ),
        'menu_icon'   => 'dashicons-format-image',
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'scgi_register_cpts' );

/* ═══════════════════════════════════════════════════
   4. META BOXES
═══════════════════════════════════════════════════ */

function scgi_add_meta_boxes() {
    // Slider
    add_meta_box( 'scgi_slider_details', 'Slider Content', 'scgi_slider_meta_html', 'scgi_slider', 'normal', 'high' );

    // Course — Main Details
    add_meta_box( 'scgi_course_details', 'Course Details',    'scgi_course_details_html',     'scgi_course', 'normal', 'high' );
    add_meta_box( 'scgi_course_why',     'Why This Course?',  'scgi_course_why_html',         'scgi_course', 'normal', 'default' );
    add_meta_box( 'scgi_course_elig',    'Eligibility Info',  'scgi_course_eligibility_html', 'scgi_course', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'scgi_add_meta_boxes' );

// ── SLIDER META ──
function scgi_slider_meta_html( $post ) {
    $subtitle    = get_post_meta( $post->ID, '_slider_subtitle',    true );
    $highlight   = get_post_meta( $post->ID, '_slider_highlight',   true );
    $btn_text    = get_post_meta( $post->ID, '_slider_btn_text',    true );
    $btn_link    = get_post_meta( $post->ID, '_slider_btn_link',    true );
    wp_nonce_field( 'scgi_slider_nonce', 'scgi_slider_nonce_field' );
    ?>
    <table class="form-table" style="width:100%">
        <tr><th>Main Title</th><td><strong><?php the_title(); ?></strong> (Edit title above)</td></tr>
        <tr><th>Headline Highlight</th><td><input type="text" name="slider_highlight" value="<?php echo esc_attr( $highlight ); ?>" style="width:100%;" placeholder="e.g. Heal, Lead, Excel!"></td></tr>
        <tr><th>Subtitle / Tagline</th><td><input type="text" name="slider_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" style="width:100%;"></td></tr>
        <tr><th>Button Text</th><td><input type="text" name="slider_btn_text" value="<?php echo esc_attr( $btn_text ); ?>" style="width:100%;" placeholder="Explore Courses"></td></tr>
        <tr><th>Button Link</th><td><input type="text" name="slider_btn_link" value="<?php echo esc_attr( $btn_link ); ?>" style="width:100%;" placeholder="#courses"></td></tr>
    </table>
    <p><em>Set the "Featured Image" above to use as the slide background.</em></p>
    <?php
}

function scgi_save_slider_meta( $post_id ) {
    if ( ! isset( $_POST['scgi_slider_nonce_field'] ) || ! wp_verify_nonce( $_POST['scgi_slider_nonce_field'], 'scgi_slider_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    update_post_meta( $post_id, '_slider_subtitle', sanitize_text_field( $_POST['slider_subtitle'] ?? '' ) );
    update_post_meta( $post_id, '_slider_highlight', sanitize_text_field( $_POST['slider_highlight'] ?? '' ) );
    update_post_meta( $post_id, '_slider_btn_text', sanitize_text_field( $_POST['slider_btn_text'] ?? '' ) );
    update_post_meta( $post_id, '_slider_btn_link', sanitize_text_field( $_POST['slider_btn_link'] ?? '' ) );
}
add_action( 'save_post_scgi_slider', 'scgi_save_slider_meta' );

// ── COURSE DETAILS META ──
function scgi_course_details_html( $post ) {
    $level       = get_post_meta( $post->ID, '_course_level',       true );
    $duration    = get_post_meta( $post->ID, '_course_duration',    true );
    $short_desc  = get_post_meta( $post->ID, '_course_short_desc',  true );
    $is_paramed  = get_post_meta( $post->ID, '_course_is_paramed',  true );
    $brochure    = get_post_meta( $post->ID, '_course_brochure_url', true );
    wp_nonce_field( 'scgi_course_nonce', 'scgi_course_nonce_field' );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="course_level">Degree Level</label></th>
            <td>
                <select name="course_level" id="course_level">
                    <?php foreach ( array( 'Diploma', 'UG', 'Post Basic', 'PG' ) as $l ) : ?>
                        <option value="<?php echo esc_attr( $l ); ?>" <?php selected( $level, $l ); ?>><?php echo esc_html( $l ); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="course_duration">Duration</label></th>
            <td><input type="text" name="course_duration" id="course_duration" value="<?php echo esc_attr( $duration ); ?>" style="width:100%;" placeholder="e.g. 3 Years"></td>
        </tr>
        <tr>
            <th><label for="course_short_desc">Short Description (Card)</label></th>
            <td><textarea name="course_short_desc" id="course_short_desc" style="width:100%;height:80px;" placeholder="Shown on hover card — max 2 lines"><?php echo esc_textarea( $short_desc ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="course_is_paramed">Paramedical Badge?</label></th>
            <td><input type="checkbox" name="course_is_paramed" id="course_is_paramed" value="1" <?php checked( $is_paramed, '1' ); ?>> Show "Paramedical" badge on card</td>
        </tr>
        <tr>
            <th><label for="course_brochure_url">Brochure URL (PDF)</label></th>
            <td><input type="url" name="course_brochure_url" id="course_brochure_url" value="<?php echo esc_attr( $brochure ); ?>" style="width:100%;" placeholder="https://..."></td>
        </tr>
    </table>
    <?php
}

function scgi_course_why_html( $post ) {
    $why_text   = get_post_meta( $post->ID, '_course_why_text',   true );
    $why_points = get_post_meta( $post->ID, '_course_why_points', true );
    ?>
    <table class="form-table">
        <tr>
            <th>Intro Text</th>
            <td><textarea name="course_why_text" style="width:100%;height:70px;"><?php echo esc_textarea( $why_text ); ?></textarea></td>
        </tr>
        <tr>
            <th>Bullet Points<br><small>(one per line)</small></th>
            <td><textarea name="course_why_points" style="width:100%;height:120px;"><?php echo esc_textarea( $why_points ); ?></textarea></td>
        </tr>
    </table>
    <?php
}

function scgi_course_eligibility_html( $post ) {
    $eligibility = get_post_meta( $post->ID, '_course_eligibility', true );
    $exam_info   = get_post_meta( $post->ID, '_course_exam_info',   true );
    ?>
    <table class="form-table">
        <tr>
            <th>General Eligibility</th>
            <td><textarea name="course_eligibility" style="width:100%;height:100px;"><?php echo esc_textarea( $eligibility ); ?></textarea></td>
        </tr>
        <tr>
            <th>Examination Eligibility</th>
            <td><textarea name="course_exam_info" style="width:100%;height:100px;"><?php echo esc_textarea( $exam_info ); ?></textarea></td>
        </tr>
    </table>
    <?php
}

function scgi_save_course_meta( $post_id ) {
    if ( ! isset( $_POST['scgi_course_nonce_field'] ) || ! wp_verify_nonce( $_POST['scgi_course_nonce_field'], 'scgi_course_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array(
        '_course_level'       => array( 'type' => 'select', 'key' => 'course_level' ),
        '_course_duration'    => array( 'type' => 'text',   'key' => 'course_duration' ),
        '_course_short_desc'  => array( 'type' => 'text',   'key' => 'course_short_desc' ),
        '_course_brochure_url'=> array( 'type' => 'url',    'key' => 'course_brochure_url' ),
        '_course_why_text'    => array( 'type' => 'textarea','key' => 'course_why_text' ),
        '_course_why_points'  => array( 'type' => 'textarea','key' => 'course_why_points' ),
        '_course_eligibility' => array( 'type' => 'textarea','key' => 'course_eligibility' ),
        '_course_exam_info'   => array( 'type' => 'textarea','key' => 'course_exam_info' ),
    );
    foreach ( $fields as $meta_key => $config ) {
        $val = $_POST[ $config['key'] ] ?? '';
        if ( $config['type'] === 'textarea' ) {
            update_post_meta( $post_id, $meta_key, sanitize_textarea_field( $val ) );
        } elseif ( $config['type'] === 'url' ) {
            update_post_meta( $post_id, $meta_key, esc_url_raw( $val ) );
        } else {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( $val ) );
        }
    }
    // Checkbox
    update_post_meta( $post_id, '_course_is_paramed', isset( $_POST['course_is_paramed'] ) ? '1' : '0' );
}
add_action( 'save_post_scgi_course', 'scgi_save_course_meta' );

/* ═══════════════════════════════════════════════════
   5. ENQUIRIES DATABASE TABLE
═══════════════════════════════════════════════════ */
function scgi_create_enquiries_table() {
    global $wpdb;
    $table   = $wpdb->prefix . 'enquiries';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        type varchar(20) NOT NULL DEFAULT 'course',
        name varchar(100) DEFAULT '',
        email varchar(100) DEFAULT '',
        phone varchar(20) DEFAULT '',
        alt_phone varchar(20) DEFAULT '',
        state varchar(50) DEFAULT '',
        city varchar(50) DEFAULT '',
        course_category varchar(100) DEFAULT '',
        course_name varchar(100) DEFAULT '',
        message text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
add_action( 'after_switch_theme', 'scgi_create_enquiries_table' );

/* ═══════════════════════════════════════════════════
   6. FORM HANDLERS
═══════════════════════════════════════════════════ */
function scgi_handle_contact_form() {
    if ( ! isset( $_POST['contact_nonce'] ) || ! wp_verify_nonce( $_POST['contact_nonce'], 'scgi_form_submit' ) ) {
        wp_die( 'Security check failed.' );
    }
    global $wpdb;
    $wpdb->insert( $wpdb->prefix . 'enquiries', array(
        'type'      => 'contact',
        'name'      => sanitize_text_field( $_POST['name'] ?? '' ),
        'email'     => sanitize_email( $_POST['email'] ?? '' ),
        'phone'     => sanitize_text_field( $_POST['phone'] ?? '' ),
        'alt_phone' => sanitize_text_field( $_POST['alt_phone'] ?? '' ),
        'state'     => sanitize_text_field( $_POST['state'] ?? '' ),
        'city'      => sanitize_text_field( $_POST['city'] ?? '' ),
        'message'   => sanitize_textarea_field( $_POST['message'] ?? '' ),
    ) );
    wp_redirect( add_query_arg( 'success', '1', wp_get_referer() ?: home_url( '/contact' ) ) );
    exit;
}
add_action( 'admin_post_nopriv_scgi_contact', 'scgi_handle_contact_form' );
add_action( 'admin_post_scgi_contact',        'scgi_handle_contact_form' );

function scgi_handle_course_enquiry() {
    if ( ! isset( $_POST['enquiry_nonce'] ) || ! wp_verify_nonce( $_POST['enquiry_nonce'], 'scgi_form_submit' ) ) {
        wp_die( 'Security check failed.' );
    }
    global $wpdb;
    $wpdb->insert( $wpdb->prefix . 'enquiries', array(
        'type'            => 'course',
        'course_category' => sanitize_text_field( $_POST['category'] ?? '' ),
        'course_name'     => sanitize_text_field( $_POST['course'] ?? '' ),
        'state'           => sanitize_text_field( $_POST['state'] ?? '' ),
        'city'            => sanitize_text_field( $_POST['city'] ?? '' ),
    ) );
    wp_redirect( add_query_arg( 'enquiry_success', '1', wp_get_referer() ?: home_url( '/' ) ) );
    exit;
}
add_action( 'admin_post_nopriv_scgi_course_enquiry', 'scgi_handle_course_enquiry' );
add_action( 'admin_post_scgi_course_enquiry',        'scgi_handle_course_enquiry' );

/* ═══════════════════════════════════════════════════
   7. AJAX — COURSE DROPDOWN
═══════════════════════════════════════════════════ */
function scgi_fetch_courses_ajax() {
    check_ajax_referer( 'scgi_nonce', 'security' );
    $category = sanitize_text_field( $_POST['category'] ?? '' );
    $args = array(
        'post_type'      => 'scgi_course',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'tax_query'      => array( array(
            'taxonomy' => 'course_category',
            'field'    => 'name',
            'terms'    => $category,
        ) ),
    );
    $query   = new WP_Query( $args );
    $courses = array();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $courses[] = get_the_title();
        }
    }
    wp_reset_postdata();
    wp_send_json_success( $courses );
}
add_action( 'wp_ajax_scgi_fetch_courses',        'scgi_fetch_courses_ajax' );
add_action( 'wp_ajax_nopriv_scgi_fetch_courses', 'scgi_fetch_courses_ajax' );

/* ═══════════════════════════════════════════════════
   8. ADMIN — ENQUIRIES PAGE
═══════════════════════════════════════════════════ */
function scgi_admin_menus() {
    add_menu_page( 'Enquiries', 'Enquiries', 'manage_options', 'scgi-enquiries',
        'scgi_enquiries_page_html', 'dashicons-email-alt', 26 );
}
add_action( 'admin_menu', 'scgi_admin_menus' );

function scgi_enquiries_page_html() {
    global $wpdb;
    $type    = isset( $_GET['filter_type'] ) ? sanitize_text_field( $_GET['filter_type'] ) : '';
    $where   = $type ? $wpdb->prepare( ' WHERE type = %s', $type ) : '';
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}enquiries{$where} ORDER BY created_at DESC" );
    ?>
    <div class="wrap">
        <h1>Enquiries <a href="<?php echo admin_url( 'edit.php?post_type=scgi_course' ); ?>" class="page-title-action">Manage Courses</a></h1>
        <form method="get" style="margin-bottom:15px;">
            <input type="hidden" name="page" value="scgi-enquiries">
            <select name="filter_type">
                <option value="">All Types</option>
                <option value="contact" <?php selected( $type, 'contact' ); ?>>Contact</option>
                <option value="course"  <?php selected( $type, 'course' ); ?>>Course Enquiry</option>
            </select>
            <input type="submit" class="button" value="Filter">
        </form>
        <table class="wp-list-table widefat fixed striped">
            <thead><tr>
                <th>ID</th><th>Type</th><th>Name / Course</th>
                <th>Contact</th><th>Location</th><th>Date</th>
            </tr></thead>
            <tbody>
            <?php if ( $results ) : foreach ( $results as $row ) : ?>
                <tr>
                    <td><?php echo intval( $row->id ); ?></td>
                    <td><strong><?php echo esc_html( ucfirst( $row->type ) ); ?></strong></td>
                    <td>
                        <?php if ( $row->type === 'contact' ) :
                            echo esc_html( $row->name );
                        else :
                            echo '<small>Cat:</small> ' . esc_html( $row->course_category ) . '<br>';
                            echo '<small>Course:</small> ' . esc_html( $row->course_name );
                        endif; ?>
                    </td>
                    <td><?php echo esc_html( $row->phone ); ?><br><?php echo esc_html( $row->email ); ?></td>
                    <td><?php echo esc_html( $row->city . ', ' . $row->state ); ?></td>
                    <td><?php echo esc_html( $row->created_at ); ?></td>
                </tr>
            <?php endforeach; else : ?>
                <tr><td colspan="6">No enquiries found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/* ═══════════════════════════════════════════════════
   9. CUSTOMIZER — ALL SETTINGS
═══════════════════════════════════════════════════ */
function scgi_customize_register( $wp_customize ) {

    // ── CONTACT INFO ──
    $wp_customize->add_section( 'scgi_contact_info', array(
        'title'    => 'Contact Information',
        'priority' => 30,
    ) );
    $contact_settings = array(
        'scgi_phone'         => array( 'label' => 'Phone (link)',     'default' => '+919947915916' ),
        'scgi_phone_display' => array( 'label' => 'Phone (display)',  'default' => '+91 99479 15916 / 97690 02277' ),
        'scgi_email'         => array( 'label' => 'Email',            'default' => 'info@scgi.in' ),
        'scgi_whatsapp'      => array( 'label' => 'WhatsApp (no +)',  'default' => '919769002277' ),
        'scgi_address'       => array( 'label' => 'Address',          'default' => 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Kolar, Karnataka – 563102', 'type' => 'textarea' ),
        'scgi_maps_embed'    => array( 'label' => 'Google Maps Embed URL', 'default' => '' ),
    );
    foreach ( $contact_settings as $id => $cfg ) {
        $wp_customize->add_setting( $id, array( 'default' => $cfg['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( $id, array( 'label' => $cfg['label'], 'section' => 'scgi_contact_info', 'type' => $cfg['type'] ?? 'text' ) );
    }

    // ── SOCIAL LINKS ──
    $wp_customize->add_section( 'scgi_social_links', array( 'title' => 'Social Media Links', 'priority' => 35 ) );
    foreach ( array( 'scgi_facebook' => 'Facebook URL', 'scgi_instagram' => 'Instagram URL', 'scgi_youtube' => 'YouTube URL' ) as $id => $label ) {
        $wp_customize->add_setting( $id, array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( $id, array( 'label' => $label, 'section' => 'scgi_social_links', 'type' => 'url' ) );
    }

    // ── ABOUT & HOMEPAGE CONTENT ──
    $wp_customize->add_section( 'scgi_homepage', array( 'title' => 'Homepage Content', 'priority' => 40 ) );
    $home_settings = array(
        'scgi_about_heading' => array( 'label' => 'About Section Heading',  'default' => 'A Legacy of Excellence in Healthcare Education' ),
        'scgi_about_text'    => array( 'label' => 'About Section Text',     'default' => 'Sri Channegowda Group of Institutions (SCGI), established in 2006, is a premier healthcare education institution affiliated to RGUHS.', 'type' => 'textarea' ),
        'scgi_about_points'  => array( 'label' => 'About Points (one per line)', 'default' => "RGUHS Affiliated Since 2006\nState-of-the-art Labs & Clinical Facilities\nOn-campus Hospital for Clinical Training\nPlacement Assistance for Graduates", 'type' => 'textarea' ),
        'scgi_estd'          => array( 'label' => 'Established Year',       'default' => '2006' ),
        'scgi_years'         => array( 'label' => 'Counter: Years',         'default' => '20' ),
        'scgi_alumni'        => array( 'label' => 'Counter: Alumni',        'default' => '5000' ),
        'scgi_programmes'    => array( 'label' => 'Counter: Programmes',    'default' => '10' ),
        'scgi_labs'          => array( 'label' => 'Counter: Labs',          'default' => '8' ),
        'scgi_why_heading'   => array( 'label' => 'Why SCGI Heading',       'default' => 'Why Choose SCGI?' ),
        'scgi_why_subtext'   => array( 'label' => 'Why SCGI Sub-text',      'default' => 'We combine academic excellence with real-world clinical training.' ),
    );
    foreach ( $home_settings as $id => $cfg ) {
        $wp_customize->add_setting( $id, array( 'default' => $cfg['default'], 'sanitize_callback' => 'sanitize_textarea_field' ) );
        $wp_customize->add_control( $id, array( 'label' => $cfg['label'], 'section' => 'scgi_homepage', 'type' => $cfg['type'] ?? 'text' ) );
    }

    // ── ABOUT PAGE ──
    $wp_customize->add_section( 'scgi_about_page', array( 'title' => 'About Page', 'priority' => 45 ) );
    foreach ( array(
        'scgi_mission' => array( 'label' => 'Mission Statement', 'default' => 'We aim to deliver a nurturing ground and a positive learning environment which ensures student well-being & academic success.', 'type' => 'textarea' ),
        'scgi_vision'  => array( 'label' => 'Vision Statement',  'default' => 'Promoting educational, cultural, social and charitable advancement for excellence.',                                         'type' => 'textarea' ),
    ) as $id => $cfg ) {
        $wp_customize->add_setting( $id, array( 'default' => $cfg['default'], 'sanitize_callback' => 'sanitize_textarea_field' ) );
        $wp_customize->add_control( $id, array( 'label' => $cfg['label'], 'section' => 'scgi_about_page', 'type' => $cfg['type'] ) );
    }

    // ── CTA BAND ──
    $wp_customize->add_section( 'scgi_cta_band', array( 'title' => 'CTA Band', 'priority' => 50 ) );
    foreach ( array(
        'scgi_cta_heading'  => array( 'label' => 'Heading',          'default' => 'Guiding You Towards a Bright Career' ),
        'scgi_cta_subtext'  => array( 'label' => 'Subtext',          'default' => 'Reach Out for Admissions, Queries & More' ),
        'scgi_cta_btn_text' => array( 'label' => 'Button Text',      'default' => 'Contact Us' ),
        'scgi_cta_btn_link' => array( 'label' => 'Button Link',      'default' => '' ),
    ) as $id => $cfg ) {
        $wp_customize->add_setting( $id, array( 'default' => $cfg['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( $id, array( 'label' => $cfg['label'], 'section' => 'scgi_cta_band', 'type' => 'text' ) );
    }

    // ── FOOTER ──
    $wp_customize->add_section( 'scgi_footer', array( 'title' => 'Footer', 'priority' => 55 ) );
    $wp_customize->add_setting( 'scgi_footer_about', array( 'default' => 'SCGI was established in 2006 and is affiliated to Rajiv Gandhi University of Health Sciences (RGUHS). Nestled in Kolar beside the Chennai–Bangalore highway, SCGI is a premier healthcare education institution with its own on-campus hospital.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
    $wp_customize->add_control( 'scgi_footer_about', array( 'label' => 'Footer About Text', 'section' => 'scgi_footer', 'type' => 'textarea' ) );

    // ── DEPARTMENT BANNERS ──
    $wp_customize->add_section( 'scgi_dept_banners', array( 'title' => 'Department Banner Images', 'priority' => 60 ) );
    $dept_banners = array(
        'scgi_banner_nursing' => 'Nursing Banner Image URL',
        'scgi_banner_physio'  => 'Physiotherapy Banner Image URL',
        'scgi_banner_allied'  => 'Allied Health Banner Image URL',
    );
    foreach ( $dept_banners as $id => $label ) {
        $wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
            'label'   => $label,
            'section' => 'scgi_dept_banners',
        ) ) );
    }
}
add_action( 'customize_register', 'scgi_customize_register' );

/* ═══════════════════════════════════════════════════
   10. FOOTER — nav menu fix
═══════════════════════════════════════════════════ */
// Override footer.php's nav menu to use footer location
function scgi_footer_nav( $args ) {
    if ( isset( $args['theme_location'] ) && $args['theme_location'] === 'primary'
         && isset( $args['menu_class'] ) && $args['menu_class'] === 'fl' ) {
        $args['theme_location'] = 'footer';
    }
    return $args;
}
add_filter( 'wp_nav_menu_args', 'scgi_footer_nav' );

/* ═══════════════════════════════════════════════════
   11. SETUP CONTENT RUNNER
═══════════════════════════════════════════════════ */
require_once get_template_directory() . '/setup-content.php';
