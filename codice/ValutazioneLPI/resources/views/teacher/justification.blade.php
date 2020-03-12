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
        <div class="addedJustifications-table table-responsive mb-5">
        </div>
    </div>
</div>

<div class="modal fade" id="addJustificationModal" tabindex="-1" role="dialog" aria-labelledby="addTitle"
  aria-hidden="true">

  <div class="modal-dialog modal-md .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="addTitle">Conferma aggiunta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p id="justificationMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-sm" onclick="addJustification()">Aggiungi</button>
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="removeJustificationModal" tabindex="-1" role="dialog" aria-labelledby="removeTitle"
  aria-hidden="true">

  <div class="modal-dialog modal-md .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="removeTitle">Conferma rimozione</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p id="removeJustificationMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" onclick="removeJustification()">Rimuovi</button>
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    /**
    * Array contenente tutte le righe già selezionate
    */
    let rows = [];

    /**
    * Attributo contenente l'ultimo link di aggiunta premuto 
    */
    let addLink; 

    /**
    * Array contenente tutti i dati del formulario che sta venendo modificato
    */
    let form = <?php echo $form ?>;

    /**
    * Attributo contenente l'ultimo link di eliminazione premuto 
    */
    let removeLink;

    $(document).ready(function(){
        //Genero la tabella contenente le motivazioni
        createJustificationTable();
    });

    /**
     * Funzione che consente di creare la tabella delle motivazioni
     */ 
    function createJustificationTable(){
        //Genero il link per la richiesta
        var link = "{{ url('teacher/justifications') }}";
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
                //Se il server ritorna il codice di successo genero la tabella
                if(response["status"] == 200){
                    var table = JSONToHTML('Justification', response["responseJSON"], false);
                    $(".justifications-table").html(table);  

                    var table = $("#Justification").DataTable({
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

                    //Genero la tabella contenente le motivazioni già aggiunte
                    createAddedJustifications();
                       
                    //Collego le righe della tabella al modale
                    setLinks();

                    //Al cambio di pagina collego i nuovi dati mostrati al modale
                    $('#Justification').on('page.dt search.dt', function () {
                        $("#Justification").ready(function(){
                            setLinks();
                        });
                    });

                }else if(response["status"] = 401){
                    //Se non si è autorizzati si ritorna al login
                    window.location = "{{ url('') }}";
                }       
            }
        });
    }

    /**
    * Funzione che consente di generare la tabella contenente le motivazioni già
    * collegate al formulario
    */
    function createAddedJustifications(){
        //Genero il link per la richiesta
        var link = "{{ url('teacher/form/justifications') }}";
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
                //Se il server ritorna il codice di successo genero la tabella
                if(response["status"] == 200){
                    var data = [];
                    rows = [];
                    //Salvo solo i dati utilizzati
                    for(var item in response["responseJSON"]){
                        var obj = {'ID': response["responseJSON"][item]['id_justification'], 'Titolo': response["responseJSON"][item]['title']};
                        data.push(obj);
                        rows.push("#" + response["responseJSON"][item]["id_justification"]);
                        
                    }

                    //Genero la tabella 
                    var table = JSONToHTML('AddedJustification', data, false);
                    $(".addedJustifications-table").html(table);  
                    $("#AddedJustification").DataTable({
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

                    //Disabilito le righe contenenti motivazioni già scelte
                    disableRows();
                    setRemoveLinks();
         
                    //Disabilito le righe quando si cambia pagina della tabella
                    $('#Justification').on('page.dt search.dt', function () { 
                        $('#Justification').ready(function(){
                            disableRows();
                            setRemoveLinks();
                        });
                    });     

                }else if(response["status"] = 401){
                    //Se non si è autorizzati si ritorna al login
                    window.location = "{{ url('') }}";
                }       
            }
        });
    }

    /**
    * Funzione che disabilita le righe contenute nell'array passato
    */
    function disableRows(){
        for(var row in rows){
            if($(rows[row]).length){
                $(rows[row]).addClass('text-light');
                $(rows[row]).removeAttr('data-toggle');
                $(rows[row]).removeAttr('data-target');
            }
        }
    }

    /**
    * Funzione che imposta i link delle motivazioni
    */
    function setLinks(){
        $("#Justification").ready(function() {
            //Trovo tutti i link che servono all'eliminazione delle motivazioni
            var links = $("#Justification").children('tbody').children("tr");
            $.each(links, function(){
                //Gli imposto i valori necessari per aprire il modale
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#addJustificationModal');
                $(this).click(function(){
                    //Al click mostro il modale di conferma
                    addLink = $(this);
                    var id = $(this).attr("id");
                    $("#justificationMessage").text("Sicuro di voler aggiungere la motivazione: " + id);
                });
            });
            disableRows();
        });
    }

    /**
    * Funzione che imposta i link per l'eliminazione
    */
    function setRemoveLinks(){
        $("#AddedJustification").ready(function() {
            //Trovo tutti i link che servono all'eliminazione delle motivazioni
            var links = $("#AddedJustification").children('tbody').children("tr");
            $.each(links, function(){
                //Gli imposto i valori necessari per aprire il modale
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#removeJustificationModal');
                $(this).click(function(){
                    //Al click mostro il modale di conferma
                    removeLink = $(this);
                    var id = $(this).children().eq(0).text();
                    $("#removeJustificationMessage").text("Sicuro di voler togliere la motivazione: " + id);
                });
            });
            disableRows();
        });
    }

    /**
    * Funzione che collega una motivazione ad un formulario
    */
    function addJustification(){
        var data = {'id_form': form["id"], 'id_justification' : $(addLink).attr("id")};
        
        //Nascondo il modale
        $('#addJustificationModal').modal('hide');

        //Eseguo la richiesta di inserimento
        $.ajax({
            type: "post", 
            url: "{{ url('teacher/justification/add') }}",
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            data: JSON.stringify(data),  
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la tabella
            complete: function(response) {
                if(response["status"] == 201){
                    createJustificationTable();
                    toastr.success('Motivazione aggiunta con successo');
                }else{
                    toastr.error("Impossibile aggiungere la motivazione");
                }
            }
        });
    }

    /**
    * Funzione che consente di rimuovere una motivazione dal formulario
    */
    function removeJustification(){
        //Nascondo il modale
        $('#removeJustificationModal').modal('hide');

        var link = "{{ url('teacher/justification/remove/') }}";
        link += "/" + form['id'] + "/" + $(removeLink).children().eq(0).text();

        //Eseguo la richiesta di inserimento
        $.ajax({
            type: "delete", 
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la tabella
            complete: function(response) {
                if(response["status"] == 200){
                    
                    var index = rows.indexOf($(removeLink).children().eq(0).text());
                    if (index > -1) {
                        rows.splice(index, 1);
                    }

                    rows = [];

                    createJustificationTable();
                    
                    toastr.success('Motivazione rimossa con successo');
                }else{
                    toastr.error("Impossibile rimuovere la motivazione");
                }
            }
        });
    }
</script>
@endsection