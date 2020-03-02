<?php
namespace App\Http\Controllers;

use App\User;
use App\Justification;
use App\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Funzione che reindirizza l'utente alla pagina dei docenti.
     */
    public function home(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == env('TEACHER')){
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
        if($request->all()['user_id_role'] == env('TEACHER')){
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
        if($request->all()['user_id_role'] == env('TEACHER')){
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
        if($request->all()['user_id_role'] == env('TEACHER')){
            Form::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }    
    }

    /**
     * Funzione che consente l'aggiunta di un formulario
     * @param Request request La richiesta eseguita 
     * @return La risposta in JSON
     */
    public function addForm(Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == env('TEACHER')){
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
                'title' => 'required|min:1|max:255',
                'student_name' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
                'student_surname' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
                'student_email' => 'required|email',
                'student_phone' => ['required','min:9','regex:/^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/'],
                'teacher_name' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
                'teacher_surname' => ['required','min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/'],
                'teacher_email' => 'required|email',
                'teacher_phone' => ['min:9','regex:/^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/'],
                'expert1_name' => ['min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/', 'nullable'],
                'expert1_surname' => ['min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/', 'nullable'],
                'expert1_email' => 'email|nullable',
                'expert1_phone' => ['min:9','regex:/^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/', 'nullable'],
                'expert2_name' => ['min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/', 'nullable'],
                'expert2_surname' => ['min:2','max:100','regex:/[ A-Za-zÀ-ÖØ-öø-ÿ]+/', 'nullable'],
                'expert2_email' => 'email|nullable',
                'expert2_phone' => ['min:9','regex:/^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$/', 'nullable'],
            ], $messages);

             //Verifico che la valutazione sia andata a buon fine.
             if($validation->fails()){
                //Se fallisce ritorno gli errori.
                return response()->json($validation->errors(), '422');
            }

            //Aggiungo la data di creazione
            $date=date_create();
            $request->request->add(['created' => date_format($date,"Y-m-d h:m")]);

            //Aggiungo l'id dell'utente
            $request->request->add(['id_user' => $request['id']]);

            //Se la validazione va a buon fine genero l'errore.
            $form = Form::create($request->all());

            //Ritorno la risposta di successo.
            return response()->json($form, 201);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }
}