<?php
namespace App\Http\Controllers;

use App\User;
use App\Justification;
use App\Form;
use App\Has;
use App\Contains;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Point;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Funzione che reindirizza l'utente alla pagina dei docenti.
     */
    public function home(){    
        return view('teacher/index');
    }

    /**
     * Funzione che reindirizza l'utente alla pagina di aggiunta di un formulario
     */
    public function showAddPage($id = null){
        $points = Point::where('type', '1');
        if($id != null){
            $form = Form::find($id);
            $has = Has::where('id_form', $id)->get();
            
            return view('teacher/add')->with('points', $points->get())->with('form', $form)->with('has', $has);
        }else{
            return view('teacher/add')->with('points', $points->get())->with('form', 0)->with('has', 0);
        }
        
    }

    /**
     * Funzione che reindirizza l'utente alla pagina di aggiunta di una motivazione ad un formulario
     */
    public function showJustificationPage($id){
        //Carico il formulario da modificare
        $form = Form::find($id);
        
        //Verifico che esista
        if(isset($form) && !empty($form)){
            //Ritorno la pagina
            return view('teacher/justification')->with('form', $form);
        }else{
            //Se non esiste rimando l'utente alla home
            $this->home();
        }
    }

    /**
     * Funzione che reindirizza l'utente alla pagina di ricapitolazione di un formulario
     */
    public function showResultPage($id){
        //Carico il formulario da modificare
        $form = Form::find($id);

        //Verifico che esista
        if(isset($form) && !empty($form)){
            //Ritorno la pagina
            return view('teacher/result')->with('form', $form);
        }else{
            //Se non esiste rimando l'utente alla home
            $this->home();
        }
    }

    /**
     * Funzione che ritorna tutte le motivazioni
     * @param Request request La richiesta eseguita
     * @return La risposta in JSON
     */
    public function getJustifications($id, Request $request){
        //Verifico che l'utente sia un admin
        if($request->all()['user_id_role'] == env('TEACHER')){
            //Se è amministratore ritorno tutte le motivazioni generiche più quelle dei punti specifici scelti
            $query = "select justification.* from point inner join justification on point.code = justification.id_point inner join has on has.id_point = point.code where has.id_form=" . $id . " and point.type = 1 union select justification.* from point right join justification on point.code = justification.id_point where point.type = 0";
            $result = DB::select($query);
            return response()->json($result);
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
        //Verifico che l'utente sia un docente
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
                'exists' => "Il campo :attribute deve già esistere",
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
                'point0' => 'required|min:1|max:255|exists:point,code',
                'point1' => 'required|min:1|max:255|exists:point,code',
                'point2' => 'required|min:1|max:255|exists:point,code',
                'point3' => 'required|min:1|max:255|exists:point,code',
                'point4' => 'required|min:1|max:255|exists:point,code',
                'point5' => 'required|min:1|max:255|exists:point,code',
                'point6' => 'required|min:1|max:255|exists:point,code',
            ], $messages);

            //Verifico che la valutazione sia andata a buon fine.
            if($validation->fails()){
                //Se fallisce ritorno gli errori.
                return response()->json($validation->errors(), '422');
            }

            //Salvo i punti tecnici in un array
            $points = array($request->input('point0'), $request->input('point1'), $request->input('point2'), $request->input('point3'), $request->input('point4'), $request->input('point5'), $request->input('point6'));

            //Verifico se non vi sono duplicati, per ottimizzare verifico solo la prima metà
            $check = array_unique($points);
            if($points != $check){
                return response()->json("Punti specifici duplicati", 422);
            }

            //Rimuovo i campi specifici dalla richiesta
            for($i = 0; $i < 7; $i++){
                $name = "point" . $i;
                $request->request->remove($name);
            }

            //Aggiungo la data di creazione
            $date=date_create();
            $request->request->add(['created' => date_format($date,"Y-m-d h:m")]);

            //Aggiungo l'id dell'utente
            $request->request->add(['id_user' => $request['id']]);

            //Creo il formulario
            $form = Form::create($request->all());

            //Inserisco i punti specifici scelti nel database
            foreach ($points as $point) {
                $conn = new Has();
                $conn->id_form = $form->id;
                $conn->id_point = $point;
                $conn->save();
            }

            //Ritorno la risposta di successo.
            return response()->json($form, 201);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }

    public function updateForm($id, Request $request){
        //Verifico che l'utente sia un docente
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
                'exists' => "Il campo :attribute deve già esistere",
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
                'point0' => 'required|min:1|max:255|exists:point,code',
                'point1' => 'required|min:1|max:255|exists:point,code',
                'point2' => 'required|min:1|max:255|exists:point,code',
                'point3' => 'required|min:1|max:255|exists:point,code',
                'point4' => 'required|min:1|max:255|exists:point,code',
                'point5' => 'required|min:1|max:255|exists:point,code',
                'point6' => 'required|min:1|max:255|exists:point,code',
            ], $messages);

            //Verifico che la valutazione sia andata a buon fine.
            if($validation->fails()){
                //Se fallisce ritorno gli errori.
                return response()->json($validation->errors(), '422');
            }

            //Salvo i punti tecnici in un array
            $points = array($request->input('point0'), $request->input('point1'), $request->input('point2'), $request->input('point3'), $request->input('point4'), $request->input('point5'), $request->input('point6'));

            //Verifico se non vi sono duplicati, per ottimizzare verifico solo la prima metà
            $check = array_unique($points);
            if($points != $check){
                return response()->json("Punti specifici duplicati", 422);
            }

            //Rimuovo i campi specifici dalla richiesta
            for($i = 0; $i < 7; $i++){
                $name = "point" . $i;
                $request->request->remove($name);
            }

            //Aggiungo la data di creazione
            $date=date_create();
            $request->request->add(['modified' => date_format($date,"Y-m-d h:m")]);

            //Aggiungo l'id dell'utente
            $request->request->add(['id_user' => $request['id']]);

            //Cerco la motivazione
            $form = Form::findOrFail($id);
            //Eseguo la modifica
            $form->update($request->all());

            //Inserisco i punti specifici scelti nel database
            Has::where('id_form', $form->id)->delete();
            foreach ($points as $point) {
                $conn = new Has();
                $conn->id_form = $form->id;
                $conn->id_point = $point;
                $conn->save();
            }

            //Ritorno la risposta di successo.
            return response()->json($form, 201);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }

    /**
     * Funzione che consente l'aggiunta di una motivazione ad un formulario
     * @param Request request La richiesta eseguita 
     * @return La risposta in JSON
     */
    public function addJustificationToForm(Request $request){
        if($request->all()['user_id_role'] == env('TEACHER')){
            //Personalizzo i messaggi di errore.
            $messages = [
                'required' => "Il campo :attribute deve essere specificato",
                'numeric' => "Il campo :attribute deve essere di tipo numerico",
                'exists' => "Il campo :attribute deve già esistere",
            ];

            $validation = Validator::make($request->all(), [
                'id_justification' => 'required|numeric|exists:justification,id',
                'id_form' => 'required|numeric|exists:form,id',
            ]);

            //Verifico che la valutazione sia andata a buon fine.
            if($validation->fails()){
                //Se fallisce ritorno gli errori.
                return response()->json($validation->errors(), '422');
            }
            //Se la validazione va a buon fine genero l'errore.
            $contains = Contains::create($request->all());

            //Ritorno la risposta di successo.
            return response()->json($contains, 201);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }

    /**
     * Funzione che consente la rimozione di una motivazione da un formulario
     * @param Request request La richiesta eseguita 
     * @return La risposta in JSON
     */
    public function removeJustificationFromForm($id_form, $id_justification, Request $request){
        if($request->all()['user_id_role'] == env('TEACHER')){
            Contains::where('id_form', $id_form)->where('id_justification', $id_justification)->delete();
            return response('Deleted Successfully', 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }

    /**
     * Funzione che ritorna tutte le motivazioni collegate ad un formulario
     * @param Request request La richiesta eseguita 
     * @param id L'id del formulario
     * @return La risposta in JSON
     */
    public function getFormJustifications($id, Request $request){
        if($request->all()['user_id_role'] == env('TEACHER')){

            $justifications = Contains::where('id_form', $id)->get();

            foreach($justifications as $justification){
                $code = Justification::find($justification->id_justification);
                $justification['title'] = $code['text'];
            }

            //Ritorno la risposta di successo.
            return response()->json($justifications, 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }

    public function getResults($id, Request $request){
        if($request->all()['user_id_role'] == env('TEACHER')){
            $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point like 'A%' and contains.id_form = " . $id;
            $resultA = DB::select($query);
            $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point like 'B%' and contains.id_form = " . $id;
            $resultB = DB::select($query);
            $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point like 'C%' and contains.id_form = " . $id;
            $resultC = DB::select($query);
            $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point NOT REGEXP '[a-zA-Z]' and contains.id_form = " . $id;
            $resultPoints = DB::select($query);
            $result = array("A" => $resultA, "B" => $resultB, "C" => $resultC, "points" => $resultPoints);
            return response()->json($result, 200);
        }else{
            //Se non lo è ritorno l'errore
            return response()->json(['Unauthorized' => 'Non hai i permessi necessari per accedere'], 401);
        }
    }
}