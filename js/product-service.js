jQuery(document).ready(function($) {
  var productTitle = ''; // Khởi tạo biến để lưu tiêu đề sản phẩm

  $('.view-details').click(function(event) {
    event.preventDefault();
    var post_id = $(this).data('id');
    productTitle = $(this).data('title'); // Lưu tiêu đề sản phẩm vào biến productTitle của button

    // Lấy thông tin chi tiết sản phẩm theo productId và hiển thị nó trong popup
    $.ajax({
      url: ajax_object.ajaxurl,
      type: 'post',
      data: {
        action: 'get_product_details',
        post_id: post_id
      },
      success: function(response) {
        // Hiển thị popup và làm bất kỳ xử lý nào khác ở đây
        $('.product-details').html(response);
        $('.popup-wrapper').fadeIn(function() {
          // Gán giá trị của productTitle vào input product_service_name
          $('#product_service_name.product-service-name').val(productTitle);
        });
      },
      error: function() {
        // Xử lý lỗi nếu có
      }
    });
  });

  $('.close-popup-product').on('click', function(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định khi click vào nút đóng popup
    // Đóng popup một cách mượt mà
    $('.popup-wrapper').fadeOut(function() {
      // Sau khi đóng popup, reset giá trị của form về trạng thái ban đầu
      $('.popup-content-product form').trigger('reset');
    });
  });
});
