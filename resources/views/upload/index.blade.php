@extends("layout.index")
@section("title", "Estados")

@section("content")
<div class="container mt-4">
    <h2>Subir Archivo de Insert Statements</h2>
    <form action="{{ route('archivo.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Selecciona el archivo:</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir Archivo</button>
    </form>
</div>

@endsection
