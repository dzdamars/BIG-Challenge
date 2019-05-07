<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>Login</title>

    @include('header')
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Welcome To Admin Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <center><img src="../images/images.jpg" style="margin-bottom: 15px;" /></center>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"></span> 
                                        </div>
                                    <input class="form-control" placeholder="Username" id="username" name="username" type="text" autofocus>
                                    <input type="hidden" id="redirect_to" value="<?= $decoded; ?>">
                                </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                         <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock"></span> 
                                        </div>
                                    <input class="form-control" placeholder="Password" id="password" name="password" type="password" value="">
                                </div>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" id="btnLogin" class="btn btn-lg btn-warning btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer')

    <script>
        $('#btnLogin').unbind();
        $('#btnLogin').click(function(){
            $.post("/login/try",
            { 
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
                        window.location.href = "<?= $decoded; ?>";
                    });
                }
                // console.log(data);               
            },
            "json");
        })
    </script>
</body>

</html>
