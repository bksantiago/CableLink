<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand">Cable Link</a>
            <div class="nav-collapse collapse">
                <ul class="nav header-icon">
                    <li><a href="home"><i class="icon-home icon-white"></i> Home</a></li>
                    <?php if ($user->id == 1) { ?>
                        <li><a href="#about"><i class="icon-folder-open icon-white"></i> Accounts</a></li>
                        <li><a href="Customers"><i class="icon-user icon-white"></i> Customers</a></li>
                        <li><a href="Agents"><i class="icon-eye-open icon-white"></i> Agents</a></li>
                    <?php } else { ?>
                        <li><a href="Tickets"><i class="icon-list-alt icon-white"></i> Tickets</a></li>
                        <?php if ($user->getAssignedCount() > 0) { ?>
                            <li><a href="Tickets?n=<?php echo $user->getAssignedCount(); ?>">
                                    <i class="icon-info-sign icon-white"></i> Assigned Tickets
                                    <div class="icon-notif"><?php echo $user->getAssignedCount(); ?></div></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <ul class="nav pull-right">

                    <li class="dropdown">
                        <a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            Welcome | <?php echo $user->firstName . " ( " . $user->positionTb->code . " )"; 
                            if(!file_exists('./uploads/' . $user->id . '.jpg')){
                                $imgUrl = "images/profile/blank_male.gif";
                            } else {
                                $imgUrl = "./uploads/" . $user->id . ".jpg";
                            }
                            ?>
                            <img src="<?php echo $imgUrl; ?>" style="padding: 0 5px; height: 17px;"/>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="profile?id=<?php echo $user->id; ?>">My Profile</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">My Account</li>
                            <li><a href="#">Change Password</a></li>
                            <li><a href="Account/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="dynamic-modal" class="modal hide fade transparent-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h3 id="dynamicModalLabel">Cable Link</h3>
    </div>
    <div class="modal-body" id="dynamic-modal-body">

    </div>
</div>

<div id="confirm-modal" class="modal hide fade transparent-box2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h3 id="myModalLabel">Cable Link</h3>
    </div>
    <div class="modal-body">
        <p>Confirm Submission !</p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="btn-confirm">OK</button>
        <button class="btn" data-dismiss="modal">Cancel</button>
    </div>
</div>

