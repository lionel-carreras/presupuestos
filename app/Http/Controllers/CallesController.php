<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calles;
use App\Models\LocalidadesNew;
use App\Models\Clientes;


class CallesController extends Controller
{
    /**
     * Busca calles según un término de búsqueda.
     * La búsqueda se realiza sobre el campo 'CalleNombre'.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
 /*   public function buscarCalles(Request $request)
{
    $query = $request->input('query');
    if (!$query) {
        return response()->json([]);
    }
    // Buscar calles cuyo nombre contenga el término de búsqueda y limitar a 20 resultados
    $calles = \App\Models\Calles::where('CalleNombre', 'LIKE', "%{$query}%")
                ->limit(20)
                ->get();
    return response()->json($calles);
}*/


}
