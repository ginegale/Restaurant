<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MK</title>
    <link rel="stylesheet" href="jquery-ui-1.13.2/jquery-ui.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery-3.6.4.min.js"></script>
    <script src="jquery-ui-1.13.2/jquery-ui.js"></script>
    <script src="https://kit.fontawesome.com/7a1e391625.js" crossorigin="anonymous"></script>
    <link href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        var food_categories;
        var all_foods;
        var order_now;
        //COLLECT DATA OF THE CURRENT TABLE
        //id : 1, table_no : 5, status : open, insert_time : 2023-05-09 18:50:56
        //order_now[0].id
        var orderdetail_waitconfirm;
        //COLLECT DATA OF ORDER DETAIL WAITING FOR CONFIRM
        var orderdetail_confirmed;
        var timeoutHandle;
        var header_table = `<tr><th>ID</th>
            <th scope='col'>Cat ID</th>
            <th scope='col'>Food ID</th>
            <th scope='col'>Order ID</th>
            <th scope='col'>QTY</th>
            <th scope='col'>Status</th>
            <th scope='col'>Insert Time</th>
            <th scope='col' style="display:none;">Food ID X</th>
            <th scope='col'>Name</th>
            <th scope='col'>Description</th>
            <th scope='col'>Price</th>
            <th scope='col' style='display:none;'>Image</th>
            <th scope='col'>Confirm</th></tr>`;

        var header_table_confirmed = `<tr><th>ID</th>
            <th scope='col'>Cat ID</th>
            <th scope='col'>Food ID</th>
            <th scope='col'>Order ID</th>
            <th scope='col'>QTY</th>
            <th scope='col'>Status</th>
            <th scope='col'>Insert Time</th>
            <th scope='col' style="display:none;">Food ID X</th>
            <th scope='col'>Name</th>
            <th scope='col'>Description</th>
            <th scope='col'>Price</th>
            <th scope='col' style='display:none;'>Image</th></tr>`;

        function tryParseJsonObject(jsonString) {
            try {
                var o = JSON.parse(jsonString || '""');
                if (o && typeof o === "object") {
                    return o;
                }
            }
            catch (error) {
                return false;
            }
        }

        function iconHover() {
            $('.fa-cart-plus').hover(function () {
                $(this).addClass('fa-bounce');
            }, function () {
                $(this).removeClass('fa-bounce');
            });
        }

        ///////////////////POP UP///////////////////
        function showPopUp() {
            $(".popupBackground").css("visibility", "visible");
            $(".popup").css("visibility", "visible");
        }

        function closePopUp() {
            $(".popupBackground").css("visibility", "hidden");
            $(".popup").css("visibility", "hidden");
        }
        /////////////////END POP UP/////////////////
        //////////ORDER DETAIL (ORDER FOOD)//////////
        function getOrderDetail() {
            setTimeout(function () {
                $(function () {
                    getOrderDetailToShowForWaitConfirm();
                    getOrderDetailToShowForConfirmed();
                });
            }, 1000);
            getOrderDetailAuto();
        }

        function getOrderDetailAuto() {
            setInterval(function () {
                getOrderDetailToShowForWaitConfirm();
                getOrderDetailToShowForConfirmed();
            }, 3000);
        }

        function orderFood(food_id_x) {
            $.post("create_order_detail.php", { food_id: food_id_x, order_id: order_now[0].id }).done(function (data) {
                console.log("POST ORDER DETAIL FINISH " + data);
                getOrderDetailToShowForWaitConfirm();
            });
        }

        //wait_confirm, confirmed, cancel, served
        //put a vertical bar | after each status if more than one
        function getOrderDetailToShowForWaitConfirm() {
            $.post("get_all_orderdetail_by_orderid.php", { status: "wait_confirm", order_id: order_now?.[0]?.id }).done(function (data) {
                console.log("POST ORDER DETAIL FINISH " + data);
                showOrderDetailWaitConfirm(data);
            });
        }

        function getOrderDetailToShowForConfirmed() {
            $.post("get_all_orderdetail_by_orderid.php", { status: "confirmed|served", order_id: order_now?.[0]?.id }).done(function (data) {
                console.log("POST ORDER DETAIL FINISH " + data);
                showOrderDetailConfirmed(data);
            });
        }

        function confirmOrderDetail(orderdetail_id) {
            $.post("confirm_order_detail.php", { order_detail_id: orderdetail_id }).done(function (data) {
                console.log("POST CONFIRM ORDER DETAIL FINISH " + data);
                getOrderDetailToShowForWaitConfirm();
                getOrderDetailToShowForConfirmed();
            });
        }

        function showOrderDetailWaitConfirm(data) {
            orderdetail_waitconfirm = tryParseJsonObject(data);
            $("#wait_confirm_table_header").empty();
            $("#wait_confirm_table").empty();
            var template = `<tr><td>[[--ID--]]</td>
                <td>[[--CAT_ID--]]</td>
                <td>[[--FOOD_ID--]]</td>
                <td>[[--ORDER_ID--]]</td>
                <td>[[--QTY--]]</td>
                <td>[[--STATUS--]]</td>
                <td>[[--INSERT_TIME--]]</td>
                <td style="display:none;">[[--FOOD_ID_X--]]</td>
                <td>[[--NAME--]]</td>
                <td>[[--DESCRIPTION--]]</td>
                <td>[[--PRICE--]]</td>
                <td style='display:none;'>[[--IMAGE--]]</td>
                <td><i id='food_confirm_[[--ID--]]' order-detail-id='[[--ID--]]' class='fa-solid fa-cart-plus fa-lg'></i></td></tr>`;
            $("#wait_confirm_table_header").append(header_table);
            for (var i = 0; i < orderdetail_waitconfirm.length; i++) {
                var row_now = template;
                row_now = row_now.replace("[[--ID--]]", orderdetail_waitconfirm[i].id);
                row_now = row_now.replace("[[--ID--]]", orderdetail_waitconfirm[i].id);
                row_now = row_now.replace("[[--ID--]]", orderdetail_waitconfirm[i].id);
                row_now = row_now.replace("[[--FOOD_ID--]]", orderdetail_waitconfirm[i].food_id);
                row_now = row_now.replace("[[--ORDER_ID--]]", orderdetail_waitconfirm[i].order_id);
                row_now = row_now.replace("[[--QTY--]]", orderdetail_waitconfirm[i].qty);
                row_now = row_now.replace("[[--STATUS--]]", orderdetail_waitconfirm[i].status);
                row_now = row_now.replace("[[--INSERT_TIME--]]", orderdetail_waitconfirm[i].insert_time);
                row_now = row_now.replace("[[--FOOD_ID_X--]]", orderdetail_waitconfirm[i].food_id);
                row_now = row_now.replace("[[--NAME--]]", orderdetail_waitconfirm[i].name);
                row_now = row_now.replace("[[--DESCRIPTION--]]", orderdetail_waitconfirm[i].description);
                row_now = row_now.replace("[[--PRICE--]]", orderdetail_waitconfirm[i].price);
                row_now = row_now.replace("[[--IMAGE--]]", orderdetail_waitconfirm[i].image);
                row_now = row_now.replace("[[--CAT_ID--]]", orderdetail_waitconfirm[i].cat_id);
                $("#wait_confirm_table").append(row_now);

                ////////ADD EVENT TO CONFIRM BUTTON////////
                iconHover();
                $("#food_confirm_" + orderdetail_waitconfirm[i].id).click(function foodConfirmBtn() {
                    var orderdetail_id = $(this).attr('order-detail-id');
                    console.log(orderdetail_id);
                    confirmOrderDetail(orderdetail_id);
                });
            }
        }

        function showOrderDetailConfirmed(data) {
            orderdetail_confirmed = tryParseJsonObject(data);
            $("#confirmed_table_header").empty();
            $("#confirmed_table").empty();
            var template = `<tr><td>[[--ID--]]</td>
                <td>[[--CAT_ID--]]</td>
                <td>[[--FOOD_ID--]]</td>
                <td>[[--ORDER_ID--]]</td>
                <td>[[--QTY--]]</td>
                <td>[[--STATUS--]]</td>
                <td>[[--INSERT_TIME--]]</td>
                <td style="display:none;">[[--FOOD_ID_X--]]</td>
                <td>[[--NAME--]]</td>
                <td>[[--DESCRIPTION--]]</td>
                <td>[[--PRICE--]]</td>
                <td style='display:none;'>[[--IMAGE--]]</td></tr>`;
            $("#confirmed_table_header").append(header_table_confirmed);
            for (var i = 0; i < orderdetail_confirmed.length; i++) {
                var row_now = template;
                row_now = row_now.replace("[[--ID--]]", orderdetail_confirmed[i].id);
                row_now = row_now.replace("[[--ID--]]", orderdetail_confirmed[i].id);
                row_now = row_now.replace("[[--ID--]]", orderdetail_confirmed[i].id);
                row_now = row_now.replace("[[--FOOD_ID--]]", orderdetail_confirmed[i].food_id);
                row_now = row_now.replace("[[--ORDER_ID--]]", orderdetail_confirmed[i].order_id);
                row_now = row_now.replace("[[--QTY--]]", orderdetail_confirmed[i].qty);
                row_now = row_now.replace("[[--STATUS--]]", orderdetail_confirmed[i].status);
                row_now = row_now.replace("[[--INSERT_TIME--]]", orderdetail_confirmed[i].insert_time);
                row_now = row_now.replace("[[--FOOD_ID_X--]]", orderdetail_confirmed[i].food_id);
                row_now = row_now.replace("[[--NAME--]]", orderdetail_confirmed[i].name);
                row_now = row_now.replace("[[--DESCRIPTION--]]", orderdetail_confirmed[i].description);
                row_now = row_now.replace("[[--PRICE--]]", orderdetail_confirmed[i].price);
                row_now = row_now.replace("[[--IMAGE--]]", orderdetail_confirmed[i].image);
                row_now = row_now.replace("[[--CAT_ID--]]", orderdetail_confirmed[i].cat_id);
                $("#confirmed_table").append(row_now);
            }
        }

        ////////END ORDER DETAIL (ORDER FOOD)////////
        function addListenerToFoodTile(id) {
            var id_x = '#food_tile_id_' + id;
            $(id_x).css('cursor', 'pointer');
            $(id_x).off();
            $(id_x).mouseover(function () {
                $(this).css('background-color', 'rgba(104, 1, 1, 0.2)');
            });
            $(id_x).mouseout(function () {
                $(this).css('background-color', '#fff');
            });
            $(id_x).mousedown(function () {
                $(this).css({ 'background-color': '#8c0d07', 'color': '#fff' });
            });
            $(id_x).mouseup(function () {
                $(this).css({ 'background-color': 'rgba(104, 1, 1, 0.2)', 'color': '#000' });
            });
            $(id_x).click(function () {
                var food_id_x = $(this).attr('food-id');
                console.log(food_id_x);
                orderFood(food_id_x);
            });
        }

        function loadCategory() {
            $.get("category/output/ajax_get_all_category.php", function (data, status) {
                var categories = JSON.parse(data);
                food_categories = categories;
                for (var i = 0; i < categories.length; i++) {
                    var x = "<li><a href='#food_category_" + categories[i].id + "'>" + categories[i].name + "</a></li>"
                    $("#category_tab").append(x);
                    var y = "<div id='food_category_" + categories[i].id + "' class='food-item'></div>";
                    $(".render_post").append(y);
                }
                loadFood();
            });
        }
        function loadFood() {
            for (var i = 0; i < food_categories.length; i++) {
                $.get("food/output/ajax_get_all_food.php?cat_id=" + food_categories[i].id, function (data) {
                    var foods = JSON.parse(data);
                    //all_foods.push(foods);
                    for (var j = 0; j < foods.length; j++) {
                        var template_food = `<div id='food_tile_id_[[--ID--]]' class='food_tile' food-id='[[--ID--]]'>
                            <img src='[[--IMAGE_PATH--]]'/>
                            <h3>[[--NAME--]]</h3>
                            <p>[[--DESCRIPTION--]]</p>
                            <p>[[--PRICE--]] Baht</p>
                            </div>`;
                        var food = template_food;
                        food = food.replace("[[--ID--]]", foods[j].id);
                        food = food.replace("[[--ID--]]", foods[j].id);
                        food = food.replace("[[--NAME--]]", foods[j].name);
                        food = food.replace("[[--DESCRIPTION--]]", foods[j].description);
                        food = food.replace("[[--IMAGE_PATH--]]", foods[j].image);
                        food = food.replace("[[--PRICE--]]", foods[j].price);
                        $("#food_category_" + foods[j].cat_id).append(food);
                        addListenerToFoodTile(foods[j].id)
                    }
                });
            }
            $(function () {
                $("#tabs").tabs();
            });
        }
        $(document).ready(function () {
            loadCategory();
            showPopUp();
            $("#btn_open_table").click(function () {
                //////////////////VALIDATE//////////////////
                var table_no_x = $("#table_number").val();
                if (!isNaN(parseInt(table_no_x))) {

                }
                else {
                    $("#popup_number_only").show();
                    return;
                }
                ////////////////END VALIDATE////////////////
                console.log("post to create_order.php, table_no : " + table_no_x);
                //SEND HTTP POST TO CREATE NEW TABLE OR OPEN EXIT TABLE//
                $.post("create_order.php", { table_no: table_no_x }).done(function (data) {
                    console.log("POST FINISH " + data);
                    order_now = JSON.parse(data);
                    var c = "<b>ID</b> : " + order_now[0].id +
                        ", <b>Table Number</b> : " + order_now[0].table_no +
                        ", <b>Status</b> : " + order_now[0].status +
                        ", <b>Insert Time</b> : " + order_now[0].insert_time + "<br/><br/>";
                    $("#order_now").html(c);
                    closePopUp();
                    getOrderDetail();
                });
            });
        });

    </script>
</head>

<body>
    <div class="container-fluid" style="margin:0;padding:0;">
        <div class="popupBackground">
            <div class="popup">
                <h1>Welcome to EPT Restaurant</h1>
                <div class="box_form">
                    <div class="form-group">
                        <input type="text" class="form-control" id="table_number" placeholder="Enter Table No.">
                        <div id="popup_number_only" style="color:red;display:none;">Please Enter Your Table No.</div>
                    </div>
                    <button type="button" id="btn_open_table" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div id="tabs" class="box_container">
            <header>
                <ul id="category_tab">
                    <li><a href="#order_list">Food Order List</a></li>
                </ul>
            </header>
            <section class="render_post">
                <div id="order_list">
                    <h3>Food Order List [Status: Pending Confirmation]</h3><br />
                    <div id="order_now"></div>
                    <div class="wait_confirm table-responsive">
                        <table class="table table table-striped table-hover">
                            <thead id="wait_confirm_table_header">
                            </thead>
                            <tbody id="wait_confirm_table">
                            </tbody>
                        </table>
                    </div>
                    <br /><br />
                    <h3>Food Order List [Status: Confirmed]</h3><br />
                    <div class="confirmed table-responsive">
                        <table class="table table-striped table-hover">
                            <thead id="confirmed_table_header">
                            </thead>
                            <tbody id="confirmed_table">
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.min.js"></script>
</body>

</html>