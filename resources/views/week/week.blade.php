@extends('layouts.master')

@section('content')

<?php 
$acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'week.index'.'%')->count(); 
$superadmin = \App\Models\staffrole::find(\Auth::user()->role_id)->role_code;
?> 
@if($acl != 0 || $superadmin == 'superadmin')

<style type="text/css">
    tfoot {
        display: table-header-group;
    }

    /*select[name="dataimage_length"] {
        width: 75px;
    }

    div[class="dataTables_length"] {
        width: 300px;
    }*/

    /*select[class="dataTables_length label"] {  width: 175px; }*/
    .printBorder {
      border-width:1px;
      border-style:solid;
      border-color:black;
      }
    }

    .textcenter
    {
      position: center;
    }


</style>

<script type="text/javascript">
function KonfirmasiDelete()
    {
       var x = confirm("Are you sure ?");
       if(x)
        { return true; }  
      else { return false; }
          
    }
</script>

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
            <h2>List Week</h2>
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
              
            <a class="btn btn-primary" href="{{url('week/create')}}">Create Week</a>
            <br><br>
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}"> 
                {!! session('message.content') !!}
                </div>
            @endif

             <br>
             @foreach (['danger', 'warning', 'success', 'info'] as $key)
               @if(Session::has($key))
                   <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
               @endif
              @endforeach

             <div class="table-responsive">

          <table class="table table-striped table-bordered dataTable" id="dataweek" style="color:#636362">
              <thead>
              <tr>
                  <th class="dt-head-center">Week</th>
                  <th class="dt-head-center">Month</th>
                  <th class="dt-head-center">Year</th>
                  <th class="dt-head-center">Start Date</th>
                  <th class="dt-head-center">End Date</th>
                  <th class="dt-head-center">Created At</th>
                  <th width="150" class="dt-head-center">Action</th>
                  
              </tr>
              </thead>

              <tfoot>
              <tr>
                  <th>Week</th>
                  <th>Month</th>
                  <th>Year</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Created At</th>
                  <td></td>

              </tr>
              </tfoot>

              <tbody>
                @foreach($week as $row)
                    <tr>
                        <td>{{ $row->week }}</td>
                        <td>{{ $row->bulan }}</td>
                        <td>{{ $row->tahun }}</td>
                        <td>{{ $row->tgl_awal }}</td>
                        <td>{{ $row->tgl_akhir }}</td>
                        <td>{{ $row->created_at }}</td>

                        <td align="center">
                        <a class="btn btn-primary" href="{{ url('week/edit') }}/{{ $row->id }}">Edit</a> 
                        <a onclick="return KonfirmasiDelete()" href="{{url('week/delete')}}/{{$row->id}}" type="submit" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach

              </tbody>
          </table>

          </div>   


          </div>
        </div>
      </div>
    </div>
  </div>

@push('scripts')

<script type="text/javascript"> //reload page ajax

  $(document).ready(function () {
      var table = $('#dataweek').DataTable({
          "aLengthMenu": [10, 25, 50, 100],
          "order": [5,"desc"]
          
      });


      $('#dataweek tfoot th').each(function () {
          var title = $(this).text();
          $(this).html('<input type="text" placeholder="" />');
          var table = $('#dataweek').DataTable();
          table.columns().every(function () {
              var that = this;

              $('input', this.footer()).on('keyup change', function () {
                  if (that.search() !== this.value) {
                      that
                              .search(this.value)
                              .draw();
                  }
              });
          });


      });


});

</script>

@endpush

@else
        <h3 align="center">Sorry, You don't have access permission to this page !</h3>
    @endif

@endsection
