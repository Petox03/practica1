@extends('layouts.app')

@section('content')
    <div class="">
        <div class="pb-4 bg-white flex justify-between">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search for items">
            </div>

            <a href="drug/create" type="button"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                +
            </a>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre de la droga
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripción
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cantidad por paquete
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($my_drugs as $drug)
                    <tr class="bg-white hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $drug->id }}
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
                            <div>
                                <a href="{{ route('drug.show', $drug->id) }}"
                                    class="px-5 font-medium text-green-600 hover:underline">Ver</a>
                            </div>
                            <div>
                                <a href="{{ route('drug.edit', $drug->id) }}"
                                    class="px-5 font-medium text-blue-600 hover:underline">Editar</a>
                            </div>

                            <form action="{{ route('drug.destroy', $drug->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    class="px-5 font-medium text-red-600 hover:underline cursor-pointer">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
