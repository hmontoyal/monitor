<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use webvimark\modules\UserManagement\UserManagementModule;
use webvimark\modules\UserManagement\models\User;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" integrity="sha256-ccThxznU5Q++c2MNkhHO+lnCa+WeyM1uhdE9R5xYb3s=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" integrity="sha256-xykLhwtLN4WyS7cpam2yiUOwr709tvF3N/r7+gOMxJw=" crossorigin="anonymous" />
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css" integrity="sha256-gVCm5mRCmW9kVgsSjQ7/5TLtXqvfCoxhdsjE6O1QLm8=" crossorigin="anonymous" />
    

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
   <!--  <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Inicio', 'url' => ['/site/index']],
            // User::hasRole('supervisor') ?
            // ['label' => 'usuarios', 'url' => ['/user-management/user/index']] :
            // '',
            // ['label' => 'About', 'url' => ['/site/about']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?> -->

    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">KROPSYS ADMIN</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
 <!--      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul> -->
<!--       <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form> -->
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#">Link</a></li> -->
        <?=  Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Salir (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ) ?>
      </ul>
    </div>
  </div>
</nav>

    <div class="">
  
            <div class="col-md-12">
                 <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
            </div>
        
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>   

<footer class="footer">
    <div class="">
        <p class="pull-left">&copy; Kropsys Ltda. <?= date('Y') ?></p>

        <p class="pull-right"><!-- <?= Yii::powered() ?> --></p>
    </div>
</footer>

<?php $this->endBody() ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.js" integrity="sha256-m68J/1YV2ekOkpVRiOlz7WamDtyEAitsWGNJjAk8Uz4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js" integrity="sha256-LddDRH6iUPqbp3x9ClMVGkVEvZTrIemrY613shJ/Jgw=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="assets/js/plugins/jquery.numeric.js"></script>
<script>
 $(document).ready(function(){
       $('.ajaxform').ajaxForm({
        success: function(res){
            if(res.success == true){
                toastr.success('Registrado con exito', '');
                $('.div-toggeable').toggle();
               
            }else{
                toastr.error('Hubo un problema al guardar, intentelo mas tarde...', '');
            }
        }
       });
      $.extend( true, $.fn.dataTable.defaults, {
           "language": {
                 "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
               }
        } );
     $('textarea').summernote({});
     var datatable = $('#table_impresoras, #table_detalle, #table_ubicaciones').DataTable();
     $('.datetimepicker').datetimepicker({
        format:'YYYY-MM-DD hh:mm:00 a'
    });

     $('.btn-popup').on('click', function(e){
        e.preventDefault();
        let btn = $(this);
        let url = btn.data('url');
        let id = btn.data('id');
        let __modal = $('#myModal');
        __modal.find('.modal-body').html('');
        __modal.find('.modal-body').html('<i class="fa fa-refresh fa-spin fa-2x"></i>');
        __modal.modal('show');
        __modal.find('.modal-body').load(url,{id: id},function(){
            //alert('ok');
            $('.table-datatable').DataTable();
            $('.selectpicker').selectpicker();
             $('textarea').summernote();
             $('.ajaxform').ajaxForm({
                success: function(res){
                    if(res.success == true){
                        toastr.success('Operacion realizada con exito', '');
                        __modal.modal('hide');
                       
                    }else{
                        toastr.error('Hubo un problema al procesar la operacion, intentelo mas tarde...', '');
                    }
                 }
           });
        });

     });

     $('.btn-delete').on('click', function(e){
        e.preventDefault();
        swal("En realidad desea deshabilitar este registro?", {
                buttons: ["cancelar", "Aceptar"],}).then((value) => {

                       if(value== true){
                                        var row = $(this).closest('tr');
        $.post($(this).attr('href'),{id:$(this).data('id')}, function(res){
                if(res.success == 1){
                     toastr.success('Se ha deshabilitado el registro', '');
                     row.fadeOut(400, function () {
                        datatable.row(row).remove().draw()
                         });
                 }else{
                    toastr.error('No realizar la operacion', '');
                 }
        });
                       }
                });
      
        //alert('ok');
     });
 });

$('#estado').on('change', function(){
     if($(this).val() == '0'){
       $('#location_hidden').removeClass('hidden');
       $('#ubicacion').prop('required', true);
     }else{
         $('#location_hidden').addClass('hidden');
         $('#ubicacion').prop('required', false);
     }
});
$('.numeric').numeric( { allowEmpty:true, live:true }, function ( val ) {
  console.log ( val );
});

$('tr.info-task').on('click', function(){
 $(this).closest('tr').next('tr').toggle();
});

$('#task-table').on('click', '.btn-asignar',function(e){
    var parenttr = $(this).closest("tr");
      
      //console.log(parenttr);
  $.post($(this).data('url'),{taskid : $(this).data('taskid'), userid : $(this).data('userid')}, function(res){
    if(res.success == true){
      var prev = parenttr.prev('tr');
      prev.find('.alert-warning').removeClass('alert-warning').addClass('alert-success');
       prev.find('i.fa').removeClass('fa-exclamation-triangle').addClass('fa-check-circle animated rotateIn');
      //prev.removeClass('alert-warning');
          
    }
  });
});
function toggle(ele){
   $(ele).toggle();
 }

</script>

</body>

</html>
<?php $this->endPage() ?>