@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.commands') | Admin {{ config('app.name') }}
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
            <i class="fa-solid fa-terminal"></i>
            <h3>@lang('otherworlds.commands')</h3>
        </div>
        <nav class="buttons">
            <button class="button info" onclick="location='{{ route('database_download') }}'">
                <i class="fa-solid fa-download"></i>
                <span>Download Backup</span>
            </button>

            <button class="button info" id="upload-button">
                <i class="fa-solid fa-upload"></i>
                <span>Upload Backup</span>
            </button>
        </nav>
    </div>

    <p class="bg-warning rounded-3 p-2 black">Warning: Make a backup before making changes!</p>

    <div class="d-inline-flex gap-3 mt-3">
        <button class="button info" onclick="location='{{route('places_folder')}}'">
            <i class="fa-regular fa-folder-open"></i>
            <span>Download places folder</span>
        </button>
        <a href="{{route('php_info')}}"  target="_blank" class="button info">
            <i class="fa-brands fa-php"></i>
            <span>Ver PHP info</span>
        </a>
        <button class="button info" onclick="location='{{route('git_pull')}}'">
            <i class="fa-solid fa-code-pull-request"></i>
            <span>Git pull</span>
        </button>
    </div>
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
