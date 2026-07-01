<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocalidadesNew;
use Illuminate\Support\Facades\URL;



class LocalidadesController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->input('query');

        // Validar que la longitud mínima sea 3 caracteres
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Realizar la búsqueda
        $resultados = LocalidadesNew::conSucursal() // Scope para excluir localidades sin sucursal
            ->where(function ($q) use ($query) {
                $q->where('LocalidadNombre', 'like', "%$query%") // Búsqueda por nombre
                  ->orWhere('CodigoPostal', 'like', "%$query%"); // Búsqueda por código postal
            })
            ->take(10) // Limitar los resultados
            ->get(['LocalidadID', 'LocalidadNombre', 'CodigoPostal', 'SucursalId']);
        // Retornar el JSON con los resultados
        return response()->json($resultados);
    }

}
