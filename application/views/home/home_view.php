<div id="wrapper">
        <div id="wrappertop"></div>

        <div id="wrappermiddle">

            <h2>Login</h2>
            <form >
                <div id="username_input">

                    <div id="username_inputleft"></div>

                    <div id="username_inputmiddle">
                    <form>
                        <input type="text" name="login" id="url" value="E-mail Address" onclick="this.value = ''">
                        <img id="url_user" src="<?=base_url()?>/public/img/mailicon.png" alt="">
                    </form>
                    </div>

                    <div id="username_inputright"></div>

                </div>

                <div id="password_input">

                    <div id="password_inputleft"></div>

                    <div id="password_inputmiddle">
                    <form>
                        <input type="password" name="password" id="url" value="Password" onclick="this.value = ''">
                        <img id="url_password" src="<?=base_url()?>/public/img/passicon.png" alt="">
                    </form>
                    </div>

                    <div id="password_inputright"></div>

                </div>

                <div id="submit">
                    <form method="post" action="<?=site_url('api/login')?>">
                        <input type="image" src="<?=base_url()?>/public/img/submit_hover.png" id="Login" value="Sign In">
                    </form>
                </div>

            </form>
            <div id="links_left">

            <a href="#">Forgot your Password?</a>

            </div>

            

        </div>

        <div id="wrapperbottom"></div>
        
    </div>