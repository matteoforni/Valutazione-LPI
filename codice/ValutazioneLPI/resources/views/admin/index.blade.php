@extends('_templates/admin_header')

@section('title', 'Amministrazione')

@section('content')
<div class="row">
    <div class="col-md-8 text-center offset-2">
        <h3 class="h3 text-center my-5">Gestione motivazioni</h3>
        <div class="errors-justification text-danger">

        </div>
        <div class="justifications-table table-responsive mb-5">
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addJustificationModal">Aggiungi motivazione</button>
    </div>
    
    <div class="col-md-12 text-center my-5">
        <h3 class="h3 text-center my-5">Gestione utenti</h3>
        <div class="errors-user text-danger">

        </div>
        <div class="users-table table-responsive mb-5">
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Aggiungi utente</button>
    </div>
</div>

<!-- MODALE DI AGGIUNTA DI UN UTENTE -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserTitle"
  aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="addUserTitle">Aggiungi utente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addUserForm" class="text-center border border-light p-5 mt-3 m-5 md-form">
            <p class="h4 mb-4">Aggiungi un utente</p>

            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <input type="text" id="name" name="name" class="form-control mb-4" placeholder="Nome" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <input type="text" id="surname" name="surname" class="mb-4 form-control" placeholder="Cognome" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                </div>
            </div> 

            <!-- E-mail -->
            <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" required>

            <!-- Phone number -->
            <input type="text" id="phone" name="phone" class="form-control mb-4" placeholder="Numero di telefono" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$" required>

            <select id="roleSelect" name="id_role" class="role-select mb-4 browser-default custom-select">
                <option selected disabled>Seleziona un ruolo</option>
            </select>

            <input type="number" hidden name="confirmed" value="0">

            <div class="text-center">
                <button class="btn btn-info btn-block">Registra l'utente</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!-- MODALE DI AGGIUNTA DI UNA MOTIVAZIONE -->
<div class="modal fade" id="addJustificationModal" tabindex="-1" role="dialog" aria-labelledby="addJustificationTitle"
  aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="addJustificationTitle">Aggiungi motivazione</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addJustificationForm" class="text-center border border-light p-5 mt-3 m-5 md-form">
            <p class="h4 mb-4">Aggiungi una motivazione</p>

            <div class="md-form">
                <textarea id="text" class="form-control md-textarea" name="text" maxlength="1000" length="1000" rows="4"></textarea>
                <label for="textarea-char-counter">Inserisci il testo</label>
            </div>

            <select id="pointSelect" name="id_point" class="point-select browser-default custom-select">
                <option selected disabled>Seleziona un punto</option>
            </select>
            <p id="pointText" class="mt-3"></p>

            <div class="text-center">
                <button class="btn btn-info btn-block">Aggiungi la motivazione</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!-- MODALE DI MODIFICA DI UNA MOTIVAZIONE -->
<div class="modal fade" id="updateJustificationModal" tabindex="-1" role="dialog" aria-labelledby="updateJustificationTitle"
  aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="updateJustificationTitle" class="modal-title w-100" id="addUserTitle"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateJustificationForm" class="text-center border border-light p-5 mt-3 m-5 md-form">
            <p class="h4 mb-4">Modifica la motivazione</p>

            <div class="md-form">
                <textarea id="textUpdate" class="form-control md-textarea" name="text" maxlength="1000" length="1000" rows="4"></textarea>
            </div>

            <select id="pointUpdateSelect" name="id_point" class="point-select browser-default custom-select">
                <option selected disabled>Seleziona un punto</option>
            </select>
            <p id="pointText" class="mt-3"></p>

            <div class="text-center">
                <button class="btn btn-info btn-block">Modifica la motivazione</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!-- MODALE DI MODIFICA DI UN UTENTE -->
<div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserTitle"
  aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="updateUserTitle"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateUserForm" class="text-center border border-light p-5 mt-3 m-5 md-form">
            <p class="h4 mb-4">Modifica l'utente</p>

            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <input type="text" id="nameUpdate" name="name" class="form-control mb-4" placeholder="Nome" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <input type="text" id="surnameUpdate" name="surname" class="mb-4 form-control" placeholder="Cognome" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                </div>
            </div> 

            <!-- E-mail -->
            <input type="email" id="emailUpdate" name="email" class="form-control mb-4" placeholder="E-mail" required disabled>

            <!-- Phone number -->
            <input type="text" id="phoneUpdate" name="phone" class="form-control mb-4" placeholder="Numero di telefono" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$" required>

            <select id="roleUpdateSelect" name="id_role" class="role-select mb-4 browser-default custom-select">
                <option selected disabled>Seleziona un ruolo</option>
            </select>

            <div class="text-center">
                <button class="btn btn-info btn-block">Modifica l'utente</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!-- MODALE DI ELIMINAZIONE DI UNA MOTIVAZIONE -->
<div class="modal fade" id="deleteJustificationModal" tabindex="-1" role="dialog" aria-labelledby="deleteJustificationTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-md .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="deleteJustificationTitle">Conferma eliminazione</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p id="justificationMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteJustification()">Elimina</button>
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!-- MODALE DI ELIMINAZIONE DI UN UTENTE -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteTitle"
  aria-hidden="true">

  <div class="modal-dialog modal-md .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="deleteTitle">Conferma eliminazione</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p id="userMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser()">Elimina</button>
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    /**
     * L'ultimo link di eliminazione premuto
     */
    let deleteLink;

    /**
     * L'ultima motivazione modificata
     */
    let lastUpdatedJustification;

    /**
     * L'ultimo utente modificato
     */
    let lastUpdatedUser;

    //Quando il documento è stato caricato completamente
    $(document).ready(function(){
        //Creo le tabelle
        createJustificationTable();
        createUserTable();
        //Ottengo dal controller i punti di valutazione
        var points = <?php echo $points ?>;
        //Alla selezione di un punto
        $("#pointSelect").change(function() {
            //Trovo il punto che contenga il valore selezionato nel select
            var value = this.value;
            var point = points.find(function(element) {
                return element['code'] === value; 
            }); 
            //Scrivo il titolo del punto
            $("#pointText").text(point['title']);
        });
        //Genero le opzioni del select
        for(var i = 0; i < points.length; i++){
            //Creo l'opzione
            var option = new Option(points[i]['code'], points[i]['code']);
            $(option).html(points[i]['code']);
            //La aggiungo alla select
            $(".point-select").append(option);
        }

        //Ottengo dal controller i punti di valutazione
        var roles = <?php echo $roles ?>;
        //Alla selezione di un ruolo
        $("#roleSelect").change(function() {
            //Trovo il ruolo che contenga il valore selezionato nel select
            var value = $("#roleSelect option:selected").text();
            var role = roles.find(function(element) {
                return element['name'] === value; 
            }); 
            //Scrivo il titolo del ruolo
            $("#roleText").text(role['name']);
        });
        //Genero le opzioni del select
        for(var i = 0; i < roles.length; i++){
            //Creo l'opzione
            var option = new Option(roles[i]['name'], roles[i]['id']);
            $(option).html(roles[i]['name']);
            //La aggiungo alla select
            $(".role-select").append(option);
        }
    });

    //Quando viene eseguito il submit nel form di aggiunta di un utente 
    $("#addUserForm").submit(function( event ) {
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
        //Eseguo la richiesta post al controller admin con metodo add
        $.ajax({
            type: "post",
            url: "{{ url('admin/user/add') }}",
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },            
            complete: function(response){
                $('#addUserModal').modal('hide');
                console.log(response['responseJSON']);
                //Se il server ritorna il codice di successo ricarico la tabella
                if(response["status"] == 201){
                    createUserTable();
                    toastr.success('Utente aggiunto con successo');
                //Se il server ritorna un errore stampo gli errori     
                }else if(response["status"] == 502){
                    toastr.success("Impossibile inviare l'email");
                }else{
                    //Formatto gli errori
                    var errors = [];
                    for(key in response["responseJSON"]) {
                        errors.push(response["responseJSON"][key]);
                    }
                    //Stampo gli errori
                    for(i = 0; i < errors.length; i++){
                        $(".errors-user").append("<h6>" + errors[i] + "</h6>");
                    }
                }
            }
        });
    });

    //Quando viene eseguito il submit nel form di aggiunta di una motivazione 
    $("#addJustificationForm").submit(function( event ) {
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
        //Eseguo la richiesta post al controller admin con metodo add
        $.ajax({
            type: "post",
            url: "{{ url('admin/justification/add') }}",
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },            
            complete: function(response){
                $('#addJustificationModal').modal('hide');
                //Se il server ritorna il codice di successo ricarico la tabella
                if(response["status"] == 201){
                    createJustificationTable();
                    toastr.success('Motivazione aggiunta con successo');
                //Se il server ritorna un errore stampo gli errori     
                }else{
                    //Formatto gli errori
                    var errors = [];
                    for(key in response["responseJSON"]) {
                        errors.push(response["responseJSON"][key]);
                    }
                    //Stampo gli errori
                    for(i = 0; i < errors.length; i++){
                        $(".errors-justification").append("<h6>" + errors[i] + "</h6>");
                    }
                }
            }
        });
    });

    //Quando viene eseguito il submit nel form di modifica di un utente 
    $("#updateUserForm").submit(function( event ) {
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
        //Eseguo la richiesta post al controller admin con metodo add
        var link = "{{ url('admin/user/update') }}";
        link += "/" + lastUpdatedUser;
        $.ajax({
            type: "put",
            url: link,
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },            
            complete: function(response){
                $('#updateUserModal').modal('hide');
                //Se il server ritorna il codice di successo ricarico la tabella
                if(response["status"] == 200){
                    createUserTable();
                    toastr.success('Utente modificato con successo');
                //Se il server ritorna un errore stampo gli errori     
                }else{
                    //Formatto gli errori
                    var errors = [];
                    for(key in response["responseJSON"]) {
                        errors.push(response["responseJSON"][key]);
                    }
                    //Stampo gli errori
                    for(i = 0; i < errors.length; i++){
                        $(".errors-user").append("<h6>" + errors[i] + "</h6>");
                    }
                }
            }
        });
    });

    //Quando viene eseguito il submit nel form di modifica di una motivazione 
    $("#updateJustificationForm").submit(function( event ) {
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
        //Eseguo la richiesta post al controller admin con metodo add
        var link = "{{ url('admin/justification/update') }}";
        link += "/" + lastUpdatedJustification;
        $.ajax({
            type: "put",
            url: link,
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },            
            complete: function(response){
                $('#updateJustificationModal').modal('hide');
                //Se il server ritorna il codice di successo ricarico la tabella
                if(response["status"] == 200){
                    createJustificationTable();
                    toastr.success('Motivazione modificata con successo');
                //Se il server ritorna un errore stampo gli errori     
                }else{
                    //Formatto gli errori
                    var errors = [];
                    for(key in response["responseJSON"]) {
                        errors.push(response["responseJSON"][key]);
                    }
                    //Stampo gli errori
                    for(i = 0; i < errors.length; i++){
                        $(".errors-justification").append("<h6>" + errors[i] + "</h6>");
                    }
                }
            }
        });
    });

    //Funzione che aggiunge i messaggi di errore quando i campi sono invalidi
    $(function(){
        //Messaggio per il campo nome
        $("#name")[0].oninvalid = function () {
            this.setCustomValidity("Il nome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo cognome
        $("#surname")[0].oninvalid = function () {
            this.setCustomValidity("Il cognome deve essere di almeno 2 caratteri e contenere solo lettere");
        };
        //Messaggio per il campo email
        $("#email")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un indirizzo email valido");
        };
        //Messaggio per il campo telefono
        $("#phone")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un numero di telefono valido");
        };
        //Messaggio per il campo text delle motivazioni
        $("#text")[0].oninvalid = function() {
            this.setCustomValidity("Inserire un testo valido");
        }
    });

    //Funzione che rimuove i messaggi di errore dai campi
    $(function(){
        //Rimozione del messaggio per il campo nome
        $("#name")[0].oninput= function () {
            this.setCustomValidity("");
        };
        //Rimozione del messaggio per il campo cognome
        $("#surname")[0].oninput= function () {
            this.setCustomValidity("");
        };
        //Rimozione del messaggio per il campo email
        $("#email")[0].oninput= function () {
            this.setCustomValidity("");
        };
        //Rimozione del messaggio per il campo telefono
        $("#phone")[0].oninput= function () {
            this.setCustomValidity("");
        };
        //Rimozione del messaggio per il campo text delle motivazioni
        $("#text")[0].oninput= function () {
            this.setCustomValidity("");
        };
    });

    /**
     * Funzione che consente di creare la tabella delle motivazioni
     */ 
    function createJustificationTable(){
        //Richiedo i dati per riempire la tabella
        $.ajax({
            type: "get",
            url: "{{ url('admin/justifications') }}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",     
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },       
            complete: function(response){
                //Se il server ritorna il codice di successo genero la tabella
                if(response["status"] == 200){
                    var table = JSONToHTML('Justification', response["responseJSON"]);
                    $(".justifications-table").html(table);  
                    $("#Justification").DataTable({
                        "searching": true,
                        "ordering": false,
                        "bLengthChange": false,
                        "info" : false,
                        "iDisplayLength": 5,
                        "oLanguage": {
                            "sEmptyTable": "Nessuna motivazione da mostrare",
                            "sSearch": "Cerca motivazioni",
                            "oPaginate": {
                                "sFirst": "Prima pagina",
                                "sPrevious": "Pagina precedente", 
                                "sNext": "Prossima pagina", 
                                "sLast": "Ultima pagina"
                            }
                        }
                    });
                    
                    setJustificationLinks();

                    //Reimposto i links quando si cambia pagina nella tabella   
                    $('#Justification').on('page.dt', function () {
                        setJustificationLinks();
                    });
                }else if(response["status"] = 401){
                    window.location = "url('')";
                }       
            }
        });
    }

    /**
     * Funzione che consente di creare la tabella degli utenti 
     */
    function createUserTable(){
        //Richiedo i dati per riempire la tabella
        $.ajax({
            type: "get",
            url: "{{ url('admin/users') }}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",     
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },       
            complete: function(response){
                //Se il server ritorna il codice di successo genero la tabella
                if(response["status"] == 200){
                    var data = [];
                    for(var item in response["responseJSON"]){
                        var obj = {'id': response["responseJSON"][item]['id'], 'nome': response["responseJSON"][item]['name'], 'cognome': response["responseJSON"][item]['surname'], 'Email': response["responseJSON"][item]['email'], 'telefono': response["responseJSON"][item]['phone'], 'ruolo': response["responseJSON"][item]['role']};
                        data.push(obj);
                    }

                    var table = JSONToHTML('User', data);
                    $(".users-table").html(table);  
                    $("#User").DataTable({
                        "searching": true,
                        "ordering": false,
                        "bLengthChange": false,
                        "info" : false,
                        "iDisplayLength": 5,
                        "oLanguage": {
                            "sEmptyTable": "Nessun utente da mostrare",
                            "sSearch": "Cerca utenti",
                            "oPaginate": {
                                "sFirst": "Prima pagina",
                                "sPrevious": "Pagina precedente", 
                                "sNext": "Prossima pagina", 
                                "sLast": "Ultima pagina"
                            }
                        }
                    });
                    
                    setUserLinks();

                    //Reimposto i links quando si cambia pagina nella tabella
                    $('#User').on('page.dt', function () {
                        setUserLinks();
                    });
                }else if(response["status"] = 401){
                    window.location = "url('')";
                }            
            }
        });
    }

    /**
     * Funzone che consente di eseguire la richiesta che elimina la motivazione selezionata
     */ 
    function deleteJustification(){
        $('#deleteJustificationModal').modal('hide');
        //Genero il link che andranno a richiamare
        var link = "{{ url('admin/justification/delete/') }}";
        link += "/" + $(deleteLink).parents().eq(1).attr("id");
        //Eseguo la richiesta
        $.ajax({
            type: "delete", 
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json",   
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la pagina
            complete: function(response) {
                if(response["status"] == 200){
                    createJustificationTable();
                    toastr.success('Motivazione eliminata con successo');
                }else{
                    toastr.error('Impossibile eliminare la motivazione');
                }
            }
        });
    }

    /**
     * Funzone che consente di eseguire la richiesta che elimina l'utente selezionato
     */
    function deleteUser(){
        $('#deleteUserModal').modal('hide');
        //Genero il link che andranno a richiamare
        var link = "{{ url('admin/user/delete/') }}";
        link += "/" + $(deleteLink).parents().eq(1).attr("id");
        //Eseguo la richiesta
        $.ajax({
            type: "delete", 
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json",   
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la pagina
            complete: function(response) {
                if(response["status"] == 200){
                    createUserTable();
                    toastr.success('Utente eliminato con successo');
                }else{
                    toastr.error("Impossibile eliminare l'utente");
                }
            }
        });
    }

    /**
    * Funzione che richiede la motivazione con l'id passato
    * @param id L'id della motivavzione da cercare
    */
    function getJustification(id){
        var link = "{{ url('admin/justification') }}";
        link += "/" + id;
        $.ajax({
            type: "get", 
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json",   
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la pagina
            complete: function(response) {
                if(response["status"] == 200){
                    //Imposto i valori della motivazione nel form
                    $('#textUpdate').val(response['responseJSON']['text']);
                    $('#pointUpdateSelect').val(response['responseJSON']['id_point']);
                    $('#updateJustificationTitle').html("Modifica motivazione con id: " + response['responseJSON']['id']);  
                    lastUpdatedJustification = response['responseJSON']['id'];
                }else{
                    //Chiudo il modale e mostro l'errore
                    $('#updateJustificationModal').modal('hide');
                    toastr.error("Impossibile caricare la motivazione");
                }
            }
        });
    }

    /**
    * Funzione che richiede l'utente con l'id passato
    * @param id L'id dell'utente da cercare
    */
    function getUser(id){
        var link = "{{ url('admin/user') }}";
        link += "/" + id;
        $.ajax({
            type: "get", 
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json",   
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la pagina
            complete: function(response) {
                if(response["status"] == 200){
                    //Imposto i valori del'utente nel form
                    $('#nameUpdate').val(response['responseJSON']['name']);
                    $('#surnameUpdate').val(response['responseJSON']['surname']);
                    $('#emailUpdate').val(response['responseJSON']['email']);
                    $('#phoneUpdate').val(response['responseJSON']['phone']);
                    $('#roleUpdateSelect').val(response['responseJSON']['id_role']);
                    $('#updateJustificationTitle').html("Modifica motivazione con id: " + response['responseJSON']['id']);  
                    lastUpdatedUser = response['responseJSON']['id'];
                }else{
                    //Chiudo il modale e ritorno l'errore
                    $('#updateJustificationModal').modal('hide');
                    toastr.error("Impossibile caricare l'utente");
                }
            }
        });
    }
    
    /**
    * Funzione che imposta i link di eliminazione degli utenti
    */
    function setUserLinks(){
        $("#User").ready(function() {
            //Trovo tutti i link che servono all'eliminazione degli utenti
            var deleteLinks = $(".deleteFieldUser");
            $.each(deleteLinks, function(){
                //Gli imposto i valori necessari per aprire il modale
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#deleteUserModal');
                $(this).click(function(){
                    //Al click mostro il modale di conferma
                    deleteLink = $(this);
                    var id = $(this).parents().eq(1).attr("id");
                    $("#userMessage").text("Sei sicuro di voler eliminare l'utente: " + id);
                });
            });

            //Trovo tutti i link che servono alla modifica degli utenti
            var updateLinks = $(".updateFieldUser");
            $.each(updateLinks, function() {
                //Gli imposto i valori necessari per aprire il modale
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#updateUserModal');
                $(this).click(function() {
                    //Al click ritorno l'utente su cui si ha premuto
                    var id = $(this).parents().eq(1).attr("id");
                    getUser(id);
                });
            });
        });
    }

    /**
    * Funzione che imposta i link delle motivazioni
    */
    function setJustificationLinks(){
        $("#Justification").ready(function() {
            //Trovo tutti i link che servono all'eliminazione delle motivazioni
            var deleteLinks = $(".deleteFieldJustification");
            $.each(deleteLinks, function(){
                //Gli imposto i valori necessari per aprire il modale
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#deleteJustificationModal');
                $(this).click(function(){
                    //Al click mostro il modale di conferma
                    deleteLink = $(this);
                    var id = $(this).parents().eq(1).attr("id");
                    $("#justificationMessage").text("Sicuro di voler eliminare la motivazione: " + id);
                });
            });
        
            //Trovo tutti i link che servono alla modifica delle motivazioni
            var updateLinks = $(".updateFieldJustification");
            $.each(updateLinks, function() {
                //Gli imposto i valori necessari per aprire il modale
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#updateJustificationModal');
                $(this).click(function() {
                    //Al click carico la motivazione
                    var id = $(this).parents().eq(1).attr("id");
                    getJustification(id);
                });
            });
        });
        
    }
</script>
@endsection