--  EDUARDO PÉREZ GUERERERO
-- **************** CREACION DE TABLAS *******************
delimiter ;

--  TIPO USUARIO (TABLA)
CREATE TABLE tipo_usuario 
(cod_tipoUsuario int AUTO_INCREMENT,
tipo varchar(20) not null,
CONSTRAINT pk_tipo_usuario PRIMARY KEY (cod_tipoUsuario));

--  PROVINCIAS (TABLA)
CREATE TABLE provincias 
(cod_provincia int AUTO_INCREMENT,
 provincia varchar(30) not null,
 CONSTRAINT pk_cod_provincia PRIMARY KEY (cod_provincia));
 
 --  JORNADAS (TABLA)
CREATE TABLE jornadas 
(cod_jornada int AUTO_INCREMENT,
 hora_Inicio time not null,
 hora_Fin time not null,
 color varchar(15) not null,
 CONSTRAINT pk_jornadas PRIMARY KEY (cod_jornada));

--  USUARIOS (TABLA)
CREATE TABLE usuarios 
(cod_user int AUTO_INCREMENT,
 nombre varchar(30) not null,
 apellidos varchar(50) not null,
 das varchar(30) not null unique,
 password varchar(128) not null,
 grupo int not null,
 tipoUsuario int not null,
 provincia int not null,
 activo boolean, 
 CONSTRAINT pk_cod_user PRIMARY KEY (cod_user));

-- FESTIVIDADES (TABLA)
CREATE TABLE festividades
(fechaFestiva date not null,
festividad varchar(30),
CONSTRAINT pk_festividad PRIMARY KEY (fechaFestiva));

--  CALENDARIO FESTIVO (TABLA)
CREATE TABLE calendarioFestivo 
(cod_calendario int AUTO_INCREMENT,
 fechaFestiva date not null,
 provincia int not null,
 CONSTRAINT pk_calendarioFestivo PRIMARY KEY (cod_calendario));
 
--  GRUPOS(TABLA) 
CREATE TABLE grupos
(cod_grupo int AUTO_INCREMENT,
 grupo varchar(30),
 coordinador int,
 CONSTRAINT pk_cod_grupo PRIMARY KEY (cod_grupo));
 
 --  REALIZA (TABLA)
 CREATE TABLE realiza 
 (fecha date not null,
  cod_user int not null,
  cod_jornada int not null,
  CONSTRAINT pk_realiza PRIMARY KEY (fecha, cod_user));

--  VACACIONES (TABLA)
CREATE TABLE vacaciones
(cod_usuario int not null,
 diaVacaciones date not null,
 CONSTRAINT pk_vacacionesUsuarios PRIMARY KEY (cod_usuario, diaVacaciones));

--  REGISTRO DE ACTIVIAD (TABLA)
CREATE TABLE registro_accionRealizada
(cod_registro int AUTO_INCREMENT,
 cod_usuario int not null,
 fecha datetime not null,
 accionRealizada varchar(255) not null,
 CONSTRAINT pk_registro_accionRealizada PRIMARY KEY (cod_registro));
 
--   ***************************** CONSTRAINTS *****************************
 
 --  TABLA USUARIO
ALTER TABLE usuarios 
 ADD CONSTRAINT fk_tipoUsuario_usuarios FOREIGN KEY (tipoUsuario) REFERENCES tipo_usuario(cod_tipoUsuario);
ALTER TABLE usuarios 
 ADD CONSTRAINT fk_grupos_usuarios FOREIGN KEY (grupo) REFERENCES grupos(cod_grupo);
ALTER TABLE usuarios
 ADD CONSTRAINT fk_calendarioFestivo_usuarios FOREIGN KEY (provincia) REFERENCES provincias(cod_provincia);
 
 --  TABLA GRUPOS
 ALTER TABLE grupos
 ADD CONSTRAINT fk_usuarios_grupos FOREIGN KEY (coordinador) REFERENCES usuarios(cod_user);
 
 --  TABLA REGISTRO DE ACTIVIDAD
 ALTER TABLE registro_accionRealizada
 ADD CONSTRAINT fk_usuarios_registro_accionRealizada FOREIGN KEY (cod_usuario) REFERENCES usuarios (cod_user);
 
 --  TABLA MERECE
 ALTER TABLE vacaciones
 ADD CONSTRAINT fk_usuarios_vacaciones_Usuarios FOREIGN KEY (cod_usuario) REFERENCES usuarios(cod_user);
 
 --  TABLA REALIZA
 ALTER TABLE realiza
  ADD CONSTRAINT fk_usuarios_realiza FOREIGN KEY (cod_user) REFERENCES usuarios (cod_user);
  ALTER TABLE realiza
  ADD CONSTRAINT fk_jornadas_realiza FOREIGN KEY (cod_jornada) REFERENCES jornadas (cod_jornada);
  
 --  TABLA CALENDARIO FESTIVO
 ALTER TABLE calendarioFestivo
 ADD CONSTRAINT fk_provincias_calendarioFestivo FOREIGN KEY (provincia) REFERENCES provincias(cod_provincia);
 ALTER TABLE calendarioFestivo
 ADD CONSTRAINT fk_festividades_calendarioFestivo FOREIGN KEY (fechaFestiva) REFERENCES festividades(fechaFestiva);


/* *************************************************************************************

PONER FUNCIONES Y PROCEDURES PARA TODO

**************************************************************************************** */

--   TABLA USUARIOS

-- VISUALIZAR
delimiter //
 
 CREATE PROCEDURE pUsuariosVisualizar ()
	BEGIN
		select u.cod_user, u.nombre, u.apellidos, u.das, u.password, u.grupo, u.tipoUsuario, u.provincia, u.activo from usuarios as u;
END 
 //
--  ACTIVAR
CREATE PROCEDURE pUsuariosActivar(IN pCodUsuario int, IN usuarioConectado int)
	BEGIN
		update usuarios set activo = true where cod_user = pCodUsuario;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha activado un usuario");
	END
	//
-- AÑADIR
CREATE PROCEDURE pUsuariosInsertar (IN pNombre varchar(30),IN pApellido varchar(50),IN pDas varchar(30),
IN pPassword varchar(128),IN pGrupo int, IN pTipoUsuario int,IN pProvincia int, IN usuarioConectado int)
	BEGIN
		insert into usuarios (nombre, apellidos, das, password, grupo, tipoUsuario, provincia,activo)
		values (pNombre, pApellido, pDas, sha2(pPassword,512), pGrupo, pTipoUsuario, pProvincia, true);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "se ha insertado un usuario");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pUsuariosModificar (IN pCodUsuario int, IN pNombre varchar(30),IN pApellido varchar(50),IN pDas varchar(30),
	IN pGrupo int, IN pTipoUsuario int,IN pProvincia int, IN usuarioConectado int)
	BEGIN
		declare provinciaAux int;
		set provinciaAux = (select provincia from usuarios where cod_user = pCodUsuario);
		IF (provinciaAux <> pProvincia)
			THEN				
				update usuarios set nombre = pNombre,
				apellidos = pApellido,
				das = pDas,
				grupo =pGrupo, 
				tipoUsuario =pTipoUsuario,
				provincia =pProvincia
				where cod_user = pCodUsuario;
				
				delete from realiza
				where fecha in (select fechaFestiva
								from calendarioFestivo
								where provincia = (select provincia 
													from usuarios
													where cod_user = pCodUsuario))
				and cod_user = pCodUsuario;
				
			ELSE
				update usuarios set nombre = pNombre,
				apellidos = pApellido,
				das = pDas,
				grupo =pGrupo, 
				tipoUsuario =pTipoUsuario
				where cod_user = pCodUsuario;
		END IF;
		

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "se ha modificado un usuario");
END 
 //
-- DAR BAJA
CREATE PROCEDURE pUsuariosDarBaja (IN pCodUsuario int, IN usuarioConectado int)
	BEGIN
		update usuarios set activo = false where cod_user = pCodUsuario;

		insert into registro_accionRealizada (usuario, fecha, accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha desactivado un usuario");
END 
 //
-- ELIMINAR
CREATE PROCEDURE pUsuariosEliminar (IN pCodUsuario int, IN usuarioConectado int)
	BEGIN
		delete from usuarios where cod_user = pCodUsuario;

		insert into registro_accionRealizada (usuario, fecha, accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado un usuario");
END 
 //
--   TABLA GRUPOS

-- VISUALIZAR
CREATE PROCEDURE pGruposVisualizar ()
	BEGIN
		select g.cod_grupo, g.grupo, g.coordinador from grupos as g;
END 
 //
-- AÑADIR
CREATE PROCEDURE pGruposInsertar (IN nombreGrupo varchar(30), IN pCoordinador int, IN usuarioConectado int)
	BEGIN
		insert into grupos (grupo, coordinador)
		values (nombreGrupo, pCoordinador);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "se ha insertado un grupo");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pGruposModificar (IN pCodGrupo int, IN nombreGrupo varchar(30), IN pCoordinador int, IN usuarioConectado int)
	BEGIN
		update grupos set grupo = nombreGrupo,
		coordinador = pCoordinador
		where cod_grupo = pCodGrupo;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado un grupo");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pGruposEliminar(IN pCodGrupo int, IN usuarioConectado int)
	BEGIN
		delete from grupos where cod_grupo = pCodGrupo;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado un grupo");
END 
 //
--   TABLA TIPO USUARIO
-- VISUALIZAR
CREATE PROCEDURE pTipoUsuariosVisualizar ()
	BEGIN
		select tu.cod_tipoUsuario, tu.tipo from tipo_usuario as tu;
END 
 //
-- AÑADIR
CREATE PROCEDURE pTipoUsuariosInsertar (IN pTipo varchar(30), IN usuarioConectado int)
	BEGIN
		insert into tipo_usuario (tipo)
		values (pTipo);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "se ha insertado un tipo de usuario");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pTipoUsuariosModificar (IN pCodTipoUsuario int, IN pTipo varchar(30), IN usuarioConectado int)
	BEGIN
		update tipo_usuario set tipo = pTipo
		where cod_tipoUsuario = pCodTipoUsuario;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado un tipo de usuario");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pTipoUsuariosEliminar(IN pCodTipoUsuario int, IN usuarioConectado int)
	BEGIN
		delete from tipo_usuario 
		where cod_tipoUsuario = pCodTipoUsuario;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado un tipo de usuario");
END 
 //
--   TABLA PROVINCIAS
-- VISUALIZAR
CREATE PROCEDURE pProvinciasVisualizar()
	BEGIN
		select p.cod_provincia, p.provincia from provincias as p;
END 
 //
-- AÑADIR
CREATE PROCEDURE pProvinciasInsertar(IN pProvincia varchar(30), IN usuarioConectado int)
	BEGIN
		insert into provincias (provincia)
		values (pProvincia);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha insertado una provincia");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pProvinciasModificar(IN pCodProvincia int, IN pProvincia varchar(30), IN usuarioConectado int)
	BEGIN
		update provincias set provincia = pProvincia
		where cod_provincia = pCodProvincia;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado una provincia");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pProvinviasEliminar(IN pCodTipoUsuario int, IN usuarioConectado int)
	BEGIN
		delete from tipo_usuario 
		where cod_tipoUsuario = pCodTipoUsuario;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado una provincia");
END 
 //
--   TABLA CALENDARIO FESTIVO
-- VISUALIZAR
CREATE PROCEDURE pCalendarioFestivoVisualizar()
	BEGIN
		select * from calendarioFestivo;
END 
 //
-- AÑADIR
CREATE PROCEDURE pCalendarioFestivoInsertar(IN pFecha date, IN pProvincia int, IN usuarioConectado int)
	BEGIN
		insert into calendarioFestivo (fechaFestiva, provincia)
		values (pFecha,pProvincia);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha insertado un calendario festivo");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pCalendarioFestivoModificar(IN pCodCalendario int,IN pFecha int, IN pProvincia int, IN usuarioConectado int)
	BEGIN
		update calendarioFestivo set provincia = pProvincia, provincia = pProvincia
		where cod_calendarioFestivo = pCodCalendario;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado un calendario festivo");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pCalendarioFestivoEliminar(IN pFecha int,IN pIdPronvicia int, IN usuarioConectado int)
	BEGIN
		delete from calendarioFestivo
		where fecha = pFecha and provincia = pIdPronvicia;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado un calendario festivo");
END 
 //
 --   TABLA FESTIVIDADES
-- VISUALIZAR
CREATE PROCEDURE pFestividadesVisualizar()
	BEGIN
		select * from festividades;
END 
 //
-- AÑADIR
CREATE PROCEDURE pFestividadesInsertar(IN pFecha date,IN pFestividad varchar(30), IN usuarioConectado int)
	BEGIN
		insert into festividades (fechaFestiva, festividad)
		values (pFecha,pFestividad);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha insertado un calendario festivo");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pFestividadesModificar(IN pFecha int, IN pFestividad varchar(30), IN usuarioConectado int)
	BEGIN
		update festividades set festividad = pFestividad
		where fechaFestiva = pFecha;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado un calendario festivo");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pFestividadesEliminar(IN pFecha int, IN usuarioConectado int)
	BEGIN
		delete from festividades
		where fechaFestiva = pFecha;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado un calendario festivo");
END 
 // 
--   TABLA CALENDARIO VACACIONES
-- VISUALIZAR
CREATE PROCEDURE pVacacionesVisualizar()
	BEGIN
		select * from vacaciones;
END
//

-- AÑADIR
CREATE PROCEDURE pVacacionesInsertar(IN pCodUser int, IN pDiaDeVacacion date, IN usuarioConectado int)
	BEGIN
		insert into vacaciones (cod_usuario,diaVacaciones)
		values (pCodUser,pDiaDeVacacion);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha insertado vacaciones a un usuario");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pVacacionesModificar(IN pCodUser int, IN pDiaDeVacacion date, IN usuarioConectado int)
	BEGIN
		update vacaciones set diaVacaciones = pDiaDeVacacion
		where cod_usuario = pCodUser;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado las vacaciones de un usuario");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pVacacionesEliminar(IN pCodUser int, IN pDiaDeVacacion date, IN usuarioConectado int)
	BEGIN
		delete from vacaciones
		where diaVacaciones = pDiaDeVacacion and cod_usuario = pCodUser;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado las vacaciones de un usuario");
END 
 //

--   TABLA JORNADAS

-- VISUALIZAR
CREATE PROCEDURE pJornadasVisualizar ()
	BEGIN
		select * from jornadas;
END 
 //
-- AÑADIR
CREATE PROCEDURE pJornadasInsertar (IN pHoraInicio time, IN pHoraFin time,IN pColor varchar(15), IN usuarioConectado int)
	BEGIN
		insert into jornadas (hora_Inicio, hora_Fin, color)
		values (pHoraInicio, pHoraFin, pColor);

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha insertado una jornada");
END 
 //
-- MODIFICAR
CREATE PROCEDURE pJornadasModificar (IN pCodJornada int, IN pHoraInicio time, IN pHoraFin time,IN pColor varchar(15), IN usuarioConectado int)
	BEGIN
		update jornadas set hora_Inicio = pHoraInicio,
		hora_Fin = pHoraFin,
		color = pColor
		where cod_jornada = pCodJornada;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado una jornada");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pJornadasEliminar(IN pCodJornada int, IN usuarioConectado int)
	BEGIN
		delete from jornadas where cod_jornada = pCodJornada;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado una jornada");
END 
 //
--   TABLA REALIZA

-- VISUALIZAR
CREATE PROCEDURE pRealizaVisualiza ()
	BEGIN
		select r.fecha, r.cod_jornada, r.cod_user from realiza as r;
END 
 //
-- AÑADIR
CREATE PROCEDURE pRealizaInsertar (IN pFecha date, codJornada int, IN codUsuario int, IN usuarioConectado int)
	BEGIN
		declare existe int;
		set existe = (select count(*)
					from calendarioFestivo
					where provincia = (select provincia
									from usuarios
									where cod_user = codUsuario) and fechaFestiva = pFecha);
		if (existe = 0)
			THEN
				insert into realiza (fecha, cod_jornada, cod_user)
				values (pFecha, codJornada, codUsuario);
				
				insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
				values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha insertado una jornada a un usuario");
			END IF;
			
		set existe = (select count(*)
					from vacaciones
					where cod_usuario = codUsuario and diaVacaciones = pFecha);
			
		if (existe <> 0)
			THEN
				call pVacacionesEliminar(codUsuario,pFecha, usuarioConectado);
			END IF;
END 
 //
-- MODIFICAR
CREATE PROCEDURE pRealizaModificar (IN pFechaActual date, IN codJornada int, IN codUsuario int, IN usuarioConectado int)
	BEGIN
		update realiza set cod_jornada = codJornada
		where fecha = pFechaActual and cod_user = codUsuario;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha modificado una jornada a un usuario");
END 
 //
-- ELIMINAR 
CREATE PROCEDURE pRealizaEliminar(IN pFecha date, IN codUsuario int, IN usuarioConectado int)
	BEGIN
		delete from realiza 
		where fecha = pFecha and cod_user = codUsuario;

		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Se ha eliminado una jornada a un usuario");
END 
 //

--   TABLA REGISTRO ACTIVIDAD
-- VISUALIZAR
CREATE PROCEDURE pRegistroVisualizar()
	BEGIN
		select ra.cod_registro, ra.fecha, ra.cod_usuario, ra.accionRealizada from registro_accionRealizada;
END 
 //
/* *************************************************************************************

FUNCIONES PARA CASOS ESPECÍFICOS

**************************************************************************************** */

--  LISTAR LOS REGISTROS DE UN USUARIO DETERMINADO
CREATE PROCEDURE pListarRegistroPorUsuario (IN codUsuario int)
	BEGIN
		select ra.cod_registro, ra.fecha, ra.cod_usuario, ra.accionRealizada from registro_accionRealizada
		where ra.cod_usuario = codUsuario;
END 
 //
--  MOSTRAR LAS VACACIONES DE UN DETERMINADO USUARIO
CREATE PROCEDURE pVerVacacionesDeUsuarioDeterminado (IN codUsuario int)
	BEGIN
		select * from vacaciones where cod_usuario = codUsuario;
END 
 //
--  MOSTRAR LOS DÍAS FESTIVOS DE UN DETERMINADO USUARIO
CREATE PROCEDURE pVerDiasFestivosDeUsuarioDeterminado (IN codUsuario int)
	BEGIN
		select cf.cod_calendarioFestivo, cf.cod_usuario, cf.fechaFestiva, cf.provincia from calendarioFestivo as cf where
		cod_usuario = codUsuario;
END 
 //

--  VER LOS TRABAJADORES DE UNA DETERMINADA JORNADA
CREATE PROCEDURE pVerTrabajadoresDeUnaJornada (IN codJornada int)
	BEGIN
		select r.fecha, r.cod_jornada, r.cod_user from realiza as r where cod_jornada = codJornada; 
END 
 //
--  COMPROBAR SI EXISTE EL USUARIO Y QUE SU DAS Y PASSWORD SEA CORRECTA
CREATE FUNCTION fComprobarUSuario(fDas varchar(30), fPassword varchar(128))
RETURNS boolean
	BEGIN
		declare existe int;
		set existe = (select count(*) from usuarios as u where u.das = fDas and u.password = sha2(fPassword, 512));
		if (existe = 1) 
		then
			return true;
		else
			return false;
        END IF;
END 
 //
/* *************************************************************************************

FUNCIONES O PROCEDIMIENTOS DE BUSQUEDA

**************************************************************************************** */

-- BUSCAR UN GRUPO DETERMINADO
CREATE PROCEDURE pBuscarUnGrupo(IN pCodGrupo int)
	BEGIN
		select * from grupos where cod_grupo = pCodGrupo;
END 
//

-- BUSCAR GRUPOS POR NOMBRE DE GRUPO
CREATE PROCEDURE pBuscarUnGruposPorNombre(IN pNombre varchar(30))
	BEGIN
		select *
		from grupos 
		where (grupo like concat(pNombre,"%"));
END
//

-- BUSCAR USUARIOS POR NOMBRE Y APLLEIDO
CREATE PROCEDURE pUsuariosBuscarNombre(IN pNombre varchar(30))
	BEGIN
		select *
		from usuarios 
		where (nombre like concat(pNombre,"%") or apellidos like concat(pNombre,"%"));
END 
 //
-- BUSCAR USUARIO POR SU DAS
CREATE PROCEDURE pUsuariosBuscarDas(IN pDas varchar(30))
	BEGIN
		select * from usuarios where das = pDas;
END 
 //
 
 -- BUSCAR USUARIOS POR DAS
CREATE PROCEDURE pUsersPorDas(IN pDas varchar(30))
	BEGIN
		select * 
		from usuarios
		where (das like concat(pDas,"%"));
END 
 //
 -- BUSCAR USUARIOS POR SU CÓDIGO
CREATE PROCEDURE pUsuariosBuscarCodigo(IN pCodUser int)
	BEGIN
		select * from usuarios where cod_user = pCodUser;
END 
 // 
-- LISTAR USUARIOS DE UN DETERMINADO GRUPO
CREATE PROCEDURE pListarUsuariosPorGrupo (IN codGrupo int)
	BEGIN
		select * from usuarios
		where grupo = codGrupo;
END 
 //
--  LISTAR USUARIOS DE UN DETERMINADO TIPO
CREATE PROCEDURE pListarUsuariosPorTipo (IN codTipoUsuario int)
	BEGIN
		select * from usuarios
		where tipoUsuario = codTipoUsuario;
END 
 //
-- BUSCAR LOS USUARIOS QUE PERTENEZCAN AL GRUPO DE UN DETERMINADO USUARIO
CREATE PROCEDURE pListarUsuariosPorGrupoDeUsuario (IN pCodUsuario int)
	BEGIN
		select * from usuarios
		where grupo = (select grupo from usuarios where cod_user = pCodUsuario);
END
 //

CREATE PROCEDURE pUsuariosBuscarGrupoDeUnUsuario(IN pDas varchar(30))
	BEGIN
	select grupo from usuarios where das = pDas;
END
 //
-- LISTAR USUARIOS DE TIPO ADMINISTRADOR
CREATE PROCEDURE pListarAdministradores()
	BEGIN
		select * from usuarios 
		where tipoUsuario = (select cod_tipoUsuario from tipo_usuario
							where tipo = 'Administrador') or tipoUsuario = (select cod_tipoUsuario from tipo_usuario
																			where tipo = 'coordinador');
END
 //

-- LISTAR USUARIOS DE TIPO ESTÁNDAR
CREATE PROCEDURE pListarUsuariosEstandar()
	BEGIN
		select * from usuarios 
		where tipoUsuario = (select cod_tipoUsuario from tipo_usuario
							where tipo = 'Estandar');
END
 //
 
-- BUSCAR FESTEJOS POR PROVINCIAS
CREATE PROCEDURE pListarFestejosDeUnaProvinvia(IN pProvincia varchar(30))
	BEGIN
		select * from calendarioFestivo where provincia = pProvincia;
END 
 //
 
-- BUSCAR JORNADAS POR ID
CREATE PROCEDURE pJornadaPorId(IN pIdJornada int)
	BEGIN
		select * from jornadas where cod_jornada = pIdJornada;
END 
//

-- BUSCAR REALIZA
CREATE PROCEDURE pBuscarRealiza(IN pFecha date, IN pUser int)
	BEGIN
		select * from realiza where fecha = pFecha and cod_user = pUser;
END 
//
-- BUSCAR GRUPO DE USUARIO ACTUAL

 CREATE PROCEDURE pBuscarGrupoDeUsuarioActual(IN pDas varchar(30))
	BEGIN
		select * from grupos where cod_grupo = 
		(select grupo from usuarios where das = pDas);
END 
//

--  COMPROBAR SI EL USUARIO ES ADMINISTRADOR
CREATE FUNCTION fComprobarCoordinador(fDas varchar(30))
RETURNS boolean
	BEGIN
		declare existe int;
		set existe = (select tipoUsuario from usuarios as u where u.das = fDas);
		if (existe = (select cod_tipoUsuario from tipo_usuario where tipo = 'coordinador')) 
		then
			return true;
		else
			return false;
        END IF;
END 
 //
 
 --  COMPROBAR SI EL USUARIO ES ADMINISTRADOR
CREATE FUNCTION fComprobarAdministrador(fDas varchar(30))
RETURNS boolean
	BEGIN
		declare existe int;
		set existe = (select tipoUsuario from usuarios as u where u.das = fDas);
		if (existe = (select cod_tipoUsuario from tipo_usuario where tipo = 'administrador')) 
		then
			return true;
		else
			return false;
        END IF;
END 
 //
 
-- FESTIVIDADES DE UN DETERMINADO USUARIO
CREATE PROCEDURE pCalFestivoPorProvincias (IN pCodUsuario int)
	BEGIN
		select *
		from calendarioFestivo
		where provincia = (select provincia from usuarios where cod_user = pCodUsuario);
END
//
-- MOVER A USUARIO A GRUPO POR DEFECTO
CREATE PROCEDURE pExpulsarUsuario(IN pCodUsuario int, IN usuarioConectado int)
	BEGIN 
		update usuarios
		set grupo = (select cod_grupo from grupos where grupo = 'Sin Asignar')
		where cod_user = pCodUsuario;
		
		delete from realiza
		where cod_user = pCodUsuario;
		
		insert into registro_accionRealizada (cod_usuario, fecha,accionRealizada)
		values (usuarioConectado, CURRENT_TIMESTAMP(), "Ha expulsado a "+(select nombre from usuarios where cod_user = pCodUsuario)+" de su grupo");
		
END
//


-- BUSCAR JORNADAS REALIZADAS POR USUARIOS
CREATE PROCEDURE pJornadasRealizadasPorUsuario (IN pCodUser int)
	BEGIN
		select * 
		from realiza
		where cod_user = pCodUser;
END
//

-- MOSTRAR LOS DÍAS FESTIVOS DE UN USUARIO EN UNA DETERMINADA FECHA
CREATE PROCEDURE pBuscarJornadasDeUsuarioEnDeterminadasFechas (IN pCodUser int, IN pFechaDesde date, IN pFechaHasta date)
	BEGIN
		select *
		from realiza
		where cod_user = pCodUser 
		and fecha BETWEEN pFechaDesde and pFechaHasta;
END
//

-- MOSTRAR LOS DÍAS DE VACACIONES DE UN USUARIO EN UNA DETERMINADA FECHA
CREATE PROCEDURE pBuscarDiasVacacionesDeUsuarioEnDeterminadaFecha (IN pCodUser int, IN pFechaDesde date, IN pFechaHasta date)
	BEGIN
		select *
		from vacaciones
		where cod_usuario = pCodUser 
		and diaVacaciones BETWEEN pFechaDesde and pFechaHasta;
END
//

-- VACACIONES POR USUARIO
CREATE PROCEDURE pVacacionesPorUsuario (IN pCodUser int)
	BEGIN
		select *
		from vacaciones
		where cod_usuario = pCodUser;
END 
//

-- BUSCAR PROVINCIAS POR ID
CREATE PROCEDURE pProvinciasPorId (IN pCodProvincia int)
	BEGIN
		select *
		from provincias
		where cod_provincia = pCodProvincia;
END 
//