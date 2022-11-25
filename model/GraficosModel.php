<?php

class GraficosModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getCantidadesSuscripcion($desde, $hasta)
    {
        $sql = "select count(id_suscripcion) as cantidad from suscripcion ";

        if ($desde != "" && $hasta != "") {
            $sql .= " where fecha>='" . $desde . "' and fecha<='" . $hasta . "'";
        } else if ($desde != "" && $hasta == "") {
            $sql .= " where fecha>='" . $desde . "'";
        } else if ($desde == "" && $hasta != "") {
            $sql .= " where fecha<='" . $hasta . "'";
        } else {

        }

        $sql .= "group by fecha order by fecha";
        return $this->database->query($sql);
    }

    public function getFechasSuscripcion($desde, $hasta)
    {
        $sql = "select fecha from suscripcion ";

        if ($desde != "" && $hasta != "") {
            $sql .= " where fecha>='" . $desde . "' and fecha<='" . $hasta . "'";
        } else if ($desde != "" && $hasta == "") {
            $sql .= " where fecha>='" . $desde . "'";
        } else if ($desde == "" && $hasta != "") {
            $sql .= " where fecha<='" . $hasta . "'";
        } else {

        }

        $sql .= " group by fecha order by fecha";
        return $this->database->query($sql);
    }

    public function getCantidadesCompras($desde, $hasta)
    {
        $sql = "select count(id_compra) as cantidad from compra ";

        if ($desde != "" && $hasta != "") {
            $sql .= " where fecha>='" . $desde . "' and fecha<='" . $hasta . "'";
        } else if ($desde != "" && $hasta == "") {
            $sql .= " where fecha>='" . $desde . "'";
        } else if ($desde == "" && $hasta != "") {
            $sql .= " where fecha<='" . $hasta . "'";
        } else {

        }

        $sql .= "group by fecha order by fecha";
        return $this->database->query($sql);
    }

    public function getFechasCompras($desde, $hasta)
    {
        $sql = "select fecha from compra ";

        if ($desde != "" && $hasta != "") {
            $sql .= " where fecha>='" . $desde . "' and fecha<='" . $hasta . "'";
        } else if ($desde != "" && $hasta == "") {
            $sql .= " where fecha>='" . $desde . "'";
        } else if ($desde == "" && $hasta != "") {
            $sql .= " where fecha<='" . $hasta . "'";
        } else {

        }

        $sql .= " group by fecha order by fecha";
        return $this->database->query($sql);
    }
}