<section id="result-section" class="row" style="display:none;">
  <div class="col-xs-12 section-header">
    <h4>Series</h4>
    <button id="close-button" type="button" name="button" onclick="hideResultSection();">X</button>
  </div>
  <div class="section-content">
    <div class="col-xs-12 col-sm-6 full-height">
      <table id="series-table" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Part</th>
            <th>Images</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    <div class="full-height col-xs-6 hidden-xs">
      <div id="thumb-div" class="row full-height"></div>
    </div>
  </div>
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
</section>
