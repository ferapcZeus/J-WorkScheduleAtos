<?php 

class Usuario {
	private $codUser;
	private $nombre;
	private $apellidos;
	private $das;
	private $password;
	private $grupo;
	private $tipoUsuario;
	private $provincia;
	private $activo;
	
	public function __construct()
	{	
	}
	 /* GENERAR GETTERS AND SETTERS */
	public function getCodUsuario()
	{
		return $this->codUser;
	}
	
	public function setCodUsuario($cod)
	{
		$this->codUser = $cod;
	}
	
	public function getNombre()
	{
		return $this->nombre;
	}
	
	public function setNombre($nom)
	{
		$this->nombre = $nom;
	}
	
	public function getApellidos()
	{
		return $this->apellidos;
	}
	
	public function setApellidos($iApellidos)
	{
		$this->apellidos = $iApellidos;
	}
	
	public function getDas()
	{
		return $this->das;
	}
	
	public function setDas($iDas)
	{
		$this->das = $iDas;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword($iPassword)
	{
		$this->password = $iPassword;
	}
	
	public function getGrupo()
	{
		return $this->grupo;
	}
	
	public function setGrupo($iGrupo)
	{
		$this->grupo = $iGrupo;
	}
	
	public function getTipoUsuario()
	{
		return $this->tipoUsuario;
	}
	
	public function setTipoUsuario($iTipoUsuario)
	{
		$this->tipoUsuario = $iTipoUsuario;
	}	
	
	public function getActivo()
	{
		return $this->activo;
	}
	
	public function setActivo($iActivo)
	{
		$this->activo = $iActivo;
	}
	
	public function getProvincia()
	{
		return $this->provincia;
	}
	
	public function setProvincia($idProvincia)
	{
		$this->provincia = $idProvincia;
	}
	
	public function jsonSerialize() {
        return [
            'cod_usuario' => $this->codUser,
            'nombre' => $this->nombre,
			'apellidos' => $this->apellidos,
			'das' => $this->das,
            'grupo' => $this->grupo,
			'tipoUsuario' => $this->tipoUsuario,
			'provincia' => $this->provincia,
			'activo' => $this->activo
        ];
    }
}