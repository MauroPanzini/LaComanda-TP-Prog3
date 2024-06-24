<?php

class Pedido
{
    public $id;
    public $pedido;
    public $tipoPedido;
    public $precio;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (pedido, tipoPedido, precio) VALUES (:pedido, :tipoPedido, :precio)");
        $consulta->bindValue(':pedido', $this->pedido, PDO::PARAM_STR);
        $consulta->bindValue(':tipoPedido', $this->tipoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, pedido, tipoPedido, precio FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'pedido');
    }

    public static function obtenerPedido($pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, pedido, tipoPedido, precio FROM pedidos WHERE pedido = :pedido");
        $consulta->bindValue(':pedido', $pedido, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('pedido');
    }

    public function modificarPedido($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET pedido = :pedido, tipoPedido = :tipoPedido, precio = :precio WHERE id = :id");
        $consulta->bindValue(':pedido', $this->pedido, PDO::PARAM_STR);
        $consulta->bindValue(':tipoPedido', $this->tipoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarPedido($pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $pedido, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }
}