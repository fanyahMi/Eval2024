<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>

<div class="row mT-30">
      <div class="row mT-15">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-12">
                        <h1 style="font-size: 20px" class="c-grey-900 mB-20">Liste des coureurs par étape</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="font-size: 15px" class="c-grey-900 mB-20">Affecation de coureur sur l'étape : {{ $etape }} nombre maximum de coureur {{ $nbMax }}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if(count($recherches) < $nbMax)
                        <form action="{{url('affectation-du-coureur')}}" method="post">
                            @csrf
                            <div class="row" >
                                <div class="col-md-3">
                                    <label for="selectPersonne" class="mR-10">Sélectionnez une personne</label>
                                    <select class="form-control" id="selectPersonne" name="coureur_id">
                                        @foreach($listCoureurEquipe as $option)
                                            <option value="{{ $option->id_coureur }}" >{{ $option->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="etape_id" value="{{$etape_id}}">
                                <div class="col-md-3">
                                    <button type="submit" style="margin-top: 8%;" class="btn btn-primary">Valider</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>

                    <br>

                <div class="row">
                    <div class="col-md-12">
                        <div id="table-container">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Numero Dossard</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($recherches as $data)
                                        <tr>
                                            <td >{{$data->nom}}</td>
                                            <td>{{ $data->numero_dossard }}</td>
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

