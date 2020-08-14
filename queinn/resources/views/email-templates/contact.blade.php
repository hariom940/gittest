<style>
body{margin:0px;}
</style>
<div style="width:100%; float:left; background:#efedee; padding:10px 0px; margin:0px; outline:none;">
	<div style="width:780px; margin:0 auto; padding:10px; background:#fff; border:0px;">
		<table cellpadding="0" border="0" cellspacing="0" align="center" style="width:780px; margin: 0px auto; padding-top:20px;  border-top:4px #ae0701 solid; border-right:0px; border-left:0px; border-bottom:0px;  border-spacing:0px !important;">
			<tr>
				<td style="width: 700px; padding-bottom:10px; float:left; border:0px; text-align:center;">
					<a href="{!! URL::to('/')!!}" target="_blank" title="">
						<img alt="" src="{{URL::asset($wl_logo) }}" width="150" height="40" style="border:0px; width:150px; height:40px;" />
					</a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table border="0" bgcolor="#ae0701" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:14px; text-transform:uppercase; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:center; color:#333;">
							<strong style="color:#fff;">Contact Us</strong></h3></td>
				        </tr>
				    </table> 
				</td>
			</tr>


			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%;   border-top: 1px solid #e5e5e5; height:40px;">
				    	<tr>
				        	<td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#333;">
										{{ $title }},
									</h3>
							</td>
				        </tr>

				        <tr>
				        	<td style="margin:0px; padding:5px 0px;">
				        			<h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#333;">
										A new contact request has been received which is as follows:
									</h3>
							</td>
				        </tr>

				    </table>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%;   border-top: 1px solid #e5e5e5;  border-bottom: 1px solid #e5e5e5; height:40px;">
						<tr>
							<td style="margin:0px; padding:5px 0px; width:10%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>Name</strong>
									</h3>
							</td>
							
							<td style="width:15%;font-size:12px;font-family:Arial, Helvetica, sans-serif;color:#000; font-weight:bold; vertical-align:middle; text-align:center;">:</td>
							
							<td style="padding:5px 0px;width:75%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>{{ $name }}</strong>
									</h3>
							</td>
						</tr>

						<tr>
							<td style="margin:0px; padding:5px 0px;width:10%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>Email</strong>
									</h3>
							</td>
							<td style="width:15%;font-size:12px;font-family:Arial, Helvetica, sans-serif;color:#000; font-weight:bold; vertical-align:middle;text-align:center;">:</td>
							<td style="padding:5px 0px;width:75%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>{{ $email }}</strong>
									</h3>
							</td>
						</tr>

						<tr>
							<td style="margin:0px; padding:5px 0px;width:10%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>Subject</strong>
									</h3>
							</td>
							
							<td style="width:15%;font-size:12px;font-family:Arial, Helvetica, sans-serif;color:#000; font-weight:bold; vertical-align:middle;text-align:center;">:</td>
							
							<td style="padding:5px 0px;width:75%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>{{ $subject }}</strong>
									</h3>
							</td>
						</tr>

						<tr>
							<td style="margin:0px; padding:5px 0px;width:10%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>Message</strong>
									</h3>
							</td>
							
							<td style="width:15%;font-size:12px;font-family:Arial, Helvetica, sans-serif;color:#000; font-weight:bold; vertical-align:middle;text-align:center;">:</td>
							
							<td style="padding:5px 0px;width:75%;">
									<h3 style="font-size:12px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
										<strong>{!! $content !!}</strong>
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
				        			<h3 style="font-size:15px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:center; color:#ae0701;">
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