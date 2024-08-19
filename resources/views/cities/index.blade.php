@extends("layout.index")
@section("title", "Ciudades")

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
<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar País</button>

<table class="table table-hover mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>State_id</th>
            <th>IsCapital</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cities as $city)
        <tr>
            <td>{{ $city->id }}</td>
            <td>{{ $city->name }}</td>
            <td>{{ $city->state_id }}</td>
            <td>{{ $city->isCapital }}</td>
            <td>{{ $city->status }}</td>
            <td>
                <!-- Botones para abrir los modales de ver, editar, eliminar -->
                <button class="btn btn-info" data-toggle="modal" data-target="#viewModal" data-id="{{ $city->id }}">View</button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" data-id="{{ $city->id }}">Edit</button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $city->id }}">Delete</button>
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
                <h5 class="modal-title" id="addModalLabel">Agregar País</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('cities.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Campos para agregar país -->
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="state_id">ID Estado</label>
                        <input type="text" class="form-control" id="state_id" name="state_id" required>
                    </div>
                    <div class="form-group">
                        <label for="isCapital">isCapital</label>
                        <select class="form-control" id="isCapital" name="isCapital" required>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Estado</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
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
                <h5 class="modal-title" id="viewModalLabel">Detalles de la Ciudad</h5>
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
                    <label for="view-state_id">ID_Estado:</label>
                    <input type="text" class="form-control" id="view-state_id" readonly>
                </div>
                <div class="form-group">
                    <label for="view-isCapital">IsCapital:</label>
                    <input type="text" class="form-control" id="view-isCapital" readonly>
                </div>
                <div class="form-group">
                    <label for="view-status">Estado:</label>
                    <input type="text" class="form-control" id="view-status" readonly>
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
                <h5 class="modal-title" id="editModalLabel">Editar País</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT') <!-- Método PUT para actualizar -->
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <!-- Campos para editar ciudad -->
                    <div class="form-group">
                        <label for="edit-name">Nombre</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-state_id">ID Estado</label>
                        <input type="number" class="form-control" id="edit-state_id" name="state_id" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-isCapital">¿Es Capital?</label>
                        <select class="form-control" id="edit-isCapital" name="isCapital" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
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
                <h5 class="modal-title" id="deleteModalLabel">Eliminar País</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este país? Esto realizará un borrado lógico.</p>
                <form id="deleteForm">
                    @csrf
                    @method('PUT') <!-- Método PUT necesario para Laravel -->
                    <input type="hidden" id="delete-id" name="id" value="">
                    <input type="hidden" id="delete-status" name="status" value="1"> <!-- Estado predeterminado para desactivar -->
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

            var button = $(event.relatedTarget); // Botón que disparó el modal
            var id = button.data('id'); // Extraer el ID del atributo data-id
            var modal = $(this);
            modal.find('#delete-id').val(id);

            if (modal.attr('id') === 'viewModal') {
                // Usar Axios para hacer la solicitud
                axios.get('/ciudades/' + id)
                    .then(function(response) {
                        var data = response.data;

                        // Imprimir los datos en la consola


                        // Llenar los campos del modal con los datos obtenidos
                        modal.find('#view-name').val(data.name);
                        modal.find('#view-state_id').val(data.state_id);
                        modal.find('#view-isCapital').val(data.isCapital);
                        modal.find('#view-status').val(data.status);
                    })
                    .catch(function(error) {
                        console.error('Error al cargar los datos:', error);
                        modal.find('.modal-content').html('<p>Error al cargar los datos</p>');
                    });
            } else if (modal.attr('id') === 'editModal') {
                // Cargar datos para editar
                axios.get('/ciudades/' + id)
                    .then(function(response) {
                        var data = response.data;
                        console.log('Datos de edición:', data);

                        modal.find('#edit-id').val(data.id);
                        modal.find('#edit-name').val(data.name);
                        modal.find('#edit-state_id').val(data.state_id);
                        modal.find('#edit-isCapital').val(data.isCapital);
                    })
                    .catch(function(error) {
                        console.error('Error al cargar los datos para edición:', error);
                    });

                // Manejar la actualización de la ciudad
                $('#editForm').on('submit', function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var formData = form.serialize();
                    var id = modal.find('#edit-id').val(); // Obtener el ID del campo oculto
                    var url = '/ciudades/actualizar/' + id; // URL para la actualización

                    axios.put(url, formData)
                        .then(function(response) {
                            $('#editModal').modal('hide');
                            location.reload(); // Recargar la página para ver los cambios
                        })
                        .catch(function(error) {
                            console.error('Error al actualizar la ciudad:', error);
                        });
                });
            } else if (modal.attr('id') === 'deleteModal') {
                $('#confirmDelete').on('click', function() {
                    var id = $('#delete-id').val();
                    var status = $('#delete-status').val(); // Aquí se establece el valor de estado (0 para desactivar)
                    var url = '/ciudades/status'; // URL para el método status

                    axios.put(url, {
                            id: id,
                            status: status
                        })
                        .then(function(response) {
                            if (response.data.response === 1) {
                                $('#deleteModal').modal('hide');
                                location.reload(); // Recargar la página para ver los cambios
                                alert(response.data.message); // Mostrar mensaje de éxito
                            } else {
                                alert(response.data.message); // Mostrar mensaje de error
                            }
                        })
                        .catch(function(error) {
                            console.error('Error al eliminar la Ciudad:', error);
                            alert('Error al eliminar la Ciudad'); // Mostrar mensaje de error
                        });
                });
            }
        });

    });
</script>
@endsection