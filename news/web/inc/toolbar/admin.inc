
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
					<span class=""><a href="/">Home</a></span> |
					<span class=""><a href="/post/add.php">Add Post+</a></span> |
					<span class=""><a href="/admin/dashboard.php">Dashboard </a></span> |
					<span class=""><a href="/user/logout.php">logout</a> (<?php echo $gSessionUser->userName; ?>) </span>
				</div>
				
		</div>

	</div>
</div>

