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
        </style>
    </head>
<body>
<header style="text-align: center; margin-top: 50px">
   <h1>Hector home automation project</h1>
</header>
<section style="margin-top:30px">
<div class="row" style="text-align:center">
    <div class="large-12 columns">
        <table style="width:100%">
            <tr>
                <th>Identifier</th>
                <th>State</th>
                <th>
                    Action
                    <a href="./" class="button round secondary tiny" style="float:right;margin: 0px;display: inline-block;">reset</a>
                </th>
            </tr>
            <tr id='l0'>
                <td>LED - 0</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led0" type="checkbox" name="testGroup" class="led" data-id="0">
                      <label for="led0"></label>
                    </div>                   
                </td>
            </tr>
            <tr id='l1'>
                <td>LED - 1</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led1" type="checkbox" name="testGroup" class="led" data-id="1">
                      <label for="led1"></label>
                    </div> 
                </td>
            </tr>
            <tr id='l2'>
                <td>LED - 2</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led2" type="checkbox" name="testGroup" class="led" data-id="2">
                      <label for="led2"></label>
                    </div> 
                </td>
            </tr>
            <tr id='l3'>
                <td>LED - 3</td>
                <td><span class="label secondary">OFF</span></td>
                <td>
                    <div class="switch round large">
                      <input id="led3" type="checkbox" name="testGroup" class="led" data-id="3">
                      <label for="led3"></label>
                    </div> 
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
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './server.php?state=');
    xhr.send();

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
    });


</script>
</body>
</html>