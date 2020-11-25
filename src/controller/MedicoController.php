<?php 
/*
 *@autor: José Luis
 *@Teste Facil Consulta
 *@MedicoController
*/	

class MedicoController extends Controller
{	
	private $medicoModel;
	private $pagination;

	public function __construct()
	{
		$this->medicoModel = $this->loadModel('MedicoModel');
		$this->pagination = $this->loadLibrarie('Pagination');
	}

	public function index()
	{	
		$this->loadView('frame/header');
		$this->loadView('medico/listagem');
	}

	public function cadastro()
	{	
		$this->loadView('frame/header');
		$this->loadView('medico/cadastro');
	}

	public function listagem()
	{
		$this->loadView('frame/header');
		$this->loadView('medico/listagem');
	}

	public function editar($id)
	{	
		if(is_numeric($id) && !empty($id))
		{	
			$medico = $this->medicoModel->getMedicoById($id);

			if($medico)
			{
				$dados = array('medico' => $medico);

				$this->loadView('frame/header');
				$this->loadView('medico/editar', $dados);
			}
			else
			{
				Header('Location:'.BASE_URL.'medico/listagem?er=1');
			}
		}
		else
		{
			Header('Location:'.BASE_URL.'medico/listagem?er=2');
		}	
	}	

	public function horario()
	{	
		$id = $_GET['id'];
		
		if(is_numeric($id) && !empty($id))
		{	
			$medico = $this->medicoModel->getMedicoById($id);

			if($medico)
			{
				$dados = array('medico' => $medico);

				$this->loadView('frame/header');
				$this->loadView('medico/horario', $dados);
			}
			else
			{
				Header('Location:'.BASE_URL.'medico/listagem?er=1');
			}
		}
		else
		{
			Header('Location:'.BASE_URL.'medico/listagem?er=2');
		}	
	}

	public function inserir()
	{	
		$inserir = $this->medicoModel->inserir($_POST);
		echo json_encode($inserir);
	}

	public function atualizar()
	{	
		$atualizar = $this->medicoModel->atualizar($_POST);
		echo json_encode($atualizar);
	}

	public function getMedicos()
	{
		$limit = PER_PAGE;  
		$perPage = (isset($_GET["p"])) ? $_GET["p"] : 1;  		
		$start = ($perPage - 1) * $limit;  		

		$getMedicos = $this->medicoModel->getMedicos($start, $limit);

		$totalRows = $getMedicos['total'];

		$this->pagination->paginate($totalRows, $limit, $perPage);

		$data = array
		(
			'dados' => $getMedicos['dados'],
			'total' => $getMedicos['total'],
			'paginate' => $this->pagination->links()
		);

		echo json_encode($data);
	}

	public function inserirHorario()
	{	
		$inserirHorario = $this->medicoModel->inserirHorario($_POST);
		echo json_encode($inserirHorario);
	}

	public function getHorarios()
	{
		$limit = PER_PAGE;  
		$perPage = (isset($_GET["p"])) ? $_GET["p"] : 1;  		
		$start = ($perPage - 1) * $limit;  		
		$idMedico = $_GET["idMedico"];

		$getHorariosByIdMedico = $this->medicoModel->getHorariosByIdMedico($idMedico, $start, $limit);

		$totalRows = $getHorariosByIdMedico['total'];

		$this->pagination->paginate($totalRows, $limit, $perPage);

		$data = array
		(
			'dados' => $getHorariosByIdMedico['dados'],
			'total' => $getHorariosByIdMedico['total'],
			'paginate' => $this->pagination->links()
		);

		echo json_encode($data);
	}

	public function excluirHorario($idHorario)
	{
		$excluirHorario = $this->medicoModel->excluirHorario($idHorario);
		echo json_encode($excluirHorario);
	}	

	public function agendar()
	{
		$agendar = $this->medicoModel->agendar($_POST);
		echo json_encode($agendar);
	}

}