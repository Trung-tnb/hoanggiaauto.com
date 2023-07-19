<?php
// Add custom Theme Functions here
// cho phep tai file svg
function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);
/*gia-trang-chi-tiet-san-pham*/
function sago_price_html($product, $is_variation = false){
    ob_start();
    ?>
<?php
    if($product->is_on_sale()):
        ?>
<?php
    endif;    
    if($product->is_on_sale() && ($is_variation || $product->is_type('simple') || $product->is_type('external'))) {
        $sale_price = $product->get_sale_price();
        $regular_price = $product->get_regular_price();
        if($regular_price) {
            $sale = round(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
            $sale_amout = $regular_price - $sale_price;
            ?>

<div class="price-text">
    <ul>
        <li class="price">
            Giá:
            <span><?php echo wc_price($sale_price); ?></span>
        </li>
        <li class="price_old">
            Giá gốc:
            <span><?php echo wc_price($regular_price); ?>
        </li>
    </ul>
</div>
<?php
        }
    }elseif($product->is_on_sale() && $product->is_type('variable')){
        $prices = $product->get_variation_prices( true );
        if ( empty( $prices['price'] ) ) {
            $price = apply_filters( 'woocommerce_variable_empty_price_html', '', $product );
        } else {
            $min_price     = current( $prices['price'] );
            $max_price     = end( $prices['price'] );
            $min_reg_price = current( $prices['regular_price'] );
            $max_reg_price = end( $prices['regular_price'] );
             
            if ( $min_price !== $max_price ) {
                $price = wc_format_price_range( $min_price, $max_price ) . $product->get_price_suffix();
            } elseif ( $product->is_on_sale() && $min_reg_price === $max_reg_price ) {
                $sale = round(((floatval($max_reg_price) - floatval($min_price)) / floatval($max_reg_price)) * 100);
                $sale_amout = $max_reg_price - $min_price;
                ?>

<div class="price-text">
    <ul>
        <li class="price">
            Giá:
            <span><?php echo wc_price($min_price); ?></span>
        </li>
        <li class="price_old">
            Giá gốc:
            <span><?php echo wc_price($max_reg_price); ?>
        </li>
    </ul>
</div>
<?php
            } else {
                $price = wc_price( $min_price ) . $product->get_price_suffix();
            }
        }
        echo $price;      
    }else{ ?>
<div class="price-text">
    <ul>
        <li class="price">
            Giá:
            <span><?php echo $product->get_price_html(); ?></span>
        </li>

    </ul>
</div>
<?php }
    return ob_get_clean();
}
function woocommerce_template_single_price(){
    global $product;
    echo sago_price_html($product);
}
add_filter('woocommerce_available_variation','sago_woocommerce_available_variation', 10, 3);
function sago_woocommerce_available_variation($args, $thisC, $variation){
    $old_price_html = $args['price_html'];
    if($old_price_html){
        $args['price_html'] = sago_price_html($variation, true);
    }
    return $args;
}
//gia 0d thanh lien he
function devvn_wc_custom_get_price_html( $price, $product ) {
    if ( $product->get_price() == 0 ) {
        if ( $product->is_on_sale() && $product->get_regular_price() ) {
            $regular_price = wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $product->get_regular_price() ) );
            $price = wc_format_price_range( $regular_price, __( 'Free!', 'woocommerce' ) );
        } else {
            $price = '<span class="amount">' . __( 'Liên hệ', 'woocommerce' ) . '</span>';
        }
    }
    return $price;
}
add_filter( 'woocommerce_get_price_html', 'devvn_wc_custom_get_price_html', 10, 2 );
//rut gon tieu de san pham
add_filter( 'the_title', 'short_title_product', 10, 2 );
function short_title_product( $title, $id ) {
if (get_post_type( $id ) === 'product' & !is_single() ) {
return wp_trim_words( $title, 5 ); // thay đổi số từ bạn muốn thêm
} else {
return $title;
}
}
//nut xem them trang chi tiet san pham
add_action('wp_footer','devvn_readmore_flatsome');
function devvn_readmore_flatsome(){
    ?>
<script>
(function($) {
    $(document).ready(function() {
        $(window).on('load', function() {
            if ($('.single-product div#tab-description').length > 0) {
                var wrap = $('.single-product div#tab-description');
                var current_height = wrap.height();
                var your_height = 300;
                if (current_height > your_height) {
                    wrap.css('height', your_height + 'px');
                    wrap.append(function() {
                        return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_more"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                    });
                    wrap.append(function() {
                        return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
                    });
                    $('body').on('click', '.devvn_readmore_flatsome_more', function() {
                        wrap.removeAttr('style');
                        $('body .devvn_readmore_flatsome_more').hide();
                        $('body .devvn_readmore_flatsome_less').show();
                    });
                    $('body').on('click', '.devvn_readmore_flatsome_less', function() {
                        wrap.css('height', your_height + 'px');
                        $('body .devvn_readmore_flatsome_less').hide();
                        $('body .devvn_readmore_flatsome_more').show();
                    });
                }
            }
        });
    });
})(jQuery);
</script>
<?php
}
//themnutmuangay trang chi tiet san pham
/*
 * Add quickbuy button go to cart after click
 */
add_action('woocommerce_after_add_to_cart_button','devvn_quickbuy_after_addtocart_button');
function devvn_quickbuy_after_addtocart_button(){
    global $product;
    ?>
<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
    class="button buy_now_button alt" id="buy_now_button">
    <?php _e('Mua ngay', 'devvn'); ?>
</button>
<input type="hidden" name="is_buy_now" id="is_buy_now" value="0" />
<script>
jQuery(document).ready(function() {
    jQuery('body').on('click', '#buy_now_button', function() {
        if (jQuery(this).hasClass('disabled')) return;
        var thisParent = jQuery(this).closest('form.cart');
        jQuery('#is_buy_now', thisParent).val('1');
        thisParent.submit();
    });
});
</script>
<?php
}
add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url) {
    if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now']) {
        $redirect_url = wc_get_checkout_url();
    }
    return $redirect_url;
}
//doitextnutadtocartsanpham
// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Thêm vào giỏ', 'woocommerce' ); 
}
// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Thêm vào giỏ', 'woocommerce' );
}

//doi ten "san pham tuong tu"
add_filter("gettext", "rename_relatedproduct_text", 10, 3);
add_filter("ngettext", "rename_relatedproduct_text", 10, 3);
function rename_relatedproduct_text($translated, $text, $domain)
{
	if ($text === "Related products" && $domain === "woocommerce") {
		$translated = esc_html__("Sản phẩm liên quan", $domain);
	}
	return $translated;
}
//san pham da xem
//sanphamdaxem
function isures_set_user_visited_product_cookie()
{
    if (!is_singular('product')) {
        return;
    } 
    global $post; 
    if (empty($_COOKIE['woocommerce_recently_viewed'])) { 
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list((array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed']))); 
    }
    $keys = array_flip($viewed_products);
 
    if (isset($keys[$post->ID])) {
        unset($viewed_products[$keys[$post->ID]]);
    } 
    $viewed_products[] = $post->ID; 
    if (count($viewed_products) > 22) {
        array_shift($viewed_products);
    } 
    wc_setcookie('woocommerce_recently_viewed', implode('|', $viewed_products));
}
add_action('wp', 'isures_set_user_visited_product_cookie');
add_shortcode('isures_recently_viewed_products', 'isures_2718_prod_viewed_atts');
function isures_2718_prod_viewed_atts()
{
    ob_start();
    $viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed'])) : array();
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));      
?>
<div id="isures-recently--wrap" class="related related-products-wrapper product-section">
    <h3 class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
        <span>Sản phẩm đã xem</span>
    </h3>
    <div class="isures-container">
        <?php
            if (!empty($viewed_products)) {
               echo do_shortcode('[products type="row" limit="4" columns="4" ids="' . implode(',', $viewed_products) . '"]');
            } else {
				echo '<div class="san-pham_daxem">';
                echo 'Không có sản phẩm xem gần đây!';
				 echo '</div>';
            } 
            ?>
    </div>
</div>

<?php
    return ob_get_clean();
}
//botabdanhgia
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
unset( $tabs['reviews'] ); // Bỏ tab đánh giá
return $tabs;
}
//bocactruongthanhphoquocgiamabuudien
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_postcode']);
     unset($fields['billing']['billing_state']);
     unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_last_name']);
     unset($fields['billing']['billing_company']);
   	unset($fields['billing']['billing_city']);
    	unset($fields['billing']['billing_country']);
     return $fields;
}
//keodaitruongdiachi
add_filter('woocommerce_billing_fields', 'custom_woocommerce_billing_fields');
function custom_woocommerce_billing_fields( $fields ) {
 
     $fields['billing_address_1']['class'] = array( 'form-row-wide' );
	$fields['billing_first_name']['class'] = array( 'form-row-wide' );
 
     return $fields;
}
//shortcode sidebar trang chi tiet san pham end

//xoa bo poston blog
function flatsome_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }
 
    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( 'c' ) ),
        esc_html( get_the_modified_date() )
    );
 
    $posted_on = sprintf(
        esc_html_x( '%s', 'post date', 'flatsome' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );
 
    $byline = sprintf(
        esc_html_x( '%s', 'post author', 'flatsome' ),
        '<span class="meta-author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );
    echo '<span class="posted-on"><i class="far fa-calendar-alt"></i>' . $posted_on . '</span> | <span class="byline"><i class="fas fa-user"></i>'  . $byline . '</span>';
 
}
//them ma giam gia san pham
/* Start Button Coupon */
function btk_coupon( $atts) {
extract(shortcode_atts(array(
'link' => '',
'code' => '',
'text' => "'Sử dụng mã giảm giá này khi thanh toán để được giảm giá'",
'title' =>'',
'a' => "'"
), $atts));
return '<a href="'.$link.'" onclick=" person=prompt('.$text.','.$a.''.$code.''.$a.')" class="btkc-coupon" >'.$title.'</a>';
}
add_shortcode( 'nutgiamgia', 'btk_coupon' );
/* Link Affiliate */
function btk_link( $atts) {
extract(shortcode_atts(array(
'link' => '',
'title' =>'',
'a' => "'"
), $atts));
return '<a href="'.$link.'" class="btkc-coupon" target="_blank">'.$title.'</a>';
}
add_shortcode( 'linkgiamgia', 'btk_link' );


//SILIDER HOMEPAGE
add_action('wp_footer', function(){
	?>
<style>
.slider-col-3 .col {
    padding: 0 !important;
    width: 33.33% !important;
    opacity: 1 !important;
    -webkit-transform: scale(0.96) !important;
    transform: scale(0.96) !important;
}

@media only screen and (max-width: 600px) {
    .slider-col-3 .col {
        width: 50% !important;
    }
}
</style>
<script>
jQuery(document).ready(function($) {

    if ($('.slider-col-3').length) {
        const row = 1;
        const elems = $('.slider-col-3').find('.row');
        const wrapper = $('<div class="col" />');
        for (var i = 0; i < elems.length; i += row) {
            elems.slice(i, i + row).wrapAll(wrapper);
        }
    }
});
</script>
<?php
});
// them tiêu đề tên trang vào page neu là post và homepage thì không hiện
function flatsome_custom_title() {
    if (is_front_page() || is_singular('post') || is_singular('product') || is_tax('product-category')) {
      return;
    }
  
    echo '
      <section id="breadcrumb-title-page-all" class="breadcrumb-title-page-img">
        <div class="breadcrumb-overlay-title-page-all"></div>
          <div class="breadcrumb-content">
            <div class="wrapper">
              <div class="inner text-center">
                <div class="breadcrumb-big">
                  <h2 class="page-title">' . get_the_title() . '</h2>				
                </div>
              </div>
            </div>
          </div>
      </section>
      <div class="breadcrumbs_page-dev">
        <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
            <p><a href="https://helioz.vn/">Trang chủ</a><span class="separator"> » </span><span class="last">Đại
                    lý</span></p>
        </nav>
      </div>';
  }
  

// product for web
// Đường dẫn tới thư mục của file products.php
$products_path = get_stylesheet_directory() . '/class-functions/products.php';
// Kiểm tra xem file tồn tại trước khi chèn
if (file_exists($products_path)) {
    get_template_part('class-functions/products');
}






















?>