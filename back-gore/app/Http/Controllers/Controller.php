<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPageSize()
    {
        if (request()->filled('per_page')) {
            return intval(request()->input('per_page'));
        }
        if (request()->filled('page_size')) {
            return intval(request()->input('page_size'));
        }
        if (request()->filled('rowsPerPage')) {
            return intval(request()->input('rowsPerPage'));
        }
        return config('controller.page_size', 20);
    }

    public function generateViewSetList(Request $request, Builder $querySet, array $filterBy, array $searchBy, array $orderBy, array $relationFields = [])
    {
        function addOrSkipBaseTable(string $colName, string $tableBaseName)
        {
            $colName = str_replace('!', '.', $colName);
            if (strpos($colName, '.') === false) {
                return $tableBaseName . '.' . $colName;
            }
            return $colName;
        }

        $tableBaseName = $querySet->getModel()->getTable();
        // return $tableBaseName;
        if ($request->hasAny($filterBy)) {
            // return $request;
            foreach ($filterBy as $filter) {
                if ($request->filled($filter)) {
                    $querySet->where(addOrSkipBaseTable($filter, $tableBaseName), $request->input($filter));
                }
            }
        }

        if ($request->filled('search')) {
            $querySet->where(function ($q) use ($searchBy, $request, $tableBaseName, $relationFields) {
                $q->where(function ($q) use ($searchBy, $request, $tableBaseName) {
                    foreach ($searchBy as $searchByCol) {
                        $q->orWhere(addOrSkipBaseTable($searchByCol, $tableBaseName), 'like', '%' . $request->input('search') . '%');
                    }
                });

                // Agregar lógica para búsqueda por nombre en relaciones y campos específicos
                foreach ($relationFields as $relationField) {
                    $relation = $relationField['relation'];
                    $fields = $relationField['fields'];

                    $q->orWhereHas($relation, function ($query) use ($request, $fields) {
                        $query->where(function ($query) use ($request, $fields) {
                            foreach ($fields as $field) {
                                $query->orWhere($field, 'like', '%' . $request->input('search') . '%');
                            }
                        });
                    });
                }

                return $q;
            });
            // return $querySet->toSql();
        }




        if ($request->filled('order_by')) {
            $searchOrderList = explode(',', $request->input('order_by'));
            foreach ($searchOrderList as $searchOrderParam) {
                $searchOrderParamWithoutSign = preg_replace('/-/', '', $searchOrderParam, 1);

                $orderDirection = substr($searchOrderParam, 0, 1) === '-' ? 'desc' : 'asc';

                if (in_array($searchOrderParamWithoutSign, $orderBy, true)) {
                    $querySet->orderBy(addOrSkipBaseTable($searchOrderParamWithoutSign, $tableBaseName), $orderDirection);
                }
            }
        }

        return $this->getPageSize() ? $querySet->paginate($this->getPageSize()) : response()->json(['data' => $querySet->get()]);
    }
    public function nuevoNombre($nameOriginal, $concat="") {
        $posPunto = strrpos($nameOriginal, '.');    // buscar el ultimo punto del nombre del archivo
        $nombre = substr($nameOriginal, 0, $posPunto);
        $extension = substr($nameOriginal, $posPunto);
        if($nombre&&$nombre!=""){
            //$nombre=$nombre;
        }else{
            $nombre=$extension;
            $extension="";
        }
        $nombre = str_replace([
            "ñ", "á", "é", "í", "ó", "ú", "ü", "Ñ", "Á", "É", "Í", "Ó", "Ú", "Ü",
            "ç", "¨", "´", "~", "#", "%", "&", "/", "\\", "?", "*", ":", "<", ">", "|", "\"", "'", "."
            ], [
            "n", "a", "e", "i", "o", "u", "u", "N", "A", "E", "I", "O", "U", "U",
            "c",  "",  "",  "",  "",  "",  "", "-", "_",  "",  "", "_",  "",  "", "-",  "",  "", "_"
            ], $nombre);
        // Eliminar espacios en blanco y guiones bajos consecutivos
        $nombre = preg_replace("/[\s_]+/", "_", $nombre);
        // Eliminar guiones bajos al principio y al final
        $nombre = trim($nombre, "_");
        $newName = $nombre.'_'.Carbon::now()->format('Y-m-d_H-i-s-u').$concat.$extension;
        return $newName;
    }
}
