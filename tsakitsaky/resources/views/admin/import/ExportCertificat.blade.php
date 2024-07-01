<style>
    body {
    font-family: Roboto;
}

.certificate-container {
    padding: 50px;
    width: 1024px;
}
.certificate {
    border: 20px solid #0C5280;
    padding: 25px;
    height: 600px;
    position: relative;
    background-image: url(../../assets/static/images/confetti-vector-background-party-design-with-colorful-confetti_165143-1898.avif);
    background-size: 100%;
}

.certificate:after {
    content: '';
    top: 0px;
    left: 0px;
    bottom: 0px;
    right: 0px;
    position: absolute;
    background-size: 100%;
    z-index: -1;
}

.certificate-header > .logo {
    width: 150px;
}

.certificate-title {
    text-align: center;
}

.certificate-body {
    text-align: center;
}

h1 {

    font-weight: 400;
    font-size: 48px;
    color: #0C5280;
}

.student-name {
    font-size: 24px;
}

.certificate-content {
    margin: 0 auto;
    width: 750px;
}

.about-certificate {
    width: 380px;
    margin: 0 auto;
}

.topic-description {

    text-align: center;
}

</style>
<div class="certificate-container">
    <div class="certificate">
        <div class="water-mark-overlay"></div>
        <div class="certificate-header">
            <img src="../../assets/static/images/running-and-marathon-logo-design-running-man-symbol-free-vector.jpg" class="logo" alt="">
        </div>
        <div class="certificate-body">

            <p class="certificate-title"><strong>RUNNING MARATHON</strong></p>
            <h1>CERTIFICAT DE MERITE</h1>
            <p class="student-name">Equipe {{$resultat->equipe_libelle}}</p>
            <div class="certificate-content">
                <div class="about-certificate">
                    <p>
                        en reconnaissance de sa performance exceptionnelle.
                    </p>
                </div>
                <p class="topic-title">
                    Avec un temps très impressionnant , Equipe {{$resultat->equipe_libelle}} a démontré un engagement,
                    une détermination et une endurance exemplaires.
                </p>
                <div class="text-center">
                    <p class="topic-description text-muted">
                        Nous félicitons Equipe {{$resultat->equipe_libelle}} pour cet exploit remarquable et célébrons cette réalisation extraordinaire.
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
