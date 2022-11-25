<?php

class SeccionController
{

    private $seccionModel;
    private $edicionModel;
    private $view;
    private $session;

    public function __construct($seccionModel, $edicionModel, $view, $session)
    {
        $this->edicionModel = $edicionModel;
        $this->seccionModel = $seccionModel;
        $this->view = $view;
        $this->session = $session;

    }

    public function list($data = [])
    {
        $data['secciones'] = $this->seccionModel->getProductos();
        $this->view->render('seccionView.mustache', $data);
    }

    public function subirSeccion()
    {
        $nombre = $_POST["nombreSeccion"] ?? '';
        $edicion = $_POST["edicionSeccion"] ?? '';
        $this->seccionModel->setSeccion($nombre, $edicion);

        Redirect::doIt('/infonet/abm/vistaListaSecciones');
    }

    public function seccionesPorEdicion()
    {
        $id = $_GET['id'] ?? '';
        $comprado = $this->seccionModel->getEdicionComprada($id, $this->session->getIdUsuario());
        if(!empty($comprado)){
            $data['secciones'] = $this->seccionModel->getSeccionesPorProducto($id);
            $data['edicion'] = $this->edicionModel->getEdicionById($id);
            $this->view->renderSession('secciones-por-edicionView.mustache', $data);
        }else{
            Redirect::doIt('/infonet/producto');
        }
    }

    public function borrarSeccion()
    {
        $data['usuario'] = $this->session->getCurrentUser();
        $idSeccion = $_GET["id"] ?? '';
        $this->seccionModel->deleteSeccion($idSeccion);
        Redirect::doIt('/infonet/abm/vistaListaSecciones');
    }


}