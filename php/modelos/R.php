<?php 

class JRealiza
{
	private $fecha;
	private $codJornada;
	private $codUsuario;
	
	public function __construct()
	{	
		
	}
	 /* GENERAR GETTERS AND SETTERS */
	public function getFecha()
	{
		return $this->fecha;
	}
	
	public function setFecha($fechaNueva)
	{
		$this->fecha = $fechaNueva;
	}
	
	public function getCodJornada()
	{
		return $this->codJornada;
	}
	
	public function setCodJornada($codJor)
	{
		$this->codJornada = $codJor;
	}
	
	public function getCodUsuario()
	{
		return $this->codUsuario;
	}
	
	public function setCodUsuario($codUser)
	{
		$this->codUsuario = $codUser;
	}
	
	public function jsonSerialize() {
        return [
            'fecha' => $this->fecha,
            'codJornada' => $this->codJornada,
			'codUsuario' => $this->codUsuario
        ];
    }
}
?>