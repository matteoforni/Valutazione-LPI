<?php
namespace App\Http\Controllers;

use App\User;
use App\Justification;
use App\Form;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
/**
     * Funzione che reindirizza l'utente alla pagina di registrazione.
     */
    public function home(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == 1){
            $user = User::find($request->id);
            //Se è ammministratore gli mostro la pagina
            return view('teacher/index')->with('user', $user);;
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
    public function getForms(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == 1){
            //Se è amministratore ritorno tutti gli utenti
            return response()->json(Form::all());
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
        
    }
}