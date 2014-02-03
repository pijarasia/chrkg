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
  url: '<?php echo base_url()."setting/company";?>',
  search: function(n) {
    var $form = $("#sform");
    this.param.query = $form.serializeFormJSON() || '';
    this.param.dataperpage = n || 10;
    this.param.curpage = 0;
    this.loadData();
    return false;
  },
  sort: function(skey,stype) {
    this.param.skey = skey || '_name';
    this.param.stype = stype || 'asc';
    this.loadData();
    return false;
  },
  setPage: function(n) {
    this.param.curpage = n;
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
          t += '<tr><td>' + dt.logo + '</td>' +
              '<td>' + dt.name + '</td>' +
              '<td>' + dt.url + '</td>' +
              '<td>' + dt.email + '</td>' +
              '<td>' + dt.phone1 + '</td>' +
              '<td>' + dt.phone2 + '</td>' +
              '<td>' + dt.fax + '</td>' +
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

$.fn.resetFormCustomCustom = function()
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
        url : "<?php echo base_url(); ?>usermanagement/company_delete",
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
    $('#dialog').find('#name').val(obj.name);
    $('#dialog').find('#business_area').val(obj.business_area);
    $('#dialog').find('#url').val(obj.url);
    $('#dialog').find('#email').val(obj.email);
    $('#dialog').find('#phone1').val(obj.phone1);
    $('#dialog').find('#phone2').val(obj.phone2);
    $('#dialog').find('#fax').val(obj.fax);
    $('#dialog').find('#logo').val(obj.logo);
    $('#dialog').find('#business_area').val(obj.business_area);
    $('#dialog').find('#address').val(obj.address);
    $('#dialog').find('#city').val(obj.city);
    $('#dialog').find('#state').val(obj.state);
    return false;
}

var uploadG = function(id,js)
{
    var obj=JSON.parse(js);
    $('#dialog-upload').modal('show');
    $('#dialog-upload').find('#hidden_id').val(id);
    $('#dialog-upload').find('#output').val(obj.logo);
    return false;
}

$(document).ready(function() {
  var $validator = $("#fform").validate({
      rules: {
          permission_id: { required: true },
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
        url: '<?php echo base_url()."usermanagement/company_form" ?>',
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

  $("#save-upload").click(function() {
    var $form = $("#fform-upload");
    var options = {
        url: "<?php echo base_url()."usermanagement/company_form_upload" ?>",
        type: 'POST',
        dataType: 'json',
        data: $form.serializeFormJSON(),
        beforeSend: function(){
          NProgress.start();
        },
        success: function(d) {
          $.pnotify({
            title: 'Notification',
            text: d.message,
            type: d.status
          });
        },
        error: function(){

        },
        complete: function(){
          $("#dialog-upload").modal('hide');
          $form.resetForm();
          NProgress.done();
          Document.search();
        }
    };
    $form.ajaxSubmit(options);
    return false;
  });
});