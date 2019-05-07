<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>List Admin</title>

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
                        <h1 class="page-header">List Admin</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">ID Admin</th>
                                    <th width="20%">Username</th>
                                    <th width="30%">Display Name</th>
                                    <th width="10%">Group</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dataAdmins as $dataAdmin){ ?>
                                <tr>
                                    <td><?= $dataAdmin->id_admin; ?></td>
                                    <td><?= $dataAdmin->username; ?></td>
                                    <td><?= $dataAdmin->display_name; ?></td>
                                    <td><?= $dataAdmin->group_name; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            <a href="<?= url('/')?>/admin/detail/<?= $dataAdmin->id_admin; ?>" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                                            <?php if($logged_in != $dataAdmin->id_admin){ ?>
                                            <button data-id="<?= $dataAdmin->id_admin; ?>" type="button" class="btn btn-danger btnDelete"><i class="glyphicon glyphicon-trash"></i></button>
                                            <?php } ?>
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
            var id_admin_delete = $(this).attr('data-id');
            $.displayConfirm('Are You Sure Want To DELETE this Data ?',function(){
                $.post("/admin/ajaxrequest",
                { 
                    
                    process:"delete",
                    id_admin:id_admin_delete
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {
                        $.displayInfo(data.message,function(){
                            window.location.href = "<?= url('/') ?>/admin";
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
