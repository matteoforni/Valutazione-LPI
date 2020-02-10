<?php
namespace App\Http\Controllers;

use App\User;
use App\Justification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
/**
     * Funzione che reindirizza l'utente alla pagina di registrazione.
     */
    public function home(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è ammministratore gli mostro la pagina
            return view('admin/index');
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
     * Funzione che consente di eliminare un utente
     * @param int id L'id dell'utente
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function deleteUser($id, Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['id_role'] == 2){
            //Se è amministratore ritorno tutti gli utenti
            User::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }    
    }

    public function updateUser($request, $id){
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'surname' => 'required',
            'nationality' => 'required'
        ]);
        
        $author = User::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
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

    public function updateJustification($id){
        
    }
}
?>