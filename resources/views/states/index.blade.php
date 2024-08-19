@extends("layout.index")
@section("title", "Estados")

@section("content")

@if (session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

@if (session('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif

<!-- Botón para abrir el modal de agregar -->
<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Estado</button>

<table class="table table-hover mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Ciudad ID</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($states as $state)
        <tr>
            <td>{{ $state->id }}</td>
            <td>{{ $state->name }}</td>
            <td>{{ $state->country_id }}</td>
            <td>
                <!-- Botones para abrir los modales de ver, editar, eliminar -->
                <button class="btn btn-info" data-toggle="modal" data-target="#viewModal" data-id="{{ $state->id }}">View</button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" data-id="{{ $state->id }}">Edit</button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $state->id }}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Agregar -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Agregar Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('states.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Campos para agregar estado -->
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="country_id">Ciudad ID</label>
                        <input type="text" class="form-control" id="country_id" name="country_id" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detalles del Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="view-name">Nombre:</label>
                    <input type="text" class="form-control" id="view-name" readonly>
                </div>
                <div class="form-group">
                    <label for="view-country_id">Ciudad ID:</label>
                    <input type="text" class="form-control" id="view-country_id" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="PUT">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <!-- Campos para editar estado -->
                    <div class="form-group">
                        <label for="edit-name">Nombre</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-country_id">Ciudad ID</label>
                        <input type="text" class="form-control" id="edit-country_id" name="country_id" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Eliminar Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este estado? Esto realizará un borrado lógico.</p>
                <form id="deleteForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="delete-id" name="id" value="">
                    <input type="hidden" id="delete-status" name="status" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#viewModal, #editModal, #deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('#delete-id').val(id);

            if (modal.attr('id') === 'viewModal') {
                axios.get('/estados/' + id)
                    .then(function(response) {
                        var data = response.data;
                        modal.find('#view-name').val(data.name);
                        modal.find('#view-country_id').val(data.country_id);
                    })
                    .catch(function(error) {
                        console.error('Error al cargar los datos:', error);
                    });
            } else if (modal.attr('id') === 'editModal') {
                axios.get('/estados/' + id)
                    .then(function(response) {
                        var data = response.data;
                        modal.find('#edit-id').val(data.id);
                        modal.find('#edit-name').val(data.name);
                        modal.find('#edit-country_id').val(data.country_id);
                    })
                    .catch(function(error) {
                        console.error('Error al cargar los datos para edición:', error);
                    });

                $('#editForm').on('submit', function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var formData = form.serialize();
                    var id = modal.find('#edit-id').val();
                    var url = '/estados/actualizar/' + id;

                    axios.put(url, formData)
                        .then(function(response) {
                            $('#editModal').modal('hide');
                            location.reload();
                        })
                        .catch(function(error) {
                            console.error('Error al actualizar el estado:', error);
                        });
                });
            } else if (modal.attr('id') === 'deleteModal') {
                $('#confirmDelete').on('click', function() {
                    console.log('ID para eliminar:', $('#delete-id').val());
                    var id = $('#delete-id').val();
                    var status = $('#delete-status').val();
                    var url = '/estados/status';

                    axios.put(url, {
                            id: id,
                            status: status
                        })
                        .then(function(response) {
                            $('#deleteModal').modal('hide');
                            location.reload();
                        })
                        .catch(function(error) {
                            console.error('Error al eliminar el estado:', error);
                        });
                });
            }
        });
    });
</script>
@endsection