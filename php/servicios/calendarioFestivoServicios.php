<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/CalendarioFestivo.php");

class calendarioFestivoServicio 
{
	private $link;
	private $listaDeFechasFestivas;
	private $stmt;
	private $query;
	private $calendarioFestivo;
	
	public function __construct()
	{ 
	}
	public function VisualizarFechasFestivasPorProvincia($idProvincia)
	{
		$this->link= new Conexion(); 
		$this->listaDeFechasFestivas = array();
		$this->query = "call pListarFestejosPorProvinvia(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt->bind_param("i", $idProvincia); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE TIPOUSUARIO
        {
			$this->calendarioFestivo = new CalendarioFestivo();
			$this->calendarioFestivo->setCodigoCalendarioFestivo($fila['cod_calendario']);
			$this->calendarioFestivo->setFechaFestiva($fila['fechaFestiva']);
			$this->calendarioFestivo->setProvincia($fila['provincia']);
			$this->listaDeFechasFestivas[] = $this->calendarioFestivo->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaDeFechasFestivas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function agregarCalendarioFestivo($fechaFestiva,$idProvincia, $usuarioConectado)
	{
		
		$this->link= new Conexion(); 
		$this->query = "call pCalendarioFestivoInsertar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("sii", $fechaFestiva, $idProvincia,$usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function eliminarCalendarioFestivo($fechaFestiva,$idProvincia, $usuarioConectado)
	{
		$this->query = "call pCalendarioFestivoModificar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("sii",$fechaFestiva, $idProvincia,$usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function modificartipoUsuario($idCalendario,$fechaFestiva,$idProvincia, $usuarioConectado)
	{
		$this->query = "call ptipoUsuarioModificar (?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isii",$idCalendario,$fechaFestiva,$idProvincia, $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}	
	
	public function festividadPorUsuarios($cod_usuario)
	{
		$this->link= new Conexion(); 
		$this->listaDeFechasFestivas = array();
		$this->query = "call pCalFestivoPorProvincias(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("i",$cod_usuario); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE JORNADAS
        {
			$this->calendarioFestivo = new CalendarioFestivo();
			$this->calendarioFestivo->setCodigoCalendarioFestivo($fila['cod_calendario']);
			$this->calendarioFestivo->setFechaFestiva($fila['fechaFestiva']);
			$this->calendarioFestivo->setProvincia($fila['provincia']);
			$this->listaDeFechasFestivas[] = $this->calendarioFestivo->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaDeFechasFestivas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
}
?>