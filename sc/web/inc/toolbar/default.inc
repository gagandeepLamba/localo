
<div id="header">
	<div class="h-content">
		<div rel="home" id="logo">
				<h3> <a href="/"> <img src="/css/images/logo.png" alt="logo" /> </a> </h3>
		</div>
       <div id="search-top">
				<form method="get" id="searchform" action="<?php echo $_SERVER['REQUEST_URI']; ?>">	
						<input type="text" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" value="Search" class="text" name="s" id="s"> 
						<input type="submit" class="button"  value=" ">
						
				</form>
		</div>
		<div id="hcenter">
				<div id="login">
				 <span class="register"><a href="/">Home</a></span>
				 &nbsp;|&nbsp;
				<span class="register"><a href="/user/login.php">Login</a></span>
				</div>
				
		</div>
		
		
	</div>
</div>
