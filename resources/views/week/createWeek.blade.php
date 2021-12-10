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
        <h3>Week</h3>
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
            <h2>Create Week</h2>
            
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              
            <div class="table-responsive">

            <form id="FormIni" method="POST" action="{{url('week/store')}}" autocomplete="off">
                  {{ csrf_field() }}
            <table class="table">
              <tr>
                <td width="20%">Week </td>
                <td> 
                  <select name="week" class="form-control" style="width: 160px;">
                    <option value="">Select Week</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td width="20%">Start Date</td>
                <td> 
                  <input style="width: 200px;" type="text" name="tgl_awal" id="filter-date" class="form-control">  
                </td>
              </tr>

              <tr>
                <td width="20%">End Date</td>
                <td> 
                  <input style="width: 200px;" type="text" name="tgl_akhir" id="filter-date" class="form-control">  
                </td>
              </tr>

              <tr>
                <td></td>
                <td><br>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <a href="{{url('week')}}" class="btn btn-info">Back</a>
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
        tgl_awal: {
          required: true,
        },
        tgl_akhir: {
          required: true
        },
        
     },  
    
    messages: {
        tgl_awal : {
          required: "Start Date is required."
        },
        tgl_akhir : {
          required: "End Date is required."
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


jQuery(document).ready(function () {
      'use strict';

      jQuery('#filter-date, #search-from-date, #search-to-date').datetimepicker();
  });
</script>

@endpush



@endsection
