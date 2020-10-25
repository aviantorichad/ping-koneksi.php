<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$get_timer = isset($_GET['timer']) ? $_GET['timer'] : 10;

$start = $get_timer;
// ************* list ip/host.begin **************
$hosts = [];
$hosts['AP'] = '192.168.1.1';
$hosts['GOOGLE'] = 'google.com';
$hosts['YOUTUBE'] = 'youtube.com';
$hosts['FACEBOOK'] = 'facebook.com';
$hosts['INSTAGRAM'] = 'instagram.com';
$hosts['TWITTER'] = 'twitter.com';
$hosts['DETIK'] = 'detik.com';
// ************* list ip/host.end ****************
function Ping($host, $timeout = 10)
{
  $timeout = $get_timer ?? $timeout;
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // echo 'This is a server using Windows!';
    $os = "win";
  } else {
    // echo 'This is a server not using Windows!';
    $os = "lin";
  }

  $output = array();
  if ($os == "lin") {
    $com = 'ping -n -w ' . $timeout . ' -c 1 ' . escapeshellarg($host);
  }
  if ($os == "win") {
    $com = 'ping -w ' . $timeout . ' -n 2 ' . escapeshellarg($host);
  }

  $exitcode = 0;
  exec($com, $output, $exitcode);

  if ($exitcode == 0 || $exitcode == 1) {
    foreach ($output as $cline) {
      if ($os == "lin") {
        if (strpos($cline, ' bytes from ') !== false) {
          $out = (int)ceil(floatval(substr($cline, strpos($cline, 'time=') + 5)));
          return $out;
        }
      }
      if ($os == "win") {
        if (strpos($cline, 'Reply from ') !== false) {
          $out = (int)ceil(floatval(substr($cline, strpos($cline, 'time=') + 5)));
          return $out;
        }
      }
    }
  }

  return false;
}

if (isset($_GET['host'])) {
  $ping = Ping($_GET['host']);
  echo $ping;
  exit();
}
?>

<script>
  function ngeping(liid, host) {
    window['total-' + liid]++;
    var lid = document.getElementById(liid);
    var hid = document.getElementById("h" + liid);

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //total
        document.getElementById('total-' + liid).innerHTML = window['total-' + liid];
        var result = this.responseText;
        var width = this.responseText;
        var cssHeight = this.responseText * 50 / 250;
        if (result == '') {
          result = "-";
          width = "1";
        }

        var currentdate = new Date();
        var datetime = currentdate.getDate() + "/" +
          (currentdate.getMonth() + 1) + "/" +
          currentdate.getFullYear() + " " +
          currentdate.getHours() + ":" +
          currentdate.getMinutes() + ":" +
          currentdate.getSeconds();

        lid.style.width = width + "px";
        lid.innerHTML = result;

        //min
        if (Number(window['min-' + liid]) == 0) {
          window['min-' + liid] = result;
          document.getElementById('min-' + liid).innerHTML = result;
        } else if (Number(result) < Number(window['min-' + liid])) {
          window['min-' + liid] = result;
          document.getElementById('min-' + liid).innerHTML = result;
        } else {}

        //max
        if (Number(result) > Number(window['max-' + liid])) {
          window['max-' + liid] = result;
          document.getElementById('max-' + liid).innerHTML = result;
        }

        if (result >= 500) {
          lid.style.backgroundColor = "#f77";
          var para = document.createElement("span");
          para.style.backgroundColor = "#f77";
          para.style.padding = "3px";
          para.style.color = "#222";
          para.style.display = "inline-block";
          para.style.verticalAlign = "bottom";
          para.style.height = cssHeight;
          para.style.maxHeight = "90px";
          para.title = datetime;
          var node = document.createTextNode(result);
          para.insertBefore(node, para.firstChild);
          //last up
          document.getElementById('lu-' + liid).innerHTML = ' #' + window['total-' + liid] + ' @ ' + datetime;
        } else if (result > 200 && result < 500) {
          lid.style.backgroundColor = "#ff7";
          var para = document.createElement("span");
          para.style.backgroundColor = "#ff7";
          para.style.padding = "3px";
          para.style.color = "#222";
          para.style.display = "inline-block";
          para.style.verticalAlign = "bottom";
          para.style.width = "20px";
          para.style.height = cssHeight;
          para.style.maxHeight = "80px";
          para.title = datetime;
          var node = document.createTextNode(result);
          //last up
          document.getElementById('lu-' + liid).innerHTML = ' #' + window['total-' + liid] + ' @ ' + datetime;
          para.insertBefore(node, para.firstChild);
        } else if (result == '-') {
          lid.style.backgroundColor = "white";
          var para = document.createElement("span");
          para.style.backgroundColor = "blue";
          para.style.padding = "3px";
          para.style.color = "#222";
          para.style.display = "inline-block";
          para.style.verticalAlign = "bottom";
          para.style.width = "20px";
          para.style.height = cssHeight;
          para.style.maxHeight = "100px";
          para.title = datetime;
          var node = document.createTextNode(result);
          para.insertBefore(node, para.firstChild);
          //down nih
          window['down-' + liid]++;
          document.getElementById('down-' + liid).innerHTML = window['down-' + liid];
          document.getElementById('ld-' + liid).innerHTML = ' #' + window['total-' + liid] + ' @ ' + datetime;
        } else {
          lid.style.backgroundColor = "#7f7";
          var para = document.createElement("span");
          para.style.backgroundColor = "#7f7";
          para.style.padding = "3px";
          para.style.color = "#222";
          para.style.display = "inline-block";
          para.style.verticalAlign = "bottom";
          para.style.width = "20px";
          para.style.height = cssHeight;
          para.style.maxHeight = "70px";
          para.title = datetime;
          var node = document.createTextNode(result);
          para.insertBefore(node, para.firstChild);
          //last up
          document.getElementById('lu-' + liid).innerHTML = ' #' + window['total-' + liid] + ' @ ' + datetime;
        }
        hid.insertBefore(para, hid.firstChild);
      }
      window['persen-' + liid] = (Number(window['total-' + liid]) - Number(window['down-' + liid])) / Number(window['total-' + liid]) * 100;
      document.getElementById('persen-' + liid).innerHTML = window['persen-' + liid].toFixed(2) + '%';
      if (window['persen-' + liid] < 50) {
        document.getElementById('th-' + liid).style.backgroundColor = 'maroon';
      } else {
        document.getElementById('th-' + liid).style.backgroundColor = 'transparent';
      }
    };
    xhttp.open("POST", "?host=" + host, true);
    xhttp.send();
  }

  function doPing() {
    i = <?= $start ?>;
    <?php foreach ($hosts as $key => $value) {
      echo "ngeping('" . $key . "', '" . $value . "');";
    }
    ?>
  }

  function doPingInterval() {
    document.getElementById('btnStopPingInterval').style.display = "inline-block";
    document.getElementById('btnDoPing').style.display = "none";
    document.getElementById('btnDoPingInterval').style.display = "none";
    pingterus = setInterval(function() {
      counters()
    }, 1000);
  }

  function stopPingInterval() {
    document.getElementById('btnDoPingInterval').style.display = "inline-block";
    document.getElementById('btnDoPing').style.display = "inline-block";
    document.getElementById('btnStopPingInterval').style.display = "none";
    clearInterval(pingterus);
    xhttp.abort();
  }

  var i = <?= $start ?>;

  function counters() {
    var id = document.getElementById('counter');
    id.innerHTML = i;

    if (i == 0) {
      doPing();
    }
    i--;
  }

  document.addEventListener("DOMContentLoaded", function(event) {
    //code autoload...
  });

  function gantiTimer() {
    var a = prompt('Timer (default:10)', 10);
    if (a) {
      window.location.href = '?timer=' + a;
    }
  }
</script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pingku by @aviantorichad</title>
<style>
  body {
    font-size: 14px;
    font-family: helvetica, arial, sans;
    background: #222;
    color: #ddd;
  }

  .list {
    padding: 3px;
    border-bottom: 1px solid #555;
    list-style: none;
    width: 100%;
  }

  .hist {
    padding: 3px;
    border-bottom: 1px solid #555;
    list-style: none;
    width: 100%;
  }

  .label {
    width: 150px;
    display: inline-block;
    font-weight: bold;
    color: gold;
  }

  .desc,
  .status,
  .total {
    width: 150px;
    font-size: 10px;
    display: inline-block;
  }

  .result {
    display: inline-block;
    color: #000;
    font-size: 10px;
    white-space: nowrap;
    width: auto;
    width: 300px;
    overflow: scroll;
  }

  .hist .result {
    padding: 3px;
    display: inline-block;
    max-width: 75%;
    color: #fff;
  }

  ::-webkit-scrollbar {
    width: 0px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: rgb(0, 0, 0);
    border: 4px solid transparent;
    background-clip: content-box;
    /* THIS IS IMPORTANT */
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #2d2d2d;
    border: 1px solid rgb(0, 0, 0);
  }

  button {
    background: #333;
    border: 1px solid #555;
    padding: 5px;
    color: #888;
    cursor: pointer;
  }

  button:hover {
    background: #034;
    color: #fff;
  }

  .tr {
    width: 33.33%;
    display: inline-block;
    margin-bottom: 20px;
  }

  .th {
    vertical-align: bottom;
    display: inline-block;
  }

  .td {
    height: 100px;
    vertical-align: bottom;
    background: #111;
    display: inline-block;
  }

  @media only screen and (max-width: 600px) {
    .tr {
      width: 100%;
      display: inline-block;
      margin-bottom: 20px;
    }

  }
</style>
<button name="btnDoingInterval" id="btnDoPingInterval" onclick="doPingInterval()">[>] Play Ping</button>
<button name="btnStopPingInterval" id="btnStopPingInterval" onclick="stopPingInterval()" style="display:none;">[x] Stop Ping</button>
<button name="counter" onClick="gantiTimer()">Timer: <span id="counter">0</span></button>
<button name="btnDoPing" id="btnDoPing" onclick="doPing()">Ping Sekali</button>
<ul>
  <?php foreach ($hosts as $key => $value) {
    echo '<li class="list" style="display:none"><span class="label">' . $key . '</span><br/><span class="desc">(' . $value . ')</span>: <span id="' . $key . '" title="' . $value . '" class="result"></span></li>';
  }
  ?>
</ul>
<div class="table" style="width:100%" border=0>
  <?php
  $x = 0;
  foreach ($hosts as $key => $value) {
    $bgcolor = ($x % 2 == 0) ? '#000' : '#111';
    echo '<div class="tr">
            <div class="th" id="th-' . $key . '">
              <span class="label">' . $key . '</span>
              <br/>
              <span class="desc"><a href="http://' . $value . '" target="_blank" style="color:#da0">(' . $value . ')</a></span>
              <br/>
              <span class="status">min/max: <b id="min-' . $key . '">0</b>/<b id="max-' . $key . '">0</b></span>
              <br/>
              <span class="total">down/total: <b id="down-' . $key . '">0</b>/<b id="total-' . $key . '">0</b></span>
              <br/>
              <span class="total" title="last up">lU <u id="lu-' . $key . '">-</u></span>
              <br/>
              <span class="total" title="last down">lD <u id="ld-' . $key . '">-</u></span>
              <br/>
              <span class="persen"><b id="persen-' . $key . '">0%</b></span>
            </div>
            <div class="td" style="background:' . $bgcolor . '">
              <div id="h' . $key . '" title="' . $value . '" class="result custom_scrollbar"></div>
              <div style="height:100px;background:red;display:inline-block;"></div>
              
          <script>
          window["persen-' . $key . '"] = 0;
          window["total-' . $key . '"] = 0;
          window["down-' . $key . '"] = 0;
          window["lu-' . $key . '"] = 0;
          window["ld-' . $key . '"] = 0;
          window["min-' . $key . '"] = 0;
          window["old-min-' . $key . '"] = 0;
          window["max-' . $key . '"] = 0;
          window["old-max-' . $key . '"] = 0;
          </script>
            </div>
          </div>';
    $x++;
  }
  ?>
</div>