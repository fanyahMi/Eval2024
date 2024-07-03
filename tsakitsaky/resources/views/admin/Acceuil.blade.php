<script src="{{ asset('assets/js/chart.js') }}"></script>
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<!----------->
<div class="row mT-30">
    <div class="row mT-15">
        <div class="row">
            <div class="col-md-6">
                <h1 style="font-size: 20px" class="c-grey-900 mB-20"><b>Classement de Course par Équipe</b></h1>
            </div>
            <div class="col-md-2"></div>
        </div>
      <div class="col-md-12">
          <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                <div class="col-md-6">
                    <h2 class="c-grey-900 mB-20"><b>Classement Global Sans Catégorie</b></h2>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-8">
                      <div id="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipe</th>
                                        <th>Point</th>
                                    </tr>
                                </thead>
                                @php
                                    $dat = '[';
                                    $label = '[';
                                @endphp
                                <tbody id="table-body">
                                    @foreach($classementEquipeSimple as $key => $data)
                                        <tr>
                                            <td>Equipe {{ $data->equipe_libelle }}</td>
                                            <td style="text-align: right">{{ $data->total_points }}</td>
                                            @php
                                                if ($key == (count($classementEquipeSimple))-1) {
                                                    $dat.= $data ->total_points;
                                                    $label .= '"'. $data ->equipe_libelle.'"';
                                                } else {
                                                    $dat.= $data ->total_points. "," ;
                                                    $label .= '"'. $data ->equipe_libelle.'"'. ",";
                                                }
                                            @endphp
                                        </tr>
                                    @endforeach
                                    @php
                                        $dat.="]";
                                        $label.="]";
                                    @endphp
                                </tbody>
                            </table>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Chart</h6>
                            </div>
                            <div class="layer w-100">
                                <canvas id="simple" height="220"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <script>

                    var donutCtx = document.getElementById('simple').getContext('2d');
                        var donutChart = new Chart(donutCtx, {
                            type: 'pie',
                            data: {
                                labels:  @php echo $label; @endphp,
                                datasets: [{
                                    data:  @php echo $dat; @endphp,
                                    backgroundColor: ["rgba(255, 99, 132, 0.2)","rgba(54, 162, 235, 0.2)","rgba(255, 206, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(153, 102, 255, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 99, 132, 0.2)","rgba(54, 162, 235, 0.2)","rgba(255, 206, 86, 0.2)","rgba(75, 192, 192, 0.2)"],
                                    borderColor :["rgba(255, 99, 132, 1)","rgba(54, 162, 235, 1)","rgba(255, 206, 86, 1)","rgba(75, 192, 192, 1)","rgba(153, 102, 255, 1)","rgba(255, 159, 64, 1)","rgba(255, 99, 132, 1)","rgba(54, 162, 235, 1)","rgba(255, 206, 86, 1)","rgba(75, 192, 192, 1)"],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                </script>
              </div>
          </div>
      </div>
    </div>
</div>
<!------------------>
<div class="row mT-30">
    <div class="row mT-15">
      <div class="col-md-12">
        @foreach($resultat as $d)
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="c-grey-900 mB-20"><b>Categorie {{$d['categorie']}}</b></h2>
                </div>
            </div>
                <br>
            <div class="row">
                <div class="col-md-8">
                    <div id="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipe</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @php
                                        $dat = '[';
                                        $label = '[';
                                    @endphp
                                    @foreach($d['data'] as $key => $data)

                                        <tr>
                                            <td >Equipe {{$data->equipe_libelle}}</td>
                                            <td style="text-align: right">{{$data->points}}</td>
                                            @php
                                                if ($key == (count($d['data'])-1)) {
                                                    $dat.= $data ->points;
                                                    $label .= '"'. $data ->equipe_libelle.'"';
                                                } else {
                                                    $dat.= $data ->points. ",";
                                                    $label .= '"'. $data ->equipe_libelle.'"'. ",";
                                                }

                                            @endphp

                                        </tr>
                                    @endforeach
                                    @php
                                        $dat.="]";
                                        $label.="]";
                                    @endphp
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Chart</h6>
                            </div>
                            <div class="layer w-100">
                                <canvas id="{{$d['categorie']}}" height="220"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var donutCtx = document.getElementById('{{$d['categorie']}}').getContext('2d');
                        var donutChart = new Chart(donutCtx, {
                            type: 'pie',
                            data: {
                                labels:  @php echo $label; @endphp,
                                datasets: [{
                                    data:  @php echo $dat; @endphp,
                                    backgroundColor: ["rgba(255, 99, 132, 0.2)","rgba(54, 162, 235, 0.2)","rgba(255, 206, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(153, 102, 255, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 99, 132, 0.2)","rgba(54, 162, 235, 0.2)","rgba(255, 206, 86, 0.2)","rgba(75, 192, 192, 0.2)"],
                                    borderColor :["rgba(255, 99, 132, 1)","rgba(54, 162, 235, 1)","rgba(255, 206, 86, 1)","rgba(75, 192, 192, 1)","rgba(153, 102, 255, 1)","rgba(255, 159, 64, 1)","rgba(255, 99, 132, 1)","rgba(54, 162, 235, 1)","rgba(255, 206, 86, 1)","rgba(75, 192, 192, 1)"],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                </script>
            </div>
        </div>
            @endforeach<!----------------->
      </div>
    </div>
</div>

