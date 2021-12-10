@extends('layouts.master')

@section('content')

<?php 
$acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'staff.index'.'%')->count(); 
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
        <h3>Staff</h3>
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
            <h2>List Staff</h2>
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
              
            <a class="btn btn-primary" href="{{url('staff/create')}}">Create Staff</a>
            <br><br>
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}"> 
                {!! session('message.content') !!}
                </div>
            @endif

             <div class="table-responsive">

          <table class="table table-striped table-bordered dataTable" id="datastaff" style="color:#636362">
              <thead>
              <tr>
                  <th class="dt-head-center">Name</th>
                  <th class="dt-head-center">Avatar</th>
                  <th class="dt-head-center">Email</th>
                  <th class="dt-head-center">Role</th>
                  <th class="dt-head-center">Division</th>
                  <th class="dt-head-center">Created At</th>
                  <th width="150" class="dt-head-center">Action</th>
                  
              </tr>
              </thead>

              <tfoot>
              <tr>
                  <th>Name</th>
                  <th>Avatar</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Division</th>
                  <th>Created At</th>
                  <td></td>

              </tr>
              </tfoot>


              <tbody>
                @foreach($staff as $row)
                    <tr>
                        <td>{{ $row->staff_name }}</td>
                        <td align="center"><img src="{{ asset('assets/images') }}/{{ $row->avatar }}" style="max-width: 100px;height: auto"></td>
                        <td>{{ $row->user->email or '' }}</td>
                        <td>{{ $row->user->staffrole->role_name or '' }}</td>
                        <td>{{ $row->division->nama or '' }}</td>
                        <td>{{ $row->created_at }}</td>

                        <td align="center">
                        <a style="width: 70px;" class="btn btn-primary" href="{{ url('staff/edit') }}/{{ $row->id }}">Edit</a> 
                        <a onclick="return KonfirmasiDelete()" href="{{url('staff/delete')}}/{{$row->id}}" type="submit" class="btn btn-danger">Delete</a>
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
      var table = $('#datastaff').DataTable({
          "aLengthMenu": [10, 25, 50, 100],
          "order": [2,"desc"],
          "columnDefs": [
              {
                  "targets": [[2, "desc"]],
                  "visible": false,
                  "hidden": true,
                  "sort": 'timestamp'
              }
          ],
          
      });


      $('#datastaff tfoot th').each(function () {
          var title = $(this).text();
          $(this).html('<input type="text" placeholder="" />');
          var table = $('#datastaff').DataTable();
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
