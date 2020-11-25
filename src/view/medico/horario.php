<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title ">Configurar Horário</h4>
					</div>
					<form enctype="multipart/form-data" method="POST" action="<?=BASE_URL?>medico/inserirHorario" id="form_cadastroHorario">
						<div class="card-body">	
							<div class="row mt-3 mb-3">
								<div class="col">                  
									<a href="<?=BASE_URL?>medico/listagem" class="btn btn-success">Listagem de Médicos</a>             
								</div>
							</div>						
							<div class="row mt-3 mb-3">
								<div class="col-sm-6 mt-3">
									<div class="form-group bmd-form-group">
										<label for="#dataHorario" class="bmd-label-static">Data</label>
										<input type="text" class="form-control datepicker" id="dataHorario" name="dataHorario" required="true" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-6 mt-3">
									<div class="form-group bmd-form-group">
										<label for="#horaHorario" class="bmd-label-static">Hora</label>
										<input type="text" class="form-control timepicker" id="horaHorario" name="horaHorario" required="true" autocomplete="off">
									</div>
								</div>							
							</div>						
						</div>
						<div class="row mt-3" style="padding: .9375rem 20px;">
							<div class="col-md-12 text-right">
								<a href="javascript:history.back()" class="btn btn-dark">Cancelar</a>
								<button type="submit" class="btn btn-primary">Configurar</button>
							</div>
						</div>
					</form>
					<div class="card-body">
						<div class="table-responsive" id="data_resultHorarios"></div>
						<div class="row align-items-center">
							<div class="col-md-3"><b>Total de registros: </b><b id="data_totalHorarios"></b></div>
							<div class="col-md-9" id="data_pagination"></div>
						</div>
						<div class="col-md-12">
							<div class="row align-items-center text-left">
								<span class="material-icons" style="color:green;">alarm_on</span>Horário Disponível
							</div>
							<div class="row align-items-center text-left">
								<span class="material-icons" style="color:red;">alarm_off</span>Horário Agendado
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->loadView('frame/footer'); ?>

<script>
	var loader = '<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';

	facil.initDatetimepickers();

	var idMedico = facil.urlParam('id');

	inserirHorario('#form_cadastroHorario');
	loadHorarios(1);

	function inserirHorario(id)
	{	
		$(id).validate({
			highlight: function(element)
			{
				$(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
				$(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
			},
			success: function(element)
			{
				$(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
				$(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
			},
			errorPlacement: function(error, element)
			{
				$(element).closest('.form-group').append(error);
			},
			submitHandler: function(form)
			{
				$("#loader").show();
				var data = new FormData(form);
				data.append('id_medico', idMedico);
				var url = $(form).attr('action');

				$.ajax({
					url:url,      
					type:"post",        
					data: data,
					processData: false,
					cache: false,
					contentType: false,
					dataType: "json",
					success: function(result)
					{
						$("#loader").hide();
						facil.showNotification('top','right', result.text, result.type);
						facil.resetForm(form);	
						loadHorarios(1);
					}
				});
			}
		});
	}

	function loadHorarios(page)
	{
		$('#data_resultHorarios').html(loader);

		$.ajax({
			url: base_url+'medico/getHorarios?idMedico='+idMedico+'&p='+page,
			method:"get",
			dataType:"json",
			success:function(data)
			{
				$('#data_resultHorarios').html(data.dados);
				$('#data_pagination').html(data.paginate);
				$('#data_totalHorarios').html(data.total);
			}
		});
	}

	$(document).on('click','.pagination li a', function(e)
	{
		e.preventDefault();     
		var page = $(this).attr('href');
		loadHorarios(page);
	});

	function delHorario(idHorario)
	{
		Swal.fire({   
			title: "Excluir Horário",   
			text: "Deseja realmente excluir este horário?",  
			type: "warning",   
			showCancelButton: true,
			confirmButtonText: 'Sim',
			cancelButtonText: 'Não',
			reverseButtons: true,
			confirmButtonColor: '#FF3342',
		})
		.then((result) =>
		{
			if(result.value)
			{
				if((idHorario % 1) == 0){
					$("#loader").show();

					$.ajax({
						type: "POST",
						url: base_url+"medico/excluirHorario/"+idHorario,
						dataType: "json",
						success: function(result)
						{
							$("#loader").hide();
							facil.showNotification('top','right', result.text, result.type); 
							loadHorarios(1);
							
						}
					});
					return false;
				}
			}
			else{
				swal.close();
			}
		});
	}
</script>