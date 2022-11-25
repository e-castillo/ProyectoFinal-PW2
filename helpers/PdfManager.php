<?php

require_once 'dependencies/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class PdfManager
{
    public function __construct()
    {

    }

    public function createPdf($usuarioId, $ediciones, $esDescarga)
    {
        $html = "<span><span class='info'>Info</span><span class='net'>net</span></span>
<h4 class='title-table'>Mis Ediciones</h4>";
        $html .= "<table border='1' width='100%' style='border-collapse: collapse';>
                    <tr>
                        <th>Id Edición</th>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Edicion</th>
                        
                    </tr>";

        for ($i = 0; $i < sizeof($ediciones); $i++) {
            $html .=
                "<tr>
                        <td>" . $ediciones[$i]['id_edicion'] . "</td>
                        <td>" . $ediciones[$i]['fecha'] . "</td>
                        <td>" . $ediciones[$i]['nombre'] . "</td>
                        <td>" . $ediciones[$i]['evento'] . "</td>
                    </tr>";
        }

        $html .= "</table>";
        $html .= "
<style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&family=Roboto:wght@100;300;400;500;700;900&display=swap');
                    .title-table{
                    font-size: 45px;
                    }
                    
                    .info{
                    background-color: green;
                    color: #fff;
                    padding: 5px 5px; 
                    border-radius: 5px;
                    margin-right: 2px;
                    }
                    table, .info, .net, .title-table{
                    font-family: 'Poppins', sans-serif;
                    }
                    
                    .info, .net{
                    font-size: 30px; 
                    }
                    .title-table{
                    font-size: 30px;
                    }
                    
                    td, th{
                    padding: 10px 0; 
                    text-align: center; 
                    }
                    
                    th:nth-child(1){
                    background-color: red;
                    color: #ffff;
                    }
                    th:nth-child(2){
                    background-color: green;
                    color: #ffff;
                    }
                    th:nth-child(3){
                    background-color: black;
                    color: #ffff;
                    }
                    th:nth-child(4){
                    background-color: blue;
                    color: #ffff;
                    }
                    </style>";


        $filename = "MisEdiciones";

        //try {

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        if ($esDescarga === true) {
            $dompdf->stream($filename, array("Attachment" => 1));
        } else {
            $dompdf->stream($filename, array("Attachment" => 0));
        }

        //}catch (Exception $e){var_dump($e->getMessage());}
        //$dompdf->stream($filename);


    }

}