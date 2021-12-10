@extends('layouts.master')

@section('content')

<style type="text/css">
    tfoot {
        display: table-header-group;
    }

    .error {
      color: red;
      background-color: #FFF;

    }

    .textcenter
    {
      position: center;
    }

    


</style>

<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Staff Role</h3>
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          <div class="input-group">
            <!-- <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Go!</button>
            </span> -->
          </div>
        </div>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Create Staff Role</h2>
            <!-- <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul> -->
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              
            <div class="table-responsive">

            <form id="FormIni" method="POST" action="{{url('staffrole/store')}}">
                  {{ csrf_field() }}
            <table class="table">

              <tr>
                <td width="20%">Role Code </td>
                <td> 
                  <input style="width: 200px;" type="text" maxlength="10" name="role_code" class="form-control"> 
                </td>
              </tr>

              <tr>
                <td>Role Name </td>
                <td> 
                  <input style="width: 200px;" type="text" maxlength="10" name="role_name" class="form-control"> 
                </td>
              </tr>

              <tr>
                <td>Access Information </td>
                <td> 
                  <?php 
                            $routeCollection = Route::getRoutes();
                            $new             = [];
                            $groups          = [];
                            foreach ($routeCollection as $value) {

                                if(($value->getName() != '') or (!$value)){
                                    if(strpos($value->getName(), 'front-user') === false){
                                        
                                        if (in_array(explode(".",$value->getName())[0], $groups)) {
                                            
                                        } else {

                                            array_push($groups, explode(".",$value->getName())[0]);
                                        }                            
                                        array_push($new, $value->getName());
                                    }
                                }                            
                            } 
                            asort($groups);
                            foreach ($groups as $key => $group) {
                                # code...
                                echo '<label class="switch"><input type="checkbox" class="skip" onclick="checkclass(\''.$group.'\')" id="'.$group.'"/><span></span><em> '.$group.'</em> </label></br>';
                                foreach ($routeCollection as $row) {
                                    if(explode(".",$row->getName())[0] == $group){

                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="switch" style="margin-left:25px;"><input type="checkbox" name="routelist[]" class="'.$group.' skip" value="'.$row->getName().'"/><span></span> '.$row->getName().'</label></br>';
                                    }
                                }
                                echo '</br>';
                            }
                            
                        ?> 
                </td>
              </tr>

              <tr>
                <td></td>
                <td><br>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <a href="{{url('staffrole')}}" class="btn btn-info">Back</a>
                </td>

              </tr>
                    
            </table>

            </div>   


          </div>
        </div>
      </div>
    </div>
  </div>

@push('scripts')

<script type="text/javascript">
$(document).ready(function() {

  $('#FormIni').validate({
    rules: {
        role_code: {
          required: true,
          remote: "check_rolecode"
        },
        role_name: {
          required: true
        },
        
     },  

     messages: {
        role_code : {
          remote: "Role code already taken."
        } 
      
      },
  

      errorElement: "em",
      errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block alert_error" );

        if ( element.prop( "type" ) === "checkbox" ) {
          error.insertAfter( element.parent( "label" ) );
        } else {
          error.insertAfter( element );
        }
      },
      highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
      },
      unhighlight: function (element, errorClass, validClass) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
      }

  });   

});

function checkclass(data)
    {   
        if($( "#"+data ).is(':checked'))
        {                    
            $( "."+data ).not(this).prop( "checked", true );        
        } 
        else 
        {                    
            $( "."+data ).not(this).prop( "checked", false );        
        }        

    }
</script>

@endpush



@endsection
