<!-- CRUMBS 
Nb: Ganti Company dengan Cost Center, Status Job => closed, Province ganti dengan location di joborder controller line 1043

Angka di CRUMBS Bukan Urutan Tapi Jumlah Total Pelamar

-->
<div class="span12 well">
  <?php echo $crumbs; ?>
</div>

<!-- Jobdescription  -->

<!-- WIDGET BERUBAH WARNA Orange Doang Status BERBENTUK TABEL AJAX
# Rank Name Comment Location Active/Passive Application Date Action

1. Rating Blabla 0 Jakarta Barat Active 2013-Oct-7 Tombol View Resume, ada effects kalau di hover display
foto, download resume dan see more
 -->
<div class="pull-right" style="margin-bottom:20px;">
      <button class="btn btn-mini  btn-default">Print Job Description</button>
      <button class="btn btn-mini btn-default">Download Job Description</i></button>
</div>

  <div class="span12 box-widget widget-down">
    <div class="box-widget-head">
      <div class="pull-left">Pending <i class='icon-pause'></i></div>
      <div class="btn-toolbar" style="margin-left:100px;">
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
        <div class="pull-right btn-group sharp">
		      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
		      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
		    </div>
      </div>
    </div>
    <div class="box-widget-body table-body widget-default-h-sort">
      <table class="table table-condensed table-striped sortable">
        <thead>
          <tr>
            <th data-key='control'>#</th>
            <th data-key='control' data-sortkey='asc'>Rank</th>
            <th data-key='_name' data-sortkey='asc'>Name</th>
            <th data-key='control' data-sortkey='asc'>Comment</th>
            <th data-key='_location' data-sortkey='asc'>Location</th>
            <th data-key='_status' data-sortkey='asc'>Active/Pasive</th>
            <th data-key='date' data-sortkey='asc'>Aplication Date</th>
            <th data-key='control' data-sortkey='asc'>Action</th>
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
      <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
    </div>
  </div>



<!-- BX Slider, Nama Email Rating | Crumbs 
   | Share Candidate, Email Candidate, No Permission to rate Action widget
     HR: siapa, Direct Manager: siapa, Internal Recruiter: siapa
   Resume Google Docs | Messages
-->

<div class="span12 box-widget widget-down">
  <div class="box-widget-head">
    <div class="pull-left">Description</div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body">
    </div>
    <div class="box-widget-footer">
    </div>
</div>

<!-- Rejected | Accepted -->
<div class="span6 box-widget widget-dashboard-six">
  <div class="box-widget-head">
    <div class="pull-left">Rejected <i class='icon-stop'></i></div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body">
    </div>
    <div class="box-widget-footer">
    </div>
</div>
<div class="span6 box-widget widget-dashboard-six">
  <div class="box-widget-head">
    <div class="pull-left">Accepted <i class='icon-play'></i></div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body">
    </div>
    <div class="box-widget-footer">
    </div>
</div>

<!-- Description -->
<div class="span12 box-widget widget-down">
  <div class="box-widget-head">
    <div class="pull-left">Description</div>
    <div class="pull-right btn-group sharp">
      <button class="btn btn-mini noGR"><i class="icon-chevron-down"></i></button>
      <button class="btn btn-mini noGR"><i class="icon-chevron-up"></i></button>
    </div>
    </div>
    <div class="box-widget-body">
    </div>
    <div class="box-widget-footer">
    </div>
</div>