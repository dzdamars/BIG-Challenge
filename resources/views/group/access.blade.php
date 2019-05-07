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
                        <h1 class="page-header">Authorized Access Group</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Group Name</label>
                            <input class="form-control" name="group_name" id="group_name" value="<?= $dataGroup['group_name']?>" disabled>
                            <input type="hidden" value="<?= $dataGroup['id_group']; ?>" id="id_group" name="">
                            <!-- <p class="help-block">Group Name for grouping the admin</p> -->
                        </div>
                        <div class="form-group">
                            <label>Menu Access</label>
                            <div id="html" class="demo">
                                <ul>
                                    <?php foreach($menu as $topMenu){ ?>
                                    <li id="<?= $topMenu['id_menu'];?>" ><?= $topMenu['text_menu']?>
                                        <?php if(isset($topMenu['child'])){ ?>
                                        <ul class="nav nav-second-level">
                                            <?php foreach($topMenu['child'] as $firstChild){ ?>
                                            <li id="<?= $firstChild['id_menu'];?>"><?= $firstChild['text_menu']?> 
                                                <?php if(isset($firstChild['grandchild'])){ ?>
                                                <ul class="nav nav-third-level">
                                                    <?php foreach($firstChild['grandchild'] as $grandchild){ ?>
                                                    <li id="<?= $grandchild['id_menu'];?>"><?= $grandchild['text_menu']; ?></li>
                                                    <?php } ?>
                                                </ul>
                                                <?php } ?>
                                                <!-- /.nav-third-level -->
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>
                                        <!-- /.nav-second-level -->
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <input type="hidden" id="penampung">
                        <button type="button" id="btnSubmit" class="btn btn-default">Save</button>
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
        $('#btnSubmit').unbind();
        $('#btnSubmit').click(function(){
            $.displayConfirm('Are You Sure the Permission for menu is correct ?',function(){
                // var selectedMenuStringify = ;
                var selectedMenu = JSON.parse($('#penampung').val());
                
                $.post("/group/ajaxrequest",
                { 
                    
                    process:"update_menu_access",
                    id_menus:selectedMenu,
                    id_group:$('#id_group').val()
                },
                function(data){
                    if(data.status == "error")
                    {
                        $.displayError(data.message);
                    }
                    else
                    {
                        $.displayInfo(data.message,function(){
                            window.location.href = "<?= url('/') ?>/group/list";
                        });
                    }
                    // console.log(data);               
                },
                "json");
            })
        })

        $('#html').jstree({
            "checkbox" : {
              "keep_selected_style" : false
            },
            "plugins" : [ "checkbox" ]
        });

        $('#html').on('changed.jstree', function(e, data) {
            var i, j, r = [];
            /* console.log(JSON.stringify(data, null, 2)) */;
            nodesOnSelectedPath = [...data.selected.reduce(function (acc, nodeId) {
                var node = data.instance.get_node(nodeId);
                return new Set([...acc, ...node.parents, node.id]);
            }, new Set)];
            
            // alert('Selected: ' + nodesOnSelectedPath.join(', '));
            // console.log('Selected: ' + nodesOnSelectedPath.join(', '));
            nodesOnSelectedPath = nodesOnSelectedPath.filter(id => id !== '#');
            $('#penampung').val(JSON.stringify(nodesOnSelectedPath));
        });

        $(document).ready(function(){
            <?php 
            foreach ($menu_raw as $key => $value) { 
                if(in_array($value['id_menu'], $has_access)){
            ?>
                $("#html").jstree("check_node", "<?= $value['id_menu']; ?>");
            <?php
                }else{
            ?>
                $("#html").jstree("uncheck_node", "<?= $value['id_menu']; ?>");
            <?php
                }            
             } ?>
        })
    </script>
</body>

</html>
