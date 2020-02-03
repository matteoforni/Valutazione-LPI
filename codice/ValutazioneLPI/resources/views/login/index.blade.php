@extends('_templates/login_header')

@section('title', 'Login')

@section('content')
<div class="row">
    <div class="col-md-6 offset-3">
        <form class="text-center border border-light p-5 mt-5" action="#!">
            <p class="h4 mb-4">Accedi al tuo account</p>

            <!-- Email -->
            <input type="email" id="email" class="form-control mb-4" placeholder="E-mail">

            <!-- Password -->
            <input type="password" id="password" class="form-control mb-4" placeholder="Password">

            <div class="d-flex justify-content-end">
                <div>
                    <!-- Forgot password -->
                    <a href="">Hai dimenticato la password?</a>
                </div>
            </div>

            <!-- Sign in button -->
            <button class="btn btn-info btn-block my-4" type="submit">Accedi</button>

            <!-- Register -->
            <p>Non possiedi un account?
                <a href="{{ url("register") }}">Registrati</a>
            </p>
        </form>
    </div>
</div>
@endsection