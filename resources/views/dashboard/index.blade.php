<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/images.jpg" />

    <title>Dashboard</title>

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
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <center><img src="../images/images.jpg" style="margin-bottom: 20px;" /></center>
                    <h3>About Us</h3>
                    <p class="dropcap">Founded in 2013, PT BIG has been a fast-growing IT consulting, custom software development and IT managed support services, helping organizations use technology to increase productivity, reduce costs, minimize risks and grow strategically.</p>
                            <p>Our primary focus is to develop strategic long-term relationships with our clients. The dedication to long term partnerships has allowed us to help many leading organizations achieve their business goals and grow significantly through the effective use of technology.</p>
                  
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    @include('footer')
</body>

</html>
