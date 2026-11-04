<div class="modal fade modalProductosEditar" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Añadir Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="productosForm">
                    @csrf
                    <input type="hidden" name="idproducto" id="idproducto">
                    <div class="mb-3">
                        <label class="form-label">Producto:</label>
                        <input type="text" name="productos" id="producto" class="form-control" maxlength="20" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría:</label>
                        <input type="text" name="categoria" id="categoria" class="form-control" maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio:</label>
                        <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock:</label>
                        <input type="number" name="stock" id="stock" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
