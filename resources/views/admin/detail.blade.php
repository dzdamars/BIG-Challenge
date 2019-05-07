<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>Detail Admin</title>

    @include('header')

</head>

<body>

    <div id="wrapper">
        @include('navigation')
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detail Admin</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                    <form role="form">
                        <div class="form-group">
                            <label>Display Name</label>
                            <input class="form-control" name="display_name" id="display_name" value="<?= $dataAdmin['display_name']?>">
                            <input class="form-control" type="hidden" name="id_admin" id="id_admin" value="<?= $dataAdmin['id_admin']?>">
                            <p class="help-block">The Name that displayed on the Programs</p>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" name="username" id="username" value="<?= $dataAdmin['username']?>">
                            <p class="help-block">Username for logging in to the program</p>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" name="password" id="password" value="<?= $dataAdmin['password']?>" type="password">
                            <p class="help-block">Password for logging in to the program</p>
                        </div>
                        <div class="form-group">
                            <label>Group</label>
                            <select id="group" class="form-control">
                                <option value="" selected disabled>Select Group</option>
                                <?php foreach($groups as $group){ ?>
                                <option value="<?= $group['id_group'] ?>" <?= ($dataAdmin['id_group'] == $group['id_group'] ? 'selected' : '') ?>><?= $group['group_name']; ?></option>
                                <?php } ?>
                            </select>
                            <p class="help-block">Group for permission control</p>
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
                $.post("/admin/ajaxrequest",
                { 
                    process:'update',
                    id_admin:$('#id_admin').val(),
                    display_name:$("#display_name").val(),
                    group:$("#group").val(),
                    username:$("#username").val(),
                    password:$("#password").val()
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {
                        $.displayInfo(data.message,function(){
                            window.location.href = "<?= url('/admin/list'); ?>";
                        });
                    }
                    // console.log(data);               
                },
                "json");   
            }
        })

        function checkUsername()
        {

        }

        function checkError() 
        {
            var errormsg = "";
            
            if($('#display_name').val() == "")
            {
                errormsg += "Display Name Can't be Empty ! <br/>";
            }

            if($('#username').val() == "")
            {
                errormsg += "Username Can't be Empty ! <br/>";
            }

            if($('#password').val() == "")
            {
                errormsg += "Password Can't be Empty ! <br/>";
            }

            if(!$('#group').val())
            {
                errormsg += "Group Can't be Empty ! <br/>";
            }

            return errormsg;
        }
    </script>
</body>

</html>
