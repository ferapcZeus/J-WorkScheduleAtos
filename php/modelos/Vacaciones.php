<?php 

class Vacaciones {
	private $fecha;
	private $cod_usuario;
	
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
	
	public function getCodUsuario()
	{
		return $this->cod_usuario;
	}
	
	public function setCodUsuario($cod_user)
	{
		$this->cod_usuario = $cod_user;
	}
	
	public function jsonSerialize() {
        return [
            'fecha' => $this->fecha,
            'cod_usuario' => $this->cod_usuario
        ];
    }

}