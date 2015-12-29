
            <!-- ====================================================
            ================= CONTENT ===============================
            ===================================================== -->
            <section id="content">

                <div class="page page-forms-common">

                    <div class="pageheader">

                       

                        <div class="page-bar">

                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo base_url()?>index.php/welcome/dashboard"><i class="fa fa-home"></i> Lowry Solutions</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>index.php/welcome/allusers">All Users</a>
                                </li>
                                <li>
                                    <a href="">Add User</a>
                                </li>
                            </ul>
                            
                        </div>

                    </div>


                  


                    <!-- row -->
                    <div class="row">
                        <!-- col -->
                        <div class="col-md-12">



                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font">Add User</h1>
                                   
                                </div>
                                <!-- /tile header -->

                                <!-- tile body -->
                                <div class="tile-body">

                                    <form action="<?php echo base_url()?>index.php/welcome/saveuser" method="post" class="form-horizontal" role="form">

                                        <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">FirstName</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="first_name" id="first_name" required>
                                            </div>
                                        </div>

                                     

                                        <hr class="line-dashed line-full"/>
										
										  <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">LastName</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="last_name" id="last_name" required>
                                            </div>
                                        </div>

                                     

                                        <hr class="line-dashed line-full"/>
										
										  <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" id="email" required>
                                            </div>
                                        </div>
										
										<hr class="line-dashed line-full"/>
										
										  <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">Phone Number</label>
                                            <div class="col-sm-10">
                                                <input type="phonenumber" class="form-control" name="ph_number" id="ph_number" required>
                                            </div>
                                        </div>
										
	                                    <hr class="line-dashed line-full"/>
										
										  <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">UserName</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username" id="username" required>
                                            </div>
                                        </div>
                                        <hr class="line-dashed line-full"/>
										
										  <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="password" id="password" required>
                                            </div>
                                        </div>

                                        <hr class="line-dashed line-full"/>
										
										  <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">CUST-CODE</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="cus_code" id="cus_code" required>
                                            </div>
                                        </div>
                                        <hr class="line-dashed line-full"/>
										
										  <div class="form-group">
                                            <label for="input01" class="col-sm-2 control-label">Role</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="role" id="role" required>
												<option>Select Role</option>
												<option value="2">Normal User</option>
												<option value="3">Super User</option>
												
												</select>
                                            </div>
                                        </div>
                                

                                        <hr class="line-dashed line-full"/>


                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                               <a href="<?php echo base_url()?>index.php/welcome/allusers"><button type="button" class="btn btn-lightred">Cancel</button></a>
                                                <button type="submit" class="btn btn-default">Save changes</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                                <!-- /tile body -->

                            </section>
                            <!-- /tile -->



                        </div>
                        <!-- /col -->
                    </div>
                    <!-- /row -->




                </div>
                
            </section>
            <!--/ CONTENT -->






        </div>
        <!--/ Application Content -->