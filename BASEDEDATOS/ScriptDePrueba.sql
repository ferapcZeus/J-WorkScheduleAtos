

delimiter ;
-- PROVINCIAS
INSERT INTO provincias (provincia) values ('S/C de Tenerife'), ('Madrid'), ('Las Palmas');

-- TIPOUSUARIOS
INSERT INTO tipo_usuario (tipo) values ('estandar');
INSERT INTO tipo_usuario (tipo) values ('coordinador');
INSERT INTO tipo_usuario (tipo) values ('administrador');

-- FESTEJEJOS Y CALENDARIO FESTIVO

INSERT INTO festividades values ('2016-05-27','FESTEJO DE PRUEBAS');
INSERT INTO festividades values ('2016-05-24','FESTEJO DE PRUEBAS1');
INSERT INTO festividades values ('2016-05-31','FESTEJO DE PRUEBAS2');


INSERT INTO calendarioFestivo (fechaFestiva, provincia) values ('2016-05-27', 1),('2016-05-27', 2),('2016-05-27', 3);
INSERT INTO calendarioFestivo (fechaFestiva, provincia) values ('2016-05-24', 1),('2016-05-24', 2);
INSERT INTO calendarioFestivo (fechaFestiva, provincia) values ('2016-05-31', 1);

-- CREAR GRUPOS
INSERT INTO grupos (grupo, coordinador) values ('Sin Asignar', null);
INSERT INTO grupos (grupo, coordinador) values ('Wintel', null);
INSERT INTO grupos (grupo, coordinador) values ('Sistemas', null);
INSERT INTO grupos (grupo, coordinador) values ('Desarrollo', null);
INSERT INTO grupos (grupo, coordinador) values ('Ubunto', null);

/* INSERSIONES */
-- USUARIOS
insert into usuarios (nombre, apellidos, das, `password`, grupo, tipoUsuario, provincia, activo)
values (concat("Usuario1"), concat("Apellido1"),concat("das1"),sha2('123',512),1,2,1,true);
insert into usuarios (nombre, apellidos, das, `password`, grupo, tipoUsuario, provincia, activo)
values (concat("Usuario2"), concat("Apellido2"),concat("das2"),sha2('123',512),2,2,1,true );
insert into usuarios (nombre, apellidos, das, `password`, grupo, tipoUsuario, provincia, activo)
values (concat("Usuario3"), concat("Apellido3"),concat("das3"),sha2('123',512),2,1,2,true);
insert into usuarios (nombre, apellidos, das, `password`, grupo, tipoUsuario, provincia, activo)
values (concat("Usuario4"), concat("Apellido4"),concat("das4"),sha2('123',512),4,3,3,true );

-- DAR COORDINADOR A GRUPOS
UPDATE grupos set coordinador = 1 where cod_grupo = 1;
UPDATE grupos set coordinador = 1 where cod_grupo = 3;
UPDATE grupos set coordinador = 2 where cod_grupo = 2;
UPDATE grupos set coordinador = 2 where cod_grupo = 4;

-- DAR VACACIONES

call pVacacionesInsertar (1, '2016-05-02', 4);
call pVacacionesInsertar (1, '2016-05-03', 4);
call pVacacionesInsertar (1, '2016-05-04', 4);
call pVacacionesInsertar (1, '2016-05-05', 4);
call pVacacionesInsertar (1, '2016-05-06', 4);
call pVacacionesInsertar (1, '2016-05-07', 4);
call pVacacionesInsertar (1, '2016-05-08', 4);



-- CREAR JORNADAS
call pJornadasInsertar("01:00:00","09:00:00",'#B20033',1);
call pJornadasInsertar("02:00:00","10:00:00",'black',1);
call pJornadasInsertar("03:00:00","11:00:00",'#FDC847',1);
call pJornadasInsertar("04:00:00","12:00:00",'purple',1);
call pJornadasInsertar("05:00:00","13:00:00",'teal',1);
call pJornadasInsertar("06:00:00","14:00:00",'blue',1);
call pJornadasInsertar("07:00:00","15:00:00",'maroon',1);
call pJornadasInsertar("08:00:00","16:00:00",'lime',1);
	

call pRealizaInsertar('2016-05-09',1,1,1);
call pRealizaInsertar('2016-05-10',1,1,1);
call pRealizaInsertar('2016-05-11',1,1,1);
call pRealizaInsertar('2016-05-12',1,1,1);
call pRealizaInsertar('2016-05-13',1,1,1);
call pRealizaInsertar('2016-05-14',1,1,1);
call pRealizaInsertar('2016-05-15',1,1,1);

