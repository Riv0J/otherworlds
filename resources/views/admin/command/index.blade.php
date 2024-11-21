@extends('layout.masterpage')

@section('title')
    @lang('otherworlds.commands') | Admin {{ config('app.name') }}
@endsection

@section('canonical')
    {{ URL::current() }}
@endsection

@section('content')


<section class="wrapper col-12 col-lg-10">
    <div class="title">
        <div class="text">
            <i class="fa-solid fa-terminal"></i>
            <h3>@lang('otherworlds.commands')</h3>
        </div>
        <nav class="buttons">

        </nav>
    </div>

    <span class="bg-warning p-2 rounded-2"> 
        <i class="fa-solid fa-triangle-exclamation"></i> 
        Warning: Make a backup before making changes!
    </span>

    <div id="comandos" class="flex-row flex-wrap gap-2 mt-5">

        <fieldset>
            <legend>
                <i class="fa-solid fa-bars-progress"></i>
                <span>Server</span>
            </legend>
            <button class="button info" onclick="window.open('{{ route('php_info') }}', '_blank')">
                <i class="fa-brands fa-php"></i>
                <span>PHP info</span>
            </button>
            <button class="button info" onclick="location='{{route('git_pull')}}'">
                <i class="fa-solid fa-code-pull-request"></i>
                <span>Git pull</span>
            </button>
        </fieldset>

        <fieldset>
            <legend>
                <i class="fa-solid fa-database"></i>
                <span>Database</span>
            </legend>
            <button class="button info" type="button" onclick="location='{{ route('database_download') }}'">
                <i class="fa-solid fa-download"></i>
                <span>Download Backup</span>
            </button>

            <button class="button info" onclick="location='{{route('places_folder')}}'">
                <i class="fa-regular fa-folder-open"></i>
                <span>Download places folder</span>
            </button>

            <button class="button info" id="upload-button">
                <i class="fa-solid fa-upload"></i>
                <span>Upload Backup</span>
                <form id="upload-form" action="{{ route('database_upload') }}" method="POST" enctype="multipart/form-data" class="d-none">
                    @csrf
                    <input type="file" id="backup-file" name="backup" accept=".sql" required>
                </form>
            </button>
        </fieldset>

    </div>
</section>
<style>
    fieldset{
        position: relative;
        border: 2px solid var(--alt_dark);
        padding: 1rem;
        padding-top: 1.5rem;
        display: flex;
        flex-direction: row;
        gap:0.5rem;
        width: max-content;
    }
    legend{
        position: absolute;
        top: -30%;
        padding-inline: 0.5rem;
        width: max-content;
    }
</style>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backupFileInput = document.getElementById('backup-file');

        // Al hacer clic en el botón "Upload Backup", abrir el selector de archivos
        document.getElementById('upload-button').addEventListener('click', function(event) {
            backupFileInput.click();
        });

        // Al seleccionar un archivo, enviar el formulario automáticamente
        backupFileInput.addEventListener('change', function() {
            if (backupFileInput.files.length > 0) {
                document.getElementById('upload-form').submit();
            }
        });
    });
</script>
@endsection
