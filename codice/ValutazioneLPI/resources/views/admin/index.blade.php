@extends('_templates/admin_header')

@section('title', 'Amministrazione')

@section('content')
<div class="row">
    <div class="col-md-8 offset-2">
        <h3 class="h3 text-center my-5">Gestione motivazioni</h3>
        <div class="justifications-table table-responsive">
        </div>
    </div>
    <div class="col-md-12">
        <h3 id="aaaa" class="h3 text-center my-5">Gestione utenti</h3>
        <div class="users-table table-responsive mb-5">
        </div>
    </div>
</div>
<script src="/resources/js/JSONToHTML.js"></script>
<script>
    $(document).ready(function(){
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
                    var table = JSONToHTML('justifications', response["responseJSON"]);
                    $(".justifications-table").append(table);  
                }          
            }
        });
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
                    var table = JSONToHTML('users', response["responseJSON"]);
                    $(".users-table").append(table);  
                }          
            }
        });
    
        $("#justifications").DataTable(/*{
            "searching": true,
            "bLengthChange": false,
            "info" : false,
            "iDisplayLength": 5,
            "oLanguage": {
                "sEmptyTable": "Nessuna motivazione da mostrare"
            }
        }*/);
        $("#users").DataTable({
            "searching": true,
            "bLengthChange": false,
            "info" : false,
            "iDisplayLength": 5,
            "oLanguage": {
                "sEmptyTable": "Nessun utente da mostrare"
            }
        });
    });
</script>
@endsection