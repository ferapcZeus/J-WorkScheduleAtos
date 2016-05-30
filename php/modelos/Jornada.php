<?php 

class Jornada
{
	private $cod_jornada;
	private $horaInicio;
	private $horaFin;
	private $color;
	
	public function __construct()
	{	
		
	}
	 /* GENERAR GETTERS AND SETTERS */
	public function getCodJornada()
	{
		return $this->cod_jornada;
	}
	
	public function setCodJornada($codJornada)
	{
		$this->cod_jornada = $codJornada;
	}
	
	public function getHoraInicio()
	{
		return $this->horaInicio;
	}
	
	public function setHoraInicio($horaIni)
	{
		$this->horaInicio = $horaIni;
	}
	
	public function getHoraFin()
	{
		return $this->horaFin;
	}
	
	public function setHoraFin($horaSalida)
	{
		$this->horaFin = $horaSalida;
	}
	
	public function getColor()
	{
		return $this->color;
	}
	
	public function setColor($newColor)
	{
		$this->color = $newColor;
	}
	
	public function jsonSerialize() {
        return [
            'codJornada' => $this->cod_jornada,
            'horaInicio' => $this->horaInicio,
			'horaFin' => $this->horaFin,
			'color' => $this->color
        ];
    }
}
?>