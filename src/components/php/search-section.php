<?php require_once 'main-functions.php'; ?>
<section id="search-section" class="row">
  <form id="search-from" class="col-xs-12" role="form">

    <div class="search-input-group">
      <input id="searchById" type="search" class="form-control search-control" placeholder="Id">
      <button type="button" name="button" class="reset-search">x</button>
    </div>

    <div class="search-input-group">
      <input id="searchByName" type="search" class="form-control search-control" placeholder="Name">
      <button type="button" name="button" class="reset-search">x</button>
    </div>

    <div class="search-input-group hidden-xs">
      <input id="searchByAccession" type="search" class="form-control search-control" placeholder="Accession No.">
      <button type="button" name="button" class="reset-search">x</button>
    </div>

    <select title="Modality" id="searchByModality" class="form-control search-control hidden-xs selectpicker" multiple>
      <option value="all">All</option>
      <?php loadAllModalities($pritnModOption) ?>
    </select>

    <select title="Institution" id="searchByInstitution" class="form-control search-control hidden-xs selectpicker" data-live-search="true">
      <option value="all">All</option>
      <?php loadAllInstitution($printInstOption) ?>
    </select>

    <div class="search-input-group hidden-xs">
      <input id="searchByFrom" type="text" class="form-control search-control" placeholder="From">
      <button type="button" name="button" class="reset-search">x</button>
    </div>

    <div class="search-input-group hidden-xs">
      <input id="searchByTo" type="text" class="form-control search-control" placeholder="To">
      <button type="button" name="button" class="reset-search">x</button>
    </div>

  </form>
  <div class="test">
    <button id="close-search" type="button" name="button"><span class="glyphicon glyphicon-arrow-up"></span></button>
  </div>
</section>
