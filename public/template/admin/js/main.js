$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function  removeRow(id, url) {
    if (confirm('Xóa mà không thể khôi phục. Bạn có chắc ?')) {
        $.ajax({
            type: 'DELETE',
            datatype: 'JSON',
            data: {id},
            url: url,
            success: function (result) {
                // nếu kết quả trả về đúng
                if (result.error == false) {
                    alert(result.message);//hiển thị tin nhắn thông báo kết quả
                    location.reload();//load lại trang
                } else {
                    alert('Xóa lỗi vui lòng thử lại');
                }
            }
        })
    }
}


    // Upload File
$('#upload').change(function (){
   const form = new FormData();
   form.append('file', $(this)[0].files[0]);

   $.ajax({
       processData: false,
       contentType: false,
       type: 'POST',
       datatype: 'JSON',
       data: form,
       url: '/admin/upload/services',
       success: function (results) {
           // console.log(results)
           if (results.error == false) {
               $('#image_show').html('<a href="' + results.url + '" target="_blank">' +
                    '<img src="' + results.url + '" width="100px"></a>')
               // update dữ liệu lên serve để lưu vào file
               $('#thumb').val(results.url);
           } else {
               alert('Upload File Lỗi');
           }
       }
   });
});
