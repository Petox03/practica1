@extends('layouts.app')

@section('content')
    <form class="max-w-md mx-auto" method="post" enctype="multipart/form-data">
        @csrf
        <!-- Campo de subir imagen -->
        <div class="relative z-0 w-full mb-5 group">
            <input type="file" name="image" id="image"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                onchange="previewImage(event)" required />
            <label for="image" class="block mt-2 text-sm text-gray-500">Sube una imagen</label>
        </div>
        <!-- Contenedor de la vista previa -->
        <div id="imagePreviewContainer" class="mt-5 hidden">
            <p class="text-gray-600">Previsualización:</p>
            <img id="imagePreview" src="" alt="Previsualización de la imagen" class="max-w-xs rounded-lg">
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Guardar
        </button>
    </form>

    <!-- Mostrar previsualización si existe -->
    @if (session('preview_url'))
        <div class="mt-5">
            <p class="text-gray-600">Previsualización de la imagen subida:</p>
            <img src="{{ session('preview_url') }}" alt="Previsualización de la imagen" class="max-w-xs rounded-lg">
        </div>
    @endif
@endsection

@push('js')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');

            if (file) {
                const objectUrl = URL.createObjectURL(file);
                previewImage.src = objectUrl;
                previewContainer.classList.remove('hidden');
            } else {
                previewImage.src = '';
                previewContainer.classList.add('hidden');
            }
        }
    </script>
@endpush
