<?php use App\Models\FormatDate; ?>
<div class="row mT-30">
    <div class="row mT-15">
      <div class="col-md-12">
          <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                  <div class="col-md-6">
                      <h1 style="font-size: 20px" class="c-grey-900 mB-20">Point obtenue par etape</h1>
                  </div>
                  <div class="col-md-2"></div>
              </div>
              <div class="row">
                  <div class="col-md-9">
                      <div id="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Etape</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                        @foreach ($resultat as $data)
                                            <tr>
                                                <td>{{$data->etape }}</td>
                                                <td style="text-align: right">{{$data->points}}</td>
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
