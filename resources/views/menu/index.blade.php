<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>List Menu</title>

    @include('header')

</head>

<body>

    <div id="wrapper">
        @include('navigation')
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">List Menu</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">ID Menu</th>
                                    <th width="20%">Menu Text</th>
                                    <th width="30%">Icon</th>
                                    <!-- <th width="10%">Link Target</th> -->
                                    <th width="10%">Level Menu</th>
                                    <th width="10%">Parent Menu</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dataMenus as $dataMenu){ ?>
                                <tr>
                                    <td><?= $dataMenu->id_menu; ?></td>
                                    <td><?= $dataMenu->text_menu; ?></td>
                                    <td><i class="<?= $dataMenu->icon; ?>"></i></td>
                                    <td>
                                        <?php if($dataMenu->level_menu == 1){ ?>
                                        TOP
                                        <?php }elseif($dataMenu->level_menu == 2){ ?>
                                        First Child
                                        <?php }elseif($dataMenu->level_menu == 3){ ?>
                                        Second Child
                                        <?php } ?>
                                    </td>
                                    <td><?= $dataMenu->parent_text_menu; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            <a href="<?= url('/')?>/menu/detail/<?= $dataMenu->id_menu; ?>" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                                            <button data-id="<?= $dataMenu->id_menu; ?>" type="button" class="btn btn-danger btnDelete"><i class="glyphicon glyphicon-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    @include('footer')

    <script>
        $('.btnDelete').unbind();
        $('.btnDelete').click(function(){
            var id_menu_delete = $(this).attr('data-id');
            $.displayConfirm('Are You Sure Want To DELETE this Data ?',function(){
                $.post("/menu/ajaxrequest",
                { 
                    
                    process:"delete",
                    id_menu:id_menu_delete
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {
                        $.displayInfo(data.message,function(){
                            window.location.href = "<?= url('/') ?>/menu";
                        });
                    }
                    // console.log(data);               
                },
                "json");
            })
        })
    </script>
</body>

</html>
