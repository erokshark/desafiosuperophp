<? include '_inc_config.php';?>  

<?
$pes = isset($_REQUEST['inp_pes']) ? $_REQUEST['inp_pes'] : '';
?>

<html>

    <head>
        <? include '_inc_head.php';?>
    </head>
    
    <body> 
  
        <br>
        <?
        $inp_codi  = isset($_REQUEST['inp_codi'])  ? $_REQUEST['inp_codi']  : '0';
        $inp_nome  = isset($_REQUEST['inp_nome'])  ? $_REQUEST['inp_nome']  : '';
        $inp_status = ($_REQUEST['inp_status']=='yes' ? 1 : 0)	; 
        $msg = '';
        if( isset($_REQUEST['bt_salvar']) ){
            $task_ed = new Task();
            $task_ed->codtask = $inp_codi;
            $task_ed->nomtask = $inp_nome; 
            $task_ed->statustask = $inp_status; 
            if($task_ed->save() === false ){
                $msg = 'Erro ao realizar operação!';
            }
            else{
                $msg = 'Operação realizada com sucesso!';
                $inp_codi = $task_ed->codtask;
            }
        }

        if( isset($_REQUEST['bt_excluir']) ){
            $task_ed = new Task();
            $task_ed->codtask = $_REQUEST['inp_codi_ex'];
            if( $task_ed->remove() == 0 ){
                $msg = 'Erro ao realizar exclusão!';
            }
            else{
                $msg = 'Exclusão realizada com sucesso!';
            }
        }
        ?>
		<div class="col-md-6" >
			<form method="post" id="formEdicao" action="?">
				ID:        <input type="text" name="inp_codi"    readonly  value="<?=$inp_codi?>" />
				<br>Descrição:  <input type="text" name="inp_nome"    placeholder="Nome..."  value="<?=$inp_nome?>" />
				<br>Status: <input type="checkbox" name="inp_status"   placeholder="Status..." value="yes"  <? echo ($inp_status==1 ? 'checked' : '');?>>								 
				<br>
				<br>
				<input type="button" class="btn btn-success" value="Novo" onclick=" window.location='?' " />
				&nbsp; &nbsp; | &nbsp;&nbsp;
				<input type="submit" class="btn btn-primary" name="bt_salvar" value="Salvar" />				
			</form>
		</div>
		<hr> 
		
		<div class="col-md-6">
			<h1>Lista de Tasks</h1>
			
			<form method="post" action="?" class="navbar-search pull-left">
				<input class="span2" type="text" class="search-query" name="inp_pes" placeholder="Pesquisa..." value="<?=$pes?>" />
				<button class="btn btn-primary" type="submit" >Pesquisar</button>
			</form>		
		</div>
			
			<br><?=$msg?>
			
			<table border="1" class="col-md-8">
				<tr>
					<td>ID</td>
					<td>Descrição</td>
					<td>Status</td>
					<td>Editar</td>
					<td>Excluir</td>
				</tr>
				<?
					$ob_task = new Task();
					$lista = $ob_task->get_list('*', '', " nomtask LIKE '%".$pes."%' ");
					foreach ( $lista as $lin )
					{
						?>
						<tr>
							<td><?=$lin->codtask?></td>
							<td><?=$lin->nomtask?></td>
							<td class="text-center">
								<input type="checkbox" onclick="return false;" value="yes"  <?php echo ($lin->statustask==1 ? 'checked' : '');?>>								 
							</td>
							<td class="text-center">
								<form method="post" action="?">
									<input type="hidden" name="inp_codi" value="<?=$lin->codtask?>">
									<input type="hidden" name="inp_nome" value="<?=$lin->nomtask?>">
									<input type="hidden" name="inp_status" value="<?=$lin->statustask?>"> 
									  <button class="btn btn-info" type="submit" name="bt_editar" > Editar
									  </button> 

								</form>
							</td>
							<td class="text-center">
								<form method="post">
									<input type="hidden" name="inp_codi_ex" value="<?=$lin->codtask?>">
									  <button class="btn btn-danger" type="submit" name="bt_excluir" > Excluir
									  </button> 
								</form>
							</td>
						</tr>
						<?
					}
					if( count($lista) == 0 ) {
						?>
						<tr>
							<td colspan="3" > Nenhuma Task encontrada.</td>
						</tr>
						<?    
					}
				?>
			</table>			
		</div>
    </body>
</html> 