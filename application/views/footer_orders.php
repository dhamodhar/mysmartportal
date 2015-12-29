


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

       
        <script src="<?php echo base_url()?>assets/js/vendor/daterangepicker/moment.min.js"></script>
           <script src="<?php echo base_url()?>assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
     
<script src="<?php echo base_url()?>assets/jquery.simple-text-rotator.js"></script>
   
        <!--/ vendor javascripts -->




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
            url: "<?php echo base_url()?>index.php/welcome/all_orders",
            dataType: "text",
            success: function(xml){
			//alert(xml);
			//$('#orders-list tbody').append(xml);
                $(xml).find('order').each(function(){
				
                var orderNumber= $(this).find('order_number').text();
				var order_date= $(this).find('order_date').text();
				var po_number= $(this).find('po_number').text();
				var invoice_number= $(this).find('invoice_number').text();
				var invoice_amount= $(this).find('invoice_amount').text();
				var ship_city= $(this).find('ship_city').text();
				var ship_state= $(this).find('ship_state').text();
				var order_status= $(this).find('order_status').text();
				var d = new Date(order_date);
				
				
                //var sPublisher = $(this).find('Publisher').text();
               //alert(sTitle);
			   
			   $('#orders-list tbody').append("<tr><td style='widtd:180px;'><a href='<?php echo base_url()?>index.php/welcome/order_view/"+orderNumber+"'>"+orderNumber+"</a></td><td style='widtd:200px;'>"+d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear()+"</td><td style='widtd:150px;'>"+po_number+"</td><td style='widtd:150px;'><a href='<?php echo base_url()?>index.php/welcome/order_view'>"+invoice_number+"</a></td><td style='widtd:150px;'>$ "+invoice_amount+"</td><td style='widtd:150px;'>"+ship_city+" / "+ship_state+"</td><td style='widtd:100px;'>"+order_status+"</td></tr>");
                 //datatables();           
		   });
		     $('#orders-list').DataTable({
                  "bSort": false
				});
            },
            error: function() {
            alert("An error occurred while processing XML file.");
            }
        });
    });    

           
        </script>
        <script type="text/javascript">
function searchbydates()
{
$('#orders-list').DataTable( {
    destroy: true,
    searching: false
} );
 var test1 = "";
 var fromdate = document.getElementById("from").value;
 var todate =document.getElementById("to").value;
 var order_id = document.getElementById("order_id").value;
 if(order_id==""){
 //alert("t");
 order_id = "%20";
 
 }
 //alert(order_id+" "+todate+" "+fromdate);
 var d = new Date(fromdate);
 var t = new Date(todate);
 var from = d.getMonth()+"-"+d.getDate()+"-"+d.getFullYear();
  var to = t.getMonth()+"-"+t.getDate()+"-"+t.getFullYear();
  
  if(from=="NaN-NaN-NaN")
  {
   
  from = "%20";
  
  }
  if(to=="NaN-NaN-NaN")
  {
  to = "%20";
  
  }
        $.ajax({
            type: "GET",
            url: "<?php echo base_url()?>index.php/welcome/orders_search_by_dates/"+from+"/"+to+"/"+order_id,
            dataType: "text",
            success: function(xml){
			//alert(xml);
			//$('#orders-list tbody').append(xml);
			$('#orders-list tbody').html("");
                $(xml).find('order').each(function(){
				
                var orderNumber= $(this).find('order_number').text();
				var order_date= $(this).find('order_date').text();
				var po_number= $(this).find('po_number').text();
				var invoice_number= $(this).find('invoice_number').text();
				var invoice_amount= $(this).find('invoice_amount').text();
				var ship_city= $(this).find('ship_city').text();
				var ship_state= $(this).find('ship_state').text();
				var order_status= $(this).find('order_status').text();
				var d = new Date(order_date);
				
				
                //var sPublisher = $(this).find('Publisher').text();
               //alert(sTitle);
			   
			   $('#orders-list tbody').append("<tr><td style='widtd:180px;'><a href='<?php echo base_url()?>index.php/welcome/order_view/"+orderNumber+"'>"+orderNumber+"</a></td><td style='widtd:200px;'>"+d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear()+"</td><td style='widtd:150px;'>"+po_number+"</td><td style='widtd:150px;'><a href='<?php echo base_url()?>index.php/welcome/order_view'>"+invoice_number+"</a></td><td style='widtd:150px;'>"+invoice_amount+"</td><td style='widtd:150px;'>"+ship_city+" / "+ship_state+"</td><td style='widtd:100px;'>"+order_status+"</td></tr>");
                 //datatables();           
		   });
		     
            },
            error: function() {
            alert("An error occurred while processing XML file.");
            }
        });



}
</script>



        <!--/ Page Specific Scripts -->


  <script>
            $(window).load(function(){


                $('#from').datetimepicker();
                 $('#to').datetimepicker();
                 });
                
                </script>




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