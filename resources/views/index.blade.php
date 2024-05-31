<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Control de gastos</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        {{-- TailwindCSS --}}
        <script src="https://cdn.tailwindcss.com"></script>

        {{-- Fontawesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- Sweetalert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Flatpickr --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    </head>

    <body>
        <div class="m-4">
            <h1 class="text-3xl font-bold text-clifford text-center">
                Control de Gastos
            </h1>
        </div>

        {{-- Formulario de registro/edición --}}
        <div class="shadow py-1 mx-10 my-4 rounded-md">

            <div class="bg-gray-200 p-2 rounded-t-md ">
                <h2 class="text-center text-2xl font-bold text-clifford">
                    Registro de gastos
                </h2>
            </div>

            <div class="flex items-center justify-center">
                <form method="POST" class="w-full max-w-lg m-8" action="{{ URL::route('guardar') }}">
                    @csrf
                    @if(isset($gasto) && $gasto->id_gasto)
                        <input type="hidden" id="id_gasto" name="id_gasto" value="{{$gasto->id_gasto}}">
                    @endif
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2" for="fecha">
                                Fecha <span class="text-red-600">*</span>
                            </label>
                            <input id="fecha"
                                class="appearance-none block w-full text-gray-700 border border-gray-400 rounded py-2 px-4 leading-tight"
                                type="text"
                                name="fecha"
                                @if(isset($gasto)) value="{{ $gasto->fecha }}" @else value="{{ old('fecha') }}" @endif
                                autocomplete="off">
                            @error('fecha')
                                <span class="text-xs text-red-700">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full md:w-1/2 px-3">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2" for="monto">
                                Monto <span class="text-red-600">*</span>
                            </label>

                            <input id="monto"
                                class="appearance-none block w-full text-gray-700 border border-gray-400 rounded py-2 px-4 leading-tight"
                                type="text"
                                name="monto"
                                @if(isset($gasto)) value="{{ $gasto->monto }}" @else value="{{ old('monto') }}"  @endif
                                autocomplete="off">

                            @error('monto')
                                <span class="text-xs text-red-700">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2" for="forma_pago">
                                Forma de pago <span class="text-red-600">*</span>
                            </label>
                            <select name="id_tipo_pago" name="id_tipo_pago" class="block w-full text-gray-700 border border-gray-400 rounded py-2 px-4">
                                <option value="">Seleccione una opción</option>
                                @foreach($tiposPago as $tp)
                                    {{--
                                    ToDo:
                                    Completa el código para presentar las opciones del campo "select" del formulario.
                                    --}}
                                @endforeach
                            </select>
                            @error('id_tipo_pago')
                                <span class="text-xs text-red-700">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                        <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                            Descripción <span class="text-red-600">*</span>
                        </label>
                        <textarea rows="3" name="descripcion" id="descripcion" class="appearance-none block w-full text-gray-700 border border-gray-400 rounded py-2 px-4 leading-tight" autocomplete="off" maxlength="Imp" style="resize: none;">@if(isset($gasto)){{$gasto->descripcion}} @else {{old('descripcion')}}@endif</textarea>

                        @error('descripcion')
                            <span class="text-xs text-red-700">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Guardar
                        </button>
                        <button type="reset" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-4">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabla de datos --}}
        <div class="mx-10 shadow">
            <div class="p-2 bg-gray-200  rounded-t-md">
                <h2 class="text-center text-2xl font-bold text-clifford">
                    Gastos registrados ${{ number_format($total, 2) }}
                </h2>
            </div>

            <div>
                @if ($gastos->isEmpty())
                    <div class="mx-auto text-center py-4">
                        <p>No hay registros de gastos</p>
                    </div>
                @else
                    <div class="p-4 w-10/12 mx-auto">
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="border bg-blue-600 text-white">
                                    <th class="border">Id</th>
                                    <th class="border">Descripción</th>
                                    <th class="border">Fecha</th>
                                    <th class="border">Monto</th>
                                    <th class="border">Tipo de pago</th>
                                    <th class="border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gastos as $g)
                                    <tr>
                                        <td class="border text-center w-1/12">
                                            {{ $g->id_gasto }}
                                        </td>
                                        <td class="border m-2 p-2 w-4/12">
                                            {{ $g->descripcion }}
                                        </td>
                                        <td class="w-1/12 border text-center m-2 p-2">
                                            {{ $g->fecha }}
                                        </td>
                                        <td class="w-1/12 border text-right m-2 p-2">
                                            ${{ number_format($g->monto, 2) }}
                                        </td>
                                        <td class="w-1/12 border text-center m-2 p-2">
                                            {{ $g->tipoPago->nombre_tipo }}
                                        </td>
                                        <td class="w-2/12 border text-center m-2 p-2">
                                            <a href="{{ URL::route('editar', ['id_gasto' => $g->id_gasto]) }}" class="bg-cyan-500 hover:bg-cyan-700 text-white py-1 px-2 rounded" role="button"><i class="fa-solid fa-pen-to-square"></i></i>&nbsp;Editar</a>

                                            <a class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded" role="button" onClick="eliminarRegistro({{$g->id_gasto}}, '{{URL::route('eliminar', ['id_gasto' => $g->id_gasto])}}')"><i class="fa-solid fa-trash-can"></i>&nbsp;Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="my-2">
                        {{ $gastos->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', (evt) => {
                flatpickr('#fecha', {
                    enableTime: false,
                });
            });

            function eliminarRegistro(id_gasto, url)
            {
                Swal.fire({
                    title: "Confirmar eliminación",
                    text: "¿Desea eliminar el registro?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí",
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let request = new XMLHttpRequest();
                        request.open("GET", url);
                        request.send();
                        request.onreadystatechange = function() {
                            if (request.readyState == XMLHttpRequest.DONE) {
                                if (request.status == 200) {
                                    let data = request.responseText;
                                    let objeto = JSON.parse(data);
                                    window.location = "{{ URL::route('index') }}";
                                } else {
                                    console.log("Error en la llamada asíncrona");
                                }
                            }
                        };
                    }
                });
            }
        </script>
    </body>
</html>
