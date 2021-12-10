<div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home </a>
                    <!-- <ul class="nav child_menu"> -->
                      <!-- <li><a href="{{ url('/') }}">Home</a></li> -->
                    <!-- </ul> -->
                  </li>

                  <?php 
                    $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'scrum.scrummarket'.'%')->count(); 
                    $superadmin = \App\Models\staffrole::find(\Auth::user()->role_id)->role_code;
                    ?> 
                    @if($acl != 0 )
                  <li><a><i class="fa fa-edit"></i> KPI Market <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                      <li><a href="{{ url('scrummarket') }}">KPI Market Lists</a></li>
                     
                    </ul>
                  </li>
                  @endif

                  <?php 
                    $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'scrum.myscrum_dev'.'%')->count(); 
                  ?> 
                  @if($acl != 0)
                  <li><a><i class="fa fa-edit"></i> My KPI (Developer) <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                      <li><a href="{{ url('myscrum_dev') }}">My KPI Dev</a></li>
                     
                    </ul>
                  </li>
                  @endif

                  <?php 
                    $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'scrum.myscrum_analyst'.'%')->count(); 
                  ?> 
                    @if($acl != 0)
                  <li><a><i class="fa fa-edit"></i> My KPI (Analyst) <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                      <li><a href="{{ url('myscrum_analyst') }}">My KPI Analyst</a></li>
                     
                    </ul>
                  </li>
                  @endif


                  <?php 
                  $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'scrum.index'.'%')->count(); 
                  ?>
                  @if($acl != 0 || $superadmin == 'superadmin') 
                  <li><a><i class="fa fa-edit"></i> Master Table <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('scrum') }}">KPI</a></li>
                     

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'division.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('division') }}">Division</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'client.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('client') }}">Client</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'urgency.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('urgency') }}">Urgency</a></li>
                      @endif
                      
                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'estimate.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('estimate') }}">Estimate</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'staffrole.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('staffrole') }}">Staff Role</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'status.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('status') }}">Status</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'project.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('project') }}">Project</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'staff.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('staff') }}">Staff</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'transaction.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('transaction') }}">Transaction</a></li>
                      @endif

                      <?php 
                      $acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'week.index'.'%')->count(); 
                      ?> 
                      @if($acl != 0 || $superadmin == 'superadmin')
                      <li><a href="{{ url('week') }}">Week</a></li>
                      @endif

                    </ul>
                  </li>
                  @endif

                  

                  <!-- <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="form.html">General Form</a></li>
                      <li><a href="form_advanced.html">Advanced Components</a></li>
                      <li><a href="form_validation.html">Form Validation</a></li>
                      <li><a href="form_wizards.html">Form Wizard</a></li>
                      <li><a href="form_upload.html">Form Upload</a></li>
                      <li><a href="form_buttons.html">Form Buttons</a></li>
                    </ul>
                  </li> -->
                    
                </ul>
              </div>
              <div class="menu_section">
                <!-- <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul> -->
              </div>