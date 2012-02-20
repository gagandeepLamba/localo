<div id="header">
	<div class="navbar">
		<div class="navbar-inner">
		  <div class="container">
			<a class="brand" href="#">3mik.com...</a>


			<ul class="nav">
				<li class="active">
				  <a href="/">Home</a>
				</li>
				<li><a href="/test/ful/single.php">Share</a></li>
				<li><a href="/qa/ask.php">Ask</a></li>
			</ul> <!-- fixed links -->
			
			

			<ul class="nav">
				<li class="divider-vertical"></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello&nbsp;<?php echo $gSessionUser->firstName; ?><b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="/user/dashboard.php">My Account</a></li>
					<li><a href="#">Dummy Link</a></li>
					
					<li class="divider"></li>
					<li><a href="/user/logout.php">Logout</a></li>
				  </ul>
				</li>
		  </ul> <!-- Account links -->
		
			
		  </div>
		</div>
	</div> <!-- navbar -->
</div> <!-- header -->