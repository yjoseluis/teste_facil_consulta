<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Listagem dos Médicos</h4>
          </div>
          <div class="card-body">
            <div class="row mt-3 mb-3">
              <div class="col">                  
                <a href="<?=BASE_URL?>medico/cadastro" class="btn btn-success">Novo Médico</a>             
              </div>
            </div>

            <div class="table-responsive" id="data_resultMedicos"></div>
            <div class="row align-items-center">
              <div class="col-md-3"><b>Total de registros: </b><b id="data_totalMedicos"></b></div>
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

  switch(facil.urlParam('er'))
  {
    case '1':
    facil.showNotification('top','right', 'Médico não cadastrado!', 'info');
    break;      
    case '2':
    facil.showNotification('top','right', 'Parâmetros passados incorretamente!', 'danger');
    break;
    case 'null':  
    break;
  }

  loadMedicos(1);

  function loadMedicos(page)
  {
    $('#data_resultMedicos').html(loader);

    $.ajax({
      url: base_url+'medico/getMedicos?p='+page,
      method:"get",
      dataType:"json",
      success:function(data)
      {
        $('#data_resultMedicos').html(data.dados);
        $('#data_pagination').html(data.paginate);
        $('#data_totalMedicos').html(data.total);
      }
    });
  }

  $(document).on('click','.pagination li a', function(e)
  {
    e.preventDefault();     
    var page = $(this).attr('href');
    loadMedicos(page);
  });

  function agendar(idMedico, idHorario, horario_agendado)
  { 
    if(horario_agendado == 0)
    {
      $("#loader").show();
      $.ajax({
        url:base_url+"medico/agendar",      
        type:"post",        
        data: {idHorario:idHorario},
        dataType: "json",
        success: function(result)
        {
          $("#loader").hide();
          facil.showNotification('top','right', result.text, result.type);  
          loadMedicos(1);
        }
      });
    }
    else
    {
      facil.showNotification('top','right', 'Este horário já está agendado!', 'info');
    }
  }
</script>