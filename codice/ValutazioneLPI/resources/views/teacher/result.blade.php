@extends('_templates/teacher_header')

@section('title', 'Risultato finale')

@section('content')
@section('content')
<h3 class="h3 text-center my-5">Risultati del formulario</h3>
<div class="row">
    <div class="col-md-4 text-center">
        <h5 class="h5 text-center mb-5">Risultati sezione A</h5>
        <p id="resultsA" class="p text-center mb-5"></p>
        <button id="showA" class="btn btn-sm btn-info" onclick="showA()">Mostra motivazioni</button>
        <div class="justifications-a-table table-responsive mb-5">
        </div>
    </div>
    <div class="col-md-4 text-center">
        <h5 class="h5 text-center mb-5">Risultati sezione B</h5>
        <p id="resultsB" class="p text-center mb-5"></p>
        <button id="showB" class="btn btn-sm btn-info" onclick="showB()">Mostra motivazioni</button>
        <div class="justifications-b-table table-responsive mb-5">
        </div>
    </div>
    <div class="col-md-4 text-center">
        <h5 class="h5 text-center mb-5">Risultati sezione C</h5>
        <p id="resultsC" class="p text-center mb-5"></p>
        <button id="showC" class="btn btn-sm btn-info" onclick="showC()">Mostra motivazioni</button>
        <div class="justifications-c-table table-responsive mb-5">
        </div>
    </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    let form = <?php echo $form ?>;

    $(document).ready(function(){
        createResultsTable();
    });

    /**
     * Funzione che consente di creare la tabella delle motivazioni
     */ 
     function createResultsTable(){
        //Genero il link per la richiesta
        var link = "{{ url('teacher/form/results') }}";
        link += "/" + form["id"];

        //Richiedo i dati per riempire la tabella
        $.ajax({
            type: "get",
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json",     
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },       
            complete: function(response){
                //Se il server ritorna il codice di successo genero le tabelle
                if(response["status"] == 200){
                    //Genero la prima tabella
                    var data = [];
                    //Salvo solo i dati utilizzati
                    for(var item in response["responseJSON"]["A"]){
                        var obj = {'Motivazione': response["responseJSON"]["A"][item]['text']};
                        data.push(obj);                        
                    }

                    if(data.length){
                        var pointsMade = 60-data.length;
                        var results = pointsMade/60*5+1;
                        results = results.toFixed(2);

                        var string = pointsMade + " punti su un massimo di 60 \nRisultato finale: " + results;

                        var table = JSONToHTML('Justification', data, false);
                        $(".justifications-a-table").html(table);  

                        var table = $("#JustificationA").DataTable({
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
                    }else{
                        var string = "60 punti su un massimo di 60 \nRisultato finale: 6.00";
                    }
                    $('#resultsA').text(string);

                    //Genero la seconda tabella
                    var data = [];
                    //Salvo solo i dati utilizzati
                    for(var item in response["responseJSON"]["B"]){
                        var obj = {'Motivazione': response["responseJSON"]["B"][item]['text']};
                        data.push(obj);                        
                    }

                    if(data.length){
                        var pointsMade = 30-data.length;
                        var results = pointsMade/30*5+1;
                        results = results.toFixed(2);

                        var string = pointsMade + " punti su un massimo di 30 \nRisultato finale: " + results;

                        var table = JSONToHTML('JustificationB', data, false);
                        $(".justifications-b-table").html(table);  

                        var table = $("#Justification").DataTable({
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
                    }else{
                        var string = "30 punti su un massimo di 30 \nRisultato finale: 6.00";
                    }
                    $('#resultsB').text(string);

                    //Genero la terza tabella
                    var data = [];
                    //Salvo solo i dati utilizzati
                    for(var item in response["responseJSON"]["C"]){
                        var obj = {'Motivazione': response["responseJSON"]["C"][item]['text']};
                        data.push(obj);                        
                    }

                    if(data.length){
                        var pointsMade = 30-data.length;
                        var results = pointsMade/30*5+1;
                        results = results.toFixed(2);

                        var string = pointsMade + " punti su un massimo di 30 \nRisultato finale: " + results;

                        var table = JSONToHTML('JustificationC', data, false);
                        $(".justifications-c-table").html(table);  

                        var table = $("#JustificationC").DataTable({
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
                    }else{
                        var string = "30 punti su un massimo di 30 \nRisultato finale: 6.00";
                    }
                    $('#resultsC').text(string);

                }else if(response["status"] = 401){
                    //Se non si è autorizzati si ritorna al login
                    window.location = "{{ url('') }}";
                }     
            }
        });
    }

    function showA(){
        var table = $('#JustificationA');
        if($(table).hasClass('d-none')){
            $(table).show();
            $('#showA').text("Nascondi motivazioni");
        }else{
            $(table).hide();
        }
    }

    function showB(){
        var table = $('#JustificationB');
        if($(table).hasClass('d-none')){
            $(table).removeClass('d-none');
            $('#showB').text("Nascondi motivazioni");
        }else{
            $(table).addClass('d-none');
        }
    }

    function showC(){
        var table = $('#JustificationC');
        if($(table).hasClass('d-none')){
            $(table).removeClass('d-none');
            $('#showC').text("Nascondi motivazioni");
        }else{
            $(table).addClass('d-none');
        }
    }
</script>
@endsection