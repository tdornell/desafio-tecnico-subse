<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">    <title>Viajes</title>
</head>
<body>
    <div class="d-flex justify-content-center">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <h5 class="card-title">Viajes</h5>
                <p class="card-text">Suba el archivo CSV con los datos de los agentes que viajaron.</p>
                <p class="card-text">Los datos deben seguir el siguiente orden: nombre, apellido, documento, organismo, viaticos, fecha_inicio, fecha_fin</p>

                <!-- Formulario para subir el CSV -->
                <!-- El formulario envía el archivo a la ruta 'viajes.store' para procesarlo y guardar los datos en la base de datos -->
                <form action="{{ route('viajes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="csv_file" class="form-label" aria-required="true">Archivo .csv: <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="csv_file" name="csv_file" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
                <!-- Fin del formulario -->

                <!-- Muestra un mensaje de éxito si se cargaron correctamente los datos -->
                @if (session('success'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Muestra un mensaje de error si el archivo no tiene el formato correcto -->
                @error('format')
                    <div class="alert alert-danger mt-3" role="alert">
                        {!! nl2br(e($message)) !!}
                    </div>
                @enderror

                <!-- Muestra un mensaje de error si los tipos de datos no son correctos -->
                @error('datatype')
                    <div class="alert alert-danger mt-3" role="alert">
                        {!! nl2br(e($message)) !!}
                    </div>
                @enderror
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>