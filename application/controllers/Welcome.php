<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 *
	 */
	 const SERVICE_URL = "http://192.185.56.80/~mysmartportal/development/orders.xml";
	 
	 
	 
	public function index($msg=null)
	{
     if($this->session->userdata('subcode') == 1){

	if($msg==null)
			 {
			   $data['msg']="";
			 
			 }else if($msg=="logout")
			 {
			     $data['msg']="<h4 style='color:green;'>successfully Logged out</h4>";
			 }else
			 {
			   $data['msg']="<h4 style='color:red;'>Invalid username and password</h4>";
			 
			 }
			 $this->load->model('mysmartportal_model');
			 $data['users'] = $this->mysmartportal_model->getallusers_sublogin();
			 $this->load->view('login_latest',$data);
			 
			 }else
			 {
			 
			 redirect(base_url()."index.php/welcome/sub_index");
			 
			 }
			
	}
	
	
		public function sub_index($msg=null)
	{
			 if($msg==null)
			 {
			   $data['msg']="";
			 
			 }else if($msg=="logout")
			 {
			 $data['msg']="<h4 style='color:green;'>successfully Logged out</h4>";
			 }else
			 {
			   $data['msg']="<h4 style='color:red;'>Invalid username and password</h4>";
			 
			 }
			 $this->load->view('sub_login',$data);
			
	}
	
	public function subloginckeck()
	{
	 $username = $this->input->post('username');
	 if($username=="48617")
	 {
	        $sessionvals1=array(
											'subcode' =>1,
											
												  );
												  
												  
	        $this->session->set_userdata($sessionvals1);
			redirect(base_url()."index.php/welcome/index");
	 }else
	 {
	   $sessionvals1="";
	   $this->session->set_userdata($sessionvals1);
	   redirect(base_url()."index.php/welcome/index");
	 }
	
									
	
	
	}
	
	public function getpassowrd()
	{
	$email = $this->input->post("email");
	$this->load->model('mysmartportal_model');
	$password = $this->mysmartportal_model->getpassowrd($email);
	echo $password[0]->password;
	}
	
	
	public function logincheck()
	{
				  $username = $this->input->post('username');
				  $password = $this->input->post('password');
				  //load model
				  $this->load->model('mysmartportal_model');
				  
				  $user = $this->mysmartportal_model->checkLoginDetails($username,$password);
				  if($user == "faild")
				  {
					redirect(base_url()."index.php/welcome/index/error");
				  
				  }else{
								$sessionvals=array(
											'userid' => $user[0]->id,
											'username' => @$user[0]->username,
											'firstname' => $user[0]->first_name,
											'lastname' => $user[0]->last_name,
											'email' => $user[0]->email_id,
											'phone_number' => $user[0]->phone_number,
											'role' => $user[0]->role,
											'cust_code' => $user[0]->cus_code,
											'is_logged_in' => 1
												  );
										  $this->session->set_userdata($sessionvals);
										  if($this->session->userdata('role')==1)
											{
											   redirect(base_url()."index.php/welcome/admin_dashboard");
											}else
											{
												 redirect(base_url()."index.php/welcome/dashboard");
											
											}
										
				  
				  }
				  

	}
	
	public function logout()
	{
			   $sessionvals=array(
					            'userid' => '',
								'username' => '',
								'firstname' => '',
								'lastname' => '',
								'email' => '',
								'phone_number' => '',
								'role' => '',
								'cust_code' => '',
								'is_logged_in' => 0
				);
				$this->session->unset_userdata($sessionvals);
				
				 $sessionvals1=array(
											'subcode' =>0,
											
												  );
												  $this->session->unset_userdata($sessionvals1);
				@session_destroy();
				redirect(base_url()."index.php/welcome/index/logout");

	}
	
	public function dashboard()
	{
		if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
			if($this->session->userdata('role')==1)
				{
					 $this->load->view('admin_header');
					 $this->load->view('admin_index');
					  $this->load->view('footer');
				}else
				{
				
				    $this->load->model('Mysmartportal_model');
					$usermenu=$this->Mysmartportal_model->getmenu($this->session->userdata('userid'));
					$userallmenu=$this->Mysmartportal_model->getallusermenu();
					$split = explode(",",@$usermenu[0]->menu_id);
					$usermenu1 = array();
					for($i=0;$i<sizeof($split);$i++)
					{
					  $finalusermenu = array('id'=>$split[$i],
											 'menuname'=>$this->Mysmartportal_model->getmenuname($split[$i])
											 );
					  $usermenu1[$i] = $finalusermenu;
					}
					 $data['menu']=$usermenu1;
					 $data['ids']=$usermenu[0]->menu_id;
					 $email1=$this->session->userdata('email');
					 $cust_code= $this->session->userdata('cust_code'); 
					 $rss = new DOMDocument(); 
			         $rss->load("http://216.234.105.194:8088/Alpha.svc/E21DashBoardData/".$cust_code."/".$email1."/UserType/PermLevel/1-1-2010/1-1-2016/5434548B-9C59-451E-9673-1D462C11953B/E2795374-87A2-45DE-AD46-194D042B6213");
			
      				   foreach ($rss->getElementsByTagName('E21DashBoardData') as $node)
									   {	
                                        if (strpos($node->getElementsByTagName('PendingOrders')->item(0)->nodeValue,'Error Number') !== false) {
                                         $pendingorders = "";	
										 $opencases = "";	
										 $openorders = "";	
										 $shippedorders = "";     
                                               }else{									   
									     $pendingorders = $node->getElementsByTagName('PendingOrders')->item(0)->nodeValue;	
										 $opencases = $node->getElementsByTagName('OpenCases')->item(0)->nodeValue;	
										 $openorders = $node->getElementsByTagName('OpenOrders')->item(0)->nodeValue;	
										 $shippedorders = $node->getElementsByTagName('ShippedOrders')->item(0)->nodeValue;	
									}
										 $data['pendingorders'] = $pendingorders;
										 $data['opencases'] = $opencases;
										 $data['openorders'] = $openorders;
										 $data['shippedorders'] = $shippedorders;
									   }
	
					
					 $this->load->view('dashboard_user_latest',$data); 
					
				
				}
			 
			
			 }

	}
	
	public function orders()
	{
	
			  if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
				{
				   redirect(base_url()."index.php/welcome/index");
				
				}else{
				
					$this->load->model('Mysmartportal_model');
					$usermenu=$this->Mysmartportal_model->getmenu($this->session->userdata('userid'));
					$userallmenu=$this->Mysmartportal_model->getallusermenu();
					$split = explode(",",@$usermenu[0]->menu_id);
					$usermenu1 = array();
					$orderpageaccess = "";
					for($i=0;$i<sizeof($split);$i++)
					{
					if($split[$i]==2)
					{
					$orderpageaccess = "ok";
					
					}
					  $finalusermenu = array('id'=>$split[$i],
											 'menuname'=>$this->Mysmartportal_model->getmenuname($split[$i])
											 );
					  $usermenu1[$i] = $finalusermenu;
					}
					$data['menu']=$usermenu1;
					$data['ids']=$usermenu[0]->menu_id;
                     if($orderpageaccess=="ok"){
					 $this->load->view('header',$data);
					 $this->load->view('orders');
					 $this->load->view('footer_orders');
				         }else
						 {
						 redirect(base_url()."index.php/welcome/dashboard");
						 
						 }
				 }
				
	}
	
	
	
	public function open_orders()
	{
	
			  if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
				{
				   redirect(base_url()."index.php/welcome/index");
				
				}else{
				
					$this->load->model('Mysmartportal_model');
					$usermenu=$this->Mysmartportal_model->getmenu($this->session->userdata('userid'));
					$userallmenu=$this->Mysmartportal_model->getallusermenu();
					$split = explode(",",@$usermenu[0]->menu_id);
					$usermenu1 = array();
					$orderpageaccess = "";
					for($i=0;$i<sizeof($split);$i++)
					{
					if($split[$i]==2)
					{
					$orderpageaccess = "ok";
					
					}
					  $finalusermenu = array('id'=>$split[$i],
											 'menuname'=>$this->Mysmartportal_model->getmenuname($split[$i])
											 );
					  $usermenu1[$i] = $finalusermenu;
					}
					$data['menu']=$usermenu1;
					$data['ids']=$usermenu[0]->menu_id;
                     if($orderpageaccess=="ok"){
					 $this->load->view('header',$data);
					 $this->load->view('open_orders');
					 $this->load->view('open_orders_footer');
				         }else
						 {
						 redirect(base_url()."index.php/welcome/dashboard");
						 
						 }
				 }
				
	}
	
	
	
	public function order_view($order_id=null)
	{
			 if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
			 {
			   redirect(base_url()."index.php/welcome/index");
			
			 }else{
			 
			        $this->load->model('Mysmartportal_model');
					$usermenu=$this->Mysmartportal_model->getmenu($this->session->userdata('userid'));
					$userallmenu=$this->Mysmartportal_model->getallusermenu();
					$split = explode(",",@$usermenu[0]->menu_id);
					$usermenu1 = array();
					for($i=0;$i<sizeof($split);$i++)
					{
					  $finalusermenu = array('id'=>$split[$i],
											 'menuname'=>$this->Mysmartportal_model->getmenuname($split[$i])
											 );
					  $usermenu1[$i] = $finalusermenu;
					}
					$data['menu']=$usermenu1;
					$data['ids']=$usermenu[0]->menu_id;
					$data['order_id'] = $order_id;
					
				 $this->load->view('header',$data);
				 $this->load->view('order-view');
				 $this->load->view('orderview_footer');
			 }
		
	}
	
	public function orderview_data($order_id)
	{
	
	  if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
	        $cust_code= $this->session->userdata('cust_code'); 
	        $rss = new DOMDocument(); 
			$rss->load("http://216.234.105.194:8088/Alpha.svc/E21GetOrderDetails/".$cust_code."/".$order_id."/5434548B-9C59-451E-9673-1D462C11953B/E2795374-87A2-45DE-AD46-194D042B6213");
			//echo print_r($rss);
	         echo"<diffgr:diffgram xmlns:diffgr='urn:schemas-microsoft-com:xml-diffgram-v1' xmlns:msdata='urn:schemas-microsoft-com:xml-msdata'><DocumentElement xmlns=''><OrderDetails>";
									   foreach ($rss->getElementsByTagName('OrderDetails') as $node)
									   {									  
									      echo "<order_number>".$node->getElementsByTagName('order_number')->item(0)->nodeValue."</order_number><item_no>".$node->getElementsByTagName('item_no')->item(0)->nodeValue."</item_no><part_code>".$node->getElementsByTagName('part_code')->item(0)->nodeValue."</part_code><part_desc>".$node->getElementsByTagName('part_desc')->item(0)->nodeValue."</part_desc><qty>".$node->getElementsByTagName('qty')->item(0)->nodeValue."</qty><uom>".$node->getElementsByTagName('uom')->item(0)->nodeValue."</uom><item_price>".$node->getElementsByTagName('item_price')->item(0)->nodeValue."</item_price><extended_price>".$node->getElementsByTagName('extended_price')->item(0)->nodeValue."</extended_price><item_stat>".$node->getElementsByTagName('item_stat')->item(0)->nodeValue."</item_stat><item_status>".$node->getElementsByTagName('item_status')->item(0)->nodeValue."</item_status>";
									   }
									      echo "</OrderDetails></DocumentElement></diffgr:diffgram></DataTable>";
										  
			}
									   
	
	
	}
	
	
	
	public function orderview_header_data($order_id)
	{
	
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
	        $cust_code= $this->session->userdata('cust_code'); 
	        $rss = new DOMDocument(); 
			$rss->load("http://216.234.105.194:8088/Alpha.svc/E21GetOrderInvoiceHeader/10729-000/689308-001/jdownes@cmsprintsolutions.com/UserType/PermLevel/5434548B-9C59-451E-9673-1D462C11953B/E2795374-87A2-45DE-AD46-194D042B6213");
			//echo print_r($rss);
	        echo"<diffgr:diffgram xmlns:diffgr='urn:schemas-microsoft-com:xml-diffgram-v1' xmlns:msdata='urn:schemas-microsoft-com:xml-msdata'><DocumentElement xmlns=''><InvoiceHeader>";
									   foreach ($rss->getElementsByTagName('InvoiceHeader') as $node)
									   {	
                                             
                                           if (strpos($node->getElementsByTagName('carr_code')->item(0)->nodeValue,'Error Number') !== false) {
                                                     
                                               }else{
                                          echo "<carr_code>".$node->getElementsByTagName('carr_code')->item(0)->nodeValue."</carr_code><invoice_numb>".$node->getElementsByTagName('invoice_numb')->item(0)->nodeValue."</invoice_numb><order_numb>".$node->getElementsByTagName('order_numb')->item(0)->nodeValue."</order_numb><rel_numb>".$node->getElementsByTagName('rel_numb')->item(0)->nodeValue."</rel_numb><order_date>".$node->getElementsByTagName('order_date')->item(0)->nodeValue."</order_date><post_date>".$node->getElementsByTagName('post_date')->item(0)->nodeValue."</post_date><ship_date>".$node->getElementsByTagName('ship_date')->item(0)->nodeValue."</ship_date><billto_code>".$node->getElementsByTagName('billto_code')->item(0)->nodeValue."</billto_code><billname>".$node->getElementsByTagName('billname')->item(0)->nodeValue."</billname><billcity>".$node->getElementsByTagName('billcity')->item(0)->nodeValue."</billcity><billst>".$node->getElementsByTagName('billst')->item(0)->nodeValue."</billst><shipto_code>".$node->getElementsByTagName('shipto_code')->item(0)->nodeValue."</shipto_code><shipname>".$node->getElementsByTagName('shipname')->item(0)->nodeValue."</shipname><shipcity>".$node->getElementsByTagName('shipcity')->item(0)->nodeValue."</shipcity><shipst>".$node->getElementsByTagName('shipst')->item(0)->nodeValue."</shipst><cust_po>".$node->getElementsByTagName('cust_po')->item(0)->nodeValue."</cust_po><total_tax>".$node->getElementsByTagName('total_tax')->item(0)->nodeValue."</total_tax><amount>".$node->getElementsByTagName('amount')->item(0)->nodeValue."</amount><shipping_charge>".$node->getElementsByTagName('shipping_charge')->item(0)->nodeValue."</shipping_charge><handling_charge>".$node->getElementsByTagName('handling_charge')->item(0)->nodeValue."</handling_charge><ship_charge>".$node->getElementsByTagName('ship_charge')->item(0)->nodeValue."</ship_charge>";
									   }
									    
									   }
									      echo "</InvoiceHeader></DocumentElement></diffgr:diffgram></DataTable>";
									   
	
	        }
	}
	
	public function admin_dashboard()
	{
	
		   if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
			{
			   redirect(base_url()."index.php/welcome/index");
			
			}else{		
					  if($this->session->userdata('role')==1)
						{
							 $this->load->view('admin_header');
							 $this->load->view('admin_index');
						}else
						{
							 $this->load->view('header'); 
							 $this->load->view('index');
						
						}
					   $this->load->view('footer'); 
				 }

	}
	
	
	public function all_orders($email=null)
	{
	
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
			$rss = new DOMDocument(); 
			 $cust_code= $this->session->userdata('cust_code'); 
			$email1=$this->session->userdata('email');
			
			$urlArray = array(array('name' => 'api', 'url' => 'http://216.234.105.194:8088/Alpha.svc/E21GetOrders/'.$cust_code.'/'.$email1.'/UserType/PermLevel/50/1/5434548B-9C59-451E-9673-1D462C11953B/E2795374-87A2-45DE-AD46-194D042B6213/order_number/desc'),
								  );
								  
						  foreach ($urlArray as $url) 
						  {
			                           $rss->load($url['url']);
									      echo"<diffgr:diffgram xmlns:diffgr='urn:schemas-microsoft-com:xml-diffgram-v1' xmlns:msdata='urn:schemas-microsoft-com:xml-msdata'><DocumentElement xmlns=''>";
									   foreach ($rss->getElementsByTagName('Order') as $node)
									   {
									   if (strpos($node->getElementsByTagName('order_number')->item(0)->nodeValue,'Error Number') !== false) {
                                                     
                                               }else{
									  if($email == 1)
									  {
									   echo "<Order diffgr:id='Order1' msdata:rowOrder='0' diffgr:hasChanges='inserted'><order_number>".$node->getElementsByTagName('order_number')->item(0)->nodeValue."</order_number><order_date>".$node->getElementsByTagName('order_date')->item(0)->nodeValue."</order_date><po_number>".$node->getElementsByTagName('po_number')->item(0)->nodeValue."</po_number><invoice_number>".$node->getElementsByTagName('invoice_number')->item(0)->nodeValue."</invoice_number><invoice_amount>".$node->getElementsByTagName('invoice_amount')->item(0)->nodeValue."</invoice_amount><ship_city>".$node->getElementsByTagName('ship_city')->item(0)->nodeValue."</ship_city><ship_state>".$node->getElementsByTagName('ship_state')->item(0)->nodeValue."</ship_state><order_status>".$node->getElementsByTagName('order_status')->item(0)->nodeValue."</order_status></Order>";
                                        break;
									  }else{
									      echo "<Order diffgr:id='Order1' msdata:rowOrder='0' diffgr:hasChanges='inserted'><order_number>".$node->getElementsByTagName('order_number')->item(0)->nodeValue."</order_number><order_date>".$node->getElementsByTagName('order_date')->item(0)->nodeValue."</order_date><po_number>".$node->getElementsByTagName('po_number')->item(0)->nodeValue."</po_number><invoice_number>".$node->getElementsByTagName('invoice_number')->item(0)->nodeValue."</invoice_number><invoice_amount>".$node->getElementsByTagName('invoice_amount')->item(0)->nodeValue."</invoice_amount><ship_city>".$node->getElementsByTagName('ship_city')->item(0)->nodeValue."</ship_city><ship_state>".$node->getElementsByTagName('ship_state')->item(0)->nodeValue."</ship_state><order_status>".$node->getElementsByTagName('order_status')->item(0)->nodeValue."</order_status></Order>";
                                            }									     
										 }
									   }
									      echo "</DocumentElement></diffgr:diffgram></DataTable>";
									   
						  }
						  
			}

	}
	
	
	public function all_orders_to_csv($email=null)
	{
	
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
			$rss = new DOMDocument(); 
			 $cust_code= $this->session->userdata('cust_code'); 
			$email1=$this->session->userdata('email');
			
			$urlArray = array(array('name' => 'api', 'url' => 'http://216.234.105.194:8088/Alpha.svc/E21GetOrders/'.$cust_code.'/'.$email1.'/UserType/PermLevel/50/1/5434548B-9C59-451E-9673-1D462C11953B/E2795374-87A2-45DE-AD46-194D042B6213/order_number/desc'),
								  );
								$csv_data = "";  
						  foreach ($urlArray as $url) 
						  {
			                           $rss->load($url['url']);
									   foreach ($rss->getElementsByTagName('Order') as $node)
									   {
									   if (strpos($node->getElementsByTagName('order_number')->item(0)->nodeValue,'Error Number') !== false) {                                  
                                          }else{
									  $csv_data = $csv_data."_".$node->getElementsByTagName('order_number')->item(0)->nodeValue.",".$node->getElementsByTagName('order_date')->item(0)->nodeValue.",".$node->getElementsByTagName('po_number')->item(0)->nodeValue.",".$node->getElementsByTagName('invoice_number')->item(0)->nodeValue.",".$node->getElementsByTagName('invoice_amount')->item(0)->nodeValue.",".$node->getElementsByTagName('ship_city')->item(0)->nodeValue.",".$node->getElementsByTagName('ship_state')->item(0)->nodeValue.",".$node->getElementsByTagName('order_status')->item(0)->nodeValue;
									     // echo "<Order diffgr:id='Order1' msdata:rowOrder='0' diffgr:hasChanges='inserted'><order_number>".$node->getElementsByTagName('order_number')->item(0)->nodeValue."</order_number><order_date>".$node->getElementsByTagName('order_date')->item(0)->nodeValue."</order_date><po_number>".$node->getElementsByTagName('po_number')->item(0)->nodeValue."</po_number><invoice_number>".$node->getElementsByTagName('invoice_number')->item(0)->nodeValue."</invoice_number><invoice_amount>".$node->getElementsByTagName('invoice_amount')->item(0)->nodeValue."</invoice_amount><ship_city>".$node->getElementsByTagName('ship_city')->item(0)->nodeValue."</ship_city><ship_state>".$node->getElementsByTagName('ship_state')->item(0)->nodeValue."</ship_state><order_status>".$node->getElementsByTagName('order_status')->item(0)->nodeValue."</order_status></Order>";
									      }
									   }
									   
									   $odersdata = explode("_",$csv_data);
									     
									   $file = fopen("orders.csv","w");

										foreach ($odersdata as $line)
										  {
										  fputcsv($file,explode(',',$line));
										  }

										fclose($file);
										
										
										  header("Content-type: text/csv");
										  header("Content-disposition: attachment; filename = orders.csv");
										  readfile($_SERVER['DOCUMENT_ROOT']."/orders.csv");
						  }
						  
			}

	}
	
	
	public function orders_search_by_dates($from,$to,$order_id)
	{
	
	      if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		  {
		   redirect(base_url()."index.php/welcome/index");
		
		  }else{
			$rss = new DOMDocument(); 
			 $cust_code= $this->session->userdata('cust_code'); 
			$email1=$this->session->userdata('email');
			$urlArray = array(array('name' => 'api', 'url' => 'http://216.234.105.194:8088/Alpha.svc/E21GetOrderList_DateSearch/'.$cust_code.'/'.$email1.'/'.$from.'/'.$to.'/'.$order_id.'/UserType/PermLevel/50/1/5434548B-9C59-451E-9673-1D462C11953B/E2795374-87A2-45DE-AD46-194D042B6213'),
								  );
								  
						  foreach ($urlArray as $url) 
						  {
			                           $rss->load($url['url']);
									      echo"<diffgr:diffgram xmlns:diffgr='urn:schemas-microsoft-com:xml-diffgram-v1' xmlns:msdata='urn:schemas-microsoft-com:xml-msdata'><DocumentElement xmlns=''>";
									   foreach ($rss->getElementsByTagName('Order') as $node)
									   {	
									   
									    if (strpos($node->getElementsByTagName('order_number')->item(0)->nodeValue,'Error Number') !== false) {
                                                     
                                               }else{								  
									      echo "<Order diffgr:id='Order1' msdata:rowOrder='0' diffgr:hasChanges='inserted'><order_number>".$node->getElementsByTagName('order_number')->item(0)->nodeValue."</order_number><order_date>".$node->getElementsByTagName('order_date')->item(0)->nodeValue."</order_date><po_number>".$node->getElementsByTagName('po_number')->item(0)->nodeValue."</po_number><invoice_number>".$node->getElementsByTagName('invoice_number')->item(0)->nodeValue."</invoice_number><invoice_amount>".$node->getElementsByTagName('invoice_amount')->item(0)->nodeValue."</invoice_amount><ship_city>".$node->getElementsByTagName('ship_city')->item(0)->nodeValue."</ship_city><ship_state>".$node->getElementsByTagName('ship_state')->item(0)->nodeValue."</ship_state><order_status>".$node->getElementsByTagName('order_status')->item(0)->nodeValue."</order_status></Order>";
									      }
									   }
									      echo "</DocumentElement></diffgr:diffgram></DataTable>";
									   
						  }
						  
				}

	}
	public function adduser()
	{
	
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
			$this->load->view('admin_header');
			$this->load->view('adduser');
			$this->load->view('footer'); 
			
			}
			
	}
	
	public function saveuser()
	{
	
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
		 $params = array('first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'email_id'=>$this->input->post('email'),
						'phone_number'=>$this->input->post('ph_number'),
						'user_name'=>$this->input->post('username'),
						'password'=>$this->input->post('password'),
						'cus_code'=>$this->input->post('cus_code'),
						'role'=>$this->input->post('role')   
						 );
						 $this->load->model('Mysmartportal_model');
						 $save = $this->Mysmartportal_model->saveuser($params);
		                                  //$this->Mysmartportal_model->saveuser($params);
						redirect(base_url()."index.php/welcome/allusers/inserted");
		}
	
	}
	
	
	
	public function allusers($msg=null,$count=null)
	{
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
	
	        $data['msg']=$msg;
			$data['count']=$count;
	        $this->load->model('Mysmartportal_model');
			$data['allusers'] = $this->Mysmartportal_model->getallusers();
	        $this->load->view('admin_header');
			$this->load->view('allusers',$data);
			$this->load->view('footer_users'); 
			
			}
	
	}
	

	public function edituser($id=null)
	{
	
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
	        $this->load->model('Mysmartportal_model');
			$data['edituser'] = $this->Mysmartportal_model->getedituser($id);
			$usermenu=$this->Mysmartportal_model->getmenu($id);
			$userallmenu=$this->Mysmartportal_model->getallusermenu();
			//echo "TTTTTTTT".@$usermenu[0]->menu_id;
			$split = explode(",",@$usermenu[0]->menu_id);
			$usermenu1 = array();
			for($i=0;$i<sizeof(@$split);$i++)
			{
			  $finalusermenu = array('id'=>$split[$i],
			                         'menuname'=>$this->Mysmartportal_model->getmenuname($split[$i])
			  );
			$usermenu1[$i] = $finalusermenu;
			}
			$data['menu']=@$usermenu1;
			$data['allmenu'] = $userallmenu;
			$data['assinedid'] = @$usermenu[0]->menu_id;
			$this->load->view('admin_header');
			$this->load->view('edituser',$data);
			$this->load->view('footer'); 
			
			}
	}	
	
		public function deleteuser($id)
		{
		if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
		    $this->load->model("Mysmartportal_model");
			$this->Mysmartportal_model->deleteuser($id);
		 redirect(base_url()."index.php/welcome/allusers/updated");	
		}
		
		
		}
		
	
	public function saveedituser()
	{
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
			$uid= $this->input->post('uid');
			$ids= "";
			foreach($this->input->post('check') as $value){
			if($ids=="")
			{
			$ids = $value;
			
			}else{
			$ids= $ids.",".$value;
			}
       
             }
	
	
			$params = array('first_name'=>$this->input->post('first_name'),
							'last_name'=>$this->input->post('last_name'),
							'email_id'=>$this->input->post('email'),
							'phone_number'=>$this->input->post('ph_number'),
							'cus_code'=>$this->input->post('cus_code'),
							'password'=>$this->input->post('password'),
							'status'=>$this->input->post('status'),
							'role'=>$this->input->post('role')     
							 );
							 $this->load->model('Mysmartportal_model');
							 $save = $this->Mysmartportal_model->saveedituser($params,$uid);
							 
							 $paramsid = array('menu_id'=>$ids);
							 $saveid = $this->Mysmartportal_model->saveeditusermenu($paramsid,$uid);
							 
			redirect(base_url()."index.php/welcome/allusers/updated");	
			
			}
	}
	
	public function user_profile()
	{
	
	  if($this->session->userdata('is_logged_in') != '')
	  {
	     $this->load->view('profile'); 
	  }else
	  {
	  redirect(base_url()."index.php/welcome/");
	  
	  }
	
	
	}
	
	public function bulkuserupload()
	{
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
			$this->load->view('admin_header');
			$this->load->view('bulkuserupload');
			$this->load->view('footer'); 
			}
	
	
	
	}
	public function technical_support()
	{
	if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
		{
		   redirect(base_url()."index.php/welcome/index");
		
		}else{
		
		 $this->load->model('Mysmartportal_model');
					$usermenu=$this->Mysmartportal_model->getmenu($this->session->userdata('userid'));
					$userallmenu=$this->Mysmartportal_model->getallusermenu();
					$split = explode(",",@$usermenu[0]->menu_id);
					$usermenu1 = array();
					for($i=0;$i<sizeof($split);$i++)
					{
					  $finalusermenu = array('id'=>$split[$i],
											 'menuname'=>$this->Mysmartportal_model->getmenuname($split[$i])
											 );
					  $usermenu1[$i] = $finalusermenu;
					}
					$data['menu']=$usermenu1;
					$data['ids']=$usermenu[0]->menu_id;
			$this->load->view('header',$data);
			$this->load->view('technical');
			$this->load->view('footer'); 
			}
	
	
	
	}
	
	
	function upload_attendance()
	{
	
				$image_name = $_FILES['exc1']['name'];
				$timestamp=rand(1,99999);

				copy($_FILES['exc1']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/studentdetails/".$image_name);
				
				$this->load->library('excel');
                ini_set("memory_limit", "-1");
				   set_include_path(get_include_path() . PATH_SEPARATOR . "Classes/");
				   include $_SERVER['DOCUMENT_ROOT']."/application/third_party/PHPExcel/IOFactory.php";
				   $inputFileName = $_SERVER['DOCUMENT_ROOT']."/studentdetails/".$image_name;
				 try {
				   $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				  } catch(Exception $e) {
				   die("Error loading file :" . $e->getMessage());
				  }
				//All data from excel
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				//echo "DDDDDDDD".sizeof($sheetData);
				$error_duplicate="";
				
				
				
				
				for($j=2; $j <= sizeof($sheetData); $j++) 
		          {
						 $email=$sheetData[$j]['C'];
						 $this->load->model('Mysmartportal_model');
						 $check = $this->Mysmartportal_model->checkuser($email);
						  if($check>0 or $sheetData[$j]['H']==1 or $sheetData[$j]['A']=="" or $sheetData[$j]['C']=="" or $sheetData[$j]['D']=="" or $sheetData[$j]['E']=="" or $sheetData[$j]['F']=="" or $sheetData[$j]['G']=="" or $sheetData[$j]['H']==""){
								$errormail = str_replace("@","ZZ",$email);
							   redirect(base_url()."index.php/welcome/allusers/inserted1/duplicated_".$errormail);
															   
							 }
					 
			 	
		
		          }
		
	

		for($x=2; $x <= sizeof($sheetData); $x++) 
		{
		              //echo $Name = $sheetData[$x]['A']."<br>";
		             //echo $email= $sheetData[$x]['B']."<br>";
				                              $fname=$sheetData[$x]['A'];
											  $lname=$sheetData[$x]['B'];
											  $email=$sheetData[$x]['C'];
											  $phonenumber=$sheetData[$x]['D'];
											  $username=$sheetData[$x]['E'];
											  $password=$sheetData[$x]['F'];
											  $cus_code=$sheetData[$x]['G'];
											  $role=$sheetData[$x]['H'];
											  $ststatus=1;
											  if($role==1 or $email==null)
											  {
											     redirect(base_url()."index.php/welcome/allusers/inserted1/duplicated_error");
											  }else
											  {
											    $this->load->model('Mysmartportal_model');
											    $check = $this->Mysmartportal_model->checkuser($email);
											   
											   if($check>0)
											   {
											     $errormail = str_replace("@","ZZ",$email);
											     redirect(base_url()."index.php/welcome/allusers/inserted1/duplicated_".$errormail);
											   
											   }else{
											 
														$params = array('first_name'=>$fname,
														'last_name'=>$lname,
														'email_id'=>$email,
														'phone_number'=>$phonenumber,
														'user_name'=>$username,
														'password'=>$password,
														'cus_code'=>$cus_code,
														'role'=>$role  
														 );
														 $this->load->model('Mysmartportal_model');
														 $save = $this->Mysmartportal_model->saveuser($params);

												 }
											  }
											  
										  



                    }
				redirect(base_url()."index.php/welcome/allusers/inserted/".$x);
				
				
				
				
	
			   
	        }
	        
	        
	        public function open_invoices()
	{
	
			  if($this->session->userdata('is_logged_in') == '' && $this->session->userdata('is_logged_in') == 0)
				{
				   redirect(base_url()."index.php/welcome/index");
				
				}else{
				
					$this->load->model('Mysmartportal_model');
					$usermenu=$this->Mysmartportal_model->getmenu($this->session->userdata('userid'));
					$userallmenu=$this->Mysmartportal_model->getallusermenu();
					$split = explode(",",@$usermenu[0]->menu_id);
					$usermenu1 = array();
					$orderpageaccess = "";
					for($i=0;$i<sizeof($split);$i++)
					{
					if($split[$i]==2)
					{
					$orderpageaccess = "ok";
					
					}
					  $finalusermenu = array('id'=>$split[$i],
											 'menuname'=>$this->Mysmartportal_model->getmenuname($split[$i])
											 );
					  $usermenu1[$i] = $finalusermenu;
					}
					$data['menu']=$usermenu1;
					$data['ids']=$usermenu[0]->menu_id;
                     if($orderpageaccess=="ok")
					 {
					 
						 $this->load->view('header',$data);
						 $this->load->view('invoices');
						 $this->load->view('invoice_footer');
				     }else
					 {
						 redirect(base_url()."index.php/welcome/dashboard"); 
					 }
				 }
				
	}
	
	public function all_invoices($email=null)
	{
			$rss = new DOMDocument(); 
			 $cust_code= $this->session->userdata('cust_code'); 
			$email1=$this->session->userdata('email');
			$urlArray = array(array('name' => 'api', 'url' => 'http://216.234.105.194:8088/Alpha.svc/E21GetInvoiceList/'.$cust_code.'/'.$email1.'/UserType/PermLevel/50/1/5434548B-9C59-451E-9673-1D462C11953B/E2795374-87A2-45DE-AD46-194D042B6213/invoice_numb/desc'),
								  );
								  
						  foreach ($urlArray as $url) 
						  {
			                           $rss->load($url['url']);
									      echo"<diffgr:diffgram xmlns:diffgr='urn:schemas-microsoft-com:xml-diffgram-v1' xmlns:msdata='urn:schemas-microsoft-com:xml-msdata'><DocumentElement xmlns=''>";
									   foreach ($rss->getElementsByTagName('Invoice') as $node)
									   {	
									    if (strpos($node->getElementsByTagName('order_number')->item(0)->nodeValue,'Error Number') !== false) {
                                                     
                                               }else{								  
									      echo "<Invoice diffgr:id='Invoice1' msdata:rowOrder='0' diffgr:hasChanges='inserted'><invoice_numb>".$node->getElementsByTagName('invoice_numb')->item(0)->nodeValue."</invoice_numb><billto_code>".$node->getElementsByTagName('billto_code')->item(0)->nodeValue."</billto_code><billname>".$node->getElementsByTagName('billname')->item(0)->nodeValue."</billname><billcity>".$node->getElementsByTagName('billcity')->item(0)->nodeValue."</billcity><billst>".$node->getElementsByTagName('billst')->item(0)->nodeValue."</billst><shipto_code>".$node->getElementsByTagName('shipto_code')->item(0)->nodeValue."</shipto_code><shipname>".$node->getElementsByTagName('shipname')->item(0)->nodeValue."</shipname><shipcity>".$node->getElementsByTagName('shipcity')->item(0)->nodeValue."</shipcity><shipst>".$node->getElementsByTagName('shipst')->item(0)->nodeValue."</shipst><inv_date>".$node->getElementsByTagName('inv_date')->item(0)->nodeValue."</inv_date><entry_type>".$node->getElementsByTagName('entry_type')->item(0)->nodeValue."</entry_type><amount>".$node->getElementsByTagName('totalamount')->item(0)->nodeValue."</amount><due_date>".$node->getElementsByTagName('due_date')->item(0)->nodeValue."</due_date></Invoice>";
			}						   }
									      echo "</DocumentElement></diffgr:diffgram></DataTable>";
									   
						  }

	}
	
	
	
}