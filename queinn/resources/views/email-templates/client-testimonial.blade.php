<style>
body{margin:0px;}
</style>
<div style="width:100%; float:left; background:#efedee; padding:10px 0px; margin:0px; outline:none;">
	<div style="width:780px; margin:0 auto; padding:10px; background:#fff; border:0px;">
		<table cellpadding="0" border="0" cellspacing="0" align="center" style="width:780px; margin: 0px auto; padding-top:20px;  border-top:4px #6cbfce solid; border-right:0px; border-left:0px; border-bottom:0px;  border-spacing:0px !important;">
			<tr>
				<td style="width: 700px; padding-bottom:10px; float:left; border:0px; text-align:center;">
					<a href="{!! URL::to('/')!!}" target="_blank" title="">
						<img alt="" src="{{URL::asset($wl_logo) }}" width="200" height="72" style="border:0px; width:200px; height:72px;" />
					</a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table border="0" bgcolor="#0ca6cb" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:14px; text-transform:uppercase; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:center; color:#333;">
							<strong style="color:#fff;">Request for Feedback</strong></h3></td>
				        </tr>
				    </table> 
				</td>
			</tr>


			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%;   border-top: 1px solid #e5e5e5;  border-bottom: 1px solid #e5e5e5; height:40px;">
				    	<tr>
				        	<td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#333;">
										Hello {{ $name }}!
									</h3>
							</td>
				        </tr>

				        <tr>
				        	<td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#333;">
										You are receiving this email because you have placed an order few days ago. We would really appreciate it if you could take a few moments to share your feedback with us. We want to know what we did right so we can keep doing it and any suggestions you may have on how to improve.
									</h3>
							</td>
				        </tr>

				        <tr>
				        	<td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#333;">
										Please <a href="{{url('/testimonials') }}">Click Here</a> to submit your feedback.
									</h3>
							</td>
				        </tr>

				        <tr>
				        	<td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#333;">
										If you choose to submit your feedback using the above link, you will be rewarded with a random amount of points that you can use on a future order.
									</h3>
							</td>
				        </tr>

				        <tr>
				        	<td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#333;">
										Your feedback may used as a featured testimonial on our site so keep that in mind when you place your submission. Pictures and stories of your adventures are welcome.
									</h3>
							</td>
				        </tr>
				    
				    </table>
				</td>
			</tr>
		
			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:15px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:center; color:#27a4b0;">
										Thanks,<br />{{ $mailSignatureName }}
									</h3>
							</td>
						</tr>	
				    </table>  
				</td>
			</tr>
		</table>
	</div>
</div>