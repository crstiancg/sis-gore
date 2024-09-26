<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Models\Persona;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    
    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Persona::query(),
            [],
            [],
            [],
        );
    }

    public function store(StorePersonaRequest $request)
    {
        DB::beginTransaction();

        try {
            if ($request->tipo_documento === 'DNI') {
                $exists = Persona::where('dni', $request->dni)->exists();
                if ($exists) {
                    return response()->json(['error' => 'El DNI ya está registrado'], 409);
                }
            } elseif ($request->tipo_documento === 'RUC') {
                $exists = Persona::where('ruc', $request->ruc)->exists();
                if ($exists) {
                    return response()->json(['error' => 'El RUC ya está registrado'], 409);
                }
            } else {
                return response()->json(['error' => 'Tipo de documento no válido'], 400);
            }
    
            $persona = Persona::create($request->all());
    
            DB::commit();
            return response($persona, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create persona', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function show(Persona $persona)
    {
        return response()->json($persona);
    }

    public function update(Request $request, Persona $persona)
    {
        DB::beginTransaction();

        try {
            if ($request->tipo_documento === 'DNI') {
                $exists = Persona::where('dni', $request->dni)
                                 ->where('id', '!=', $persona->id)
                                 ->exists();
                if ($exists) {
                    return response()->json(['error' => 'El DNI ya está registrado'], 409);
                }
            } elseif ($request->tipo_documento === 'RUC') {
                $exists = Persona::where('ruc', $request->ruc)
                                 ->where('id', '!=', $persona->id)
                                 ->exists();
                if ($exists) {
                    return response()->json(['error' => 'El RUC ya está registrado'], 409);
                }
            } else {
                return response()->json(['error' => 'Tipo de documento no válido'], 400);
            }
    
            $persona->update($request->all());
    
            DB::commit();
            return response()->json($persona, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update persona', 'message' => $e->getMessage()], 500);
        }
    
    }

    public function destroy(Persona $persona)
    {
        return response()->json($persona->delete());
    }

    public function getSolicitanteDni(string $dni)
    {
        $persona = Persona::where('dni', $dni)->first();
        if ($persona) {
            $persona->existe = true;
            return response()->json($persona);
        } else {
            $token = 'apis-token-6807.Z1QDuGGlyyYJEtNrFCo1TmgDHOx54FNE';
            // $numero = '46027897';
            $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
            $parameters = [
                'http_errors' => false,
                'connect_timeout' => 5,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Referer' => 'https://apis.net.pe/dnisolicitante',
                    'User-Agent' => 'laravel/guzzle',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $dni]
            ];
            // Para usar la versión 1 de la api, cambiar a /v1/dni
            $res = $client->request('GET', '/v2/reniec/dni', $parameters);
            $response = json_decode($res->getBody()->getContents(), true);

            return response()->json($response);
        }
    }
    
    public function getEmpresaRuc(string $ruc)
    {
        // Persona::where('dni',$dni);
        $empresa = Persona::where('ruc', $ruc)->first();

        if ($empresa) {
            return response()->json($empresa);
        } else {
            $token = 'apis-token-6504.24Zo2alc2aNI9AYM7Mno1us92N9ZJr6x';

            $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

            $parameters = [
                'http_errors' => false,
                'connect_timeout' => 5,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                    'User-Agent' => 'laravel/guzzle',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $ruc]
            ];
            // Para usar la versión 1 de la api, cambiar a /v1/ruc
            $res = $client->request('GET', '/v2/sunat/ruc', $parameters);
            $response = json_decode($res->getBody()->getContents(), true);

            return response()->json($response);
        }
    }
}
