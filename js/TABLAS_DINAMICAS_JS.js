
var hoy=new Date(); //objeto fecha actual
var numeroUsuarios;
		
function recargar_tablas(numuser) {
	if (numuser == undefined || numuser.length == 0)
	{
		numuser = {};
	}
	numeroUsuarios = numuser;
	limpiar();
	crear_calendario();
	lista(numuser);
	tabla_user(numuser);
	cargarJornadaRealiza();
}
		
function daysInMonth(mes, anyo){
	if( (mes == 1) || (mes == 3) || (mes == 5) || (mes == 7) || (mes == 8) || (mes == 10) || (mes == 12) ) 
		return 31;
	else if( (mes == 4) || (mes == 6) || (mes == 9) || (mes == 11) ) 
		return 30;
	else if( mes == 2 ){
		if (anyo % 4 == 0){
			if (anyo % 100 == 0){
				if (anyo % 400 == 0){
					return 29;
				}
				return 28;
			}
			return 29;
		}
		else
			return 28;
	}     
}
		
function crear_calendario(){
	meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	diassem = ["D","L","M","X","J","V","S"];
	
	var cab2 = document.createElement('tr');
	for (var i = - 1; i<=1; i++){
		var anyos = document.createElement('td');
		anyos.setAttribute("id","anyos"+i);
		
		if (i == 0){
		anyos.setAttribute("colspan", "15");
		anyos.setAttribute("class", "yearcalendario texto-year yearEncurso");
		}else {
		anyos.setAttribute("colspan", "8");
		anyos.setAttribute("class", "yearcalendario texto-year");
		}
		anyos.setAttribute("onclick", "cambiarAnyo(event)");

		
		if (hoy.getFullYear()+i == new Date().getFullYear()){ // DEJAR EL AÑO ACTUAL SIEMPRE SELECIONADO CON LA CLASE anyoActual(color:green) aunque cambie de año.
			anyos.setAttribute("class", anyos.getAttribute("class")+" anyoActual");
		}
		anyos.innerHTML=hoy.getFullYear()+i;
		cab2.appendChild(anyos);
	}
	
	for (var p in meses)
	{
		var mesOption = document.createElement("option");
		mesOption.setAttribute("value", p);
		mesOption.appendChild(document.createTextNode(meses[p]));
		$('#mesesDesdeSelect').append(mesOption);

		var mesOption2 = document.createElement("option");
		mesOption2.setAttribute("value", p);
		mesOption2.appendChild(document.createTextNode(meses[p]));
		$('#mesesHastaSelect').append(mesOption2);
	}
	
	var cab = document.createElement('tr');
	var cabecera = document.createElement('td');
	cabecera.setAttribute("id","cabecera");
	cabecera.setAttribute("colspan", "31");
	cabecera.setAttribute("class", "text-center texto-year");
	
	var span = document.createElement('span');
	span.setAttribute("id", "mesanterior");
	span.setAttribute("class", "mesanterior");
	span.setAttribute("onclick","mesAnt()");
	span.innerHTML = meses[hoy.getMonth()-1];
	
	var span2 = document.createElement('span');
	span2.setAttribute("id", "messiguiente");
	span2.setAttribute("class", "messiguiente");
	span2.setAttribute("onclick", "mesSig()");
	span2.innerHTML = meses[hoy.getMonth()+1];
	if (hoy.getMonth() == 11)
	{
		span2.innerHTML = meses[0];
	}
	if (hoy.getMonth() == 0)
	{
		span.innerHTML = meses[11];
	}
	
	var pMesAcual = document.createElement("span");
	pMesAcual.setAttribute("value",hoy.getMonth());
	pMesAcual.setAttribute("id","mesActual");
	pMesAcual.appendChild(document.createTextNode(meses[hoy.getMonth()]));
	cabecera.appendChild(pMesAcual);
	cabecera.appendChild(span);
	cabecera.appendChild(span2);
	cab.appendChild(cabecera);
	
	var sem = document.createElement('tr'); 
	var h = new Date(hoy.getFullYear(), hoy.getMonth(), 1).getDay();
	var dias = document.createElement('tr');
	var numsem = document.createElement('tr');
			
	var cont = 0;
	var numAnterior = -1;
	var k = 0;
	for (j = 0; j < daysInMonth(hoy.getMonth()+1,hoy.getFullYear()); j++){
		var dsem = document.createElement('td');
		dsem.setAttribute("id","week"+j);
		dsem.setAttribute("class","week");
		if (h > 6){
			h=0;
		}
		dsem.innerHTML=diassem[h++];
		sem.appendChild(dsem);
		var td1 = document.createElement('td');
		td1.setAttribute("id","fecha"+j);
		if ((j+1) == hoy.getDate() && meses[hoy.getMonth()] == meses[new Date().getMonth()] && hoy.getFullYear() == new Date().getFullYear()){
			td1.setAttribute("class","fecha diaActual");
			}else {
			td1.setAttribute("class","fecha");
		}
		td1.setAttribute("value", formattedDate(hoy,j+1));
		td1.innerHTML=j+1;					
		dias.appendChild(td1);		
	
		if (cont == 0){
			var semanasDelAnyo = document.createElement("td");
			semanasDelAnyo.innerHTML = + numsemanas(new Date(hoy.getFullYear(),hoy.getMonth(),j+1));
			numsem.appendChild(semanasDelAnyo);
			k++;
			cont++;
			numAnterior = semanasDelAnyo.innerHTML;
		}
		if (numAnterior == numsemanas(new Date(hoy.getFullYear(),hoy.getMonth(),j+1))){
			semanasDelAnyo.setAttribute("colspan",cont);
			semanasDelAnyo.setAttribute("id","semanasanyo"+ k);
			semanasDelAnyo.setAttribute("ultPos",j);
			semanasDelAnyo.setAttribute("idPos",k);
			semanasDelAnyo.setAttribute("class","semAnyo");
			cont++;
		}
		else {
			var semanasDelAnyo = document.createElement("td");
			semanasDelAnyo.setAttribute("id","semanasanyo" +k);
			semanasDelAnyo.setAttribute("ultPos",j);
			semanasDelAnyo.setAttribute("idPos",k);
			semanasDelAnyo.innerHTML = numsemanas(new Date(hoy.getFullYear(),hoy.getMonth(),j+1));
			numsem.appendChild(semanasDelAnyo);
			k++;
			numAnterior = semanasDelAnyo.innerHTML;
			cont = 1;
			cont++;
		}
		semanasDelAnyo.setAttribute("onclick", "verNumero(event)");
	}
				
	var tablacal = document.getElementById('calendario');
	tablacal.appendChild(cab2);
	tablacal.appendChild(cab);
	tablacal.appendChild(numsem);
	tablacal.appendChild(sem);	
	tablacal.appendChild(dias);
	
	$('#mesesDesdeSelect').val(0).change();
	$('#mesesHastaSelect').val(hoy.getMonth()).change();
}
			

function limpiar(){
	document.getElementById("calendario").innerHTML = "";
	document.getElementById("usuarios").innerHTML = "";
}
						
function lista(numuser){	
	for (var x = 0; x < numuser.length; x++){
		var str = document.createElement('tr');
		str.setAttribute("class", "horario_usertr");
		for (j = 0; j < daysInMonth(hoy.getMonth()+1,hoy.getFullYear()); j++){
			var cuser = document.createElement('td');
			cuser.setAttribute("class", "horario_user");
			var fechaAttr = formattedDate(hoy,j+1);
			cuser.setAttribute("fecha",fechaAttr);
			cuser.setAttribute("user",numuser[x].cod_usuario);
			str.appendChild(cuser);
		}
	var tablas = document.getElementsByTagName("table");
	var tablacal = tablas[1];			
	tablacal.appendChild(str);
	}
}
		
function numsemanas(hoy){
	var tdt = new Date(hoy.valueOf());
	var dayn = (hoy.getDay() + 6) % 7;
	tdt.setDate(tdt.getDate() - dayn + 3);
	var firstThursday = tdt.valueOf();
	tdt.setMonth(0, 1);
	if (tdt.getDay() !== 4){
		tdt.setMonth(0, 1 + ((4 - tdt.getDay()) + 7) % 7);
	}
	return 1 + Math.ceil((firstThursday - tdt) / 604800000);
}
function mesSig(){
	hoy.setMonth(hoy.getMonth()+1);
	recargar_tablas(numeroUsuarios);
}

function mesAnt(){
	hoy.setMonth(hoy.getMonth()-1);
	recargar_tablas(numeroUsuarios);
}


function cambiarAnyo(elEvento){
	hoy.setFullYear(parseInt(elEvento.target.innerHTML));
	recargar_tablas(numeroUsuarios);
}

function verNumero(elEvento){
	var grupoSelected = grupoSeleccionado();
	if (!esAdministrador)
	{
		if (usuarioActual.cod_usuario != grupoSelected.coordinador)
		{
			
		}
		else if(grupoSelected.nombre == 'Sin Asignar')
		{
		}
		else
		{	
			onClikSemanasEvento(elEvento);			
		}
	}
	else if(grupoSelected.nombre == 'Sin Asignar')
	{
	}
	else
	{	
		onClikSemanasEvento(elEvento);			
	}
}

function onClikSemanasEvento(elEvento)
{
	var adios = parseInt(elEvento.target.getAttribute('ultPos'));
		if (elEvento.target.getAttribute('idPos') == 1){
			var hola = parseInt(elEvento.target.getAttribute('idPos'));
			var anteriorPos = -1;
		}else {
			var hola = parseInt(elEvento.target.getAttribute('idPos')) -1;
			var anteriorPos = document.getElementById('semanasanyo'+ hola).getAttribute('ultPos');
		}
		for (var i = adios; i > anteriorPos; i--){
			
			if (elEvento.target.getAttribute("class") == 'semAnyo')
			{
				var dia = document.getElementById('fecha'+i);
				$('#fecha'+i).removeClass().addClass("fecha-selected");
				if ($('#fecha'+i).html() == new Date().getDate() && $("#mesActual").attr("value") == new Date().getMonth() && $("#anyos0").html() == new Date().getFullYear())
				{
					$('#fecha'+i).addClass("diaActual");
				}
				
			}else
			{
				var dia = document.getElementById('fecha'+i);
				if ($('#fecha'+i).html() == new Date().getDate() && $("#mesActual").attr("value") == new Date().getMonth() && $("#anyos0").html() == new Date().getFullYear())
				{
					dia.setAttribute("class","fecha diaActual");
				}else {
					dia.setAttribute("class","fecha");
				}
				
			}
		}
		if (elEvento.target.getAttribute("class") == 'semAnyo')
		{
			$('#'+elEvento.target.id).removeClass().addClass('semAnyo clicked');		
		}else
		{
			$('#'+elEvento.target.id).removeClass().addClass('semAnyo');
		}
}

function onClikDiasEvento(elemento)
{
	if (elemento.attr("class") == "fecha" || elemento.attr("class") == "fecha diaActual" )
		{
			if (elemento.html() == new Date().getDate() && $("#mesActual").attr("value") == new Date().getMonth() && $("#anyos0").html() == new Date().getFullYear())
			{			
				elemento.removeClass().addClass("fecha-selected diaActual");
			}
			else 
			{
				elemento.removeClass().addClass("fecha-selected");
			}
		}
		else
		{
			if (elemento.html() == new Date().getDate() && $("#mesActual").attr("value") == new Date().getMonth() && $("#anyos0").html() == new Date().getFullYear())
			{
				elemento.removeClass().addClass("fecha diaActual");
			}
			else 
			{
				elemento.removeClass().addClass("fecha");
			}
		}
}


function tabla_user(usuarios){
  var tablauser = document.getElementById("usuarios");
  for (var i in usuarios)
  {
    var filas = document.createElement('tr');
    var celdas = document.createElement('td');
	celdas.setAttribute("class", "user");
	var a = document.createElement("a");
	celdas.setAttribute("data-toggle", "modal");
	celdas.setAttribute("value", usuarios[i].cod_usuario);
	celdas.setAttribute("ondblclick", "cargarModal(event),openModalGestionUsuario()");
	celdas.setAttribute("onmousedown", "seleccionarUsuario(event)");
	if (usuarios[i].cod_usuario == usuarioActual.cod_usuario)
	{
		celdas.setAttribute("class", "user actual");
	}
	celdas.appendChild(document.createTextNode(usuarios[i].nombre + " " +usuarios[i].apellidos));
    filas.appendChild(celdas);
    tablauser.appendChild(filas);
	
	comprobrarDiasFestivos(usuarios[i].cod_usuario);
	comprobarVacaciones(usuarios[i].cod_usuario);
  }
}
function openModalGestionUsuario(){
	var grupoSelected = grupoSeleccionado();
	if ((esCoordinador && usuarioActual.cod_usuario == grupoSelected.coordinador) || esAdministrador)
	{
	$('#modalmoduser').modal('show')
	}
}
function seleccionarUsuario(elEvento){
	var grupoSelected = grupoSeleccionado();
	if ((esCoordinador && usuarioActual.cod_usuario == grupoSelected.coordinador) || esAdministrador)
	{
		if (elEvento.target.getAttribute("class") == 'user' || elEvento.target.getAttribute("class") == 'user actual')
		{
			elEvento.target.setAttribute("class", "user-select");
		}
		else
		{
			if (elEvento.target.getAttribute("value") == usuarioActual.cod_usuario)
			{
				elEvento.target.setAttribute("class", "user actual");
			}else
			{
				elEvento.target.setAttribute("class", "user");
			}
		}
		
	}
}

function cargarModal(elEvento)
{
	var grupoSelected = grupoSeleccionado();
	if ((esCoordinador && usuarioActual.cod_usuario == grupoSelected.coordinador) || esAdministrador)
	{
		var titulo = document.getElementById("nombreUsuarioText");
		var das = document.getElementById("dasGestionUsuario");
		var nombre = document.getElementById("nombreGestionUsuario");
		var apellidos = document.getElementById("apellidosGestionUsuario");
		titulo.innerHTML = elEvento.target.innerHTML;
		
		$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: true,
			data: {'action' : 'usuarioPorId' , 'id' : elEvento.target.getAttribute("value")},
			dataType: 'json',
			success: function(usuario)
			{
				$("#idUser").attr("value",usuario[0].cod_usuario);
				das.value = usuario[0].das;	
				nombre.value = usuario[0].nombre;	
				apellidos.value = usuario[0].apellidos;
				$("#grupoGestionUsuarioCombo option[value!="+usuario[0].grupo+"]").attr("selected",false);
				$("#tipoUsuarioGestionCombo option[value!="+usuario[0].tipoUsuario+"]").attr("selected",false);
				$("#provinciaGestionCombo option[value!="+usuario[0].provincia+"]").attr("selected",false);
				
				$("#grupoGestionUsuarioCombo option[value="+usuario[0].grupo+"]").attr("selected",true);
				$("#tipoUsuarioGestionCombo option[value="+usuario[0].tipoUsuario+"]").attr("selected",true);
				$("#provinciaGestionCombo option[value="+usuario[0].provincia+"]").attr("selected",true);
				
				
			},
			error: function(es){console.log(es.status)}
		});
	}
}

function display(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('mostrarFecha()',refresh);
}

function mostrarFecha() {
	var meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	var diassem = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sabado"];
	var hoy = new Date();
	var horas = hoy.getHours();
	var minutos = hoy.getMinutes();
	var segundos = hoy.getSeconds();
	
	if (horas<10)
	{
		horas = "0"+horas;
	}
	if (minutos<10)
	{
		minutos = "0"+minutos;
	}
	if (segundos<10)
	{
		segundos = "0"+segundos;
	}
	
	var fecha = diassem[hoy.getDay()]
	+" "+hoy.getDate() 
	+" de "+ meses[hoy.getMonth()]
	+" de "+ hoy.getFullYear()
	+"  "+ horas
	+":"+ minutos
	+":"+ segundos;
	document.getElementById('fechaActual').innerHTML = fecha;
	tt=display();
}

function fecha (){
	var fecha = hoy.getDate() 
	+"-"+hoy.getMonth()
	+"-"+ hoy.getFullYear();
	document.getElementById('FechaActualPruebas').innerHTML = "Version 5.1 " + fecha;
}

function formattedDate(date,day) {
    var d = date,
        month = '' + (d.getMonth() + 1),
        day = '' + day,
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day, ].join('-');
}

function modificarEliminarGestionJornadas(accion)
{
		$.ajax({
		url: 'gestion/Jornadas.php',
		type: 'POST',
		async: true,
		data: {'action' : accion,
		'idJornada': $('#comboJornada').val(),
		'horaInicio': $('#horainicio').val(),
		'horaFin': $('#horafin').val(),
		'color': $('#color').val()},
		success: function()
		{
		},
		error: function(es){console.log(es.status);}
	});	
}

function crearGestionJornadas(accion)
{
		$.ajax({
		url: 'gestion/Jornadas.php',
		type: 'POST',
		async: true,
		data: {'action' : accion,
		'horaInicio': $('#horainicio2').val(),
		'horaFin': $('#horafin2').val(),
		'color': $('#ncolor').val()},
		success: function()
		{
		},
		error: function(es){console.log(es.status);}
	});	
}
function cargarJornadaRealiza(){
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: true,
		data: {'action' : 'jornadasRealiza'},
		dataType: 'json',
		success: function(jornadas)
		{
			var elementos = $('.horario_user');
			for (var i = 0; i < elementos.length; i++)
			{
				for (var j = 0; j<jornadas.length;j++)
				{
					if (elementos[i].getAttribute('user') == jornadas[j].codUsuario)
					{
						if (elementos[i].getAttribute('fecha') == jornadas[j].fecha)
						{
							var jornadaSpan = document.createElement("span");
							jornadaSpan.setAttribute("class", "jornada-realiza");
							jornadaSpan.setAttribute("jornada", jornadas[j].codJornada);
							
								// CARGAR LOS COLORES DE LAS JORNADAS REALIZADAS
							cargarColoresDeJornada(jornadaSpan);	
							elementos[i].appendChild(jornadaSpan);
						}
					}
				}
			}
		},
		error: function(es){console.log(es.status)}
	});		
}
function comprobrarDiasFestivos(codUsuario)
{
		$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: false,
			data: {'action' : 'diasFestivos', 'codUser': codUsuario},
			dataType: 'json',
			success: function(calFestivo)
			{
				for (var j in calFestivo)
				{
					$('td[user='+codUsuario+'][fecha='+calFestivo[j].fechaFestiva+']').removeClass().addClass("fecha-desactivada");
				}
			},
			error: function(es){console.log(es.status)}
		});	
}
function comprobarVacaciones(codUsuario)
{
	$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: false,
			data: {'action' : 'vacaciones', 'codUser': codUsuario},
			dataType: 'json',
			success: function(vacaciones)
			{
				for (var j in vacaciones)
				{
					$('td[user='+codUsuario+'][fecha='+vacaciones[j].fecha+']').removeClass().addClass("horario_user fecha-vacaciones");
					/*var linkFestivo = document.createElement("span");
					linkFestivo.setAttribute("class","festejos glyphicon glyphicon-globe");
					linkFestivo.setAttribute("data-toggle","tooltip");
					linkFestivo.setAttribute("data-placement","auto");
					linkFestivo.setAttribute("title","Festejo");
					$('td[user='+codUsuario+'][fecha='+vacaciones[j].fechaFestiva+']').append(linkFestivo);*/
					
				}
			},
			error: function(es){console.log(es.status)}
		});	
}

function openModalGestionGrupo()
{
	if (esCoordinador || esAdministrador)
		{
			$('#modalmodgrupo').modal('show');
		}
}
function cargarGestionGrupo()
{
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: false,
		data: {'action' : 'grupos'},
		dataType: 'json',
		success: function(grupos)
		{
			$("#comboGrupo").find('option').remove().end();
			for (var i in grupos)
			{
				var grupoOption = document.createElement("option");
				grupoOption.setAttribute("value",grupos[i].codGrupo);
				grupoOption.appendChild(document.createTextNode(grupos[i].nombre));
				if (esAdministrador)
				{
					$('#comboGrupo').append(grupoOption);
				}
				else if (esCoordinador)
				{
					if (grupos[i].coordinador == usuarioActual.cod_usuario)
					{
						$("#comboGrupo").append(grupoOption);
					}
				}
				else 
				{
					
				}
			}
		},
		error:function(){console.log(err.status);}
	});
}
	
	
function cargarGestionGrupo2()
{	
	
	$('#nGrupoGestion').attr("value",$("#comboGrupo option[value="+$('#comboGrupo').val()+"]").html());
	var codGrupo = $("#comboGrupo").val();
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: false,
		data: {'action' : 'userPorGrupo', 'codigoGrupo' : codGrupo},
		dataType: 'json',
		success: function(usuarios)
		{
			$("#listaUsuarios").find('option').remove().end();
			for (var user in usuarios){
				options = document.createElement("option");
				options.setAttribute("value",usuarios[user].cod_usuario);
				options.appendChild(document.createTextNode(usuarios[user].nombre + " " + usuarios[user].apellidos));
				
				$("#listaUsuarios").append(options);
				
			}
		}
	});	
	
	if (esAdministrador)
	{
		$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: false,
			data: {'action' : 'administradores'},
			dataType: 'json',
			success: function(administradores)
			{
				$("#coordinadorg").find('option').remove().end();
				var options = document.createElement("option");
				options.setAttribute("value","null");
				options.appendChild(document.createTextNode("Sin asignar"));
				$("#coordinadorg").append(options);
					for (var i in administradores)
					{
						var administrador = document.createElement("option");
						administrador.setAttribute("value",administradores[i].cod_usuario);
						administrador.appendChild(document.createTextNode(administradores[i].nombre));
						$("#coordinadorg").append(administrador);
					}
			},
			error: function(es){console.log(es.status)}
		});
	}
	else 
	{
		var administrador = document.createElement("option");
		administrador.setAttribute("value",usuarioActual.cod_usuario);
		administrador.appendChild(document.createTextNode(usuarioActual.nombre));
		$("#coordinadorg").append(administrador);
	}
/*
	$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: false,
			data: {'action' : 'grupoSelected' , 'codigoGrupo' : codGrupo},
			dataType: 'json',
			success: function(grupos)
			{
				if (grupos[0].nombre == "Sin Asignar")
				{
					$("#nGrupoGestion").attr('disabled','disabled');
					$("#coordinadorg").attr('disabled','disabled');
					$('#expulsarDelGrupoButton').hide();
				}
				else
				{	
					$('#expulsarDelGrupoButton').show();				
					$("#nGrupoGestion").removeAttr('disabled');
					$("#coordinadorg").removeAttr('disabled');
					$("#nGrupoGestion").attr("value", grupos[0].nombre);
					$("#coordinadorg").val(grupos[0].coordinador).change();	
				}
			}
		});		
		*/
}