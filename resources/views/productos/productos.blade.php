@extends('layouts.principal')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-cart"></i>
        </span> Productos
    </h3>
</div>

<div class="card">
<div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="card-title mb-0">Lista de Productos</h4>
        <button type="button" class="btn btn-gradient-primary" onclick="abrirModalIngresar()">
            <i class="mdi mdi-plus"></i> Añadir Producto
        </button>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th class="text-center">N°</th>
                <th>Productos</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $prod)
                <tr>
                    <td class="text-center">{{ $prod->idProductos }}</td>
                    <td>{{ $prod->productos }}</td>
                    <td>{{ $prod->categoria }}</td>
                    <td>S/ {{ number_format($prod->precio, 2) }}</td>
                    <td>{{ $prod->stock }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-gradient-warning"
                            onclick="abrirModalEditar({{ $prod->idProductos }}, @js($prod->productos), {{ $prod->precio }}, @js($prod->categoria), {{ $prod->stock }})">Editar</button>
                        <button type="button" class="btn btn-sm btn-gradient-danger"
                            onclick="confirmarEliminar({{ $prod->idProductos }})">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>

<!-- Formulario oculto para la ruta store -->
<form id="form-crear-producto" class="productosform" action="{{ route('productos.store') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="productos" id="input-productos">
    <input type="hidden" name="precio" id="input-precio">
    <input type="hidden" name="categoria" id="input-categoria">
    <input type="hidden" name="stock" id="input-stock">
</form>

<!-- Formulario oculto para editar (update) -->
<form id="form-editar-producto" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="productos" id="edit-productos">
    <input type="hidden" name="precio" id="edit-precio">
    <input type="hidden" name="categoria" id="edit-categoria">
    <input type="hidden" name="stock" id="edit-stock">
</form>

<!-- Formulario oculto para eliminar (destroy) -->
<form id="form-eliminar-producto" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
const urlBaseProductos = "{{ url('productos') }}";

function abrirModalEditar(id, nombre, precio, categoria, stock) {
    Swal.fire({
        title: '<strong>Editar Producto</strong>',
        html: `
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Producto:</label>
                <input id="swal-producto" class="form-control">
            </div>
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Precio:</label>
                <input id="swal-precio" type="number" step="0.01" class="form-control">
            </div>
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Categoría:</label>
                <input id="swal-categoria" class="form-control">
            </div>
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Stock:</label>
                <input id="swal-stock" type="number" class="form-control">
            </div>
        `,
        didOpen: () => {
            document.getElementById('swal-producto').value = nombre;
            document.getElementById('swal-precio').value = precio;
            document.getElementById('swal-categoria').value = categoria;
            document.getElementById('swal-stock').value = stock;
        },
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        focusConfirm: false,
        preConfirm: () => {
            const prod = document.getElementById('swal-producto').value;
            const prec = document.getElementById('swal-precio').value;
            const cat = document.getElementById('swal-categoria').value;
            const stk = document.getElementById('swal-stock').value;

            if (!prod || !prec || !cat || !stk) {
                Swal.showValidationMessage('Todos los campos son obligatorios');
                return false;
            }
            return { productos: prod, precio: prec, categoria: cat, stock: stk };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('form-editar-producto');
            form.action = urlBaseProductos + '/' + id;
            document.getElementById('edit-productos').value = result.value.productos;
            document.getElementById('edit-precio').value = result.value.precio;
            document.getElementById('edit-categoria').value = result.value.categoria;
            document.getElementById('edit-stock').value = result.value.stock;
            form.submit();
        }
    });
}

function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Eliminar producto?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('form-eliminar-producto');
            form.action = urlBaseProductos + '/' + id;
            form.submit();
        }
    });
}

function abrirModalIngresar() {
    Swal.fire({
        title: '<strong>Productos</strong>',
        html: `
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Producto:</label>
                <input id="swal-producto" class="form-control" placeholder="Nombre del producto">
            </div>
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Precio:</label>
                <input id="swal-precio" type="number" step="0.01" class="form-control" placeholder="0.00">
            </div>
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Categoría:</label>
                <input id="swal-categoria" class="form-control" placeholder="Categoría">
            </div>
            <div class="text-start mb-3">
                <label class="form-label fw-semibold">Stock:</label>
                <input id="swal-stock" type="number" class="form-control" placeholder="0">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Ingresar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        focusConfirm: false,
        preConfirm: () => {
            const prod = document.getElementById('swal-producto').value;
            const prec = document.getElementById('swal-precio').value;
            const cat = document.getElementById('swal-categoria').value;
            const stk = document.getElementById('swal-stock').value;

            if (!prod || !prec || !cat || !stk) {
                Swal.showValidationMessage('Todos los campos son obligatorios');
                return false;
            }
            return { productos: prod, precio: prec, categoria: cat, stock: stk };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('input-productos').value = result.value.productos;
            document.getElementById('input-precio').value = result.value.precio;
            document.getElementById('input-categoria').value = result.value.categoria;
            document.getElementById('input-stock').value = result.value.stock;
            
            document.getElementById('form-crear-producto').requestSubmit();
        }
    });
}
</script>
@endsection