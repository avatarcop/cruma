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
        <h3>Project</h3>
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
            <h2>Edit Project</h2>
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

            <form id="FormIni" method="POST" action="{{url('project/update')}}/{{ $edit->id }}">
                  {{ csrf_field() }}
            <table class="table">

              <tr>
                <td width="20%">Project Code </td>
                <td> 
                  <input readonly="" style="width: 200px;" type="text" name="project_code" class="form-control" value="{{ $edit->project_code }}"> 
                </td>
              </tr>

              <tr>
                <td width="20%">Project Name </td>
                <td> 
                  <input style="width: 200px;" maxlength="20" type="text" name="project_name" class="form-control" value="{{ $edit->project_name }}"> 
                </td>
              </tr>

              <tr>
                <td width="20%">Client </td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="client_id">
                      <option value="">Select Client</option>
                      @foreach($client as $row)
                          @if($row->id == $edit->client_id)
                            <option value="{{ $row->id }}" selected="">{{ $row->client_name }}</option>
                          @else
                            <option value="{{ $row->id }}">{{ $row->client_name }}</option>
                          @endif
                      @endforeach
                  </select>
                </td>
              </tr>

              <tr>
                <td width="20%">Division </td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="division_id">
                      <option value="" selected="">Select Division</option>
                      @foreach($division as $row)
                          @if($row->id == $edit->division_id)
                            <option value="{{ $row->id }}" selected="">{{ $row->nama }}</option>
                          @else
                            <option value="{{ $row->id }}">{{ $row->nama }}</option>
                          @endif
                      @endforeach
                  </select>
                </td>
              </tr>


              <tr>
                <td width="20%">Status </td>
                <td> 
                  <select style="width: 150px;" class="form-control" name="status">
                      
                      @if($edit->status == '1')
                        <option value="1" selected="">Active</option>
                        <option value="0">Inactive</option>
                      @elseif($edit->status == 0)
                        <option value="1">Active</option>
                        <option value="0" selected="">Inactive</option>
                      @else
                        <option value="" selected="">Select Status</option>  
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                      @endif
                      
                  </select>
                </td>
              </tr>

              <tr>
                <td></td>
                <td><br>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <a href="{{url('project')}}" class="btn btn-info">Back</a>
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
        project_name: {
          required: true
        },
        client_id: {
          required: true
        },
        division_id: {
          required: true
        },

        status: {
          required: true
        },
        
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
</script>

@endpush



@endsection
