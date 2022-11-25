<?php

class PdfController
{
    private $view;
    private $session;
    private $pdfmodel;
    private $historialModel;


    public function __construct($PdfModel, $view, $session, $historialModel)
    {
        $this->historialModel = $historialModel;
        $this->view = $view;
        $this->session = $session;
        $this->pdfmodel = $PdfModel;
    }

    public function list()
    {
        $fechas = $_GET['fechas'] ?? "";
        if($fechas === ""){
            $desde = explode("?", $_GET['descarga'])[0] ;
            $hasta = explode("?", $_GET['descarga'])[1];
            $ediciones = $this->historialModel->getEdiciones($this->session->getIdUsuario(), $desde, $hasta);
            $this -> pdfmodel-> getPdf(2, $ediciones, true);
        } else {
            $desde = explode("?", $_GET['fechas'])[0] ;
            $hasta = explode("?", $_GET['fechas'])[1];
            $ediciones = $this->historialModel->getEdiciones($this->session->getIdUsuario(), $desde, $hasta);
            $this -> pdfmodel-> getPdf(2, $ediciones, false);
        }

    }

}
