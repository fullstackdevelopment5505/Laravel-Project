@extends('layouts.main')

@section('title')
Dashboard
@endsection

@section('css_files')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css" rel="stylesheet">
@endsection

@section('custom_css')
<style type="text/css">
    
.nw-card{
    position: relative;
    box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
    background-image: linear-gradient(to right, #934598, #884b9d, #6366b6, #4b71bd, #4072ba);
    min-height: 100px;
    border-radius: 10px;
    border: 2px solid #b865d5;
}
.nw-card2{
    position: relative;
    box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
    background-image: linear-gradient(to right, #2e3238 , #bdbdbc);
    min-height: 100px;
    border-radius: 10px;
    border: 2px solid #53575d;
}
.nw-card .fa,.nw-card2 .fa{
    color: #fff;
    font-size: 51px;
    float: left;
}
.nw-card h2,.nw-card2 h2{
    font-size: 33px;
    color: #fff;
    text-align: right;
} 
.nw-card p,.nw-card2 p{
    color: #fff;
}   
.section .card{

    background-color: #fff;
    border: none;
    position: relative;
    border-radius: 7px;
    box-shadow: 0 2px 17px 2px rgb(0, 0, 0,0.04);
}
.section .card .card-body {
    padding: 30px;
}
.section .text-muted {
    color: #b0b6b7 !important;
}
.section .card .card-footer {
    background-color: transparent;
    border: none;
    padding: 15px 30px;
    border-top: 1px solid #e6eaea;
}
.text-success {
    color: #22e840 !important;
}
.section h4{
   font-size: 1.5rem;
}
.section2 h3{
   font-size: 1.75rem;
}
.section .text-center,.section2 .text-center{
   text-align: center !important;
}
.text-danger {
    color: #ff473d !important;
}
.section2 .card,.section3 .card,.section4 .card,.section5 .card{
       background-color: #fff;
    border: none;
    position: relative;
    border-radius: 7px;
    box-shadow: 0 2px 17px 2px rgb(0, 0, 0,0.04);
    flex: 1 1 auto;
    -ms-flex: 1 1 auto;
}
.section2 .card .card-header,.section3 .card .card-header,.section4 .card .card-header,.section5 .card .card-header {
   background-color: transparent;
    border-bottom-color: #e6eaea;
    line-height: 30px;
    -ms-flex-item-align: center;
    -ms-grid-row-align: center;
    align-self: center;
    width: 100%;
}
.section2 .card .card-header h4,.section3 .card .card-header h4,.section4 .card .card-header h4,.section5 .card .card-header h4 {
    font-size: 20px;
    font-weight: 400;
    letter-spacing: 0;
    margin: 0;
    line-height: 30px;
}
.section2 .card .card-body,.section3 .card .card-body,.section4 .card .card-body,.section5 .card .card-body {
    padding: 30px;
        flex: 1 1 auto;
}
.h-250 {
    height: 284px !important;
}
.h-6 {
    height: 6px;
}
.chart-dropshadow {
    -webkit-filter: drop-shadow(-6px 9px 4px rgba(0, 0, 0, .1));
    filter: drop-shadow(-6px 9px 4px rgba(0, 0, 0, .1));
}
.row-deck>.col, .row-deck>[class*='col-']{
   display: -ms-flexbox;
    display: flex;
    -ms-flex-align: stretch;
    /* align-items: stretch; */
}
</style>
@endsection

@section('content')
            <section class="section"> 
               <div class="row">   
                  <div class="col-lg-6 col-xl-3 col-md-6 col-12"> 
                     <div class="card"> 
                        <div class="card-body text-center"> 
                           <p class="text-muted mb-1"> 
                           Today sales 
                           </p>
                           <div> 
                              <h4 class="mt-2 mb-3">$2,345</h4> 
                              <div> 
                                 <span id="dynamicsparkline"></span>
                              </div> 
                           </div> 
                        </div> 
                        <div class="card-footer"> 
                           <div class="float-left"> 
                              <p class="mb-0">
                                 <span>
                                    <i class="fa fa-arrow-circle-o-up ml-1 text-success"></i> 2.5%
                                 </span> last month
                              </p>
                           </div> 
                           <div class="float-right"> 
                              <i class="fa fa-line-chart"></i> 
                           </div> 
                        </div> 
                     </div> 
                  </div>

                  <div class="col-lg-6 col-xl-3 col-md-6 col-12"> 
                     <div class="card"> 
                        <div class="card-body text-center"> 
                           <p class="text-muted mb-1"> 
                           Today Orders 
                           </p>
                           <div> 
                              <h4 class="mt-2 mb-3">$245</h4> 
                              <div> 
                                 <span id="piesparkline"></span>
                              </div> 
                           </div> 
                        </div> 
                        <div class="card-footer"> 
                           <div class="float-left"> 
                              <p class="mb-0">
                                 <span>
                                    <i class="fa fa-arrow-circle-o-down ml-1 text-danger"></i> 4%
                                 </span> last month
                              </p>
                           </div> 
                           <div class="float-right"> 
                              <i class="fa fa-shopping-cart "></i> 
                           </div> 
                        </div> 
                     </div> 
                  </div>

                  <div class="col-lg-6 col-xl-3 col-md-6 col-12"> 
                     <div class="card"> 
                        <div class="card-body text-center"> 
                           <p class="text-muted mb-1"> 
                           Sales Revenue
                           </p>
                           <div> 
                              <h4 class="mt-2 mb-3">$245</h4> 
                              <div> 
                                 <span id="linesparkline"></span>
                              </div> 
                           </div> 
                        </div> 
                        <div class="card-footer"> 
                           <div class="float-left"> 
                              <p class="mb-0">
                                 <span>
                                    <i class="fa fa-arrow-circle-o-down ml-1 text-danger"></i> 4%
                                 </span> last month
                              </p>
                           </div> 
                           <div class="float-right"> 
                              <i class="fa fa-signal"></i> 
                           </div> 
                        </div> 
                     </div> 
                  </div>

                  <div class="col-lg-6 col-xl-3 col-md-6 col-12"> 
                     <div class="card"> 
                        <div class="card-body text-center"> 
                           <p class="text-muted mb-1"> 
                           Total Profit
                           </p>
                           <div> 
                              <h4 class="mt-2 mb-3">$245</h4> 
                              <div> 
                                 <span id="discretesparkline"></span>
                              </div> 
                           </div> 
                        </div> 
                        <div class="card-footer"> 
                           <div class="float-left"> 
                              <p class="mb-0">
                                 <span>
                                    <i class="fa fa-arrow-circle-o-up ml-1 text-success"></i> 4%
                                 </span> last month
                              </p>
                           </div> 
                           <div class="float-right"> 
                              <i class="fa fa-dollar "></i> 
                           </div> 
                        </div> 
                     </div> 
                  </div>
               </div>
            </section>
            
            <section class="section2">
               <div class="row row-deck">
                  <div class="col-lg-6 col-xl-5 col-md-12 col-12">
                     <div class="card">
                        <div class="card-header text-left">
                           <h4>Revenue</h4>
                        </div>
                        <div class="card-body">
                           <div class="mb-3">
                              <div class="text-center">
                                 <div class="mb-2">
                                    <h6 class=" mb-1">Total Revenue</h6>
                                    <h3 class=" mb-2">15,730</h3>
                                    <span class="text-success"><i class="zmdi zmdi-long-arrow-up zmdi-hc-lg mr-2"></i><span>+24%</span></span><span class="text-muted ml-2">From Last Month</span> 
                                 </div>
                              </div>
                           </div>
                           <canvas id="barChart" class="chartjs-render-monitor h-250" width="481" height="438"></canvas>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6 col-xl-7 col-md-12 col-12">
                     <div class="card overflow-hidden">
                        <div class="card-header text-left">
                           <h4>Statistics</h4>
                        </div>
                        <div class="card-body">
                              <div id="map" style="width: 100%; height: 400px;"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>

            <section class="section3">
               <div class="row row-deck">
                  <div class="col-xl-4 col-lg-6 col-sm-12 col-sm-12">
                     <div class="card ">
                        <div class="card-header text-left">
                           <h4>Sales Status</h4>
                        </div>
                        <div class="card-body">
                           <canvas id="pieChart" class="chartjs-render-monitor chart-dropshadow" width="362" height="357" ></canvas>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-6 col-sm-12 col-sm-12">
                     <div class="card">
                        <div class="card-header text-left">
                           <h4 class="card-title">Browsing Status</h4>
                        </div>
                        <div class="card-body text-left">
                           <div class="mb-4">
                              <p class="mb-2">Chrome<span class="float-right text-muted">80%</span></p>
                              <div class="progress h-6">
                                 <div class="progress-bar bg-primary w-80 " style="width:80%" role="progressbar"></div>
                              </div>
                           </div>
                           <div class="mb-4">
                              <p class="mb-2">Firefox<span class="float-right text-muted">70%</span></p>
                              <div class="progress h-6"> 
                                 <div class="progress-bar bg-secondary w-70" style="width:70%"  role="progressbar"></div>
                              </div>
                           </div>
                           <div class="mb-4">
                              <p class="mb-2">Safari<span class="float-right text-muted">70%</span></p>
                              <div class="progress h-6">
                                 <div class="progress-bar bg-warning w-70" style="width:70%"  role="progressbar"></div>
                              </div>
                           </div>
                           <div class="mb-4">
                              <p class="mb-2">Opera<span class="float-right text-muted">60%</span></p>
                              <div class="progress h-6">
                                 <div class="progress-bar bg-success w-60" style="width:60%"  role="progressbar"></div>
                              </div>
                           </div>
                           <div class="mb-3">
                              <p class="mb-2">Internet Explore<span class="float-right text-muted">60%</span></p>
                              <div class="progress h-6">
                                 <div class="progress-bar bg-info w-60" style="width:60%"  role="progressbar"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-12 col-sm-12 col-sm-12">
                     <div class="card ">
                        <div class="card-header text-left">
                           <h4>Order Status</h4>
                        </div>
                        <div class="card-body">
                           <canvas id="barChart2" class="chartjs-render-monitor h-250" width="300" height="300"></canvas>
                        </div>
                     </div>
                  </div>
               </div>           
            </section>


<!--             <section class="section4">
               <div class="row row-deck">
                  <div class="col-xl-6 col-lg-12 col-sm-12 col-sm-12">
                     <div class="card ">
                        <div class="card-header text-left">
                           <h4>Recent Events</h4>
                        </div>
                        <div class="card-body text-left">
                           <table class="myTable display joined_data">
                              <thead>
                                 <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Organizer Name</th>
                                    <th>Actions</th>
                                 </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-6 col-lg-12 col-sm-12 col-sm-12">
                     <div class="card ">
                        <div class="card-header text-left">
                           <h4>Recent Member</h4>
                        </div>
                        <div class="card-body text-left">
                           <table class="myTable display joined_data">
                              <thead>
                                 <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Email/Phone</th>
                                    <th>Actions</th>
                                 </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>   
            </section> -->




@endsection

@section('js_files')
<script src="https://omnipotent.net/jquery.sparkline/2.1.2/jquery.sparkline.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" ></script>
      <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8Aphh9TfxhOqU6-RzeMWt0l8oIzVa8MU&callback=initMap">
    </script>

@endsection

@section('custom_js')
 <script type="text/javascript">


       $(function() {
        /** This code runs when everything has been loaded on the page */
        /* Inline sparklines take their values from the contents of the tag */

        $('#dynamicsparkline').sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
            type: 'bar',
            height: 50,
            colorMap: {
               '9': '#a1a1a1'
            },
            barColor: '#7673e6',
            barSpacing: 4
         });



           $('#piesparkline').sparkline([1,1,2,1], {
               type: 'pie',
               width: 50,
               height: 50,
               sliceColors: ['#01b8ff','#f47b25','#7673e6','#ffb209']
            });

            $('#linesparkline').sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
               type: 'line',
               lineColor: '#ffb209 ',
               fillColor: '#ffb209 ',
               width: 80,
               height: 50,
               spotColor: '#f44336',
               minSpotColor: '#f44336'
            });

            $('#discretesparkline').sparkline([4, 6, 7, 7, 4, 3, 2, 1, 4, 4, 2, 4, 3, 7, 8, 9, 7, 6, 4, 3,2, 4, 3, 4, 5, 4, 5, 4, 3], {
               type: 'discrete',
               barWidth: 100,
               lineColor: '#f47b25 ',
               width: 150,
               height: 50

            });

           

         });    


   var ctx = document.getElementById("barChart");
   var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
         labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
         datasets: [{
            label: "online",
            data: [65, 59, 80, 81, 56, 55, 40],
            borderColor: "#7673e6",
            borderWidth: "0",
            barWidth: "1",
            backgroundColor: "#7673e6"
         }, {
            label: "offline",
            data: [28, 48, 40, 19, 86, 27, 90],
            borderColor: "#f47b25",
            borderWidth: "0",
            barWidth: "1",
            backgroundColor: "#f47b25"
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: true,
         scales: {
            xAxes: [{
               ticks: {
                  fontColor: "rgba(0,0,0,0.5)",
                },
               gridLines: {
                  display: false,
               }
            }],
            yAxes: [{
               ticks: {
                  beginAtZero: true,
                  fontColor: "rgba(0,0,0,0.5)",
               },
               gridLines: {
                  display: false
               },
            }]
         },
         legend: {
            labels: {
               fontColor: "rgba(0,0,0,0.5)"
            },
         },
      }
   });
   /*---ChartJS (#barChart) closed---*/


   /*---ChartJS (#pieChart)---*/
   var ctx = document.getElementById("pieChart");
   var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
         datasets: [{
            data: [40, 25, 20],
            backgroundColor: ['#7673e6', ' #f47b25', '#ffb209' ],
            hoverBackgroundColor: ['#7673e6','#f47b25','#ffb209'],
            borderColor:'transparent',
         }],
         labels: ["sales", "profit", "growth"]
      },
      options: {
         responsive: true,
         maintainAspectRatio: true,
         legend: {
            labels: {
               fontColor: "rgba(0,0,0,0.5)"
            },
         },
      }
   });
   /*---ChartJS (#pieChart) closed---*/



   var ctx = document.getElementById("barChart2");
   var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
         labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
         datasets: [{
            label: "online",
            data: [65, 59, 80, 81, 56, 55, 40],
            borderColor: "#7673e6",
            borderWidth: "0",
            barWidth: "1",
            backgroundColor: "#7673e6"
         }, {
            label: "offline",
            data: [28, 48, 40, 19, 86, 27, 90],
            borderColor: "#f47b25",
            borderWidth: "0",
            barWidth: "1",
            backgroundColor: "#f47b25"
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: true,
         scales: {
            xAxes: [{
               ticks: {
                  fontColor: "rgba(0,0,0,0.5)",
                },
               gridLines: {
                  display: false,
               }
            }],
            yAxes: [{
               ticks: {
                  beginAtZero: true,
                  fontColor: "rgba(0,0,0,0.5)",
               },
               gridLines: {
                  display: false
               },
            }]
         },
         legend: {
            labels: {
               fontColor: "rgba(0,0,0,0.5)"
            },
         },
      }
   });
   /*---ChartJS (#barChart2) closed---*/



   </script>
   <script type="text/javascript">
            $(document).ready(function() {
                $('.myTable').DataTable({
                    "paging": true,
                    "info": true,
                    "bLengthChange":false,
                    "bFilter":false,
                    "pageLength": 5
                });
            });

   </script>
     <script type="text/javascript">
        function initMap() {
    var locations = [];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 1,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
   }
  </script>
@endsection