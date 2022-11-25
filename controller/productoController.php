<?php

class ProductoController
{

    private $productoModel;
    private $view;
    private $session;
    private $weather;
    private $rol;

    public function __construct($productosModel, $view, $weather, $session)
    {
        $this->productoModel = $productosModel;
        $this->view = $view;
        $this->session = $session;
        $this->weather = $weather;
    }

    public function list()
    {
        $data['productos'] = $this->productoModel->getProductos();
        $data["clima"] = $this->weather->getDayWeather();
        $data["tempNum"] = $this->weather->getTemperatura();
        $data["t"] = $this->weather->detailsTemperature()->weather;
        $data["semana"] = $this->weather->getWeekWeather();
        $this->view->render('productoView.mustache', $data);
    }

    public function description()
    {
        $idUsuario = $this->session->getIdUsuario();
        $id_producto = $_GET['id'] ?? '';
        $data['usuario'] = $idUsuario;
        $data['producto'] = $this->productoModel->getProducto($id_producto);
        $data['suscripto'] = $this->validarSuscripcion($id_producto, $idUsuario);

        if ($data['suscripto']) {
            $fechaSuscripcion = $this->productoModel->getSuscripcion($id_producto, $idUsuario);
            $resultado = $this->productoModel->getEdicionesNoCompradas($id_producto, $idUsuario);

            if (!empty($resultado)) {
                foreach ($resultado as $edicion) {

                    $diferencia = $this->productoModel->getDiferenciaDeDias($edicion["fecha"], $fechaSuscripcion[0]["fecha"]);
                    if ($diferencia < 0 || $diferencia > 31) {
                        $this->productoModel->setCompra($idUsuario, $edicion["id_edicion"]);
                    }
                }
            }
        }

        $data['edicionProducto'] = $this->productoModel->getEdicionesDeCadaProducto($id_producto, $idUsuario);
        $this->view->render('descriptionView.mustache', $data);

    }

    public function subirProducto()
    {
        $nombre = $_POST["nombreProducto"] ?? '';
        $imagen = $_FILES["imagenProducto"]["name"] ?? '';
        $tipo = $_POST["tipoProducto"] ?? '';
        $precio = $_POST["precioProducto"] ?? '0.00';

        $rutaArchivoTemporal = $_FILES["imagenProducto"]["tmp_name"];
        $rutaArchivoFinal = "public/iso/" . $imagen;
        move_uploaded_file($rutaArchivoTemporal, $rutaArchivoFinal);

        $this->productoModel->setProducto($nombre, $imagen, $tipo, $precio);

        Redirect::doIt('/infonet/abm/vistaListaProductos');
    }

    public function borrarProducto()
    {
        $data['usuario'] = $this->session->getCurrentUser();
        $idPproducto = $_GET["id"] ?? '';
        $this->productoModel->deleteProducto($idPproducto);
        Redirect::doIt('/infonet/abm/vistaListaProductos');
    }

    public function validarSuscripcion($id_producto, $idUsuario)
    {
        $resultado = $this->productoModel->getSuscripcion($id_producto, $idUsuario)[0]["diferencia"] ?? '';

        if (!empty($resultado) || $resultado < 0 || $resultado > 31) {
            return false;
        } else {
            return true;
        }
    }


    public function modificarProducto()
    {
        $data['usuario'] = $this->session->getCurrentUser();
        $idProducto = $_GET["idProducto"] ?? '';
        $nombreProducto = $_POST["modNombreProducto"] ?? '';
        $imagenProducto = $_FILES["modImagenProducto"]["name"] ? $_FILES["modImagenProducto"]["name"] : $_POST["modImagenProductoSave"];
        $tipoProducto = $_POST["modTipoProducto"] ?? '';

        $rutaArchivoTemporal = $_FILES["modImagenProducto"]["tmp_name"];
        $rutaArchivoFinal = "public/iso/" . $imagenProducto;
        move_uploaded_file($rutaArchivoTemporal, $rutaArchivoFinal);

        $this->productoModel->updateProducto($idProducto, $nombreProducto, $imagenProducto, $tipoProducto);
        Redirect::doIt('/infonet/abm/vistaListaProductos/lista-productos');
    }


}
