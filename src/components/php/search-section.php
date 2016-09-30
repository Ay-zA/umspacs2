<?php require_once 'main-functions.php'; ?>
<section id="search-section" class="row">
  <form id="search-from" class="col-xs-12" role="form">
    <input id="searchById" type="search" class="form-control search-control" placeholder="Id">
    <input id="searchByName" type="search" class="form-control search-control" placeholder="Name">
    <input id="searchByAccession" type="search" class="form-control search-control hidden-xs" placeholder="Accession No.">
      <select title="Modality" id="searchByModality" class="form-control search-control hidden-xs selectpicker" multiple >
        <?php loadAllModalities($pritnModOption) ?>
      </select>
    <select title="Institution" id="searchByInstitution" class="form-control search-control hidden-xs selectpicker" data-live-search="true">
        <?php loadAllInstitution($printInstOption) ?>
    </select>
    <input id="searchByFrom" type="text" class="form-control search-control hidden-xs" placeholder="From">
    <input id="searchByTo" type="text" class="form-control search-control hidden-xs" placeholder="To">
  </form>
</section>
