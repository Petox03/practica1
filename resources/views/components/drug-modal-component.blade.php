<dialog id="{{ $modalId }}" class="modal">
    <div class="modal-box w-2/4 max-w-5xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>

        <div class="grid grid-cols-3 gap-4">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nombre del medicamento</legend>
                <input type="text" class="input" placeholder="Nombre" id="{{ $nameId }}" value="{{ $nameValue ?? '' }}" />
                <span class="error-message text-red-500 text-sm"></span>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Precio</legend>
                <input type="text" class="input" placeholder="1,000" id="{{ $priceId }}" value="{{ $priceValue ?? '' }}" />
                <span class="error-message text-red-500 text-sm"></span>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Cantidad por paquete</legend>
                <input type="text" class="input" placeholder="0" id="{{ $quantityId }}" value="{{ $quantityValue ?? '' }}" />
                <span class="error-message text-red-500 text-sm"></span>
            </fieldset>
            <fieldset class="fieldset col-span-3">
                <legend class="fieldset-legend">Descripción</legend>
                <textarea class="textarea h-24 w-full" placeholder="..." id="{{ $descriptionId }}">{{ $descriptionValue ?? '' }}</textarea>
                <span class="error-message text-red-500 text-sm"></span>
            </fieldset>
            <fieldset class="fieldset col-span-3">
                <div id="{{ $previewContainerId }}" class="mt-5 {{ $imageHidden ? 'hidden' : '' }}">
                    <p class="text-gray-600">Previsualización:</p>
                    <img id="{{ $previewImageId }}" src="{{ $imageSrc ?? '' }}" alt="Previsualización de la imagen" class="max-w-xs rounded-lg">
                </div>
                <legend class="fieldset-legend">Imágen</legend>
                <input type="file" name="image" id="{{ $fileInputId }}"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                    onchange="previewImage(event, '{{ $previewImageId }}')" {{ $fileInputRequired ? 'required' : '' }} />
                <span class="error-message text-red-500 text-sm"></span>
            </fieldset>
        </div>

        <div class="modal-action">
            <form method="dialog">
                <button class="text-white btn btn-error">Cerrar</button>
            </form>
            <button class="text-white btn btn-success" onclick="{{ $actionFunction }}">{{ $actionButtonText }}</button>
        </div>
    </div>
</dialog>
