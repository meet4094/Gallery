<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Category
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/getCategorydata') }}",
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response.category);
                    $.each(response.category, function(prefix, val) {
                        $('#category_data').append(
                            `<li><a class="{{ @$title == 'categories' ? 'active' : '' }}" href="{{url('category')}}/${val.id}">${val.name}</a></li>`
                        )
                    })
                } else {
                    alert('failed');
                }
            },
            error: function(error) {
                alert('Error');
            }
        });
    });

    // Top View Person And Category Related More Person
    $(document).ready(function() {
        var categoryId = $('.categoryId').val();
        $.ajax({
            type: 'POST',
            url: "{{ url('/getTopViewPersondata') }}",
            data: {
                categoryId: categoryId
            },
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response.category);
                    $.each(response.topviewperson, function(prefix, val) {
                        $('#filter__gallery').append(
                            `<a href="{{url('person_details')}}/${val.id}">
                                <div class="product__sidebar__view__item set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}'); width: 100%; background-position: center">
                                    <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                    <h5 style="color: #ffffff;font-weight: 700;line-height: 26px;">${val.name}</h5>
                                </div>
                            </a>`
                        );
                    });
                } else {
                    alert('failed');
                }
            },
            error: function(error) {
                alert('Error');
            }
        });
    });

    // Filter Top View Person
    $(".filter__data li").click(function() {
        var filerId = this.id;
        $('.filter__data li').addClass('active');
        $.ajax({
            type: 'POST',
            url: "{{ url('/getTopViewPersondata') }}",
            data: {
                filerId: filerId
            },
            success: function(response) {
                // console.log(response);
                if (response.st == 'success') {
                    $('#filter__gallery').html('');
                    $.each(response.topviewperson, function(prefix, val) {
                        $('#filter__gallery').append(
                            `<a href="{{url('person_details')}}/${val.id}"><div class="product__sidebar__view__item set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}')">
                                <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                <h5 style="color: #ffffff;font-weight: 700;line-height: 26px;">${val.name}</h5>
                            </div></a>`
                        );
                    });
                } else {
                    alert('failed');
                };
            },
            error: function(error) {
                alert('Error');
            }
        });
    });
</script>