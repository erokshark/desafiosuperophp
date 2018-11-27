<?php

class Task extends Conexao implements Int_Conexao
{
    public $codtask = '';
    public $nomtask = '';
    public $statustask = 0; 	
	
    static function cria_tabela($con){
		
			echo '<br> - - - criando!';
        $res = $con->exec(
            " CREATE TABLE tb_task (
                codtask INT NOT NULL AUTO_INCREMENT ,
                nomtask VARCHAR(255) NULL, 				
                statustask TINYINT(1) DEFAULT 0,
                PRIMARY KEY (codtask)
            )" );
        //print_r($con->errorInfo());
        $res = $con->exec( " INSERT INTO tb_task VALUES (1, 'task 1', 0)" );
        $res = $con->exec( " INSERT INTO tb_task VALUES (2, 'task 2', 1)" );
        return $res === false ? 'Erro: '.$con->errorInfo()[2] : 'Ok' ;
    }

    public function __construct($codtask='', $nomtask='', $statustask='')
    {
        parent::__construct();
        $this->codtask = $codtask;
        $this->nomtask = $nomtask;
        $this->statustask = $statustask; 
    }

    public function get($id)
    {
        $str = " SELECT * FROM tb_task WHERE codtask = ".$id;

        try{

            $stt = $this->pdo->prepare($str);
            $stt->execute();
            for($i=0; $row = $stt->fetch(); $i++){ 
                $this->codtask = $row['codtask'];
                $this->nomtask = $row['nomtask'];
                $this->statustask = $row['statustask']; 
            }
            return $this;
        }
        catch(PDOException  $e ){
            echo "Error: ".$e;
            return false;
        }
    }
     

    public function get_list( $colu_='', $inner='', $where='' )
    {
        $arr_ret = array();
        $inne_ = $inner  =='' ? ''  : $inner  ;
        $wher_ = $where=='' ? ''  : 'WHERE '.$where;
        $sql = "
          SELECT ".$colu_." 
            FROM tb_task  
                 ".$inne_."
                 ".$wher_." ";
        //echo $sql;
        try{
            $stt = $this->pdo->prepare($sql);
            $stt->execute();
            while($row=$stt->fetch(PDO::FETCH_OBJ)) {
                array_push($arr_ret, $row);
            }
        }
        catch(PDOException  $e ) {
            echo "Error: " . $e;
        }
        return $arr_ret;
    }

    public function save(){
        if( $this->codtask < 1 ){
            // Novo
            $sql = " 
              INSERT INTO tb_task
              VALUES ( 0
                     , '$this->nomtask' 
                     , '$this->statustask' )";
            //echo $sql; exit();

            try{
                $stt = $this->pdo->prepare($sql);
                $stt->execute();
                $this->codtask = $this->pdo->lastInsertId();
            }
            catch(PDOException  $e ){
                echo "Error: ".$e;
                return false;
            }

        }
        else{
            // Update
            //echo 'Update';
            $sql = " 
              UPDATE tb_task
                  SET nomtask = '$this->nomtask'
                    , statustask = '$this->statustask' 
                WHERE codtask= $this->codtask  ";
            //echo $sql; exit();
            try{
                $stt = $this->pdo->prepare($sql);
                $stt->execute();
                return $stt->rowCount();
            }
            catch(PDOException  $e ){
                echo "Error: ".$e;
                return false;
            }
        }
    }

    public function remove(){
        $sql = " 
          DELETE FROM tb_task 
          WHERE codtask = $this->codtask ";
        //echo $sql; exit();
        try{
            $stt = $this->pdo->prepare($sql);
            $stt->execute();
            return $stt->rowCount();
        }
        catch(PDOException  $e ){
            echo "Error: ".$e;
            return 0;
        }
    }

}