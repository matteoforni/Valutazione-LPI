@extends('_templates/admin_header')

@section('title', 'Amministrazione')

@section('content')
<div class="row">
    <div class="col-md-8 text-center offset-2">
        <h3 class="h3 text-center my-5">Gestione motivazioni</h3>
        <div class="justifications-table table-responsive mb-5">
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addJustificationModal">Aggiungi motivazione</button>
    </div>
    <div class="errors text-danger">

    </div>
    <div class="col-md-12 text-center my-5">
        <h3 class="h3 text-center my-5">Gestione utenti</h3>
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
        <form id="addUserForm" class="text-center border border-light p-5 mt-3 m-5">
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

            <input type="number" hidden name="confirmed" value="0">
            <input type="number" hidden name="id_role" value="1">

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
        <form id="addJustificationForm" class="text-center border border-light p-5 mt-3 m-5">
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
        <h4 class="modal-title w-100" id="addUserTitle">Modifica motivazione</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateJustificationForm" class="text-center border border-light p-5 mt-3 m-5">
            <p class="h4 mb-4">Modifica la motivazione</p>

            <div class="md-form">
                <textarea id="textUpdate" class="form-control md-textarea" name="text" maxlength="1000" length="1000" rows="4"></textarea>
                <label for="textarea-char-counter">Inserisci il testo</label>
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
    let deleteLink;
    $(document).ready(function(){
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
    });

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
                //Se il server ritorna il codice di successo ricarico la tabella
                if(response["status"] == 201){
                    createUserTable();
                    toastr.success('Utente aggiunto con successo');
                //Se il server ritorna un errore stampo gli errori     
                }else{
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
        });
    });

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
                        $(".errors").append("<h6>" + errors[i] + "</h6>");
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
                //Se il server ritorna il codice di successo salvo il token JWT ritornato nei cookies
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
                //Se il server ritorna il codice di successo salvo il token JWT ritornato nei cookies
                if(response["status"] == 200){
                    var table = JSONToHTML('User', response["responseJSON"]);
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
                    $('#Users').on('page.dt', function () {
                        setUserLinks();
                    });
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
                    $('#textUpdate').html(response['responseJSON']['text']);
                    $('#pointUpdateSelect').val(response['responseJSON']['id_point']);
                }else{
                    $('#updateJustificationModal').modal('hide');
                    toastr.error("Impossibile caricare la motivazione");
                }
            }
        });
    }
    
    /**
    * Funzione che imposta i link di eliminazione degli utenti
    */
    function setUserLinks(){
        //Trovo tutti i link che servono all'eliminazione degli utenti
        var deleteLinks = $(".deleteFieldUser");
        $.each(deleteLinks, function(){
            $(this).attr('data-toggle', 'modal');
            $(this).attr('data-target', '#deleteUserModal');
            $(this).click(function(){
                deleteLink = $(this);
                var id = $(this).parents().eq(1).attr("id");
                $("#userMessage").text("Sei sicuro di voler eliminare l'utente: " + id);
            });
        });
    }

    /**
    * Funzione che imposta i link delle motivazioni
    */
    function setJustificationLinks(){
        //Trovo tutti i link che servono all'eliminazione delle motivazioni
        var deleteLinks = $(".deleteFieldJustification");
        $.each(deleteLinks, function(){
            $(this).attr('data-toggle', 'modal');
            $(this).attr('data-target', '#deleteJustificationModal');
            $(this).click(function(){
                deleteLink = $(this);
                var id = $(this).parents().eq(1).attr("id");
                $("#justificationMessage").text("Sicuro di voler eliminare la motivazione: " + id);
            });
        });

        var updateLinks = $(".updateFieldJustification");
        $.each(updateLinks, function() {
            $(this).attr('data-toggle', 'modal');
            $(this).attr('data-target', '#updateJustificationModal');
            $(this).click(function() {
                var id = $(this).parents().eq(1).attr("id");
                getJustification(id);
            });
        });
    }
</script>
@endsection