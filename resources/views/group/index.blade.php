<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>List Group</title>

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
                        <h1 class="page-header">List Group</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">ID Group</th>
                                    <th width="20%">Group Name</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dataGroups as $dataGroup){ ?>
                                <tr>
                                    <td><?= $dataGroup['id_group']; ?></td>
                                    <td><?= $dataGroup['group_name']; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            <a href="<?= url('/')?>/group/access/<?= $dataGroup['id_group']; ?>" class="btn btn-success"><i class="glyphicon glyphicon-lock"></i></a>
                                            <a href="<?= url('/')?>/group/detail/<?= $dataGroup['id_group']; ?>" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                                            <button data-id="<?= $dataGroup['id_group']; ?>" type="button" class="btn btn-danger btnDelete"><i class="glyphicon glyphicon-trash"></i></button>
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
            var id_group_delete = $(this).attr('data-id');
            $.displayConfirm('Are You Sure Want To DELETE this Data ?',function(){
                $.post("/group/ajaxrequest",
                { 
                    
                    process:"delete",
                    id_group:id_group_delete
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {
                        $.displayInfo(data.message,function(){
                            window.location.href = "<?= url('/') ?>/group";
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
