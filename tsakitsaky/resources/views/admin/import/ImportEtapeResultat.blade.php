<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h4 class="c-grey-900">Importation de donnee</h4>
        <div class="mT-30">
            <form action="{{url('importationetapesresultat')}}" method="post" enctype="multipart/form-data">

                <!-- CSRF Token -->
                @csrf

                <!-- CSV File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label for="">Etapes</label>
                        <input type="file" name="csvetape" class="form-control" id="csvetape" accept="text/csv" >
                        <span id="csvetape_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Excel File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label for="">Resultat</label>
                        <input type="file" name="csvresultat" class="form-control" id="csvresultat" accept="text/csv">
                        <span id="csvresultat_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <br>
                <button type="submit" class="btn btn-primary btn-color" onclick="submitForm()">Importer</button>
            </form>
        </div>
    </div>
</div>
