<?php 

class Provincia {
	private $cod_Provincia;
	private $nombre;
	
	public function __construct()
	{	
		
	}
	 /* GENERAR GETTERS AND SETTERS */
	public function getNombre()
	{
		return $this->nombre;
	}
	
	public function setNombre($nom)
	{
		$this->nombre = $nom;
	}
	
	public function getProvincia()
	{
		return $this->cod_Provincia;
	}
	
	public function setProvincia($codProvincia)
	{
		$this->cod_Provincia = $codProvincia;
	}
	
	public function jsonSerialize() {
        return [
            'codProvincia' => $this->cod_Provincia,
            'nombre' => $this->nombre
        ];
    }
}