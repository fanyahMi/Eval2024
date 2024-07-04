<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>

<div class="row mT-20">
      <div class="row mT-15">
        <h1 class="c-grey-900 mB-20" style="font-size: 20px;">Liste des coureurs par étape </h1>
        <div class="col-md-12">
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
                @foreach ($etapes as $item)
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-20">{{$item->etape}} ({{$item->longueur}} km) :
                            {{$item->nb_coureur}}

                        coureur(s)</h4>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <!-- Ajout coureur -->
                <div class="row">
                    <div class="col-md-12">
                        <div id="table-container">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Temps chrono</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach ($coureur as $items)
                                        @if ($item->id_etape == $items->etape_id)
                                        <tr>
                                            <td >{{$items->nom}}</td>
                                            <td>{{$items->temps_chrono}}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="peer">
                        <a href="{{url('ajout_de_coureur')}}/{{$item->id_etape}}" style="background: linear-gradient(to right, #364fcb, #4f6ad7);border: none;display: inline-block;" class="btn btn-color">
                        Ajout coureur</a>
                    </div>
                </div>
                <!----- Ajout coureur-------->
            </div>

            @endforeach
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
