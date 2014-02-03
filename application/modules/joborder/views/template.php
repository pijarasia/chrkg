<div class='content-inner well'>
  <div class="page-header">
    <a class="btn btn-small btn-primary" href="<?php echo site_url('joborder/add');?>">Create New Joborder</a>
    <a class="btn btn-small btn-primary" href="<?php echo site_url('joborder/template');?>">Create New Joborder From Template</a>
  </div>
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
            <?php echo form_dropdown($s_company,$option['s_company']);?>
            <?php echo form_dropdown($s_type,$option['s_type']);?>
            <?php echo form_dropdown($s_province,$option['s_province']);?>
            <div class='control-group '>
              <label class='control-label' for='start'>Start</label>
              <div class='controls'>
                    <select name='s_start_date' id='s_start_date' style='width: 100px;'>
                        <option value=''>Date</option>
                        <?php echo option_date(date());?>
                    </select>
                    <select name='s_start_month' id='s_start_month' style='width: 110px;'>
                        <option value=''>Month</option>
                        <?php echo option_month(date());?>
                    </select>
                    <select name='s_start_year' id='s_start_year' class='input-small'>
                        <option value=''>Year</option>
                        <?php echo option_year(date());?>
                    </select>
                </div>
            </div>
            <div class='control-group '>
              <label class='control-label' for='start'>End</label>
              <div class='controls'>
                    <select name='s_end_date' id='s_end_date' style='width: 100px;'>
                        <option value=''>Date</option>
                        <?php echo option_date(date());?>
                    </select>
                    <select name='s_end_month' id='s_end_month' style='width: 110px;'>
                        <option value=''>Month</option>
                        <?php echo option_month(date());?>
                    </select>
                    <select name='s_end_year' id='s_end_year' class='input-small'>
                        <option value=''>Year</option>
                        <?php echo option_year(date());?>
                    </select>
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
    <div id='document-masonry' class="js-masonry"
  data-masonry-options='{ "columnWidth": 300, "itemSelector": ".item" }'>

    </div>
    <div style="clear:both;"></div>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>