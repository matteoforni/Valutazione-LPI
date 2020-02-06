@extends('_templates/login_header')

@section('title', 'Registrati')

@section('content')
<div class="row">
    <div class="col-md-6 offset-3">
        <form id="registerForm" class="text-center border border-light p-5 mt-3 mb-5">
            <p class="h4 mb-4">Registrati</p>

            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <input type="text" id="name" name="name" class="form-control mb-4" placeholder="Nome" minlength="2" pattern="[A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <input type="text" id="surname" name="surname" class="mb-4 form-control" placeholder="Cognome" minlength="2" pattern="[A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                </div>
            </div>

            <!-- E-mail -->
            <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" required>

            <!-- Phone number -->
            <input type="text" id="phone" name="phone" class="form-control mb-4" placeholder="Numero di telefono" pattern="/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/" required>

            <!-- Password -->
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-describedby="passwordHelpBlock" minlength="8" required>
            <small id="passwordHelpBlock" class="form-text text-muted mb-4">
                Inserire una password di almeno 8 caratteri
            </small>

            <input type="password" id="repassword" name="repassword" class="form-control" placeholder="Ripeti la password" minlength="8" required>

            <!-- Register -->
            <p class="mt-3">Possiedi già un account?
                <a href="{{ url("") }}">Accedi</a>
            </p>
            
            <input type="number" hidden name="confirmed" value="0">
            <input type="number" hidden name="id_role" value="1">

            <!-- Sign up button -->
            <button class="btn btn-info my-4 btn-block">Registrati</button>
        </form>
    </div>
    <div class="col-md-3 my-5">
        <div class="errors text-danger">

        </div>
    </div>
</div>
<script>
    //All'evento di submit del form eseguo la richiesta al server con AJAX
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
            url: "{{ url('register/register') }}",
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
        //Messaggio per il campo password
        $("#password")[0].oninvalid = function () {
            this.setCustomValidity("La password deve essere di almeno 8 caratteri");
        };
        //Messaggio per il campo ripetizione password
        $("#repassword")[0].oninvalid = function () {
            this.setCustomValidity("La password deve essere di almeno 8 caratteri");
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
        //Rimozione del messaggio per il campo password
        $("#password")[0].oninput= function () {
            this.setCustomValidity("");
        };
        //Rimozione del messaggio per il campo ripetizione password
        $("#repassword")[0].oninput= function () {
            this.setCustomValidity("");
        };
    });

</script>
@endsection