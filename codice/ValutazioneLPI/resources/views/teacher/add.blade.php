@extends('_templates/teacher_header')

@section('title', 'Docenti')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <form id="addFormForm" class="text-center border border-light p-5 mt-3 my-5 md-form">
            <p class="h4 mb-4">Aggiungi un formulario</p>

            <input type="text" id="title" name="title" class="form-control mb-4" placeholder="Titolo del progetto" minlength="1" maxlength="255" required>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sullo studente <b class="text-danger">*</b></p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Student first name -->
                        <input type="text" id="student_name" name="student_name" class="form-control mb-4" placeholder="Nome dello studente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Student last name -->
                        <input type="text" id="student_surname" name="student_surname" class="mb-4 form-control" placeholder="Cognome dello studente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Student E-mail -->
                        <input type="email" id="student_email" name="student_email" class="form-control mb-4" placeholder="E-mail dello studente" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Student Phone number -->
                        <input type="text" id="student_phone" name="student_phone" class="form-control mb-4" placeholder="Numero di telefono dello studente" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sul docente responsabile <b class="text-danger">*</b></p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher first name -->
                        <input type="text" id="teacher_name" name="teacher_name" class="form-control mb-4" placeholder="Nome del docente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher last name -->
                        <input type="text" id="teacher_surname" name="teacher_surname" class="mb-4 form-control" placeholder="Cognome del docente" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+" required>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher E-mail -->
                        <input type="email" id="teacher_email" name="teacher_email" class="form-control mb-4" placeholder="E-mail del docente" required>
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher Phone number -->
                        <input type="text" id="teacher_phone" name="teacher_phone" class="form-control mb-4" placeholder="Numero di telefono del docente" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sul primo perito</p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher first name -->
                        <input type="text" id="expert1_name" name="expert1_name" class="form-control mb-4" placeholder="Nome del primo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher last name -->
                        <input type="text" id="expert1_surname" name="expert1_surname" class="mb-4 form-control" placeholder="Cognome del primo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher E-mail -->
                        <input type="email" id="expert1_email" name="expert1_email" class="form-control mb-4" placeholder="E-mail del primo perito">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher Phone number -->
                        <input type="text" id="expert1_phone" name="expert1_phone" class="form-control mb-4" placeholder="Numero di telefono del primo perito" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$">
                    </div>
                </div>
            </div>

            <div class="col-md-12 border border-light my-3 py-3">
                <p class="text-center my-3">Informazioni sul secondo perito</p>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher first name -->
                        <input type="text" id="expert2_name" name="expert2_name" class="form-control mb-4" placeholder="Nome del secondo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher last name -->
                        <input type="text" id="expert2_surname" name="expert2_surname" class="mb-4 form-control" placeholder="Cognome del secondo perito" minlength="2" pattern="[ A-Za-zÀ-ÖØ-öø-ÿ]+">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Teacher E-mail -->
                        <input type="email" id="expert2_email" name="expert2_email" class="form-control mb-4" placeholder="E-mail del secondo perito">
                    </div>
                    <div class="col-md-6">
                        <!-- Teacher Phone number -->
                        <input type="text" id="expert2_phone" name="expert2_phone" class="form-control mb-4" placeholder="Numero di telefono del secondo perito" pattern="^(0|0041|\+41)?[1-9\s][0-9\s]{1,12}$">
                    </div>
                </div>
            </div>

            <p class="text-left">I riquadri contrassegnati da un <b class="text-danger">*</b> sono richiesti</p>

            <!-- Sign up button -->
            <button class="btn btn-info my-4 btn-block">Aggiungi</button>
        </form>
    </div>
    <div class="col-md-3 my-5">
        <div class="errors text-danger">

        </div>
    </div>
</div>
@endsection