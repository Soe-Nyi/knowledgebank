<fieldset>
    <!-- Form Name -->
    <legend>Add new admin user</legend>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label">Username</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  type="text" name="username" autocomplete="off" placeholder="Username" class="form-control" value="" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- Text input-->
    
    <!-- Email input -->
    <div class="form-group">
        <label class="col-md-4 control-label">Email</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input  type="text" name="email" autocomplete="off" placeholder="Email or Phone Number" class="form-control" value="" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- Email input-->
    <div class="form-group">
        <label class="col-md-4 control-label" >Password</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="password" autocomplete="off" placeholder="Password " class="form-control" required="" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- radio checks -->
    <div class="form-group">
        <label class="col-md-4 control-label">User type</label>
        <div class="col-md-4">
            <div class="radio">
                <label>
                    <?php //echo $admin_account['admin_type'] ?>
                    <input type="radio" name="admin_type" value="super" required=""/> Super admin
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="admin_type" value="admin" required=""/> Admin
                </label>
            </div>
        </div>
    </div>
    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>