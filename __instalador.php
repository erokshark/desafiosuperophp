<pre>
<?php

include '_inc_config.php';
 
try
{
    echo '<br>Conecta no Banco ('.DB_HOST.') e Base('.DB_BASE.')! ';
    $con = new PDO('mysql:host='.DB_HOST.';dbname='.DB_BASE.';charset=utf8', DB_USER, DB_PASS);
    echo '<br> - Ok, conectado e Base já existe! ';
	try	{ 
		$numero_linhas_afetado = $con->exec("SELECT 1 FROM tb_task"  ); 
		if($numero_linhas_afetado > 0){
			echo '<br> - Ok, tabela já existe! ';
		}					
	} catch (PDOException $e)	{ 
	
			echo '<br> - - - Erro ao criar a tabela!';
		try {
			echo '<br> - Criando tabela - - Task => '.Task::cria_tabela($con);
		} catch (PDOException $e){
			echo '<br> - - - Erro ao criar a tabela!';
        }
	}
				
}
catch (PDOException $e)
{
    print_r($e);
    echo 'Erro = número(<b>'.$e->getCode().'</b>) , mensagem(<b>'.$e->getMessage().'</b>) ';
    if($e->getCode()=='1049'){
        echo '<br> - - Base('.DB_BASE.') não existe!';
        echo '<br> - - Conecta apenas no banco';
        try{
            $con = new PDO('mysql:host='.DB_HOST.'', DB_USER, DB_PASS);
            echo '<br> - - - Ok Banco ('.DB_HOST.') conectado sem a Base! ';
            // http://php.net/manual/pt_BR/pdo.exec.php
            // PDO::exec — Execute an SQL statement and return the number of affected rows
            $numero_linhas_afetado = $con->exec("CREATE DATABASE ".DB_BASE.""  );
            if($numero_linhas_afetado>0){
                $con = new PDO('mysql:host='.DB_HOST.';dbname='.DB_BASE.';charset=utf8', DB_USER, DB_PASS);
                echo '<br> - - - Ok Base ('.DB_BASE.') criada com sucesso! ';
                echo '<br> - - - Task => '.Task::cria_tabela($con);
            }
            else{
                echo '<br> - - - Erro ao criar a Base ('.DB_BASE.')!';
            }
        }
        catch (PDOException $e){

        }
    }
}
