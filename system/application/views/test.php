<script>
var currentQ=1;
$(function(){
	$('.startTEST').click(function(){
		$('.instructons').fadeOut();
		$('.test').fadeIn();
		$('.digits').countdown({
			image: "<?=base_url();?>img/digits-min.png",
			format: 'sss',
    		startTime: "60"
		});
	});
	
});	 
</script>
<?
	$row_mcq = $mcq->row(); 	
?>
<div class="container-fluid">
  <div class="row">
  	<div class="instructons">
        <h4>Test Instructions</h4>
        <p>You will be asked 15 questions. Each question have an autotimer of 1 minute and next question should appear after 1 minute. </p>
        <button type="button" class="btn btn-primary startTEST">Start Test</button>
    </div>
    <div class="test" style=" display:none">
    	<div class="row">
    		<div class="col-md-8"><h1>Question 1 of 15</h1></div>
  			<div class="col-md-4"><div class="digits"></div></div>
        </div>    
        <div class="row">
        	<h3><?=$row_mcq->question?> ?</h3>
            <div class="radio">
              <label>
                <input type="radio" name="asn" id="optionsRadios1" value="1">
                <?=$row_mcq->opt1?>
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="asn" id="optionsRadios2" value="2">
                <?=$row_mcq->opt2?>
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="asn" id="optionsRadios3" value="3">
                <?=$row_mcq->opt3?>
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="asn" id="optionsRadios4" value="4">
                <?=$row_mcq->opt4?>
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
    </div>
  </div>
</div>