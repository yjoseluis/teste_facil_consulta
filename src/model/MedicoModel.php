<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@MedicoModel
*/	

class MedicoModel extends Model
{	
	public function __Construct()
    {
        parent::__construct();
    }

	public function inserir($postData)
	{	
		$response = $this->loadLibrarie('Response');
		$hash = $this->loadLibrarie('Hash');

		//Lógica para ver se os campos estão com mais de 6 caracteres
		if (strlen($postData['emailMedico']) < 6 || strlen($postData['nomeMedico']) < 6 || strlen($postData['senhaMedico']) < 6)
		{
			return $response->emit('warning', 'Por favor, forneça ao menos 6 caracteres nos campos!');
		}
		elseif(!filter_var($postData['emailMedico'], FILTER_VALIDATE_EMAIL))
		{
			return $response->emit('warning', 'Por favor, forneça um endereço e-mail válido.!');
		}
		else
		{
			$sql = ("
				INSERT INTO 
					medico 
					(email, nome, senha, data_criacao) 
				VALUES (
					\"{$postData['emailMedico']}\", 
					\"{$postData['nomeMedico']}\", 
					\"{$hash->crypt($postData['senhaMedico'])}\", 
					\"".date('Y-m-d H:i:s')."\"
				)"
			);

			$results = $this->conn->query($sql);

			if($results->rowCount() > 0)
			{	
				return $response->emit('success', 'Médico cadastrado com sucesso!');
			}
			else
			{
				return $response->emit('danger', 'Erro ao cadastrar o médico!');
			}
		}
	}	

	public function inserirHorario($postData)
	{	
		$response = $this->loadLibrarie('Response');
		$formatter = $this->loadLibrarie('Formatter');

		$sql = ("
			INSERT INTO 
				horario 
				(id_medico, data_horario, horario_agendado, data_criacao) 
			VALUES (
				\"{$postData['id_medico']}\", 
				\"{$formatter->datetime_db($postData['dataHorario'], $postData['horaHorario'])}\", 
				0, 
				\"".date('Y-m-d H:i:s')."\"
			)"
		);

		$results = $this->conn->query($sql);

		if($results->rowCount() > 0)
		{	
			return $response->emit('success', 'Horário cadastrado com sucesso!');
		}
		else
		{
			return $response->emit('danger', 'Erro ao cadastrar o hórario!');
		}
	}

	public function atualizar($postData)
	{	
		$response = $this->loadLibrarie('Response');
		$hash = $this->loadLibrarie('Hash');

		$medico = $this->getMedicoById($postData['idMedico']);

		//Lógica para ver se os campos estão com mais de 6 caracteres
		if (strlen($postData['emailMedico']) < 6 || strlen($postData['nomeMedico']) < 6)
		{
			return $response->emit('warning', 'Por favor, forneça ao menos 6 caracteres nos campos!');
		}
		else
		{	
			//Lógica para saber se os campos de senha antiga e nova estão com valores
			if(!empty($postData['novaSenhaMedico']) && !empty($postData['senhaMedico']))
			{	
				//Lógica para ver se os campos estão com mais de 6 caracteres
				if (strlen($postData['novaSenhaMedico']) < 6 || strlen($postData['senhaMedico']) < 6)
				{
					return $response->emit('warning', 'Por favor, forneça ao menos 6 caracteres nos campos!');
				}
				else
				{
					//Lógica para comparar se as duas senhas coincidem
					if($hash->compare($postData['senhaMedico'], $medico['senha']))
					{	
						$sql = ("
							UPDATE 
								medico 
							SET
								nome = \"{$postData['nomeMedico']}\", 
								senha = \"{$hash->crypt($postData['novaSenhaMedico'])}\", 
								data_alteracao = \"".date('Y-m-d H:i:s')."\"
							WHERE 
								id = {$postData['idMedico']}
						");

						$results = $this->conn->query($sql);

						if($results->rowCount() > 0)
						{	
							return $response->emit('success', 'Médico editado com sucesso!');
						}
						else
						{
							return $response->emit('danger', 'Erro ao editar o médico!');
						}
					}
					else
					{
						return $response->emit('warning', 'Parece que a senha que você digitou não é a mesma de seu cadastro!');
					}
				}
			}
			else
			{	
				$sql = ("
					UPDATE 
						medico 
					SET 
						nome = \"{$postData['nomeMedico']}\", 
						data_alteracao = \"".date('Y-m-d H:i:s')."\" 
					WHERE 
						id = {$postData['idMedico']}
				");

				$results = $this->conn->query($sql);

				if($results->rowCount() > 0)
				{	
					return $response->emit('success', 'Médico editado com sucesso!');
				}
				else
				{
					return $response->emit('danger', 'Erro ao editar o médico!');
				}
			}
		}
	}

	public function getMedicos($start = null, $perPage = null)
	{
		$formatter = $this->loadLibrarie('Formatter');

		$sql = ("
			SELECT
				medico.*,
				horario.data_horario 
			FROM
				medico
				LEFT JOIN horario ON horario.id_medico = medico.id 
				AND horario.horario_agendado = 0 
				AND horario.data_horario < 
				(
					SELECT 
						data_horario 
					FROM 
						horario 
					WHERE 
						id_medico = medico.id 
					GROUP BY 
						id_medico 
					ORDER BY 
						horario_agendado ASC, data_horario ASC
				) 
			GROUP BY
				medico.id 
			ORDER BY
				horario.data_horario DESC
			LIMIT {$start}, {$perPage}
		");

		$results = $this->conn->query($sql);

		$dados['dados'] = '';
		$dados['total'] = $this->conn->query("
			SELECT 
				* 
			FROM 
				medico
		")->rowCount();

		if($results->rowCount() > 0)
		{	
			$dados['dados'] .=
			'<table class="table" style="font-weight: bold;">
				<thead>
					<tr>
						<th style="font-weight: bold;""></th>
						<th style="font-weight: bold;">Nome</th>		
						<th style="font-weight: bold;"">Horários</th>				
					</tr>  
				</thead>
			<tbody>';

			foreach ($results->fetchAll(PDO::FETCH_ASSOC) as $medico)
			{
				$horarios = $this->getHorariosByMedico($medico['id']);

				$dados['dados'] .=
				'<tr> 				
				<td style="width:5%">
					<div class="td-actions text-left" style="display: block;">
						<a href="'.BASE_URL.'medico/editar/'.$medico['id'].'" rel="tooltip" class="btn btn-info btn-link">
							<i class="material-icons">edit</i>
						</a>						
						<a href="'.BASE_URL.'medico/horario?id='.$medico['id'].'" rel="tooltip" class="btn btn-success btn-link">
							<i class="material-icons">query_builder</i>
						</a>
					</div>  
				</td>
				<td>'.$medico['nome'].'</td>
				<td>';
					if($horarios)
					{
						$dados['dados'] .=
						'<table class="table table-sm table-bordered text-center">';

						foreach ($horarios as $horario)
						{	
							$horarioDisponivel = '';
							$title = '';

							switch ($horario['horario_agendado'])
							{
								case '0':
									$horarioDisponivel = '<span class="material-icons" style="color:green;">alarm_on</span>';
									$title = 'Horário Disponível';
									break;
								case '1':
									$horarioDisponivel = '<span class="material-icons" style="color:red;">alarm_off</span>';
									$title = 'Horário Agendado';
									break;	
							}

							$dados['dados'] .=
							'<tr onclick="agendar('.$medico['id'].', '.$horario['id'].', '.$horario['horario_agendado'].');" style="cursor:pointer;" class="tr-horario">
								<td>'.$formatter->db_datetime($horario['data_horario']).'</td>
								<td style="width:5%; text-align: right;" title="'.$title.'">'.$horarioDisponivel.'</td>
							</tr>';
						}

						$dados['dados'] .=
						'</table>';
					}
					else
					{
						$dados['dados'] .=
						'<table class="table table-sm table-bordered text-center">
							<tr><td>Não há horários para esse médico!</td></tr>
						</table>';	
					}
				$dados['dados'] .=
				'</td>
					</tr>';
			}

			$dados['dados'] .=
			'</tbody>
			</table>';
		}
		else
		{
			$dados['dados'] .= 
			'<table class="table table-striped table-sm" style="font-weight: bold;">   
				<tr>
					<td>Nenhum Registro encontrado!</td>
				</tr>                        
			<table>';
		}	

		return $dados;	
	}

	public function getHorariosByMedico($id_medico)
	{
		$sql = ("
			SELECT
				* 
			FROM
				horario 
			WHERE
				id_medico = {$id_medico} 
			ORDER BY
				horario_agendado ASC,
				data_horario ASC
		");

		$results = $this->conn->query($sql);

		if($results->rowCount() > 0)
		{
			return $results->fetchAll(PDO::FETCH_ASSOC);
		}	
		else
		{
			return false;
		}
	}

	public function getMedicoById($id)
	{
		$sql = ("
			SELECT
				* 
			FROM
				medico 
			WHERE
				id = {$id}
		");
		$results = $this->conn->query($sql);

		if($results->rowCount() > 0)
		{
			return $results->fetch(PDO::FETCH_ASSOC);
		}	
		else
		{
			return false;
		}
	}

	public function getHorariosByIdMedico($idMedico, $start = null, $perPage = null)
	{
		$formatter = $this->loadLibrarie('Formatter');

		$sql = ("
			SELECT 
				* 
			FROM 
				horario 
			WHERE 
				id_medico = {$idMedico} 
			LIMIT {$start}, {$perPage}
		");

		$results = $this->conn->query($sql);

		$dados['dados'] = '';
		$dados['total'] = $this->conn->query("
			SELECT 
				* 
			FROM 
				horario 
			WHERE 
				id_medico = {$idMedico}
		")->rowCount();

		if($results->rowCount() > 0)
		{	
			$dados['dados'] .=
			'<table class="table" style="font-weight: bold;">
				<thead>
					<tr>							
						<th style="font-weight: bold;"">Horários</th>
						<th style="font-weight: bold;""></th>				
						<th style="font-weight: bold;""></th>				
					</tr>  
				</thead>
			<tbody>';

			foreach ($results->fetchAll(PDO::FETCH_ASSOC) as $horario)
			{	
				$horarioDisponivel = '';
				$title = '';

				switch ($horario['horario_agendado'])
				{
					case '0':
						$horarioDisponivel = '<span class="material-icons" style="color:green;">alarm_on</span>';
						$title = 'Horário Disponível';
						break;
					case '1':
						$horarioDisponivel = '<span class="material-icons" style="color:red;">alarm_off</span>';
						$title = 'Horário Agendado';
						break;	
				}

				$dados['dados'] .=
				'<tr> 			
					<td>'.$formatter->db_datetime($horario['data_horario']).'</td>	
					<td style="width:5%; text-align: right;" title="'.$title.'">'.$horarioDisponivel.'</td>
					<td style="width:5%; text-align: right;">';
						if($horario['horario_agendado'] == 0)
						{	
							$dados['dados'] .=
							'<div class="td-actions text-right" style="display: block;">
								<a href="#" onclick="delHorario('.$horario['id'].');" rel="tooltip" class="btn btn-danger btn-link">
									<i class="material-icons">delete</i>
								</a>						
							</div>';  
						}
					$dados['dados'] .=
					'</td>
				</tr>';
			}

			$dados['dados'] .=
			'</tbody>
			</table>';
		}
		else
		{
			$dados['dados'] .= 
			'<table class="table table-striped table-sm" style="font-weight: bold;">   
				<tr>
					<td>Nenhum Registro encontrado!</td>
				</tr>                        
			<table>';
		}	

		return $dados;	
	}

	public function excluirHorario($idHorario)
	{	
		$response = $this->loadLibrarie('Response');

		$sql = ("
			DELETE 
			FROM 
				horario 
			WHERE 
				id = {$idHorario}
		");

		$results = $this->conn->query($sql);

		if($results->rowCount() > 0)
		{	
			return $response->emit('success', 'Horário excluído com sucesso!');
		}
		else
		{
			return $response->emit('danger', 'Erro ao excluir o horário!');
		}
	}


	public function agendar($postData)
	{	
		$response = $this->loadLibrarie('Response');

		$sql = ("
			UPDATE 
				horario 
			SET 
				horario_agendado = 1 
			WHERE 
				id = {$postData['idHorario']}
		");

		$results = $this->conn->query($sql);

		if($results->rowCount() > 0)
		{	
			return $response->emit('success', 'Horário agendado com sucesso!');
		}
		else
		{
			return $response->emit('danger', 'Erro ao agendar o horário!');
		}
	}
}