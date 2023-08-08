$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loadMore()
{
    const page = $('#page').val();
    // gọi đến serve
    $.ajax({
        type: 'POST',
        datatype: 'JSON',
        data: {page},
        url:'/services/load-product', // trỏ đường dẫn về route
        success:function (result){
            if (result.html != '') {
                $('#loadProduct').append(result.html);
                $('#page').val(page + 1);
            } else {
                alert('Đã load xong Sản Phẩm!');
                $('#button-loadMore').css('display', 'none')//ẩn nút loadMore
            }
        }
    })
}
