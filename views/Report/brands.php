<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">Brands Bar Chart</h5>
            </div>
            <div class="col-md-6">
                <label for="date-from">Date from</label>
                <input type="date" id="date-from" class="form-control pull-right helper">
                <label for="date-to">Date to</label>
                <input type="date" id="date-to" class="form-control pull-right helper">
            </div>
        </div>
    </div>
    <div class="card-body" id="brands-pie-chart-body">
        <!-- Line Chart -->
        <canvas id="brands-pie-chart" style="max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 801.6px;" width="1002" height="400"></canvas>
        <!-- End Line CHart -->
    </div>
</div>

<script>
    $(document).ready(function () {
        var urlBrands = "/report/brandsProcess";
        var dataFromView= { "date_from": $("#date-from").val(), "date_to": $("#date-to").val() };
        var canvasObject = $("#brands-pie-chart").get(0).getContext('2d');

        $.getJSON(urlBrands, dataFromView,function (result){
                var labelsBrands = result.map(function (object){
                    return object.name;
                });

                var dataBrands = result.map(function (object){
                    return object.num_of_brands;
                });

                createGraph(dataBrands, labelsBrands, canvasObject);
        });

        $(".helper").change(function () {
            $("#brands-pie-chart").remove();
            $("#brands-pie-chart-body").append("<canvas id='brands-pie-chart' style='max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 801.6px;' width='1002' height='500'></canvas>");

            dataFromView = { "date_from": $("#date-from").val(), "date_to": $("#date-to").val() };
            canvasObject = $("#brands-pie-chart").get(0).getContext('2d');

            $.getJSON(urlBrands, dataFromView,function (result){
                var labelsBrands = result.map(function (object) {
                    return object.name;
                });

                var  dataBrands = result.map(function (object){
                    return object.num_of_brands;
                });

                createGraph(dataBrands, labelsBrands, canvasObject);
            });
        });
    });

    function createGraph(data, labels, canvasObject) {
        var currentPalette = "neon";
        var chart = new Chart(canvasObject, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    label: "Brands",
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Brands"
                },
                legend: {
                    display: true
                }
            }
        });
        chartColors(chart, currentPalette);
    }

    function chartColors(chart, palette) {
        if (!palette) palette = currentPalette;
        currentPalette = palette;

        /*Gradients
          The keys are percentage and the values are the color in a rgba format.
          You can have as many "color stops" (%) as you like.
          0% and 100% is not optional.*/
        var gradient;
        switch (palette) {
            case 'cool':
                gradient = {
                    0: [255, 255, 255, 1],
                    20: [220, 237, 200, 1],
                    45: [66, 179, 213, 1],
                    65: [26, 39, 62, 1],
                    100: [0, 0, 0, 1]
                };
                break;
            case 'warm':
                gradient = {
                    0: [255, 255, 255, 1],
                    20: [254, 235, 101, 1],
                    45: [228, 82, 27, 1],
                    65: [77, 52, 47, 1],
                    100: [0, 0, 0, 1]
                };
                break;
            case 'neon':
                gradient = {
                    0: [255, 255, 255, 1],
                    20: [255, 236, 179, 1],
                    45: [232, 82, 133, 1],
                    65: [106, 27, 154, 1],
                    100: [0, 0, 0, 1]
                };
                break;
        }

        //Get a sorted array of the gradient keys
        var gradientKeys = Object.keys(gradient);
        gradientKeys.sort(function(a, b) {
            return +a - +b;
        });

        //Find datasets and length
        var chartType = chart.config.type;
        switch (chartType) {
            case "pie":
            case "doughnut":
                var datasets = chart.config.data.datasets[0];
                var setsCount = datasets.data.length;
                break;
            case "bar":
            case "line":
                var datasets = chart.config.data.datasets;
                var setsCount = datasets.length;
                break;
        }

        //Calculate colors
        var chartColors = [];
        for (i = 0; i < setsCount; i++) {
            var gradientIndex = (i + 1) * (100 / (setsCount + 1)); //Find where to get a color from the gradient
            for (j = 0; j < gradientKeys.length; j++) {
                var gradientKey = gradientKeys[j];
                if (gradientIndex === +gradientKey) { //Exact match with a gradient key - just get that color
                    chartColors[i] = 'rgba(' + gradient[gradientKey].toString() + ')';
                    break;
                } else if (gradientIndex < +gradientKey) { //It's somewhere between this gradient key and the previous
                    var prevKey = gradientKeys[j - 1];
                    var gradientPartIndex = (gradientIndex - prevKey) / (gradientKey - prevKey); //Calculate where
                    var color = [];
                    for (k = 0; k < 4; k++) { //Loop through Red, Green, Blue and Alpha and calculate the correct color and opacity
                        color[k] = gradient[prevKey][k] - ((gradient[prevKey][k] - gradient[gradientKey][k]) * gradientPartIndex);
                        if (k < 3) color[k] = Math.round(color[k]);
                    }
                    chartColors[i] = 'rgba(' + color.toString() + ')';
                    break;
                }
            }
        }

        //Copy colors to the chart
        for (i = 0; i < setsCount; i++) {
            switch (chartType) {
                case "pie":
                case "doughnut":
                    if (!datasets.backgroundColor) datasets.backgroundColor = [];
                    datasets.backgroundColor[i] = chartColors[i];
                    if (!datasets.borderColor) datasets.borderColor = [];
                    datasets.borderColor[i] = "rgba(255,255,255,1)";
                    break;
                case "bar":
                    datasets[i].backgroundColor = chartColors[i];
                    datasets[i].borderColor = "rgba(255,255,255,0)";
                    break;
                case "line":
                    datasets[i].borderColor = chartColors[i];
                    datasets[i].backgroundColor = "rgba(255,255,255,0)";
                    break;
            }
        }

        //Update the chart to show the new colors
        chart.update();
    }

</script>