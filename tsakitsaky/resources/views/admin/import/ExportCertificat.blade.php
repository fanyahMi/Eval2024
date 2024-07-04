<link href="{{ asset('assets/css/certificat.min.css') }}" rel="stylesheet" />

<div class="certificate-container">
    <div class="certificate">
        <div class="water-mark-overlay"></div>
        <div class="certificate-header">
            <img src="../../assets/static/images/running-and-marathon-logo-design-running-man-symbol-free-vector.jpg" class="logo" alt="">
        </div>
        <div class="certificate-body">

            <p class="certificate-title"><strong>RUNNING MARATHON</strong></p>
            <h1>CERTIFICAT DE MERITE</h1>
            <p class="student-name" id="equipeLibelle"></p>
            <div class="certificate-content">
                <div class="about-certificate">
                    <p>
                        en reconnaissance de sa performance exceptionnelle.
                    </p>
                </div>
                <p class="topic-title" id="certificateText">
                    Avec un temps très impressionnant, Equipe [Nom équipe] a démontré un engagement,
                    une détermination et une endurance exemplaires.
                </p>
                <div class="text-center">
                    <p class="topic-description text-muted">
                        Nous félicitons Equipe [Nom équipe] pour cet exploit remarquable et célébrons cette réalisation extraordinaire.
                    </p>
                </div>
            </div>
            <div class="certificate-footer text-muted">
                <div class="row">
                    <div class="">
                        <p>Organisateur: ______________________</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="peer">
    <a href="{{url('export')}}" style="background: linear-gradient(to right, #364fcb, #4f6ad7);border: none;display: inline-block;" class="btn btn-color">
    Exporter</a>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('certificat-data') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.result) {
                    $('#equipeLibelle').text('Equipe ' + response.result.equipe_libelle);
                    $('#certificateText').html('Avec un temps très impressionnant, Equipe ' + response.result.equipe_libelle + ' a démontré un engagement, une détermination et une endurance exemplaires.');
                } else {
                    console.error('Erreur lors de la récupération des données du certificat.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX: ' + status + ', ' + error);
            }
        });
    });
</script>

