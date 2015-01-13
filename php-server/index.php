<?php
    define('LEDS', 4);
    $state = file_get_contents("_STATE_");
    $led_state = array(false, false, false, false);
    $len = strlen($state);
    $i = 0;
    while ($i < $len && $i < LEDS) {
        if ($state[$i] == 'o' || $state[$i] == 'O')
            $led_state[$i] = true;
        ++$i;
    }

    $stats = json_decode(file_get_contents("stats.json"), true);
    date_default_timezone_set(UTC);
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>hector home automation</title>
        <link rel="stylesheet" href="./css/foundation.css" />
        <script src="./js/vendor/modernizr.js"></script>
        <link rel="shortcut icon" href="./resources/success.ico" type="image/x-icon">
        <link rel="icon" href="./resources/success.ico" type="image/x-icon">
        <style type="text/css">
        .label {
            -webkit-transition: background .5s;
        }
        .caps {
            text-transform: uppercase;
        }
        </style>
    </head>
<body>
<header>
    <nav class="top-bar" data-topbar="" role="navigation" id="header">
        <ul class="title-area">
            <li class="name">
                <h1><a href="#"> &nbsp;
                    Project HIOT
                </a>
                </h1>
            </li>
            
        </ul>

      
    <section class="top-bar-section">
        <!-- Right Nav Section -->
        <ul class="right">
            <li>
                <a href="javascript: void(0)" class="reset" > RESET </a>
            </li>
            <li class="has-dropdown not-click">
                <a href="#options">HIOT OPTIONS</a>
                <ul class="dropdown"><li class="title back js-generated"><h5><a href="javascript:void(0)">Back</a></h5></li>
                    <li id="dadd"><a href="#Add" >Add A Device</a></li>
                    <li><a href="#settings">Settings</a></li>
                    <li><a href="#logout" >Logout</a></li>
                </ul>
            </li>
                    </ul>
      </section></nav>
</header>

<section id="addd" style="display:none">
    <div class="row">
        <div class="large-12 columns">
           <h3> Add a Device </h3>
           <div class="panel">
                <form method="post" class="_d">
                    <div class="row">
                        <div class="large-6 columns">
                            <input type="text" placeholder="Device Name" id="dname" name="dname" regex="[a-zA-Z -_0-9]+">
                            <input type="text" placeholder="Pin Number" id="dpin" name="dpin" min="0"  regex="[0-9]+">
                            <input type="text" placeholder="Voltage in Volts (V)" id="dvolt" name="dvolt" min="0" regex="[0-9]+[.]*[0-9]*">
                            <input type="text" placeholder="Current in Amphere (A)" id="damphere" name="damphere" min="0" regex="[0-9]+[.]*[0-9]*">

                        </div>
                        <div class="large-6 columns">
                            <textarea placeholder="Device description..." id="ddesc" name="ddesc" style="height:145px" regex="[a-zA-Z0-9 .-_!#]*"></textarea>
                            <a class="button tiny secondary" id="dmapbutton" href="#map" >Plot device location on map</a>
                            <input type="hidden" name="dcoord" id="dcoord" value="0_0" regex="[0-9]+[.]*[0-9]*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-6 columns">
                            <a class="button tiny success" id="dsubmit">Add this Device</a>
                            <a class="button tiny alert" id="dreset">Reset & Cancel</a>

                        </div>
                    </div>

                </form>
           </div>
        </div>
    </div>
</section>
<section style="margin-top:30px">
<div class="row" style="text-align:center">
    <div class="large-12 columns">
        <table style="width:100%">
            <tr>
                <th> Identifier </th>
                <th> State </th>
                <th> Action </th>
                <th> Stats (Needs Reload)</th>
            </tr>
            <tr id='l0'>
                <td>TUBELIGHT</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led0" type="checkbox" name="testGroup" class="led" data-id="0" <?php if ($led_state[0]) echo " checked "; ?>>
                      <label for="led0"></label>
                    </div>                   
                </td>
                <td>   
                    <span class="label caps success">Total Run:</span> <?= $stats[0]['total_run']; ?>s 
                    <br>
                    <span class="label caps success">Running Since:</span> <?php if ($stats[0]['last_started'] == -1) echo "its OFF"; else echo date("D, d M 'y H:i:s", $stats[0]['last_started']); ?>
                </td>
            </tr>
            <tr id='l1'>
                <td>CFL</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led1" type="checkbox" name="testGroup" class="led" data-id="1" <?php if ($led_state[1]) echo " checked "; ?>>
                      <label for="led1"></label>
                    </div> 
                </td>
                <td>   
                    <span class="label caps success">Total Run:</span> <?= $stats[1]['total_run']; ?>s 
                    <br>
                    <span class="label caps success">Running Since:</span> <?php if ($stats[1]['last_started'] == -1) echo "its OFF"; else echo date("D, d M 'y H:i:s", $stats[1]['last_started']); ?>
                </td>
            </tr>
            <tr id='l2'>
                <td>FAN</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led2" type="checkbox" name="testGroup" class="led" data-id="2" <?php if ($led_state[2]) echo " checked "; ?>>
                      <label for="led2"></label>
                    </div> 
                </td>
                <td>   
                    <span class="label caps success">Total Run:</span> <?= $stats[2]['total_run']; ?>s 
                    <br>
                    <span class="label caps success">Running Since:</span> <?php if ($stats[2]['last_started'] == -1) echo "its OFF"; else echo date("D, d M 'y H:i:s", $stats[2]['last_started']); ?>
                </td>
            </tr>
            <tr id='l3'>
                <td>LED - 2</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led3" type="checkbox" name="testGroup" class="led" data-id="3" <?php if ($led_state[3]) echo " checked "; ?>>
                      <label for="led3"></label>
                    </div> 
                </td>
                <td>   
                    <span class="label caps success">Total Run:</span> <?= $stats[3]['total_run']; ?>s 
                    <br>
                    <span class="label caps success">Running Since:</span> <?php if ($stats[3]['last_started'] == -1) echo "its OFF"; else echo date("D, d M 'y H:i:s", $stats[3]['last_started']); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
</section>
<script src="./js/jquery.js"></script>
<script src="./js/fastclick.js"></script>
<script src="./js/foundation.min.js"></script>
<script>
    var LEDS = 4;
    $(document).foundation();
    $(document).ready(function() {
        $(".led").on("change", function() {
            var string = '';
            $(".led").each(function() {
                var id = parseInt($(this).attr("data-id"));
                if (this.checked) string += 'o';
                else string += 'f';
            });
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './server.php?state=' +string);
            xhr.string = string;
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    for(i = 0; i < LEDS; i++) {
                        if (this.string[i] == 'o') {
                            $("#l" +i +" td").eq(1).children("span").removeClass("secondary").addClass("success").html("ON");

                        } else {
                            $("#l" +i +" td").eq(1).children("span").removeClass("success").addClass("secondary").html("OFF");
                        }
                    }
                }
            };
            xhr.send();
        });

        $(".reset").on('click', function() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', './server.php?state=');
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (parseInt(this.responseText) == 1) {
                            location.reload();
                        }
                    }
                }
                xhr.send();
        });

        $("#dsubmit").on('click', function(e) {
            var s = true;
            $("._d input, ._d textarea").each(function() {
                var r = new RegExp($(this).attr("regex"));
                var arr = r.exec($(this).val());
                if (arr != null && arr.length) {
                    $(this).css("border", "1px solid yellowGreen");
                } else {
                    $(this).css("border", "1px solid red");
                    s = false;
                }
            });
            if (s) this.parentNode.parentNode.parentNode.submit();
            e.preventDefault();
        });
        $("#dreset").on('click', function() {
            this.parentNode.parentNode.parentNode.reset();
            $("#addd:visible").slideUp();
        });
        $("#dadd").on('click', function() {
            $("#addd").slideDown();
            $("._d input, ._d textarea").each(function() {
                $(this).css("border", "");
            });
        });


    });


</script>
</body>
</html>