<?php

class PdfModel
{
    private $PdfManager;

    public function __construct($PdfManager)
    {
        $this->PdfManager = $PdfManager;
    }

    public function getPdf($idUsuario, $ediciones, $esDescarga)
    {
        return $this -> PdfManager -> createPdf($idUsuario, $ediciones, $esDescarga);
    }
}