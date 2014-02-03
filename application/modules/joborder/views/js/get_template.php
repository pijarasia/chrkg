<?php

?>
var Document = {
  param: {
    dataperpage: 0, // jumlah data per halaman
    query: '',
    curpage: 0,
    numpage: 0,
    skey: '',
    stype: '',
    npage: 0
  },
  url: '<?php echo base_url()."joborder/template";?>',
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
      beforeSend: function() {
        NProgress.start();
      },
      success: function(d) {
        Document.param.numpage = d.numpage;
        Document.param.npage = d.npage;

        var t = '', dt = {};
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          t +=
              '<div class="item">'+
                '<a class="btn btn-primary" href="'+dt.url+'">Use For Template</a>' + '<br />' +
                dt.name + '<br />'+
                dt.company + '<br />'+
                dt.state + '<br />'+
                dt.city + '<br />'+
                dt.employment_type + '<br />' +
                '</div>';
        }
        $('#document-masonry').html(t);
        $('#pagination').html(d.pagination);
      },
      error: function() {

      },
      complete: function(){
        NProgress.done();
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