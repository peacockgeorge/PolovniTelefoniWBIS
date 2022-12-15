<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">Brands Bar Chart</h5>
            </div>
            <div class="col-md-6">
                <label for="date-from">Date from</label>
                <input type="month" id="date-from" class="form-control pull-right helper">
                <label for="date-to">Date to</label>
                <input type="month" id="date-to" class="form-control pull-right helper">
            </div>
        </div>
    </div>
    <div class="card-body" id="adsPerBrand-pie-chart-body">
        <!-- Line Chart -->
        <canvas id="adsPerBrand-bar-chart" style="max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 801.6px;" width="1002" height="400"></canvas>
        <!-- End Line CHart -->
    </div>
</div>

<script>
    $(document).ready(function () {
        var urlBrands = "/report/adsPerBrandProcess";
        var dataFromView = { "date_from": $("#date-from").val(), "date_to": $("#date-to").val() };
        var canvasObject= $("#adsPerBrand-bar-chart").get(0).getContext('2d');

        $.getJSON(urlBrands, dataFromView,function (result) {
            createGraph(result, canvasObject);
        });

        $(".helper").change(function () {
            $("#adsPerBrand-bar-chart").remove();
            $("#adsPerBrand-pie-chart-body").append("<canvas id='adsPerBrand-bar-chart' style='max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 801.6px;' width='1002' height='500'></canvas>");

            dataFromViewBrands = { "date_from": $("#date-from").val(), "date_to": $("#date-to").val() };
            canvasObjectBrands = $("#adsPerBrand-bar-chart").get(0).getContext('2d');

            $.getJSON(urlBrands, dataFromViewBrands,function (result) {
                createGraph(result, canvasObjectBrands);
            });
        });
    });

    function  createGraph(result, canvasObject) {

        new Chart(canvasObject, {
            type: 'bar',
            data: result,
            options: {
                barValueSpacing: 20,
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                }
            }
        });
    }

</script>
