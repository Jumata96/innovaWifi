@extends('forms.router.router')
@section('content-router')
  
@include('API.router')
<br>
<div class="row">
	<div class="col s12 m12 l12">
                <div class="card-panel-2">
                  <div class="row cabecera" style="margin-left: -0.85rem; margin-right: -0.85rem">                 
                    <div class="col s12 m12 l12">
                      <i class="mdi-av-my-library-books left" style="font-size: 27px"></i>
                      <h4 class="header2" style="margin: 10px 0px;"><b>Registrar Router Mikrotik</b></h4>  
                    </div>
                  </div>
                  <div class="row grey lighten-3" style="height: 52px; padding-top: 7px; margin-left: -0.78rem; margin-right: -0.78rem">
                        <div class="col s12 m12 herramienta">
                          <a href="#mntPost" class="btn-floating waves-effect waves-light grey lighten-5 modal-trigger"><i class="mdi-content-add" style="color: #03a9f4"></i></a>
                          <a class="btn-floating waves-effect waves-light grey lighten-5"><i class="mdi-navigation-check" style="color: #2E7D32"></i></a>
                          <a class="btn-floating waves-effect waves-light  grey lighten-5"><i class="mdi-image-edit" style="color: #0277bd"></i></a>
                          <a class="btn-floating waves-effect waves-light grey lighten-5"><i class="mdi-content-remove" style="color: #dd2c00"></i></a>
                          <a style="margin-left: 6px"></a>   
                          <a href="#informacion" class="btn-floating waves-effect waves-light light-blue lighten-1 tooltipped modal-trigger" data-position="top" data-delay="500" data-tooltip="Ver información del Formulario"><i class="mdi-action-info"></i></a>
                          <a class="dropdown-button btn-floating right waves-effect waves-light grey lighten-5" href="#!" data-activates="dropdown2"><i class="mdi-editor-vertical-align-bottom" style="color: #424242"></i></a>            
                        </div>    

                        @include('forms.pruebas.mntPost')       
                        @include('forms.pruebas.scripts.modalInformacion')        
                  </div>
                                    
                  <div class="row cuerpo">
                    <?php 

                      $bandera = false;

                      if (count($post) > 0) {
                        # code...
                        $bandera = true;
                        $i = 0;
                      }

                    ?>

                  <br>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      
                        <div class="card-content">
                          Existen <?php echo ($bandera)? count($post) : 0; ?> registros. <br><br>
                          <table id={{ ($bandera)? "data-table-simple" : "" }} class="responsive-table display tabla" cellspacing="0">
                               <thead>
                                  <tr>
                                     <th>#</th>
                                     <th>Título</th>
                                     <th>Comentario</th>
                                     <th>Estado</th>
                                     <th>Fecha Creación</th>
                                  </tr>
                               </thead>
                               <?php
                                    if($bandera){                                                           
                                ?>
                               <tfoot>
                                  <tr>
                                     <th>#</th>
                                     <th>Título</th>
                                     <th>Comentario</th>
                                     <th>Estado</th>
                                     <th>Fecha Creación</th>
                                  </tr>
                                </tfoot>

                               <tbody>
                                <tr>
                                  <?php 
                                      foreach ($post as $valor) {
                                      $i++;
                                   ?>
                                     <td><?php echo $i; ?></td>
                                     <td><?php echo $valor->titulo ?></td>
                                     <td><?php echo $valor->comentario ?></td>
                                     <td>
                                        @if($valor->estado == 0)
                                        <div id="u_estado" class="chip center-align" style="width: 70%">
                                            <b>NO DISPONIBLE</b>
                                          <i class="material-icons"></i>
                                        </div>
                                      @else
                                        <div id="u_estado2" class="chip center-align teal accent-4 white-text" style="width: 70%">
                                          <b>ACTIVO</b>
                                          <i class="material-icons"></i>
                                        </div>
                                      @endif
                                     </td>
                                     <td><?php echo $valor->fecha_creacion ?></td>
                                  </tr>
                                  <?php }} ?>
                               </tbody>
                            </table>
                          </div>
                    
                  </div>

                  </div>
                </div>
              </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    

    $("#add").click(function(e){
        e.preventDefault();
        console.log("pruebaaaaaa");

        //var _token = $("input[name=_token]").val();
        var titulo = $("input[name=titulo]").val();
        var comentario = $("input[name=comentario]").val();

        $.ajax({
            url: "{{ url('/post/grabar') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf-token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
           type:'POST',
           url:"{{ url('/post/grabar') }}",
           data:{titulo:titulo, comentario:comentario},

           success:function(data){
              
              var obj = $.parseJSON(data);
              console.log(data);
              
              //console.log(Object.values(data));
              $("#data-table-simple").append("<tr class='post"+ obj[0]['idpost'] +"'>"+
              "<td>"+ obj[0]['idpost'] +"</td>"+
              "<td>"+ obj[0]['titulo'] +"</td>"+
              "<td>"+ obj[0]['comentario'] +"</td>"+
              "<td>"+ obj[0]['estado'] +"</td>"+
              "<td>"+ obj[0]['fecha_creacion'] +"</td></tr>");

              //alert(data.success);
           },

           error:function(){ 
              alert("error!!!!");
        }
        });
  });
</script>
@endsection