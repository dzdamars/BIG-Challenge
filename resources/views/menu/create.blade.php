<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>Create Menu</title>

    @include('header')

</head>

<body>

    <div id="wrapper">
        @include('navigation')
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Create Menu</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                    <form role="form">
                        <div class="form-group">
                            <label>Menu Text</label>
                            <input class="form-control" name="text_menu" id="text_menu" placeholder="Masukkan Nama Menu">
                            <p class="help-block">*Teks akan muncul pada Menu Bar</p>
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <input class="form-control" name="icon" id="icon" placeholder="Masukkan Code Ikon">
                            <p class="help-block">*Ikon akan muncul pada menu bar (Silahkan lihat ikon pada web <a href="https://getbootstrap.com/docs/3.3/components/#glyphicons">Glyphicon Bootstrap Icon</a>)</p>
                        </div>
                        <div class="form-group">
                            <label>Link Target</label>
                            <input class="form-control" name="link_menu" id="link_menu" placeholder="Masukkan Target Lokasi Menu">
                            <p class="help-block">*Link ini akan mentarget lokasi menu (Pertama butuh untuk membuat Route dan Controller) ex: "/group/create"</p>
                        </div>
                        <div class="form-group">
                            <label>Level Menu</label>
                            <select id="level_menu" class="form-control">
                                <option value="" selected disabled>Select Level</option>
                                <option value="1">1 (top)</option>
                                <option value="2">2 (first child)</option>
                                <option value="3">3 (second child)</option>
                            </select>
                            <p class="help-block">*Level menu menunjukkan dimana menu itu akan muncul dan memilih parent menu</p>
                        </div>
                        <div class="form-group" id="parent_menu_brakect" style="display: none;">
                            <label>Parent Menu</label>
                            <select id="parent_id_menu" class="form-control">
                                <option value="" selected disabled>Select Parent</option>
                            </select>
                            <p class="help-block">*Silahkan pilih parent Menu</p>
                        </div>
                        <button type="button" id="btnSubmit" class="btn btn-default">Save</button>
                    </form>
                
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    @include('footer')

    <script>
        $('#btnSubmit').unbind();
        $('#btnSubmit').click(function(){
            var error = checkError();

            if (error != "")
            {
                $.displayError(error);
            }
            else
            {
                $.post("/menu/ajaxrequest",
                { 
                    process:'save',
                    icon:$("#icon").val(),
                    text_menu:$("#text_menu").val(),
                    link_menu:$("#link_menu").val(),
                    parent_id_menu:$("#parent_id_menu").val(),
                    level_menu:$("#level_menu").val()
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {
                        $.displayInfo(data.message,function(){
                            window.location.href = "<?= url('/menu/list'); ?>";
                        });
                    }
                    // console.log(data);               
                },
                "json"); 
            }
        })

        $("#level_menu").change(function () {
            $('#parent_id_menu').html('<option value="" selected disabled>Select Parent</option>');
            if(this.value != 1){
                load_parent();
                $('#parent_menu_brakect').show();
            }else{
                $('#parent_menu_brakect').hide();
            }
        });

        function load_parent()
        {
            $.post("/menu/ajaxrequest",
                { 
                    process:'getParent',
                    level_menu:$("#level_menu").val()
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {   
                        $.each(data.parent_list,function(index,value){
                            $('#parent_id_menu').append('<option value="'+value.id_menu+'">'+value.text_menu+'</option>');
                        })
                    }
                    // console.log(data);               
                },
                "json"); 
        }

        function checkError() 
        {
            var errormsg = "";

            if($("#text_menu").val() == "")
            {
                errormsg += "Menu Text Can't be Empty ! <br/>";
            }

            // if($("#link_menu").val() == "")
            // {
            //     errormsg += "Link Target Can't be Empty ! <br/>";
            // }

            if(!$("#level_menu").val())
            {
                errormsg += "Display Name Can't be Empty ! <br/>";
            }

            if($("#level_menu").val() != 1 && !$("#parent_id_menu").val()){
                errormsg += "Parent Menu Can't be Empty ! <br/>";
            }


            return errormsg;
        }
    </script>
</body>

</html>
