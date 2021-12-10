@extends('layouts.master')

@section('content')
<script>
function buka()
{
    var data = $('#grafikformid').serialize();

     $.ajax({
        type : "POST",
        url  : "{{route('index.grafik')}}",
        data : data,

        success: function(response)
        {
            // PROGRAMMER
            if(typeof response.datagraph_programmer !== 'undefined' && response.datagraph_programmer.length > 0)
            {
              var programmer = response.datagraph_programmer
              var data02 = [['y', 'label', 'indexLabel']];

              var analyst = response.datagraph_analyst
              var data01 = [['y', 'label', 'indexLabel']];

              console.log('pro '+programmer)

              $.each(programmer, function (data, value) {
                data02.push([value.y, value.label, value.indexLabel ]);
              });

              var arr = $.makeArray(data02);
              console.log('asd '+data02)
              //Better to construct options first and then pass it as a parameter
              var options2 = {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                  text: "Kinerja Programmer periode "+response.periode,                
                  fontColor: "black"
                },  
                axisY: {
                  tickThickness: 0,
                  lineThickness: 0,
                  valueFormatString: " ",
                  gridThickness: 0                    
                },
                axisX: {
                  tickThickness: 0,
                  lineThickness: 0,
                  labelFontSize: 18,
                  labelFontColor: "black"        
                },
                data: [{
                  indexLabelFontSize: 12,
                  toolTipContent: "<span style=\"color:#62C9C3\">{indexLabel}:</span> <span style=\"color:#CD853F\"><strong>{y}</strong></span>",
                  indexLabelPlacement: "inside",
                  indexLabelFontColor: "white",
                  // indexLabelFontWeight: 600,
                  indexLabelFontFamily: "Verdana",
                  // color: "green",
                  type: "bar",
                  dataPoints: programmer
                  // [
                  //   { y: 21, label: "21%", indexLabel: "Video" },
                  //   { y: 25, label: "25%", indexLabel: "Dining" },
                  //   { y: 33, label: "33%", indexLabel: "Entertainment" },
                  //   { y: 36, label: "36%", indexLabel: "News" },
                  //   { y: 42, label: "42%", indexLabel: "Music" },
                  //   { y: 49, label: "49%", indexLabel: "Social Networking" },
                  //   { y: 50, label: "50%", indexLabel: "Maps/ Search" },
                  //   { y: 55, label: "55%", indexLabel: "Weather" },
                  //   { y: 61, label: "61%", indexLabel: "Games" }
                  // ]
                }]
              };

              document.getElementById("chartProgrammer").style.display = "block";
              document.getElementById("ket").style.display = "block";
              $("#chartProgrammer").CanvasJSChart(options2);

              //----------------------------------------------------------------------

              // ANALIS
              $.each(analyst, function (data, value) {
                data01.push([value.y, value.label.toString(), value.indexLabel.toString() ]);
              });

              var arr = $.makeArray(data01);
              console.log('asd '+data01)
              //Better to construct options first and then pass it as a parameter
              var options = {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                  text: "Kinerja Analis periode "+response.periode+'',                
                  fontColor: "black"
                },  
                axisY: {
                  tickThickness: 0,
                  lineThickness: 0,
                  valueFormatString: " ",
                  gridThickness: 0                    
                },
                axisX: {
                  tickThickness: 0,
                  lineThickness: 0,
                  labelFontSize: 18,
                  labelFontColor: "black"        
                },
                data: [{
                  indexLabelFontSize: 12,
                  toolTipContent: "<span style=\"color:#62C9C3\">{indexLabel}:</span> <span style=\"color:#CD853F\"><strong>{y}</strong></span>",
                  indexLabelPlacement: "inside",
                  indexLabelFontColor: "white",
                  // indexLabelFontWeight: 600,
                  indexLabelFontFamily: "Verdana",
                  color: "purple",
                  type: "bar",
                  dataPoints: analyst
                  // [
                  //   { y: 21, label: "21%", indexLabel: "Video" },
                  //   { y: 25, label: "25%", indexLabel: "Dining" },
                  //   { y: 33, label: "33%", indexLabel: "Entertainment" },
                  //   { y: 36, label: "36%", indexLabel: "News" },
                  //   { y: 42, label: "42%", indexLabel: "Music" },
                  //   { y: 49, label: "49%", indexLabel: "Social Networking" },
                  //   { y: 50, label: "50%", indexLabel: "Maps/ Search" },
                  //   { y: 55, label: "55%", indexLabel: "Weather" },
                  //   { y: 61, label: "61%", indexLabel: "Games" }
                  // ]
                }]
              };

              document.getElementById("chartAnalyst").style.display = "block";
              document.getElementById("ket").style.display = "block";
              $("#chartAnalyst").CanvasJSChart(options);
            }else{
              document.getElementById("chartProgrammer").style.display = "none";
              document.getElementById("chartAnalyst").style.display = "none";
              document.getElementById("ket").style.display = "none";
            }
        }
      });
}

</script>
<div class="">
    <div class="page-title">
      <div class="title">
        <h3>Aplikasi Pengolahan Key Performance Indicator Karyawan</h3>
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
            <h2>Key Perfomance Indicator</h2>
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
              <form name="grafikform" id="grafikformid" method="post">
                {{ csrf_field() }}
                <table width="auto">
                  <tr>
                    <td width="200" height="auto">Week</td>
                    <td>
                      <select name="week" class="form-control">
                      @foreach($week as $k)
                        <option value="{{ $k->id }}">Week {{ $k->week }} ({{ $k->tgl_awal }} - {{ $k->tgl_akhir }})</option>
                      @endforeach  
                      </select>
                    </td>
                  </tr>
                    <tr height="50" valign="bottom">
                      <td></td>
                      <td><button type="button" onclick="buka()" name="tes" class="btn btn-primary">Cari</button></td>
                    </tr>
                </table>
              </form>
              <br>

              <div id="chartProgrammer" style="height: 300px; width: 100%;"></div>
              <br>
              <hr width="100%" size="2">
              <br>
              <div id="chartAnalyst" style="height: 300px; width: 100%;"></div>
              <br>
              <div id="ket">
              Keterangan : <br>
              Warna merah berarti kinerja kurang bagus<br>
              Warna hijau berarti kinerja bagus
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</script>

@endsection
