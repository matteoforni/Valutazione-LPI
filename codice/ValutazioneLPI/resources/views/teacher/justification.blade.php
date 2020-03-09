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

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    /*
    * Array contenente tutte le righe già selezionate
    */
    let rows = [];

    /*
    * Attributo contenente l'ultimo link di aggiunta premuto 
    */
    let addLink; 
    var first = true;

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

                    createAddedJustifications();
                       

                    setLinks();

                    $('#Justification').on('page.dt', function () {
                        $("#Justification").ready(function(){
                            setLinks();
                        });
                    });

                }else if(response["status"] = 401){
                    window.location = "{{ url('') }}";
                }       
            }
        });
    }

    function createAddedJustifications(){
        var form = <?php echo $form ?>;
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
                    
                    for(var item in response["responseJSON"]){
                        var obj = {'Titolo': response["responseJSON"][item]['title']};
                        data.push(obj);
                        rows.push("#" + response["responseJSON"][item]["id_justification"]);
                    }

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

                    disableRows(rows);
         
                    $('#Justification').on('page.dt', function () { 
                        $('#Justification').ready(function(){
                            disableRows(rows);
                        });
                    });   

                }else if(response["status"] = 401){
                    window.location = "{{ url('') }}";
                }       
            }
        });
    }

    function disableRows(rows){
        for(var row in rows){
            $(rows[row]).addClass('text-light');
            $(rows[row]).removeAttr('data-toggle');
            $(rows[row]).removeAttr('data-target');
        }
    }

    /**
    * Funzione che imposta i link delle motivazioni
    */
    function setLinks(){
        $("#Justification").ready(function() {
            //Trovo tutti i link che servono all'eliminazione delle motivazioni
            var rows = $("#Justification").children('tbody').children("tr");
            $.each(rows, function(){
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
        });
    }

    function addJustification(){
        var path = window.location.href;
        var parts = path.split('/');
        var idForm = parts[parts.length-1]
        var data = {'id_form': idForm, 'id_justification' : $(addLink).attr("id")};
        
        $('#addJustificationModal').modal('hide');

        $.ajax({
            type: "post", 
            url: "{{ url('teacher/justification/add') }}",
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            data: JSON.stringify(data),  
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la pagina
            complete: function(response) {
                if(response["status"] == 201){
                    createJustificationTable();
                    rows.push("#" + $(addLink).attr("id"));
                    
                    toastr.success('Motivazione aggiunta con successo');
                }else{
                    toastr.error("Impossibile aggiungere la motivazione");
                }
            }
        });
    }
</script>
@endsection