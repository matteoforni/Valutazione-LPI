<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Config\Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

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

    /**
     * Funzione che rimanda l'utente alla pagina seguente il login in base ai suoi privilegi
     * @param Request request La richiesta del client
     * @return string Il token codificato
     */
    public function login(Request $request){
        $user = User::find($request->all()['id']);
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == env('ADMIN')){
            //Se è ammministratore gli mostro la pagina
            return redirect('admin?token=' . $request->get('token'));
        }elseif($request->all()['user_id_role'] == env('TEACHER')){
            //Se non lo è ritorno la pagina per i docenti
            return redirect('teacher?token=' . $request->get('token'));
        }
    }

    /**
     * Funzione che conferma l'email dell'utente
     * @param L'id dell'utente criptato
     * @return se va a buon fine la pagina di login altrimenti il messaggio d'errore
     */
    public function confirmation($token){
        $users = User::all();

        //Decripto l'id dell'utente
        $token = Crypt::decrypt($token);

        foreach($users as $user){
            if($user->confirmation_token == $token){
                $user->confirmed = 1;
                $user->confirmation_token = null;
                $user->save();
                return redirect(''); 
            }
        }
        return response()->json('Utente non trovato', 401);
    }
}
?>