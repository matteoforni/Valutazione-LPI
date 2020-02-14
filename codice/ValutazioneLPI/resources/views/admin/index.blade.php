@extends('_templates/admin_header')

@section('title', 'Amministrazione')

@section('content')
<div class="row">
    <div class="col-md-8 offset-2">
        <h3 class="h3 text-center my-5">Gestione motivazioni</h3>
        <div class="justifications-table table-responsive">
        </div>
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
        <form id="registerForm" class="text-center border border-light p-5 mt-3 m-5">
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
                <button class="btn btn-info btn-block">Registrati</button>
            </div>
        </form>
        <div class="col-md-3 my-5">
            <div class="errors text-danger">
    
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    $(document).ready(function(){
        createJustificationTable();
        createUserTable();
    });

    $("#registerForm").submit(function( event ) {
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
        //Eseguo la richiesta post al controller register con metodo register
        $.ajax({
            type: "post",
            url: "{{ url('admin/add') }}",
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json",            
            complete: function(response){
                //Se il server ritorna il codice di successo rimando all'utente alla pagina di login
                if(response["status"] == 201){
                    window.location = "{{ url('') }}";

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
                    $("#justifications").DataTable({
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
                    //Trovo tutti i link che servono all'eliminazione delle motivazioni
                    var deleteLinks = $(".deleteFieldJustification");
                    $.each(deleteLinks, function(){
                        //Ad ogniuno di loro collego un evento onClick
                        $(this).click(function() {
                             //Genero il link che andranno a richiamare
                            var link = "{{ url('admin/justification/delete/') }}";
                            link += "/" + $(this).parents().eq(1).attr("id");
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
                                complete: function() {
                                    createJustificationTable()
                                }
                            });
                        });
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
                    $("#users").DataTable({
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
                    //Trovo tutti i link che servono all'eliminazione degli utenti
                    var deleteLinks = $(".deleteFieldUser");
                    $.each(deleteLinks, function(){
                        //Ad ogniuno di loro collego un evento onClick
                        $(this).click(function() {
                            //Genero il link che andranno a richiamare
                            var link = "{{ url('admin/user/delete/') }}";
                            link += "/" + $(this).parents().eq(1).attr("id");
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
                                complete: function() {
                                    createUserTable()
                                }
                            });
                        });
                    });
                }          
            }
        });
    }
</script>
@endsection