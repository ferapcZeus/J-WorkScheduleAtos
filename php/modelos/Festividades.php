<?php 

class Festividad {
	private $fecha;
	private $festividad;
	
	public function __construct()
	{	
		
	}
	 /* GENERAR GETTERS AND SETTERS */
	public function getFecha()
	{
		return $this->fecha;
	}
	
	public function setFecha($nuevaFecha)
	{
		$this->fecha = $nuevaFecha;
	}
	
	public function getFestividad()
	{
		return $this->festividad;
	}
	
	public function setFestividad($nFestividad)
	{
		$this->festividad = $nFestividad;
	}
	
	public function jsonSerialize() {
        return [
            'fecha' => $this->fecha,
            'festividad' => $this->festividad
        ];
    }

}