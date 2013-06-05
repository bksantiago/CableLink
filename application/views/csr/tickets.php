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
                    <li><a href="#">Link</a></li>
                    <li class="nav-header">Sidebar</li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li class="nav-header">Sidebar</li>
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