@extends('_templates/login_header')

@section('title', 'Login')

@section('content')
<div class="row">
    <div class="col-md-6 offset-3">
        <form id="loginForm" class="text-center border border-light p-5 mt-5">
            <p class="h4 mb-4">Accedi al tuo account</p>

            <!-- Email -->
            <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail">

            <!-- Password -->
            <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password">

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
    $("#loginForm").submit(function( event ) {
        event.preventDefault();
        var jsonData = $(this).serializeArray();
        var form = {};
        for(var index in jsonData) {
            var json = jsonData[index];
            form[json.name] = json.value;
        }
        $.ajax({
            type: "post",
            url: "{{ url('login/authenticate') }}",
            data: JSON.stringify(form),
            contentType: "application/json; charset=utf-8",
            dataType: "json",            
            complete: function(response){
                if(response["status"] == 200){
                    Cookies.set('token', response["responseJSON"]["token"], { expires: 1 });
                }else{
                    var errors = [];
                    for(key in response["responseJSON"]) {
                        errors.push(response["responseJSON"][key]);
                    }
                    for(i = 0; i < errors.length; i++){
                        $(".errors").append("<h6>" + errors[i] + "</h6>");
                    }
                }
            }
        });
    });
    console.log(Cookies.get('token'));
</script>
@endsection