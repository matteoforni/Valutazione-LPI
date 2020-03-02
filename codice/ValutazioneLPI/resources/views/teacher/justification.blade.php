@extends('_templates/teacher_header')

@section('title', 'Aggiungi motivazioni')

@section('content')
<div class="row">
    <div class="col-md-8 text-center offset-md-2">
        <h3 class="h3 text-center my-5">Aggiunta di motivazioni al formulario</h3>
        <div class="errors-justification text-danger">

        </div>
        <div class="justifications-table table-responsive mb-5">
        </div>
    </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    $(document).ready(function(){
        createJustificationTable();
    });
    /**
     * Funzione che consente di creare la tabella delle motivazioni
     */ 
     function createJustificationTable(){
        //Richiedo i dati per riempire la tabella
        $.ajax({
            type: "get",
            url: "{{ url('teacher/justifications') }}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",     
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },       
            complete: function(response){
                //Se il server ritorna il codice di successo genero la tabella
                if(response["status"] == 200){
                    var table = JSONToHTML('Justification', response["responseJSON"], false);
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

                }else if(response["status"] = 401){
                    //window.location = "{{ url('') }}";
                }       
            }
        });
    }
</script>
@endsection