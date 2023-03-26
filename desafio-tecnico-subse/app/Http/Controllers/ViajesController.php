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

        /** 
         * TODO: 
         * Validar que los tipos de datos de cada campo sean correctos.
         */ 

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

            // Valida que la línea tenga el formato correcto.
            if (count($line) !== 7) {
                return redirect()->back()->withErrors(
                    [
                        'format' => "No se pudieron guardar los datos en la base de datos.\n" .
                                    "El archivo CSV no tiene el formato correcto en la línea " . $line_number . ". " .
                                    "Verifique que cada fila tenga exactamente 7 campos."
                    ]);
            } else {
                // Si la línea tiene el formato correcto, crea el objeto Viaje y lo guarda en el array.
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
