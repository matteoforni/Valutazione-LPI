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

        //Verifico che sia stato impostato
        if(!$token){
            //Verifico se è nell'URL
            $token = $request->get('token');
        }else{
            //Rimuovo la stringa 'Bearer' iniziale
            $token = explode(" ", $token)[1];
        }        

        //Se il token non è settato ritorno l'errore
        if(!$token) {
            return response()->json(['error' => 'Token non impostato'], 401);
        }

        try {
            //Decodifico il token
            $credentials = JWT::decode($token, env('APP_KEY'), ['HS256']);

            //Aggiungo alla richiesta il tipo di ruolo così da riutilizzarlo in seguito
            $request->request->add(['user_id_role' => $credentials->id_role]);
            $request->request->add(['id' => $credentials->sub]);
        } catch(ExpiredException $e) {
            //Se è scaduto ritorno l'errore
            return view('login/index');
        } catch(Exception $e) {
            print_r($e->getMessage());
            //Se non riesco a decodificarlo ritorno l'errore
            return response()->json(['error' => 'Impossibile decodificare il token'], 400);
        }

        //Cerco l'utente che ha l'id salvato nel token
        $user = User::find($credentials->sub);

        //Salvo l'utente che ha eseguito la richiesta
        $request->auth = $user;

        //Ritorno la richiesta così da riutilizzarla nel metodo del controller chiamato
        return $next($request);
    }

}

?>