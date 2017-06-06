<!DOCTYPE html>
<html>

<!-- ADD THE CLASS sidedar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>K</b>T</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>K</b>Ticketing</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="user_home.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
          
        </li>

        <li class="treeview">
			<a href="#"><i class="fa fa-calendar-o"></i><span>To Do List </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
				<li>
                	<a href="view_list.php"> <i class="fa fa-eye"></i> View</a>
                </li>
                <li>
                	<a href="add_new_todo.php?job=add_new"><i class="fa fa-plus-square"></i> Add</a>
                </li>
                <li>
                	<a href="task_manager.php?job=task_manager"><i class="fa fa-thumbs-up"></i> Task Manager</a>
                </li>		
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-university"></i><span> Bank</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
				<li>
                                    <a href="add_bank.php?job=bank_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
                                <li>
                                    <a href="deposit.php?job=deposit_form"><i class="fa fa-database"></i> Deposit</a>
                                </li>
                                <li>
                                    <a href="withdraw.php?job=withdraw_form"><i class="fa fa-share"></i> Withdraw</a>
                                </li>
                                <li>
                                    <a href="transfer.php?job=transfer_form"><i class="fa fa-exchange"></i> Transfer</a>
                                </li>
                                <li>
                                    <a href="cheque_deposit.php?job=cheque_deposit_select_form"><i class="fa fa-cc"></i> Cheque Deposit</a>
                                </li>
                                <li>
                                    <a href="cheque_presentation.php?job=cheque_presentation_select_form"><i class="fa fa-cc"></i> Cheque Presentation</a>
                                </li>
                                <li>
                                    <a href="cheque.php?job=cheque_select_form"><i class="fa fa-cc"></i> Cheque Reconciliation</a>
                                </li>	
			</ul>

		</li>


        <li class="treeview">
			<a href="#"><i class="fa fa-money"></i><span>Cash Box </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
				<li>
                                    <a href="cash.php?job=view_form"><i class="fa fa-eye"></i> View Balance</a>
                                </li>
                                <li>
                                    <a href="cash_transfer.php?job=transfer_form"><i class="fa fa-exchange"></i> Transfer</a>
                                </li>		
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-space-shuttle"></i><span>Booking </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
				<li>
                                    <a href="booking.php?job=booking_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="date_change.php?job=date_change_form"><i class="fa fa-calendar"></i> Date Change</a>
                                </li>
								<li>
                                    <a href="non_confirm_booking.php?job=list_non_confirm_form"><i class="fa fa-exclamation-circle"></i> Nonconfirm Booking</a>
                                </li>
								<li>
                                    <a href="ticket_number.php?job=ticket"><i class="fa fa-file"></i> Ticket Number</a>
                                </li>
								<li>
                                    <a href="booking_transfer.php?job=transfer"><i class="fa fa-share-square"></i> Transfer</a>
                                </li>
								<li>
                                    <a href="date_change.php?job=list"><i class="fa fa-share-square"></i> Date Change Logbook</a>
                                </li>
								<li>
                                    <a href="book.php?job=list"><i class="fa fa-file-text"></i> Log Book</a>
                                </li>	
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-taxi"></i><span>Cab </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
                                <li>
                                    <a href="cab.php?job=cab_form"><i class="fa fa-plus-square"></i> Book</a>
                                </li>
								<li>
                                    <a href="search_cab.php?job=search_cab"><i class="fa fa-search"></i> Search</a>
                                </li>
									<li>
                                    <a href="log_book.php?job=log_book"><i class="fa fa-file-text"></i> LogBook</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-user"></i><span>Customer </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
                                <li>
                                    <a href="customer.php?job=customer_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>				
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-gift"></i><span>Gift Voucher </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
				<li>
                	<a href="gift_voucher.php?job=gift_voucher"><i class="fa fa-plus-square"></i> Add</a>
                </li>			
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-life-ring"></i><span> Insurance </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
                                <li>
                                    <a href="insurance.php?job=insurance_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="insurance.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>			
			</ul>

		</li>


        <li class="treeview">
			<a href="#"><i class="fa fa-money"></i><span> Other Incomes </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
                                <li>
                                    <a href="invoice.php?job=invoice_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="invoice.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>		
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-money"></i><span> Other Expenses</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
                                <li>
                                    <a href="other_expenses.php?job=other_expenses_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="other_expenses.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>	
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-money"></i><span> Loan</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
                                <li>
                                    <a href="loan.php?job=loan_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="loan.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-italic"></i><span> Itinerary</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="paybill.php?job=paybill_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="paybill.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>
			</ul>

		</li>


        <li class="treeview">
			<a href="#"><i class="fa fa-credit-card"></i><span> Paybill</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>

			<ul class="treeview-menu">
                                <li>
                                    <a href="itinerary.php?job=itinerary_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="itinerary.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>
			</ul>

		</li>


        <li class="treeview">
			<a href="#"><i class="fa fa-italic"></i><span> Receipt</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="receipt.php?job=receipt_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="receipt.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>
			</ul>

		</li>


        <li class="treeview">
			<a href="#"><i class="fa fa-reply-all"></i><span> Refund</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="refund.php?job=refund_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="refund.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>
								<li>
                                    <a href="refund_logbook.php?job=search_form"><i class="fa fa-file-text"></i> Log Book</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-bar-chart"></i><span> Reports</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="profit_by_staff.php"><i class="fa fa-money"></i> Profit By Staff</a>
                                </li>
                                <li>
                                    <a href="ip.php"><i class="fa fa-italic"></i> IP Table</a>
                                </li>
								
								<li>
                                    <a href="all_non_confirm_booking.php?job=list_all_non_confirm_form"><i class="fa fa-exclamation-circle"></i> Nonconfirm Booking</a>
                                </li>
                                <li>
                                    <a href="chat_history.php?job=chat_history"><i class="fa fa-comment"></i> Chat History</a>
                                </li>
								 <li>
                                    <a href="income_profit.php?job=income_profit"><i class="fa fa-money"></i> Income & Expenses </a>
                                </li>
								<li>
                                    <a href="cheque_inventory.php?job=cheque_inventory"><i class="fa fa-money"></i> Cheque Inventory </a>
                                </li>
									<li>
                                    <a href="outstanding_invoice.php?job=outstanding_invoice"><i class="fa fa-book"></i> Outstanding Invoice </a>
                                </li>
									<li>
                                    <a href="outstanding_other_expenses.php?job=outstanding_other_expenses"><i class="fa fa-area-chart"></i> Outstanding Other Expenses </a>
                                </li>
									<li>
                                    <a href="outstanding_voucher.php?job=outstanding_voucher"><i class="fa fa-line-chart"></i> Outstanding Voucher </a>
                                </li>
									<li>
                                    <a href="customer_invoice_due.php?job=customer_invoice_due"><i class="fa fa-book"></i> Customer Invoice Due </a>
                                </li>
									<li>
                                    <a href="customer_other_expenses_due.php?job=customer_other_expenses_due"><i class="fa fa-area-chart"></i> Customer Other Expenses Due </a>
                                </li>
									<li>
                                    <a href="travels_voucher_due.php?job=travels_voucher_due"><i class="fa fa-line-chart"></i> Travels Voucher Due </a>
                                </li>
									<li>
                                    <a href="pnr.php?job=pnr"><i class="fa fa-file-text"></i> PNR Report </a>
                                </li>
									<li>
                                    <a href="staff_target.php?job=staff_target"><i class="fa fa-dot-circle-o"></i> Staff Target Report </a>
                                </li>
									<li>
                                    <a href="customer_birthday.php?job=customer_birthday"><i class="fa fa-birthday-cake"></i> Customer Birthday </a>
                                </li>
								<li>
                                    <a href="flight_date.php?job=flight_date"><i class="fa fa-fighter-jet"></i> Flight Date </a>
                                </li>
									<li>
                                    <a href="booking_without_visa.php?job=booking_without_visa"><i class="fa fa-book"></i> Booking Without Visa & Passport </a>
                                </li>
								<li>
                                    <a href="report_summary.php?job=report_summary"><i class="fa fa-file-text"></i> Report Summary</a>
                                </li>
									<li>
                                    <a href="branch_target_report.php?job=branch_target_report"><i class="fa fa-dot-circle-o"></i> Branch Target Report </a>
                                </li>
								<li>
                                    <a href="gift_voucher_list.php?job=gift_voucher_list"><i class="fa fa-gift"></i> Gift Voucher List</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-phone"></i><span> Telephone Directory</span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
 								<li>
                                    <a href="telephone_directory.php?job=telephone_directory"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
							<li>
                                    <a href="view_telephone_no.php?job=view_telephone_no"><i class="fa fa-eye"></i> View</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-users"></i><span> User Management </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="users.php?job=list"><i class="fa fa-eye"></i> View</a>
                                </li>
                                <li>
                                    <a href="users.php?job=add_new"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
                                <li>
                                    <a href="staff_salary.php?job=staff_salary"><i class="fa fa-money"></i> Staff Salary</a>
                                </li>
 								<li>
                                    <a href="search_salary.php?job=search_salary"><i class="fa fa-search"></i> Search Staff Salary</a>
                                </li>
									<li>
                                    <a href="branch_salary.php?job=search_salary"><i class="fa fa-search"></i> Search Branch Salary</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-ticket"></i><span>Voucher </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="voucher.php?job=voucher_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="voucher.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-cc-visa"></i><span>Visa </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="visa.php?job=visa_form"><i class="fa fa-plus-square"></i> Add</a>
                                </li>
								<li>
                                    <a href="visa.php?job=search_form"><i class="fa fa-search"></i> Search</a>
                                </li>
								<li>
                                    <a href="visa_logbook.php?job=search_form"><i class="fa fa-file-text"></i> Log Book</a>
                                </li>
			</ul>

		</li>

        <li class="treeview">
			<a href="#"><i class="fa fa-cogs"></i><span>System Settings </span><span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
                                <li>
                                    <a href="air_lines.php"><i class="fa fa-plane"></i> Air Lines Settings</a>
                                </li>
								<li>
                                    <a href="air_ports.php"><i class="fa fa-map-marker"></i> Air Ports Settings</a>
                                </li>
								<li>
                                    <a href="cab_package.php"><i class="fa fa-taxi"></i> Cab Packages</a>
                                </li>
								<li>
                                    <a href="country.php"><i class="fa fa-flag"></i> Country Settings</a>
                                </li>
								<li>
                                    <a href="embassy.php"><i class="fa fa-university"></i> Embassy Settings</a>
                                </li>
								<li>
                                    <a href="nationality.php"><i class="fa fa-heart"></i> Nationality Settings</a>
                                </li>
								<li>
                                    <a href="modules.php"><i class="fa fa-cubes"></i> Module Settings</a>
                                </li>
								<li>
                                    <a href="offer.php"><i class="fa fa-money"></i> Offer Settings</a>
                                </li>
								<li>
                                    <a href="travels.php"><i class="fa fa-fighter-jet"></i> Travel Agency Settings</a>
                                </li>
								<li>
                                    <a href="quick_links.php?job=quick_links"><i class="fa fa-external-link"></i> Quick Links</a>
                                </li>
								<li>
                                    <a href="message.php?job=message"><i class="fa fa-external-link"></i> Message</a>
                                </li>
								<li>
                                    <a href="branch_target.php?branch_target"><i class="fa fa-money"></i> Branch Target</a>
                                </li>
			</ul>

		</li>

       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


