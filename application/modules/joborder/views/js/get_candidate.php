<?php

?>
var Document = {
  param: {
    ids: <?php echo $id;?>,
    dataperpage: 0, // jumlah data per halaman
    query: '',
    curpage: 0,
    numpage: 0,
    skey: '',
    stype: '',
    npage: 0,
    apply_id: '<?php echo $apply_id;?>',
    step: '<?php echo $step;?>',
    status: '<?php echo $status;?>',
  },
  url: '<?php
    $a = !empty($apply_id) ? "/{$apply_id}" : '';
    $s = !empty($step) ? "/{$step}" : '';
    $st = !empty($status) ? "/{$status}" : '';

    echo base_url()."joborder/candidate/{$id}{$a}{$s}{$st}";?>
  ',
  search: function(n) {
    var $form = $("#sform");
    this.param.query = $form.serializeFormJSON() || '';
    this.param.dataperpage = n || 1;
    this.param.curpage = 0;
    this.loadData();
    return false;
  },
  refresh: function() {
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
      beforeSend: function() {
        NProgress.start();
      },
      success: function(d) {
        Document.param.numpage = d.numpage;
        Document.param.npage = d.npage;
        var t = '', dt = {};
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          t += '<tr><td>' + dt.checkbox +'</td>' +
             '<td>' + dt.name + '</td>' +
             '<td>' + dt.step + '</td>' +
             '<td>' + dt.age + '</td>' +
             '<td>' + dt.dom + '</td>' +
             '<td>' + dt.created + '</td>' +
             '<td><div id="star-'+ dt.id + '" class="star" data-score="' + dt.rate +'" data-apply="' +  dt.id + '"></div></td>' +
             '<td>' + dt.archive + '</td>' +
             '<td>' + dt.note + '</td>' +
             '<td>' + dt.action + '</td></tr>';
        }
        $('#document-data').html(t);
        $('#pagination').html(d.pagination);
        $("#view_document").html('');
        if(Document.param.dataperpage == 1){
          
        }
      },
      error: function() {

      },
      complete: function(){
        NProgress.done();
        $("[rel='tooltip']").tooltip();
        $.fn.raty.defaults.path = '<?php echo img_path();?>images/raty';
        $.each($('.star'), function() {
          $("#" + this.id ).raty({
            readOnly: true,
            score: function() {
              return $(this).attr('data-score');
            }
            });
        });
      }
    });
  },
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