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




        <!-- ============================================
        ============== Custom JavaScripts ===============
        ============================================= -->
        <script src="<?php echo base_url()?>assets/js/main.js"></script>
        <!--/ custom javascripts -->




        <!-- ===============================================
        ============== Page Specific Scripts ===============
        ================================================ -->
		       <script>

 $(document).ready(function(){
   //initialize datatable
              
	  var test1 = "";
        $.ajax({
            type: "GET",
            url: "<?php echo base_url()?>index.php/welcome/orderview_data/<?php echo $order_id; ?>",
            dataType: "text",
            success: function(xml){
			//alert(xml);
			//$('#orders-list tbody').append(xml);
                $(xml).find('OrderDetails').each(function(){
				
                var orderNumber= $(this).find('order_number').text();
				var part_code = $(this).find('part_code').text();
				var qty = $(this).find('qty').text();
				var uom = $(this).find('uom').text();
				var item_price = $(this).find('item_price').text();
				var extended_price= $(this).find('extended_price').text();
				var item_status= $(this).find('item_status').text();
				var part_desc= $(this).find('part_desc').text();
				var item_stat= $(this).find('item_stat').text();
				
				
 
			   $("#count").html(item_stat);
			   $('#orders-list tbody').append("<tr><td>"+orderNumber+"</td><td>"+part_code+"</td><td>"+qty+"</td><td >"+uom+"</td><td >"+item_price+"</td><td>"+extended_price+"</td><td><span class='label label-danger'>"+item_status+"</span></td><td>"+part_desc+"</td></tr>");
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
        displayorder_details();
    });    

          function displayorder_details()
{

$.ajax({
            type: "GET",
            url: "<?php echo base_url()?>index.php/welcome/orderview_header_data/<?php echo $order_id; ?>",
            dataType: "text",
            success: function(xml_order_header_details){
			
			$(xml_order_header_details).find('InvoiceHeader').each(function(){
						var shipcity= $(this).find('shipcity').text();
						var shipname= $(this).find('shipname').text();
						var shipst= $(this).find('shipst').text();
						var shipto_code= $(this).find('shipto_code').text();
						$("#shipping").html("<p class='text-uppercase text-strong mb-10 custom-font'>SHIPPING Address</p><ul class='list-unstyled text-default lt mb-20'><li>"+shipcity+"</li><li>"+shipname+"</li><li>"+shipst+"</li><li>"+shipto_code+"</li></ul>");
						var order_numb= $(this).find('order_numb').text();
						var order_date= $(this).find('order_date').text();
						var amount= $(this).find('amount').text();
						var total_tax= $(this).find('total_tax').text();
						var shipping_charge= $(this).find('shipping_charge').text();
						$("#order_details").html("<p class='text-uppercase text-strong mb-10 custom-font'>Invoice Number(s)</p><ul class='list-unstyled text-default lt mb-20'><li><strong>Order Number : </strong>"+order_numb+"</li><li><strong>Order Date : </strong> "+order_date+"</li><li><strong>Order Amount : </strong> $"+amount+"</li><li><strong>Tax Amount : </strong> $"+total_tax+"</li><li><strong>Shipping Charges : </strong>$"+shipping_charge+"</li><li><strong>Total Order Amount : </strong> $"+amount+"</li><li><strong>Dube Date : </strong> 2014/05/15 00:00:00 UTC</li><li><strong>Pay Type : </strong> On Account</li><li><strong>Tracking : </strong> 84546585</li></ul>");
						var billcity= $(this).find('billcity').text();
						var billname= $(this).find('billname').text();
						var billst= $(this).find('billst').text();
						var billto_code= $(this).find('billto_code').text();
						$("#billing").html("<p class='text-uppercase text-strong mb-10 custom-font'>BILLING Address</p><ul class='list-unstyled text-default lt mb-20'><li>"+billcity+"</li><li>"+billname+"</li><li>"+billst+"</li><li>"+billto_code+"</li></ul>");

						});
		
			
			}

    });   

}	 
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