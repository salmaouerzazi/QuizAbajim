<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class PdfInsertController extends Controller
{
    public function insertIcon(Request $request) {
      
        $x = $request->input('x');
        $y = $request->input('y');

        // Load your PDF
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile('piii.pdf');
        $tpl = $pdf->importPage(6); // for the first page

        $pdf->AddPage();
        $pdf->useTemplate($tpl);
        
        // Load your icon
        $pdf->Image('play-button.png', $x, $y, 30, 30); // 30x30 is the dimension of the image in the PDF

        // Save the new PDF
        $outputPath = 'newww.pdf';
        $pdf->Output($outputPath ,'F');
        

        return response()->json(['message' => 'Icon inserted successfully', 'pdfPath' => $outputPath]);
    }
}
