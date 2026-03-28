<?php
/**
 * SCGI Custom Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* ───── REQUIRE SETUP CONTENT ───── */
require_once get_template_directory() . '/setup-content.php';

/* ───── THEME SETUP ───── */
function scgi_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'scgi-custom' ),
	) );
}
add_action( 'after_setup_theme', 'scgi_setup' );

/* ───── ENQUEUE ASSETS ───── */
function scgi_scripts() {
	wp_enqueue_style( 'scgi-google-fonts', 'https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'scgi-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', array(), '6.5.0' );
	wp_enqueue_style( 'scgi-main-style', get_stylesheet_uri(), array(), '1.0' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'scgi-main-js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0', true );

	// Localize for AJAX
	wp_localize_script( 'scgi-main-js', 'scgi_ajax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'scgi_nonce' )
	) );
}
add_action( 'wp_enqueue_scripts', 'scgi_scripts' );

/* ───── CUSTOM POST TYPES ───── */

// Sliders CPT
function scgi_register_sliders_cpt() {
	$labels = array(
		'name'          => 'Sliders',
		'singular_name' => 'Slider',
	);
	$args = array(
		'labels'      => $labels,
		'public'      => true,
		'has_archive' => false,
		'supports'    => array( 'title', 'thumbnail', 'page-attributes' ), // page-attributes for menu_order
		'menu_icon'   => 'dashicons-images-alt2',
		'rewrite'     => array( 'slug' => 'slider' ),
	);
	register_post_type( 'scgi_slider', $args );
}
add_action( 'init', 'scgi_register_sliders_cpt' );

// Courses CPT
function scgi_register_courses_cpt() {
	$labels = array(
		'name'          => 'Courses',
		'singular_name' => 'Course',
	);
	$args = array(
		'labels'      => $labels,
		'public'      => true,
		'has_archive' => true,
		'supports'    => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'menu_icon'   => 'dashicons-welcome-learn-more',
		'rewrite'     => array( 'slug' => 'courses' ),
	);
	register_post_type( 'scgi_course', $args );
}
add_action( 'init', 'scgi_register_courses_cpt' );

// Course Taxonomy
function scgi_register_course_taxonomy() {
	register_taxonomy( 'course_category', 'scgi_course', array(
		'label'        => 'Categories',
		'rewrite'      => array( 'slug' => 'course-category' ),
		'hierarchical' => true,
	) );
}
add_action( 'init', 'scgi_register_course_taxonomy' );

// Logos CPT
function scgi_register_logos_cpt() {
	$labels = array(
		'name'          => 'Logos',
		'singular_name' => 'Logo',
	);
	$args = array(
		'labels'      => $labels,
		'public'      => true,
		'supports'    => array( 'title', 'thumbnail', 'page-attributes' ),
		'menu_icon'   => 'dashicons-grid-view',
	);
	register_post_type( 'scgi_logo', $args );
}
add_action( 'init', 'scgi_register_logos_cpt' );

/* ───── CUSTOM META BOXES (Native - No ACF) ───── */

// Slider Meta Boxes
function scgi_add_slider_metaboxes() {
	add_meta_box( 'slider_details', 'Slider Details', 'scgi_slider_details_html', 'scgi_slider', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'scgi_add_slider_metaboxes' );

function scgi_slider_details_html( $post ) {
	$subtitle    = get_post_meta( $post->ID, '_slider_subtitle', true );
	$description = get_post_meta( $post->ID, '_slider_description', true );
	$button_text = get_post_meta( $post->ID, '_slider_btn_text', true );
	$button_link = get_post_meta( $post->ID, '_slider_btn_link', true );
	wp_nonce_field( 'slider_details_nonce', 'slider_details_nonce_field' );
	?>
	<p><label>Subtitle (Gold Text):</label><br><input type="text" name="slider_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" style="width:100%;"></p>
	<p><label>Description:</label><br><textarea name="slider_description" style="width:100%; height: 60px;"><?php echo esc_textarea( $description ); ?></textarea></p>
	<p><label>Button Text:</label><br><input type="text" name="slider_btn_text" value="<?php echo esc_attr( $button_text ); ?>" style="width:100%;"></p>
	<p><label>Button Link:</label><br><input type="text" name="slider_btn_link" value="<?php echo esc_attr( $button_link ); ?>" style="width:100%;"></p>
	<?php
}

function scgi_save_slider_details( $post_id ) {
	if ( ! isset( $_POST['slider_details_nonce_field'] ) || ! wp_verify_nonce( $_POST['slider_details_nonce_field'], 'slider_details_nonce' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	update_post_meta( $post_id, '_slider_subtitle', sanitize_text_field( $_POST['slider_subtitle'] ) );
	update_post_meta( $post_id, '_slider_description', sanitize_textarea_field( $_POST['slider_description'] ) );
	update_post_meta( $post_id, '_slider_btn_text', sanitize_text_field( $_POST['slider_btn_text'] ) );
	update_post_meta( $post_id, '_slider_btn_link', sanitize_text_field( $_POST['slider_btn_link'] ) );
}
add_action( 'save_post_scgi_slider', 'scgi_save_slider_details' );

// Course Meta Boxes
function scgi_add_course_metaboxes() {
	add_meta_box( 'course_details', 'Course Details', 'scgi_course_details_html', 'scgi_course', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'scgi_add_course_metaboxes' );

function scgi_course_details_html( $post ) {
	$duration = get_post_meta( $post->ID, '_course_duration', true );
	wp_nonce_field( 'course_details_nonce', 'course_details_nonce_field' );
	?>
	<p><label>Duration:</label><br><input type="text" name="course_duration" value="<?php echo esc_attr( $duration ); ?>" style="width:100%;"></p>
	<?php
}

function scgi_save_course_details( $post_id ) {
	if ( ! isset( $_POST['course_details_nonce_field'] ) || ! wp_verify_nonce( $_POST['course_details_nonce_field'], 'course_details_nonce' ) ) return;
	update_post_meta( $post_id, '_course_duration', sanitize_text_field( $_POST['course_duration'] ) );
}
add_action( 'save_post_scgi_course', 'scgi_save_course_details' );

/* ───── CUSTOM DATABASE TABLE (wp_enquiries) ───── */

function scgi_create_enquiries_table() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'enquiries';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		type varchar(20) NOT NULL,
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
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
add_action( 'after_switch_theme', 'scgi_create_enquiries_table' );

/* ───── FORM HANDLING (admin-post.php) ───── */

function scgi_handle_contact_form() {
	if ( ! isset( $_POST['contact_nonce'] ) || ! wp_verify_nonce( $_POST['contact_nonce'], 'scgi_form_submit' ) ) {
		wp_die( 'Security Check Failed' );
	}

	global $wpdb;
	$wpdb->insert( $wpdb->prefix . 'enquiries', array(
		'type'      => 'contact',
		'name'      => sanitize_text_field( $_POST['name'] ),
		'email'     => sanitize_email( $_POST['email'] ),
		'phone'     => sanitize_text_field( $_POST['phone'] ),
		'alt_phone' => sanitize_text_field( $_POST['alt_phone'] ),
		'state'     => sanitize_text_field( $_POST['state'] ),
		'city'      => sanitize_text_field( $_POST['city'] ),
		'message'   => sanitize_textarea_field( $_POST['message'] ),
	));

	wp_redirect( home_url( '/contact/?success=1' ) );
	exit;
}
add_action( 'admin_post_nopriv_scgi_contact', 'scgi_handle_contact_form' );
add_action( 'admin_post_scgi_contact', 'scgi_handle_contact_form' );

function scgi_handle_course_enquiry() {
	if ( ! isset( $_POST['enquiry_nonce'] ) || ! wp_verify_nonce( $_POST['enquiry_nonce'], 'scgi_form_submit' ) ) {
		wp_die( 'Security Check Failed' );
	}

	global $wpdb;
	$wpdb->insert( $wpdb->prefix . 'enquiries', array(
		'type'            => 'course',
		'course_category' => sanitize_text_field( $_POST['category'] ),
		'course_name'     => sanitize_text_field( $_POST['course'] ),
		'state'           => sanitize_text_field( $_POST['state'] ),
		'city'            => sanitize_text_field( $_POST['city'] ),
	));

	wp_redirect( add_query_arg( 'enquiry_success', '1', wp_get_referer() ) );
	exit;
}
add_action( 'admin_post_nopriv_scgi_course_enquiry', 'scgi_handle_course_enquiry' );
add_action( 'admin_post_scgi_course_enquiry', 'scgi_handle_course_enquiry' );

/* ───── AJAX COURSE DROPDOWN ───── */

function scgi_fetch_courses_ajax() {
	check_ajax_referer( 'scgi_nonce', 'security' );
	
	$category = sanitize_text_field( $_POST['category'] );
	$args = array(
		'post_type'      => 'scgi_course',
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'course_category',
				'field'    => 'name',
				'terms'    => $category,
			),
		),
	);
	
	$query = new WP_Query( $args );
	$courses = array();
	
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$courses[] = get_the_title();
		}
	}
	wp_reset_postdata();
	echo json_encode( $courses );
	wp_die();
}
add_action( 'wp_ajax_scgi_fetch_courses', 'scgi_fetch_courses_ajax' );
add_action( 'wp_ajax_nopriv_scgi_fetch_courses', 'scgi_fetch_courses_ajax' );

/* ───── ADMIN DASHBOARD (Enquiries) ───── */

function scgi_admin_menus() {
	add_menu_page( 'Enquiries', 'Enquiries', 'manage_options', 'scgi-enquiries', 'scgi_enquiries_page_html', 'dashicons-email-alt', 26 );
}
add_action( 'admin_menu', 'scgi_admin_menus' );

function scgi_enquiries_page_html() {
	global $wpdb;
	$type = isset( $_GET['filter_type'] ) ? sanitize_text_field( $_GET['filter_type'] ) : '';
	$where = $type ? $wpdb->prepare( "WHERE type = %s", $type ) : "";
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}enquiries $where ORDER BY created_at DESC" );
	?>
	<div class="wrap">
		<h1>Enquiries</h1>
		<div class="tablenav top">
			<form method="get">
				<input type="hidden" name="page" value="scgi-enquiries">
				<select name="filter_type">
					<option value="">All Types</option>
					<option value="contact" <?php selected($type, 'contact'); ?>>Contact</option>
					<option value="course" <?php selected($type, 'course'); ?>>Course Enquiry</option>
				</select>
				<input type="submit" class="button" value="Filter">
			</form>
		</div>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Type</th>
					<th>Name / Course</th>
					<th>Contact Info</th>
					<th>Location</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( $results ) : foreach ( $results as $row ) : ?>
					<tr>
						<td><?php echo $row->id; ?></td>
						<td><strong><?php echo ucfirst($row->type); ?></strong></td>
						<td><?php echo $row->type == 'contact' ? esc_html($row->name) : 'Category: ' . esc_html($row->course_category) . '<br>Course: ' . esc_html($row->course_name); ?></td>
						<td><?php echo esc_html($row->phone); ?><br><?php echo esc_html($row->email); ?></td>
						<td><?php echo esc_html($row->city) . ', ' . esc_html($row->state); ?></td>
						<td><?php echo $row->created_at; ?></td>
					</tr>
				<?php endforeach; else : ?>
					<tr><td colspan="6">No enquiries found.</td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/* ───── CUSTOMIZER SETTINGS (Contact Info) ───── */

function scgi_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'scgi_contact_info' , array(
		'title'      => __('Contact Information', 'scgi'),
		'priority'   => 30,
	) );

	$wp_customize->add_setting( 'scgi_phone', array( 'default' => '+919947915916', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'scgi_phone', array( 'label' => 'Phone Number (Link)', 'section' => 'scgi_contact_info', 'type' => 'text' ) );

	$wp_customize->add_setting( 'scgi_phone_display', array( 'default' => '+91 99479 15916 / 97690 02277', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'scgi_phone_display', array( 'label' => 'Phone Number (Display)', 'section' => 'scgi_contact_info', 'type' => 'text' ) );

	$wp_customize->add_setting( 'scgi_email', array( 'default' => 'info@scgi.in', 'sanitize_callback' => 'sanitize_email' ) );
	$wp_customize->add_control( 'scgi_email', array( 'label' => 'Email', 'section' => 'scgi_contact_info', 'type' => 'text' ) );

	$wp_customize->add_setting( 'scgi_whatsapp', array( 'default' => '919769002277', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'scgi_whatsapp', array( 'label' => 'WhatsApp Number (without +)', 'section' => 'scgi_contact_info', 'type' => 'text' ) );

	$wp_customize->add_setting( 'scgi_address', array( 'default' => 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Kolar, Karnataka – 563102', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'scgi_address', array( 'label' => 'Address', 'section' => 'scgi_contact_info', 'type' => 'textarea' ) );
}
add_action( 'customize_register', 'scgi_customize_register' );

/* ───── GALLERY CPT ───── */

function scgi_register_gallery_cpt() {
	$labels = array(
		'name'          => 'Gallery',
		'singular_name' => 'Gallery Item',
	);
	$args = array(
		'labels'      => $labels,
		'public'      => true,
		'supports'    => array( 'title', 'thumbnail' ),
		'menu_icon'   => 'dashicons-format-image',
	);
	register_post_type( 'scgi_gallery', $args );
}
add_action( 'init', 'scgi_register_gallery_cpt' );

/* ───── ABOUT POINTS META BOX ───── */

function scgi_add_about_metaboxes() {
	add_meta_box( 'about_points', 'About Us Points (One per line)', 'scgi_about_points_html', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'scgi_add_about_metaboxes' );

function scgi_about_points_html( $post ) {
	$points = get_post_meta( $post->ID, '_about_points', true );
	wp_nonce_field( 'about_points_nonce', 'about_points_nonce_field' );
	?>
	<p><label>Points (Use new lines for each):</label><br>
	<textarea name="about_points" style="width:100%; height: 100px;"><?php echo esc_textarea( $points ); ?></textarea></p>
	<?php
}

function scgi_save_about_points( $post_id ) {
	if ( ! isset( $_POST['about_points_nonce_field'] ) || ! wp_verify_nonce( $_POST['about_points_nonce_field'], 'about_points_nonce' ) ) return;
	update_post_meta( $post_id, '_about_points', sanitize_textarea_field( $_POST['about_points'] ) );
}
add_action( 'save_post', 'scgi_save_about_points' );

/* ───── COURSE DETAIL META BOXES ───── */

function scgi_add_course_detail_metaboxes() {
	add_meta_box( 'course_why', 'Why Choose This Course?', 'scgi_course_why_html', 'scgi_course', 'normal', 'high' );
	add_meta_box( 'course_eligibility', 'Eligibility Criteria', 'scgi_course_eligibility_html', 'scgi_course', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'scgi_add_course_detail_metaboxes' );

function scgi_course_why_html( $post ) {
	$why_text = get_post_meta( $post->ID, '_course_why_text', true );
	$why_points = get_post_meta( $post->ID, '_course_why_points', true );
	?>
	<p><label>Intro Text:</label><br><textarea name="course_why_text" style="width:100%; height: 80px;"><?php echo esc_textarea( $why_text ); ?></textarea></p>
	<p><label>Points (One per line):</label><br><textarea name="course_why_points" style="width:100%; height: 80px;"><?php echo esc_textarea( $why_points ); ?></textarea></p>
	<?php
}

function scgi_course_eligibility_html( $post ) {
	$eligibility = get_post_meta( $post->ID, '_course_eligibility', true );
	$exam_info = get_post_meta( $post->ID, '_course_exam_info', true );
	?>
	<p><label>General Eligibility:</label><br><textarea name="course_eligibility" style="width:100%; height: 80px;"><?php echo esc_textarea( $eligibility ); ?></textarea></p>
	<p><label>Examination Info:</label><br><textarea name="course_exam_info" style="width:100%; height: 80px;"><?php echo esc_textarea( $exam_info ); ?></textarea></p>
	<?php
}

function scgi_save_course_detail_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( isset( $_POST['course_why_text'] ) ) update_post_meta( $post_id, '_course_why_text', sanitize_textarea_field( $_POST['course_why_text'] ) );
	if ( isset( $_POST['course_why_points'] ) ) update_post_meta( $post_id, '_course_why_points', sanitize_textarea_field( $_POST['course_why_points'] ) );
	if ( isset( $_POST['course_eligibility'] ) ) update_post_meta( $post_id, '_course_eligibility', sanitize_textarea_field( $_POST['course_eligibility'] ) );
	if ( isset( $_POST['course_exam_info'] ) ) update_post_meta( $post_id, '_course_exam_info', sanitize_textarea_field( $_POST['course_exam_info'] ) );
}
add_action( 'save_post_scgi_course', 'scgi_save_course_detail_meta' );
