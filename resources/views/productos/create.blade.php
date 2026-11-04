@extends('layouts.principal')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-plus-box"></i>
        </span> Registrar Producto
    </h3>
</div>

<div class="card" style="max-width: 600px;">
<div class="card-body">
    <h4 class="card-title">Nuevo Producto</h4>

    <form class="forms-sample" action="{{ route('productos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre del Producto:</label>
            <input type="text" name="productos" class="form-control" maxlength="20" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría:</label>
            <input type="text" name="categoria" class="form-control" maxlength="30" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock:</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gradient-primary">Ingresar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-light">Cancelar</a>
        </div>
    </form>
</div>
</div>
@endsection