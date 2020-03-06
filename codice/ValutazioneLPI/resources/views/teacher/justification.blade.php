@extends('_templates/teacher_header')

@section('title', 'Aggiungi motivazioni')

@section('content')
<div class="row">
    <div class="col-md-8 text-center">
        <h3 class="h3 text-center my-5">Aggiunta di motivazioni al formulario</h3>
        <div class="errors-justification text-danger">

        </div>
        <div class="justifications-table table-responsive mb-5">
        </div>
    </div>
    <div class="col-md-3 offset-md-1">
        <h3 class="h3 text-center my-5">Motivazioni presenti</h3>
        <table id="addedJustifications" class='table text-center table-hover table-bordered'>
            <thead>
                
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    $(document).ready(function(){
        createJustificationTable();

        var justifications = <?php echo $justifications ?>;

        if(Array.isArray(justifications) && justifications.length){
            $("#addedJustifications thead").append("<tr><th class='font-weight-bold' scope='col'>Codice</th></tr>");
            $.each(justifications, function(){
                $("#addedJustifications tbody").append("<tr><td>" + this['justification'] + "</td></tr>");
            });

            $("#addedJustifications").DataTable({
                "searching": false,
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
        }
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
                    window.location = "{{ url('') }}";
                }       
            }
        });
    }
</script>
@endsection