<!-- TODO Up and down button -->
<section id="study-section" class="row">
  <div id="patient-table-div" class="col-xs-12 full-height">
    <div id="loadingDiv">
      <div>
        <img id="result-label" src="src/images/ring.svg"></img>
        <h4>Loading...</h4>
      </div>
    </div>
    <table id="patient-table" class="table table-striped table-hover" style="font-size: small;">
      <thead>
        <tr>
          <th>Patient Id</th>
          <th>Name</th>
          <th>Institution</th>
          <th>Accession No.</th>
          <th>Mod</th>
          <th>Date/Time</th>
          <th class="hidden-xs">Info</th>
          <th class="hidden-xs">Viewer</th>
        </tr>
      </thead>

      <tbody>

      </tbody>
    </table>
        <nav class="text-center" id="study-pagination" aria-label="Page navigation">
          <ul class="pagination">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="active"><a href="#">1</a></li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
          <div id="result-information" class=""></div>
        </nav>
      </div>
</section>
