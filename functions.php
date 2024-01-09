<?php

class Constantes {
    const HOST = "";
    const USER = "";
    const PASSWORD = "";
    const DB = "";
}

class Configuracion extends Constantes{

    public $mysql = NULL;	

    public function conectarBD($bd = Constantes::DB)
    {
        date_default_timezone_set("America/Santiago");
        $this->mysql = new mysqli(Constantes::HOST, Constantes::USER, Constantes::PASSWORD, $bd);	
        mysqli_set_charset($this->mysql, "utf8");	
        return $this->mysql;

    }

    
    public function consulta($query)
    {			
        $i = 0;
        $contenedor = array();	
        $result = mysqli_query($this->mysql, $query) or die("Error en la consulta: $query ".mysqli_error());
        
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
        {
            $contenedor[$i] = $row;
            $i++;
        }
        
        return $contenedor;
    }

    public function actualizacion($query)
    {
        $result = mysqli_query($this->mysql, $query);

        if (!$result) {
            throw new Exception("Error en la consulta: " . mysqli_error($this->mysql));
        }
        
        return $result;
    }

    public function desconectarDB()
    {
            mysqli_close($this->mysql);
    }

}

 