<?php
	
	//La page principale du site
	include "include/mainHeader.php";
?>
	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li class="active">Connexion</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">Connexion</h1>
				</header>
				
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">Connectez-vous à votre espace personnel</h3>
							<p class="text-center text-muted">Connectez-vous pour avoir accès aux services de la bibliothèque. Cela prendra quelques instants.</p>
							<hr>
							
							<form action="login.php" method="POST">
								<div class="top-margin">
									<label>Login<span class="text-danger">*</span></label>
									<input name="username" type="text" class="form-control">
								</div>
								<div class="top-margin">
									<label>Password <span class="text-danger">*</span></label>
									<input name="password" type="password" class="form-control">
								</div>

								<hr>

								<div class="row">
									<div class="col-lg-4 text-right">
										<button name="sbm" class="btn btn-action" type="submit">Sign in</button>
										
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>
				
			</article>
			<!-- /Article -->

		</div>
	</div>	<!-- /container -->
	

<?php	
	include "include/footer.php";
?>
