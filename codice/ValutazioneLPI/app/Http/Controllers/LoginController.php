<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Crypt;
use App\Mailer;
use Illuminate\Support\Facades\URL;


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
        if($user->first_login == true){
            return redirect('/login/reset/show/first/' . $user->id);
        }else{
            //Verifico che l'utente sia un admin
            if($user->id_role == env('ADMIN')){
                //Se è ammministratore gli mostro la pagina
                return redirect('admin');
            }elseif($user->id_role == env('TEACHER')){
                //Se non lo è ritorno la pagina per i docenti
                return redirect('teacher');
            }
        }
        
    }

    /**
     * Funzione che mostra la pagina di modifica della password
     * @param string Token il token di reset
     * @return La pagina
     */
    public function showReset($token){
        $user = User::where('reset_token', Crypt::decrypt($token))->firstOrFail();;
        if(isset($user) && !empty($user)){
            return view('login/reset');
        }else{
            return response()->json(['error' => "Utente inesistente"], 400);
        } 
    }

    /**
     * Funzione che mostra la pagina di inserimento dell'email per la modifica della password
     * @return La pagina
     */
    public function showRequestReset(){    
        return view('login/request_reset');
    }

    /**
     * Funzione che mostra la pagina di modifica della password al primo login
     * @return La pagina
     */
    public function showDefaultPasswordReset($id){
        $id = User::find($id)->id;
        return view('login/first')->with('id', $id);
    }

    /**
     * Funzione che conferma l'email dell'utente
     * @param L'id dell'utente criptato
     * @return se va a buon fine la pagina di login altrimenti il messaggio d'errore
     */
    public function confirmation($token){
        //Carico tutti gli utenti
        $users = User::all();

        //Decripto l'id dell'utente
        $token = Crypt::decrypt($token);

        foreach($users as $user){
            if($user->confirmation_token == $token){
                //Tolgo il token e salvo l'utente rimandandolo al login
                $user->confirmed = 1;
                $user->confirmation_token = null;
                $user->save();
                return redirect(''); 
            }
        }
        return response()->json('Utente non trovato', 401);
    }

    /**
     * Funzione che consente di impostare il token di reset della password
     * @param string email L'email dell'account da modificare
     * @return La risposta JSON
     */
    public function setToken(Request $request){
        //Carico l'utente dall'email
        $email = $request->input('email');
        $user = User::where('email', $email)->firstOrFail();

        if(isset($user) && !empty($user)){
            //Imposto il token
            $user->reset_token = md5(uniqid(rand(), true));
            $user->save();

            //Creo l'email di modifica
            $link = URL::to('/login/reset/show');
            $link .= "/" . Crypt::encrypt($user->reset_token);
            $body = "<h3>Richiesta di modifica della password</h3>Ci risulta che hai richiesto una modifica della tua password. <br>Se lo hai richiesto te premi il seguente link: <a href='" . $link . "'>Premi qui per cambiare la password</a>";
            $subject = "Modifica la password di 'Valutazione LPI'";

            //Invio l'email
            $mailer = new Mailer();
            if(!$mailer->sendMail($user->email, $body, $subject)){
                response()->json(["Bad Gateway" => "Impossibile inviare l'email"], 502);
            }
            
            response()->json(["Success" => "Token impostato correttamente"], 200);
        }else{
            return response()->json(['error' => "Utente inesistente"], 400);
        } 
    }
          

    /**
     * Funzione che consente di modificare la password di un utente
     * @param string token Il token di reset dell'utente
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON 
     */
    public function changePassword($token, Request $request){
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'min' => "Il campo :attribute deve essere di almeno :min caratteri",
            'max' => "Il campo :attribute deve essere di massimo :max caratteri",
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'repassword' => 'required|min:8'
        ], $messages);
        
        //Verifico che la valutazione sia andata a buon fine.
        if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }
        
        $user = User::where('reset_token', Crypt::decrypt($token))->firstOrFail();
        if(isset($user) && !empty($user)){
            //Verifico che le password siano uguali
            if(!($request->input('password') == $request->input('repassword'))){
                //Se sono diverse ritorno l'errori
                return response()->json(['error' => "Inserire due password corrispondenti"], 400);
            }else{
                //Rimuovo la ripetizione della password per non inserirla nel database
                unset($request['repassword']);
            }
            //Cambio la password
            $options = array(
                'cost' => env('COST'),
            );
            $user->password = password_hash($request['password'],PASSWORD_BCRYPT, $options);
            $user->reset_token = null;

            $user->save();
            return response()->json($user, 200);
        }else{
            return response()->json(['error' => "Utente inesistente"], 400);
        }        
    }

    /**
     * Funzione che consente di modificare la password di un utente al suo primo login
     * @param int id L'id dell'utente
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON 
     */
    public function changeDefaultPassword($id, Request $request){
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'min' => "Il campo :attribute deve essere di almeno :min caratteri",
            'max' => "Il campo :attribute deve essere di massimo :max caratteri",
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'repassword' => 'required|min:8'
        ], $messages);
        
        //Verifico che la valutazione sia andata a buon fine.
        if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }
        
        $user = User::find($id);
        if(isset($user) && !empty($user)){
            //Verifico che le password siano uguali
            if(!($request->input('password') == $request->input('repassword'))){
                //Se sono diverse ritorno l'errori
                return response()->json(['error' => "Inserire due password corrispondenti"], 400);
            }else{
                //Rimuovo la ripetizione della password per non inserirla nel database
                unset($request['repassword']);
            }
            //Cambio la password
            $options = array(
                'cost' => env('COST'),
            );
            $user->password = password_hash($request['password'],PASSWORD_BCRYPT, $options);
            $user->first_login = false;

            $user->save();
            return response()->json($user, 200);
        }else{
            return response()->json(['error' => "Utente inesistente"], 400);
        }    
    }
}
?>