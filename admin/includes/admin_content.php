
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>
                        <?php
                                // $user =  new User();
                                // $user->username = "Test2";
                                // $user->password = "Test123";
                                // $user->first_name = "Test";
                                // $user->last_name = "Test Last";
                                // $user->save();
                                $photo = Photo::find_all();
                                foreach ($photo as  $value) {
                                    echo $value->description . "<br>";
                                }
                                echo INCLUDES_PATH;
                         ?>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
