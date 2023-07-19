<?php
/**
 * Template Name: Products Page
 *
 * This template can be used to display a page that shows a list of products or services.
 *
 * @package Flatsome
 */

 get_header(); ?>

<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'product-service',
    'posts_per_page' => 10,
    'paged' => $paged
);
$custom_query = new WP_Query( $args );
if ( $custom_query->have_posts() ) :
?>
<div class="row large-columns-4 medium-columns-3 small-columns-2 row-xsmall product-service_dev ">
    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
    <div class="col post-item">
        <div class="col-inner col-box_dev">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="article-inner <?php flatsome_blog_article_classes(); ?>">
                    <div class="post-thumbnail">
                        <div class="box box-bounce box-text-bottom box-blog-post has-hover">
                            <div class="box-image">
                                <div class="circle-product">
                                    <span class="item"><i class="fa-solid fa-user-shield"></i></span>
                                    <span class="item"><i class="fa-brands fa-windows"></i></span>
                                    <span class="item"><i class="fa-solid fa-eye"></i></span>
                                </div>
                                    <span class="archive-item-dev">
                                        <?php
                                        $terms = get_the_term_list(get_the_ID(), 'product-category', '', ' | ', '');
                                        echo $terms;
                                        ?>
                                    </span>
                                <div class="image-zoom image-cover">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( array(300, 600) ); ?>
                                    <?php else : ?>
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/screenshot.png'; ?>"
                                        alt="Logo">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="box-text">
                                <div class="box-text-inner blog-post-inner">
                                    <h4 class="post-title is-large"><?php the_title(); ?></h4>
                                    <div class="info_product_article">
                                        <p>Độ truyền sáng</p>
                                        <div class="value-range">
                                            <?php $truyen_sang = get_field('truyen-sang', get_the_ID()); ?>
                                            <input id="truyen-sang" type="range" min="1" max="100" step="1"
                                                value="<?php echo $truyen_sang; ?>" readonly onmousedown="return false;"
                                                onkeydown="return false;" />
                                            <span class="text-value-range"><?php echo $truyen_sang; ?>%</span>
                                        </div>
                                        <p>Tổng cản năng lượng</p>
                                        <div class="value-range">
                                            <?php $tong_can = get_field('tong-can', get_the_ID()); ?>
                                            <input id="tong-can" type="range" min="1" max="100" step="1"
                                                value="<?php echo $tong_can; ?>" readonly onmousedown="return false;"
                                                onkeydown="return false;" />
                                            <span class="text-value-range"><?php echo $tong_can; ?>%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-box">
                                    <button class="button alert is-outline mb-0 view-details"
                                        data-id="<?php echo get_the_ID(); ?>">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                    </div>

            </article>
        </div>
    </div>
    <?php endwhile; ?>
    <!-- Pagination -->
    <div class="pagination-wrapper">
        <?php
    echo paginate_links( array(
        'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var( 'paged' ) ),
        'total' => $custom_query->max_num_pages,
        'prev_text' => '<i class="fa-solid fa-angle-left"></i>',
        'next_text' => '<i class="fa-solid fa-angle-right"></i>',
    ) );
    ?>
    </div>
</div>
<?php endif; wp_reset_postdata(); ?>

<!-- Hien thi poup san pham star -->
<div class="popup-wrapper">
    <div class="popup-content-product">
        <div class="popup-header">
            <a class="close-popup-product resetform"><i class="fa-solid fa-xmark"></i></a>
            <h4>Thông tin chi tiết sản phẩm</h4>
        </div>
        <div class="popup-body">
            <div class="product-details"></div>
        </div>
        <div class="popup-footer">
            <a href="tel:0932061699" class="button button order-now">
                <i class="fa-solid fa-phone"></i> Liên hệ
            </a>
            <a href="https://zalo.me/0966660170" class="button order-now  zalo-button">
                <img src="http://vixsunfilm.com/wp-content/uploads/2023/06/zalo-01.svg" alt="Zalo Icon"
                    class="zalo-icon">
                Tư vấn Zalo
            </a>
        </div>
    </div>
</div>
<!-- Hien thi poup san pham end-->
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/product-service.js"></script>
<script type="text/javascript">
var urlajax = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
</script>
<?php get_footer(); ?>