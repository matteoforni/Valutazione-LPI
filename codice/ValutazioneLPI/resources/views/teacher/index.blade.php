@extends('_templates/teacher_header')

@section('title', 'Docenti')

@section('content')
<div class="row">
    <h1>TEACHER</h1>
</div>
<script>
$(document).ready(function(){
    //Notifico la mancanza di un email verificata
    var user = <?php echo $user ?>

    if(user['confirmed'] == 0) {
        toastr.warning('Verifica la tua email');
    }
});
</script>
@endsection