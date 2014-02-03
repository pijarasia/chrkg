<div class='content-inner well' style="padding: 30px 20px;min-height: 530px">
    <div class="row-fluid">
        <div class="span5">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_search" name='s_search' placeholder="Email Template" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>
        </div>

        <div id="dialog-email" class="modal custom hide fade in" style="display: none;width: 680px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4>Add Email Template</h4>
            </div>
            <div class="modal-body">
            <form name="form_email" id="form_email" method="get">
                <div class="form-vertical">
                    <div class="control-group">
                        <label class="control-label" for="group">Group</label>
                        <div class="controls" style="padding-top: 5px;">
                            <select name="group" id="group">
                                <option value="">Select Group</option>
                                <option value="0">All</option>
                            <? 
                                foreach ($group->result() as $row)
                                {
                                    echo '<option value="'.$row->AppLevelListID.'"'.$selected.'>'.$row->AppLevelListLevelName.'</option>';
                                }
                            ?>                         
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="subject">Subject</label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="subject" name="subject" placeholder="Subject"/>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="editor">Content</label>
                        <div class="controls" style="padding-top: 5px;">
                            <!--Sementara ini dulu-->
                            <!--<textarea cols="90" rows="5" id="content" name="content"></textarea>-->
                            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                              <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                  </ul>
                                </div>
                              <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                  <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                  <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                  <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                                  </ul>
                              </div>
                              <div class="btn-group">
                                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                              </div>
                              <div class="btn-group">
                                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                                <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                                <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                              </div>
                              <div class="btn-group">
                                <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                                <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                              </div>
                              <div class="btn-group">
                        		  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
                        		    <div class="dropdown-menu input-append">
                        			    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                        			    <button class="btn" type="button">Add</button>
                                </div>
                        
                              </div>
                              
                              <div class="btn-group">
                                <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
                                <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                              </div>
                              <div class="btn-group">
                                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                              </div>
                            </div>
                            <div id="editor">
                            </div>
                        </div>
                    </div>                                               
                </div>  
            </form>                                                                
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDEmail" id="hiddenIDEmail" />
                <input type="submit" class="btn btn-info" name="simpan_email" id="simpan_email" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
        
        <!--Detail-->        
        <div id="dialog-email-detail" class="modal custom hide fade in" style="display: none;width: 680px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4>Detail Email Template</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td style="width: 70px;">Group</td>
                        <td style="width: 10px;">:</td>
                        <td><span id="groupD"></span></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Subject</td>
                        <td style="vertical-align: top;">:</td>
                        <td><span id="subjectD"></span></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Content</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="border: 1px solid #ddd;padding: 5px;"><span id="editorD"></span></td>
                    </tr>
                </table>                                             
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDEmail" id="hiddenIDEmail" />
                <input type="submit" class="btn btn-info" name="simpan_email" id="simpan_email" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>        
        <div class="span7" style="text-align: right;">
            <?php
                if ($bool_add)
                {
            ?>
            <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-email"><i class="icon-plus"></i> Add Email Template</a>              
            <?php
                }
            ?>
            <div class="btn-group">
                <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">Row/Page <span class="caret"></span></button>
                <ul class="dropdown-menu" style="min-width: 90px;">
                    <li><a onclick='Document.search(10);'>10</a></li>
                    <li><a onclick='Document.search(20);'>20</a></li>
                </ul>
            </div>         
        </div>
    </div>  
    <div class="alert alert-error hide" id="alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="status-error"></div>
    </div>
    <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="status-success"></div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_group' data-sortkey='asc' style="width: 200px;">Group</th>
                <th data-key='_subject' data-sortkey='asc'>Subject Email</th>
				<th data-key='control' style="width: 70px;">Action</th>
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
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>