<?php
//customs post type and taxonomy /dang ky san pham va danh muc san pham/
function create_product_service() {
    $labels = array(
        'name'                  => __( 'Dịch vụ', 'text_domain' ),
        'singular_name'         => __( 'Dịch vụ', 'text_domain' ),
        'menu_name'             => __( 'Dịch vụ', 'text_domain' ),
        'name_admin_bar'        => __( 'Dịch vụ', 'text_domain' ),
        'add_new'               => __( 'Thêm mới', 'text_domain' ),
        'add_new_item'          => __( 'Thêm Dịch vụ mới', 'text_domain' ),
        'new_item'              => __( 'Dịch vụ mới', 'text_domain' ),
        'edit_item'             => __( 'Chỉnh sửa Dịch vụ', 'text_domain' ),
        'view_item'             => __( 'Xem Dịch vụ', 'text_domain' ),
        'all_items'             => __( 'Tất cả Dịch vụ', 'text_domain' ),
        'search_items'          => __( 'Tìm kiếm Dịch vụ', 'text_domain' ),
        'parent_item_colon'     => __( 'Dịch vụ cha:', 'text_domain' ),
        'not_found'             => __( 'Không tìm thấy Dịch vụ.', 'text_domain' ),
        'not_found_in_trash'    => __( 'Không có Dịch vụ nào trong thùng rác.', 'text_domain' ),
        'featured_image'        => __( 'Hình ảnh đại diện', 'text_domain' ),
        'set_featured_image'    => __( 'Đặt hình ảnh đại diện', 'text_domain' ),
        'remove_featured_image' => __( 'Xóa hình ảnh đại diện', 'text_domain' ),
        'use_featured_image'    => __( 'Sử dụng như hình ảnh đại diện', 'text_domain' ),
        'archives'              => __( 'Lưu trữ Dịch vụ', 'text_domain' ),
        'insert_into_item'      => __( 'Chèn vào Dịch vụ', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Đã tải lên Dịch vụ này', 'text_domain' ),
        'filter_items_list'     => __( 'Lọc danh sách Dịch vụ', 'text_domain' ),
        'items_list_navigation' => __( 'Điều hướng danh sách Dịch vụ', 'text_domain' ),
        'items_list'            => __( 'Danh sách Dịch vụ', 'text_domain' ),
        
    );
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'san-pham' ),
        'capability_type'       => 'post',
		 'menu_icon'             => 'dashicons-cart',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'gallery' ),
    );
    register_post_type( 'product-service', $args );
}
add_action( 'init', 'create_product_service', 0 );
function create_product_service_taxonomy() {
$labels = array(
    'name'                       => __( 'Danh mục Dịch vụ', 'text_domain' ),
    'singular_name'              => __( 'Danh mục Dịch vụ', 'text_domain' ),
    'search_items'               => __( 'Tìm kiếm danh mục', 'text_domain' ),
    'popular_items'              => __( 'Danh mục phổ biến', 'text_domain' ),
    'all_items'                  => __( 'Tất cả danh mục', 'text_domain' ),
    'parent_item'                => __( 'Danh mục cha', 'text_domain' ),
    'parent_item_colon'          => __( 'Danh mục cha:', 'text_domain' ),
    'edit_item'                  => __( 'Chỉnh sửa danh mục', 'text_domain' ),
    'update_item'                => __( 'Cập nhật danh mục', 'text_domain' ),
    'add_new_item'               => __( 'Thêm danh mục mới', 'text_domain' ),
    'new_item_name'              => __( 'Tên danh mục mới', 'text_domain' ),
    'separate_items_with_commas' => __( 'Phân tách danh mục bằng dấu phẩy', 'text_domain' ),
    'add_or_remove_items'        => __( 'Thêm hoặc xoá danh mục', 'text_domain' ),
    'choose_from_most_used'      => __( 'Chọn từ danh mục phổ biến', 'text_domain' ),
    'not_found'                  => __( 'Không tìm thấy danh mục.', 'text_domain' ),
    'menu_name'                  => __( 'Danh mục Dịch vụ', 'text_domain' ),
);

$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'rewrite'                    => array( 'slug' => 'danh-muc-san-pham' ),
);
register_taxonomy( 'product-category', array( 'product-service' ), $args );
}
add_action( 'init', 'create_product_service_taxonomy', 0 );

//chen file css progress-bar.css
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'progress-bar', get_stylesheet_directory_uri() . '/css/progress-bar.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles' );

  //shortcode hien thi danh muc dich vu
function list_product_services($atts) {
    ob_start();
    extract(shortcode_atts(array(
        'category' => ''
    ), $atts));   
    $args = array(
        'post_type' => 'product-service',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product-category',
                'field' => 'slug',
                'terms' => $category
            )
        )
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) : ?>
<div class="row large-columns-4 medium-columns-3 small-columns-2 row-xsmall product-service_dev">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
    <div class="col post-item">
        <div class="col-inner col-box_dev">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          
                <!--price tab-->
                <div class="listing-item">
                    <figure class="image">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( array(300, 600) ); ?>
                            <?php else : ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . '/screenshot.png'; ?>"
                                alt="Logo">
                        <?php endif; ?>
                    <figcaption>
                           <div class="caption">
                           <h4 class="post-title is-large"><?php the_title(); ?></h4>
                            </div> 
                        </figcaption>
                    </figure>
                    <div class="listing">
                    <h4><?php echo number_format(get_field('price_range')) ? number_format(get_field('price_range')) . ' đ' : '<span class="wait-update-price">Đang cập nhật giá</span>'; ?></h4>
                    <!-- hinh anh thuong hieu star -->
                        <div class="list-brands">
                            <?php
                            $brands = get_field('brands');

                            if ($brands) {
                                foreach ($brands as $brand) {
                                    $logo = get_field('logo-thuong-hieu', $brand, false); // Thêm tham số thứ ba là false để trả về ID của taxonomy
                                    if ($logo) {
                                        $image_array = wp_get_attachment_image_src($logo, 'full');
                                        $image_url = $image_array[0];
                            ?>
                                        <span class="brand-service-sp"><img src="<?php echo esc_url($image_url); ?>" alt="Brand Logo" width="100" height="50"></span>
                            <?php
                                    }
                                }
                            } else {
                                echo '<span class="wait-update">Đang cập nhật thương hiệu</span>';
                            }
                            ?>
                        </div>
                    <!-- hinh anh thuong hieu end -->
                        <p><i class="fa-solid fa-circle-check"></i> Dòng xe: <strong> <?php echo get_field('model') ? get_field('model') : '<span class="wait-update">Đang cập nhật</span>'; ?></strong> </p>                        
                        <p><i class="fa-solid fa-circle-check"></i> Bảo hành: <strong>  <?php echo get_field('guaranteed') ? get_field('guaranteed') : '<span class="wait-update">Đang cập nhật</span>'; ?></strong> </p>
                        <p><i class="fa-solid fa-circle-check"></i> Thời gian thi công: <strong> <?php echo get_field('construction_time') ? get_field('construction_time') : '<span class="wait-update">Đang cập nhật</span>'; ?></strong> </p>
                    </div>
                    <!-- <button class="button alert is-small is-outline mb-0 view-details" data-id="<?php echo get_the_ID(); ?>">Xem chi tiết</button> -->  
                    <div class="footer-box">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="button success is-small expand is-outline product-btn-view">Chi tiết</a>
                        <button class="button primary is-small expand view-details product-btn-order" data-id="<?php echo get_the_ID(); ?>" data-title="<?php the_title(); ?>">Đặt lịch</button>
                    </div>
                </div>
                <!-- end of price tab--> 
            </article>
        </div>
    </div>
    <?php endwhile; ?>
</div>



<!-- Hien thi poup san pham star -->
<div class="popup-wrapper">
    <div class="popup-content-product">
        <div class="popup-header">
            <a href="#" class="close-popup-product resetform"><i class="fa-solid fa-xmark"></i></a>
            <h4>Đặt lịch dịch vụ</h4>
        </div>
        <div class="popup-body">
            <div class="product-details"></div>
            <?php echo do_shortcode('[contact-form-7 id="1931" title="Form đặt lịch dịch vụ"]'); ?>
        </div>
        <div class="popup-footer">
            <!-- <a href="tel:0932061699" class="button button order-now">
                <i class="fa-solid fa-phone"></i> Liên hệ
            </a>
            <a href="https://zalo.me/0966660170" class="button order-now  zalo-button">
                <img src="http://vixsunfilm.com/wp-content/uploads/2023/06/zalo-01.svg" alt="Zalo Icon"
                    class="zalo-icon">
                Tư vấn Zalo
            </a> -->
        </div>
    </div>
</div>
<!-- Hien thi poup san pham end-->
<?php endif;
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('list_product_services', 'list_product_services');

// Hàm xử lý AJAX để hiển thị chi tiết sản phẩm
function get_product_details() {
    $post_id = $_POST['post_id'];
    ob_start();
    // Thay thế get_template_part() bằng nội dung chi tiết sản phẩm của bạn
    echo '<h4 class="preview-product">Quý khách đang đặt lịch cho dịch vụ: <span class="title-product-view" id="title_product_service">' . get_the_title($post_id) . '</span></h4>';
    $output = ob_get_clean();
    echo $output;
    wp_die();
}
add_action('wp_ajax_get_product_details', 'get_product_details');
add_action('wp_ajax_nopriv_get_product_details', 'get_product_details');






// Thêm mã JavaScript vào file function.php của theme hoặc plugin của bạn
function enqueue_custom_scripts() {
  wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/js/product-service.js', array('jquery'), '1.0', true);
  
  // Truyền giá trị của ajaxurl từ PHP sang JavaScript
  wp_localize_script('custom-scripts', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
?>