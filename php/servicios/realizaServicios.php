<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/R.php");

class realizaServicio
{
	private $link;
	private $listarealizas;
	private $stmt;
	private $query;
	private $realiza;
	
	public function __construct()
	{
	}
	
	/* VISUALIZA TODOS LOS REGISTROS DE LA TABLA REALIZA */
	
	public function visualizaRealiza()
	{
		$this->link= new Conexion(); 
		$this->listarealizas = array();
		$this->query = "call pRealizaVisualiza()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE realizaS
        {
			$this->realiza = new JRealiza();
			$this->realiza->setFecha($fila['fecha']);
			$this->realiza->setCodUsuario($fila['cod_user']);
			$this->realiza->setCodJornada($fila['cod_jornada']);
			$this->listarealizas[] = $this->realiza->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listarealizas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
		
	}
	public function agregarRealiza($NuevaRealiza, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->realiza = $NuevaRealiza;
		$this->query = "call pRealizaInsertar (?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("siii", $this->realiza->getFecha(),$this->realiza->getCodJornada(), $this->realiza->getCodUsuario(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function eliminaRealiza($realiza2, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->realiza = $realiza2;
		$this->query = "call pRealizaEliminar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("sii",$this->realiza->getFecha(), $this->realiza->getCodUsuario(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function modificarRealiza($realiza2, $usuarioConectado)
	{
		$this->link= new Conexion();
		$this->realiza = $realiza2;
		$this->query = "call pRealizaModificar (?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("siii", $this->realiza->getFecha(),$this->realiza->getCodJornada(), $this->realiza->getCodUsuario(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function buscarRealiza($realiza2)
	{
		$this->link= new Conexion(); 
		$this->listarealizas = array();
		$this->query = "call pBuscarRealiza(?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("si",$realiza2->getFecha(), $realiza2->getCodUsuario()); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE realizaS
        {
			$this->realiza = new JRealiza();
			$this->realiza->setFecha($fila['fecha']);
			$this->realiza->setCodUsuario($fila['cod_user']);
			$this->realiza->setCodJornada($fila['cod_jornada']);
			$this->listarealizas[] = $this->realiza->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listarealizas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
		
	}
	
	public function realizaPorUsuario($codUser)
	{
		$this->link= new Conexion(); 
		$this->listarealizas = array();
		$this->query = "call pJornadasRealizadasPorUsuario(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("i",$codUser); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE realizaS
        {
			$this->realiza = new JRealiza();
			$this->realiza->setFecha($fila['fecha']);
			$this->realiza->setCodUsuario($fila['cod_user']);
			$this->realiza->setCodJornada($fila['cod_jornada']);
			$this->listarealizas[] = $this->realiza->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listarealizas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
		
	}
	
		public function realizaPorUsuarioEnFechaDeterminada($codUser, $fechaDesde, $fechaHasta)
	{
		$this->link= new Conexion(); 
		$this->listarealizas = array();
		$this->query = "call pBuscarJornadasDeUsuarioEnDeterminadasFechas(?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("iss",$codUser, $fechaDesde, $fechaHasta); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE realizaS
        {
			$this->realiza = new JRealiza();
			$this->realiza->setFecha($fila['fecha']);
			$this->realiza->setCodUsuario($fila['cod_user']);
			$this->realiza->setCodJornada($fila['cod_jornada']);
			$this->listarealizas[] = $this->realiza->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listarealizas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
		
	}
	
	
}
?>