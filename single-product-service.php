<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main row row-main">
        <div class="large-12 col">
            <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                </header><!-- .entry-header -->
                <div class="entry-content">
                    <!-- table start-->
                    <h3>Thông số mã sản phẩm: <?php echo get_the_title(); ?></h3>
                    <table>
                        <tr>
                            <td><i class="fa-regular fa-circle-check"></i> Tỷ lệ truyền sáng</td>
                            <td><?php echo get_post_meta(get_the_ID(), 'truyen-sang', true); ?>%</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-circle-check"></i> Tỷ lệ cản UV</td>
                            <td><?php echo get_post_meta(get_the_ID(), 'chong-UV', true); ?>%</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-circle-check"></i> Tỷ lệ cản hồng ngoại</td>
                            <td><?php echo get_post_meta(get_the_ID(), 'hong-ngoai', true); ?>%</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-circle-check"></i> Tổng cản năng lượng</td>
                            <td><?php echo get_post_meta(get_the_ID(), 'tong-can', true); ?>%</td>
                        </tr>
                        <tr>
                            <td><i class="fa-regular fa-circle-check"></i> Độ dày</td>
                            <td><?php echo get_post_meta(get_the_ID(), 'do-day', true); ?>%</td>
                        </tr>
                    </table>
                    <!-- table end -->
                    <h3 class="section-title section-title-normal"><b></b><span
                            class="title-poup section-title-main">Hình ảnh sản phẩm</span><b></b></h3>
                    <div class="col-inner">
                        <div class="row row-collapse row-poup">
                            <?php 
                            $imageGallery = get_field('image-gallery'); // Lấy giá trị trường 'image-gallery' của ACF
                            if (!empty($imageGallery)) {
                                foreach ($imageGallery as $image) { ?>
                                    <div class="col medium-3 small-6 col-poup">
                                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                                    </div>
                            <?php }
                            } else { ?>
                                <span class="alert-poup">Hình ảnh đang được cập nhật</span>
                            <?php } ?>
                        </div>
                    </div>

                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-## -->
            <?php endwhile; // End of the loop. ?>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
