<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />
    <title>Create Admin</title>

    @include('header')

</head>

<body>

    <div id="wrapper">
        @include('navigation')
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Create Admin</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                    <form role="form">
                        <div class="form-group">
                            <label>Display Name</label>
                            <input class="form-control" name="display_name" id="display_name" placeholder="Masukkan Nama">
                            <p class="help-block">*Nama Akan Muncul pada Admin</p>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" name="username" id="username" placeholder="Masukkan Username">
                            <p class="help-block">*Username untuk login</p>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" name="password" id="password" type="password" placeholder="Masukkan Password">
                            <p class="help-block">*Password untuk login</p>
                        </div>
                        <div class="form-group">
                            <label>Group</label>
                            <select id="group" class="form-control">
                                <option value="" selected disabled>Select Group</option>
                                <?php foreach($groups as $group){ ?>
                                <option value="<?= $group['id_group'] ?>"><?= $group['group_name']; ?></option>
                                <?php } ?>
                            </select>
                            <p class="help-block">*Grup untuk permission control</p>
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
                    process:'cekUsernameSave',
                    username:$("#username").val()
                },
                function(data){
                    console.log(data);
                    if(data.status == "error")
                    {
                        $.displayError('Username Has Been Taken !');
                    }
                    else
                    {
                        $.post("/admin/ajaxrequest",
                        { 
                            process:'save',
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
