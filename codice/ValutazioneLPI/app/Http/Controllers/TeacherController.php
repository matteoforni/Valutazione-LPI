<?php
namespace App\Http\Controllers;

use App\User;
use App\Justification;
use App\Form;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Funzione che reindirizza l'utente alla pagina dei docenti.
     */
    public function home(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == 1){
            $user = User::find($request->id);
            //Se è docente gli mostro la pagina
            return view('teacher/index')->with('user', $user);;
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }

    /**
     * Funzione che reindirizza l'utente alla pagina di aggiunta di un formulario
     */
    public function showAddPage(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == 1){
            //Se è docente gli mostro la pagina
            return view('teacher/add');
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }

    /**
     * Funzione che ritorna tutti i formulari contenuti nel database
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function getForms(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == 1){
            //Se è amministratore ritorno tutti i formulari
            $forms = response()->json(Form::all());
            return $forms;
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
        
    }

    /**
     * Funzione che consente di eliminare un formulario
     * @param int id L'id del formulario
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function deleteForm($id, Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == 1){
            Form::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }    
    }
}