<?php use App\Models\FormatDate; ?>
<div class="row mT-30">
    <div class="row mT-15">
      <div class="col-md-12">
          <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                  <div class="col-md-6">
                      <h4 class="c-grey-900 mB-20">Resultat</h4>
                  </div>
                  <div class="col-md-2"></div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div id="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Rang</th>
                                        <th>Nom coureur</th>
                                        <th>Genre</th>
                                        <th>Chrono</th>
                                        <th>Penalite</th>
                                        <th>Temps final</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                        @foreach ($resultat as $data)
                                            <tr>
                                                <td>{{$data->rang_coureur2 }}</td>
                                                <td>{{$data->nom}}</td>
                                                <td>{{$data->genre}}</td>
                                                <td>{{$data->temps_chrono}}</td>
                                                <td>{{$data->penalite }}</td>
                                                <td>{{$data->temps_chrono_penalite}}</td>
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
  </div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
