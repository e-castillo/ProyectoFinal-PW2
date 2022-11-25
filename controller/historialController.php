<?php

class HistorialController
{

    private $historialModel;
    private $view;
    private $session;

    public function __construct($HistorialModel, $view, $session)
    {
        $this->historialModel = $HistorialModel;
        $this->view = $view;
        $this->session = $session;
    }

    public function list()
    {
        if ($this->session->getRol() == 2) {
            $data['usuario'] = $this->session->getCurrentUser();
            $data['ediciones'] = $this->historialModel->getEdiciones($this->session->getIdUsuario(), $_GET['desde'] ?? '', $_GET['hasta'] ?? '');
            $data['fechaDesde'] = $_GET['desde'] ?? '';
            $data['fechaHasta'] = $_GET['hasta'] ?? '';
            $this->view->render('historialView.mustache', $data);
        }else{
            Redirect::doIt("/infonet/producto");
        }
    }

    // public function description()
    // {
    //     $id = $_GET['id'] ?? '';
    //     $producto['producto'] = $this->productoModel->getProducto($id);
    //     $this->view->render('descriptionView.mustache', $producto);
    // }
}
