<?php

class EdicionController
{

    private $edicionModel;
    private $productoModel;
    private $view;
    private $session;

    public function __construct($edicionModel, $productoModel, $view, $session)
    {
        $this->edicionModel = $edicionModel;
        $this->view = $view;
        $this->session = $session;
    }

    public function list()
    {
        $data['usuario'] = $this->session->getCurrentUser();
        $data['ediciones'] = $this->edicionModel->getEdiciones(2);
        $this->view->render('edicionView.mustache', $data);
    }

    public function subirEdicion()
    {
        $data['usuario'] = $this->session->getCurrentUser();
        $idProducto = $_POST["productoEdicion"] ?? '';
        $fecha = $_POST["fechaEdicion"] ?? '';
        $evento = $_POST["eventoEdicion"] ?? '';
        $precio = $_POST["precioEdicion"] ?? '0.00';
        $this->edicionModel->setEdicion($idProducto, $fecha, $evento, $precio);

        Redirect::doIt('/infonet/abm');
    }

}
