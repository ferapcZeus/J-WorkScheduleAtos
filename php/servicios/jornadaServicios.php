<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/Jornada.php");

class jornadaServicio 
{
	private $link;
	private $listajornadas;
	private $stmt;
	private $query;
	private $jornada;
	
	public function __construct()
	{
	}
	/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LAS JORNADAS */
	public function visualizarJornadas()
	{
		$this->link= new Conexion(); 
		$this->listajornadas = array();
		$this->query = "call pJornadasVisualizar()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE JORNADAS
        {
			$this->jornada = new Jornada();
			$this->jornada->setCodJornada($fila['cod_jornada']);
			$this->jornada->setHoraInicio($fila['hora_Inicio']);
			$this->jornada->setHoraFin($fila['hora_Fin']);
			$this->jornada->setColor($fila['color']);
			$this->listajornadas[] = $this->jornada->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listajornadas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function agregarJornada($nuevaJornada, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->jornada = $nuevaJornada;
		$this->query = "call pJornadasInsertar (?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("sssi", $this->jornada->getHoraInicio(), $this->jornada->getHoraFin(),$this->jornada->getColor(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function eliminarJornada($jornada, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->jornada = $jornada;
		$this->query = "call pJornadasEliminar (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ii",$this->jornada->getCodJornada(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function modificarJornada($jornada2, $usuarioConectado)
	{
		$this->link= new Conexion();
		$this->jornada = $jornada2;
		$this->query = "call pJornadasModificar (?,?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isssi",  $this->jornada->getCodjornada(), $this->jornada->getHoraInicio(), $this->jornada->getHoraFin(),$this->jornada->getColor(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function jornadaPorID($id)
	{
		$this->link= new Conexion(); 
		$this->listajornadas = array();
		$this->query = "call pJornadaPorId(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("i",$id); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE JORNADAS
        {
			$this->jornada = new Jornada();
			$this->jornada->setCodJornada($fila['cod_jornada']);
			$this->jornada->setHoraInicio($fila['hora_Inicio']);
			$this->jornada->setHoraFin($fila['hora_Fin']);
			$this->jornada->setColor($fila['color']);
			$this->listajornadas[] = $this->jornada->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listajornadas; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	
}
?>