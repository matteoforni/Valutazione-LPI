@extends('_templates/login_header')

@section('title', 'Reset password')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form id="requestForm" class="text-center border border-light p-5 mt-5 md-form">
            <p class="h4 mb-4">Modifica la tua password</p>
            <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password" minlength="8" required>
            <input type="password" id="repassword" name="repassword" class="form-control mb-4" placeholder="Ripeti la Password" minlength="8" required>
            <button class="btn btn-info btn-block my-4">Cambia la password</button>

            <p>Non possiedi un account?
                <a href="{{ url("register") }}">Registrati</a>
            </p>
            <p>Vuoi accedere al tuo account?
                <a href="{{ url("") }}">Accedi</a>
            </p>
        </form>
    </div>
    <div class="col-md-3 my-5">
        <div class="errors text-danger">

        </div>
    </div>
</div>
<script>
    //All'evento di submit del form eseguo la richiesta al server con AJAX
    $("#requestForm").submit(function( event ) {
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
        //Genero il link per la richiesta
        var link = "{{ url('login/reset/changePassword') }}";
        link += "/" + location.href.substring(location.href.lastIndexOf('/') + 1);
        $.ajax({
            type: "put",
            url: link,
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json",            
            complete: function(response){
                //Se il server ritorna il codice di successo rimando l'utente al login
                if(response["status"] == 200){
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
        //Messaggio per il campo password
        $("#password")[0].oninvalid = function () {
            this.setCustomValidity("Inserire una password valida");
        };
    });

    //Funzione che rimuove i messaggi di errore dai campi
    $(function(){
        //Rimozione del messaggio per il campo password
        $("#password")[0].oninput= function () {
            this.setCustomValidity("");
        };
    });
</script>
@endsection