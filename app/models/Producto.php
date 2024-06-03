<?php

class Producto
{
    public $id;
    public $producto;
    public $precio;

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (producto, precio) VALUES (:producto, :precio)");
        $consulta->bindValue(':producto', $this->producto, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, producto, precio FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'producto');
    }

    public static function obtenerProducto($producto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, producto, precio FROM productos WHERE producto = :producto");
        $consulta->bindValue(':producto', $producto, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('producto');
    }

    public function modificarProducto($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET producto = :producto, precio = :precio WHERE id = :id");
        $consulta->bindValue(':producto', $this->producto, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarProducto($producto)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $producto, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }
}