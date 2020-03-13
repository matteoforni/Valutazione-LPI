<?php

class ValutazionePDF extends TCPDF{
    public function Header() {
        // Position at 15 mm from bottom
        $this->SetY(10);
        // Set font
        $this->SetFont('courier', 'I', 10);
        // Title
        $this->Cell(0, 10, 'Procedura di qualificazione: Informatica/o AFC (Ordinanza 2014) Griglia di valutazione', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('courier', 'I', 10);
        // Page number
        $this->Cell(2, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new ValutazionePDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins("10", "10", "10");

// add a page
$pdf->AddPage('P', 'A4');
$pdf->SetY(20);

$content = <<<EOF
<style>
h1 {
    color:blue;
    font-weight: lighter;
}
</style>
<h1>        1 INFOMAZIONI GENERALI</h1>
<table>
    <tr>
        <th>Superiore professionale</th>
        <th>Candidata/o</th>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Telefono</td>
        <td>Telefono</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Email</td>
        <td>Email</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
</table>
EOF;
    
$pdf->writeHTML($content);

//Close and output PDF document
$pdf->Output('test.pdf', 'D');
?>