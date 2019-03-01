<script>
    function add_product()
    {
        $.ajax({
            url: $("#baseurl").val() + 'buy/productlist',
            data: {},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    $(`#price`).val('');
                    $('#width').val('');
                    $('#height').val('');
                    var x = document.getElementById("codeproduct");
                    x.options.length = 0;
                    for (i = 0;i<data.length;i++) {
                        x = document.getElementById("codeproduct");
                        var option = document.createElement("option");
                        option.text = data[i].name+"--"+data[i].code;
                        option.value = data[i].id;
                        x.add(option);
                    }
                    $('#hided').show();
                    $('#quantity').text("Anchor");
                    $('#codeproduct').select2('val','');
                    $("#add_modal").modal();

                } else {
                }
            }
        });
    }
  
    function edit_tempproduct(id) {
        $.ajax({
            url: $("#baseurl").val() + 'buy/productlist',
            data: {},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    var x = document.getElementById("codeproduct_e");
                    x.options.length = 0;
                    for (i = 0;i<data.length;i++) {
                        x = document.getElementById("codeproduct_e");
                        var option = document.createElement("option");
                        option.text = data[i].code+"--"+data[i].name;
                        option.value = data[i].id;
                        x.add(option);
                    }

                    $.ajax({
                        url: $("#baseurl").val() + 'buy/tempproductlist',
                        data: {'id':id},
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                            if (data) {
                                $('#codeproduct_e').select2('val', data['productId']);
                                $(`#pricee`).val(data['price']);
                                $('#widthe').val(data['width']);
                                $('#heighte').val(data['height']);
                                $('#tempid').text(data['id']);
                                $("#edit_modal").modal();
                                bbb();
                            } else {
                            }
                        }
                    });
                } else {
                }

            }
        });


    }
    function bbb() {
        var sel = document.getElementById('codeproduct_e');
        var id = sel.options[sel.selectedIndex].value;
        $.ajax({
            url: $("#baseurl").val() + 'buy/productprice',
            data: {'id':id},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    for (i = 0; i < data.length; i++) {
                        if (data[i].type=='1')
                        {
                            $('#hidede').hide();
                            $('#quantitye').text("Cantidad");
                        }
                        else if (data[i].type=='0')
                        {
                            $('#hidede').show();
                            $('#quantitye').text("Anchor");
                        }
                    }
                }
            }
        });

    }
    function delete_tempproduct(id) {
        $('#tempproduct_del').attr('href','javascript:tempproduct_del('+id+')');
        $("#productdel_modal").modal();
    }
    function tempproduct_del(id) {
        $.ajax({
            url: $("#baseurl").val() + 'buy/tempproductdelete',
            data: {'id': id,'chitNum':$('#tempchitnum').val()},
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#productdata').html(data);
                alert("Deleted Successfully!");
                $('#productdel_modal').modal('hide');
            }
        });
    }
     $(document).ready(function() {
         $('.date').datepicker({
             format: 'yyyy-mm-dd'
         });
         $('#search_btn').hide();
         $('#search_str').hide();
         $('#codeproduct').change(function(){
           var sel = document.getElementById('codeproduct');
           var id = sel.options[sel.selectedIndex].value;
           $.ajax({
                url: $("#baseurl").val() + 'buy/productprice',
                data: {'id':id},
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        for (i = 0; i < data.length; i++) {
                            $('#price').val(data[i].buyPrice);
                            if (data[i].type=='1')
                            {
                                $('#hided').hide();
                                $('#quantity').text("Cantidad");
                            }
                            else if (data[i].type=='0')
                            {
                                $('#hided').show();
                                $('#quantity').text("Anchor");
                            }
                        }
                    }
                }
            });
        });
         $('#codeproduct_e').change(function(){
             var sel = document.getElementById('codeproduct_e');
             var id = sel.options[sel.selectedIndex].value;
             $.ajax({
                 url: $("#baseurl").val() + 'buy/productprice',
                 data: {'id':id},
                 type: 'POST',
                 dataType: 'json',
                 success: function (data) {
                     if (data) {
                         for (i = 0; i < data.length; i++) {
                             $('#pricee').val(data[i].buyPrice);
                             if (data[i].type=='1')
                             {
                                 $('#hidede').hide();
                                 $('#quantitye').text("Cantidad");
                             }
                             else if (data[i].type=='0')
                             {
                                 $('#hidede').show();
                                 $('#quantitye').text("Anchor");
                             }
                         }
                     }
                 }
             });
         });
       $('#product_save').click(function(){
             var sel = document.getElementById('codeproduct');
             var id = sel.options[sel.selectedIndex].value;
             var price = $('#price').val();
             var width = $('#width').val();
             var height = $('#height').val();
             var chitnum = $('#chitNum').val();
             var tempchitnum = $('#tempchitnum').text();
             if ($('#quantity').text() == "Cantidad"){
                 height = '1';
             }
             if(id==''||price==''||width==''||height=='')
             {
                 alert('Por favor revise su entrada');
                 return;
             }
            if(id!=''&price!=''&width!=''&height!='') {
                $.ajax({
                    url: $("#baseurl").val() + 'buy/productsavetemp',
                    data: {'id': id, 'price': price, 'width': width, 'height': height, 'tempchitnum': tempchitnum},
                    type: 'POST',
                    dataType: 'html',
                    success: function (data) {
                        $('#productdata').html(data);
                        $("#add_modal").modal("hide");
                    }
                });
            }
         });
         $('#editproduct_save').click(function() {
             var sel = document.getElementById('codeproduct_e');
             var productId = sel.options[sel.selectedIndex].value;
             var price = $('#pricee').val();
             var id = $('#tempid').text();
             var width = $('#widthe').val();
             var height = $('#heighte').val();
             var tempchitnum = $('#tempchitnum').text();
             if(productId==''&price==''&width==''&height=='')
             {
                 alert('Por favor revise su entrada');
             }
             if(id!=''&price!=''&width!=''&height!='') {
                 $.ajax({
                     url: $("#baseurl").val() + 'buy/productupdatetemp',
                     data: {'id':id,'productId': productId, 'price': price, 'width': width, 'height': height, 'tempchitnum': tempchitnum},
                     type: 'POST',
                     dataType: 'html',
                     success: function (data) {
                         $('#productdata').html(data);
                         $("#edit_modal").modal("hide");
                     }
                 });
             }
         });
         $('#chitsave').click(function(){
             var sel = document.getElementById('warehouse');
             var warehouseId = sel.options[sel.selectedIndex].value;
             var shipcpm = $('#shipcpm').val();
             var buydate = $('#buydate').val();
             var tracking = $('#tracking').val();
             var waypay = $('#waypay').val();
             var chitNum = $('#tempchitnum').text();
             sel = document.getElementById('provider');
             var provider = sel.options[sel.selectedIndex].value;
             if(shipcpm==''&buydate==''&tracking==''&waypay=='')
             {
                 alert('Por favor revise su entrada');
             }
             if(shipcpm!=''&buydate!=''&tracking!=''&waypay!='')
             {
                 $.ajax({
                     url: $("#baseurl").val() + 'buy/chitsave',
                     data: {'chitNum':chitNum,'warehouseId':warehouseId,'shipcpm':shipcpm,'buydate':buydate,'tracking':tracking,'waypay':waypay,'provider':provider},
                     type: 'POST',
                     dataType: 'json',
                     success: function (data) {
                         if(data){
                             alert("Numero guardado :"+data['maxchit']);
                             parent.location.href ="<?php echo base_url() ?>buy";
                         }
                     }
                 });
             }
         });

     });
</script>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green">
            <i class="icon-pin font-green"></i>
            <span class="caption-subject bold uppercase"> Compras </span>
        </div>
        <div class="form-actions noborder pull-right">
            <button type="button" class="btn blue" id="chitsave">Crear</button>
        </div>
    </div>
    <div class="portlet-body form">
        <form role="form">
            <div class="form-body">
                <div  style = "display: none" class="form-group form-md-line-input form-md-floating-label col-md-4">
                    <input type="text" class="form-control form-control edited" readonly="" value="<?php if(count($chitnum)>0)
                    {
                        foreach($chitnum as $chitnum)
                        {
                            if ($chitnum['chitnum']=='')
                            { echo'1';}
                            else {
                                echo $chitnum['chitnum'];
                            }
                        }
                    } else
                        {
                            echo '1';
                        }?>" id="chitNum">
<!--                    <label for="form_control_1">#</label>-->

                </div>
                <div class="form-group form-md-line-input form-md-floating-label has-info col-md-4">
                    <select class="form-control edited select2me" id="warehouse">
                        <?php if(count($warehouse) == 0) {?>
                            <option value="">None</option>
                        <?php } ?>
                        <?php foreach($warehouse as $warehouse){ ?>
                        <option value="<?php echo $warehouse['id'];?>" selected=""><?php echo $warehouse['name'];?>
                        <?php }?>
                    </select>
                    <label for="form_control_1">Sucursal</label>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label col-md-4" >
                    <input id="buydate" class="form-control form-control edited input-medium date-picker date" size="16" type="text"  value=""  data-date-format="yyyy-mm-dd">
                    <span class="help-block"> Select date </span>
                </div>
                <?php foreach($userdata as $userdata) {?>
                <div class="form-group form-md-line-input form-md-floating-label has-error col-md-4">
                    <input type="text" class="form-control" disabled="" id="">
                    <label for="form_control_1"> Personal:
                        <?php echo $userdata['name']; ?> </label>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                    <div class="form-control form-control-static">  <?php echo $userdata['email']; ?>  </div>
                    <label for="form_control_1">Personal correo electrónico</label>
                </div>
                <?php }?>
                <div class="form-group form-md-line-input form-md-floating-label col-md-4" >
                    <input type="text" class="form-control" id="shipcpm" value="">
                    <label for="shipcpm"> Transpotista </label>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                    <input type="text" class="form-control" id="tracking">
                    <label for="form_control_1">Guia</label>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label has-success col-md-4">
                    <input type="text" class="form-control" id="waypay">
                    <label for="form_control_1">Forma pago</label>
                </div>
                <div class="form-group form-md-line-input   form-md-floating-label has-info col-md-4">
                    <select class="form-control  col-md-12 edited select2me" id="provider">
                        <?php $i = 0; foreach($provider as $provider) {$i++; ?>
                            <option value="<?php echo $provider['pid'];?>" selected=""><?php echo $provider['name'];?></option>
                        <?php }?>
                    </select>
                    <label for="provider">Proveedor</label>
                </div>
            </div>
        </form>
        <div class="portlet-body">
            <div class="table-toolbar pull-right">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a id="addproduct" href="javascript:add_product()" class="btn green">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
			<div style="overflow: auto; width: 100%;">
            <table class="table table-striped table-hover table-bordered" id="productdata">
                <thead>
                <tr>
                    <th> # </th>
                    <th> Cantidad </th>
                    <th> Producto </th>
                    <th> Precio </th>
                    <th> Ancho </th>
                    <th> Alto </th>
                    <th> M 2 </th>
                    <th> -- $ -- </th>
                    <th> Editar </th>
                    <th> Borrar </th>
                </tr>
                </thead>
                <tbody>
<!--                --><?php //$i = 0; foreach($temp_product as $temp_product) {$i++;?>
<!--                    <tr >-->
<!--                        <td>--><?php //echo ($maxid+$i);?><!--</td>-->
<!--                        <td>--><?php //echo $temp_product['quantity']?><!--</td>-->
<!--                        <td>--><?php //echo $temp_product['pname']?><!--</td>-->
<!--                        <td>--><?php //echo $temp_product['price']?><!--</td>-->
<!--                        <td>--><?php //echo $temp_product['width']?><!--</td>-->
<!--                        <td>--><?php //echo $temp_product['height']?><!--</td>-->
<!--                        <td>--><?php //echo $temp_product['square']?><!--</td>-->
<!--                        <td>--><?php //echo $temp_product['dollar']?><!--</td>-->
<!--                        <td><a class="fa fa-edit" href="javascript:edit_tempproduct(--><?php //echo $temp_product['id']?><!--)">Editar</a></td>-->
<!--                        <td><a class="fa fa-trash-o" href="javascript:delete_tempproduct(--><?php //echo $temp_product['id']?><!--)">Borrar</a></td>-->
<!--                    </tr>-->
<!--                --><?php //}?>
<!--                <tr>-->
<!--                    <td colspan="3">-->
<!--                        Recuento : --><?php //echo $buyproduct[0]['count']; ?>
<!--                    </td>-->
<!--                    <td colspan="3">-->
<!--                        Suma M2: --><?php //echo $buyproduct[0]['square']; ?>
<!--                    </td>-->
<!---->
<!--                    <td colspan="3">-->
<!--                        Suma $: --><?php //echo $buyproduct[0]['dollar']; ?>
<!--                    </td>-->

<!--                </tr>-->
                </tbody>
             </table>
			</div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-sm in" id="productdel_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Borrar</h4>
            </div>
            <div class="modal-body">
                <p>¿Realmente quieres borrar esta ficha?</p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn blue" id="tempproduct_del">Borrar</a>
                <button type="button" class="btn btn-green" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="add_modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Añadir Producto</h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="reg-body">
                                <form action="">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input form-md-floating-label has-info  ">
                                            <select class="form-control edited select2me" id="codeproduct">
                                                <option value="" selected=""><?php echo '';?></option>
                                            </select>
                                            <label for="form_control_1">Clave & Producto</label>
                                        </div>
                                        <div class="col-md-4" >
                                            <label for="price">Precio:</label>
                                            <input type="text" class="form-control" id="price" placeholder="" name="price">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="width" id="quantity">Ancho:</label>
                                            <input type="text" class="form-control" id="width" placeholder="" name="width">
                                        </div>
                                        <div class="col-md-4" id="hided">
                                            <label for="height">Alto:</label>
                                            <input type="text" class="form-control" id="height" placeholder="" name="height">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                <button type="button" id="product_save" class="btn green">Añadir</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="edit_modal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Editar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="reg-body">
                                <form action="">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input form-md-floating-label  ">
                                            <select class="form-control edited select2me" id="codeproduct_e">
                                                <option value="" selected=""><?php echo '';?></option>
                                            </select>
                                            <label for="form_control_1">Clave & Producto</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pricee">Precio:</label>
                                            <input type="text" class="form-control" id="pricee" placeholder="" name="pricee">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="widthe" id="quantitye">Ancho:</label>
                                            <input type="text" class="form-control" id="widthe" placeholder="" name="widthe">
                                        </div>
                                        <div class="col-md-4" id="hidede">
                                            <label for="heighte" >Alto:</label>
                                            <input type="text" class="form-control" id="heighte" placeholder="" name="heighte">
                                            <label id="tempid" data-id="" style="display:none"></label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                <button type="button" id="editproduct_save" class="btn green">Añadir</button>
            </div>
        </div>
    </div>
</div>