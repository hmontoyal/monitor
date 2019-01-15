
<form action="index.php?r=tickets/ticket/finalizar-ticket-ajax" id="firma-form" method="post">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                 <h2>Formulario de cierre de ticket</h2>
            </div>
        </div>
    <div class="row">
            <div class="form-group col-md-6">
        <label for="nombre">NOMBRE CONTACTO</label>
        <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo $ticket->nombre; ?>">
    </div>
    <div class="form-group col-md-6">
        <label for="email">EMAIL CONTACTO</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $ticket->correo; ?>">
    </div>

    </div>
    <div class="row">
        <div class="col-md-12">
        <label for="signatureparent">FIRMA CONFORME</label>
                      <!--WHERE The canvas is displayed-->
    <div id="signatureparent">
        <div id="signature"></div>
        <button type="reset" class="btn btn-info" id="btnClear">LIMPIAR</button>
        <button type="submit" class="btn btn-success" id="btnSave">GUARDAR Y FINALIZAR</button>
    </div>
        </div>
    </div>
    <!--End Canvas Display-->
    <!--This is where the data value is captured to--> 
    <input type="hidden" id="hiddenSigData" name="hiddenSigData"/>
    <!--For testing only-->
  <!--   <textarea  rows="2" cols="150" id="textSigData" name="textSigData"></textarea> -->
    <!--The image display--> 
<!--     <img id="imgSigData" name="imgSigData"  src=""  /> -->
    
    <!--JavaScript Code change to your liking.-->
    </div>

  
<?= \jberall\signaturedraw\SignatureDraw::widget(); ?>
<input type="hidden" name="ot" value="<?php echo $ticket->ot; ?>" id="ot">
</form>
<script>
    $(document).ready(function() {
        var $sigdiv = $("#signature").jSignature({'UndoButton':false});
        $('#btnClear').click(function(){
            $('#signature').jSignature('clear');
            $('#hiddenSigData').val('');
            // $('#textSigData').val('');
            // $("#imgSigData").attr('src','');
        });
        var emptySig = '';



        $('#firma-form').ajaxForm({
            beforeSubmit : function(arr, $form, options){
                
                var sigData = $('#signature').jSignature('getData','default');
                if($('#signature').jSignature('getData', 'native').length == 0) {
                    toastr.warning('TODOS LOS CAMPOS SON OBLIGATORIOS', 'HUBO UN PROBLEMA AL INTENTAR GUARDAR');
                        return false
                }

                arr.push({name:'hiddenSigData', value: sigData })
                            return true;
             },
             success: function(res){
                if(res.ok == true){
                     toastr.success('Ticket cerrado con exito', '');
                }

             }
        });
       

    })
    
    
</script>
