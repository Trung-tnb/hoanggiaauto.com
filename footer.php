<?php
/**
 * The template for displaying the footer.
 *
 * @package flatsome
 */

global $flatsome_opt;
?>

</main>

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer>

</div>

<?php wp_footer(); ?>

<script>
//text chay khung tim kiem
jQuery(document).ready(function($){
	! function(t) {
        "use strict";
        t.fn.placeholderTypewriter = function(e) {
            var n = t.extend({
                delay: 50,
                pause: 1e3,
                text: []
            }, e);
            function r(t, e) {
                t.attr("placeholder", ""),
                    function t(e, r, u, a) {
                        var i = n.text[r],
                            o = e.attr("placeholder");
                        if (e.attr("placeholder", o + i[u]), u < i.length - 1) return setTimeout(function() {
                            t(e, r, u + 1, a)
                        }, n.delay), !0;
                        a()
                    }(t, e, 0, function() {
                        setTimeout(function() {
                            ! function t(e, r) {
                                var u = e.attr("placeholder"),
                                    a = u.length;
                                if (e.attr("placeholder", u.substr(0, a - 1)), a > 1) return setTimeout(function() {
                                    t(e, r)
                                }, n.delay), !0;
                                r()
                            }(t, function() {
                                r(t, (e + 1) % n.text.length)
                            })
                        }, n.pause)
                    })
            }
            return this.each(function() {
                r(t(this), 0)
            })
        }
    }(jQuery);

    var placeholderText = ['Bạn muốn tìm gì?', 'Phim cách nhiệt Ô tô?', 'Phim cách nhiệt công trình nhà kính', 'Bảng giá dán phim cách nhiệt'];
    $('.search-field').placeholderTypewriter({
        text: placeholderText
    });
    //]csc]>
  var body = $( 'body' );
});

    //<![CDATA[
</script>

</body>
</html>

