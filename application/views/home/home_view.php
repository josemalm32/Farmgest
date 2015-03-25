<!-- start:container -->
<div class="container">
    <div class="row">
        <div class="login-card">   
            <form id="login_form" method="post" action="<?=site_url('api/login')?>">
                <h3>Login</h3>
                <div>
                    <label>Login</label>
                    <div>
                        <input type="text" name="login" class="input-xlarge" />
                    </div>
                </div>
                <div>
                    <label>Password</label>
                    <div>
                        <input type="password" name="password" class="input-xlarge" />
                    </div>
                </div>
                <div>
                    <div>
                        <input type="submit" value="Login" class="btn btn-primary" />
                        <!-- <a class="btn" href="<?=site_url('home/register')?>">Register</a> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


