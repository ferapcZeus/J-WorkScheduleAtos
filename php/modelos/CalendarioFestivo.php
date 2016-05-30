<?php 

class CalendarioFestivo {
	private $cod_calendarioFestivo;
	private $fechaFestiva;
	private $provincia;
	
	public function __construct()
	{ 
	}
	 /* GENERAR GETTERS AND SETTERS */
	public function getCodigoCalendarioFestivo()
	{
		return $this->cod_calendarioFestivo;
	}
	
	public function setCodigoCalendarioFestivo($cod)
	{
		$this->cod_calendarioFestivo = $cod;
	}
	
	public function getFechaFestiva()
	{
		return $this->fechaFestiva;
	}
	
	public function setFechaFestiva($fecha)
	{
		$this->fechaFestiva = $fecha;
	}
	
		public function getProvincia()
	{
		return $this->provincia;
	}
	
	public function setProvincia($idProvincia)
	{
		$this->provincia = $idProvincia;
	}
	
	public function jsonSerialize() {
        return [
            'codCalendarioFestivo' => $this->cod_calendarioFestivo,
            'fechaFestiva' => $this->fechaFestiva,
			'provincia' => $this->provincia
        ];
    }
}