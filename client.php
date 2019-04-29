<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Cliente</title>
</head>
<body>
	<section>
		<form method="post">
			<table>
				<tr>
					<td><h2>Cadastro de pacientes:</h2><br>
						Nome:<br><input type="text" name="txtNome"><br>
						Idade:<br><input type="text" name="txtIdade"><br>
						Doença:<br><input type="text" name="txtDoenca"><br>
						Estado:<br>
						<select name="slcEstado">
							<option value="Grave">Grave</option>
							<option value="Moderado">Moderado</option>
							<option value="Leve">Leve</option>
						</select>
						<input type="submit" name="btnEnviar" value="Enviar" >
					</td>
				</tr>
				<?php
					$servidor_host = "127.0.0.1";
					$porta = 20302;

					if(isset($_POST["btnEnviar"])){
						$msg = "Nome: ".$_REQUEST['txtNome']."\r\n"."Idade: ".$_REQUEST['txtIdade']."\r\n"."Doença: ".$_REQUEST['txtDoenca']."\r\n"."Estado: ".$_REQUEST['slcEstado'];
						$socket = socket_create(AF_INET, SOCK_STREAM, 0);
						socket_connect($socket, $servidor_host, $porta);

						socket_write($socket, $msg, strlen($msg));

						$resposta = socket_read($socket, 1924);
						$resposta = trim($resposta);
						$resposta = "\nO servidor disse:\n".$resposta;
					}
				?>
				<tr>
					<td>
						<textarea readonly="readonly" cols="30" rows="10">Aguardando servidor. <?php echo @$resposta; ?> </textarea>
					</td>
				</tr>
			</table>
		</form>
	</section>
</body>
</html>