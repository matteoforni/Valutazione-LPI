<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Config\Config;

class LoginController extends Controller
{
    /**
     * Funzione che consente di autenticare un utente
     * @param Request request La richiesta effettuata
     * @return Response La risposta JSON
     */
    public function authenticate(Request $request){
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'min' => "Il campo :attribute deve essere di almeno :min caratteri",
            'max' => "Il campo :attribute deve essere di massimo :max caratteri",
            'email' => "Il campo :attribute deve essere un indirizzo email valido",
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:7',
        ], $messages);

         //Verifico che la valutazione sia andata a buon fine.
         if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }

        //Cerco l'utente con quell'email
        $user = User::where('email', $request->input('email'))->first();

        //Se non esiste ritorno l'errore
        if (!$user) {
            return response()->json(['error' => "L'utente non esiste"], 400);
        }

        //Verifico la password e genero il token
        if (password_verify($request->input('password'), $user->password)) {
            return response()->json(['token' => $this->jwt($user)], 200);
        }

        //Se la combinazione di password e email non corrispondono ritorno l'errore
        return response()->json(['error' => 'Email o password sbagliate'], 400);
    }

    /**
     * Funzione che consente di generare un token JWT
     * @param User user L'utente alla quale assegnare il token
     * @return string Il token codificato
     */
    protected function jwt(User $user) {
        //Imposto i dati del token
        $payload = [
            'iss' => env('ISS'), //Emittente del token
            'sub' => $user->id, //Soggetto del token
            'iat' => time(), //Data e orario dell'emissione
            'exp' => time() + 60*60, //Data e orario dello scadere del token
            'id_role' => $user->id_role
        ];
        
        //Genero il token crittografato con la chiave generata contenente i dati
        return JWT::encode($payload, env('APP_KEY'), 'HS256');
    } 
}
?>