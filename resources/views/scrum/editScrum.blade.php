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
        <h3>KPI</h3>
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
            <h2>Edit KPI</h2>
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

            <form id="FormIni" method="POST" enctype="multipart/form-data" action="{{url('scrum/update')}}/{{ $edit->id }}">
                  {{ csrf_field() }}

            <table class="table">

               <tr>
                <td width="20%">Project </td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="project_id" onchange="project(this.value)">
                      <option value="" selected="">Select Project</option>
                      <option value="{{ $edit->project_id }}" selected="">{{ $edit->project->project_name or ''}} - {{ $edit->project->division->nama or '' }}</option>

                      @foreach($project as $row)
                        <option value="{{ $row->id }}">{{ $row->project_name }} - {{ $row->division->nama or ''}}</option>
                      @endforeach
                  </select>
                </td>
              </tr>

              <tr>
                <td width="20%">Developer </td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="developer_id" onchange="developer(this.value)">
                      <option value="">Select Developer</option>
                      @foreach($developer as $row)
                        @if($edit->transaction)

                          @if($row->id == $edit->transaction->developer_id)
                            <option value="{{ $row->id }}" selected="">{{ $row->staff_name }}</option>
                          @else

                            <option value="{{ $row->id }}">{{ $row->staff_name }}</option>
                          @endif

                        @else
                          @if($edit->project->division->id == $row->division_id)
                          <option value="{{ $row->id }}">{{ $row->staff_name }}</option>
                          @endif
                        @endif
                      @endforeach
                  </select>
                </td>
              </tr>


              <tr>
                <td width="20%">Analyst </td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="analyst_id">
                      <option value="" selected="">Select Analyst</option>
                      @foreach($analyst as $row)
          
                          @if($row->id == $edit->analyst_id)
                            <option value="{{ $row->id }}" selected="">{{ $row->staff_name }}</option>
                          @else
                            <option value="{{ $row->id }}">{{ $row->staff_name }}</option>
                          @endif
                        
                      @endforeach
                  </select>
                </td>
              </tr>

              <tr>
                <td width="20%">Urgency </td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="urgency_id">
                      <option value="" selected="">Select Urgency</option>
                      @foreach($urgency as $row)
                        @if($row->id == $edit->urgency_id)
                          <option value="{{ $row->id }}" selected="">{{ $row->urgency_name }}</option>
                        @else
                          <option value="{{ $row->id }}">{{ $row->urgency_name }}</option>
                        @endif
                      @endforeach
                  </select>
                </td>
              </tr>

              <tr>
                <td width="20%">Deadline </td>
                <td> 
                  <input style="width: 200px;" type="text" name="deadline" id="filter-date" class="form-control" value="{{ $edit->deadline }}"> 
                </td>
              </tr>

              <tr>
                <td width="20%">Estimate Hour</td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="estimate_id">
                      <option value="" selected="">Select Estimate</option>
                      @foreach($estimate as $row)
                        @if($row->id == $edit->estimate_id)
                          <option value="{{ $row->id }}" selected="">{{ $row->desc }}</option>
                        @else
                          <option value="{{ $row->id }}">{{ $row->desc }}</option>
                        @endif
                      @endforeach
                  </select>
                </td>
              </tr>

              <tr>
                <td width="20%">Subject </td>
                <td> 
                  <input maxlength="50" type="text" name="subject" class="form-control" value="{{ $edit->subject }}"> 
                </td>
              </tr>

              <tr>
                <td width="20%">Status </td>
                <td> 
                  <select style="width: 350px;" class="form-control" name="status_id">
                      <!-- <option value="" selected="">Select Status</option> -->
                      @foreach($status as $row)
                        @if($row->id == $edit->status_id)
                          <option value="{{ $row->id }}" selected="">{{ $row->status_name }}</option>
                        @else
                          <option value="{{ $row->id }}">{{ $row->status_name }}</option>
                        @endif
                      @endforeach
                  </select>
                </td>
              </tr>

              

              <tr>
                <td width="20%">KPI Desc </td>
                <td>  
                  <textarea name="scrum_desc" maxlength="1000" class="form-control" cols="10" rows="5">{{ $edit->scrum_desc }}</textarea>
                </td>
              </tr>

              <tr>
                <td width="20%">Images </td>
                <td> 
                  <input style="width: auto;" maxlength="255" type="file" name="images" class="form-control"> 
                  <br>*ket: bila tidak diisi maka gambar lama akan tetap digunakan
                </td>
              </tr>

              <tr>
                <td width="20%">Notes </td>
                <td>  
                  <textarea name="notes" maxlength="255" class="form-control" cols="10" rows="5">{{ $edit->notes }}</textarea>
                </td>
              </tr>

              <tr>
                <td></td>
                <td><br>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <!-- Jika analis -->
                    <?php 
                      if(\App\Models\user::find(\Auth::user()->id)->role_id == '2')
                      {
                        ?>
                        <a href="{{url('myscrum_analyst')}}" class="btn btn-info">Back</a>
                        <?php
                      }else{
                        ?>
                        <a href="{{url('scrum')}}" class="btn btn-info">Back</a>
                        <?php
                      }
                    ?>
                    
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
        project_id: {
          required: true
        },
        analyst_id: {
          required: true
        },
        // scrum_type_id: {
        //   required: true,
        //   email: true
        // },
        urgency_id: {
          required: true
        },
        subject: {
          required: true
        },
        estimate_id: {
          required: true
        },
        division_id: {
          required: true
        },
        status: {
          required: true
        },
        images: {
          extension: "jpg|jpeg|png|bmp"
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

function project(val){
      $('[name="developer_id"]').find('option').remove()
      // $('[name="analyst_id"]').find('option').remove()

      var newState = new Option('Select Developer','',true,true);
      // var newState2 = new Option('Select Analyst','',true,true);

      $('[name="developer_id"]').append(newState).trigger('change');
      // $('[name="analyst_id"]').append(newState2).trigger('change');

      var project = {!!$project!!}

      $.each(project,function(index,project_data){
        if (project_data.id == val) 
        { 
          var dev = {!!$developer!!}
          // var analis = {!!$analyst!!}

          
          $.each(dev,function(indexs,dev_data){
            if (dev_data.division_id == project_data.division_id) 
            {
              var newState = new Option(dev_data.staff_name, dev_data.id, false,false);
              $('[name=developer_id]').append(newState).trigger('change');
            }
          });

          // $.each(analis,function(indexs,analis_data){
          //   if (analis_data.division_id == project_data.division_id) 
          //   {
          //     var newState2 = new Option(analis_data.staff_name, analis_data.id, false,false);
          //     $('[name=analyst_id]').append(newState2).trigger('change');
          //   }
          // });
          
        }
      });

    console.log(val)
}


function developer(val){
  if($('[name="developer_id"]').val() != '')
  {
      $('[name="status_id"]').find('option').remove()

      // var newState3 = new Option('Select Status','',true,true);

      // $('[name="status_id"]').append(newState3).trigger('change');

      var status = {!!$status!!}

      $.each(status,function(index,status_data){
        if (status_data.status_code == '1' || status_data.status_code == '4') 
        { 
          var newState3 = new Option(status_data.status_name, status_data.id, false,false);
          $('[name=status_id]').append(newState3).trigger('change');
            
        }
      });
  }else{
      $('[name="status_id"]').find('option').remove()

      // var newState3 = new Option('Select Status','',true,true);

      // $('[name="status_id"]').append(newState3).trigger('change');

      var status = {!!$status!!}

      $.each(status,function(index,status_data){
        if (status_data.status_code == '0') 
        { 
          var newState3 = new Option(status_data.status_name, status_data.id, false,false);
          $('[name=status_id]').append(newState3).trigger('change');
        }
      });
  }

}


// $( function() {
//     $( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy h:m:s' });
//   } );

jQuery(document).ready(function () {
      'use strict';

      jQuery('#filter-date, #search-from-date, #search-to-date').datetimepicker();
  });

</script>

@endpush



@endsection
