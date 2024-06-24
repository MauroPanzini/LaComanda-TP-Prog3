<?php
class Pedido
{
    public $id;
    public $cliente;
    public $fecha;
    public $productos;
    public $comentario;
    public $estado;
    public $idPedido;
    public $tipoPedido;
    public $precio;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $fechaActual = new DateTime(date("d-m-Y"));
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (cliente, productos, fecha, comentario, idPedido, precio, estado) VALUES (:cliente, :productos, :fecha, :comentario, :pedido, :precio, :estado)");
        $consulta->bindValue(':cliente', $this->cliente, PDO::PARAM_STR);
        $consulta->bindValue(':productos', $this->productos, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, date_format($fechaActual, 'Y-m-d H:i:s'));
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'pedido');
    }

    public static function obtenerPedido($idPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE idPedido = :idPedido");
        $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public function modificarPedido($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET pedido = :pedido, tipoPedido = :tipoPedido, precio = :precio WHERE id = :id");
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_STR);
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

    public static function obtenerTareas($puesto){
        $objAccesoDatos = AccesoDatos::obtenerInstancia(); // selecciono los campos de pedido, de la tabla pedido, donde el puesto coincida con la comida
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, empleado, clave, puesto FROM pedidos WHERE empleado = :empleado");
        $consulta->execute();
        return $consulta->fetchObject('Pedido');
    }
}