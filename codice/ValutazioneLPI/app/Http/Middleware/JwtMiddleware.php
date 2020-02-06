<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Request;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware{
    public function handle($request, Closure $next)
    {
        //Prendo il token dagli header della richiesta
        $token = $request->header('Authorization');

        //Rimuovo la stringa 'Bearer' iniziale
        $token = explode(" ", $token)[1];
 
        //Se il token non è settato ritorno l'errore
        if(!$token) {
            return response()->json(['error' => 'Token non impostato'], 401);
        }

        try {
            //Decodifico il token
            $credentials = JWT::decode($token, env('APP_KEY'), ['HS256']);
        } catch(ExpiredException $e) {
            //Se è scaduto ritorno l'errore
            return response()->json(['error' => 'Il token è scaduto'], 400);
        } catch(Exception $e) {
            print_r($e->getMessage());
            //Se non riesco a decodificarlo ritorno l'errore
            return response()->json(['error' => 'Impossibile decodificare il token'], 400);
        }

        //Cerco l'utente che ha l'id salvato nel token
        $user = User::find($credentials->sub);

        //Salvo l'utente che ha eseguito la richiesta
        $request->auth = $user;

        return $next($request);
    }

}

?>