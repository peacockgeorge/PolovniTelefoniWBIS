<?php
use app\core\Application;

/** @var $params \app\models\AdManagementModel */


if (Application::getApp()->getSession()->getFlash("success")) {
    $message = Application::getApp()->getSession()->getFlash("success");

    echo "<script>";
    echo "toastr.success('$message')";
    echo "</script>";
}

if (Application::getApp()->getSession()->getFlash("error")) {
    $message = Application::getApp()->getSession()->getFlash("error");
    echo "<script>";
    echo "toastr.error('$message')";
    echo "</script>";
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Create Ad</h5>
        <!-- General Form Elements -->
        <form action="/admanagement/createProcess" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Phone Model</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control">
                    <?php
                    if(isset($params) && isset($params->errors) && isset($params->errors['name'])) {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['name'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputNumber" class="col-sm-2 col-form-label">Image Upload</label>
                <div class="col-sm-10">
                    <input class="form-control" type="file" name="image" id="image">
                    <?php
                    if(isset($params) && isset($params->errors) && isset($params->errors['image'])) {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['image'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEmail" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="number" name="price" class="form-control">
                    <?php
                    if(isset($params) && isset($params->errors) && isset($params->errors['price'])) {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['price'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" style="height: 100px"></textarea>
                    <?php
                    if(isset($params) && isset($params->errors) && isset($params->errors['description'])) {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['description'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Brand</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  id="search_brands" placeholder="Brands...">
                    <select class="form-select" name="brand_id" id="brand">
                    </select>
                    <?php
                    if(isset($params) && isset($params->errors) && isset($params->errors['brand'])) {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['brand_id'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Create Ad</button>
                </div>
            </div>
        </form><!-- End General Form Elements -->
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "/api/brand/getall",
            data: { "search": $("#search_brands").val() },
            method: "GET"
        }).done(function(result) {
            $("#brand").empty();
            $.each(JSON.parse(result), function(i, item) {
                $("#brand").append("<option value='"+ item.id +"'>" + item.name + "</option>");
            });
        });

        $("#search_brands").keyup(function () {
            $.ajax({
                url: "/api/brand/getall",
                data: { "search": $("#search_brands").val() },
                method: "GET"
            }).done(function(result) {
                $("#brand").empty();
                $.each(JSON.parse(result), function(i, item) {
                    $("#brand").append("<option value='"+ item.id +"'>" + item.category_name + "</option>");
                });
            });
        });
    });
</script>