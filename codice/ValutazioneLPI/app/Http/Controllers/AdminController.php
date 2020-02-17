<?php
namespace App\Http\Controllers;

use App\User;
use App\Point;
use App\Justification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
/**
     * Funzione che reindirizza l'utente alla pagina di registrazione.
     */
    public function home(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            $points = Point::all();
            //Se è ammministratore gli mostro la pagina
            return view('admin/index')->with('points', $points);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
       
    }

    /**
     * Funzione che ritorna tutti gli utenti contenuti nel database
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function getUsers(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è amministratore ritorno tutti gli utenti
            return response()->json(User::all());
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
        
    }

    /**
     * Funzione che ritorna l'utente con l'id passato come parametro
     * @param int id L'id dell'utente
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function getUser($id, Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è amministratore ritorno tutti gli utenti
            return response()->json(User::find($id));
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }    
    }

    public function getJustifications(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è amministratore ritorno tutti i form
            return response()->json(Justification::all());
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }  
    }

    /**
     * Funzione che ritorna la motivazione con il codice passato come parametro
     * @param int id L'id della motivazione
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function getJustification($id, Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è amministratore ritorno tutti gli utenti
            return response()->json(Justification::find($id));
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }    
    }

    /**
     * Funzione che consente di aggiungere un utente
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON 
     */
    public function addUser(Request $request){
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'min' => "Il campo :attribute deve essere di almeno :min caratteri",
            'max' => "Il campo :attribute deve essere di massimo :max caratteri",
            'email' => "Il campo :attribute deve essere un indirizzo email valido",
            'numeric' => "Il campo :attribute deve essere di tipo numerico",
            'same' => "Il campo :attribute deve valere 0",
            'unique' => "L':attribute inserita è già in utilizzo",
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'name' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
            'surname' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
            'email' => 'required|email|unique:user',
            'phone' => ['required','min:9','regex:/^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/'],
            'confirmed' => 'required|in:0,1|numeric',
            'id_role' => 'required|numeric'
        ], $messages);
        
        //Verifico che la valutazione sia andata a buon fine.
        if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }
        
        $options = array(
            'cost' => env('COST'),
        );

        $request['password'] = password_hash($request['password'],PASSWORD_BCRYPT, $options);

        //Se la validazione va a buon fine genero l'errore.
        $user = User::create($request->all());

        //Ritorno la risposta di successo.
        return response()->json($user, 201);
    }

    /**
     * Funzione che consente di eliminare un utente
     * @param int id L'id dell'utente
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function deleteUser($id, Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è amministratore cerco l'utente e lo elimino
            User::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }    
    }

    /**
     * Funzione che consente di modificare un utente
     * @param int id L'id dell'utente
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON 
     */
    public function updateUser($id, Request $request){
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'min' => "Il campo :attribute deve essere di almeno :min caratteri",
            'max' => "Il campo :attribute deve essere di massimo :max caratteri",
            'email' => "Il campo :attribute deve essere un indirizzo email valido",
            'numeric' => "Il campo :attribute deve essere di tipo numerico",
            'same' => "Il campo :attribute deve valere 0",
            'unique' => "L':attribute inserita è già in utilizzo",
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'name' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
            'surname' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
            'phone' => ['required','min:9','regex:/^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/'],
            'confirmed' => 'required|in:0,1|numeric',
            'id_role' => 'required|numeric'
        ], $messages);
        
        //Verifico che la valutazione sia andata a buon fine.
        if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }
        
        //Cerco l'utente
        $user = User::findOrFail($id);
        //Eseguo la modifica
        $user->update($request->all());

        //Ritorno l'utente
        return response()->json($user, 200);
    }

/**
     * Funzione che consente di aggiungere una motivazione
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON 
     */
    public function addJustification(Request $request){
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'unique' => "L':attribute inserita è già in utilizzo",
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'text' => 'required',
            'id_point' => 'required|exists:point,code',
        ], $messages);
        
        //Verifico che la valutazione sia andata a buon fine.
        if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }

        //Se la validazione va a buon fine genero l'errore.
        $justification = Justification::create($request->all());

        //Ritorno la risposta di successo.
        return response()->json($justification, 201);
    }

    /**
     * Funzione che consente di eliminare una motivazione
     * @param int id L'id della motivazione
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function deleteJustification($id, Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è amministratore ritorno tutti gli utenti
            Justification::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }    
    }

    /**
     * Funzione che consente di modificare una motivazione
     * @param int id L'id della motivazione
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON 
     */
    public function updateJustification($id, Request $request){
        //Personalizzo i messaggi di errore.
        $messages = [
            'required' => "Il campo :attribute deve essere specificato",
            'exists' => "Il punto scelto non esiste"
        ];

        //Eseguo la validazione dei dati.
        $validation = Validator::make($request->all(), [
            'text' => 'required',
            'id_point' => 'required|exists:point,code'
        ], $messages);
        
        //Verifico che la valutazione sia andata a buon fine.
        if($validation->fails()){
            //Se fallisce ritorno gli errori.
            return response()->json($validation->errors(), '422');
        }
        
        //Cerco la motivazione
        $justification = Justification::findOrFail($id);
        //Eseguo la modifica
        $justification->update($request->all());

        //Ritorno la motivazione
        return response()->json($justification, 200);
    }
}
?>