<?php
namespace App\Models;

use App\core\FPDF;

class PdfGenerator extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Liste des Participants', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function generateTable($header, $data) {
        $this->SetFont('Arial', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(50, 10, utf8_decode($col), 1);
        }
        $this->Ln();
        
        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(50, 10, utf8_decode($col), 1);
            }
            $this->Ln();
        }
    }
}
?>
