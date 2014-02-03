<div class='span12 well'>
  <form class="form-inline">
      <label for="" style="color:gray;margin-right:25px;"><h4>Quick Job Search</h4></label>
      <input type="text" name="s_name" id="s_name" placeholder="Name"/>
      <button type="submit" class="btn">Search</button>
    <form>
</div>

<div class='well'>
  <div class="span3 box-widget widget-dashboard">
    <div class="box-widget-head">
      <div class="pull-left">Advance/Revine</div>
    </div>
    <div class="box-widget-body widget-default-h">
      <form action="" class="form-inline">
        <div class="control-group">
          <label for="" class="control-label">Name</label>
          <div class="controls">
            <input type="text" name='f_name' placeholder="name" class="widget-input"/>
          </div>
        </div>
        <div class="control-group">
          <label for="" class="control-label">Vertical</label>
          <div class="controls">
            <select name="" id="" class="widget-select">
              <option value=""></option>
              <option value="">1</option>
              <option value="">2</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label for="" class="control-label">Cost Center</label>
          <div class="controls">
            <select name="" id="" class="widget-select">
              <option value=""></option>
              <option value="">1</option>
              <option value="">2</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label for="" class="control-label">Location</label>
          <div class="controls">
            <select name="" id="" class="widget-select">
              <option value=""></option>
              <option value="">1</option>
              <option value="">2</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label for="" class="control-label">Priority</label>
          <div class="controls">
            <select name="" id="" class="widget-select">
              <option value=""></option>
              <option value="">1</option>
              <option value="">2</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label for="" class="control-label">Sourcing Dificulties</label>
          <div class="controls">
            <select name="" id="" class="widget-select">
              <option value=""></option>
              <option value="">1</option>
              <option value="">2</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label for="" class="control-label">Status</label>
          <div class="controls">
            <select name="" id="" class="widget-select">
              <option value=""></option>
              <option value="">1</option>
              <option value="">2</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label for="" class="control-label">Date Range</label>
          <div class="controls">
            <input type="text" name='from' class="widget-input" placeholder="From" />
            <input type="text" name='to' class="widget-input" placeholder="To" />
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="span9 box-widget widget-dashboard-long widget-default-h">
    <div class="box-widget-head">
      <div class="pull-left">Search Result Total: <span id="total-result"></span></div>
      <div class="pull-right">
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
      </div>
    </div>
    <div class="box-widget-body table-body widget-default-h">
      <table class="table table-condensed table-striped sortable">
        <thead>
          <tr>
            <th data-key='control'>#</th>
            <th data-key='_title' data-sortkey='asc'>Job Name</th>
            <th data-key='_vertical' data-sortkey='asc'>Vertical</th>
            <th data-key='_start' data-sortkey='asc'>Open Date</th>
            <th data-key='_state' data-sortkey='asc'>Location</th>
            <th data-key='control' data-sortkey='asc'>No. 1st Interview</th>
            <th data-key='control' data-sortkey='asc'>Status</th>
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
          </tr>
        </tbody>
      </table>
      <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
    </div>
  </div>
</div>
