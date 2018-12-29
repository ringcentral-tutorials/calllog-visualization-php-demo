<?php

$html = '<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Call Logs Visualization Demo</title>
    <script src="public/js/main.js" type="text/javascript"></script>
    <script src="public/js/jquery-3.1.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <script>
      function showOptions(elm){
        if ($("#more_options").is(":visible")){
          $("#more_options").hide()
          $(elm).text("More options")
        }else{
          $("#more_options").show()
          $(elm).text("Less options")
        }
      }
  </script>
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="/" class="navbar-brand"><b>Call Logs</b> VISUALIZATION</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="https://www.ringcentral.com" target="_blank">Powered by&nbsp;<img alt="Brand" src="public/img/ringcentral.png" height="20"></a></li>
      </ul>
    </div>
  </nav>
  <section id="content">
    <form class="form-inline">
      <div class="form-group">
        <label for="fromDate">From Date</label>
          <input type="text" id="fromdatepicker"></input>&nbsp;&nbsp;
        <label for="toDate">To Date</label>
          <input type="text" id="todatepicker"></input>&nbsp;
        <button type="button" class="btn-button" onclick="showOptions(this)" style="display:inline">Show options</button>
        <button type="button" class="btn-call" onclick="readCallLogs()" style="display:inline">Read</button>
        &nbsp;&nbsp;
        <label for="access_level">Access level</label>
        <select name="access_level" id="access_level" style="display:inline">
          <option value="account" selected>Account</option>
          <option value="user">Extension</option>
        </select>

        <div id="more_options">
          <label for="phoneNumber">Phone Number</label>
            <input id="phoneNumber" type="text" size="15" style="display:inline"></input>&nbsp;&nbsp;
          <label for="extension">Extension</label>
            <input id="extension" type="text" name="extension" size="5" ></input>&nbsp;&nbsp;

          <label for="direction">Direction</label>
          <select name="direction" id="direction" style="display:inline">
            <option value="default" selected>Default</option>
            <option value="Inbound">Inbound</option>
            <option value="Outbound">Outbound</option>
          </select>&nbsp;&nbsp;
          <label for="type">Type</label>
          <select name="type" id="type" style="display:inline">
            <option value="default" selected>Default</option>
            <option value="Voice">Voice</option>
            <option value="Fax">Fax</option>
          </select>&nbsp;&nbsp;
          <label for="transport">Transport</label>
          <select name="transport" id="transport" style="display:inline">
            <option value="default" selected>Default</option>
            <option value="PSTN">PSTN</option>
            <option value="VoIP">VoIP</option>
          </select>&nbsp;&nbsp;
          <label for="view">View</label>
          <select name="view" id="view" style="display:inline">
            <option value="Simple" selected>Simple</option>
            <option value="Detailed">Detailed</option>
          </select>&nbsp;&nbsp;
          <input type="checkbox" id="showBlocked" checked=true> Show blocked</input>&nbsp;&nbsp;
          <input type="checkbox" id="withRecording"> With recording</input>
      </div>
      </div>
    </form>
    <hr>
    <div class="row">
      <div class="col-xs-12">
        <label for="graphoption">Select Graphs</label>
        <select id="graphoption" onchange="drawGraphs()">
          <option value="callbytype">Calls Types</option>
          <option value="callbyduration">Calls Duration & Recording</option>
          <option value="faxbyduration">Faxes Duration</option>
          <option value="incallwithresults">Inbound Calls with Results</option>
          <option value="outcallwithresults">Outbound Calls with Results</option>
          <option value="infaxwithresults">Inbound Faxes with Results</option>
          <option value="outfaxwithresults">Outbound Faxes with Results</option>
          <option value="incallwithactions">Inbound Calls with Actions</option>
          <option value="outcallwithactions">Outbound Calls with Actions</option>
          <option value="infaxwithactions">Inbound Faxes with Actions</option>
          <option value="outfaxwithactions">Outbound Faxes with Actions</option>
          <option value="callsdensity">Calls Density</option>
          <option value="callsmap">Calls Map</option>
        </select>&nbsp;&nbsp;&nbsp;&nbsp;
        <span id="timezone_block" style="display:none">
          <label for="timezone">Time zone</label>
          <select id="timezone" onchange="refreshGraph()" style="display:inline">
            <option value="-12">-12</option>
            <option value="-11">-11</option>
            <option value="-10">-10</option>
            <option value="-9">-9</option>
            <option value="-8">-8</option>
            <option value="-7">-7</option>
            <option value="-6">-6</option>
            <option value="-5">-5</option>
            <option value="-4">-4</option>
            <option value="-3">-3</option>
            <option value="-2">-2</option>
            <option value="-1">-1</option>
            <option value="0" selected>0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
          </span>
          <span id="map_block" style="display:none">
          <label for="onmap">Direction</label>
            <select id="onmap" onchange="refreshGraph()" style="display:inline">
              <option value="both" selected>Both</option>
              <option value="inbound">Inbound</option>
              <option value="outbound">Outbound</option>
            </select>
          </span>
          <table>
            <tr id="graphs"></tr>
          </table>
        </div>
    </div>
  </section>
</body>
</html>';
echo ($html);
