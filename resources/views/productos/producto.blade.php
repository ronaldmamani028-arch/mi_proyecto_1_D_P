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
        <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="mdi mdi-plus"></i> Añadir Producto
        </button>
    </div>

    <div class="table-responsive">
    <table class="table table-hover productosTable">
        <thead>
            <tr>
                <th scope="col">N°</th>
                <th scope="col">Producto</th>
                <th scope="col">Categoría</th>
                <th scope="col">Precio</th>
                <th scope="col">Stock</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Se llena con AJAX desde resources/js/productos.js --}}
        </tbody>
    </table>
    </div>
</div>
</div>

@include('productos.formulario')

@endsection

@push('scripts')
    @vite(['resources/js/productos.js'])
@endpush
