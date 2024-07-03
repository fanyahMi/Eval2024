<?php use App\Models\FormatDate; ?>
<div class="row mT-30">
    <div class="row mT-15">
      <div class="col-md-12">
          <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                  <div class="col-md-6">
                      <h1 style="font-size: 20px;font-weight: bold" class="c-grey-900 mB-20">Liste des étapes de la course</h1>
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
                                        <th>Longueur</th>
                                        <th>Nombre Coureur</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($recherches as $data)
                                        <tr>
                                            <td style="text-align: right">{{$data->rang}}</td>
                                            <td>{{ $data->etape }}</td>
                                            <td style="text-align: right">{{ number_format($data->longueur, 2, '.', ',') }}</td>
                                            <td style="text-align: right">{{ number_format($data->nb_coureur, 2, '.', ',') }}</td>
                                            <td>
                                                <a href="{{url('formulaire-pour-ajout-de-temps')}}/{{$data->id_etape}}">Ajout temps</a>
                                            </td>
                                            <td>
                                                <a href="{{url('resultat-pour-une-etape')}}/{{$data->id_etape}}">Resultat</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(count($recherches) != 0)
                            {{$recherches->links('pagination::bootstrap-4')}}
                        @endif
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script type="text/javascript">
  /*$(document).ready(function() {
      $('#inputtext').on('input', function() {
          var recherche = $(this).val();
          $.ajax({
              type: 'GET',
              url: "{{url('rechercheTableau')}}",
              data: {
                  recherche: recherche
              },
              success: function(data) {
                  $('#table-container').html(data);
              }
          });
      });
  });*/
</script>
