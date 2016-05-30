<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/Vacaciones.php");

class vacacionesServicio 
{
	private $link;
	private $listaVacaciones;
	private $stmt;
	private $query;
	private $vacaciones;
	
	public function __construct()
	{
	}
	/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LAS VACACIONES*/
	public function visualizarVacaciones()
	{
		$this->link= new Conexion(); 
		$this->listaVacaciones = array();
		$this->query = "call pVacacionesVisualizar()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE JORNADAS
        {
			$this->vacaciones = new Vacaciones();
			$this->vacaciones->setFecha($fila['diaVacaciones']);
			$this->vacaciones->setCodUsuario($fila['cod_usuario']);
			$this->listaVacaciones[] = $this->vacaciones->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaVacaciones; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function agregarVacaciones($nuevaVacaciones, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->vacaciones = $nuevaVacaciones;
		$this->query = "call pVacacionesInsertar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isi", $this->vacaciones->getCodUsuario(), $this->vacaciones->getFecha(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function eliminarVacaciones($nuevaVacaciones, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->vacaciones = $nuevaVacaciones;
		$this->query = "call pVacacionesEliminar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isi", $this->vacaciones->getCodUsuario(), $this->vacaciones->getFecha(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function modificarJornada($nuevaVacaciones, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->vacaciones = $nuevaFestividad;
		$this->query = "call pVacacionesModificar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isi", $this->vacaciones->getCodUsuario(), $this->vacaciones->getFecha(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
		
		/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LAS VACACIONES*/
	public function visualizarVacacionesEnDeterminadaFechaPorUsuario($codUser, $fechaDesde, $fechaHasta)
	{
		$this->link= new Conexion(); 
		$this->listaVacaciones = array();
		$this->query = "call pBuscarDiasVacacionesDeUsuarioEnDeterminadaFecha(?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("iss", $codUser, $fechaDesde, $fechaHasta); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE JORNADAS
        {
			$this->vacaciones = new Vacaciones();
			$this->vacaciones->setFecha($fila['diaVacaciones']);
			$this->vacaciones->setCodUsuario($fila['cod_usuario']);
			$this->listaVacaciones[] = $this->vacaciones->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaVacaciones; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
			/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LAS VACACIONES*/
	public function buscarVacacionesPorUsuarios($codUser)
	{
		$this->link= new Conexion(); 
		$this->listaVacaciones = array();
		$this->query = "call pVacacionesPorUsuario(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("i", $codUser); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE JORNADAS
        {
			$this->vacaciones = new Vacaciones();
			$this->vacaciones->setFecha($fila['diaVacaciones']);
			$this->vacaciones->setCodUsuario($fila['cod_usuario']);
			$this->listaVacaciones[] = $this->vacaciones->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaVacaciones; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
}
?>