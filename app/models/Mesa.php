<?php

class Mesa
{
    public $id;
    public $capacidad;

    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (capacidad) VALUES (:capacidad)");
        $consulta->bindValue(':capacidad', $this->capacidad, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, capacidad FROM mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public static function obtenerMesa($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, capacidad FROM mesas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }

    public function modificarMesa($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET capacidad = :capacidad WHERE id = :id");
        $consulta->bindValue(':capacidad', $this->capacidad, PDO::PARAM_INT);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
    }

    // public static function borrarMesa($id)
    // {
    //     $objAccesoDato = AccesoDatos::obtenerInstancia();
    //     $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET fechaBaja = :fechaBaja WHERE id = :id");
    //     $fecha = new DateTime(date("d-m-Y"));
    //     $consulta->bindValue(':id', $id, PDO::PARAM_INT);
    //     $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
    //     $consulta->execute();
    // }
}