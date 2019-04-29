<?php
	$servidor_host = "127.0.0.1";
	$porta = 20302;
	set_time_limit(0);

	$socket = socket_create(AF_INET,SOCK_STREAM,0) or die("Não foi possível criar o socket.\n");
	$resultado = socket_bind($socket,$servidor_host,$porta) or die("Não foi possível passar o endereço para o socket.\n");

	$resultado = socket_listen($socket, 3) or die("Não houve escuta no socket / não foi possível criar um canal de escuta no socket.\n");
	echo("Esperando conexões...");

	do{
		$confirmacao = socket_accept($socket) or die("Não foi possível aceitar a conexão.\n");
		$msg = socket_read($confirmacao, 1024) or die("Não foi possível ler a mensagem\n");
		
		// $msg = trim($msg);

		echo("\nMensagem do cadastro de pacientes (cliente): \n ".$msg."\n\n");

		date_default_timezone_set('America/Sao_Paulo');
		$data_atendimento = date('d-m-Y-H-i');
		$nome_arquivo = "./htdocs/Clientes/".$data_atendimento.".txt";
    	$arquivo = fopen($nome_arquivo, 'a');
    	if(fwrite($arquivo,$msg)) echo("\nArquivo salvo com sucesso. $nome_arquivo");
    	fclose($arquivo);

		$resposta = "\nO paciente foi cadastrado com sucesso! \nDados:\n$msg";

		socket_write($confirmacao, $resposta, strlen($resposta)) or die("Não foi possível escrever a resposta.\n");
	}while(1);

	socket_close($confirmacao, $socket);
?>