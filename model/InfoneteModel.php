<?php

class InfoneteModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getProductos(){
        $sql = "SELECT * FROM producto";
        return $this->database->query($sql);
    }

    public function getProductoPorId($idProducto){
        $sql = "SELECT * FROM producto WHERE id = '$idProducto'";
        return $this->database->query($sql);
    }

    public function getEdicionPorId($idEdicion){
        $sql = "SELECT * FROM edicion WHERE id = '$idEdicion'";
        return $this->database->query($sql);
    }

    public function getEdicionesPorProducto($idProducto){
        $sql = "SELECT * FROM edicion WHERE producto = '$idProducto'";
        return $this->database->query($sql);
    }

    public function getSeccionesPorEdicion($idEdicion){
        $sql = "SELECT s.descripcion, s.id FROM seccion s JOIN edicion_seccion es ON s.id = es.seccion 
                                                    JOIN edicion e ON e.id = es.edicion 
                                                    WHERE e.id = '$idEdicion'";
        return $this->database->query($sql);
    }

    public function getContenidoSuscritoPorEdicionSeccion($usuario, $idSeccion, $idEdicion) {
        $sql = "SELECT c.id, c.titulo, c.subtitulo, c.contenido, c.multimedia, c.latitud, c.longitud, 
                       cm.imagen1, cm.imagen2, cm.imagen3, cm.audio, cm.video, cm.url FROM contenido c 
                                        JOIN contenido_multimedia cm ON c.multimedia = cm.id
                                        JOIN edicion_seccion_noticia esn ON c.id = esn.noticia
                                        JOIN edicion e ON e.id = esn.edicion
                                        JOIN suscripcion s ON s.producto_id = e.producto
                WHERE esn.edicion = '$idEdicion' 
                AND esn.seccion = '$idSeccion'
                AND s.usuario_id = $usuario";
        return $this->database->query($sql);
    }

    public function getContenidoCompradoPorEdicionSeccion($usuario, $idSeccion, $idEdicion) {
        $sql = "SELECT c.id, c.titulo, c.subtitulo, c.contenido, c.multimedia, c.latitud, c.longitud, 
                       cm.imagen1, cm.imagen2, cm.imagen3, cm.audio, cm.video, cm.url FROM contenido c 
                                        JOIN edicion_seccion_noticia esn ON c.id = esn.noticia
                                        JOIN contenido_multimedia cm ON c.multimedia = cm.id
                                        JOIN edicion e ON e.id = esn.edicion
                                        JOIN compra co ON co.edicion_id = e.id
                WHERE esn.edicion = '$idEdicion' 
                AND esn.seccion = '$idSeccion'
                AND co.usuario_id = $usuario";
        return $this->database->query($sql);
    }

    public function getNoticiasPorEdicion($idEdicion) {
        $sql = "SELECT * FROM contenido c JOIN edicion_seccion_noticia esn ON c.id = esn.noticia
                WHERE esn.edicion = '$idEdicion'" ;
        return $this->database->query($sql);
    }

    public function getNombreSeccionPorId($idSeccion){
        $sql = "SELECT * FROM seccion WHERE id = '$idSeccion'";
        return $this->database->query($sql);
    }

    public function getContenidoPorId($idContenido) {
        $sql = "SELECT * FROM contenido WHERE id = '$idContenido' ";
        return $this->database->query($sql);
    }

    public function getMultimediaByContenido($idContenido){
        $sql = "SELECT * FROM contenido_multimedia cm JOIN contenido c ON c.multimedia = cm.id 
                                                      WHERE c.id = '$idContenido'";
    }

    public function suscribirseProducto($idProducto,$usuario) {

        $sql = "INSERT INTO suscripcion(usuario_id, producto_id, fechaVencimiento)
                VALUES($usuario, $idProducto, NOW() + INTERVAL 1 MONTH)";

        return $this->database->execute($sql);
    }

    public function comprarEdicion($idEdicion, $usuario) {

        $sql = "INSERT INTO compra(usuario_id, edicion_id)
                VALUES($usuario, $idEdicion)";

        return $this->database->execute($sql);
    }
}