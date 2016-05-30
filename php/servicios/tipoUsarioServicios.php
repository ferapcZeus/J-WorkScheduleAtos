<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/TipoUsuario.php");

class tipoUsuarioServico 
{
	private $link;
	private $listatipoUsuarios;
	private $stmt;
	private $query;
	private $tipoUsuario;
	
	public function __construct()
  {
  }
	/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LAS TIPOUSUARIO */
	public function VisualizartipoUsuarios()
	{
		$this->link= new Conexion(); 
		$this->listatipoUsuarios = array();
		$this->query = "call pTipoUsuariosVisualizar()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE TIPOUSUARIO
        {
			$this->tipoUsuario = new TipoUsuario();
			$this->tipoUsuario->setTipoUsuario($fila['cod_tipoUsuario']);
			$this->tipoUsuario->setTipo($fila['tipo']);
			$this->listatipoUsuarios[] = $this->tipoUsuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listatipoUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function agregartipoUsuario($nombretipoUsuario, $usuarioConectado)
	{
		
		$this->link= new Conexion(); 
		$this->query = "call ptipoUsuarioInsertar (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("si", $nombretipoUsuario, $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function eliminartipoUsuario($idtipoUsuario, $usuarioConectado)
	{
		$this->query = "call ptipoUsuarioEliminar (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ii",$idtipoUsuario, $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function modificartipoUsuario($idtipoUsuario, $nombretipoUsuario, $usuarioConectado)
	{
		$this->query = "call ptipoUsuarioModificar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isi", $idtipoUsuario, $nombretipoUsuario, $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
}
?>