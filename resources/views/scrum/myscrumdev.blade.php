@extends('layouts.master')

@section('content')

<?php 
$acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'scrum.myscrum_dev'.'%')->count(); 
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
function KonfirmasiFinish()
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
        <h3>My KPI (Developer)</h3>
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
            <h2>My KPI Lists</h2>
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
              
            
            <br><br>
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}"> 
                {!! session('message.content') !!}
                </div>
            @endif

             <div class="table-responsive">

          <table class="table table-striped table-bordered dataTable" id="datascrum" style="color:#636362">
              <thead>
              <tr>
                  <th class="dt-head-center">KPI Card No</th>
                  <th class="dt-head-center">Project</th>
                  <th class="dt-head-center">Analyst</th>
                  <th class="dt-head-center">Subject</th>
                  <th class="dt-head-center">Urgency</th>
                  <th class="dt-head-center">Status</th>
                  <th class="dt-head-center">Deadline</th>
                  <th class="dt-head-center">Finish Time</th>
                  <th width="50" class="dt-head-center">Action</th>
                  
              </tr>
              </thead>

              <tfoot>
              <tr>
                  <th>KPI Card No</th>
                  <th>Project</th>
                  <th>Analyst</th>
                  <th>Subject</th>
                  <th>Urgency</th>
                  <th>Status</th>
                  <th>Deadline</th>
                  <th>Finish Time</th>
                  <td></td>

              </tr>
              </tfoot>


              <tbody>
                <?php $warna='white'; ?>
                @foreach($scrum as $row)

                    <tr>
                        <td>{{ $row->scrum_card_no }}</td>
                        <td>{{ $row->project->project_name or '' }}</td>
                        <td>{{ $row->analyst->staff_name or '' }}</td>
                        <td>{{ $row->subject }}</td>
                        <td>{{ $row->urgency->urgency_name or '' }}</td>
                        <td>{{ $row->status->status_name or '' }}</td>
                        <td>{{ $row->deadline }}</td>
                        <td>{{ $row->finish_time }}</td>

                        <td align="center">
        
                            @if($row->status_id != $status_waiting and $row->status_id != $status_finish)
                              @if($row->urgency->urgency_name == 'High')
                                <a onclick="return KonfirmasiFinish()" href="{{url('scrum/finishdev')}}/{{$row->id}}" type="submit" class="btn btn-danger">Finish</a>
                              @elseif($row->urgency->urgency_name == 'Medium')
                                <a onclick="return KonfirmasiFinish()" href="{{url('scrum/finishdev')}}/{{$row->id}}" type="submit" class="btn btn-warning">Finish</a>
                              @else
                                <a onclick="return KonfirmasiFinish()" href="{{url('scrum/finishdev')}}/{{$row->id}}" type="submit" class="btn btn-primary">Finish</a>
                              @endif
                            @endif

                         
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
      var table = $('#datascrum').DataTable({
          "aLengthMenu": [10, 25, 50, 100],
          "columnDefs" : [
              { 
                type: 'time-date-sort', 
                targets: [7],
              }
          ],
          "order": [[ 7, "desc" ]]
          
      });


      $('#datascrum tfoot th').each(function () {
          var title = $(this).text();
          $(this).html('<input type="text" placeholder="" />');
          var table = $('#datascrum').DataTable();
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
