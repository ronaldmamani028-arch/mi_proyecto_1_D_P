import $ from 'jquery';
import Swal from 'sweetalert2';

$(document).on('submit', '.productosform', function (e) {
    e.preventDefault();
    const form = $(this).serialize();
    $.ajax({
        url: '/productos',
        method: 'POST',
        data: form,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done((res) => {
        console.log(res);
        Swal.fire({
            title: '¡Buen trabajo!',
            text: res.mensaje,
            icon: 'success',
            confirmButtonColor: '#b66dff'
        }).then(() => {
            location.reload();
        });
    });
});
