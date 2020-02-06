<?php
namespace App\Http\Controllers;

use App\User;
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
}
?>