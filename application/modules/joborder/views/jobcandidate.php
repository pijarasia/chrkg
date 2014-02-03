<div class='content-inner well'>
  <div class="page-header">
  </div>
  <div class="accordion" id="accordion0">
    <div class="accordion-group">
      <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion0" href="#collapseNought">
          Overview
        </a>
      </div>
      <div id="collapseNought" class="accordion-body collapse">
        <div class="accordion-inner">
          <table class="table table-condensed table-striped table-hover sortable">
              <tbody>
                <tr>
                  <td>Title</td><td><?php echo $record['joborderTitle'];?></td>
                </tr>
                <tr>
                  <td>Company</td><td><?php echo $record['joborderCompanyID'];?></td>
                </tr>
                <tr>
                  <td>Busines Unit</td><td><?php echo $record['joborderCompanyDepartementID'];?></td>
                </tr>
                  <td>Last Update</td><td><?php echo $record['joborderUpdated'];?></td>
                </tr>
                <tr>
                  <td>Action</td><td></td>
                </tr>
                <tr>
                  <td>Type</td><td><?php echo $record['joborderType'];?></td>
                </tr>
                <tr>
                  <td>Location</td><td><?php echo $record['joborderCity'];?></td>
                </tr>
                <tr>
                  <td>Busines Area</td><td><?php echo $record['joborderBusinesAreaID'];?></td>
                </tr>
                <tr>
                  <td>Job Stage</td><td><?php echo $record['joborderStatus'];?></td>
                </tr>
                <tr>
                  <td>Direct Manager</td><td></td>
                </tr>
                <tr>
                  <td>Internal Recruiter</td><td></td>
                </tr>
                <tr>
                  <td>HR</td><td></td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
  <div class="accordion" id="accordion1">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">
            Description
          </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse">
          <div class="accordion-inner">
            <table class="table table-condensed table-striped table-hover sortable">
              <tbody>
                <tr>
                </tr>
                <tr>
                  <td>Description</td><td><?php echo $record['joborderDescription'];?></td>
                </tr>
                <tr>
                  <td>Requirements</td><td><?php echo $record['joborderRequirements'];?></td>
                </tr>
                <tr>
                  <td>Other Detail</td><td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  <form class="form-horizontal" id="sform" method='post'>
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
            Search By
          </a>
        </div>
        <div id="collapseTwo" class="accordion-body collapse">
          <div class="accordion-inner">
            <div class="control-group">
              <label class="control-label" for="s_name">Name</label>
              <div class="controls">
                <input type="text" id="s_name" name='s_name' placeholder="Name" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_step">Step</label>
              <div class="controls">
                <input type="text" id="s_step" name='s_step' placeholder="Step" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_age">Age</label>
              <div class="controls">
                <input type="text" id="s_age" name='s_age' placeholder="Age" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_dom">Domicile</label>
              <div class="controls">
                <input type="text" id="s_dom" name='s_dom' placeholder="Domicile" class="input-xlarge">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="s_start">Created</label>
              <div class="controls">
                <input type="text" id="s_created" name='s_created' placeholder="Created" class="input-xlarge">
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
    <form>
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
  <table class="table table-condensed table-striped table-hover sortable">
    <thead>
      <tr>
        <th data-key='control'><input type="checkbox" name="idall" id="idall" value="on"></th>
        <th data-key='_name' data-sortkey='asc'>Name</th>
        <th data-key='control'>Step</th>
        <th data-key='_age' data-sortkey='asc'>Age</th>
        <th data-key='_dom' data-sortkey='asc'>Dom</th>
        <th data-key='_created' data-sortkey='asc'>Created</th>
        <th data-key='_rate' data-sortkey='asc'>Rate</th>
        <th data-key='control'>Note</th>
        <th data-key='control'>Action</th>
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
      </tr>
    </tbody>
  </table>
  </form>
    <div class="pagination pagination-centered pagination-medium"></div>
</div>

<?php echo modules::run('joborder/action1',$in); ?>
<?php echo modules::run('joborder/action2',$in); ?>
<?php echo modules::run('joborder/action3',$in); ?>
<?php echo modules::run('joborder/action4',$in); ?>
<?php echo modules::run('joborder/action5',$in); ?>
<?php echo modules::run('joborder/action6',$in); ?>
<?php echo modules::run('joborder/action7',$in); ?>
<?php echo modules::run('joborder/action8',$in); ?>