<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h4 class="c-grey-900">Importation des points</h4>
        <div class="mT-30">
            <form action="{{url('importation-point')}}" method="post" enctype="multipart/form-data">

                <!-- CSRF Token -->
                @csrf
                <!-- Excel File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label for="">Points</label>
                        <input type="file" name="csvpoint" class="form-control" id="csvpoint" accept="text/csv">
                        <span id="csvpoint_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <br>
                <button type="submit" class="btn btn-primary btn-color" onclick="submitForm()">Importer</button>
            </form>
        </div>
    </div>
</div>
