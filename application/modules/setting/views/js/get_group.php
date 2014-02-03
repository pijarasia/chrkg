<?php

?>
var Document = {
  param: {
    dataperpage: 10, // jumlah data per halaman
    query: '',
    curpage: 0,
    numpage: 0,
    skey: '',
    stype: '',
    npage: 0
  },
  url: '<?php echo base_url()."setting/group";?>',
  search: function(n) {
    var $form = $("#sform");
    this.param.query = $form.serializeFormJSON() || '';
    this.param.dataperpage = n || 10;
    this.param.curpage = 0;
    this.loadData();
    return false;
  },
  setPage: function(n) {
    this.param.curpage = n;
    this.loadData();
    return false;
  },
  sort: function(skey,stype) {
    this.param.skey = skey || '_name';
    this.param.stype = stype || 'asc';
    this.loadData();
    return false;
  },
  loadData: function() {
    $.ajax({
      url: Document.url,
      type: 'POST',
      dataType: 'json',
      data: jQuery.param(Document.param),
      beforeSend: function(){
        NProgress.start();
      },
      success: function(d) {
        Document.param.numpage = d.numpage;
        Document.param.npage = d.npage;
        var t = '', dt = {};
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          t += '<tr><td>' + dt.id + '</td>' +
              '<td>' + dt.name + '</td>' +
              '<td>' + dt.refname + '</td>' +
             '<td>' + dt.action + '</td></tr>';
        }
        $('#document-data').html(t);
        $('#pagination').html(d.pagination);
      },
      complete: function(){
        NProgress.done();
      }
    });
  }
}

$.fn.serializeFormJSON = function() {
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

$.fn.resetFormCustom = function()
{
    var $form = $(this);

    $form.find('input:text, input:hidden, input:password, input:file, textarea').val('');
    $form.find('select option:selected').removeAttr('selected');
    $form.find('input:checkbox, input:radio').removeAttr('checked');

    return this;
};

var deleteG = function(id){
    var form_data = {
      id:id
    };
    $.ajax({
        url : "<?php echo base_url(); ?>setting/group_delete",
        type : 'POST',
        data : form_data,
        success: function(d){
          $.pnotify({
            title: 'Notification',
            text: d.message,
            type: d.status
          });
        },
        complete: function(){
          Document.search();
        }
    });
    return false;
}

var editG = function(id,js)
{
    var obj=JSON.parse(js);
    $('#dialog').modal('show');
    $('#dialog').find('#hidden_id').val(id);
    $('#dialog').find('#group_id').val(obj.id);
    $('#dialog').find('#name').val(obj.name);
    $('#dialog').find('#refname').val(obj.refname);
    return false;
}

$(document).ready(function() {
  var $validator = $("#fform").validate({
      rules: {
          group_id: { required: true },
          name: { required: true },
          refname: { required: true },
      },
      errorPlacement: function (error, element) {
          //return false; //Suppress all messages
      },
      highlight: function (element) {
          $(element).closest('.control-group').removeClass('success').addClass('error');
      },
      unhighlight: function (element) {
          $(element).closest('.control-group').removeClass('error').addClass('success');
      }
  });
  $("#add").click(function(){
    $('#fform').resetFormCustom();
    $('#fform').find("hidden_id" );
  });

  $("#save").click(function() {
    var $form = $("#fform");
    var $valid = $form.valid();
    if(!$valid) {
        $validator.focusInvalid();
        return false;
		} else {
      $.ajax({
        url: '<?php echo base_url()."setting/group_form" ?>',
        type: 'POST',
        dataType: 'json',
        data: $form.serializeFormJSON(),
        beforeSend: function(){
          NProgress.start();
        },
        success: function(d){
          $.pnotify({
            title: 'Notification',
            text: d.message,
            type: d.status
          });
        },
        error: function(){

        },
        complete: function(){
          $("#dialog").modal('hide');
          NProgress.done();
          Document.search();
        }
      });
 		}
    return false;
  });
});