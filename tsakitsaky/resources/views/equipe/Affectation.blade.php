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
                    <div class="col-md-6">
                        <h1 style="font-size: 20px" class="c-grey-900 mB-20">Affecation de coureur sur l'étape : {{ $etape }} nombre maximum de coureur {{ $nbMax }}</h1>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <input type="hidden" name="recherche" class="form-control" id="inputtext" placeholder="Votre Recherche">
                    </div>
                </div>

                <!-- Ajout du formulaire sur une seule ligne -->
                <div class="row">
                    <div class="col-md-12">
                        @if(count($recherches) < $nbMax)
                        <form action="{{url('affectation_du_coureur')}}" method="post">
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

<script src="{{ asset('assets/js/jquery.js') }}"></script>

<script>


</script>

<script>
 /*   document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('inputtext');
        const tableBody = document.getElementById('table-body');

        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                let found = false;
                Array.from(row.cells).forEach(cell => {
                    const cellText = cell.textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        found = true;
                    }
                });
                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });*/
</script>
