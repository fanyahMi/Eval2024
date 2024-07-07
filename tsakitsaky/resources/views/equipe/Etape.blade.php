<div class="row mT-30">
    <div class="row mT-15">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-6">
                        <h1 style="font-size: 20px" class="c-grey-900 mB-20">Liste des étapes de la course</h1>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="table-container">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Rang</th>
                                            <th>Etape</th>
                                            <th>Longueur</th>
                                            <th>Nombre Coureur</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <!-- Table rows will be inserted here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="pagination-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
$(document).ready(function() {
    const localStorageKey = "etapesData";

    function fetchData() {
        const storedData = localStorage.getItem(localStorageKey);
        if (storedData != null) {
            renderTable(JSON.parse(storedData));
        } else {
            $.ajax({
                url: `{{ url('/liste-etapes') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    localStorage.setItem(localStorageKey, JSON.stringify(data.result));
                    renderTable(data.result);
                }
            });
        }
    }

    function renderTable(data) {
        const tableBody = $("#table-body");
        tableBody.empty();

        $.each(data.data, function(index, item) {
            const row = `
                <tr>
                    <td style="text-align: right">${item.rang}</td>
                    <td>${item.etape}</td>
                    <td style="text-align: right">${Number(item.longueur).toFixed(2)}</td>
                    <td style="text-align: right">${Number(item.nb_coureur).toFixed(2)}</td>
                    <td><a href="{{ url('Liste-des-coureurs') }}/${item.id_etape}">Affectation</a></td>
                </tr>
            `;
            tableBody.append(row);
        });
    }
    fetchData();
});
</script>
