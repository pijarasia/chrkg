<div id="test">
    <div class='content-inner well' style="padding: 30px 20px;">
        <div class="row-fluid">
            <div class="span10">
            	<form class="form-inline" id="sform" method='post'>
                    <div class="control-group">
                        <label for="" class="control-label">Name</label>
                        <div class="controls">
                            <input type="text" id="s_name" name='s_name' placeholder="Name" class="input-xlarge"/>
                        </div>
                    </div>
                    <?php echo form_dropdown($s_gr,$option['s_group']);?>                    
                    <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i>Search</button>
            	</form>
            </div>
    
            <div class="span2" style="text-align: right;">
                <div class="btn-group">
                    <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">Row/Page <span class="caret"></span></button>
                    <ul class="dropdown-menu" style="min-width: 90px;">
                        <li><a onclick='Document.search(10);'>10</a></li>
                        <li><a onclick='Document.search(20);'>20</a></li>
                        <li><a onclick='Document.search(50);'>50</a></li>
                        <li><a onclick='Document.search(100);'>100</a></li>
                    </ul>
                </div>
            </div>    
        </div>
    
        <table class="table table-bordered table-striped sortable">
            <thead>
                <tr>
                    <th data-key='_name' data-sortkey='asc'>Name</th>
                    <th data-key='_email' data-sortkey='asc'>Email</th>
                    <th data-key='control' data-sortkey='asc'>Groups</th>
                    <th data-key='control' data-sortkey='asc'>Join On</th>
                </tr>
            </thead>
            <tbody id="document-data">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="pagination pagination-centered pagination-xlarge" id="pagination"></div>
    </div>
</div>