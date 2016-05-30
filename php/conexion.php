<?php
class Conexion
{
	private $server = "localhost";
	private $user = "root";
	private $pass = "";
	private $dataBase = "J-WorkScheduleAtosbd";
	private $conn;
	
	public function __construct()
	{	
		$this->conn = new mysqli
		(
			$this->server,
			$this->user,
			$this->pass,
			$this->dataBase
		);
		if ($this->conn->connect_errno)
		{
			echo "Fallo al contenctar a MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
		}
	}

	public function getConexion()
	{
		if ($this->conn == null)
		{
			$this->conn = new mysqli
			(
				$this->server,
				$this->user,
				$this->pass,
				$this->dataBase
			);
			if ($this->conn->connect_errno)
			{
				echo "Fallo al contenctar a MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
			}
		}		
		else
		{
			return $this->conn;
		}

	}
	public function desconectar()
	{
		if ($this->conn == null)
		{
			
		}
		else
		{
			$this->conn->close();	
		}
		
	}
}
?>