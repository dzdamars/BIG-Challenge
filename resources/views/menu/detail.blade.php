<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>Detail Menu</title>

    @include('header')

</head>

<body>

    <div id="wrapper">
        @include('navigation')
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detail Menu</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                    <form role="form">
                        <div class="form-group">
                            <label>Menu Text</label>
                            <input class="form-control" name="text_menu" id="text_menu" value="<?= $dataMenu['text_menu']; ?>">
                            <input type="hidden" id="id_menu" value="<?= $dataMenu['id_menu']; ?>">
                            <p class="help-block">The Text that will displayed on the Menu Bar</p>
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <input class="form-control" name="icon" id="icon" value="<?= $dataMenu['icon']; ?>">
                            <p class="help-block">Icon that will show on the menu bar (take a look on the <a href="https://getbootstrap.com/docs/3.3/components/#glyphicons">cheatcode</a>)</p>
                        </div>
                        <div class="form-group">
                            <label>Link Target</label>
                            <input class="form-control" name="link_menu" id="link_menu" value="<?= $dataMenu['link_menu']; ?>">
                            <p class="help-block">The link that will targeted by the menu (need to create the controller first)</p>
                        </div>
                        <div class="form-group">
                            <label>Level Menu</label>
                            <select id="level_menu" class="form-control">
                                <option value="" selected disabled>Select Level</option>
                                <option value="1" <?= ($dataMenu['level_menu'] == '1' ? 'selected' : '') ?>>1 (top)</option>
                                <option value="2" <?= ($dataMenu['level_menu'] == '2' ? 'selected' : '') ?>>2 (first child)</option>
                                <option value="3" <?= ($dataMenu['level_menu'] == '3' ? 'selected' : '') ?>>3 (second child)</option>
                            </select>
                            <p class="help-block">Level menu that determine where it will shown and whether it will have a parent menu or not</p>
                        </div>
                        <div class="form-group" id="parent_menu_brakect" style="display: none;">
                            <label>Parent Menu</label>
                            <select id="parent_id_menu" class="form-control">
                                <option value="" selected disabled>Select Parent</option>
                            </select>
                            <p class="help-block">Parent menu that will inherit from</p>
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
        $(document).ready(function(){
            <?php if($dataMenu['level_menu'] != 1){?>
            $('#level_menu').trigger('change');
            $('#parent_menu_brakect').show();
            <?php } ?>
        })

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
                    process:'update',
                    id_menu:$('#id_menu').val(),
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
                            if("<?=$dataMenu['parent_id_menu'] ?>" == value.id_menu){
                                $('#parent_id_menu').append('<option value="'+value.id_menu+'" selected>'+value.text_menu+'</option>');    
                            }else{
                                $('#parent_id_menu').append('<option value="'+value.id_menu+'">'+value.text_menu+'</option>');
                            }
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
