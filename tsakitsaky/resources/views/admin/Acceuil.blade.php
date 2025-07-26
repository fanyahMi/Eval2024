<script src="{{ asset('assets/js/chart.js') }}"></script>
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<!----------->
<div class="row mT-30">
    <div class="row mT-15">
        <div class="row">
            <div class="col-md-6">
                <h1 style="font-size: 20px" class="c-grey-900 mB-20"><b>Classement de Course par Équipe</b></h1>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="c-grey-900 mB-20"><b>Classement Global Sans Catégorie</b></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="table-container-simple">
                            <div class="table-responsive">
                                <table id="table-simple" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Equipe</th>
                                            <th>Point</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body-simple">
                                        <!-- Les données seront ajoutées ici via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="layers">
                                <div class="layer w-100 mB-10">
                                    <h6 class="lh-1">Chart</h6>
                                </div>
                                <div class="layer w-100">
                                    <canvas id="chart-simple" height="220"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="categorie-results">

</div>
</div>

<script>
$(document).ready(function() {
    $.ajax({
        url: '{{ url("classement/global") }}',
        type: 'GET',
        success: function(data) {
            var tableBodySimple = $('#table-body-simple');
            var chartDataSimple = [];
            var chartLabelsSimple = [];

            $.each(data.classementEquipeSimple, function(index, equipe) {
                tableBodySimple.append('<tr><td>Equipe ' + equipe.equipe_libelle + '</td><td style="text-align: right">' + equipe.total_points + '</td></tr>');
                chartLabelsSimple.push('Equipe ' + equipe.equipe_libelle);
                chartDataSimple.push(equipe.total_points);
            });

            var chartSimpleCtx = document.getElementById('chart-simple').getContext('2d');
            var chartSimple = new Chart(chartSimpleCtx, {
                type: 'pie',
                data: {
                    labels: chartLabelsSimple,
                    datasets: [{
                        data: chartDataSimple,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    });

    $.ajax({
        url: '{{ url("classement/categorie") }}',
        type: 'GET',
        success: function(data) {
            $.each(data.resultat, function(index, categorie) {
                var categorieHtml = '<div class="row mT-30"><div class="row mT-15"><div class="col-md-12"><div class="bgc-white bd bdrs-3 p-20 mB-20"><div class="row"><div class="col-md-6"><h2 class="c-grey-900 mB-20"><b>Categorie ' + categorie.categorie + '</b></h2></div></div><br><div class="row"><div class="col-md-8"><div id="table-container-' + categorie.categorie + '"><div class="table-responsive"><table class="table table-striped table-bordered"><thead><tr><th>Equipe</th><th>Points</th></tr></thead><tbody>';

                var chartDataCategorie = [];
                var chartLabelsCategorie = [];

                $.each(categorie.data, function(idx, equipe) {
                    categorieHtml += '<tr><td>Equipe ' + equipe.equipe_libelle + '</td><td style="text-align: right">' + equipe.points + '</td></tr>';
                    chartLabelsCategorie.push('Equipe ' + equipe.equipe_libelle);
                    chartDataCategorie.push(equipe.points);
                });

                categorieHtml += '</tbody></table></div></div></div><div class="col-md-3"><div class="row"><div class="layers"><div class="layer w-100 mB-10"><h6 class="lh-1">Chart</h6></div><div class="layer w-100"><canvas id="chart-' + categorie.categorie + '" height="220"></canvas></div></div></div></div></div></div></div></div>';

                $('#categorie-results').append(categorieHtml);

                var chartCategorieCtx = document.getElementById('chart-' + categorie.categorie).getContext('2d');
                var chartCategorie = new Chart(chartCategorieCtx, {
                    type: 'pie',
                    data: {
                        labels: chartLabelsCategorie,
                        datasets: [{
                            data: chartDataCategorie,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });
        }
    });
});
</script>

