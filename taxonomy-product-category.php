<?php get_header(); ?>
<section id="breadcrumb-title-page-all" class="breadcrumb-title-page-img">
    <div class="breadcrumb-overlay-title-page-all"></div>
    <div class="breadcrumb-content">
        <div class="wrapper">
            <div class="inner text-center">
                <div class="breadcrumb-big">
                    <h2 class="page-title">Danh mục:
                        <?php
                if (is_tax('product-category')) {
                  single_term_title();
                } else {
                  echo get_the_title();
                }
              ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="breadcrumbs_page-dev">
    <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
        <p><a href="/">Trang chủ</a><span class="separator"> » </span><span class="last"><?php
                if (is_tax('product-category')) {
                  single_term_title();
                } else {
                  echo get_the_title();
                }
              ?></span></p>
    </nav>
</div>
<div class="content-area page-wrapper">
    <div class="container">
        <div class="row large-columns-4 medium-columns-3 small-columns-2 row-xsmall product-service_dev">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
                                                        value="<?php echo $truyen_sang; ?>" readonly
                                                        onmousedown="return false;" onkeydown="return false;" />
                                                    <span class="text-value-range"><?php echo $truyen_sang; ?>%</span>
                                                </div>
                                                <p>Tổng cản năng lượng</p>
                                                <div class="value-range">
                                                    <?php $tong_can = get_field('tong-can', get_the_ID()); ?>
                                                    <input id="tong-can" type="range" min="1" max="100" step="1"
                                                        value="<?php echo $tong_can; ?>" readonly
                                                        onmousedown="return false;" onkeydown="return false;" />
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
            <?php endwhile; endif; ?>
        </div>
        <?php the_posts_pagination(); ?>
    </div>

    <!-- Các phần còn lại của mã HTML -->
    <!-- Hien thi poup san pham star -->
    <div class="popup-wrapper">
        <div class="popup-content-product">
            <div class="popup-header">
                <a href="#" class="close-popup-product resetform"><i class="fa-solid fa-xmark"></i></a>
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
</div>
<?php get_footer(); ?>