<?php

class MustacheRenderer
{
    private $mustache;
    private $viewFolder;
    private $session;
    private $rol;

    public function __construct($viewFolder, $partialFolder, $session)
    {
        $this->viewFolder = $viewFolder;
        $this->session = $session;
        $this->rol = $this->session->obtenerRolUsuario();

        Mustache_Autoloader::register();
        $this->mustache = new Mustache_Engine(
            array(
                'partials_loader' => new Mustache_Loader_FilesystemLoader($partialFolder)
            ));
    }

    public function render($viewName, $datos = [])
    {
        $contentAsString = file_get_contents($this->viewFolder . $viewName);
        $datos['usuario'] = $this->session->getCurrentUser();
        $datos[$this->rol] = true;
        echo $this->mustache->render($contentAsString, $datos);
    }

    public function renderSession($viewName, $datos = [])
    {
        $contentAsString = file_get_contents($this->viewFolder . $viewName);
        if ($this->session->getCurrentUser() != 0) {
            $datos['usuario'] = $this->session->getCurrentUser();
            $datos[$this->rol] = true;
            echo $this->mustache->render($contentAsString, $datos);
        } else {
            Redirect::doIt("/infonet/login");
        }

    }

    public function renderPdf($viewName, $datos = []) {
        $contentAsString =  file_get_contents($this->viewFolder . $viewName);
        return $this->mustache->render($contentAsString, $datos);
    }

}