<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../modelos/Usuario.php");

class usuarioServicio 
{
	private $link;
	private $listaUsuarios;
	private $stmt;
	private $query;
	private $usuario;

	public function __construct()
	{ 
	}
	// VISUALIZAR TODOS LOS USUARIOS
	public function visualizarUsuarios()
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pUsuariosVisualizar()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	/* COMPRUEBA EL REGISTRO POR SU DAS(ÚNICA) Y PASSWORD */
	public function comprobrarUsuario($myusername, $mypassword)
	{
		$this->link= new Conexion();
		$this->query = "select fComprobarUsuario(?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ss", $myusername, $mypassword); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->bind_result($resultado); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		$this->stmt->fetch(); // ALMACENA LOS DATOS DEVUELTO EN LOS PARAMETROS AGREGADOS
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $resultado; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
		/* COMPRUEBA SI EL REGISTRO ES COORDINADOR O NO */
	public function comprobarCoordinador($myusername)
	{
		$this->link= new Conexion();
		$this->query = "select fComprobarCoordinador(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $myusername); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->bind_result($resultado); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		$this->stmt->fetch(); // ALMACENA LOS DATOS DEVUELTO EN LOS PARAMETROS AGREGADOS
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $resultado; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
		/* COMPRUEBA SI EL REGISTRO ES ADMINISTRADOR O NO */
	public function comprobarAdministrador($myusername)
	{
		$this->link= new Conexion();
		$this->query = "select fComprobarAdministrador(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $myusername); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->bind_result($resultado); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		$this->stmt->fetch(); // ALMACENA LOS DATOS DEVUELTO EN LOS PARAMETROS AGREGADOS
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $resultado; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	/* VISUALIZA TODOS LOS USUARIOS DE UN MISMO GRUPO */
	public function visualizarUsuariosPorGrupo ($idGrupo)
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pListarUsuariosPorGrupo(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("i", $idGrupo); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	/* AGREGA UN RESGRISTRO NUEVO DE USUARIO */
	public function agregarUsuario($NuevoUsuario,$usuarioConectado)
	{
		$this->link= new Conexion();
		$this->usuario = $NuevoUsuario;
		$this->query = "call pUsuariosInsertar (?,?,?,?,?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("sssssiii",
			$this->usuario->getNombre(),
			$this->usuario->getApellidos(),
			$this->usuario->getDas(),
			$this->usuario->getPassword(),
			$this->usuario->getGrupo(),
			$this->usuario->getTipoUsuario(),
			$this->usuario->getProvincia(),
			$usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	/* ESTA FUNCIÓN ELIMINA AL USUARIO DE LA APLICACIÓN MANTENIENDO SUS DATOS EN LA BASE DE DATOS */
	public function desactivarUsuario($idUsuario, $usuarioConectado)
	{
		$this->link= new Conexion();
		$this->query = "call pUsuariosDarBaja (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ii",$idUsuario, $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	/* MODIFICA AL USUARIO */
	public function modificarUsuario($usuarioModificado,$usuarioConectado)
	{
		$this->link= new Conexion();
		$this->query = "call pUsuariosModificar(?,?,?,?,?,?,?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("isssiiii",
		$usuarioModificado->getCodUsuario(),
		$usuarioModificado->getNombre(),
		$usuarioModificado->getApellidos(),
		$usuarioModificado->getDas(),
		$usuarioModificado->getGrupo(),
		$usuarioModificado->getTipoUsuario(),
		$usuarioModificado->getProvincia(),
		$usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	/* HABILITA AL USUARIO PARA SU APARICIÓN EN LA APLICACIÓN NUEVAMENTE */
	public function activarUsuario($idUsuario, $usuarioConectado)
	{
		$this->link= new Conexion();
		$this->query = "call pUsuariosActivar (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ii", $idUsuario, $usuarioConectado ); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	/* ESTA FUNCIÓN ELIMINA AL USUARIO COMPLETAMENTE DE LA BASE DE DATOS */
	public function eliminarUsuario($idUsuario, $usuarioConectado)
	{
		$this->link= new Conexion();
		$this->query = "call pUsuarioEliminar (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ii",$idUsuario, $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
	 /* BUSCAR UN USUARIO POR SU DAS */
	public function buscarUsuarioPorDas ($das)
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pUsuariosBuscarDas(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $das); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	/* BUSCAR LOS USUARIOS POR DAS */
	public function buscarUsuariosDasEmpiezaPor ($das)
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pUsersPorDas(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $das); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
		public function buscarUsuarioPorCodigo ($codUsuario)
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pUsuariosBuscarCodigo(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $codUsuario); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function cogerGrupoDeUnUsuario($das)
	{
		$this->link= new Conexion();
		$idGrupo = "";
		$this->query = "call pUsuariosBuscarGrupoDeUnUsuario(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $das); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$idGrupo = $fila['grupo']; // RECOGERMOS EL RESULTADO EN UNA VARIABLE
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $idGrupo; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	/* VISUALIZAR USUARIOS ADMINISTRADORES */
	public function visualizarUsuariosAdministradores()
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pListarAdministradores()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
		/* VISUALIZAR USUARIOS ESTANDAR */
	public function visualizarUsuariosEstandar()
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pListarUsuariosEstandar()"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}
	
	public function visualizarUsuarioPorNombre($nombre)
	{
		$this->link= new Conexion();
		$this->listaUsuarios = array();
		$this->query = "call pUsuariosBuscarNombre(?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("s", $nombre); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$resultado = $this->stmt->get_result(); // RECOGEMOS EL RESULTADO EN UNA VARIABLE
		while ($fila = $resultado->fetch_assoc()) // RECORREMOS EL ARRAY DE USUARIOS
        {
			$this->usuario = new Usuario();
			$this->usuario->setCodUsuario($fila['cod_user']); // AÑADIMOS LOS CODIGOS DE LOS USUARIOS
			$this->usuario->setNombre($fila['nombre']); // AÑADIMOS LOS NOMBRE DE LOS USUARIOS
			$this->usuario->setApellidos($fila['apellidos']); // AÑADIMOS LOS APELLIDOS DE LOS USUARIOS
			$this->usuario->setDas($fila['das']); // AÑADIMOS LOS DAS DE LOS USUARIOS
			$this->usuario->setTipoUsuario($fila['tipoUsuario']);// AÑADIMOS LOS TIPOS DE LOS USUARIOS
			$this->usuario->setGrupo($fila['grupo']); // AÑADIMOS LOS GRUPOS DE LOS USUARIOS
			$this->usuario->setProvincia($fila['provincia']); // AÑADIMOS LAS PROVINCIAS DE LOS USUARIOS
			$this->usuario->setActivo($fila['activo']); // AÑADIMOS LOS ESTADOS DE LOS USUARIOS
			
			$this->listaUsuarios[] = $this->usuario->jsonSerialize();
        }
		$resultado->free();
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
		return $this->listaUsuarios; // DEVOLVEMOS EL RESULTADO DE LA FUNCIÓN / DEL PROCEDIMIENTO
	}	
	
	public function expulsarDelGrupo($user, $usuarioConectado)
	{
		$this->link= new Conexion();
		$this->usuario = $user;
		$this->query = "call pExpulsarUsuario (?,?)"; // AGREGAMOS LA SENTENCIA DE LA FUNCIÓN/ DEL PROCEDIMIENTO
		$this->stmt = $this->link->getConexion()->prepare($this->query); // PREPARAMOS LA SENTENCIA ALMACENADA
		$this->stmt->bind_param("ii",$this->usuario->getCodUsuario(), $usuarioConectado); // AGREGAMOS LOS PARAMETROS PREPARADOS NECESARIOS
		$this->stmt->execute(); // EJECUTAMOS EL PROCEDIMIENTO
		$this->stmt->close(); // CERRAMOS LA SENTENCIA PREPARADA (TAMBIEN CIERRA LA CONEXIÓN)
		$this->link->desconectar(); // CIERRA LA CONEXIÓN DEL OBJETO CONEXION
	}
	
}
?>