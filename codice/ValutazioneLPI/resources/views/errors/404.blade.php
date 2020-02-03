@extends('_templates/login_header')

@section('title', 'Pagina non trovata')

@section('content')
<div class="row h-75">
    <div class="col-md-6 offset-3 text-center my-5 error-row">
        <h1 class="h1">Pagina non trovata</h1>
        <h4 class="h4">La pagina richiesta non esiste</h4>
        <p>Codice di errore generato dal server: 404</p>
    </div>
</div>
@endsection