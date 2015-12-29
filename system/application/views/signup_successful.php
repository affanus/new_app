<section class="section-account">  

    <div class="card contain-sm style-accent ">
        <div class="card-body style-default-bright">
        	<form class="form floating-label form-validate" role="form" action="<?= base_url();?>users/account_verify" method="post" id="userRegistration" enctype="multipart/form-data">
            	<h1 class="page-header" style="font-size: 24px; margin-top: 0;">Verify Account</h1>
                    <div class="row">
    				<div class="col-xs-12">
                    <h1>Congrats!</h1>
                    <p>Your account has not been created.To activite your account please check your email</p>
                    Please enter you Account code here to activite your account 
                        </div>
                        </div>
                <div class="row">
                	<div class="col-sm-4">
                    	<div class="form-group">
                            <input type="text" name="activation_code" id="activation_code" class="form-control">
                            <label for="activation_code" class="control-label">Account Code</label>
                        </div>
                          
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-12">
                		<button type="submit" class="btn ink-reaction btn-primary style-accent">Activate Now</button>
                    </div>    
                </div>
            </form>
        </div>
        
    </div>
</section>