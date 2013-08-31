<div class="container">
    <div class="row">
        <div class="span3">
            <div class="well sidebar-nav transparent-box">
                <ul class="nav nav-list">
                    <li class="nav-header"><i class="icon-cog icon-white"></i> TICKETS CONTROLS</li>
                    <li <?php if(empty($n)) echo "class='active'"; ?>><a href="Tickets/create">New Ticket</a></li>
                    <li><a href="Customers/customer_list">Customers List</a></li>
                    <li <?php if(!empty($n)) echo "class='active'"; ?>>
                        <a href="Tickets/assigned">Assigned Ticket</a></li>                    
                    <li class="nav-header"><i class="icon-cog icon-white"></i> DISPATCHES</li>
                    <li><a href="Tickets/upcoming_dispatches">Upcoming Dispatches</a></li>                    
                    <li><a href="Tickets/finish_dispatch">Update Dispatches</a></li>
                    <li class="nav-header"><i class="icon-cog icon-white"></i> CUSTOMERS</li>
                    <li><a href="Customers/customer_registration">Customers Registration</a></li>
                    <li><a href="Customers/customer_list">Customers List</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
            </div><!--/.well -->
        </div><!--/span-->
        <div class="span9" id="contents">
        </div>
    </div><!-- .row -->
</div><!-- .container -->