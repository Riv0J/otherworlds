@extends('layout.masterpage')

@section('title')
    Database | Admin {{ config('app.name') }}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')
<form id="upload-form" action="{{ route('database_upload') }}" method="POST" enctype="multipart/form-data" class="d-none">
    @csrf
    <input type="file" id="backup-file" name="backup" accept=".sql" required>
</form>

<section class="wrapper col-12 col-lg-10">
    <div class="title">
        <div class="text">
            <i class="fa-solid fa-database"></i>
            <h3>Database</h3>
        </div>
        <nav class="buttons">
            <!-- Botón para descargar el backup -->
            <button class="button info" onclick="location='{{ route('database_download') }}'">
                <i class="fa-solid fa-download"></i>
                <span>Download Backup</span>
            </button>

            <!-- Botón para subir el backup -->
            <button class="button info" id="upload-button">
                <i class="fa-solid fa-upload"></i>
                <span>Upload Backup</span>
            </button>
        </nav>
    </div>

    <h2>Warning!</h2>
    <p>Please save a backup before making any changes!</p>
</section>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadButton = document.getElementById('upload-button');
        const backupFileInput = document.getElementById('backup-file');
        const uploadForm = document.getElementById('upload-form');

        // Al hacer clic en el botón "Upload Backup", abrir el selector de archivos
        uploadButton.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar que se envíe el formulario
            backupFileInput.click(); // Simular clic en el input file
        });

        // Al seleccionar un archivo, enviar el formulario automáticamente
        backupFileInput.addEventListener('change', function() {
            if (backupFileInput.files.length > 0) {
                uploadForm.submit(); // Enviar el formulario
            }
        });
    });
</script>
@endsection
