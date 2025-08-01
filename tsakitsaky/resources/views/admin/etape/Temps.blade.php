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
                        <h1 style="font-size: 22px;font-weight: bold" class="c-grey-900 mB-20">Affectation de temps effectuer par coureur sur l'étape : {{ $etape }}</h1>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form id="addTempsForm" action="{{url('add-temps')}}" method="post">
                            @csrf
                            <div class="row" >
                                <div class="col-md-3">
                                    <label for="selectPersonne" class="mR-10">Sélectionnez une personne</label>
                                    <select class="form-control" id="selectPersonne" name="coureur_etape_id">
                                        @foreach($coureurs as $option)
                                            <option value="{{ $option->coureur_etape_id }}" >{{ $option->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('coureur_etape_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror

                                <div class="col-md-3">
                                    <label for="heureDepart">Date de départ</label>
                                    <input type="date" step="1" class="form-control" id="heureDepart" name="date_depart">
                                </div>
                                @error('date_depart')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror


                                <div class="col-md-3">
                                    <label for="heureDepart">Heure de départ</label>
                                    <input type="time" step="1" class="form-control" id="heureDepart" name="heure_depart">
                                </div>
                                @error('heure_depart')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror

                                <div class="col-md-3">
                                    <label for="heureArrivee" >Heure d'arrivée</label>
                                    <input type="datetime-local" step="1" class="form-control" id="heureArrivee" name="heure_arriver">
                                </div>
                                @error('heure_arriver')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror

                                <div class="col-md-3">
                                    <button type="submit" style="margin-top: 8%;" class="btn btn-primary">Valider</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="font-size: 19px;font-weight: bold" class="c-grey-900 mB-20">Temps effectuer par coureur sur l'étape : {{ $etape }}</h2>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="c-grey-900 mB-20">Sans categorie</h3>
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
                                                <th>Rang</th>
                                                <th>Equipe</th>
                                                <th>Nom</th>
                                                <th>Genre</th>
                                                <th>Date du depart</th>
                                                <th>Heure depart</th>
                                                <th>Heure Arriver</th>
                                                <th>Difference en s</th>
                                                <th>Points</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            @foreach($simple as $data)
                                                <tr>
                                                    <td >{{$data->rang_coureur2}}</td>
                                                    <td >{{$data->equipe_libelle}}</td>
                                                    <td >{{$data->nom}}</td>
                                                    <td >{{$data->genre}}</td>
                                                    <td >{{$data->date_cours}}</td>
                                                    <td >{{$data->heure_depart}}</td>
                                                    <td >{{$data->heure_arriver}}</td>
                                                    <td >{{$data->difference_seconds_total}}</td>
                                                    <td >{{$data->points}}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    @foreach($resultat as $d)
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="c-grey-900 mB-20">Categorie {{$d['categorie']}}</h3>
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
                                                    <th>Rang</th>
                                                    <th>Equipe</th>
                                                    <th>Nom</th>
                                                    <th>Genre</th>
                                                    <th>Date du depart</th>
                                                    <th>Heure depart</th>
                                                    <th>Heure Arriver</th>
                                                    <th>Difference en s</th>
                                                    <th>Points</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                @foreach($d['data'] as $data)
                                                    <tr>
                                                        <td >{{$data->rang_coureur}}</td>
                                                        <td >{{$data->equipe_libelle}}</td>
                                                        <td >{{$data->nom}}</td>
                                                        <td >{{$data->genre}}</td>
                                                        <td >{{$data->date_cours}}</td>
                                                        <td >{{$data->heure_depart}}</td>
                                                        <td >{{$data->heure_arriver}}</td>
                                                        <td >{{$data->difference_seconds_total}}</td>
                                                        <td >{{$data->points}}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach


            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#addTempsForm').submit(function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            // Efface les messages d'erreur existants
            $('.error-message').text('');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'), // URL de l'action du formulaire
                data: $(this).serialize(), // Sérialise les données du formulaire
                dataType: 'json',
                success: function(response) {
                    alert('Temps ajouté avec succès.');
                    $('#addTempsForm')[0].reset(); // Réinitialise le formulaire
                    location.reload(); // Recharge les données, mais vous pouvez supprimer si vous ne voulez pas
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors; // Récupère les erreurs JSON
                    $.each(errors, function(index, value) {
                        // Affiche les erreurs sous les champs de formulaire correspondants
                        $('#error_' + index).text(value[0]);
                    });
                }
            });
        });
    });
</script>
