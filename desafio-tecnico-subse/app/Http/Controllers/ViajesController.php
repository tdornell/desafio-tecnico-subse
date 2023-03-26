<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Viaje;
use SplFileObject;

class ViajesController extends Controller
{
    /**
     * Lee el archivo CSV y guarda los viajes en la base de datos.
     * Se realizan las siguientes validaciones:
     * - Que se haya seleccionado un archivo.
     * - Que el archivo sea un CSV.
     * - Que el archivo no esté vacío.
     * - Que el archivo tenga el formato correcto.
     * - Que los tipos de datos de cada campo sean correctos.
     */

    public function store(Request $request){

        // Valida que se haya seleccionado un archivo.
        if (!$request->hasFile('csv_file')) {
            return redirect()->back()->withErrors(
                [
                    'format' => "No se pudieron guardar los datos en la base de datos.\n" .
                                "No se seleccionó ningún archivo."
                ]);
        }

        // Valida que el archivo sea un CSV.
        if ($request->file('csv_file')->getClientOriginalExtension() !== 'csv') {
            return redirect()->back()->withErrors(
                [
                    'format' => "No se pudieron guardar los datos en la base de datos.\n" .
                                "El archivo seleccionado no es un archivo CSV."
                ]);
        }

        // Valida que el archivo no esté vacío.
        if ($request->file('csv_file')->getSize() === 0) {
            return redirect()->back()->withErrors(
                [
                    'format' => "No se pudieron guardar los datos en la base de datos.\n" .
                                "El archivo CSV está vacío."
                ]);
        }

        // Obtiene el archivo CSV enviado desde el formulario.
        $csv_file = $request->file('csv_file');
        
        // Lee el archivo CSV.
        $csv = new SplFileObject($csv_file);
        
        // Array para guardar los objetos Viaje.
        $viajes = [];

        // Número de línea actual.
        $line_number = 1;

        // Lee el archivo CSV línea por línea.
        while (!$csv->eof()) {
            $line = $csv->fgetcsv();

            // Array para guardar los errores de la línea actual.
            $line_errors = [];

            // Valida que la línea tenga el formato correcto.
            if (count($line) !== 7) {
                return redirect()->back()->withErrors(
                    [
                        'format' => "No se pudieron guardar los datos en la base de datos.\n" .
                                    "El archivo CSV no tiene el formato correcto en la línea " . $line_number . ". " .
                                    "Verifique que cada fila tenga exactamente 7 campos."
                    ]);
            } else {
                
                if (empty($line[0]) || !is_string($line[0])) {
                    $line_errors[] = "El campo 'nombre' debe ser un string no vacío.";
                }
                if (empty($line[1]) || !is_string($line[1])) {
                    $line_errors[] = "El campo 'apellido' debe ser un string no vacío.";
                }
                if (empty($line[2]) || !is_string($line[2])) {
                    $line_errors[] = "El campo 'documento' debe ser un número.";
                }
                if (empty($line[3]) || !is_string($line[3])) {
                    $line_errors[] = "El campo 'organismo' debe ser un string no vacío.";
                }

                // Valida que el campo 'viaticos' sea un número de hasta 10 dígitos.
                if (!preg_match('/^\d{1,10}(\.\d+)?$/', $line[4])) {
                    $line_errors[] = "El campo viaticos debe ser un número de hasta 10 dígitos.";
                }

                // Valida que el campo 'fecha_inicio' sea una fecha válida en formato 'YYYY-MM-DD'.
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $line[5]) || !strtotime($line[5])) {
                    $line_errors[] = "El campo 'fecha_inicio' debe ser una fecha válida en formato 'YYYY-MM-DD'.";
                }

                // Valida que el campo 'fecha_fin' sea una fecha válida en formato 'YYYY-MM-DD'.
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $line[6]) || !strtotime($line[6])) {
                    $line_errors[] = "El campo 'fecha_fin' debe ser una fecha válida en formato 'YYYY-MM-DD'.";
                }
                
                // Si la línea tiene errores, crea el mensaje de error y redirige a la página anterior.
                if (!empty($line_errors)) {
                    $error_message = "Error en la línea " . $line_number . ":\n" . implode("\n", $line_errors);
                    return redirect()->back()->withErrors(['datatype' => $error_message]);
                }

                // Si la línea tiene el formato y tipo de datos correctos, se crea el objeto Viaje y lo guarda en el array.
                $viaje = new Viaje;
                $viaje->nombre = $line[0];
                $viaje->apellido = $line[1];
                $viaje->documento = $line[2];
                $viaje->organismo = $line[3];
                $viaje->viaticos = $line[4];
                $viaje->fecha_inicio = $line[5];
                $viaje->fecha_fin = $line[6];

                $viajes[] = $viaje;
            }

            $line_number++;
        }

        // Guarda los viajes en la base de datos.
        foreach ($viajes as $viaje) {
            $viaje->save();
        }

        // Redirección a la página principal con mensaje de éxito.
        return redirect()->route('app')->with('success', 'Viajes guardados correctamente.');
    }
}
