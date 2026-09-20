
<div class="row">

    <div class="container-fluid col-md-6">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Aktivni-Neaktivni kupci</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="invoiceActive" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%; display: block; width: 634px;" width="634" height="250" class="chartjs-render-monitor"></canvas>
                </div>
            </div>

            <!-- /.card-body -->
        </div>
    </div>
</div>


<script>


        var urlActive = "/invoicesActive";

        $.getJSON(urlActive, function (result){
            var labelsActive = result.map(function (e){
                return e.active;
            });

            var numberOfInvoicesActive = result.map(function (e){
                return e.numberOfInvoices;
            });

            var setData = {
                labels: labelsActive,
                datasets: [
                    {
                        label: "Odnos aktivnih i neaktivnih kupaca",
                        data: numberOfInvoicesActive,
                        backgroundColor: ["#669911", "#119966" ],
                        hoverBackgroundColor: ["#66A2EB", "#FCCE56"]
                    }]
            }

            var graphActive = $("#invoiceActive").get(0).getContext('2d');

            createBarGraph(setData, labelsActive, graphActive);
        });

    function createBarGraph(setData, labelsActive, graphActive){
        new Chart(graphActive, {
            type: 'horizontalBar',
            data: setData
        });
    }



</script>
