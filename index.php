<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$start = 10;

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
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // echo 'njenengan ngagem windows';
    $os = "win";
  } else {
    // echo 'njenengan mboten ngagem windows';
    $os = "lin";
  }

  $output = array();
  if ($os == "lin") {
    $com = 'ping -n -w ' . $timeout . ' -c 1 ' . escapeshellarg($host);
  }
  if ($os == "win") {
    $com = 'ping -w ' . $timeout . ' -n 1 ' . escapeshellarg($host);
  }

  $exitcode = 0;
  exec($com, $output, $exitcode);

  if ($exitcode == 0 || $exitcode == 1) {
    foreach ($output as $cline) {
      if ($os == "lin") {
        if (strpos($cline, ' bytes from ') !== false) {
          $out = (int) ceil(floatval(substr($cline, strpos($cline, 'time=') + 5)));
          return $out;
        }
      }
      if ($os == "win") {
        if (strpos($cline, 'Reply from ') !== false) {
          $out = (int) ceil(floatval(substr($cline, strpos($cline, 'time=') + 5)));
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
    var lid = document.getElementById(liid);
    var hid = document.getElementById("h" + liid);

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
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
          currentdate.getFullYear() + " @ " +
          currentdate.getHours() + ":" +
          currentdate.getMinutes() + ":" +
          currentdate.getSeconds();

        lid.style.width = width + "px";
        lid.innerHTML = result;

        if (result >= 500) {
          lid.style.backgroundColor = "#f77";
          var para = document.createElement("span");
          para.style.backgroundColor = "#f77";
          para.style.padding = "3px";
          para.style.color = "#222";
          para.style.display = "inline-block";
          para.style.verticalAlign = "bottom";
          para.style.height = cssHeight;
          para.style.maxHeight = "100px";
          para.title = datetime;
          var node = document.createTextNode(result);
          para.insertBefore(node, para.firstChild);
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
          para.style.maxHeight = "100px";
          para.title = datetime;
          var node = document.createTextNode(result);
          para.insertBefore(node, para.firstChild);
        } else if (result == '-') {
          lid.style.backgroundColor = "#ddd";
          var para = document.createElement("span");
          para.style.backgroundColor = "#ddd";
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
          para.style.maxHeight = "100px";
          para.title = datetime;
          var node = document.createTextNode(result);
          para.insertBefore(node, para.firstChild);
        }
        hid.insertBefore(para, hid.firstChild);
      }
    };
    xhttp.open("GET", "?host=" + host, true);
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
</script>

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
  }

  .desc {
    width: 150px;
    font-size: 10px;
    display: inline-block;
  }

  .result {
    padding: 3px;
    display: inline-block;
    color: #000;
  }

  .hist .result {
    padding: 3px;
    display: inline-block;
    max-width: 75%;
    color: #fff;
  }

  ::-webkit-scrollbar {
    width: 10px;
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
</style>
<button name="btnDoingInterval" id="btnDoPingInterval" onclick="doPingInterval()">[>] Play Ping</button>
<button name="btnStopPingInterval" id="btnStopPingInterval" onclick="stopPingInterval()" style="display:none;">[x] Stop Ping</button>
<button name="counter">Timer: <span id="counter">0</span></button>
<button name="btnDoPing" id="btnDoPing" onclick="doPing()">Ping Sekali</button>
<ul>
  <?php foreach ($hosts as $key => $value) {
    echo '<li class="list" style="display:none"><span class="label">' . $key . '</span><br/><span class="desc">(' . $value . ')</span>: <span id="' . $key . '" title="' . $value . '" class="result"></span></li>';
  }
  ?>
</ul>
<table style="width:100%" border=0>
  <?php foreach ($hosts as $key => $value) {
    echo '<tr>
            <td style="width:100px;vertical-align:bottom;height:100px;">
              <span class="label">' . $key . '</span>
              <br/>
              <span class="desc">(' . $value . ')</span>
            </td>
            <td style="height:100px;vertical-align:bottom;background:#111">
              <div id="h' . $key . '" title="' . $value . '" class="result custom_scrollbar" style="font-size:10px;white-space: nowrap;width:1000px;overflow:auto;"></div>
            </td>
          </tr>';
  }
  ?>
</table>
<!-- 
kula nuwun
matur nuwun sampun ngagem aplikasi niki
aplikasi niki awalipun damel monitor koneksi internal kulo
sakniki badhe kulo share damel njenengan2 menawi gadah kebutuhan ingkang sami kaliyan kulo
nuwun sewu menawi badhe dimodifikasi ampun nghapus/ngubah "kredit" nami kulo ting aplikasi niki, 
sakestu, sepele nanging berarti kagem kulo

menawi badhe donasi kulo nggih nampi lan saged dikirim ting bank meniko
BANK BCA : 8715-9843-81 a/n Richad Avianto
PAYPAL : aviantorich@gmail.com


*dilarang keras memodifikasi/menghapus kredit aviantorichad dan mengkomersilkan aplikasi ini tanpa seijin dari aviantorich@gmail.com

author: Richad Avianto
alias: aviantorichad
github: github.com/aviantorichad 
kritik/saran/bug: kirim email ke aviantorich@gmail.com atau kirim issue ke github
-->