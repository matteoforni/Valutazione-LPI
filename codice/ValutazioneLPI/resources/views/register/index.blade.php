@extends('_templates/login_header')

@section('title', 'Registrati')

@section('content')
<div class="row">
    <div class="col-md-6 offset-3">
        <form id="registerForm" class="text-center border border-light p-5 mt-5">
            <p class="h4 mb-4">Registrati</p>

            <div class="form-row mb-4">
                <div class="col">
                    <!-- First name -->
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nome">
                </div>
                <div class="col">
                    <!-- Last name -->
                    <input type="text" id="surname" name="surname" class="form-control" placeholder="Cognome">
                </div>
            </div>

            <!-- E-mail -->
            <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail">

            <!-- Phone number -->
            <input type="text" id="phone" name="phone" class="form-control mb-4" placeholder="Numero di telefono">

            <!-- Password -->
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-describedby="passwordHelpBlock">
            <small id="passwordHelpBlock" class="form-text text-muted mb-4">
                Inserire una password di almeno 8 caratteri
            </small>

            <!-- Register -->
            <p class="mt-3">Possiedi già un account?
                <a href="{{ url("login") }}">Accedi</a>
            </p>
            
            <input type="number" hidden name="confirmed" value="0">
            <input type="number" hidden name="id_role" value="1">

            <!-- Sign up button -->
            <button class="btn btn-info my-4 btn-block">Registrati</button>
        </form>
    </div>
</div>
<script>
    $("#registerForm").submit(function( event ) {
        event.preventDefault();
        var jsonData = $(this).serializeArray();
        var form = {};
        for(var index in jsonData) {
            var json = jsonData[index];
            form[json.name] = json.value;
        }
        $.ajax({
            type: "post",
            url: "{{ url('register/register') }}",
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json",            
            complete: function(response){
                if(response["status"] == 201){
                    window.location = "{{ url('login') }}";
                }
            }
        });
    });

</script>
@endsection