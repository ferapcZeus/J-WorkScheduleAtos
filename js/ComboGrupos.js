var usuarioActual = "";
var esCoordinador = false;
var  esAdministrador = false;
var allWeekseleted = false;
var autoCompleteMaxSize = 25;
$(document).ready(function (){

	mostrarFecha();

		/* ************** BUSCAR USUARIO ACTUAL ***************** */
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: false,
		data: {'action' : 'buscarUsuarioActual'},
		dataType: 'json',
		success: function(usuarios)
		{
			usuarioActual = usuarios[0];
			
		},
		error: function(es){console.log(es.status)}
	});
	
	$.ajax
	({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: false,
		data: {'action' : 'comprobarAdministrador'},
		success: function(administrador)
		{
			

			if (administrador == false)
			{
				esAdministrador = false;
			}
			else 
			{
				esAdministrador = true;
			}
		}		
	});
	
	
	$.ajax
	({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: false,
		data: {'action' : 'comprobarCoordinador'},
		success: function(coordinador)
		{
			

			if (coordinador == false)
			{

				esCoordinador = false;
			}
			else 
			{
				esCoordinador = true;
			}
		}		
	});
	if (!esAdministrador && !esCoordinador)
	{
		$('#administracionMenu').hide();
	}
	
	$("#comboGrupo").change(function() {
		var grupo;
		var codGrupoSelected = $(this).val();
		$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: true,
			data: {'action' : 'userPorGrupo' , 'codigoGrupo' : codGrupoSelected},
			dataType: 'json',
			success: function(usuarios)
			{	
				$("#listaUsuarios").find('option').remove().end();
				for (var user in usuarios)
				{
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
		$("#coordinadorg").find('option').remove().end();
		var administrador = document.createElement("option");
		administrador.setAttribute("value",usuarioActual.cod_usuario);
		administrador.appendChild(document.createTextNode(usuarioActual.nombre));
		$("#coordinadorg").append(administrador);
	}
	
			$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: false,
			data: {'action' : 'grupoSelected' , 'codigoGrupo' : codGrupoSelected},
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
	});
	
	$("#lista").change(function() {
		var codigoGrupo = $(this).val();
		$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: true,
			data: {'action' : 'userPorGrupo','codigoGrupo' : codigoGrupo},
			dataType: 'json',
			success: function(usuarios)
			{
				$("#seccion").innerHTML = usuarios.length;
				recargar_tablas(usuarios);
			}
		});
	});
	
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: true,
		data: {'action' : 'tUser'},
		dataType: 'json',
		success: function(tUsuarios)
		{
			for (var i in tUsuarios)
			{
					
				var tUsuario = document.createElement("option");
				tUsuario.setAttribute("value",tUsuarios[i].codTipoUsuario);
				tUsuario.appendChild(document.createTextNode(tUsuarios[i].tipo));
				
				var tUsuario2 = document.createElement("option");
				tUsuario2.setAttribute("value",tUsuarios[i].codTipoUsuario);
				tUsuario2.appendChild(document.createTextNode(tUsuarios[i].tipo));
				
				if (esAdministrador)
				{
					$("#tusuario").append(tUsuario);					
					$("#tipoUsuarioGestionCombo").append(tUsuario2);
				}
				else if (esCoordinador)
				{
					if (tUsuarios[i].tipo == 'coordinador' || tUsuarios[i].tipo == 'estandar')
					{
						$("#tusuario").append(tUsuario);					
						$("#tipoUsuarioGestionCombo").append(tUsuario2);						
					}
				}
				else
				{
					
				}
			}
		},
		error: function(es){console.log(es.status)}
	});
	
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: true,
		data: {'action' : 'provincias'},
		dataType: 'json',
		success: function(provincias)
		{
			for (var i in provincias)
			{
				var provincia = document.createElement("option");
				provincia.setAttribute("value",provincias[i].codProvincia);
				provincia.appendChild(document.createTextNode(provincias[i].nombre));
				$("#provincia").append(provincia);
				
				var provinciaCombo2 = document.createElement("option");
				provinciaCombo2.setAttribute("value",provincias[i].codProvincia);
				provinciaCombo2.appendChild(document.createTextNode(provincias[i].nombre));
				$("#provinciaGestionCombo").append(provinciaCombo2);
			}
		},
		error: function(es){console.log(es.status)}
	});
	
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: true,
		data: {'action' : 'usuarioActual'},
		dataType: 'json',
		success: function(usuario)
		{
			$("#usuarioActual").html(usuario + ' <a class="text-desconectar" href="logout.php"> (Desconectar)</a>');
		},
		error: function(es){console.log(es.status)}
	});
	
	// PETICION DE LAS JORNADAS DE TRABAJO 
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: true,
		data: {'action' : 'jornadas'},
		dataType: 'json',
		success: function(jornadas)
		{
		//	var coloresArray = ['#B20033', 'black', 'blue', 'fuchsia', 'gray', 'green', 
			//					'lime', 'maroon', 'navy', 'olive', 'orange', 'purple', 'red', 
				//				'silver', 'teal', '#FDC847'];
			var divLeyenda = document.getElementById("Leyenda");
			var tablaLeyenda = document.createElement("table");
			tablaLeyenda.setAttribute("class", "leyenda");
			var filaTabla = document.createElement("tr");
			// filaTabla.setAttribute("class", "leyenda");
			// var rojo = 200;
			// var verde = 10;
			// var azul = 12;
			// var contadorColor = 0;
			var colorines
			// ELEMENTO BORRAR
				var jornadaBorrar = document.createElement("span");
				jornadaBorrar.setAttribute("class", "jornada-borrar");
				jornadaBorrar.setAttribute('style','background:white; border:1px solid black;');
				jornadaBorrar.appendChild(document.createTextNode("Borrar"));
				var column = document.createElement("td");
				column.setAttribute("class", "leyenda");
				column.appendChild(jornadaBorrar);
				filaTabla.appendChild(column);
				tablaLeyenda.appendChild(filaTabla);
				divLeyenda.appendChild(tablaLeyenda);
			// ---------------------
			
			// ELEMENTO FESTIVIDADES
			
				var vacacionesJornada = document.createElement("span");
				vacacionesJornada.setAttribute("class", "jornada-holiday");
				var column = document.createElement("td");
				column.setAttribute("class", "leyenda");
				column.appendChild(vacacionesJornada);
				
			// ELEMENTO VACACIONES
			
			
			for (var i in jornadas)
			{				
				// CREAR LA LEYENDA
				var colorJornada = document.createElement("span");
				colorJornada.setAttribute("class", "jornada-default");
				colorJornada.setAttribute("style","background:"+jornadas[i].color);
				colorJornada.setAttribute("color",jornadas[i].color);
				// colorJornada.style.backgroundColor = "rgb(" + rojo + "," + verde + "," + azul + ")";
				// rojo = contadorColor % 255;
				// verde = contadorColor % 255;
				// azul = contadorColor  % 255;
				// contadorColor += 30;
				//console.log(colorJornada.style.backgroundColor);
				colorJornada.appendChild(document.createTextNode(hora(jornadas[i].horaInicio)+" "+hora(jornadas[i].horaFin)));
				var columnTabla = document.createElement("td");
				columnTabla.setAttribute("class", "leyenda");
				colorJornada.setAttribute("value", jornadas[i].codJornada);
				columnTabla.appendChild(colorJornada);
				filaTabla.appendChild(columnTabla);
				
				var jornadaCombo = document.getElementById("comboJornada");
				var optionJornada = document.createElement("option");
				optionJornada.setAttribute("value",jornadas[i].codJornada);
				document.getElementById("color").value = jornadas[0].color;
				optionJornada.appendChild(document.createTextNode(jornadas[i].horaInicio +" - "+ jornadas[i].horaFin));
				document.getElementById("horainicio").value = jornadas[0].horaInicio;
				document.getElementById("horafin").value = jornadas[0].horaFin;
				jornadaCombo.appendChild(optionJornada);
				
			}
			
			filaTabla.appendChild(column);
			
			
			tablaLeyenda.appendChild(filaTabla);
			divLeyenda.appendChild(tablaLeyenda);
			
		},
		error: function(es){console.log(es.status)}
	});
	
	$(this).on('click','.fecha,.fecha-selected',function(){
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
			onClikDiasEvento($(this));			
		}
	}
	else if(grupoSelected.nombre == 'Sin Asignar')
	{
	}
	else
	{			
		onClikDiasEvento($(this));
	}
});
	
	$(this).on('click','.jornada-default',function(){
	if (esCoordinador || esAdministrador)
	{
		var jornadaSeleccionada = $(this);
		var usuariosSeleccionados = $('.user-select').map(function(){return $(this).attr("value");}).get();
		var diasSeleccionados = $('.fecha-selected').map(function(){return $(this).attr("value");}).get();

		if ($('.user-select').length > 0 && $('.fecha-selected').length > 0)
		{
			for (var i = 0; i < $('.user-select').length;i++)
			{
				for (var j = 0; j < $('.fecha-selected').length;j++)
					{
						var fecha = diasSeleccionados[j];
						var jornada = jornadaSeleccionada.attr("value")
						$.ajax({
							url: 'peticiones/JornadasRealizadas.php',
							type: 'POST',
							async: true,
							data: {'action' : 'jornadasRealiza',
							'idUser' : usuariosSeleccionados[i],
							'fecha' : fecha,
							'idJornada': jornada },
							success: function()
							{
								
							},
							error: function(es){console.log(es.status)}
						});	
						if ($('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+fecha+']').children[0] == undefined)
						{
							$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+fecha+']').html("");
							$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+fecha+']').removeClass("fecha-vacaciones");
							var jornadaSpan2 = document.createElement("span");
							jornadaSpan2.setAttribute("class", "jornada-realiza");
							jornadaSpan2.setAttribute("class", "jornada-realiza");
							jornadaSpan2.setAttribute("style", "background:"+$(this).attr("color"));
							$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+fecha+']').append(jornadaSpan2);
						}else {						
						$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+fecha+']').children[0].style.background =  $(this).attr("color");
						}
							
					}
			}		
					$('td[class="fecha-selected"]').removeClass("fecha-selected").addClass("fecha");
					$('td[class="fecha-selected diaActual"]').removeClass("fecha-selected").addClass("fecha");
					$('td[class="user-select"]').removeClass().addClass("user");
					$('td[class="user"][value='+usuarioActual.cod_usuario+']').addClass("actual")
			
		}
	}
	else
	{
		
	} 
	
});

$(this).on('click','.jornada-borrar',function(){
	if (esCoordinador || esAdministrador)
	{
		var usuariosSeleccionados = $('.user-select').map(function(){return $(this).attr("value");}).get();
		var diasSeleccionados = $('.fecha-selected').map(function(){return $(this).attr("value");}).get();
		if ($('.user-select').length > 0 && $('.fecha-selected').length > 0)
		{
			for (var i = 0; i < $('.user-select').length;i++)
			{
				for (var j = 0; j < $('.fecha-selected').length;j++)
					{
						if (!$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+diasSeleccionados[j]+']').children[0] == undefined)
						{}
						else
						{
						$.ajax({
							url: 'peticiones/JornadasRealizadas.php',
							type: 'POST',
							async: true,
							data: {'action' : 'borrarJornada',
							'idUser' : usuariosSeleccionados[i],
							'fecha' : diasSeleccionados[j]},
							success: function()
							{
							},
							error: function(es){alert("No se puede eliminar");}
						});	
						$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+diasSeleccionados[j]+']').html("");
						$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+diasSeleccionados[j]+']').removeClass("fecha-vacaciones");
						}
					}
					
			}
				$('td[class="fecha-selected"]').removeClass("fecha-selected").addClass("fecha");
				$('td[class="fecha-selected diaActual"]').removeClass("fecha-selected").addClass("fecha");
				$('td[class="user-select"]').removeClass().addClass("user");
				$('td[class="user"][value='+usuarioActual.cod_usuario+']').addClass("actual")
		}
	}
	else
	{
		
	}	
});

$(this).on('click','.jornada-holiday',function(){
	if (esCoordinador || esAdministrador)
	{
		var usuariosSeleccionados = $('.user-select').map(function(){return $(this).attr("value");}).get();
		var diasSeleccionados = $('.fecha-selected').map(function(){return $(this).attr("value");}).get();
		if ($('.user-select').length > 0 && $('.fecha-selected').length > 0)
		{
			for (var i = 0; i < $('.user-select').length;i++)
			{
				for (var j = 0; j < $('.fecha-selected').length;j++)
					{
						if (!$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+diasSeleccionados[j]+']').children[0] == undefined)
						{}
						else
						{
						$.ajax({
							url: 'peticiones/JornadasRealizadas.php',
							type: 'POST',
							async: true,
							data: {'action' : 'vacaciones',
							'idUser' : usuariosSeleccionados[i],
							'fecha' : diasSeleccionados[j]},
							success: function()
							{
							},
							error: function(es){alert("No se puede eliminar");}
						});	
						$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+diasSeleccionados[j]+']').html("");
						$('.horario_user[user='+usuariosSeleccionados[i]+'][fecha='+diasSeleccionados[j]+']').addClass("fecha-vacaciones");
						}
					}
					
			}
				$('td[class="fecha-selected"]').removeClass("fecha-selected").addClass("fecha");
				$('td[class="fecha-selected diaActual"]').removeClass("fecha-selected").addClass("fecha");
				$('td[class="user-select"]').removeClass().addClass("user");
				$('td[class="user"][value='+usuarioActual.cod_usuario+']').addClass("actual")
		}
	}
	else
	{
		
	}	
});
	
	
		$("#comboJornada").change(function() {
			var elemento =$(this);
			$.ajax({
				url: 'peticiones/JornadasRealizadas.php',
				type: 'POST',
				async: true,
				data: {'action' : 'buscarColor', 'idJornada' : elemento.val() },
				dataType: 'json',
				success: function(jornadas)
				{
					document.getElementById("color").value = jornadas[0].color;
					document.getElementById("horainicio").value = jornadas[0].horaInicio;
					document.getElementById("horafin").value = jornadas[0].horaFin;
				}
			});
	});	
	
$(this).on('click','#modificarJornada',function()
{
	modificarEliminarGestionJornadas("modificarJornada");
});

$(this).on('click','#eliminarJornada',function()
{
	modificarEliminarGestionJornadas("eliminarJornada");
});

$(this).on('click','#crearJornada',function()
{
	crearGestionJornadas("crearJornada");
});


		/* ************** LOAD USUARIOS***************** */
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: true,
		data: {'action' : 'grupoActual'},
		dataType: 'json',
		success: function(usuarios)
		{
			recargar_tablas(usuarios);
		},
		error: function(es){console.log(es.status)}
	});
	
		/* *************** LOAD GRUPOS ******************** */
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: true,
		data: {'action' : 'grupos'},
		dataType: 'json',
		success: function(grupos)
		{
			for (var i in grupos)
			{					
					var grupo = document.createElement("option");
					grupo.setAttribute("value",grupos[i].codGrupo);
					grupo.appendChild(document.createTextNode(grupos[i].nombre));
					
					var grupo2 = document.createElement("option");
					grupo2.setAttribute("value",grupos[i].codGrupo);
					grupo2.appendChild(document.createTextNode(grupos[i].nombre));
					
					var grupo3 = document.createElement("option");
					grupo3.setAttribute("value",grupos[i].codGrupo);
					grupo3.appendChild(document.createTextNode(grupos[i].nombre));
					
					var grupo4 = document.createElement("option");
					grupo4.setAttribute("value",grupos[i].codGrupo);
					grupo4.appendChild(document.createTextNode(grupos[i].nombre));
				
				// ADMINISTRAR GRUPOS MOSTRADOS
				
				 if (esAdministrador)
				{
					$("#lista").append(grupo);					
					$("#grupoGestionUsuario").append(grupo2);
					$("#grupoGestionUsuarioCombo").append(grupo3);
					$("#comboGrupoExtraer").append(grupo4);
					$("#lista option[value="+ usuarioActual.grupo +"]").attr("selected",true);
				}
				else if (esCoordinador)
				{
					
					$("#grupoGestionUsuarioCombo").append(grupo3);
					if (grupos[i].coordinador == usuarioActual.cod_usuario)
					{
						$("#lista").append(grupo);					
						$("#grupoGestionUsuario").append(grupo2);
						$("#comboGrupoExtraer").append(grupo4);
					}
					if (usuarioActual.grupo == grupos[i].codGrupo)
					{
						$("#lista").append(grupo);						
						$("#lista option[value="+ usuarioActual.grupo +"]").attr("selected",true);
					}
				}
				else 
				{
					if (usuarioActual.grupo == grupos[i].codGrupo)
					{
						$("#lista").append(grupo);
						$("#comboGrupoExtraer").append(grupo4);
						$("#lista option[value="+ usuarioActual.grupo +"]").attr("selected",true);
					}
				}
				
			}
		},
		error: function(es){console.log(es.status)}
	});
	
	$(document).on("click", '#gestionGruposLink', function (){
		cargarGestionGrupo();
		cargarGestionGrupo2();
		openModalGestionGrupo();	
	});
	
	/* *********************** TODO RELACIONADO CON LA BARRA DE BUSQUEDA **************************** */
	$('#buscador').attr("placeholder", "Buscar "+$('#selectBuscador').val());
	$('#selectBuscador').change(function(){
		$('#buscador').attr("placeholder", "Buscar "+$('#selectBuscador').val());
	});
	
	$('#selectBuscador').on('change', function (){
		$('#buscador').val("");
	})
	
	
	
	
	$("#buscador").on("keyup", function(e){
		if(e.which == 13) {
			$.ajax({
				url: 'peticiones/Buscador.php',
				type: 'POST',
				async: false,
				data: {'action' : $('#selectBuscador').val(),
				'codUser': $('#buscador').attr("codUser"),
				'idGrupo' : $('#buscador').attr("idGrupo"),			
				},
				dataType: 'json',
				success: function(datos)
				{
					if (datos[0].grupo == undefined)
					{
						$('#lista').val(datos[0].codGrupo).change();
					}else 
					{
						$('#lista').val(datos[0].grupo).change();
					}
					
				}
			});	
		}
		else if (e.which != 13)
		{
			if ($("#buscador").val() == undefined ||$("#buscador").val() == "")
			{
				$(this).val('');		
			}
			else
			{
				if ($('#selectBuscador').val() == 'nombre')
				{
					$.ajax({
						url: 'peticiones/Listar.php',
						type: 'POST',
						async: true,
						data: {'action' : 'buscador','queBuscar' : $('#selectBuscador').val() ,'nombre' : $("#buscador").val()},
						dataType: 'json',
						success: function(usuarios)
						{
							var users = new Array();

							if (usuarios.length > autoCompleteMaxSize)
							{
								for (var i = 0; i < autoCompleteMaxSize ;i++)
								{
									user =
										{
											value: usuarios[i].nombre + " " + usuarios[i].apellidos, 
											label: usuarios[i].nombre + " " + usuarios[i].apellidos,
											id: usuarios[i].cod_usuario
										};
									users.push(user);
										
								}
							}
							else
							{						
								for (var i in usuarios)
								{
									user =
										{
											value: usuarios[i].nombre + " " + usuarios[i].apellidos, 
											label: usuarios[i].nombre + " " + usuarios[i].apellidos,
											id: usuarios[i].cod_usuario
										};
									users.push(user);
								}
							}
							$('#usuariosSelect').html("");    
							$("#buscador").autocomplete({
							source: users,
							messages: {noResults: '', results: function(){}
							},        
							focus: function( event, ui ) {
								$('#buscador').val(ui.item.label);	
								return false;
							},
							select: function( event , ui )
							{					
							$('#buscador').attr("codUser", ui.item.id);
							var e = $.Event('keyup');
							e.which = 13; // Character 'A'
							$('#buscador').trigger(e);
							return false;
							},
							max:10,
							scrollHeight:250
							});
						}
					});
				}
				else if ($('#selectBuscador').val() == 'grupo')
				{
					$.ajax({
						url: 'peticiones/Listar.php',
						type: 'POST',
						async: true,
						data: {'action' : 'buscador','queBuscar' : $('#selectBuscador').val() ,'nombre' : $("#buscador").val()},
						dataType: 'json',
						success: function(grupos)
						{
							var groups = new Array();
							if (grupos.length > autoCompleteMaxSize)
							{
								for (var i = 0; i < autoCompleteMaxSize ;i++)
								{
									group = 
										{
											value: grupos[i].nombre,
											label: grupos[i].nombre,
											id: grupos[i].codGrupo
										};
									groups.push(group);
								}
							}
							else
							{						
								for (var i in grupos)
								{
									group = 
										{
											value: grupos[i].nombre,
											label: grupos[i].nombre,
											id: grupos[i].codGrupo
										};
									groups.push(group);
								}
							}
							$('#usuariosSelect').html("");    
							$("#buscador").autocomplete({
							source: groups,
							messages: {noResults: '', results: function(){}
							},        
							focus: function( event, ui ) {
								$('#buscador').val(ui.item.label);	
								return false;
							},
							select: function( event , ui )
							{					
							$('#buscador').attr("idGrupo", ui.item.id);
							var e = $.Event('keyup');
							e.which = 13; // Character 'A'
							$('#buscador').trigger(e);
							return false;
							},
							max:10,
							scrollHeight:250
							});
						}
					});
				}
				else if ($('#selectBuscador').val() == 'identificador')
				{
					$.ajax({
					url: 'peticiones/Listar.php',
					type: 'POST',
					async: true,
					data: {'action' : 'buscador','queBuscar' : $('#selectBuscador').val() ,'nombre' : $("#buscador").val()},
					dataType: 'json',
					success: function(usuarios)
					{
						var users = new Array();

							if (usuarios.length > autoCompleteMaxSize)
							{
								for (var i = 0; i < autoCompleteMaxSize ;i++)
								{
									user =
										{
											value: usuarios[i].das,
											label: usuarios[i].das,
											id: usuarios[i].cod_usuario
										};
									users.push(user);
										
								}
							}
							else
							{						
								for (var i in usuarios)
								{
									user =
										{
											value: usuarios[i].das,
											label: usuarios[i].das,
											id: usuarios[i].cod_usuario
										};
									users.push(user);
								}
							}
							$('#usuariosSelect').html("");    
							$("#buscador").autocomplete({
							source: users,
							messages: {noResults: '', results: function(){}
							},        
							focus: function( event, ui ) {
								$('#buscador').val(ui.item.label);	
								return false;
							},
							select: function( event , ui )
							{					
								$('#buscador').attr("codUser", ui.item.id);
								var e = $.Event('keyup');
								e.which = 13; // Character 'A'
								$('#buscador').trigger(e);
								return false;
							},
							max:10,
							scrollHeight:250
							});
					}
					});
				}
			}
		}
	});
	
	
	/* ***************************************************************************************************** */
	
	
	$(document).on('click', '#modGrupoPestana, #crearGrupoPestana', function (){
		if ($(this).text() == 'Modificar')
		{
			$('#crearGrupoPestana').removeClass("pestana-selected");
			$(this).addClass('pestana-selected');
			
			$('.crearGrupoContenedor').hide();
			$('.modificarGrupoContenedor').show();
		}
		else if ($(this).text() == 'Crear')
		{
			$('#modGrupoPestana').removeClass("pestana-selected");
			$(this).addClass('pestana-selected');
			$('#ngrupo').val("");
			
			$('.modificarGrupoContenedor').hide();
			$('.crearGrupoContenedor').show();
		}
		
	});
	
		$(document).on('click', '#modPestanaJornada, #crearPestanaJornada', function (){
		if ($(this).text() == 'Modificar')
		{
			$('#crearPestanaJornada').removeClass("pestana-selected");
			$(this).addClass('pestana-selected');
			
			$('.crearJornadaContenedor').hide();
			$('.modificarJornadaContenedor').show();
		}
		else if ($(this).text() == 'Crear')
		{
			$('#modPestanaJornada').removeClass("pestana-selected");
			$(this).addClass('pestana-selected');
			$('#ngrupo').val("");
			
			$('.modificarJornadaContenedor').hide();
			$('.crearJornadaContenedor').show();
		}
		
	});
	
	$(document).on('click', '#expulsarDelGrupoButton', function (){
		
	});
	
	
	if (esCoordinador && !esAdministrador)
	{
		$('#eliminarGruposButton').hide();
	}
	
	// LISTAR FESTIVIDADES
	
$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: false,
		data: {'action' : 'fiestas'},
		dataType: 'json',
		success: function(festejos)
		{
			
			for (var l in festejos)
			{
				$('.fecha-desactivada[fecha='+festejos[l].fecha+'] span').attr("title",festejos[l].festividad);
				$('.fecha-desactivada[fecha='+festejos[l].fecha+'] span').attr("data-original-title",festejos[l].festividad);
			}
			
			
		},
		error: function(es){console.log(es.status)}
	});
	
	$(document).on('keyup', '#horainicio2 , #horafin2', function(e){
		if (e.which == 8 || e.which == 0)
		{
		}
		else 
		{
			if ($(this).val().length == 2 )
			{
				$(this).val($(this).val()+":");
			}			
			if ($(this).val().length >= 6)
			{
			}  
		}
		
	});
	$(document).on('keypress', '#horainicio2, #horafin2', function(e){
		var chr = String.fromCharCode(e.which);
		if (e.which == 8 || e.which == 0)
		{
		}
		else
		{
			
			if ("1234567890".indexOf(chr) < 0)
			{
				return false;
			}
			else
			{	
				if ($(this).val().length == 2 )
				{
					$(this).val($(this).val()+":");
				}
			}
			if ($(this).val().length == 5)
			{
				return false;
			}  			
		}
	});
	
	// ONCLICK PARA EXPORTAR EL DOCUMENTO A EXCEL
	$(document).on('click', '#exportarExcelButton', function(e){
		var grupoSeleccionado;
		fechaActual = new Date();
		// TODO DEL MES DE INICIO
		fechaActual.setMonth(parseInt($('#mesesDesdeSelect').val()));
		var fechaDesde = new Date(fechaActual.getFullYear(),fechaActual.getMonth(),1);
		
		// Nº DE LAS SEMANA DEL AÑO QUE EMPIEZA EL MES DESDE
		var semanaDesde = numsemanas(new Date(fechaDesde.getFullYear(),fechaDesde.getMonth(),1));
		
		// TODO DEL MES FINAL (ÚLTIMO DÍA)	
		fechaActual.setMonth(parseInt($('#mesesHastaSelect').val()));
		var fechaHasta = getLastDateOfMonth(fechaActual.getFullYear(),fechaActual.getMonth());
		// Nº DE LAS SEMANA DEL AÑO QUE ACABA EL MES HASTA
		var semanaHasta = numsemanas(new Date(fechaHasta.getFullYear(),fechaHasta.getMonth(),fechaHasta.getDate()));

		
		// RECOGEMOS DATOS DEL GRUPO SELECCIONADO
		$.ajax({
			url: 'peticiones/Listar.php',
			type: 'POST',
			async: false,
			data: {'action' : 'grupoSelected', 'codigoGrupo': $('#comboGrupoExtraer').val()},
			dataType: 'json',
			success: function(grupo)
			{			
				grupoSeleccionado = grupo[0];
			},
			error: function(es){console.log(es.status)}
		});		
			$.ajax({
				url: 'gestion/exportar.php',
				type: 'POST',
				async: false,
				data: {'nombreGrupo' : grupoSeleccionado.nombre,
				'codgrupo' : grupoSeleccionado.codGrupo,
				'fechaDesde' : fechaDesde.getFullYear()+"-"+fechaDesde.getMonth()+"-"+fechaDesde.getDate(),
				'fechaHasta' : fechaHasta.getFullYear()+"-"+fechaHasta.getMonth()+"-"+fechaHasta.getDate(),
				'semanaEmpieza' : semanaDesde,
				'semanaAcaba': semanaHasta,
				},
				success: function(excelUrl)
				{
					console.log(excelUrl);
					window.open(excelUrl);
				},
				error: function(es){console.log(es.status)}
			});
	});
	
}); // AQUI ACABA DE ON LOAD DEL BODY *********************************************************************************************************





function addCSSRule(sheet, selector, rules, index) {
	if("insertRule" in sheet) {
		sheet.insertRule(selector + "{" + rules + "}", index);
	}
	else if("addRule" in sheet) {
		sheet.addRule(selector, rules, index);
	}
}

function hora(hora){
	return hora.substr(0,5);
	
}



function cargarColoresDeJornada(jornadaSpan)
{
	$.ajax({
		url: 'peticiones/JornadasRealizadas.php',
		type: 'POST',
		async: true,
		data: {'action' : 'buscarColor', 'idJornada': jornadaSpan.getAttribute("jornada")},
		dataType: 'json',
		success: function(jornadas)
		{
			jornadaSpan.style.background = jornadas[0].color;
		},
		error: function(es){console.log(es.status)}
	});	
}

function cambiarColor(id, diaSeleccionado,color)
{

			$('span[jornada='+id+'][fecha='+diaSeleccionado+']').attr("class", "jornada-realiza2");
}

	


function RecursiveUnbind($jElement) {
    // remove this element's and all of its children's click events
    $jElement.unbind();
    $jElement.removeAttr('onclick');
    $jElement.children().each(function () {
        RecursiveUnbind($(this));
    });
}
function grupoSeleccionado()
{
	var grupoSelected;
	$.ajax({
		url: 'peticiones/Listar.php',
		type: 'POST',
		async: false,
		data: {'action' : 'grupoAComparar', 'codGrupo':	$('#lista').val()},
		dataType: 'json',
		success: function(grupo)
		{
			grupoSelected = grupo[0];
		},
		error: function(es){console.log(es.status)}
	});	
	return grupoSelected;
	
}
function getLastDateOfMonth(Year,Month){
 return(new Date((new Date(Year, Month+1,1))-1));
 }