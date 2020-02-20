@extends('_templates/teacher_header')

@section('title', 'Docenti')

@section('content')
<div class="row">
    <div class="col-md-10 text-center offset-1">
        <h3 class="h3 text-center my-5">Storico dei formulari</h3>
        <div class="errors-forms text-danger">

        </div>
        <div class="forms-table table-responsive mb-5">
        </div>
    </div>
</div>

<script src="/resources/js/JSONToHTML.js"></script>
<script>
    $(document).ready(function(){
        //Notifico la mancanza di un email verificata
        var user = <?php echo $user ?>

        if(user['confirmed'] == 0) {
            toastr.warning('Verifica la tua email');
        }

        createFormsTable();
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
                        var obj = {'title': response["responseJSON"][item]['title'], 'creato': created, 'Email allievo': response["responseJSON"][item]['student_email'], 'Email docente': response["responseJSON"][item]['teacher_email']};
                        data.push(obj);
                    }
                    
                    var table = JSONToHTML('Form', data);
                    $(".forms-table").html(table);  
                    $("#Form").DataTable({
                        "searching": true,
                        "ordering": false,
                        "bLengthChange": false,
                        "info" : false,
                        "iDisplayLength": 5,
                        "oLanguage": {
                            "sEmptyTable": "Nessun formulario da mostrare",
                            "sSearch": "Cerca formulari",
                            "oPaginate": {
                                "sFirst": "Prima pagina",
                                "sPrevious": "Pagina precedente", 
                                "sNext": "Prossima pagina", 
                                "sLast": "Ultima pagina"
                            }
                        }
                    });
                }       
            }
        });
    }

</script>
@endsection