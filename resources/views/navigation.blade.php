        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="../images/images.jpg" width="70" style="margin: 5px 10px;float: left;"/><a class="navbar-brand" href="{{ url('/home') }}" >PT Bisnis Integrasi Global</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?= $display_name; ?>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li> -->
                        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li> -->
                        <!-- <li class="divider"></li> -->
                        <li><a id="btnLogout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php foreach($menuNav as $topMenu){ ?>
                        <li>
                            <a href="<?= ($topMenu['link_menu'] == "" ? "#" : url('/').$topMenu['link_menu']) ?>">
                                <?php if($topMenu['icon'] != ""){ ?>
                                    <i class="<?= $topMenu['icon']; ?>"></i>
                                <?php } ?>

                                <?= $topMenu['text_menu']?>
                                
                                <?php if(isset($topMenu['child'])){ ?>
                                    <span class="fa arrow"></span>
                                <?php } ?>
                            </a>

                            <?php if(isset($topMenu['child'])){ ?>
                            <ul class="nav nav-second-level">
                                <?php foreach($topMenu['child'] as $firstChild){ ?>
                                <li>
                                    <a href="<?= ($firstChild['link_menu'] == "" ? "#" : url('/').$firstChild['link_menu']) ?>">
                                        <?php if($firstChild['icon'] != ""){ ?>
                                            <i class="<?= $firstChild['icon']; ?>"></i>
                                        <?php } ?>

                                        <?= $firstChild['text_menu']?> 
                                        <?php if(isset($firstChild['grandchild'])){ ?>
                                            <span class="fa arrow"></span>
                                        <?php } ?>
                                    </a>
                                    <?php if(isset($firstChild['grandchild'])){ ?>
                                    <ul class="nav nav-third-level">
                                        <?php foreach($firstChild['grandchild'] as $grandchild){ ?>
                                        <li>
                                            <a href="<?= $grandchild['link_menu']; ?>">
                                                <?php if($grandchild['icon'] != ""){ ?>
                                                    <i class="<?= $grandchild['icon']; ?>"></i>
                                                <?php } ?>

                                                <?= $grandchild['text_menu']; ?>
                                            </a>
                                        </li>
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
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <script>
        $('#btnLogout').unbind();
        $('#btnLogout').click(function(){
            $.displayConfirm('Are You Sure Want to Logout ?',function(){
                window.location.href = "<?= url('/'); ?>"+"/login/logout";
            })
        })
        </script>