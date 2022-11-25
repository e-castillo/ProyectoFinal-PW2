<?php

class graficosController
{

    private $view;
    private $session;
    private $graficosModel;

    public function __construct($view, $session, $graficosModel)
    {
        $this->view = $view;
        $this->session = $session;
        $this->graficosModel = $graficosModel;
    }

    public function list()
    {
        if ($this->session->getRol() == 1) {
            $data['usuario'] = $this->session->getCurrentUser();
            $data['fechaDesde'] = $_GET['desde'] ?? '';
            $data['fechaHasta'] = $_GET['hasta'] ?? '';
            $tipo = $_GET['tipo'] ?? "";

            if ($tipo === "C") {

                $data['cantidadesC'] = $this->graficosModel->getCantidadesCompras($data['fechaDesde'], $data['fechaHasta']);
                $data['datesC'] = $this->graficosModel->getFechasCompras($data['fechaDesde'], $data['fechaHasta']);
                $this->view->render('graficoComprasView.mustache', $data);

            } else {

                $data['cantidades'] = $this->graficosModel->getCantidadesSuscripcion($data['fechaDesde'], $data['fechaHasta']);
                $data['dates'] = $this->graficosModel->getFechasSuscripcion($data['fechaDesde'], $data['fechaHasta']);
                $this->view->render('graficoSuscripcionView.mustache', $data);
            }
        } else {
            Redirect::doIt("/infonet/producto");
        }
    }

}
