<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">Number of ads</h5>
            </div>
            <div class="col-md-6">
                <label for="date-from">Date from</label>
                <input type="date" id="date-from" class="form-control pull-right helper">
                <label for="date-to">Date to</label>
                <input type="date" id="date-to" class="form-control pull-right helper">
            </div>
        </div>
    </div>
    <div class="card-body" id="number-of-ads-body">
        <!-- Line Chart -->
        <canvas id="number-of-ads" style="max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 801.6px;" width="1002" height="400"></canvas>
        <!-- End Line CHart -->
    </div>
</div>



<script>
    $(document).ready(function (){
        var urlNumberOfAds = "/report/numberOfAdsProcess";
        var dataFromViewNumberOfAds = { "date_from": $("#date-from").val(), "date_to": $("#date-to").val() };
        var canvasObjectNumberOfAds = $("#number-of-ads").get(0).getContext('2d');

        console.log(dataFromViewNumberOfAds);

        $.getJSON(urlNumberOfAds, dataFromViewNumberOfAds,function (result){
            var labelsNumberOfAds = result.map(function (object){
                return object.month_name;
            });

            var dataNumberOfAds = result.map(function (object){
                return object.number_of_ads;
            });

            createGraph(dataNumberOfAds, labelsNumberOfAds,  canvasObjectNumberOfAds);
        });

        $(".helper").change(function () {
            $("#number-of-ads").remove();
            $("#number-of-ads-body").append("<canvas id='number-of-ads' style='max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 801.6px;' width='1002' height='500'></canvas>");

            dataFromViewNumberOfAds = { "date_from": $("#date-from").val(), "date_to": $("#date-to").val() };
            canvasObjectNumberOfAds = $("#number-of-ads").get(0).getContext('2d');

            $.getJSON(urlNumberOfAds, dataFromViewNumberOfAds,function (result){
                var labelsNumberOfAds = result.map(function (object){
                    return object.month_name;
                });

                var  dataNumberOfAds = result.map(function (object){
                    return object.number_of_ads;
                });

                createGraph(dataNumberOfAds, labelsNumberOfAds, canvasObjectNumberOfAds);
            });
        });
    });

    function createGraph(data, labels, canvasObject) {
        new Chart(canvasObject, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    label: "Ads per month",
                    backgroundColor: 'rgb(173, 5, 5)',
                    borderColor: 'rgb(173, 5, 5)',
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Ads per month"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            max: 10,
                            min: 0,
                        }
                    }]
                },
                legend: {
                    display: true
                }
            }
        });
    }
</script>