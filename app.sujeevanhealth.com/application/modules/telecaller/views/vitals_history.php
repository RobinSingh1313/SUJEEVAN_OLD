<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<?php
$user_id = $this->input->get('user_id');
$get_userdetails = $this->db->query("SELECT registration_id, register_name FROM `registration` where registration_id='$user_id' ")->row();
?>

<div class="row">
    <div class="col-lg-12">
        <?php $this->load->view("success_error");?> 
    </div>
    <div class="col-lg-12">
        <div class="card">
            <table class="list_table">
                <thead>
                    <tr>
                       <th>#</th>
                       <th>Weight</th>
                       <th>Temperature</th>
                       <th>Pulse Rate</th>
                       <th>Respiratory Rate</th>
                       <th>SPO2</th>
                       <th>Blood Pressure</th>
                       <th>CVS</th>
                       <th>CNS</th>
                       <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                     $i=1;
                        foreach($view as $vw){?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $vw['vital_weight']!=''?$vw['vital_weight']:'--'; ?></td>
                            <td><?php echo $vw['vital_temperature']!=''?$vw['vital_temperature']:'--'; ?></td>
                            <td><?php echo $vw['vital_pulse_rate']!=''?$vw['vital_pulse_rate']:'--'; ?></td>
                            <td><?php echo $vw['vital_respiratory_rate']!=''?$vw['vital_respiratory_rate']:'--'; ?></td>
                            <td><?php echo $vw['vital_spo2']!=''?$vw['vital_spo2']:'--'; ?></td>
                            <td><?php echo $vw['vital_bp']!=''?$vw['vital_bp']:'--'; ?></td>
                            <td><?php echo $vw['vital_cvs']!=''?$vw['vital_cvs']:'--'; ?></td>
                            <td><?php echo $vw['vital_cns']!=''?$vw['vital_cns']:'--'; ?></td>
                            <td><?php echo $vw['vital_cr_on']!=''?$vw['vital_cr_on']:'--'; ?></td>
                        </tr>
                    <?php $i++;} ?>
                </tbody>
            </table>
        </div><!--end card-->
    </div>
</div> 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript">
$('.list_table').DataTable({
      dom: 'lBfrtip',
      buttons: [
         {
               extend: 'excelHtml5',
               title: '<?php echo $get_userdetails->register_name.'-'.$get_userdetails->registration_id; ?> - Vitals History',
               exportOptions: {
                  columns: ':visible'
               }
         },
         {
               extend: 'pdfHtml5',
               title: '<?php echo $get_userdetails->register_name.'-'.$get_userdetails->registration_id; ?> - Vitals History',
               exportOptions: {
                  columns: ':visible'
               }
         }
      ],
      oLanguage: {sLengthMenu: "Show Entries: <select>"+
            "<option value='10' selected='selected'>10</option>"+
            "<option value='25'>25</option>"+
            "<option value='50'>50</option>"+
            "<option value='100'>100</option>"+
            "</select>&nbsp;&nbsp;"},
            "iDisplayLength": 10,
   });
</script>