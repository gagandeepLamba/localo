
<div id="header">
	<div class="h-content">
		<div rel="home" id="logo">
				<h3> <a href="/"> 27main.com </a> </h3>
		</div>

		<div id="search-top">
				<form method="get" id="searchform" action="">	
						<input type="text" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" value="Search" class="text" name="s" id="s"> 
						<input type="image" class="but" src="/css/images/search-btn.png" value=" "> 
				</form>
				
		</div>

		<div id="hcenter">
				<div id="login">
						<span class="register"><a href="/">Home</a></span> |
                        <span class="register"><a href="/user/register.php">Register</a></span> |
						<span class="register"><a href="/post/list.php">All Posts</a></span> |
                        <span class="register"><a href="/post/add.php">Add Post</a></span> |
                        <span class="register"><a href="/link/add.php">Add Link</a></span>
                        
                        <?php
                            use com\indigloo\auth\User as Auth ;
                            if(Auth::isStaff()){
                               echo '<span class="register"><a href="/user/logout.php">logout</a></span>' ;
                            }
                        ?>

                        
				</div>
				
		</div>

	</div>
</div>

