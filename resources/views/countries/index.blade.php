@extends("layout.index")
@section("title", "Paises")

@section("content")

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif

@if (session('error'))
<script>
    toastr.error("{{ session('error') }}");
</script>
@endif





<!-- Botón para abrir el modal de agregar -->
<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar País</button>

<table class="table table-hover mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Continent</th>
            <th>Population</th>
            <th>Language</th>
            <th>Currency</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($countries as $country)
        <tr>
            <td>{{ $country->id }}</td>
            <td>{{ $country->name }}</td>
            <td>{{ $country->continent }}</td>
            <td>{{ $country->population }}</td>
            <td>{{ $country->language }}</td>
            <td>{{ $country->currency }}</td>
            <td>{{ $country->status }}</td>
            <td>
                <!-- Botones para abrir los modales de ver, editar, eliminar -->
                <button class="btn btn-info" data-toggle="modal" data-target="#viewModal" data-id="{{ $country->id }}">View</button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" data-id="{{ $country->id }}">Edit</button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $country->id }}">Delete</button>
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
            <form action="{{ route('countries.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Campos para agregar país -->
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="continent">Continente</label>
                        <input type="text" class="form-control" id="continent" name="continent" required>
                    </div>
                    <div class="form-group">
                        <label for="population">Poblacion</label>
                        <input type="text" class="form-control" id="population" name="population" required>
                    </div>
                    <div class="form-group">
                        <label for="language">Idioma</label>
                        <input type="text" class="form-control" id="language" name="language" required>
                    </div>
                    <div class="form-group">
                        <label for="currency">Moneda</label>
                        <input type="text" class="form-control" id="currency" name="currency" required>
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
                <h5 class="modal-title" id="viewModalLabel">Detalles del País</h5>
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
                    <label for="view-continent">Continente:</label>
                    <input type="text" class="form-control" id="view-continent" readonly>
                </div>
                <div class="form-group">
                    <label for="view-continent">Poblacion:</label>
                    <input type="text" class="form-control" id="view-population" readonly>
                </div>
                <div class="form-group">
                    <label for="view-language">Idioma:</label>
                    <input type="text" class="form-control" id="view-language" readonly>
                </div>
                <div class="form-group">
                    <label for="view-currency">Moneda:</label>
                    <input type="text" class="form-control" id="view-currency" readonly>
                </div>
                <div class="form-group">
                    <label for="view-status">Estado:</label>
                    <input type="text" class="form-control" id="view-status" readonly>
                </div>
                <!-- Añade más campos si es necesario -->
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
                @method('PUT') <!-- Se usa PUT para la actualización -->
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <!-- Campos para editar país -->
                    <div class="form-group">
                        <label for="edit-name">Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-continent">Continent</label>
                        <input type="text" class="form-control" id="edit-continent" name="continent" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-continent">Population</label>
                        <input type="text" class="form-control" id="edit-population" name="population" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-language">Language</label>
                        <input type="text" class="form-control" id="edit-language" name="language" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-currency">Currency</label>
                        <input type="text" class="form-control" id="edit-currency" name="currency" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-status">Status</label>
                        <select class="form-control" id="edit-status" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
                axios.get('/paises/' + id)
                    .then(function(response) {
                        var data = response.data;

                        // Imprimir los datos en la consola


                        // Llenar los campos del modal con los datos obtenidos
                        modal.find('#view-name').val(data.name);
                        modal.find('#view-continent').val(data.continent);
                        modal.find('#view-population').val(data.population);
                        modal.find('#view-language').val(data.language);
                        modal.find('#view-currency').val(data.currency);
                        modal.find('#view-status').val(data.status);
                    })
                    .catch(function(error) {
                        console.error('Error al cargar los datos:', error);
                        modal.find('.modal-content').html('<p>Error al cargar los datos</p>');
                    });
            } else if (modal.attr('id') === 'editModal') {
                // Cargar datos para editar
                axios.get('/paises/' + id)
                    .then(function(response) {
                        var data = response.data;

                        console.log('Datos de edición:', data);

                        modal.find('#edit-id').val(data.id);
                        modal.find('#edit-name').val(data.name);
                        modal.find('#edit-continent').val(data.continent);
                        modal.find('#edit-population').val(data.population);
                        modal.find('#edit-language').val(data.language);
                        modal.find('#edit-currency').val(data.currency);
                        modal.find('#edit-status').val(data.status);
                    })
                    .catch(function(error) {
                        console.error('Error al cargar los datos para edición:', error);
                    });


                // Manejar la actualización del país
                $('#editForm').on('submit', function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var formData = form.serialize();
                    var id = modal.find('#edit-id').val(); // Obtener el ID del campo oculto
                    var url = '/paises/actualizar/' + id; // URL para la actualización

                    axios.put(url, formData)
                        .then(function(response) {
                            $('#editModal').modal('hide');
                            location.reload(); // Recargar la página para ver los cambios
                        })
                        .catch(function(error) {
                            console.error('Error al actualizar el país:', error);
                        });
                });
            } else if (modal.attr('id') === 'deleteModal') {
                $('#confirmDelete').on('click', function() {
                    var id = $('#delete-id').val();
                    var status = $('#delete-status').val(); // Aquí se establece el valor de estado (0 para desactivar)
                    var url = '/paises/status'; // URL para el método status

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
                            console.error('Error al eliminar el país:', error);
                            alert('Error al eliminar el país.'); // Mostrar mensaje de error
                        });
                });

            }
        });

    });
</script>
@endsection