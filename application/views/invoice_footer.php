




        <!-- ============================================
        ============== Vendor JavaScripts ===============
        ============================================= -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url()?>assets/js/vendor/jquery/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="<?php echo base_url()?>assets/js/vendor/bootstrap/bootstrap.min.js"></script>

        <script src="<?php echo base_url()?>assets/js/vendor/jRespond/jRespond.min.js"></script>

        <script src="<?php echo base_url()?>assets/js/vendor/sparkline/jquery.sparkline.min.js"></script>

        <script src="<?php echo base_url()?>assets/js/vendor/slimscroll/jquery.slimscroll.min.js"></script>

        <script src="<?php echo base_url()?>assets/js/vendor/animsition/js/jquery.animsition.min.js"></script>

        <script src="<?php echo base_url()?>assets/js/vendor/screenfull/screenfull.min.js"></script>

        <script src="<?php echo base_url()?>assets/js/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/vendor/datatables/extensions/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url()?>assets/js/vendor/datatables/extensions/Pagination/input.js"></script>

        <script src="<?php echo base_url()?>assets/js/vendor/date-format/jquery-dateFormat.min.js"></script>
        <!--/ vendor javascripts -->


<script src="<?php echo base_url()?>assets/jquery.simple-text-rotator.js"></script>

        <!-- ============================================
        ============== Custom JavaScripts ===============
        ============================================= -->
        <script src="<?php echo base_url()?>assets/js/main.js"></script>
        <!--/ custom javascripts -->


<script>
$(document).ready(function(){

$(".demo2 .rotate").textrotator({
animation: "flip",
speed: 3000
});

});

</script>

        <!-- ===============================================
        ============== Page Specific Scripts ===============
        ================================================ -->
         <script>

 $(document).ready(function(){
   //initialize datatable
              
	  var test1 = "";
        $.ajax({
            type: "GET",
            url: "<?php echo base_url()?>index.php/welcome/all_invoices",
            dataType: "text",
            success: function(xml){
			//alert(xml);
			//$('#orders-list tbody').append(xml);
                $(xml).find('Invoice').each(function(){
				
                var invoice_numb= $(this).find('invoice_numb').text();
				var billto_code= $(this).find('billto_code').text();
				var billname= $(this).find('billname').text();
				var inv_date= $(this).find('inv_date').text();
				var due_date= $(this).find('due_date').text();
				var amount= $(this).find('amount').text();
				var status= $(this).find('entry_type').text();
			
	 //alert(due.getMonth());
var duedate_month = "";	 
				
				var d= new Date(inv_date);
 var inv_date_final = d.getMonth()+"-"+d.getDate()+"-"+d.getFullYear();

					var due= new Date(due_date);
					if(due.getMonth()==0)
				{
				duedate_month = 1;
				
				}else
				{
				
				duedate_month = due.getMonth();
				}
 var due_date_final = duedate_month+"-"+due.getDate()+"-"+due.getFullYear();	
                //var sPublisher = $(this).find('Publisher').text();
               //alert(sTitle);
			   
			   $('#orders-list tbody').append("<tr><td style='widtd:180px;'><a href='#'>"+invoice_numb+"</a></td><td style='widtd:150px;'><a href='#'>"+inv_date_final+"</a></td><td style='widtd:150px;'>$ "+amount+"</td><td style='widtd:200px;'>"+due_date_final +"</td><td style='widtd:100px;'>"+status+"</td></tr>");
                 //datatables();           
		   });
		     $('#orders-list').DataTable({
                    "dom": '<"row"<"col-md-8 col-sm-12"<"inline-controls"l>><"col-md-4 col-sm-12"<"pull-right"f>>>t<"row"<"col-md-4 col-sm-12"<"inline-controls"l>><"col-md-4 col-sm-12"<"inline-controls text-center"i>><"col-md-4 col-sm-12"p>>',
                    "language": {
                        "sLengthMenu": 'View _MENU_ records',
                        "sInfo":  'Found _TOTAL_ records',
                        "oPaginate": {
                            "sPage":    "Page ",
                            "sPageOf":  "of",
                            "sNext":  '<i class="fa fa-angle-right"></i>',
                            "sPrevious":  '<i class="fa fa-angle-left"></i>'
                        }
                    },
                    "pagingType": "input"
                   
                //*initialize datatable
				});
            },
            error: function() {
            alert("An error occurred while processing XML file.");
            }
        });
    });    

           
        </script>
        <!--/ Page Specific Scripts -->







        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>


    </body>
</html>