// jQuery ($), Swal y bootstrap ya están cargados de forma global por el layout.

$(function () {
    cargarProductos();

    // Botón "Editar": llena el modal con los datos del producto
    $(document).on("click", ".editar", function () {
        let id = $(this).data("id");
        let producto = $(this).data("producto");
        let categoria = $(this).data("categoria");
        let precio = $(this).data("precio");
        let stock = $(this).data("stock");

        $("#staticBackdropLabel").text("Editar Producto");
        $("#idproducto").val(id);
        $("#producto").val(producto);
        $("#categoria").val(categoria);
        $("#precio").val(precio);
        $("#stock").val(stock);
    });

    // Botón "Añadir": limpia el modal
    $(document).on("click", '[data-bs-target="#staticBackdrop"]', function () {
        if (!$(this).hasClass("editar")) {
            limpiarForm();
        }
    });

    // Al cerrar el modal (Cancelar o X) también se limpia el formulario
    $("#staticBackdrop").on("hidden.bs.modal", function () {
        limpiarForm();
    });
});

// -------------------------------------------------------------------------------------------------------------
function peticionAjax(url, met, datos = {}) {
    return $.ajax({
        url: url,
        method: met,
        data: datos,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}

// Limpia todos los campos del formulario
function limpiarForm() {
    $(".productosForm")[0].reset();
    $("#idproducto").val("");
    $("#staticBackdropLabel").text("Añadir Producto");
}

// Muestra una alerta con SweetAlert
function mensajeAlert(titulo, texto, icono) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icono,
    });
}

// Trae los productos del servidor y arma las filas de la tabla
function cargarProductos() {
    peticionAjax("/productos/obtenerProductos", "GET").done((res) => {
        let productos = res.productos;
        let html = "";
        productos.forEach((producto) => {
            html += `<tr>
                <td>${producto.idProductos}</td>
                <td>${producto.productos}</td>
                <td>${producto.categoria}</td>
                <td>${producto.precio}</td>
                <td>${producto.stock}</td>
                <td>
                    <button class="btn btn-danger btn-sm eliminar" data-id="${producto.idProductos}">Eliminar</button>
                    <button class="btn btn-primary btn-sm editar"
                        data-id="${producto.idProductos}"
                        data-producto="${producto.productos}"
                        data-categoria="${producto.categoria}"
                        data-precio="${producto.precio}"
                        data-stock="${producto.stock}"
                        data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">Editar</button>
                </td>
            </tr>`;
        });
        $(".productosTable tbody").html(html);
    });
}

// Eliminar (con confirmación)
$(document).on("click", ".eliminar", function (e) {
    e.preventDefault();
    let id = $(this).data("id");

    Swal.fire({
        title: "¿Eliminar producto?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
    }).then((result) => {
        if (!result.isConfirmed) return;

        peticionAjax(`/productos/${id}`, "DELETE").done((res) => {
            cargarProductos();
            mensajeAlert("Eliminado", res.message, "success");
        });
    });
});

// Guardar: si hay id es editar (PUT), si no es crear (POST)
$(document).on("submit", ".productosForm", function (e) {
    e.preventDefault();
    let form = $(".productosForm").serialize();
    let id = $("#idproducto").val();

    let url = id ? `/productos/${id}` : "/productos";
    let met = id ? "PUT" : "POST";

    peticionAjax(url, met, form)
        .done((res) => {
            if (res.success) {
                cargarProductos();
                limpiarForm();

                let modalEl = document.getElementById("staticBackdrop");
                let modal =
                    bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);
                modal.hide();

                mensajeAlert("¡Buen trabajo!", res.message, "success");
            }
        })
        .fail((xhr) => {
            mensajeAlert("Error", xhr.responseJSON.message, "error");
        });
});
