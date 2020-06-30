<!DOCTYPE html>
<html>
<head>
  <title>Demo icd</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/datatable/datatables.min.css");?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css");?>" />
  <!-- masukan jquery karena datatable adalah plugin jquery -->
  <script src="<?php echo base_url("assets/jquery.min.js");?>"></script>
</head>
<body>
<div class="container">
  <table id="myTable" class="table table-striped table-bordered table-hover">
    <thead><tr><td>No</td><td>Kode ICD</td><td>Nama ICD</td></tr></thead>
    <tbody>
    </tbody>
  </table>
</div>
<script type="text/javascript">
$(document).ready( function () {
  var token = "<?php echo $this->security->get_csrf_hash();?>";
  var table = $('#myTable').DataTable({ 

    "processing": true,
    "serverSide": true,
    "order": [],

    "ajax": {
        "url": "<?php echo base_url('icd/ajax_list')?>",
        "type": "POST",
        data: function ( d ) {
         d.<?php echo $this->security->get_csrf_token_name();?> = token;
       }
    },

    //optional
    "lengthMenu": [[5, 10, 25], [5, 10, 25]],

    "columnDefs": [
    { 
        "targets": [0,1,2],
        "orderable": true,
    },
    ],

});

   table.on('xhr.dt', function ( e, settings, json, xhr ) {
        token = json.<?=$this->security->get_csrf_token_name();?>;
    } );

} );
</script>

<script src="<?php echo base_url("assets/datatable/DataTables-1.10.20/js/jquery.dataTables.min.js");?>"></script>

<script src="<?php echo base_url("assets/datatable/datatables.min.js");?>"></script>

</body>
</html>