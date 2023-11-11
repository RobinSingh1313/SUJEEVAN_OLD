<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="waves-effect waves-dark" href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                   
                    
                    <li>
                        <a href="#" class="waves-effect waves-dark"><i class="fa fa-sitemap"></i> Blog<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <!-- <li>
                                <a href="<?php echo site_url('admin/add-category-form');?>">Add Blog Category</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/categories-list');?>">Blog Categories List</a>
                            </li> -->
                            <li>
                                <a href="<?php echo site_url('admin/add-post-page');?>">Add Blog Post</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/posts-list');?>">Blog Posts List</a>
                            </li>
                        </ul>
                    </li>

                    

                    


                    <li>
                        <a class="waves-effect waves-dark" href="<?php echo site_url('admin/contacts-list');?>"><i class="fa fa-phone"></i> Contacts</a>
                    </li>
                    
                      <li>
                        <a class="waves-effect waves-dark" href="<?php echo site_url('admin/subscribers-list');?>"><i class="fa fa-envelope"></i> Subscribers</a>
                    </li>

                   

                    <li>
                        <a class="waves-effect waves-dark" href="<?php echo site_url('admin/schedule-demos-list');?>"><i class="fa fa-calendar"></i> Appointments List</a>
                    </li>


                   

                    <li>
                        <a href="#" class="waves-effect waves-dark"><i class="fa fa-gear"></i> Settings<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('admin/change-password');?>">Change Password</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/logout');?>">Logout</a>
                            </li>
                        </ul>
                    </li>
                   
                </ul>

            </div>

        </nav>