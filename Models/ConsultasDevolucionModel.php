<?php

class ConsultaDevolucionModel {
    private $archivoDevoluciones;
    private $archivoCupones;

    public function __construct() {
        $this->archivoDevoluciones = '../Views/devoluciones.json'; 
        $this->archivoCupones = '../Views/cupones.json'; 
    }

    public function obtenerDevoluciones(){
        if (!file_exists($this->archivoDevoluciones)){
            return [];
        }

        return json_decode(file_get_contents($this->archivoDevoluciones), true);
    }
    public function listarCupones() {
        if (!file_exists($this->archivoCupones)) {
            return ['error' => 'El archivo de cupones no existe.'];
        }

        $cupones = json_decode(file_get_contents($this->archivoCupones), true);
        return $cupones;
    }
    public function obtenerCuponesConDevoluciones() {
        if (!file_exists($this->archivoCupones)) {
            return ['error' => 'El archivo de cupones no existe.'];
        }

        if (!file_exists($this->archivoDevoluciones)) {
            return ['error' => 'El archivo de devoluciones no existe.'];
        }

        $cupones = json_decode(file_get_contents($this->archivoCupones), true);
        $devoluciones = json_decode(file_get_contents($this->archivoDevoluciones), true);
        
        $resultado = [];
        
        foreach ($cupones as $cupon) {
            $devolucion = $this->obtenerDevolucionPorId($devoluciones, $cupon['devolucion_id']);
            $resultado[] = [
                'cupon' => $cupon,
                'devolucion' => $devolucion
            ];
        }

        return $resultado;
    }

    private function obtenerDevolucionPorId($devoluciones, $devolucionId) {
        foreach ($devoluciones as $devolucion) {
            if ($devolucion['numeroPedido'] === (string)$devolucionId) {
                return $devolucion; 
            }
        }
        return null; 
    }
}