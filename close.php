<?php 
add_filter('init', function(){
	if (!is_user_logged_in() && $_SERVER[REQUEST_URI] !== '/login' && $_SERVER[REQUEST_URI] !== '/login/' && $_SERVER[REQUEST_URI]  !== '/login/?loggedout=true') { ?>
		<style>
		@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@400;500&display=swap');
		</style>
		<div style="font-family: 'Prompt', sans-serif; position: absolute;	top: 50%;	left: 50%;transform: translate(-50%, -50%)">
			<center style="font-size: 30px">
			<img src="<?php echo content_url('uploads/2021/01/logo.png') ?>" alt="">
			<p style="margin-bottom: 0">ปิดปรับปรุงและอัพเดทระบบชั่วคราว</p>
			<small>System Maintenance and update</small>
			</center>
		</div>
		<?php exit();
	}
	
});