@extends('_templates/login_header')

@section('title', 'Login')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form id="loginForm" class="text-center border border-light p-5 mt-5 md-form">
            <p class="h4 mb-4">Accedi al tuo account</p>

            <!-- Email -->
            <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" required>

            <!-- Password -->
            <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password" minlength="8" required>

            <div class="d-flex justify-content-end">
                <div>
                    <!-- Forgot password -->
                    <a href="">Hai dimenticato la password?</a>
                </div>
            </div>

            <!-- Sign in button -->
            <button class="btn btn-info btn-block my-4">Accedi</button>

            <!-- Register -->
            <p>Non possiedi un account?
                <a href="{{ url("register") }}">Registrati</a>
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
    $("#loginForm").submit(function( event ) {
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
        //Eseguo la richiesta post al controller login con metodo authenticate
        $.ajax({
            type: "post",
            url: "{{ url('login/authenticate') }}",
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json",            
            complete: function(response){
                //Se il server ritorna il codice di successo salvo il token JWT ritornato nei cookies
                if(response["status"] == 200){
                    Cookies.set('token', response["responseJSON"]["token"], { expires: 1 });
                    window.location = "{{ url('login/login') }}?token=" + Cookies.get('token');
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
        //Messaggio per il campo email
        $("#email")[0].oninvalid = function () {
            this.setCustomValidity("Inserire un'email valida");
        };
        //Messaggio per il campo password
        $("#password")[0].oninvalid = function () {
            this.setCustomValidity("Inserire una password valida");
        };
    });

    //Funzione che rimuove i messaggi di errore dai campi
    $(function(){
        //Rimozione del messaggio per il campo email
        $("#email")[0].oninput= function () {
            this.setCustomValidity("");
        };
        //Rimozione del messaggio per il campo password
        $("#password")[0].oninput= function () {
            this.setCustomValidity("");
        };
    });
</script>
@endsection