<div class='content-inner well'>
  <div class="page-header">
  	<div class="morespace pull-right">
	  <span class='label'>Headcount <i class='icon-male'></i></span><span class="badge"><?php echo $jobs->joborderOpenings;?></span>
	  <span class='label'>Hired <i class='icon-male'></i></span><span class="badge"><?php echo $jobs->joborderOpenings;?></span>
	  <span class='label'>Opening <i class='icon-male'></i></span><span class="badge"><?php echo $jobs->joborderOpenings;?></span>
	</div>
  </div>
</div>

<div class='content-inner well'>
<div class="widget">
	<div class="widget-head">
	  <div class="pull-left" id="status-header"></div>
	  <div class="widget-icons pull-right">
	    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a>
	  </div>
	  <div class="clearfix"></div>
	</div>
	<div class="widget-content">
	  <div class="padd">
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
		          <li><a onclick='Document.search(30);'>30</a></li>
		          <li><a onclick='Document.search(50);'>50</a></li>
		          <li><a onclick='Document.search(100);'>100</a></li>
		        </ul>
		      </div>
		      <div class="btn-group">
		        <button class="btn btn-mini btn-success" onclick="return Document.lastPage()"></i>Last</button>
		      </div>
		    </div>
		  <table class="table table-condensed table-striped table-hover sortable">
		    <thead>
		      <tr>
		        <th data-key='control'>#</th>
		        <th data-key='_rank' data-sortkey='asc'>Rank</th>
		        <th data-key='_name' data-sortkey='asc'>Name</th>
		        <th data-key='_control'>Comment</th>
		        <th data-key='_location' data-sortkey='asc'>Location</th>
		        <th data-key='_status' data-sortkey='asc'>Active / Passive</th>
		        <th data-key='_date'>Date</th>
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
		      </tr>
		    </tbody>
		  </table>
		  </form>
		    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
	  </div>
	</div>
</div>

















