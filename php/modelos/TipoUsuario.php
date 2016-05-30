<?php 

class TipoUsuario {
	private $cod_TipoUsuario;
	private $tipo;
	
	public function __construct()
	{	
		
	}
	 /* GENERAR GETTERS AND SETTERS */
	public function getTipo()
	{
		return $this->tipo;
	}
	
	public function setTipo($nom)
	{
		$this->tipo = $nom;
	}
	
	public function getTipoUsuario()
	{
		return $this->cod_TipoUsuario;
	}
	
	public function setTipoUsuario($codTipoUsuario)
	{
		$this->cod_TipoUsuario = $codTipoUsuario;
	}
	
	public function jsonSerialize() {
        return [
            'codTipoUsuario' => $this->cod_TipoUsuario,
            'tipo' => $this->tipo
        ];
    }
}