<?php

// abstract quer dizer que não pode ser instânciado um obleto dessa classe.
abstract class Conexao
{

    // Atributo estático é da CLASSE e se chama com '::'
    private static $pdo_compartilhado;


    // Atributo dinâmico é do OBJETO(instância) e se chama '->'
    // protected pode ser visto apenas pela classe atual e seus descendentes
    protected  $pdo;


    // __construct sempre acontece quando fazemos um new
    function __construct()
    {
        // self é a CLASSE
        if(!self::$pdo_compartilhado){
            try
            {
                //http://php.net/manual/pt_BR/pdo.construct.php
                self::$pdo_compartilhado = new PDO('mysql:host='.DB_HOST.';dbname='.DB_BASE.';charset=utf8', DB_USER, DB_PASS);
                self::$pdo_compartilhado->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
                echo "<br> - Nao foi possivel conectar ao banco de dados
                      <br> - Mensagem de erro: <b>".$e->getMessage().'</b>';
                exit;
            }
        }
        // $this é o OBJETO
        $this->pdo = self::$pdo_compartilhado;
    }
}


interface Int_Conexao
{
    static function cria_tabela($con);
    public function get( $id );
    public function get_list( $colunas=[], $inner=[], $where=[]  );
    public function save();
    public function remove();
}