<div class="search-bar">
    <div class="search-form d-flex align-items-center">
        <input type="text" name="query" id="search" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </div>
</div><!-- End Search Bar -->

<div id="ad-container"></div>

<input type="button" value="Load more" id="load-more-btn" class="btn btn-outline-primary col-12">

<script>
    $(document).ready(function() {
        var page_number = 0;
        loadMore($("#load-more-btn"), $("#ad-container"), $("#search").val(), page_number, "/ad/getads")

        $("#load-more-btn").click(function (){
            loadMore($("#load-more-btn"), $("#ad-container"), $("#search").val(), page_number, "/ad/getads");
            page_number++;
        });

        $("#search").change(function (){
            $("#ad-container").empty();
            loadMore($("#load-more-btn"), $("#ad-container"), $("#search").val(), page_number, "/ad/getads");
            page_number = 0;
        });
    });

    function loadMore(jQueryLoadMoreBtn, jQueryContainer, search, pageNumber, url) {
        var data = {"page_number": pageNumber, "search": search};
        $.ajax({
            method: "GET",
            url: url,
            data: data,
            dataType: "json",
            success: function (result) {
                if (result == null || result.length == 0 || result.length < 10) {
                    jQueryLoadMoreBtn.val("No more data!");
                    jQueryLoadMoreBtn.prop('disabled', true);
                }

                if (result != null && result.length > 0) {
                    $.each(result, function (index, item) {
                        jQueryContainer.append(
                            '<div class="card mb-3">' +
                               ' <div class="row g-0">' +
                                    '<div class="col-md-4">'+
                                        '<img src=' + item.image + ' class="img-fluid rounded-start" alt="...">' +
                                    '</div>' +
                                    '<div class="col-md-8">' +
                                        '<div class="card-body">' +
                                            '<h5 class="card-title">' + 'Model: ' + item.brand + ' ' + item.name +'</h5>' +
                                            '<p class="card-text">'+ 'Price: ' + item.price +'</p>' +
                                            '<p class="card-text">'+ 'Expires at: ' + item.expires_at +'</p>' +
                                            '<p class="card-text">'+ 'Seller information:' + item.forename + ' ' + item.surname +'</p>' +
                                            '<p class="card-text">'+ 'Contact phone number:' + item.phone_number +'</p>' +
                                            '<p class="small fst-italic">'+ item.description +'</p>' +
                                        '</div>' +
                                    '</div>'+
                                '</div>' +
                            '</div>'
                        );
                    });
                }
            },
            error: function () {
                alert("Error reading data!");
            }
        });
    }
</script>