<div class="span3 box-widget widget-dashboard box-widget-hide">
  <div class="box-widget-head">
    <div class="pull-left">Status
    <label class="radio inline">
      <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Current
    </label>
    <label class="radio inline">
      <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Date range
    </label>
</div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body" style="display: none;">
    </div>
    <div class="box-widget-footer" style="display: none;">
    </div>
</div>
<div class="span3 box-widget widget-dashboard box-widget-hide">
  <div class="box-widget-head">
    <div class="pull-left">Internal Scorecard</div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body" style="display: none;">
    </div>
    <div class="box-widget-footer" style="display: none;">
    </div>
</div>
<div class="span3 box-widget widget-dashboard box-widget-hide">
  <div class="box-widget-head">
    <div class="pull-left">Suggestions & Reminders</div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body" style="display: none;">
    </div>
    <div class="box-widget-footer" style="display: none;">
    </div>
</div>
<div class="span3 box-widget widget-dashboard box-widget-hide">
  <div class="box-widget-head">
    <div class="pull-left">This week's interviews(0)</div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body" style="display: none;">
    </div>
    <div class="box-widget-footer" style="display: none;">
    </div>
</div>
<div class="span12 well">
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
    </div>
  <table class="table table-bordered table-condensed table-hover sortable">
    <thead class="dashboard-head">
      <tr>
        <th colspan="12" data-key='control'>
          <form id="sform" method='post'>
          <div class="filter pull-left">
            Jobs <select name="" id="" class="inline input-small">
                <option value="">Only open jobs</option>
                <option value="1">Only closed jobs</option>
                <option value="2">View all jobs</option>
              </select>
              <input type="text" name='s_title' placeholder="Name" class="inline input-small" />
          </div>
          <div class="filter pull-left">
            Filter By Candidate Source
            <?php echo form_dropdown_blank($s_candidate,$option['s_candidate']);?>
          </div>
          <div class="filter pull-left">
            Open Form <input type="text" name="from" placeholder="From" class="inline input-mini" /> to <input type="text" name="to"  placeholder="To" class="inline input-mini" />
          </div>
          <div class="filter pull-left">
            <?php echo form_dropdown_blank($s_location,$option['s_location']);?>
          </div>
          <div class="filter pull-left">
            <?php echo form_dropdown_blank($s_business_area,$option['s_business_area']);?>
          </div>
          <div class="filter pull-left">
            <select name="" id="" class="inline input-medium">
                <option value="">All Internal Recruiter</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
          </div>
          <div class="filter pull-left">
            <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i>Search</button></p>
          </div>
          </form>
        </th>
      </tr>
    <thead>
    <thead>
      <tr>
        <th class="priority" data-key='_control' data-sortkey='asc'>Priority</th>
        <th class="name" data-key='_title' data-sortkey='asc'>Vacancy/Jobs</th>
        <th class="name" data-key='_title' data-sortkey='asc'>Sources</th>
        <th class="breadcrumbs" data-key='control'>Seleksi CV</th>
        <th class="breadcrumbs" data-key='control'>Interv HR</th>
        <th class="breadcrumbs" data-key='control'>Interv User</th>
        <th class="breadcrumbs" data-key='control'>Interv Adv</th>
        <th class="breadcrumbs" data-key='control'>Test Bidang</th>
        <th class="breadcrumbs" data-key='control'>Psikotest</th>
        <th class="breadcrumbs" data-key='control'>Medical</th>
        <th class="breadcrumbs" data-key='control'>Presentasi</th>
        <th class="breadcrumbs" data-key='control'>Hiring</th>
      </tr>
    <thead>
    <tbody id="document-data">
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>