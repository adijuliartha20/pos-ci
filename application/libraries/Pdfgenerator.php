<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*require_once("./dompdf/dompdf/autoload.inc.php");
use Dompdf\Dompdf;*/



class Pdfgenerator {

  public function generate($html, $style='', $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait"){
    require_once "dompdf/dompdf_config.inc.php";    
    
    $dompdf = new DOMPDF();
    $dompdf->set_paper($paper, $orientation);

    $content = '<!DOCTYPE html>
                <html>
                    <head>'.$style.'</head>
                    <body>'.$html.'</body>
                </html>';



    $dompdf->load_html($content);
    $dompdf->render();   
    $output = $dompdf->output();
    $file_path = FCPATH.'uploads/report/'.$filename.".pdf";
    $return_link = base_url().'uploads/report/'.$filename.".pdf";

    if(file_exists($file_path))unlink($file_path);
    file_put_contents($file_path, $output); 
    return $return_link;
  }



  public function generate_view($html, $style='', $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait"){
    require_once "dompdf/dompdf_config.inc.php";    
    
    $dompdf = new DOMPDF();
    $dompdf->set_paper($paper, $orientation);

    $content = '<!DOCTYPE html>
                <html>
                    <head>'.$style.'</head>
                    <body>'.$html.'</body>
                </html>';



    $dompdf->load_html($content);
    $dompdf->render();   
    $output = $dompdf->output();
    $file_path = FCPATH.'uploads/report/'.$filename.".pdf";
    $return_link = base_url().'uploads/report/'.$filename.".pdf";

    if(file_exists($file_path))unlink($file_path);
    file_put_contents($file_path, $output);

    redirect($return_link);
    
    //$dompdf->stream();

    /*return $return_link;*/
  }


}