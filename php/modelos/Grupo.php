<?php 

class Grupo {
	private $cod_grupo;
	private $nombre;
	private $coordinador;
	
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
	
	public function getCodGrupo()
	{
		return $this->cod_grupo;
	}
	
	public function setCodGrupo($codGrupo)
	{
		$this->cod_grupo = $codGrupo;
	}
	
	public function getCoordinador()
	{
		return $this->coordinador;
	}
	
	public function setCoordinador($iCoordinador)
	{
		$this->coordinador = $iCoordinador;
	}
	
	public function jsonSerialize() {
        return [
            'codGrupo' => $this->cod_grupo,
            'nombre' => $this->nombre,
			'coordinador' => $this->coordinador
        ];
    }

}