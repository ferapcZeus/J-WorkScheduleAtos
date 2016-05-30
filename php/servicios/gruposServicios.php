<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/Grupo.php");

class grupoServicio 
{
	private $link;
	private $listaGrupos;
	private $stmt;
	private $query;
	private $grupo;
	
	public function __construct()
	{
	}
	/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LOS GRUPOS */
	public function visualizarGrupos()
	{
		$this->link= new Conexion(); 
		$this->listaGrupos = array();
		$this->query = "call pGruposVisualizar()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->grupo = new Grupo();
			$this->grupo->setCodGrupo($fila['cod_grupo']);
			$this->grupo->setNombre($fila['grupo']);
			$this->grupo->setCoordinador($fila['coordinador']);
			$this->listaGrupos[] = $this->grupo->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaGrupos; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function seleccionarGrupo($cod_grupo)
	{
		$this->link= new Conexion(); 
		$this->listaGrupos = array();
		$this->query = "call pBuscarUnGrupo(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("i", $cod_grupo); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->grupo = new Grupo();
			$this->grupo->setCodGrupo($fila['cod_grupo']);
			$this->grupo->setNombre($fila['grupo']);
			$this->grupo->setCoordinador($fila['coordinador']);
			$this->listaGrupos[] = $this->grupo->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaGrupos; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function agregarGrupo($NuevoGrupo, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->grupo = $NuevoGrupo;
		$this->query = "call pGruposInsertar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("sii", $this->grupo->getNombre(), $this->grupo->getCoordinador(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function eliminarGrupo($idGrupo, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->query = "call pGruposEliminar (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ii",$idGrupo, $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function modificarGrupo($NuevoGrupo, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->grupo = $NuevoGrupo;
		$this->query = "call pGruposModificar (?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isii",  $this->grupo->getCodGrupo(), $this->grupo->getNombre(), $this->grupo->getCoordinador(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	public function grupoDeUsuarioActual($dasUsuario)
	{
		$this->link= new Conexion(); 
		$this->listaGrupos = array();
		$this->query = "call pBuscarGrupoDeUsuarioActual(?);"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $dasUsuario); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->grupo = new Grupo();
			$this->grupo->setCodGrupo($fila['cod_grupo']);
			$this->grupo->setNombre($fila['grupo']);
			$this->grupo->setCoordinador($fila['coordinador']);
			$this->listaGrupos[] = $this->grupo->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaGrupos; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
		/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LOS GRUPOS */
	public function buscarGruposPorNombre($nombreGrupo)
	{
		$this->link= new Conexion(); 
		$this->listaGrupos = array();
		$this->query = "call pBuscarUnGruposPorNombre(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $nombreGrupo); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->grupo = new Grupo();
			$this->grupo->setCodGrupo($fila['cod_grupo']);
			$this->grupo->setNombre($fila['grupo']);
			$this->grupo->setCoordinador($fila['coordinador']);
			$this->listaGrupos[] = $this->grupo->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaGrupos; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
}
?>