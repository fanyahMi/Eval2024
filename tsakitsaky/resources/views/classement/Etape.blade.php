<div class="row mT-30">
    <div class="row mT-15">
      <div class="col-md-12">
          <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                  <div class="col-md-6">
                      <h4 class="c-grey-900 mB-20"><b>Classification sur les étapes avec categorie </b></h4>
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
                                        <th>Etape</th>
                                        <th>Equipe</th>
                                        <th>Point</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($classementEtape as $data)
                                        <tr>
                                            <td style="text-align: right">{{$data->rang}}</td>
                                            <td>{{ $data->etape }}</td>
                                            <td>{{ $data->equipe_libelle }}</td>
                                            <td>{{ $data->total_points }}</td>
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

