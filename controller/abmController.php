<?php

class AbmController
{

    private $productoModel;
    private $edicionModel;
    public $seccionModel;
    public $articuloModel;
    private $view;
    private $session;
    private $rol;

    public function __construct($productosModel, $edicionModel, $seccionModel, $articuloModel, $view, $session)
    {
        $this->view = $view;
        $this->productoModel = $productosModel;
        $this->edicionModel = $edicionModel;
        $this->seccionModel = $seccionModel;
        $this->articuloModel = $articuloModel;
        $this->session = $session;
    }

    public function list()
    {
        if ($this->session->getRol() == 1 ||
            $this->session->getRol() == 3) {
            $idUsuario = $this->session->getIdUsuario();
            $data['productos'] = $this->productoModel->getProductos();
            $data['ediciones'] = $this->edicionModel->getEdiciones($idUsuario);
            $this->view->renderSession('abm/abmView.mustache', $data);
        } else {
            Redirect::doIt("/infonet/producto");
        }

    }

    public function vistaAltaArticulos()
    {
        if ($this->session->getRol() == 1 ||
            $this->session->getRol() == 3) {
            $data['ediciones'] = $this->edicionModel->getAllEdiciones();
            $data['secciones'] = $this->seccionModel->getSecciones();
            $data['productos'] = $this->productoModel->getProductos();
            $data['estadoArticulos'] = $this->articuloModel->getEstadosDeArticulos();
            $this->view->renderSession('abm/alta-articulosView.mustache', $data);
        } else {
            Redirect::doIt("/infonet/producto");
        }

    }

    public function vistaAltaSecciones()
    {
        if ($this->session->getRol() == 1 ||
            $this->session->getRol() == 3) {
            $idUsuario = $this->session->getIdUsuario();
            $data['ediciones'] = $this->edicionModel->getEdiciones($idUsuario);
            $data['productos'] = $this->productoModel->getProductos();
            $this->view->renderSession('abm/alta-seccionesView.mustache', $data);
        } else {
            Redirect::doIt("/infonet/producto");
        }
    }

    public function vistaAltaProductos()
    {
        if ($this->session->getRol() == 1 ||
            $this->session->getRol() == 3) {
            $this->view->renderSession('abm/alta-productosView.mustache');
        } else {
            Redirect::doIt("/infonet/producto");
        }

    }

    public function vistaAltaEdiciones()
    {
        if ($this->session->getRol() == 1 ||
            $this->session->getRol() == 3) {
            $data['productos'] = $this->productoModel->getProductos();
            $this->view->renderSession('abm/alta-edicionesView.mustache', $data);
        } else {
            Redirect::doIt("/infonet/producto");
        }

    }

    //Listas
    public function vistaListaArticulos()
    {

        if ($this->session->getRol() == 1) {
            $data['productos'] = $this->productoModel->getProductos();
            $data['estados'] = $this->articuloModel->getEstadosDeArticulos();
            $data['secciones'] = $this->seccionModel->getSecciones();
            $this->view->renderSession('abm/lista-articulosView.mustache', $data);
        } else {
            Redirect::doIt("/infonet/producto");
        }

    }

    public function vistaListaProductos()
    {
        if ($this->session->getRol() == 1) {
            $data['productos'] = $this->productoModel->getProductos();
            $this->view->renderSession('abm/lista-productosView.mustache', $data);
        } else {
            Redirect::doIt("/infonet/producto");
        }
    }

    public function vistaListaSecciones()
    {
        if ($this->session->getRol() == 1) {
            $data['secciones'] = $this->seccionModel->getSecciones();
            $data['productos'] = $this->productoModel->getProductos();
            $this->view->renderSession('abm/lista-seccionesView.mustache', $data);
        }else {
            Redirect::doIt("/infonet/producto");
        }
    }

    public function vistaListaEdiciones()
    {
        if ($this->session->getRol() == 1) {
            $data['productos'] = $this->productoModel->getProductos();
            $this->view->renderSession('abm/lista-edicionesView.mustache', $data);
        }else {
            Redirect::doIt("/infonet/producto");
        }
    }

    public function edicionesPorProducto()
    {
        $id = $_GET['id'] ?? '';
        $data['ediciones'] = $this->productoModel->getEdicionesPorProductoAJax($id);
    }

    public function seccionesPorEdicion()
    {
        $id = $_GET['id'] ?? '';
        $data['secciones'] = $this->seccionModel->getSeccionesPorEdicionAJax($id);
    }

    public function articulosPorSeccion()
    {
        $id = $_GET['id'] ?? '';
        $data['secciones'] = $this->seccionModel->getSeccionesPorEdicionAJax($id);
    }

    public function articulosPorEdicion()
    {
        $id = $_GET['id'] ?? '';
        $data['articulos'] = $this->articuloModel->getArticulosPorEdicionAJax($id);
    }
}