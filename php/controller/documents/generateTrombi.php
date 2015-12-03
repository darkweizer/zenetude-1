<?php
    // get the HTML
    $g = $_GET["g"];
    $f = $_GET["f"];
    
    ob_start();
    include(dirname(__FILE__).'/prepareTrombi.php');

    $content = ob_get_clean();

    // convert to PDF
    require_once('../../../vendor/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
//      $html2pdf->pdf->SetProtection(array('print'), 'spipu');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('trombinoscope.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
