@extends('_templates/teacher_header')

@section('title', 'Docenti')

@section('content')
<div class="row">
    <div class="col-md-12 text-center">
        <h3 class="h3 text-center my-5">Storico dei formulari</h3>
        <div class="errors-forms text-danger">

        </div>
        <div class="forms-table table-responsive mb-5">
        </div>

        <button type="button" class="btn btn-primary mb-5" onclick="addForm()">Aggiungi formulario</button>
        <button id="btnPDF" type="button" class="btn btn-success mb-5">Visualizza template</button>
    </div>
</div>

<!-- MODALE DI ELIMINAZIONE DI UN FORMULARIO -->
<div class="modal fade" id="deleteFormModal" tabindex="-1" role="dialog" aria-labelledby="deleteTitle"
  aria-hidden="true">

<div class="modal-dialog modal-md .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="deleteTitle">Conferma eliminazione</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p id="formMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteForm()">Elimina</button>
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    $(document).ready(function(){
        createFormsTable();

        //Al click apro il PDF vuoto
        $('#btnPDF').click(function(){
            //Genero il link per la richiesta
            var link = "{{ url('teacher/pdf') }}";
            link += "/" + "empty";

            window.open(link, '_blank');
        });

        //Verifico che l'email sia stata confermata
        checkEmailConfirmation();
    });

    /**
     * Funzione che consente di creare la tabella dello storico
     */ 
     function createFormsTable(){
        //Richiedo i dati per riempire la tabella
        $.ajax({
            type: "get",
            url: "{{ url('teacher/forms') }}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",     
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },       
            complete: function(response){
                if(response["status"] == 200){
                    var data = [];
                    for(var item in response["responseJSON"]){
                        var created = response["responseJSON"][item]['created'].split(" ")[0];
                        var obj = {'id': response["responseJSON"][item]['id'], 'titolo': response["responseJSON"][item]['title'], 'creato': created, 'Email allievo': response["responseJSON"][item]['student_email'], 'Email docente': response["responseJSON"][item]['teacher_email'], 'Motivazioni': "<a class='addFieldForm'><i class='far fa-plus-square'></i></a>", 'Risultati': "<a class='resultFieldForm'><i class='far fa-chart-bar'></i></a>"};
                        data.push(obj);
                    }

                    if(!(data && data.length)){
                        data.push({'id': '', 'titolo': '', 'creato': '', 'Email allievo': '', 'Email docente': ''});
                    }

                    var table = JSONToHTML('Form', data, true);
                    $(".forms-table").html(table);  
                    $("#Form").DataTable({
                        "searching": true,
                        "ordering": false,
                        "bLengthChange": false,
                        "info" : false,
                        "iDisplayLength": 5,
                        "oLanguage": {
                            //"sEmptyTable": "Nessun formulario da mostrare",
                            //"sSearch": "Cerca formulari",
                            "oPaginate": {
                                "sFirst": "Prima pagina",
                                "sPrevious": "Pagina precedente", 
                                "sNext": "Prossima pagina", 
                                "sLast": "Ultima pagina"
                            }
                        }
                    });

                    setFormLinks();

                    //Reimposto i links quando si cambia pagina nella tabella
                    $('#Form').on('page.dt', function () {
                        setFormLinks();
                    });
                }else if(response["status"] == 401){
                    window.location = "{{ url('') }}";
                }    
            }
        });
    }

    /**
     * Funzone che consente di eseguire la richiesta che elimina l'utente selezionato
     */
     function deleteForm(){
        $('#deleteFormModal').modal('hide');
        //Genero il link che andranno a richiamare
        var link = "{{ url('teacher/form/delete/') }}";
        link += "/" + $(deleteLink).parents().eq(1).attr("id");
        //Eseguo la richiesta
        $.ajax({
            type: "delete", 
            url: link,
            contentType: "application/json; charset=utf-8",
            dataType: "json",   
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se è finita con successo richiamo la stessa funzione così da aggiornare la pagina
            complete: function(response) {
                if(response["status"] == 200){
                    createFormsTable();
                    toastr.success('Formulario eliminato con successo');
                }else if(response["status"] == 401){
                    window.location = "{{ url('') }}";
                }else{
                    toastr.error("Impossibile eliminare il formulario");
                }
            }
        });
    }

    /**
    * Funzione che imposta i link di eliminazione dei formulari
    */
    function setFormLinks(){
        $("#Form").ready(function() {
            //Trovo tutti i link che servono all'eliminazione dei formulari
            var deleteLinks = $(".deleteFieldForm");
            $.each(deleteLinks, function(){
                //Gli imposto i valori necessari per aprire il modale
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#deleteFormModal');
                $(this).click(function(){
                    //Al click mostro il modale di conferma
                    deleteLink = $(this);
                    var id = $(this).parents().eq(1).attr("id");
                    $("#formMessage").text("Sei sicuro di voler eliminare il formulario: " + id);
                });
            });

            //Trovo tutti i link che servono alla modifica delle motivazioni
            var addLinks = $(".addFieldForm");
            $.each(addLinks, function(){
                $(this).click(function(){
                    var id = $(this).parents().eq(1).attr("id");
                    var link = "{{ url('teacher/form/add/justification') }}";
                    link += "/" + id;
                    window.location = link;
                });
            });

            //Trovo tutti i link che servono alla modifica dei formulari
            var updateLinks = $(".updateFieldForm");
            $.each(updateLinks, function(){
                $(this).click(function(){
                    var id = $(this).parents().eq(1).attr("id");
                    var link = "{{ url('teacher/form/show/add') }}";
                    link += "/" + id;
                    window.location = link;
                });
            });

            //Trovo tutti i link che servono alla visualizzazione dei risultati
            var resultLinks = $(".resultFieldForm");
            $.each(resultLinks, function(){
                $(this).click(function(){
                    var id = $(this).parents().eq(1).attr("id");
                    var link = "{{ url('teacher/form/result') }}";
                    link += "/" + id;
                    window.location = link;
                });
            });
        });
    }

    /**
    * Funzione che rimanda l'utente alla pagina di aggiunta
    */
    function addForm(){
        window.location = "{{url('teacher/form/show/add')}}";
    }

    /**
    * Funzione che consente di verificare se l'email è stata confermata e se non lo è viene mostrata una notifica 
    */
    function checkEmailConfirmation(){
        $.ajax({
            type: "get", 
            url: "{{ url('teacher/user/get/current') }}",
            contentType: "application/json; charset=utf-8",
            dataType: "json",   
            headers: {
                'Authorization':'Bearer ' + Cookies.get('token'),
            },
            //Se non è stata confermata mostro una notifica
            complete: function(response) {
                if(response["status"] == 200){
                    if(!response["responseJSON"]["confirmed"]){
                        toastr.warning("Conferma la tua email");
                    }
                }else if(response["status"] == 401){
                    window.location = "{{ url('') }}";
                }
            }
        });
    }
</script>
@endsection