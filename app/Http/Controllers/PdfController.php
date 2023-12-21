<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{

        public function index(Request $request)
        {
            $request->validate([
                'text' => 'required',
            ]);

     
           $data=[
            'text'=>$request->post('text') 
           ];  
            
            $html = view('pdf.template', $data)->render();
    
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_top' => 25,
                'margin_bottom' => 25,
                'margin_left' => 20,
                'margin_right' => 20,
            ]);
            $header = '<div style="padding: 10px;">'.date("Y-m-d H:i:s").'</div>';
    
            $pdf->SetHeader($header);
    
            $pdf->WriteHTML($html);
            $filename = 'pdf_'.md5(time()). '.pdf';
    
            $pdf->Output('pdf/'. $filename, \Mpdf\Output\Destination::FILE);
    
           return response()->json(["url"=>url("/pdf/{$filename}")]);
    
        }
}
