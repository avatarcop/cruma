@extends('layouts.master')

@section('content')

<?php 
$acl = \App\Models\staffrole::where('id', \Auth::user()->role_id)->where('route_access_list', 'LIKE', '%'.'scrum.myscrum_analyst'.'%')->count(); 
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
        <h3>My KPI (Analyst)</h3>
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
              
            <a class="btn btn-primary" href="{{url('scrum/create')}}">Create KPI</a>
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
                  <th class="dt-head-center">Subject</th>
                  <th class="dt-head-center">Urgency</th>
                  <th class="dt-head-center">Status</th>
                  <th class="dt-head-center">Developer</th>
                  <th class="dt-head-center">Deadline</th>
                  <th class="dt-head-center">Finish</th>
                  <th width="150" class="dt-head-center">Action</th>
                  
              </tr>
              </thead>

              <tfoot>
              <tr>
                  <th>KPI Card No</th>
                  <th>Project</th>
                  <th>Subject</th>
                  <th>Urgency</th>
                  <th>Status</th>
                  <th>Developer</th>
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
                        <td>{{ $row->subject }}</td>
                        <td>{{ $row->urgency->urgency_name or '' }}</td>
                        <td>{{ $row->status->status_name or '' }}</td>
                        <td> {{ $row->transaction->developer_name or '' }}
                        </td>
                        <td>{{ $row->deadline }}</td>
                        <td>{{ $row->finish_time }}</td>

                        <td align="center">
                          @if($row->status_id != '5')
                          <a class="btn btn-primary" href="{{ url('scrum/edit') }}/{{ $row->id }}">Edit</a> 
                            @if($row->status_id != 0)
                            <a onclick="return KonfirmasiDelete()" href="{{url('scrum/delete')}}/{{$row->id}}" type="submit" class="btn btn-danger">Delete</a>
                            @endif
                          @endif

                          <?php 
                          if($row->urgency->urgency_name == 'High') {
                            $class_btn = 'btn btn-danger'; 
                          }elseif($row->urgency->urgency_name == 'Medium') {
                            $class_btn = 'btn btn-warning';
                          }else {
                            $class_btn = 'btn btn-primary';
                          }
                          
                          ?>


                          @if($row->status_id == $status_waiting)
                            
                            <a onclick="return KonfirmasiFinish()" href="{{url('scrum/finetuning')}}/{{$row->id}}" type="submit" class="btn btn-warning">Fine Tuning</a>
                            
                            <a onclick="return KonfirmasiFinish()" href="{{url('scrum/finish')}}/{{$row->id}}" type="submit" class="btn btn-primary">Finish</a>
                            
                            <br><br>

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
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();

      if(dd<10) {
          dd = '0'+dd
      } 

      if(mm<10) {
          mm = '0'+mm
      } 

      today = yyyy + '-' + mm + '-' + dd;
      
      var table = $('#datascrum').DataTable({
          "aLengthMenu": [10, 25, 50, 100],
          "columnDefs" : [
              { 
                type: 'time-date-sort', 
                targets: [7],
              }
          ],
          "order": [[ 7, "desc" ]],
          "dom": 'Bfrtip',
          "buttons": [
              'copy',
              {
                  extend: 'excel',
                  messageTop: "Date: "+today,
                  title: 'Key performance indicator'
              },
              {
                  extend: 'pdf',
                  messageBottom: null,
                  messageTop: "Date: "+today,
                  title: 'Key performance indicator'
              },
              {
                  extend: 'print',
                  messageTop: function () {
                      printCounter++;
   
                      if ( printCounter === 1 ) {
                          return 'This is the first time you have printed this document.';
                      }
                      else {
                          return 'You have printed this document '+printCounter+' times';
                      }
                  },
                  messageBottom: null,
                  messageTop: "Date: "+today,
                  title: 'Key performance indicator'
              }
            ]

          
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
