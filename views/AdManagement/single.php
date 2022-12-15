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
        <h5 class="card-title">Create news</h5>
        <!-- General Form Elements -->
        <form action="/newsmanagement/createProcess" method="post">
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title_news" class="form-control">
                    <?php
                    if (isset($params) and $params->errors !== null and isset($params->errors['title_news']))
                    {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['title_news'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEmail" class="col-sm-2 col-form-label">Image path</label>
                <div class="col-sm-10">
                    <input type="text" name="multimedia_path" class="form-control">
                    <?php
                    if (isset($params) and $params->errors !== null and isset($params->errors['multimedia_path']))
                    {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['multimedia_path'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword" class="col-sm-2 col-form-label">Content</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="content_news" style="height: 100px"></textarea>
                    <?php
                    if (isset($params) and $params->errors !== null and isset($params->errors['content_news']))
                    {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['content_news'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Culture Code</label>
                <div class="col-sm-10">
                    <select class="form-select" name="culture_code" aria-label="multiple select example">
                        <option value="sr">Serbian</option>
                        <option value="en">English</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Category</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  id="search_categories" placeholder="Pretraga kategorija...">
                    <select class="form-select" multiple="multiple" name="categories[]" id="categories" aria-label="multiple select example">
                    </select>
                    <?php
                    if (isset($params) and $params->errors !== null and isset($params->errors['category']))
                    {
                        echo "<ul style='padding-top: 10px !important; margin: 0px !important; list-style-type: none;'>";
                        foreach ($params->errors['category'] as $errorMessage)
                            echo "<li class='text-danger'>$errorMessage</li>";
                        echo "</ul>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Create News</button>
                </div>
            </div>
        </form><!-- End General Form Elements -->
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "/api/categories/getall",
            data: { "search": $("#search_categories").val() },
            method: "GET"
        }).done(function(result) {
            $("#categories").empty();
            $.each(JSON.parse(result), function(i, item) {
                $("#categories").append("<option value='"+ item.id +"'>" + item.category_name + "</option>");
            });
        });

        $("#search_categories").keyup(function () {
            $.ajax({
                url: "/api/categories/getall",
                data: { "search": $("#search_categories").val() },
                method: "GET"
            }).done(function(result) {
                $("#categories").empty();
                $.each(JSON.parse(result), function(i, item) {
                    $("#categories").append("<option value='"+ item.id +"'>" + item.category_name + "</option>");
                });
            });
        });
    });
</script>
