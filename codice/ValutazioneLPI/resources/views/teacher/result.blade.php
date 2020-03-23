@extends('_templates/teacher_header')

@section('title', 'Risultato finale')

@section('content')
@section('content')
<h3 class="h3 text-center my-5">Risultati del formulario</h3>
<div class="row ">
    <div class="col-md-12 border-bottom border-light">
        <h5 class="h5 text-center mb-5">Risultati finali</h5>
        <p id="finalResults" class="text-center"></p>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center mt-3">
        <a id="btnPDF" class="btn btn-success">Visualizza PDF</a>
    </div>
</div>
<div class="row">
    <div class="col-md-4 text-center mt-5">
        <h5 class="h5 text-center mb-5">Risultati sezione A</h5>
        <p id="resultsA" class="p text-center mb-5"></p>
        <button id="showA" class="btn btn-sm btn-info mb-3" onclick="showA()">Mostra motivazioni</button>
        <div class="justifications-a-table table-responsive mb-5">
        </div>
    </div>
    <div class="col-md-4 text-center mt-5">
        <h5 class="h5 text-center mb-5">Risultati sezione B</h5>
        <p id="resultsB" class="p text-center mb-5"></p>
        <button id="showB" class="btn btn-sm btn-info mb-3" onclick="showB()">Mostra motivazioni</button>
        <div class="justifications-b-table table-responsive mb-5">
        </div>
    </div>
    <div class="col-md-4 text-center mt-5">
        <h5 class="h5 text-center mb-5">Risultati sezione C</h5>
        <p id="resultsC" class="p text-center mb-5"></p>
        <button id="showC" class="btn btn-sm btn-info" onclick="showC()">Mostra motivazioni</button>
        <div class="justifications-c-table table-responsive mb-5">
        </div>
    </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    /**
    * Array che contiene tutti i dati del formulario
    */
    let form = <?php echo $form ?>;

    /**
    * Attributo che consente di mostrare/nascondere le motivazioni della prima sezione
    */
    let checkA = true;

    /**
    * Attributo che consente di mostrare/nascondere le motivazioni della seconda sezione
    */
    let checkB = true;

    /**
    * Attributo che consente di mostrare/nascondere le motivazioni della terza sezione
    */
    let checkC = true;

    /**
    * Attributo che contiene i punti fatti nella sezione A
    */
    let pointsMadeA;

    /**
    * Attributo che contiene i punti fatti nella sezione B
    */
    let pointsMadeB;

    /**
    * Attributo che contiene i punti fatti nella sezione C
    */
    let pointsMadeC;

    /**
    * Attributo che contiene la nota ottenuta nella sezione A
    */
    let resultsA;

    /**
    * Attributo che contiene la nota ottenuta nella sezione B
    */
    let resultsB;

    /**
    * Attributo che contiene la nota ottenuta nella sezione C
    */
    let resultsC;

    $(document).ready(function(){
        //Creo le tabelle con i risultati
        createResultsTable();

        //Nascondo le tabelle
        $('.justifications-a-table').hide();
        $('.justifications-b-table').hide();
        $('.justifications-c-table').hide();

        //Al click apro il PDF
        $('#btnPDF').click(function(){
            //Genero il link per la richiesta
            var link = "{{ url('teacher/pdf') }}";
            link += "/" + form["id"];

            window.open(link, '_blank');
        });
    });

    /**
     * Funzione che consente di creare le tabelle delle motivazioni
     */ 
     function createResultsTable(){
        //Genero il link per la richiesta
        var link = "{{ url('teacher/form/results') }}";
        link += "/" + form["id"];

        //Richiedo i dati per riempire le tabelle
        $.ajax({
            type: "get",
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json",     
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },       
            complete: function(response){
                if(response["status"] == 200){
                    //Se il server ritorna il codice di successo genero la prima tabella
                    var data = [];
                    //Salvo solo i dati della sezione A
                    for(var item in response["responseJSON"]["A"]){
                        var obj = {'Motivazione': response["responseJSON"]["A"][item]['text']};
                        data.push(obj);                        
                    }
                    //Aggiungo i dati dei punti specifici
                    for(var item in response["responseJSON"]["points"]){
                        var obj = {'Motivazione': response["responseJSON"]["points"][item]['text']};
                        data.push(obj);                        
                    }

                    //Se ci sono motivazioni nella sezione
                    if(data.length){
                        //Calcolo la nota
                        pointsMadeA = 60-data.length;
                        resultsA = pointsMadeA/60*5+1;
                        resultsA = resultsA.toFixed(2);

                        //Stampo i risultati della prima sezione
                        var string = pointsMadeA + " punti su un massimo di 60 \nRisultato finale: " + resultsA;

                        var table = JSONToHTML('JustificationA', data, false);

                        //Genero la tabella
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
                        $(".justification-a-table").addClass('d-none');
                    }else{
                        //Se non ci sono motivazioni stampo la stringa con la nota massima
                        var string = "60 punti su un massimo di 60 \nRisultato finale: 6.00";
                    }
                    $('#resultsA').text(string);

                    //Se il server ritorna il codice di successo genero la seconda tabella
                    var data = [];
                    //Salvo solo i dati della sezione B
                    for(var item in response["responseJSON"]["B"]){
                        var obj = {'Motivazione': response["responseJSON"]["B"][item]['text']};
                        data.push(obj);                        
                    }

                    //Se ci sono motivazioni nella sezione
                    if(data.length){
                        //Calcolo la nota
                        pointsMadeB = 30-data.length;
                        resultsB = pointsMadeB/30*5+1;
                        resultsB = resultsB.toFixed(2);

                        //Stampo i risultati della seconda sezione
                        var string = pointsMadeB + " punti su un massimo di 30 \nRisultato finale: " + resultsB;

                        //Genero la tabella
                        var table = JSONToHTML('JustificationB', data, false);
                        $(".justifications-b-table").html(table);  

                        var table = $("#JustificationB").DataTable({
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
                        //Se non ci sono motivazioni stampo la stringa con la nota massima
                        var string = "30 punti su un massimo di 30 \nRisultato finale: 6.00";
                    }
                    $('#resultsB').text(string);

                    //Se il server ritorna il codice di successo genero la terza tabella
                    var data = [];
                    //Salvo solo i dati della sezione C
                    for(var item in response["responseJSON"]["C"]){
                        var obj = {'Motivazione': response["responseJSON"]["C"][item]['text']};
                        data.push(obj);                        
                    }

                    //Se ci sono motivazioni nella sezione
                    if(data.length){
                        //Calcolo la nota
                        pointsMadeC = 30-data.length;
                        resultsC = pointsMadeC/30*5+1;
                        resultsC = resultsC.toFixed(2);

                        //Stampo i risultati della terza sezione
                        var string = pointsMadeC + " punti su un massimo di 30 \nRisultato finale: " + resultsC;

                        //Genero la tabella
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
                        //Se non ci sono motivazioni stampo la stringa con la nota massima
                        var string = "30 punti su un massimo di 30 \nRisultato finale: 6.00";
                    }
                    $('#resultsC').text(string);

                    //Calcolo la nota totale e stampo la stringa
                    var totalPoints = pointsMadeA + pointsMadeB + pointsMadeC;
                    var finalMark = resultsA * 0.5 + resultsB * 0.25 + resultsC * 0.25;
                    finalMark = finalMark.toFixed(2);

                    $('#finalResults').text("Il candidato " + form['student_name'] + " " + form['student_surname'] + " ha completato il suo LPI (" + form['title'] + ") con un punteggio totale di " + totalPoints + " punti su un massimo di 120. \nOttiene quindi una nota finale di " + finalMark);

                }else if(response["status"] = 401){
                    //Se non si è autorizzati si ritorna al login
                    window.location = "{{ url('') }}";
                }     
            }
        });
    }

    /**
    * Funzione che mostra o nasconde la prima sezione
    */
    function showA(){
        if(checkA){
            $('.justifications-a-table').show();
            $('#showA').text("Nascondi motivazioni");
            checkA = false;
        }else{
            $('.justifications-a-table').hide();
            $('#showA').text("Mostra motivazioni");
            checkA = true;
        }
    }

    /**
    * Funzione che mostra o nasconde la seconda sezione
    */
    function showB(){
        if(checkB){
            $('.justifications-b-table').show();
            $('#showB').text("Nascondi motivazioni");
            checkB = false;
        }else{
            $('.justifications-b-table').hide();
            $('#showB').text("Mostra motivazioni");
            checkB = true;
        }
    }

    /**
    * Funzione che mostra o nasconde la terza sezione
    */
    function showC(){
        if(checkC){
            $('.justifications-c-table').show();
            $('#showC').text("Nascondi motivazioni");
            checkC = false;
        }else{
            $('.justifications-c-table').hide();
            $('#showC').text("Mostra motivazioni");
            checkC = true;
        }
    }
</script>
@endsection