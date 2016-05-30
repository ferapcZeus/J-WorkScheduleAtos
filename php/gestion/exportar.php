<?php
require_once ('../Classes/PHPExcel.php');
include_once(__DIR__."/../servicios/usuarioServicios.php");
include_once(__DIR__."/../servicios/jornadaServicios.php");
include_once(__DIR__."/../servicios/realizaServicios.php");
include_once(__DIR__."/../servicios/calendarioFestivoServicios.php");
include_once(__DIR__."/../servicios/vacacionesServicios.php");
include_once(__DIR__."/../servicios/provinciaServicios.php");

$objPHPExcel = new PHPExcel();
$usuarioServicios = new usuarioServicio();
$realizaServicios = new realizaServicio();	
$jornadaServicios = new jornadaServicio();
$vacacionesServicios = new vacacionesServicio();
$provinciaServicios = new provinciaServicio();
$calendarioFestivoServices = new calendarioFestivoServicio();

$usuarios = $usuarioServicios->visualizarUsuariosPorGrupo($_POST['codgrupo']);

// TODO LOS PARAMETROS DE LA FECHAS
$semanaEmpieza = $_POST['semanaEmpieza'];
$fechadesde = date('Y-m-d', strtotime($_POST['fechaDesde']));

$semanaAcaba = $_POST['semanaAcaba'];
$fechaHasta = $_POST['fechaHasta'];



$objPHPExcel->
	getProperties()
		->setCreator("Eduardo Pérez Guerero")
		->setLastModifiedBy("Eduardo Pérez Guerero")
		->setTitle("SemanaDelaño")
		->setSubject("Documento de prueba")
		->setDescription("Documento generado con PHPExcel")
		->setKeywords("usuarios phpexcel")
		->setCategory("reportes");
$paginas = 0;
$casillaLetra = Array('B','C','D','E','F','G','H');
$posCasillaLetra=0;
if ($semanaEmpieza > $semanaAcaba)
{
	
}

for ($i = $semanaEmpieza ; $i<= $semanaAcaba;$i++)
{	
	$semanaEmpiezaYAcaba = getStartAndEndDate($i, 2016);
	if ($i == $semanaAcaba)
	{}
	else
	{
		$objPHPExcel->createSheet();
	}
	$posUsers=6;
	$objPHPExcel->setActiveSheetIndex($paginas)
		->setCellValue('A1', 'SEMANA '.$i)
		->setCellValue('A2', date('Y/m/d', strtotime($semanaEmpiezaYAcaba[0])).' - '.date('Y/m/d', strtotime($semanaEmpiezaYAcaba[1])))
		->setCellValue('A5', 'NOMBRE Y APELLIDOS')
		->setCellValue('B5', 'LUNES '.date('d', strtotime($semanaEmpiezaYAcaba[0])))
		->setCellValue('C5', 'MARTES '.date('d',  strtotime("+1 day", strtotime($semanaEmpiezaYAcaba[0]))))
		->setCellValue('D5', 'MIÉRCOLES '.date('d', strtotime("+2 days", strtotime($semanaEmpiezaYAcaba[0]))))
		->setCellValue('E5', 'JUEVES '.date('d', strtotime("+3 day", strtotime($semanaEmpiezaYAcaba[0]))))
		->setCellValue('F5', 'VIENES '.date('d', strtotime("+4 day", strtotime($semanaEmpiezaYAcaba[0]))))
		->setCellValue('G5', 'SABADO '.date('d', strtotime("+5 day", strtotime($semanaEmpiezaYAcaba[0]))))
		->setCellValue('H5', 'DOMINGO '.date('d', strtotime($semanaEmpiezaYAcaba[1])));

	$objPHPExcel->getActiveSheet()
        ->getStyle('A1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('4F81BD');
		
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
		->setName('Arial')
		->setSize(14)
		->setBold(true)
		->getColor()->setRGB('FFFFFF');
	
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()
    ->setName('Arial')
    ->setSize(14);
	
	$objPHPExcel->getActiveSheet()->getStyle()
    ->getBorders()
    ->getTop()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
		
		
	for ($j = 0; $j< count($usuarios) ;$j++)
	{
		$objPHPExcel->setActiveSheetIndex($paginas)
		->setCellValue('A'.$posUsers, $usuarios[$j]['nombre']);
		
		$jornadasRealiza = $realizaServicios->realizaPorUsuarioEnFechaDeterminada($usuarios[$j]['cod_usuario'],date('Y-m-d',  strtotime($semanaEmpiezaYAcaba[0])),date('Y-m-d',  strtotime($semanaEmpiezaYAcaba[1])));
		$festivos = $calendarioFestivoServices->festividadPorUsuarios($usuarios[$j]['cod_usuario']);
		$vacaciones = $vacacionesServicios->buscarVacacionesPorUsuarios($usuarios[$j]['cod_usuario']);
		$provincia = $provinciaServicios->buscarProvinciaPorId($usuarios[$j]['provincia']);
		for ($dias = 0; $dias<7; $dias++)
		{
			for ($nJornada = 0; $nJornada < count($jornadasRealiza); $nJornada++)
			{
				if (date('Y-m-d',  strtotime("+".$dias." days", strtotime($semanaEmpiezaYAcaba[0]))) == date('Y-m-d', strtotime($jornadasRealiza[$nJornada]['fecha'])))
				{
					$jornada = $jornadaServicios->jornadaPorID($jornadasRealiza[$nJornada]['codJornada']);
					$objPHPExcel->setActiveSheetIndex($paginas)
						->setCellValue($casillaLetra[$dias].''.$posUsers, substr($jornada[0]['horaInicio'],0,5).' - '.substr($jornada[0]['horaFin'],0,5));
				}			
			}
			for ($nFestivo = 0; $nFestivo < count($festivos); $nFestivo++)
			{
				if (date('Y-m-d',  strtotime("+".$dias." days", strtotime($semanaEmpiezaYAcaba[0]))) == date('Y-m-d', strtotime($festivos[$nFestivo]['fechaFestiva'])))
				{
					$objPHPExcel->setActiveSheetIndex($paginas)
						->setCellValue($casillaLetra[$dias].''.$posUsers, "Festivo de ".$provincia[0]['nombre']);
					$objPHPExcel->getActiveSheet()
						->getStyle($casillaLetra[$dias].''.$posUsers)
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setRGB('92D050');
				}
			}
			for ($nVacaciones = 0; $nVacaciones < count($vacaciones); $nVacaciones++)
			{
				if (date('Y-m-d',  strtotime("+".$dias." days", strtotime($semanaEmpiezaYAcaba[0]))) == date('Y-m-d', strtotime($vacaciones[$nVacaciones]['fecha'])))
				{
					$objPHPExcel->setActiveSheetIndex($paginas)
						->setCellValue($casillaLetra[$dias].''.$posUsers, "VACACIONES");
						
					$objPHPExcel->getActiveSheet()
						->getStyle($casillaLetra[$dias].''.$posUsers)
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setRGB('92D050');
				}
			}
			
			
		}
		for ($r = 0; $r<7;$r++)
		{
			if ($objPHPExcel->setActiveSheetIndex($paginas)
					->getCell($casillaLetra[$r].''.$posUsers)->getValue() == '')
			{
				$objPHPExcel->setActiveSheetIndex($paginas)
					->setCellValue($casillaLetra[$r].''.$posUsers, 'N/A');
			}
		}		
		$posUsers++;
	}
	
	$objPHPExcel->getActiveSheet()->setTitle('w'.$i);
	$paginas++;
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
	$objPHPExcel->getActiveSheet()->getColumnDimension()->setAutoSize(true);
}

		$objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.ms-excel');
	
	$archivo = "Turno ".$_POST['nombreGrupo'].".xlsx";
	$directorio = dirname(__FILE__)."../../../tmp/".$archivo;
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save($directorio);
	echo "../tmp/".$archivo;
	


function getStartAndEndDate($week, $year)
{

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7*$week)+1-$day)*24*3600;
    $return[0] = date('Y-n-j', $time);
    $time += 6*24*3600;
    $return[1] = date('Y-n-j', $time);
    return $return;
}


?>