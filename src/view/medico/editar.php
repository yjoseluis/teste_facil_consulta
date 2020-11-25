<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title ">Editar Médico</h4>
					</div>
					<form enctype="multipart/form-data" method="POST" action="<?=BASE_URL?>medico/atualizar" id="form_edicaoMedico">
						<div class="card-body">						
							<div class="row mt-3 mb-3">
								<div class="col-sm-6 mt-3">
									<div class="form-group bmd-form-group">
										<label for="#nomeMedico" class="bmd-label-floating">Nome</label>
										<input type="text" class="form-control" id="nomeMedico" name="nomeMedico" required="true" minlength="6" value="<?=$medico['nome']?>">
									</div>
								</div>
								<div class="col-sm-6 mt-3">
									<div class="form-group bmd-form-group">
										<label for="#emailMedico" class="bmd-label-floating">Email</label>
										<input type="email" class="form-control" id="emailMedico" name="emailMedico" readonly="" required="true" minlength="6" value="<?=$medico['email']?>">
									</div>
								</div>							
								<div class="col-sm-6 mt-3">
									<div class="form-group bmd-form-group">
										<label for="#senhaMedico" class="bmd-label-floating">Senha Antiga</label>
										<input type="password" class="form-control" id="senhaMedico" name="senhaMedico" minlength="6">
									</div>
								</div>
								<div class="col-sm-6 mt-3">
									<div class="form-group bmd-form-group">
										<label for="#novaSenhaMedico" class="bmd-label-floating">Nova Senha</label>
										<input type="password" class="form-control" id="novaSenhaMedico" name="novaSenhaMedico" minlength="6">
									</div>
								</div>
								<input type="hidden" name="idMedico" value="<?=$medico['id']?>">
							</div>						
						</div>
						<div class="row mt-3" style="padding: .9375rem 20px;">
							<div class="col-md-12 text-right">
								<a href="javascript:history.back()" class="btn btn-dark">Cancelar</a>
								<button type="submit" class="btn btn-primary">Editar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->loadView('frame/footer'); ?>

<script>
	atualizarMedico('#form_edicaoMedico');

	function atualizarMedico(id)
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
							
						if(result.type == 'success')
						{
							setTimeout(function()
				            { 
				              window.location.href = base_url+'medico/listagem'; 
				            }, 
				            1500);
						}					
					}
				});
			}
		});
	}
</script>