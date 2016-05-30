<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/Festividades.php");

class festividadServicio 
{
	private $link;
	private $listaFestividades;
	private $stmt;
	private $query;
	private $festividad;
	
	public function __construct()
	{
	}
	/* DEVUELVE UNA MATRIZ CON LOS DATOS DE LAS FESTIVIDADES*/
	public function visualizarFestividad()
	{
		$this->link= new Conexion(); 
		$this->listaFestividades = array();
		$this->query = "call pFestividadesVisualizar()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE JORNADAS
        {
			$this->festividad = new Festividad();
			$this->festividad->setFecha($fila['fechaFestiva']);
			$this->festividad->setFestividad($fila['festividad']);
			$this->listaFestividades[] = $this->festividad->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaFestividades; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function agregarFestividad($nuevaFestividad, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->festividad = $nuevaFestividad;
		$this->query = "call pFestividadesInsertar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ssi", $this->festividad->getFecha(),$this->festividad->getFestividad(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function eliminarJornada($nuevaFestividad, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->festividad = $nuevaFestividad;
		$this->query = "call pFestividadesEliminar (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("si", $this->festividad->getFecha(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	public function modificarJornada($nuevaFestividad, $usuarioConectado)
	{
		$this->link= new Conexion(); 
		$this->festividad = $nuevaFestividad;
		$this->query = "call pFestividadesModificar (?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ssi", $this->festividad->getFecha(),$this->festividad->getFestividad(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	
}
?>