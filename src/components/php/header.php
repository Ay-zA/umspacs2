<nav class="navbar navbar-inverse navbar-static-top no-margin-bottom" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">UMS-<span>PACS</span></a>


      <ul class="nav nav-xs visible-xs" style="float:left;">
        <li>
          <a id="all-xs" href="#">
            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>All / Reset</a>
        </li>
        <li>
          <a id="today-xs" href="#">
            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>Today</a>
        </li>
      </ul>
      <ul class="nav nav-xs visible-xs" style="float:right;">
        <li>
          <button type="button" class="searchButton btn btn-default navbar-btn"><span class="glyphicon glyphicon-search"></button>
        </li>
        <li>
          <button type="button" class="searchButton btn btn-default navbar-btn" onclick="window.open('src/components/php/logout.php','_self');"><span class="glyphicon glyphicon-log-out"></button>
        </li>
      </ul>

      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active hidden-xs">
            <a id="all" href="#"><div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>All / Reset</a>
    </li>
    <li class="hidden-xs">
      <a id="today" href="#">
        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>Today</a>
    </li>
    <li>
      <a id="yesterday" href="#">
        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>Yesterday</a>
    </li>
    <li>
      <a id="last-week" href="#">
        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>Lastweek</a>
    </li>
    <li>
      <a id="last-month" href="#">
        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>Last Month</a>
    </li>
    </ul>
    <ul class="nav navbar-nav navbar-right hidden-xs">
      <li>
        <a class="searchButton" href="#">Search</a>
      </li>
      <li class="dropdown">

        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo ucwords($_SESSION['dicom_username']);?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="setting.php"><span class="glyphicon glyphicon-cog"><span> Setting</a></li>
            <li><a href="src/components/php/logout.php"><span class="glyphicon glyphicon glyphicon-off"><span> Logout</a><li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
  </div>
</nav>
