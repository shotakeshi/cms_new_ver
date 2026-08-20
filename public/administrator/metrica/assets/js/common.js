(function ($) {
    'use strict';
    const elementOverlay = $('#ajax-overlay')
    $.ajaxSetup({
        beforeSend: function () {
            elementOverlay.fadeIn();
            elementOverlay.css('display', 'grid')
        },
        complete: function () {
            elementOverlay.fadeOut();
        },
        error: function (xhr, status, error) {
            elementOverlay.fadeOut();
        }
    });

})(jQuery)


function confirmDelete(id, url) {
    swal.fire({
        title: translations.notification['delete_fail_with_admin_used'],
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _method: "DELETE",
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Thành công!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // remove row
                        $("#row-" + id + ", #row-position-" + id).remove();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi!",
                            text: response.message,
                            showConfirmButton: true
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: "Đã xảy ra lỗi khi xóa!",
                        showConfirmButton: true
                    });
                }
            });
        } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swal.fire(
                'Cancelled',
                'Dữ liệu của bạn được an toàn',
                'error'
            )
        }
    });
}
