<?php

class pagoController{

    private $pagoModel;
    private $edicionModel;
    private $productoModel;
    private $view;
    private $session;

    public function __construct($pagoModel, $edicionModel, $productoModel, $view, $session){
        $this->pagoModel = $pagoModel;
        $this->edicionModel = $edicionModel;
        $this->productoModel = $productoModel;
        $this->session = $session;
        $this->view = $view;
    }

    public function list($data = []){
        $this->view->render('comprarEdicionView.mustache',$data);
    }


    public function pagoConfirmado($data = []){
        $user = $_GET["usuario"];
        $edicion = $_GET["edicion"] ?? 'vacio';
        $id_producto = $_GET['id_producto'] ?? 0;

        if($edicion != 'vacio'){
            $this->pagoModel->setCompra($user, $edicion);
        }else{
            $this->productoModel->setSuscripcion($id_producto, $user);
        }

        $this->view->render('confirmadoView.mustache', $data);
    }

    public function pagoFallido($data = []){
        $this->view->render('fallidoView.mustache', $data);
    }

    public function comprarEdicion(){

        if ($this->session->getCurrentUser() != 0) {
            $edicion = $_GET["edicion"];
            $user = $_GET["usuario"];

            $ediciones = $this->edicionModel->getEdicionById($edicion);
            require 'vendor/autoload.php';

            MercadoPago\SDK::setAccessToken('TEST-5322929221556591-110901-5614eabea6ba44256133cc0858a47ebb-328479679');

            $preference = new MercadoPago\Preference();

            $item = new MercadoPago\Item();

            $item->title = $ediciones[0]['evento'];
            $item->quantity = 1;
            $item->unit_price = $ediciones[0]['precio'];
            $item->currency_id = "ARS";

            $preference->items = array($item);

            $preference->back_urls = array(
                "success" => "http://localhost/infonet/pago/pagoConfirmado?usuario=$user&edicion=$edicion",
                "failure" => "http://localhost/infonet/pago/pagoFallido",
            );

            $preference->auto_return = "approved";
            $preference->binary_mode = true;

            $preference->save();

            $data['preferencias'] = $preference;

            $this->list($data);
        }else{
            Redirect::doIt('/infonet/login');
        }
    }

    public function suscribirse(){

        if ($this->session->getCurrentUser() != 0) {
            $id_producto = $_GET['id_producto'];
            $id_usuario = $_GET['id_usuario'];

            $producto = $this->productoModel->getProducto($id_producto);

            require 'vendor/autoload.php';

            MercadoPago\SDK::setAccessToken('TEST-5322929221556591-110901-5614eabea6ba44256133cc0858a47ebb-328479679');

            $preference = new MercadoPago\Preference();

            $item = new MercadoPago\Item();

            $item->title = $producto[0]['nombre'];
            $item->quantity = 1;
            $item->unit_price = $producto[0]['precio'];
            $item->currency_id = "ARS";

            $preference->items = array($item);

            $preference->back_urls = array(
                "success" => "http://localhost/infonet/pago/pagoConfirmado?usuario=$id_usuario&id_producto=$id_producto",
                "failure" => "http://localhost/infonet/pago/pagoFallido",
            );

            $preference->auto_return = "approved";
            $preference->binary_mode = true;

            $preference->save();

            $data['preferencias'] = $preference;

            $this->list($data);
        }else{
            Redirect::doIt('/infonet/login');
        }
    }

}