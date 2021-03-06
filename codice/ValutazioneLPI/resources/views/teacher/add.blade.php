@extends('_templates/teacher_header')

@section('title', 'Aggiunta')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <form id="addFormForm" class="text-center border border-light p-5 mt-3 my-5 md-form">
            <p id="pageTitle" class="h4 mb-4"></p>

            <input type="text" id="title" name="title" class="form-control mb-4" placeholder="Titolo del progetto" minlength="1" maxlength="255" required>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sullo studente <b class="text-danger">*</b></p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Student first name -->
                        <input type="text" id="student_name" name="student_name" class="form-control mb-4" placeholder="Nome dello studente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Student last name -->
                        <input type="text" id="student_surname" name="student_surname" class="mb-4 form-control" placeholder="Cognome dello studente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Student E-mail -->
                        <input type="email" id="student_email" name="student_email" class="form-control mb-4" placeholder="E-mail dello studente" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Student Phone number -->
                        <input type="text" id="student_phone" name="student_phone" class="form-control mb-4" placeholder="Numero di telefono dello studente" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sul docente responsabile <b class="text-danger">*</b></p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher first name -->
                        <input type="text" id="teacher_name" name="teacher_name" class="form-control mb-4" placeholder="Nome del docente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher last name -->
                        <input type="text" id="teacher_surname" name="teacher_surname" class="mb-4 form-control" placeholder="Cognome del docente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher E-mail -->
                        <input type="email" id="teacher_email" name="teacher_email" class="form-control mb-4" placeholder="E-mail del docente" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher Phone number -->
                        <input type="text" id="teacher_phone" name="teacher_phone" class="form-control mb-4" placeholder="Numero di telefono del docente" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sul primo perito</p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher first name -->
                        <input type="text" id="expert1_name" name="expert1_name" class="form-control mb-4" placeholder="Nome del primo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher last name -->
                        <input type="text" id="expert1_surname" name="expert1_surname" class="mb-4 form-control" placeholder="Cognome del primo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher E-mail -->
                        <input type="email" id="expert1_email" name="expert1_email" class="form-control mb-4" placeholder="E-mail del primo perito">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher Phone number -->
                        <input type="text" id="expert1_phone" name="expert1_phone" class="form-control mb-4" placeholder="Numero di telefono del primo perito" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$">
                    </div>
                </div>
            </div>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sul secondo perito</p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher first name -->
                        <input type="text" id="expert2_name" name="expert2_name" class="form-control mb-4" placeholder="Nome del secondo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher last name -->
                        <input type="text" id="expert2_surname" name="expert2_surname" class="mb-4 form-control" placeholder="Cognome del secondo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher E-mail -->
                        <input type="email" id="expert2_email" name="expert2_email" class="form-control mb-4" placeholder="E-mail del secondo perito">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher Phone number -->
                        <input type="text" id="expert2_phone" name="expert2_phone" class="form-control mb-4" placeholder="Numero di telefono del secondo perito" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$">
                    </div>
                </div>
            </div>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Punti di valutazione specifici <b class="text-danger">*</b></p>
                <select id="pointSelect" name="id_point" class="point-select browser-default custom-select">
                    <option selected disabled value="default">Seleziona un punto</option>
                </select>
                <button type="button" class="btn btn-sm btn-info btn-block" onclick="addPoint()">Seleziona</button>
                <!-- CONTENGONO LE SCELTE FATTE -->
                <div id="pointsSelected" class="row mt-2">
                    <div id="0" class="col-md-1 m-auto">
                        <i class='far fa-trash-alt' style='display:none' onclick="deleteSelection(this)"></i>
                    </div>
                    <div id="1" class="col-md-1 m-auto">
                        <i class='far fa-trash-alt' style='display:none' onclick="deleteSelection(this)"></i>
                    </div>
                    <div id="2" class="col-md-1 m-auto">
                        <i class='far fa-trash-alt' style='display:none' onclick="deleteSelection(this)"></i>
                    </div>
                    <div id="3" class="col-md-1 m-auto">
                        <i class='far fa-trash-alt' style='display:none' onclick="deleteSelection(this)"></i>
                    </div>
                    <div id="4" class="col-md-1 m-auto">
                        <i class='far fa-trash-alt' style='display:none' onclick="deleteSelection(this)"></i>
                    </div>
                    <div id="5" class="col-md-1 m-auto">
                        <i class='far fa-trash-alt' style='display:none' onclick="deleteSelection(this)"></i>
                    </div>
                    <div id="6" class="col-md-1 m-auto">
                        <i class='far fa-trash-alt' style='display:none' onclick="deleteSelection(this)"></i>
                    </div>
                </div>
            </div>

            <p class="text-left">I riquadri contrassegnati da un <b class="text-danger">*</b> sono richiesti</p>

            <button id="finalButton" class="btn btn-info my-4 btn-block"></button>
        </form>
    </div>
    <div class="col-md-3 my-5">
        <div class="errors text-danger">

        </div>
    </div>
</div>
<script>
    let formContent = 0;
    $(document).ready(function(){
        //Ottengo dal controller i punti di valutazione
        var points = <?php echo $points ?>;

        //Ottengo dal controller il formulario che si sta modificando
        formContent = <?php echo $form ?>;

        if(formContent != 0){
            var has = <?php echo $has ?>;
            fillForm(formContent, has);
            $('#pageTitle').text("Modifica il formulario");
            $('#finalButton').text("Modifica");
        }else{
            $('#pageTitle').text("Aggiungi un formulario");
            $('#finalButton').text("Aggiungi");
        }

        //Genero le opzioni del select
        for(var i = 0; i < points.length; i++){
            //Creo l'opzione
            var option = new Option(points[i]['code'], points[i]['code']);
            $(option).html(points[i]['title']);
            //La aggiungo alla select
            $(".point-select").append(option);
        }

        $(function () {
            $("#pointSelect").select2();
        });
    });
    //All'evento di submit del form eseguo la richiesta al server con AJAX
    $("#addFormForm").submit(function( event ) {
        //Blocco l'evento di default del form (aggiunta del URL get)
        event.preventDefault();
        //Ottengo i dati dal form
        var jsonData = $(this).serializeArray();
        //Formatto i dati del form nel formato necessario per eseguire la richiesta
        var form = {};
        for(var index in jsonData) {
            var json = jsonData[index];
            form[json.name] = json.value;
        }

        //Verifico se è una modifica o una aggiunta
        if(formContent != 0){
            var link = "{{ url('teacher/form/update') }}";
            link += "/" + formContent['id'];
            var type = "put";
        }else{
            var link = "{{ url('teacher/form/add') }}";
            var type = "post";
        }
        //Eseguo la richiesta post al controller
        $.ajax({
            type: type,
            url: link,
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json",      
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },       
            complete: function(response){
                //Se il server ritorna il codice di successo rimando all'utente alla pagina dei docenti
                if(response["status"] == 201){
                    var id = response["responseJSON"]['id'];
                    var link = "{{ url('teacher/form/add/justification') }}";
                    link += "/" + id;
                    window.location = link;
                }else{
                    if(response["status"] == 401){
                        window.location = "{{ url('') }}";
                    }else{
                        //Se il server ritorna un errore stampo gli errori    
                        //Formatto gli errori
                        var errors = [];
                        for(key in response["responseJSON"]) {
                            errors.push(response["responseJSON"][key]);
                        }
                        //Stampo gli errori
                        for(i = 0; i < errors.length; i++){
                            $(".errors").append("<h6>" + errors[i] + "</h6>");
                        }
                    }
                }
            }
        });
    });

    //Funzione che aggiunge i messaggi di errore quando i campi sono invalidi
    $(function(){
        //Messaggio per il campo titolo
        $("#title")[0].oninvalid = function () {
            this.setCustomValidity("Il titolo deve essere di almeno 1 carattere");
        };
        //Messaggio per il campo nome
        $("#student_name")[0].oninvalid = function () {
            this.setCustomValidity("Il nome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo cognome
        $("#student_surname")[0].oninvalid = function () {
            this.setCustomValidity("Il cognome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo email
        $("#student_email")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un email valida");
        };
        //Messaggio per il campo telefono
        $("#student_phone")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un numero di telefono valido");
        };
        //Messaggio per il campo nome
        $("#teacher_name")[0].oninvalid = function () {
            this.setCustomValidity("Il nome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo cognome
        $("#teacher_surname")[0].oninvalid = function () {
            this.setCustomValidity("Il cognome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo email
        $("#teacher_email")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un email valida");
        };
        //Messaggio per il campo telefono
        $("#teacher_phone")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un numero di telefono valido");
        };
        //Messaggio per il campo nome
        $("#expert1_name")[0].oninvalid = function () {
            this.setCustomValidity("Il nome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo cognome
        $("#expert1_surname")[0].oninvalid = function () {
            this.setCustomValidity("Il cognome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo email
        $("#expert1_email")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un email valida");
        };
        //Messaggio per il campo telefono
        $("#expert1_phone")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un numero di telefono valido");
        };
        //Messaggio per il campo nome
        $("#expert2_name")[0].oninvalid = function () {
            this.setCustomValidity("Il nome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo cognome
        $("#expert2_surname")[0].oninvalid = function () {
            this.setCustomValidity("Il cognome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo email
        $("#expert2_email")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un email valida");
        };
        //Messaggio per il campo telefono
        $("#expert2_phone")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un numero di telefono valido");
        };
    });

    //Funzione che rimuove i messaggi di errore dai campi
    $(function(){
        //Messaggio per il campo titolo
        $("#title")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo nome
        $("#student_name")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo cognome
        $("#student_surname")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo email
        $("#student_email")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo telefono
        $("#student_phone")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo nome
        $("#teacher_name")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo cognome
        $("#teacher_surname")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo email
        $("#teacher_email")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo telefono
        $("#teacher_phone")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo nome
        $("#expert1_name")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo cognome
        $("#expert1_surname")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo email
        $("#expert1_email")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo telefono
        $("#expert1_phone")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo nome
        $("#expert2_name")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo cognome
        $("#expert2_surname")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo email
        $("#expert2_email")[0].oninput = function () {
            this.setCustomValidity("");
        };
        //Messaggio per il campo telefono
        $("#expert2_phone")[0].oninput = function () {
            this.setCustomValidity("");
        };
    });

    /*
    * Array contenente le posizioni libere dove inserire le scelte
    */
    let empty = Array(0,1,2,3,4,5,6);

    /**
     * Funzione che aggiunge alla lista di selezioni il punto appena scelto
     */
    function addPoint(){
        //Seleziono il punto e verifico che non sia quello di default
        var point = $("#pointSelect option:selected");
        if($(point).val() != "default"){ 
            //Riordino l'array e ottengo la prima casella libera
            empty.sort();
            var div = $("#pointsSelected").children().eq(empty[0]);
            
            //Aggiungo il testo al div
            $(div).append("<input name='point" + empty[0] + "' class='border-0' value='" + point.val() + "'/>");

            empty.splice(0,1);
            var divs = $("#pointsSelected").children();

            //Disabilito il punto appena selezionato
            $(point).attr('disabled', 'disabled');
            
            //All'hover della lista di selezioni
            $("#pointsSelected").mouseenter(function(){
                //Mostro il tasto di eliminazione solo per i div già riempiti
                for(var i = 0; i < $("#pointsSelected").children().length; i++){
                    if($("#pointsSelected").children().eq(i).children().length > 1){
                        $("#pointsSelected").children().eq(i).children().eq(0).fadeIn(0);
                    }
                }
            });

            //Alla rimozione del mouse da sopra la lista di selezioni
            $("#pointsSelected").mouseleave(function(){
                //Nascondo i tasti di eliminazione
                for(var i = 0; i < $("#pointsSelected").children().length; i++){
                    if($("#pointsSelected").children().eq(i).children().length > 1){
                        $("#pointsSelected").children().eq(i).children().eq(0).fadeOut(0);
                    }
                }
            });

            $("#pointSelect").val("default");

            //Se si hanno inserito tutti i punti disabilito la selezione 
            if(empty.length == 0){
                $("#pointSelect").attr('disabled', 'disabled');
            }
        }
    }

    /**
     * Funzione che rimuove dalla lista di selezioni il punto scelto
     */
    function deleteSelection(element){
        //Seleziono il div da cui rimuovere il testo e lo rimuovo
        var div = $(element).parent();
        var text = $(div).children().eq(1);
        text.remove();
        //Riabilito la selezione dell'opzione appena rimossa
        $("#pointSelect option[value='"+ text.val() + "']").removeAttr('disabled');

        //Nascondo il bottone di eliminazione
        $(element).fadeOut(0);

        //Riabilito la selezione
        $("#pointSelect").removeAttr('disabled');
        
        //Notifico che vi è un posto libero nella lista
        empty.push($(div).attr('id'));
    }

    /**
    * Funzione che compila i campi se si apre la pagina per modificare un formulario
    */
    function fillForm(form, has){
        $('#title').val(form['title']);
        $('#student_name').val(form['student_name']);
        $('#student_surname').val(form['student_surname']);
        $('#student_email').val(form['student_email']);
        $('#student_phone').val(form['student_phone']);

        $('#teacher_name').val(form['teacher_name']);
        $('#teacher_surname').val(form['teacher_surname']);
        $('#teacher_email').val(form['teacher_email']);
        $('#teacher_phone').val(form['teacher_phone']);

        $('#expert1_name').val(form['expert1_name']);
        $('#expert1_surname').val(form['expert1_surname']);
        $('#expert1_email').val(form['expert1_email']);
        $('#expert1_phone').val(form['expert1_phone']);

        $('#expert2_name').val(form['expert2_name']);
        $('#expert2_surname').val(form['expert2_surname']);
        $('#expert2_email').val(form['expert2_email']);
        $('#expert2_phone').val(form['expert2_phone']);

        $.each(has, function(i){
            var value = has[i]['id_point'];
            $('#pointSelect').ready(function(){
                $("#pointSelect option[value=" + value + "]").attr('selected', 'selected'); 
                addPoint();
            });
           
        });
    }
</script>
@endsection