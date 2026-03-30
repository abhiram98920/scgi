<?php
/**
 * Auto-Populate Content on Theme Activation
 */

function scgi_auto_populate_content() {
    // Only run this once
    if ( get_option( 'scgi_theme_installed' ) ) {
        return;
    }
    
    // 1. Setup Customizer Contact Settings
    set_theme_mod( 'scgi_phone', '+919947915916' );
    set_theme_mod( 'scgi_phone_display', '+91 99479 15916 / 97690 02277' );
    set_theme_mod( 'scgi_email', 'info@scgi.in' );
    set_theme_mod( 'scgi_whatsapp', '919769002277' );
    set_theme_mod( 'scgi_address', 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Dodda Hasala Gram Panchayath, Kolar, Karnataka – 563102' );
    set_theme_mod( 'scgi_estd', '2006' );

    // Helper function to sideload images from our own theme folder
    if ( ! function_exists( 'scgi_upload_local_image' ) ) {
        function scgi_upload_local_image( $filename ) {
            $file_path = get_template_directory() . '/assets/images/' . $filename;
            if ( !file_exists( $file_path ) ) return false;
            
            // Check if already uploaded
            global $wpdb;
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid LIKE '%%%s'", $filename ) );
            if ( $attachment_id ) return $attachment_id;

            $wp_upload_dir = wp_upload_dir();
            $upload_path   = $wp_upload_dir['path'] . '/' . current_time( 'Y/m' );
            $upload_url    = $wp_upload_dir['url'] . '/' . current_time( 'Y/m' );
            wp_mkdir_p( $upload_path );

            $new_file = $upload_path . '/' . $filename;
            copy( $file_path, $new_file );

            $filetype = wp_check_filetype( $filename, null );
            $attachment = array(
                'guid'           => $upload_url . '/' . $filename, 
                'post_mime_type' => $filetype['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $new_file );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $new_file );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            
            return $attach_id;
        }
    }

    // Helper to sideload external url images
    if ( ! function_exists( 'scgi_upload_url_image' ) ) {
        function scgi_upload_url_image($url, $title) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            
            $tmp = download_url( $url );
            if( is_wp_error( $tmp ) ) return false;
            
            $file_array = array(
                'name' => basename( explode('?', $url)[0] ),
                'tmp_name' => $tmp
            );
            
            $id = media_handle_sideload( $file_array, 0, $title );
            if ( is_wp_error($id) ) {
                @unlink($file_array['tmp_name']);
                return false;
            }
            return $id;
        }
    }

    // Upload Logo & Set it
    $logo_id = scgi_upload_local_image( 'SCGI-Logo.png' );
    if ( $logo_id ) {
        set_theme_mod( 'custom_logo', $logo_id );
    }

    // Create Pages Map
    $pages = array(
        'home' => array('title' => 'Home', 'content' => '', 'template' => 'front-page.php'),
        'about-us' => array('title' => 'About Us', 'content' => '', 'template' => 'page-about.php'),
        'courses' => array('title' => 'Courses', 'content' => '', 'template' => 'archive-scgi_course.php'),
        'gallery' => array('title' => 'Gallery', 'content' => '', 'template' => 'page-gallery.php'),
        'contact' => array('title' => 'Contact', 'content' => '', 'template' => 'page-contact.php'),
    );
    
    $page_ids = array();
    foreach ( $pages as $slug => $data ) {
        $page_check = get_page_by_path( $slug );
        if ( ! isset( $page_check->ID ) ) {
            $new_page_id = wp_insert_post( array(
                'post_title'     => $data['title'],
                'post_name'      => $slug,
                'post_content'   => $data['content'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
            ) );
            if ( $data['template'] && $data['template'] !== 'archive-scgi_course.php' ) {
                update_post_meta( $new_page_id, '_wp_page_template', $data['template'] );
            }
            $page_ids[$slug] = $new_page_id;
        } else {
            $page_ids[$slug] = $page_check->ID;
        }
    }

    // Set Front Page
    if ( isset($page_ids['home']) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $page_ids['home'] );
    }

    // Setup Primary Menu
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );
    if ( !$menu_exists ) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);

        $ordered_pages = array('home', 'about-us', 'courses', 'gallery', 'contact');
        foreach ($ordered_pages as $slug) {
            if (isset($page_ids[$slug])) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $pages[$slug]['title'],
                    'menu-item-object-id' => $page_ids[$slug],
                    'menu-item-object' => 'page',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'post_type',
                ));
            }
        }
    }

    // About Us Content
    if(isset($page_ids['about-us'])) {
        $about_points = "Recognised by the Government of Karnataka\nAffiliated to Rajiv Gandhi University of Health Sciences (RGUHS)\nApproved by Indian Nursing Council (INC) & KSNC\nApproved by Karnataka State Diploma Board (KSDNEB)";
        update_post_meta($page_ids['about-us'], '_about_points', $about_points);
        
        $about_post = array(
            'ID' => $page_ids['about-us'],
            'post_content' => "SCGI has scripted success stories in the field of education and was established in the year 2006. We are affiliated to Rajiv Gandhi University of Health Sciences (RGUHS). SCGI is nestled in Kolar with own hospital, situated just beside the Chennai–Bangalore highway.\n\nAt SCGI, we believe that education is not limited to just academics. We aim to teach the upcoming generations that learning and developing their individual skills are for providing quality care, responsibility and respect within the society."
        );
        wp_update_post($about_post);
    }

    // Create Sliders
    $sliders = array(
        array(
            'title' => 'Choose Your Career at SCGI',
            'subtitle' => 'Heal, Lead, Excel!',
            'description' => 'Ignite your healthcare passion with expert training. Your future starts now!',
            'btn' => 'Explore Courses',
            'link' => '#courses',
            'img' => 'banner-nursing.png'
        ),
        array(
            'title' => 'Excellence in Clinical Practice',
            'subtitle' => 'Learn From the Best',
            'description' => 'State-of-the-art labs and our own multi-speciality hospital for hands-on training.',
            'btn' => 'View Accreditations',
            'link' => '#about',
            'img' => 'banner-physiotherapy.png'
        ),
        array(
            'title' => 'Shaping Healthcare Leaders',
            'subtitle' => 'Approved & Recognised',
            'description' => 'Join our vibrant campus established in 2006 with 5000+ alumni success stories.',
            'btn' => 'Enquire Today',
            'link' => '#enquire',
            'img' => 'banner-allied-health.png'
        )
    );

    $ext_sliders = get_posts(array('post_type'=>'scgi_slider','post_status'=>'any','posts_per_page'=>1));
    if(empty($ext_sliders)) {
        foreach ($sliders as $index => $s) {
            $sid = wp_insert_post(array(
                'post_title' => $s['title'],
                'post_status' => 'publish',
                'post_type' => 'scgi_slider',
                'menu_order' => $index
            ));
            
            update_post_meta($sid, '_slider_subtitle', $s['subtitle']);
            update_post_meta($sid, '_slider_description', $s['description']);
            update_post_meta($sid, '_slider_btn_text', $s['btn']);
            update_post_meta($sid, '_slider_btn_link', $s['link']);
            
            $attach_id = scgi_upload_local_image($s['img']);
            if($attach_id) set_post_thumbnail($sid, $attach_id);
        }
    }

    // Create Accreditations (Logos)
    $ext_logos = get_posts(array('post_type'=>'scgi_logo','post_status'=>'any','posts_per_page'=>1));
    if(empty($ext_logos)) {
        $logos = array(
            'Govt. of Karnataka' => 'KA-Govt-01.jpg',
            'RGUHS' => 'RGHUS-01.jpg',
            'Approved by Indian Nursing Council' => 'INC-01.jpg',
            'Approved by Karnataka State Nursing Council' => 'KSNC-01.jpg',
            'Approved by Karnataka Paramedical Board' => 'Logo of Karnataka paramedical board.webp',
            'Karnataka State Diploma in Nursing Examination Board (KSDNEB)' => 'Karnataka state diploma in nursing examination board.png'
        );
        foreach($logos as $title => $file) {
            $lid = wp_insert_post(array('post_title' => $title, 'post_status' => 'publish', 'post_type' => 'scgi_logo'));
            $aid = scgi_upload_local_image($file);
            if($aid) set_post_thumbnail($lid, $aid);
        }
    }

    // Prepare Categories for Courses
    $cats = array('Nursing', 'Physiotherapy', 'Allied Health Science');
    foreach($cats as $c) {
        if(!term_exists($c, 'course_category')) {
            wp_insert_term($c, 'course_category');
        }
    }

    // Create Courses
    $ext_courses = get_posts(array('post_type'=>'scgi_course','post_status'=>'any','posts_per_page'=>1));
    if(empty($ext_courses)) {
        $courses = array(
            array('title'=>'General Nursing and Midwifery (GNM)', 'cat'=>'Nursing', 'excerpt'=>'General Nursing & Midwifery programme that trains students in emergency care, clinical nursing, anatomy, physiology and midwifery practice.', 'img'=>'student-nursing.png', 'duration'=>'3.5 Years'),
            array('title'=>'Basic B.Sc Nursing', 'cat'=>'Nursing', 'excerpt'=>'A comprehensive four-year undergraduate programme designed to prepare students for a professional career in nursing and midwifery.', 'img'=>'student-nursing.png', 'duration'=>'4 Years'),
            array('title'=>'Post Basic B.Sc Nursing (P.B B.Sc Nursing)', 'cat'=>'Nursing', 'excerpt'=>'Post-basic B.Sc Nursing programme designed for GNM graduates to upgrade their qualifications and broaden their career opportunities.', 'img'=>'student-nursing.png', 'duration'=>'2 Years'),
            array('title'=>'Master of Science in Nursing (M.Sc Nursing)', 'cat'=>'Nursing', 'excerpt'=>'An advanced postgraduate programme for nursing professionals seeking to specialise and take on leadership and academic roles in healthcare.', 'img'=>'student-nursing.png', 'duration'=>'2 Years'),
            array('title'=>'Bachelor of Physiotherapy (BPT)', 'cat'=>'Physiotherapy', 'excerpt'=>'A four-and-a-half year undergraduate programme building expertise in rehabilitation, physical therapy, and movement sciences.', 'img'=>'student-physiotherapy.png', 'duration'=>'4.5 Years'),
            array('title'=>'Medical Laboratory Technology (B.Sc MLT)', 'cat'=>'Allied Health Science', 'excerpt'=>'Hands-on training in diagnostic labs — develop skills in clinical pathology, microbiology, biochemistry, and haematology.', 'img'=>'allied-bmlt.png', 'duration'=>'3 Years'),
            array('title'=>'Anaesthesia & Operation Theatre Technology (B.Sc AT & OTT)', 'cat'=>'Allied Health Science', 'excerpt'=>'Specialised programme preparing students for critical roles in operation theatre and anaesthesia management.', 'img'=>'allied-atott.png', 'duration'=>'3 Years'),
            array('title'=>'Medical Laboratory Technology (DMLT)', 'cat'=>'Allied Health Science', 'excerpt'=>'A focused diploma providing core laboratory skills in clinical pathology and diagnostic testing techniques.', 'img'=>'allied-bmlt.png', 'duration'=>'2 Years'),
            array('title'=>'Operation Theatre Technology (DOTT)', 'cat'=>'Allied Health Science', 'excerpt'=>'Specialised technical training for operation theatre assistants and paramedics.', 'img'=>'allied-atott.png', 'duration'=>'2 Years'),
            array('title'=>'Health Inspector (DHI)', 'cat'=>'Allied Health Science', 'excerpt'=>'Practical training in public health, sanitation, and community hygiene inspections.', 'img'=>'allied-atott.png', 'duration'=>'2 Years'),
        );
        
        foreach($courses as $idx => $c) {
            $cid = wp_insert_post(array('post_title'=>$c['title'], 'post_content'=>$c['excerpt'], 'post_status'=>'publish', 'post_type'=>'scgi_course', 'menu_order'=>$idx));
            wp_set_object_terms($cid, $c['cat'], 'course_category');
            update_post_meta($cid, '_course_duration', $c['duration']);
            
            $aid = scgi_upload_local_image($c['img']);
            if($aid) set_post_thumbnail($cid, $aid);
        }
    }

    // Load Gallery Data
    $ext_gallery = get_posts(array('post_type'=>'scgi_gallery','post_status'=>'any','posts_per_page'=>1));
    if(empty($ext_gallery)) {
        $galleries = array(
            'Hostel' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&q=80',
            'Smart Classroom' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&q=80',
            'Library' => 'https://images.unsplash.com/photo-1541339907198-e08756ebafe3?w=800&q=80',
            'Laboratories' => 'https://images.unsplash.com/photo-1581056770693-2d930f57d605?w=800&q=80',
            'Mini Auditorium' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
            'Exam Hall' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80',
            'IQAC Room' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&q=80',
            'Computer Lab' => 'https://images.unsplash.com/photo-1591453089816-0fbb971b454c?w=800&q=80',
            'Digital Evaluation Centre' => 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?w=800&q=80'
        );
        foreach($galleries as $title => $img) {
            $gid = wp_insert_post(array('post_title' => $title, 'post_status' => 'publish', 'post_type' => 'scgi_gallery'));
            $aid = scgi_upload_url_image($img, $title);
            if($aid) set_post_thumbnail($gid, $aid);
        }
    }

    // Mark as installed
    update_option( 'scgi_theme_installed', true );
}

add_action( 'after_switch_theme', 'scgi_auto_populate_content' );
