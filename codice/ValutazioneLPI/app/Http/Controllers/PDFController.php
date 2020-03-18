<?php

use Illuminate\Http\Request;
use App\Form;
use App\Justification;
use App\Contains;
use App\Has;
use Illuminate\Support\Facades\DB;

/**
 * Classe che genera i PDF di valutazione
 */
class PDFController extends TCPDF{
    private $form;    
    /**
     * Funzione che consente di generare l'header del PDF
     */
    public function Header() {
        //Mi posiziono a 9 mm dall'inizio del documento
        $this->SetY(9);
        //Imposto il font
        $this->SetFont('courier', 'I', 9.5);
        //Genero l'header
        $this->Cell(0, 9.5, 'Procedura di qualificazione: Informatica/o AFC (Ordinanza 2014) Griglia di valutazione', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    /**
     * Funzione che consente di generare il footer del PDF
     */
    public function Footer() {
        //Mi posiziono a 15 mm dalla fine del documento
        $this->SetY(-15);
        //Imposto il font
        $this->SetFont('courier', 'I', 10);
        //Genero il footer
        $this->Cell(30, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(215, 10, 'Versione 2.0 (310119) - Ordinanza 2014', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    /**
     * Funzione che ritorna il formulario con tutti i suoi dati
     * @return Il formulario in uso
     */
    public function getForm(){
        $parts = explode("/", $_SERVER['REQUEST_URI']);
        $this->form = Form::find(end($parts));
    }

    /**
     * Funzione che ritorna lo studente collegato al formulario
     * @return I dati dello studente
     */
    public function getStudent(){
        $student = (object)["name" => $this->form['student_name'] . " " . $this->form['student_surname'], "phone" => $this->form['student_phone'], "email" => $this->form['student_email']];
        return $student;
    }

    /**
     * Funzione che ritorna il docente collegato al formulario
     * @return I dati del docente
     */
    public function getTeacher(){
        $teacher = (object)["name" => $this->form['teacher_name'] . " " . $this->form['teacher_surname'], "phone" => $this->form['teacher_phone'], "email" => $this->form['teacher_email']];
        return $teacher;
    }
    
    /**
     * Funzione che ritorna il primo perito collegato al formulario
     * @return I dati del primo perito
     */
    public function getExpert1(){
        $expert1 = (object)["name" => $this->form['expert1_name'] . " " . $this->form['expert1_surname'], "phone" => $this->form['expert1_phone'], "email" => $this->form['expert1_email']];
        return $expert1;
    }

    /**
     * Funzione che ritorna il secondo perito collegato al formulario
     * @return I dati del secondo perito
     */
    public function getExpert2(){
        $expert2 = (object)["name" => $this->form['expert2_name'] . " " . $this->form['expert2_surname'], "phone" => $this->form['expert2_phone'], "email" => $this->form['expert2_email']];
        return $expert2;
    }

    /**
     * Funzione che ritorna tutte le motivazioni collegate ad un formulario
     * @return L'array con le motivazioni
     */
    public function getFormJustifications(){
        //Ottengo tutte le motivazioni del formulario
        $contains = Contains::where('id_form', $this->form['id'])->get();
        //Ottengo i punti specifici del formulario
        $points = Has::where('id_form', $this->form['id'])->get();

        //Creo un array che ha come chiavi il codice del punto con una A davanti
        $justificationPoints = array();
        foreach($points as $point){
            $key = "A".$point->id_point;
            $justificationPoints[$key] = "";
        }
        //Creo l'array che andrà a contenere le motivazioni della sezione A
        $justificationA = array("A1" => "", "A2" => "", "A3" => "", "A4" => "", "A5" => "", "A6" => "", "A7" => "", "A8" => "", "A9" => "", "A10" => "", "A11" => "", "A12" => "", "A13" => "");
        //Unisco i punti specifici così da avere un'array con tutte le righe della tabella della sezione A
        $justificationA = array_merge($justificationA, $justificationPoints);
        
        //Creo l'array che andrà a contenere le motivazioni della sezione B
        $justificationB = array("B1" => "", "B2" => "", "B3" => "", "B4" => "", "B5" => "", "B6" => "", "B7" => "", "B8" => "", "B9" => "", "B10" => "");
        //Creo l'array che andrà a contenere le motivazioni della sezione C
        $justificationC = array("C1" => "", "C2" => "", "C3" => "", "C4" => "", "C5" => "", "C6" => "", "C7" => "", "C8" => "", "C9" => "", "C10" => "");

        //Per ogni collegamento tra formulario e motivazione
        foreach($contains as $item){
            //Carico i dati della motivazione
            $justification = Justification::find($item->id_justification);
             
            //Verifico se va nella sezione A, B o C e la aggiungo alla rispettiva sezione
            if(substr($justification->id_point, 0, 1) === "A"){
                $justificationA[$justification->id_point] .= $justification->text . "<br>";
            }else if(substr($justification->id_point, 0, 1) === "B"){
                $justificationB[$justification->id_point] .= $justification->text . "<br>";
            }else if(substr($justification->id_point, 0, 1) === "C"){
                $justificationC[$justification->id_point] .= $justification->text . "<br>";
            }else{
                $justificationA["A".$justification->id_point] .= $justification->text . "<br>";
            }
        }

        //Cambio le chiavi dei punti specifici con quelle della tabella (da A14 a A20)
        $mom = 14;
        foreach($justificationPoints as $key => $item){
            $justificationA["A".$mom] = strval($justificationA[$key]);
            unset($justificationA[$key]);
            $mom++;
        }
        
        //Unisco le tre sezioni in un array
        $justifications = array();
        
        $justifications['A'] = $justificationA;
        $justifications['B'] = $justificationB;
        $justifications['C'] = $justificationC;

        //Ritorno la risposta
        return $justifications;
    }

    /**
     * Funzione che ritorna i punti per le sezioni
     */
    public function getPoints(){
        //Carico i punti della prima sezione
        $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point like 'A%' and contains.id_form = " . $this->form['id'];
        $pointsAmom = count(DB::select($query));
        $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point NOT REGEXP '[a-zA-Z]' and contains.id_form = " . $this->form['id'];
        $pointsA = 60-($pointsAmom+count(DB::select($query)));

        //Carico i punti della seconda sezione
        $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point like 'B%' and contains.id_form = " . $this->form['id'];
        $pointsB = 30-count(DB::select($query));

        //Carico i punti della terza sezione
        $query = "select * from contains inner join justification on contains.id_justification = justification.id where justification.id_point like 'C%' and contains.id_form = " . $this->form['id'];
        $pointsC = 30-count(DB::select($query));
        
        //ritorno i punteggi in un array unico
        $points = array("A" => $pointsA, "B" => $pointsB, "C" => $pointsC);
        return $points;
    }
}

//Creo il PDF
$pdf = new PDFController(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//Imposto i margini
$pdf->SetMargins("20", "15", "20");

//Ottengo il formulario
$pdf->getForm();

//Ottengo l'allievo
$student = $pdf->getStudent();

//Ottengo il docente
$teacher = $pdf->getTeacher();

//Ottengo il primo perito
$expert1 = $pdf->getExpert1();

//Ottegno il secondo perito
$expert2 = $pdf->getExpert2();

//Ottengo i punti
$points = $pdf->getPoints();

//Salvo i punti della prima sezione e ne calcolo la nota
$pointsA = $points['A'];
$resultA = round($pointsA/60*5+1,1);

//Salvo i punti della seconda sezione e ne calcolo la nota
$pointsB = $points['B'];
$resultB = round($pointsB/30*5+1,1);

//Salvo i punti della terza sezione e ne calcolo la nota
$pointsC = $points['C'];
$resultC = round($pointsC/30*5+1,1);

//Calcolo la nota finale
$finalResult = round($resultA*0.5 + $resultB *0.25 + $resultC * 0.25,1);

//Carico tutte le motivazioni
$justifications = $pdf->getFormJustifications();

//Divido le sezioni e le salvo come oggetti
$justificationA = (object)$justifications['A'];
$justificationB = (object)$justifications['B'];
$justificationC = (object)$justifications['C'];


//Aggiungo una pagina
$pdf->AddPage('P', 'A4');
$pdf->SetY(10);

//Genero la prima pagina
$content = <<<EOF
<style>
h1 {
    color: #00418c;
    font-weight: lighter;
    font-size: large;
}
th {
    background-color: #e3e3e3;
}
p {
    text-align: justify;
}
td {
    padding: 3px;
}

</style>
<br>
<hr>
<h1>        1 INFOMAZIONI GENERALI</h1>
<table border="0.5" cellspacing="0" cellpadding="2">
    <tr>
        <th><b> Superiore professionale</b></th>
        <th><b> Candidata/o</b></th>
    </tr>
    <tr>
        <td>$teacher->name</td>
        <td>$student->name</td>
    </tr>
    <tr>
        <td><b> Telefono</b></td>
        <td><b> Telefono</b></td>
    </tr>
    <tr>
        <td>$teacher->phone</td>
        <td>$student->phone</td>
    </tr>
    <tr>
        <td><b> Email</b></td>
        <td><b> Email</b></td>
    </tr>
    <tr>
        <td>$teacher->email</td>
        <td>$student->email</td>
    </tr>
</table>
<br><br>
<table border="0.3" cellspacing="0" cellpadding="2">
    <tr>
        <th><b> Perito 1</b></th>
        <th><b> Perito 2</b></th>
    </tr>
    <tr>
        <td>$expert1->name</td>
        <td>$expert2->name</td>
    </tr>
    <tr>
        <td><b> Telefono</b></td>
        <td><b> Telefono</b></td>
    </tr>
    <tr>
        <td>$expert1->phone</td>
        <td>$expert2->phone</td>
    </tr>
    <tr>
        <td><b> Email</b></td>
        <td><b> Email</b></td>
    </tr>
    <tr>
        <td>$expert1->email</td>
        <td>$expert2->email</td>
    </tr>
</table><br>
<hr>
<h1>        2 PROCEDURA</h1>
<p>Il seguente documento non deve assolutamente essere mostrato al candidato una volta attribuiti i punti.</p>
<p><u>Documentazione</u><br>

I periti d’esame trattano la documentazione in maniera confidenziale. La conservazione della documentazione è regolata dalla legge cantonale.

<br><br><u>Valutazione</u><br>

Il superiore professionale e gli esperti valutano le competenze professionali allargate, il risultato e le competenze professionali.</p>
<p><b>Parte A</b> Competenze professionali (20 criteri, da completare da parte del superiore professionale):<br>

        6 criteri relativi all’analisi e al concetto<br>
        7 criteri relativi la realizzazione, ai test e al risultato del LPI<br>
        7 criteri specifici ai compiti definiti dal superiore professionale nel QdC<br><br>

<b>Parte B</b> Documentazione LPI (10 criteri, da completare da parte del superiore professionale).<br><br>

<b>Parte C</b> Presentazione e colloquio professionale (10 criteri, da completare da parte dei periti).<br><br>

Unicamente in caso di disaccordo tra periti e superiore professionale nella valutazione indicare i punti assegnati dai periti in Pt.Pe ed utilizzare il campo note (punto 7). </p>
EOF;
//Scrivo nel file la pagina
$pdf->writeHTML($content);

//Aggiungo una pagina
$pdf->AddPage();

//Genero la seconda pagina
$content = <<<EOF
<style>
h1 {
    color: #00418c;
    font-weight: lighter;
    font-size: large;
}
th {
    background-color: #e3e3e3;
}
p {
    text-align: justify;
}
td {
    font-size: 10px;
}
</style>
<br>
<hr>
<h1>        3 PARTE A: Competenze professionali</h1>
<table border="0.3" cellspacing="0" cellpadding="1">
    <tr> 
        <th width="35"></th>
        <th width="145"><b>  Domanda</b></th>
        <th width="30"><b>  Pt.</b></th>
        <th width="240"><b>  Motivazione</b></th>
        <th width="30"><b>  Pt. Pe</b></th>  
    </tr>
</table>
<table border="0.3" cellspacing="0" cellpadding="9">
    <tr>
        <td width="35"><b>A1</b></td>
        <td width="145">Gestione progetto e pianificazione</td>
        <td width="30"></td>
        <td width="240">$justificationA->A1</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td width="35"><b>A2</b></td>
        <td width="145">Acquisizione del sapere</td>
        <td width="30"></td>
        <td width="240">$justificationA->A2</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td><b>A3</b></td>
        <td>Pianificazione</td>
        <td></td>
        <td>$justificationA->A3</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A4</b></td>
        <td>Comprensione concettuale</td>
        <td></td>
        <td>$justificationA->A4</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A5</b></td>
        <td>Ambiente di progetto: limiti del sistema / interfacce con l’esterno</td>
        <td></td>
        <td>$justificationA->A5</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A6</b></td>
        <td>Test della soluzione (pianificazione ed esecuzione)</td>
        <td></td>
        <td>$justificationA->A6</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A7</b></td>
        <td>Motivazione / Impegno / Attitudine al lavoro / Esecuzione</td>
        <td></td>
        <td>$justificationA->A7</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A8</b></td>
        <td>Lavoro autonomo</td>
        <td></td>
        <td>$justificationA->A8</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A9</b></td>
        <td>Conoscenze professionali e competenze pratiche</td>
        <td></td>
        <td>$justificationA->A9</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A10</b></td>
        <td>Utilizzo dei termini tecnici</td>
        <td></td>
        <td>$justificationA->A10</td>
        <td></td>    
    </tr>
</table>
EOF;
//Scrivo nel file la pagina
$pdf->writeHTML($content);

//Aggiungo una pagina
$pdf->AddPage();

//Genero la terza pagina
$content = <<<EOF
<style>
h1 {
    color: #00418c;
    font-weight: lighter;
    font-size: large;
}
th {
    background-color: #e3e3e3;
}
p {
    text-align: justify;
}
td {
    font-size: 10px;
}
</style>

<table border="0.3" cellspacing="0" cellpadding="1">
    <tr> 
        <th width="35"></th>
        <th width="145"><b>  Domanda</b></th>
        <th width="30"><b>  Pt.</b></th>
        <th width="240"><b>  Motivazione</b></th>
        <th width="30"><b>  Pt. Pe</b></th>  
    </tr>
</table>
<table border="0.3" cellspacing="0" cellpadding="9">
    <tr>
        <td width="35"><b>A11</b></td>
        <td width="145">Metodologia di lavoro e professionale</td>
        <td width="30"></td>
        <td width="240">$justificationA->A11</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td width="35"><b>A12</b></td>
        <td width="145">Organizzazione dei risultati del lavoro</td>
        <td width="30"></td>
        <td width="240">$justificationA->A12</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td><b>A13</b></td>
        <td>Prestazione</td>
        <td></td>
        <td>$justificationA->A13</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A14</b></td>
        <td>Punti tecnici valutati specifici per il progetto. <small>(punto 8.1 del QdC)</small></td>
        <td></td>
        <td>$justificationA->A14</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A15</b></td>
        <td>Punti tecnici valutati specifici per il progetto. <small>(punto 8.2 del QdC)</small></td>
        <td></td>
        <td>$justificationA->A15</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A16</b></td>
        <td>Punti tecnici valutati specifici per il progetto. <small>(punto 8.3 del QdC)</small></td>
        <td></td>
        <td>$justificationA->A16</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A17</b></td>
        <td>Punti tecnici valutati specifici per il progetto. <small>(punto 8.4 del QdC)</small></td>
        <td></td>
        <td>$justificationA->A17</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A18</b></td>
        <td>Punti tecnici valutati specifici per il progetto. <small>(punto 8.5 del QdC)</small></td>
        <td></td>
        <td>$justificationA->A18</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A19</b></td>
        <td>Punti tecnici valutati specifici per il progetto. <small>(punto 8.6 del QdC)</small></td>
        <td></td>
        <td>$justificationA->A19</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>A20</b></td>
        <td>Punti tecnici valutati specifici per il progetto. <small>(punto 8.7 del QdC)</small></td>
        <td></td>
        <td>$justificationA->A20</td>
        <td></td>    
    </tr>
    <tr>
        <td colspan="2"><b>Totale parte A (60 punti massimi)</b></td>
        <td>$pointsA</td>
        <td></td>
        <td></td>    
    </tr>
</table>
<br>
<p>Si prega di utilizzare il catalogo criteri per completare questo modulo. Troverai i livelli di qualità per ogni domanda. Si possono assegnare unicamente punti interi (compresi tra 0 e 3). Si prega di motivare le valutazioni inferiori a 3.</p>
EOF;
//Scrivo nel file la pagina
$pdf->writeHTML($content);

//Aggiungo una pagina
$pdf->AddPage();

//Genero la quarta pagina
$content = <<<EOF
<style>
h1 {
    color: #00418c;
    font-weight: lighter;
    font-size: large;
}
th {
    background-color: #e3e3e3;
}
p {
    text-align: justify;
}
td {
    font-size: 10px;
}
</style>
<br>
<hr>
<h1>        4 PARTE B: Documentazione</h1>
<table border="0.3" cellspacing="0" cellpadding="1">
    <tr> 
        <th width="35"></th>
        <th width="145"><b>  Domanda</b></th>
        <th width="30"><b>  Pt.</b></th>
        <th width="240"><b>  Motivazione</b></th>
        <th width="30"><b>  Pt. Pe</b></th>  
    </tr>
</table>
<table border="0.3" cellspacing="0" cellpadding="9">
    <tr>
        <td width="35"><b>B1</b></td>
        <td width="145">Riassunto della documentazione</td>
        <td width="30"></td>
        <td width="240">$justificationB->B1</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td width="35"><b>B2</b></td>
        <td width="145">Tenuta del diario di lavoro</td>
        <td width="30"></td>
        <td width="240">$justificationB->B2</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td><b>B3</b></td>
        <td>Capacità di riflessione</td>
        <td></td>
        <td>$justificationB->B3</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>B4</b></td>
        <td>Struttura</td>
        <td></td>
        <td>$justificationB->B4</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>B5</b></td>
        <td>Concisione</td>
        <td></td>
        <td>$justificationB->B5</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>B6</b></td>
        <td>Completezza formale della documentazione</td>
        <td></td>
        <td>$justificationB->B6</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>B7</b></td>
        <td>Espressione scritta e stile / ortografia e grammatica</td>
        <td></td>
        <td>$justificationB->B7</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>B8</b></td>
        <td>Rappresentazione</td>
        <td></td>
        <td>$justificationB->B8</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>B9</b></td>
        <td>Grafica, immagini, diagrammi e tabelle</td>
        <td></td>
        <td>$justificationB->B9</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>B10</b></td>
        <td>Documentazione della procedura di test e dei rispettivi risultati</td>
        <td></td>
        <td>$justificationB->B10</td>
        <td></td>    
    </tr>
    <tr>
        <td colspan="2"><b>Totale parte B (30 punti massimi)</b></td>
        <td>$pointsB</td>
        <td></td>
        <td></td>    
    </tr>
</table>
<br>
<p>Si prega di utilizzare il catalogo criteri per completare questo modulo. Troverai i livelli di qualità per ogni domanda. Si possono assegnare unicamente punti interi (compresi tra 0 e 3). Si prega di motivare le valutazioni inferiori a 3.</p>
EOF;
//Scrivo nel file la pagina
$pdf->writeHTML($content);

//Aggiungo una pagina
$pdf->AddPage();

//Genero la quinta pagina
$content = <<<EOF
<style>
h1 {
    color: #00418c;
    font-weight: lighter;
    font-size: large;
}
th {
    background-color: #e3e3e3;
}
p {
    text-align: justify;
}
td {
    font-size: 10px;
}
</style>
<br>
<hr>
<h1>        5 PARTE C: Presentazione e colloquio professionale</h1>
<table border="0.3" cellspacing="0" cellpadding="1">
    <tr> 
        <th width="35"></th>
        <th width="145"><b>  Domanda</b></th>
        <th width="30"><b>  Pt.</b></th>
        <th width="240"><b>  Motivazione</b></th>
        <th width="30"><b>  Pt. Pe</b></th>  
    </tr>
</table>
<table border="0.3" cellspacing="0" cellpadding="9">
    <tr>
        <td width="35"><b>C1</b></td>
        <td width="145">Gestione del tempo, struttura</td>
        <td width="30"></td>
        <td width="240">$justificationC->C1</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td width="35"><b>C2</b></td>
        <td width="145">Utilizzo dei media, aspetti tecnici</td>
        <td width="30"></td>
        <td width="240">$justificationC->C2</td>
        <td width="30"></td>    
    </tr>
    <tr>
        <td><b>C3</b></td>
        <td>Tecnica di presentazione</td>
        <td></td>
        <td>$justificationC->C3</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>C4</b></td>
        <td>Dimostrazione / presentazione del prodotto realizzato</td>
        <td></td>
        <td>$justificationC->C4</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>C5</b></td>
        <td>Domanda esperti 1</td>
        <td></td>
        <td>$justificationC->C5</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>C6</b></td>
        <td>Domanda esperti 2</td>
        <td></td>
        <td>$justificationC->C6</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>C7</b></td>
        <td>Domanda esperti 3</td>
        <td></td>
        <td>$justificationC->C7</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>C8</b></td>
        <td>Domanda esperti 4</td>
        <td></td>
        <td>$justificationC->C8</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>C9</b></td>
        <td>Domanda esperti 5</td>
        <td></td>
        <td>$justificationC->C9</td>
        <td></td>    
    </tr>
    <tr>
        <td><b>C10</b></td>
        <td>Domanda esperti 6</td>
        <td></td>
        <td>$justificationC->C10</td>
        <td></td>    
    </tr>
    <tr>
        <td colspan="2"><b>Totale parte C (30 punti massimi)</b></td>
        <td>$pointsC</td>
        <td></td>
        <td></td>    
    </tr>
</table>
<br>
<p>Si prega di utilizzare il catalogo criteri per completare questo modulo. Troverai i livelli di qualità per ogni domanda. Si possono assegnare unicamente punti interi (compresi tra 0 e 3). Si prega di motivare le valutazioni inferiori a 3.</p>
EOF;
//Scrivo nel file la pagina
$pdf->writeHTML($content);

//Aggiungo una pagina
$pdf->AddPage();

//Genero la sesta pagina
$content = <<<EOF
<style>
h1 {
    color: #00418c;
    font-weight: lighter;
    font-size: large;
}
th {
    background-color: #e3e3e3;
}
p {
    text-align: justify;
}
td {
    font-size: 10px;
}
</style>
<br>
<hr>
<h1>        6 SCHEMA RIASSUNTIVO</h1>
<table border="0.3" cellspacing="0" cellpadding="4">
    <tr> 
        <th width="170"></th>
        <th width="60"><b>Punti massimi</b></th>
        <th width="60"><b>Punti ottenuti</b></th>
        <th width="60"><b>Punti ottenuti Pe</b></th>
        <th width="60"><b>Nota</b></th>  
        <th width="70"><b>Decisione capoperito</b></th>
    </tr>
    <tr>
        <td><b>A. Competenze professionali</b></td>
        <td><b>60</b></td>
        <td>$pointsA</td>
        <td></td>
        <td>$resultA</td>
        <td></td>
    </tr>
    <tr>
        <td><b>B. Documentazione LPI</b></td>
        <td><b>30</b></td>
        <td>$pointsB</td>
        <td></td>
        <td>$resultB</td>
        <td></td>
    </tr>
    <tr>
        <td><b>C. Presentazione e colloquio professionale</b></td>
        <td><b>30</b></td>
        <td>$pointsC</td>
        <td></td>
        <td>$resultC</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4"><b>Valutazione (arrotondata al decimo) (A * 0.5 + B * 0.25 + C * 0.25)</b></td>
        <td>$finalResult</td>
        <td></td>
    </tr>
</table>
<br>
<p>Calcolo della nota per le parti A, B e C = (5 * punti ottenuti / punti massimi) + 1 (arrotondamento a 0.5)<br>
Calcolo della nota finale = Nota A x 0.5 + Nota B x 0.25 + Nota C x 0.25 (nota arrotondamento a 0.1)</p>
<br>
<table cellspacing="0" cellpadding="1">
    <tr>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Pt 60</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Pt 30</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Nota</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Pt 60</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Pt 30</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Nota</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Pt 60</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Pt 30</b></th>
        <th style="background-color: white; border: 0.2px dotted black;"><b>Nota</b></th>
    </tr>
    <tr  style="background-color: #e3e3e3;">
        <td style="border: 0.2px dotted black;"><b>0-2</b></td>
        <td style="border: 0.2px dotted black;"><b>0-1</b></td>
        <td style="border: 0.2px dotted black;">1.0</td>
        <td style="border: 0.2px dotted black;"><b>21-26</b></td>
        <td style="border: 0.2px dotted black;"><b>11-13</b></td>
        <td style="border: 0.2px dotted black;">3.0</td>
        <td style="border: 0.2px dotted black;"><b>45-50</b></td>
        <td style="border: 0.2px dotted black;"><b>23-25</b></td>
        <td style="border: 0.2px dotted black;">5.0</td>
    </tr>
    <tr>
        <td style="border: 0.2px dotted black;"><b>3-8</b></td>
        <td style="border: 0.2px dotted black;"><b>2-4</b></td>
        <td style="border: 0.2px dotted black;">1.5</td>
        <td style="border: 0.2px dotted black;"><b>27-32</b></td>
        <td style="border: 0.2px dotted black;"><b>14-16</b></td>
        <td style="border: 0.2px dotted black;">3.5</td>
        <td style="border: 0.2px dotted black;"><b>51-56</b></td>
        <td style="border: 0.2px dotted black;"><b>26-28</b></td>
        <td style="border: 0.2px dotted black;">5.5</td>
    </tr>
    <tr style="background-color: #e3e3e3;">
        <td style="border: 0.2px dotted black;"><b>9-14</b></td>
        <td style="border: 0.2px dotted black;"><b>5-7</b></td>
        <td style="border: 0.2px dotted black;">2.0</td>
        <td style="border: 0.2px dotted black;"><b>33-38</b></td>
        <td style="border: 0.2px dotted black;"><b>17-19</b></td>
        <td style="border: 0.2px dotted black;">4.0</td>
        <td style="border: 0.2px dotted black;"><b>57-60</b></td>
        <td style="border: 0.2px dotted black;"><b>29-30</b></td>
        <td style="border: 0.2px dotted black;">6</td>
    </tr>
    <tr>
        <td style="border: 0.2px dotted black;"><b>15-20</b></td>
        <td style="border: 0.2px dotted black;"><b>8-10</b></td>
        <td style="border: 0.2px dotted black;">2.5</td>
        <td style="border: 0.2px dotted black;"><b>39-44</b></td>
        <td style="border: 0.2px dotted black;"><b>20-22</b></td>
        <td style="border: 0.2px dotted black;">4.5</td>
        <td style="border: 0.2px dotted black;"><b></b></td>
        <td style="border: 0.2px dotted black;"><b></b></td>
        <td style="border: 0.2px dotted black;"></td>
    </tr>
</table>
<br>
<hr>
<h1>        7 NOTE</h1>
<table cellspacing="0" cellpadding="1">
    <tr>
        <td style="border: 0.2px dotted black;"></td>
    </tr>
    <tr>
        <td style="border: 0.2px dotted black;"></td>
    </tr>
    <tr>
        <td style="border: 0.2px dotted black;"></td>
    </tr>
    <tr>
        <td style="border: 0.2px dotted black;"></td>
    </tr>
    <tr>
        <td style="border: 0.2px dotted black;"></td>
    </tr>
    <tr>
        <td style="border: 0.2px dotted black;"></td>
    </tr>
</table>
<br>
<hr>
<h1>        8 FIRME</h1>
<table cellspacing="0" cellpadding="7">
    <tr>
        <th width="140" style="border: 0.5px dotted black;"><b>Superiore Professionale</b></th>
        <th width="32" style="border: 0.5px dotted black;"><b></b></th>
        <th width="140" style="border: 0.5px dotted black;"><b>Perito 1</b></th>
        <th width="32" style="border: 0.5px dotted black;"><b></b></th>
        <th width="140" style="border: 0.5px dotted black;"><b>Perito 2</b></th>
    </tr>
    <tr>
        <td style="border: 0.5px dotted black;"><small>(luogo e data)</small></td>
        <td style="border: 0.5px dotted black;"></td>
        <td style="border: 0.5px dotted black;"><small>(luogo e data)</small></td>
        <td style="border: 0.5px dotted black;"></td>
        <td style="border: 0.5px dotted black;"><small>(luogo e data)</small></td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid black;"></td>
        <td></td>
        <td style="border-bottom: 1px solid black;"></td>
        <td></td>
        <td style="border-bottom: 1px solid black;"></td>
    </tr>
</table>
EOF;
//Scrivo nel file l'ultima pagina
$pdf->writeHTML($content, true, 0, true, 0);
//Chiudo il file
$pdf->lastPage();

//Notifico al browser che invio un PDF
header("Content-Type: application/pdf");
//Stampo il PDF e chiudo l'output
$pdf->Output();
exit();
?>
