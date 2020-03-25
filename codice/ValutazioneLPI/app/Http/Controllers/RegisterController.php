<?php
namespace App\Http\Controllers;

use App\User;
use App\Mailer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    /**
     * Funzione che reindirizza l'utente alla pagina di registrazione.
     */
    public function home(){
        return view('register/index');
    }

    /**
     * Funzione che consente di registrare un utente.
     * @param Request request La richiesta generata dall'utente.
     * @return Response La risposta JSON
     */
    public function register(Request $request)
    {
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'min' => "Il campo :attribute deve essere di almeno :min caratteri",
            'max' => "Il campo :attribute deve essere di massimo :max caratteri",
            'email' => "Il campo :attribute deve essere un indirizzo email valido",
            'numeric' => "Il campo :attribute deve essere di tipo numerico",
            'same' => "Il campo :attribute deve valere 0",
            'unique' => "Il campo :attribute inserito è già in utilizzo",
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'name' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
            'surname' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
            'phone' => ['required','min:9','regex:/^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/','unique:user'],
            'email' => 'required|email|unique:user',
            'password' => 'required|min:8',
            'repassword' => 'required|min:8',
            'confirmed' => 'required|in:0,1|numeric',
            'id_role' => 'required|numeric',
        ], $messages);
        
        //Verifico che la valutazione sia andata a buon fine.
        if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }

        //Verifico che le password siano uguali
        if(!($request->input('password') == $request->input('repassword'))){
            //Se sono diverse ritorno l'errori
            return response()->json(['error' => "Inserire due password corrispondenti"], 400);
        }else{
            //Rimuovo la ripetizione della password per non inserirla nel database
            unset($request['repassword']);
        }
        
        $request->request->add(['first_login'=> 0]);

        $request['id_role'] = 1;

        $options = array(
            'cost' => env('COST'),
        );

        $request['password'] = password_hash($request['password'],PASSWORD_BCRYPT, $options);

        //Se la validazione va a buon fine genero l'errore.
        $user = User::create($request->all());

        //Imposto il token di conferma
        $user->confirmation_token = md5(uniqid(rand(), true));
        $user->save();

        //Invio l'email di conferma della creazione
        $link = URL::to('/login/confirmation');
        $link .= "/" . Crypt::encrypt($user->confirmation_token);
        $body = "<h3>Conferma la tua email</h3>Hai creato con successo il tuo account di 'Valutazione LPI', conferma la tua email per completare l'operazione <br><a href='" . $link . "'>Premi qui per confermare l'email</a>";
        $subject = "Nuovo account di 'Valutazione LPI'";

        $mailer = new Mailer();
        if(!$mailer->sendMail($user->email, $body, $subject)){
            response()->json(["Bad Gateway" => "Impossibile inviare l'email"], 502);
        }

        //Ritorno la risposta di successo.
        return response()->json($user, 201);
    }
}
?>