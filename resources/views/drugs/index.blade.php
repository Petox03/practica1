@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <div id="alerts">

    </div>
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table">
            <!-- head -->
            <div class="p-5 flex justify-end gap-5">
                <label class="input">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    <input type="search" id="search" class="grow" placeholder="Buscar medicina" />
                    <kbd class="kbd kbd-sm">ctrl</kbd>
                    <kbd class="kbd kbd-sm">K</kbd>
                </label>
                <button class="btn btn-success text-white" onclick="my_modal_3.showModal()">Nuevo Medicamento</button>

            </div>
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre de la medicina</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad por paquete</th>
                    <th>Imágen</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="simpleList">
                @foreach ($my_drugs as $drug)
                    <tr class="bg-white hover:bg-gray-50" data-id="{{ $drug->id }}">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $drug->order == 0 ? $drug->id : $drug->order }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $drug->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $drug->description }}
                        </td>
                        <td class="px-6 py-4">
                            ${{ $drug->price }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $drug->quantity }}
                        </td>
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $drug->img) }}" alt="Imagen del medicamento"
                                class="rounded-lg w-32 h-32">
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <a href="{{ route('drug.show', $drug->id) }}"
                                    class="px-5 font-medium text-green-600 hover:underline">Ver</a>
                            </div>
                            <div>
                                <button onclick="openEditModal({{ $drug->id }})"
                                    class="px-5 font-medium text-blue-600 hover:underline cursor-pointer">Editar</button>

                            </div>

                            <button type="submit" onclick="deleteDrug({{ $drug->id }})"
                                class="px-5 font-medium text-red-600 hover:underline cursor-pointer">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="divider"></div>
    </div>

    <dialog id="my_modal_3" class="modal">
        <div class="modal-box w-2/4 max-w-5xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Añadir medicamento</h3>

            <div class="grid grid-cols-3 gap-4">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Nombre del medicamento</legend>
                    <input type="text" class="input" placeholder="Nombre" id="drug-name"/>
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Precio</legend>
                    <input type="text" class="input" placeholder="1,000" id="drug-price"/>
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Cantidad por paquete</legend>
                    <input type="text" class="input" placeholder="0" id="drug-quantity"/>
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset col-span-3">
                    <legend class="fieldset-legend">Descripción</legend>
                    <textarea class="textarea h-24 w-full" placeholder="..." id="drug-description"></textarea>
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset col-span-3">
                    <!-- Contenedor de la vista previa -->
                    <div id="imagePreviewContainer" class="mt-5 hidden">
                        <p class="text-gray-600">Previsualización:</p>
                        <img id="imagePreview" src="" alt="Previsualización de la imagen"
                            class="max-w-xs rounded-lg">
                    </div>
                    <legend class="fieldset-legend">Imágen</legend>
                    <input type="file" name="image" id="image"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        onchange="previewImage(event)" required />
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>

            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="text-white btn btn-error">Cerrar</button>
                </form>
                <button class="text-white btn btn-success" onclick="createDrug()">Crear</button>
            </div>

        </div>
    </dialog>

    <dialog id="edit_modal" class="modal">
        <div class="modal-box w-2/4 max-w-5xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Editar medicamento</h3>

            <div class="grid grid-cols-3 gap-4">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Nombre del medicamento</legend>
                    <input type="text" class="input" placeholder="Nombre" id="edit-drug-name" />
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Precio</legend>
                    <input type="text" class="input" placeholder="1,000" id="edit-drug-price" />
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Cantidad por paquete</legend>
                    <input type="text" class="input" placeholder="0" id="edit-drug-quantity" />
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset col-span-3">
                    <legend class="fieldset-legend">Descripción</legend>
                    <textarea class="textarea h-24 w-full" placeholder="..." id="edit-drug-description"></textarea>
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
                <fieldset class="fieldset col-span-3">
                    <!-- Contenedor de la vista previa -->
                    <div id="edit-imagePreviewContainer" class="mt-5 hidden">
                        <p class="text-gray-600">Previsualización:</p>
                        <img id="edit-imagePreview" src="" alt="Previsualización de la imagen"
                            class="max-w-xs rounded-lg">
                    </div>
                    <legend class="fieldset-legend">Imágen</legend>
                    <input type="file" name="image" id="edit-image"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        onchange="previewImage(event)" />
                    <span class="error-message text-red-500 text-sm"></span>
                </fieldset>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="text-white btn btn-error">Cerrar</button>
                </form>
                <button class="text-white btn btn-success"
                    onclick="updateDrug(event, CURRENT_DRUG_ID)">Actualizar</button>
            </div>
        </div>
    </dialog>

@endsection

@push('js')

    {{-- Script para sortable js --}}
    <script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
    <script>
        // Se asigna al div con el id simpleList un nuevo elemento sortable
        Sortable.create(document.getElementById('simpleList'), {

            //configura la animación en 150ms
            animation: 150,

            // Cuando la animación termina llama a una función anónima
            onEnd: function(evt) {
                // Obtenemos el nuevo orden de las filas
                const order = [...evt.to.children].map((row, index) => {
                    return {
                        id: row.dataset.id,
                        position: index + 1
                    };
                });

                // Enviar los datos al backend usando Axios
                axios.put('/api/drugs/update-order', {
                        orders: order
                    })
                    //Si todo sale bien, actualizamos y rerenderizamos la tabla
                    .then(response => {
                        // Llamamos a una función para re-renderizar la tabla
                        if (response.data.updatedDrugs) {
                            reRenderTable(response.data.updatedDrugs);
                        }
                    })
                    //Si ocurre algún error, lo imprimimos en consola.
                    .catch(error => {
                        console.error('Error al actualizar el orden:', error);
                    });
            }
        });
    </script>

    <script>
        let CURRENT_DRUG_ID = null; // Variable global para almacenar el ID actual del medicamento a editar

        // función para mostrar la previsualización de la imágen seleccionada en el input
        function previewImage(event) {
            const file = event.target.files[0]; // Obtener el archivo seleccionado

            // Obtener los elementos del modal
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');

            if (file) {
                const objectUrl = URL.createObjectURL(file); // Generar una URL temporal
                previewImage.src = objectUrl; // Asignar la URL temporal al elemento <img>
                previewContainer.classList.remove('hidden'); // Mostrar el contenedor de previsualización
            } else {
                previewImage.src = ''; // Limpiar la previsualización
                previewContainer.classList.add('hidden'); // Ocultar la previsualización
            }
        }

        // Función para limpiar los errores previos
        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(span => {
                span.textContent = ''; // Vacía cualquier mensaje existente
            });
        }

        // Función abrir el modal de editar medicamento
        function openEditModal(id) {
            CURRENT_DRUG_ID = id; // Establece el ID del medicamento que estás editando

            // Realiza la solicitud para obtener los datos del medicamento
            axios.get(`/api/drugs/${id}`)
                .then(response => {
                    if (response.data) {
                        // Llena los inputs del modal con los datos del medicamento
                        document.getElementById('edit-drug-name').value = response.data.name;
                        document.getElementById('edit-drug-price').value = response.data.price;
                        document.getElementById('edit-drug-quantity').value = response.data.quantity;
                        document.getElementById('edit-drug-description').value = response.data.description;

                        // Si hay una imagen, muestra su previsualización
                        if (response.data.img) {
                            const imagePreview = document.getElementById('edit-imagePreview');
                            const imagePreviewContainer = document.getElementById('edit-imagePreviewContainer');
                            imagePreview.src = `/storage/${response.data.img}`;
                            imagePreviewContainer.classList.remove('hidden');
                        }

                        // Abre el modal
                        const modal = document.getElementById("edit_modal");
                        modal.showModal();
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos del medicamento:', error);
                });
        }


        // Función para actualizar un medicamento
        function updateDrug(event, id) {
            // Crea un objeto con los datos del formulario
            const data = {
                name: document.getElementById('edit-drug-name').value,
                price: document.getElementById('edit-drug-price').value,
                quantity: document.getElementById('edit-drug-quantity').value,
                description: document.getElementById('edit-drug-description').value,
            };

            // Opcional: Si hay una imagen, maneja este campo de manera distinta
            const imageInput = document.getElementById('edit-image');
            if (imageInput.files[0]) {
                alert(
                    "El manejo de archivos con JSON no es compatible de forma directa; es mejor usar FormData en este caso."
                    );
            }

            // Realiza la solicitud PUT con los datos
            axios.put(`/api/drugs/update/${id}`, data)
                //Si todo sale bien, muestra una alerta de éxito
                .then(response => {
                    if (response.status === 200) {
                        reRenderDrugs(); // Actualiza la tabla
                        clearErrors();
                        const modal = document.getElementById("edit_modal");
                        modal.close();

                        // Muestra la alerta de éxito
                        showAlert('El medicamento se ha actualizado exitosamente.', 'alert-success');
                    }
                })
                //Si sucede algún error, muestra una alerta de error y lo maneja
                .catch(error => {
                    handleValidationErrors(error);
                });

        }



        // Función para crear un medicamento
        function createDrug(event) {

            // Crea un objeto con los datos del formulario
            const formData = new FormData();
            formData.append('name', document.getElementById('drug-name').value);
            formData.append('price', document.getElementById('drug-price').value);
            formData.append('quantity', document.getElementById('drug-quantity').value);
            formData.append('description', document.getElementById('drug-description').value);

            // Opcional: Si hay una imagen, maneja este campo de manera distinta
            const imageInput = document.getElementById('image');
            if (imageInput.files[0]) {
                formData.append('img', imageInput.files[0]); // Adjuntar la imagen
            }

            // obtiene el modal para la creación del medicamento
            const modal = document.getElementById("my_modal_3");

            // hace la petición al backend y manda los datos
            axios.post('/api/drugs/store', formData)
                // Si todo sale bien, muestra una alerta de éxito
                .then(response => {
                    if (response.status === 201) {
                        reRenderDrugs(); // Actualiza la tabla
                        clearErrors(); // limpia los errores

                        // Cierra el modal de creación del medicamento
                        const modal = document.getElementById("my_modal_3");
                        modal.close();

                        // Muestra la alerta de éxito
                        showAlert('El medicamento se ha creado exitosamente.', 'alert-success');
                    }
                })
                // si sucede algún error, lo maneja
                .catch(error => {
                    handleValidationErrors(error);
                });

        }

        // Función para mostrar alertas en pantalla
        function deleteDrug(id) {
            axios.delete(`/api/drugs/destroy/${id}`)
                .then(response => {
                    if (response.status === 200) {
                        // Actualiza la tabla con los cambios
                        reRenderDrugs();

                        // Muestra la alerta de éxito
                        showAlert('El medicamento se ha eliminado exitosamente.', 'alert-error');
                    }
                })
                .catch(error => {
                    // Maneja errores de validación o errores inesperados
                    handleValidationErrors(error);
                });
        }


        // función para actualizar los datos de la tabla este es para los orders
        function reRenderTable(updatedDrugs) {
            const tableBody = document.getElementById('simpleList');
            tableBody.innerHTML = ''; // Limpiar el contenido actual

            updatedDrugs.forEach(drug => {
                tableBody.innerHTML += createRowTemplate(drug);
            });
        }

        // Función para actualizar la lista de medicamentos
        function reRenderDrugs() {
            const tableBody = document.getElementById('simpleList');
            tableBody.innerHTML = ''; // Limpiar el contenido actual

            // Realiza la solicitud GET para obtener los medicamentos
            axios.get('/api/drugs/')
                .then(response => {
                    const drugs = response.data;
                    drugs.forEach(drug => {
                        tableBody.innerHTML += createRowTemplate(drug);
                    });
                })
                .catch(error => {
                    console.error('Error al obtener los medicamentos:', error);
                });
        }


        // Crea una plantilla para cada fila de la tabla
        function createRowTemplate(drug) {
            return `
        <tr class="bg-white hover:bg-gray-50" data-id="${drug.id}">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                ${drug.order == 0 ? drug.id : drug.order}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                ${drug.name}
            </th>
            <td class="px-6 py-4">${drug.description}</td>
            <td class="px-6 py-4">$${drug.price}</td>
            <td class="px-6 py-4">${drug.quantity}</td>
            <td class="px-6 py-4">
                <img src="/storage/${drug.img}" alt="Imagen del medicamento" class="rounded-lg w-32 h-32">
            </td>
            <td class="px-6 py-4">
                <div>
                    <a href="/drug/show/${drug.id}" class="px-5 font-medium text-green-600 hover:underline">Ver</a>
                </div>
                <div>
                    <button onclick="openEditModal(${drug.id})" class="px-5 font-medium text-blue-600 hover:underline cursor-pointer">
                        Editar
                    </button>
                </div>
                <button type="submit" onclick="deleteDrug(${drug.id})"
                    class="px-5 font-medium text-red-600 hover:underline cursor-pointer">Eliminar</button>
            </td>
        </tr>
    `;
        }

        // Crea una alerta
        function showAlert(message, alertType) {
            const alertsDiv = document.getElementById('alerts');

            // Crear el contenedor de la alerta
            const alert = document.createElement('div');
            alert.setAttribute('role', 'alert');
            alert.classList.add('alert', alertType, 'my-3');
            alert.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>${message}</span>
    `;

            // Añadir la alerta al contenedor
            alertsDiv.appendChild(alert);

            // Configurar para que desaparezca automáticamente después de unos segundos
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s'; // Animación para desvanecer
                alert.style.opacity = '0'; // Desvanecer
                setTimeout(() => {
                    alert.remove(); // Eliminar del DOM
                }, 500); // Esperar a que termine la animación antes de eliminar
            }, 3000); // Mostrar la alerta por 3 segundos
        }

        // maneja los errores de los formularios.
        function handleValidationErrors(error) {
    if (error.response && error.response.status === 422) {
        // Limpia errores previos
        clearErrors();

        const errors = error.response.data.errors;

        // Muestra los errores específicos debajo de los inputs correspondientes
        for (const field in errors) {
            if (errors.hasOwnProperty(field)) {
                const input = document.getElementById(`drug-${field}`) || document.getElementById('image');
                const errorSpan = input ? input.nextElementSibling : null;

                if (errorSpan) {
                    errorSpan.textContent = errors[field].join(', '); // Muestra todos los errores del campo
                }
            }
        }
    } else {
        console.error('Error inesperado:', error);
    }
}

    </script>

    <script>
        // posiciona la escritura en el input cuando se presiona ctrl + k
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.key === 'k') {
                event.preventDefault(); // Previene la acción por defecto de Ctrl + K
                document.getElementById('search').focus(); // Posiciona el cursor en el input
            }
        });

        // Evento para buscar medicamentos en la tabla
        document.getElementById('search').addEventListener('input', function(event) {
            const searchValue = event.target.value;

            axios.post('/api/drugs/search', {
                    search: searchValue
                })
                .then(response => {
                    if (response.data) {
                        reRenderTable(response.data);
                    }
                })
                .catch(error => {
                    console.error('Error al encontrar datos:', error);
                });
        });
    </script>
@endpush
