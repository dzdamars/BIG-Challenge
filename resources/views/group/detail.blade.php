<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>Detail Group</title>

    @include('header')

</head>

<body>

    <div id="wrapper">
        @include('navigation')
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detail Group</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                    <form role="form">
                        <div class="form-group">
                            <label>Group Name</label>
                            <input class="form-control" name="group_name" id="group_name" value="<?= $dataGroup['group_name']?>">
                            <input type="hidden" value="<?= $dataGroup['id_group']; ?>" id="id_group" name="">
                            <p class="help-block">Group Name for grouping the admin</p>
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
                $.post("/group/ajaxrequest",
                { 
                    process:'update',
                    id_group:$('#id_group').val(),
                    group_name:$("#group_name").val()
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {
                        $.displayInfo(data.message,function(){
                            window.location.href = "<?= url('/group/list'); ?>";
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
            
            if($('#group_name').val() == "")
            {
                errormsg += "Group Name Can't be Empty ! <br/>";
            }

            return errormsg;
        }
    </script>
</body>

</html>
