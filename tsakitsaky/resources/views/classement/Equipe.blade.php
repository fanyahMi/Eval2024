<?php use App\Models\Utilisateurs; ?>
<div class="row mT-30">
    <div class="row mT-15">
        <div class="row">
            <div class="col-md-6">
                <h1 style="font-size: 20px; font-weight: bold" class="c-grey-900 mB-20">Classement des equipes par catégorie</h1>
            </div>
            <div class="col-md-2"></div>
        </div>
      <div class="col-md-12">
          <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                <div class="col-md-6">
                    <h2 class="c-grey-900 mB-20"><b>Sans categorie</b></h2>
                </div>
            </div>
            <br>
              <div class="row">
                  <div class="col-md-9">
                      <div id="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipe</th>
                                        <th>Point</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($classementEquipeSimple as $data)
                                        <tr>
                                            <td><a href="{{'pointEtape'}}/{{ $data->equipe }}">Equipe {{ $data->equipe_libelle }}</a></td>
                                            <td style="text-align: right">{{ $data->total_points }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (Utilisateurs::roleAdmin(session('roles')))
                            <div class="peer" style="display: none">
                                <a href="{{url('export')}}" style="background: linear-gradient(to right, #364fcb, #4f6ad7);border: none;display: inline-block;" class="btn btn-color">
                                Exporter le vainqueur </a>
                            </div>
                        @endif

                      </div>
                  </div>
              </div>
<!----------------

              <br>
              <div class="row">
                <div class="col-md-6">
                    <h4 class="c-grey-900 mB-20">Total catégorie </h4>
                </div>
            </div>
            <br>

              <div class="row">
                  <div class="col-md-12">
                      <div id="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipe</th>
                                        <th>Point</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($classementEquipe as $data)
                                        <tr>
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

---------------->

              <br>
                    @foreach($resultat as $d)
                    <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="c-grey-900 mB-20"><b>Categorie {{$d['categorie']}}</b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
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
                                                    $i=0;
                                                @endphp
                                               @for ($i = 0; $i < count($d['data']); $i++)
                                               @php
                                                   $currentPoints = $d['data'][$i]->points;
                                                   $isTied = false;

                                                   if ($i < count($d['data']) - 1 && $currentPoints == $d['data'][$i + 1]->points) {
                                                       $isTied = true;
                                                   }

                                                   if ($i > 0 && $currentPoints == $d['data'][$i - 1]->points) {
                                                       $isTied = true;
                                                   }
                                               @endphp

                                               <tr>
                                                   <td>Equipe {{ $d['data'][$i]->equipe_libelle }}</td>
                                                   @if ($isTied)
                                                       <td style="background-color: #d74f56;text-align: right">{{ $currentPoints }}</td>
                                                   @else
                                                       <td style="text-align: right">{{ $currentPoints }}</td>
                                                   @endif
                                               </tr>
                                           @endfor


                                            </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    @if (Utilisateurs::roleAdmin(session('roles')))
                                        @if (count($d['data']) != 0)
                                        <div class="peer">
                                            <form action="{{url('exportation')}}" method="get">
                                                @csrf
                                                <input type="hidden" value="{{$d['data'][0]->equipe}}" name="equipe">
                                                <input type="hidden" value="{{$d['data'][0]->id_categorie}}" name="id_categorie">
                                                <input type="submit" class="btn btn-color" style="background: linear-gradient(to right, #364fcb, #4f6ad7);border: none;display: inline-block;" value="Exporter le vainqueur">
                                            </form>
                                        </div>

                                        @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                        @endforeach
<!----------------->
          </div>
      </div>
  </div>
</div>

