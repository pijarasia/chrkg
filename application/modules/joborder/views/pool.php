<div class='content-inner well'>
  <form class="form-horizontal" id="sform" method='post'>
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
            Search By
          </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse">
          <div class="accordion-inner">
            <div class="control-group">
              <label class="control-label" for="s_title">Title</label>
              <div class="controls">
                <input type="text" id="s_title" name='s_title' placeholder="Title" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_owner">Owner</label>
              <div class="controls">
                <input type="text" id="s_owner" name='s_owner' placeholder="Owner" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_company">Company</label>
              <div class="controls">
                <input type="text" id="s_company" name='s_company' placeholder="Company" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_type">Type</label>
              <div class="controls">
                <input type="text" id="s_type" name='s_type' placeholder="Type" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_start">Start</label>
              <div class="controls">
                <input type="text" id="s_start" name='s_start' placeholder="Start" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_duration">Duration</label>
              <div class="controls">
                <input type="text" id="s_duration" name='s_duration' placeholder="Duration" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i>Search</button></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>
  <div class="btn-toolbar">
    <div class="btn-group">
      <button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">Job Type <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#">Only Open Jobs</a></li>
        <li><a href="#">Only Closed Jobs</a></li>
        <li><a href="#">All Jobs</a></li>
      </ul>
    </div>
    <div class="btn-group">
      <button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">Location <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#">All Location</a></li>
        <li><a href="#">All</a></li>
      </ul>
    </div>
    <div class="btn-group">
      <button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">Verticals <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#">All Verticals</a></li>
        <li><a href="#">All</a></li>
      </ul>
    </div>
    <div class="btn-group">
      <button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">Recruiters <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#">All Internal Recruiters</a></li>
        <li><a href="#">All</a></li>
      </ul>
    </div>
  </div>
  <div class="btn-toolbar">
    <div class="btn-group">
      <button class="btn btn-mini btn-success" onclick="return Document.firstPage()"></i>First</button>
    </div>
    <div class="btn-group">
      <button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">Row/Page <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a onclick='Document.search(10);'>10</a></li>
        <li><a onclick='Document.search(20);'>20</a></li>
        <li><a onclick='Document.search(40);'>40</a></li>
        <li><a onclick='Document.search(60);'>60</a></li>
        <li><a onclick='Document.search(80);'>80</a></li>
        <li><a onclick='Document.search(100);'>100</a></li>
      </ul>
    </div>
    <div class="btn-group">
      <button class="btn btn-mini btn-success" onclick="return Document.lastPage()"></i>Last</button>
    </div>
    <div class="btn-group">
      <button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">Add to List <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#">Selected</a></li>
        <li><a href="#">All</a></li>
      </ul>
    </div>
    <div class="btn-group">
      <button class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">Exported <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#">Selected</a></li>
        <li><a href="#">All</a></li>
      </ul>
    </div>
  </div>

  <table class="table-bordered table-striped table-condensed cf">
    <thead>
      <th>Vacancy</th>
      <th><span class="label label-inverse">Seleksi CV</span></th>
      <th><span class="label label-inverse">Inv HR</span></th>
      <th><span class="label label-inverse">Inv User</span></th>
      <th><span class="label label-inverse">Inv User 2</span></th>
      <th><span class="label label-inverse">Test Bidang</span></th>
      <th><span class="label label-inverse">Psikotest</span></th>
      <th><span class="label label-inverse">MCU</span></th>
      <th><span class="label label-inverse">Persentasi</span></th>
      <th><span class="label label-inverse">Hires</span></th>
    </thead>
    <tbody id='myjob' style='font-size:11px; text-align:center;'>
      <tr>
        <td style='text-align:left;'>Kompas TV SAP Technical Consultant</td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
      </tr>
      <tr>

        <td style='text-align:left;'>Kompas TV SAP Functional Consultant</td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
      </tr>
      <tr>
        <td style='text-align:left;'>Kompas TV SAP Legal Officer</td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
      </tr>
      <tr>

        <td style='text-align:left;'>Gramedia Printing Group Personal Asisstant</td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
        <td><span class="label label-success"><i class="icon-ok-sign"></i><span class="badge badge-success">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-warning"><i class="icon-play-sign"></i><span class="badge badge-warning">20</span><i class="icon-info-sign"></i></span>
          <span class="label label-important"><i class="icon-remove-sign"></i><span class="badge badge-important">20</span><i class="icon-info-sign"></i></span></td>
      </tr>
    </tbody>
    <tfoot>

    </tfoot>
  </table>
  <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>