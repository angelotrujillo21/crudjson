<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD JSON</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/style.css">
</head>
 

<body>
    <div class="page-loader">
        <div class="loader-dual-ring"></div>
    </div>
    <div class="container">

        <div class="col-12 offset-0 col-md-8 offset-md-2 my-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Crud productos</h3>
                </div>
                <div class="panel-body ">

                    <form id="form-productos" action="">
                        <div class="row">
                        <div class="col-12">
                            <h5 id="titulo" class="mb-0 py-2">Crear Registro</h5>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese nombre" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="cantidad" class="control-label">Cantidad</label>
                                    <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="Ingrese cantidad" required>
                                </div>
                            </div>


                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="precio" class="control-label">Precio</label>
                                    <input type="number" class="form-control" name="precio" id="precio" placeholder="Ingrese precio" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="stock" class="control-label">Stock</label>
                                    <input type="number" class="form-control" name="stock" id="stock" readonly placeholder="Ingrese stock" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 text-right">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="row">
                        <table id="table" class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">Acciones</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>



                </div>
            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

<script>
    $(document).ready(function() {
        
        setTimeout(function () {
            $(".page-loader").fadeOut();
        }, 500);

        fncDrawTable();

        $("#form-productos").trigger("reset");
        $("#form-productos").data("id", -1);

        $("#form-productos").on("submit", function(event) {

            event.preventDefault();
            var id        = $("#form-productos").data("id");
            var nombre    = $("#nombre").val();
            var cantidad  = $("#cantidad").val();
            var precio    = $("#precio").val();
            var stock     = cantidad * precio;

            var jsnData = {
                id          : id,
                type        : id == -1 ? 'crear' : 'actualizar',
                nombre      : nombre,
                cantidad    : cantidad,
                precio      : precio,
                stock       : stock
            };

            // console.log(jsnData);
            // return;
            ajax(jsnData,(aryResponse)=>{

                if(aryResponse.success){
                    toastr.success(aryResponse.message);
                    $("#form-productos").trigger("reset");
                    $("#titulo").html("Crear Registro");
                    $("#form-productos").data("id",-1);
                    fncDrawTable();
                 }else{
                    toastr.success(aryResponse.error);
                }

            });

        });

        $("#precio,#cantidad").on("keyup blur",function(){
            var precio   = $("#precio").val();
            var cantidad = $("#cantidad").val();
            var stock    = cantidad * precio;
            $("#stock").val(stock);
        });

    });
    // Funciones auxiliares 

    function fncDrawTable (){
        var sHtml = ``;
        var jsnData = {type:"obtenerDatos"};
        ajax(jsnData,(aryResponse) =>{
            if(aryResponse.success){

                var data = aryResponse.data;

                if(data.length > 0){

                    var nId   = 0;
                    
                    data.forEach(element => {
                        sHtml += `<tr>
                                    <td>
                                        <a href="javascript:;" class="text-primary" onclick="edit(${nId});" ><i class="fas fa-pencil-alt"></i></a>  
                                        <a href="javascript:;" class="text-danger" onclick="fncDelete(${nId});" ><i class="fas fa-trash"></i> </a>  
                                    </td>
                                    <td>${element.nombre}</td>
                                    <td>${element.cantidad}</td>
                                    <td>${element.precio}</td>
                                    <td>${element.stock}</td>
                                 </tr>`;
                                 nId++;

                    });

                }
                $("#table").find("tbody").html(sHtml);


            } else {
                toastr.success(aryResponse.error);
            }
        });
    }

    function fncDelete(id){
        if(confirm("¿Estas seguro de eliminar el registro?")){
            var jsnData = {
                id : id,
                type:"eliminar"
            };
            ajax(jsnData,(aryResponse)=>{
                if (aryResponse.success) {
                    fncDrawTable(); 
                    toastr.success(aryResponse.message);
                } else {
                    toastr.success(aryResponse.error);
                }
            });
        }
    }

    function edit(id){
        
        var jsnData = {
            id   : id,
            type :"editar"
        };

        $("#form-productos").data("id", id);

        ajax(jsnData,(aryResponse)=>{
            if (aryResponse.success) {

                var data = aryResponse.data;
                $("#titulo").html("Editar Registro");
                $("#nombre").val(data.nombre);
                $("#cantidad").val(data.cantidad);
                $("#precio").val(data.precio);
                $("#stock").val(data.stock);

                
            } else {
                toastr.success(aryResponse.error);
            }
        });
        
    }

    function fncOcultarLoader() {
        jQuery(".page-loader").fadeOut();
    }

    function fncMostrarLoader() {
        jQuery(".page-loader").fadeIn();
    }

    function ajax(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "ajax.php",
            data: jsnData,
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>


</html>