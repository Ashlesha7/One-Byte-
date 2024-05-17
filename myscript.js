/*$(document).ready(function() {
    // Toggle responsive navigation menu
    function toggleClass() {
        $(".responsive_nav").toggleClass("nav_open");
    }

    function removeClass() {
        $(".responsive_nav").removeClass("nav_open");
    }

    // Confirm removal of items from cart
    function verifyChoice() {
        return confirm("Are you sure you want to remove this item from the cart?");
    }

    // Overlay controls
    function showOverlay() {
        $("#overlay").fadeIn("slow");
        $(".info_holder").fadeIn("slow");
    }

    function hideOverlay() {
        $("#overlay").fadeOut("slow");
        $(".info_holder").fadeOut("slow");
    }

    // Validate input data before sending to the server
    function validateInput() {
        let cname = $("#name").val();
        let caddr = $("#addr").val();
        let cemail = $("#email").val();
        let cphone = $("#phone").val();
        let cfood = $("#chkfood").val();
        let cprice = $("#chkprice").val();

        if (cname && caddr && cemail && cphone) {
            $.ajax({
                url: 'process_order.php',
                type: 'post',
                data: {order_info: 'info', name: cname, addr: caddr, email: cemail, phone: cphone, food: cfood, price: cprice},
                success: function(data) {
                    if (data === 'success') {
                        window.location = "summary.php";
                    } else {
                        alert(data);
                    }
                }
            });
        } else {
            alert('Incomplete form data');
        }
    }

    // Update quantity in the cart
    function updateQuantity(id) {
        let qty = $("#" + id).val();
        let price = 'ajax_qty_' + id;

        $.ajax({
            url: 'process_order.php',
            type: 'post',
            data: {item_id_qty: qty},
            success: function(data) {
                $("#" + price).html(data);
                location.reload();
            }
        });
    }

    // Update table availability on date or time change
    $('#date_res, #time').change(updateTableAvailability);

    function updateTableAvailability() {
        let date_res = $('#date_res').val();
        let time = $('#time').val();

        if (!date_res || !time) {
            alert('Please select both date and time to check table availability.');
            return;
        }

        $.ajax({
            url: 'check_table_availability.php',
            type: 'POST',
            data: { date_res: date_res, time: time },
            dataType: 'json',
            success: function(response) {
                $('.table').each(function() {
                    let tableId = $(this).data('table_id');
                    if (response.bookedTables.includes(tableId.toString())) {
                        $(this).addClass('booked').off('click').on('click', function() {
                            alert('This table is already booked for the selected time.');
                        });
                    } else {
                        $(this).removeClass('booked').off('click').on('click', function() {
                            $('.table').not(this).removeClass('selected');
                            $(this).addClass('selected');
                            $('#selected_table').val(tableId);
                        });
                    }
                });
            },
            error: function() {
                alert('Failed to retrieve table availability. Please try again.');
            }
        });
    }
});
*/
$(document).ready(function() {
    // Toggle responsive navigation menu
    function toggleClass() {
        $(".responsive_nav").toggleClass("nav_open");
    }

    function removeClass() {
        $(".responsive_nav").removeClass("nav_open");
    }

    // Confirm removal of items from cart
    function verifyChoice() {
        return confirm("Are you sure you want to remove this item from the cart?");
    }

    // Overlay controls
    function showOverlay() {
        $("#overlay").fadeIn("slow");
        $(".info_holder").fadeIn("slow");
    }

    function hideOverlay() {
        $("#overlay").fadeOut("slow");
        $(".info_holder").fadeOut("slow");
    }

    // Update quantity in the cart
    function updateQuantity(id) {
        let qty = $("#" + id).val();
        let price = 'ajax_qty_' + id;

        $.ajax({
            url: 'process_order.php',
            type: 'post',
            data: {item_id_qty: qty},
            success: function(data) {
                $("#" + price).html(data);
                location.reload();
            }
        });
    }

    // Update table availability on date or time change
    $('#date_res, #time').change(updateTableAvailability);

    function updateTableAvailability() {
        let date_res = $('#date_res').val();
        let time = $('#time').val();

        if (!date_res || !time) {
            alert('Please select both date and time to check table availability.');
            return;
        }

        $.ajax({
            url: 'check_table_availability.php',
            type: 'POST',
            data: { date_res: date_res, time: time },
            dataType: 'json',
            success: function(response) {
                $('.table').each(function() {
                    let tableId = $(this).data('table-id'); // Corrected data attribute name
                    if (response.bookedTables.includes(tableId.toString())) {
                        $(this).addClass('booked').off('click').on('click', function() {
                            alert('This table is already booked for the selected time.');
                        });
                    } else {
                        $(this).removeClass('booked').off('click').on('click', function() {
                            $('.table').not(this).removeClass('selected');
                            $(this).addClass('selected');
                            $('#selected_table').val(tableId);
                        });
                    }
                });
            },
            error: function() {
                alert('Failed to retrieve table availability. Please try again.');
            }
        });
    }
});



