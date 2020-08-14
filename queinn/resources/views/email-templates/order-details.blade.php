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
							<strong style="color:#fff;">Thank you for your order</strong></h3></td>
				        </tr>
				    </table> 
				</td>
			</tr>


			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%;   border-top: 1px solid #e5e5e5;  border-bottom: 1px solid #e5e5e5; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:center; color:#333;">
							{!! $order_msg !!} Your order details are shown below for your reference:
							</h3></td>
				        </tr>
				        <tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:13px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:center; color:#333;">
							Congrats! You have earned <strong>{{ points($order->order_subtotal) }}</strong> points for completing order.
							</h3></td>
				        </tr>

				    
				    </table>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:17px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#557da1;">
							Order #{{$order->id}}
							</h3></td>
				        </tr>
				    </table>    
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table border="0" bordercolor="#cccccc" cellpadding="0" cellspacing="0" style="width: 100%;">
					@if(!empty($orderItems))
						<tr>
					        <td style="font-family: Arial, Helvetica, sans-serif;font-size: 15px; font-weight:600;padding: 5px;border: solid 1px #ccc;">Product</td>
							<td style="font-family: Arial, Helvetica, sans-serif;font-size: 15px; font-weight:600;padding: 5px;border: solid 1px #ccc;">Quantity</td>
							<td style="font-family: Arial, Helvetica, sans-serif;font-size: 15px; font-weight:600;padding: 5px;border: solid 1px #ccc;">Price</td>
				        </tr>
						@php $sum = 0; $total = 0; $a=1; @endphp
                        @foreach($orderItems as $items)
							<tr>
						        <td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">
						        	{{ fieldtofield('products', 'id', $items->product_id, 'name') }}
						        </td>
								<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">{{ $items->product_quantity }}</td>
								<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">{{ '$'.$items->product_price }}</td>
					        </tr>
					        	@php
		                            $total = $items->product_quantity * $items->product_price;
		                            $sum += $total;
	                          	@endphp
	                         @php $a++; @endphp  	
					    @endforeach    
				   
					    <tr>
					        <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;font-weight:600;border: solid 1px #ccc;">Subtotal:</td>		
							<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">{{ '$'.number_format($sum,2) }}</td>
				        </tr>
				        <tr>
					        <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;font-weight:600;border: solid 1px #ccc;">Points Redemption:</td>		
							<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">{{ '-$'.number_format($order->points_redeemed_amount,2) }}</td>
				        </tr>
						<tr>
					        <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;font-weight:600;border: solid 1px #ccc;">Shipping Charges:</td>		
							<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">{{ '$'.number_format($order->order_shipping,2).' via '}} {!! $order->order_shipping_service !!} </td>
				        </tr>
						
						<tr>
					        <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;font-weight:600;border: solid 1px #ccc;">Tax:</td>		
							<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">{{ '$'.number_format($order->order_tax,2) }}</td>
				        </tr>
						@if($order->coupon_code != '')
                          <tr>
                            <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;font-weight:600;border: solid 1px #ccc;">
                            	Discount(<b>{{ $order->coupon_code }}</b>):</td>	
                            <td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">
                            	{{ '$'.number_format($order->discount_amount,2) }}
                            </td>
                          </tr>
                        @endif
						<tr>
					        <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;font-weight:600;border: solid 1px #ccc;">Payment Method:</td>		
							<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">
								{{ ($order->payment_options == 'paypal') ? 'Paypal' : 'Credit Card Payment' }}
							</td>
				        </tr>
						
						<tr>
					        <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size:15px; font-weight:600;padding: 5px;border: solid 1px #ccc;">Total:</td>		
							<td style="font-family: Arial, Helvetica, sans-serif; font-size:15px;padding: 5px;border: solid 1px #ccc;">{{ '$'.number_format($order->order_total,2) }}</td>
				        </tr>
				    @endif
				    </table>    
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:18px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#557da1;">
							Order Notes:
							</h3></td>
						<td style="margin:0px; padding:5px 0px;"><h3 style="font-size:18px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#557da1;">
							{!! $order->order_notes !!}
							</h3></td>	
				        </tr>
				    </table>  
				</td>
			</tr>


			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:18px; margin:0px; padding:5px 0 5px 0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#557da1;">
							Your details
							</h3></td>
				        </tr>
				    </table>  
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:0px;"><h3 style="font-size:15px; margin:0px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
							<strong>Email:</strong> <a href="mailto:{!! $order->email_address !!}">{!! $order->email_address !!}</a>
							</h3></td>
				        </tr>
				    </table>  
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:15px; margin:0px; padding:0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; font-weight:normal;">
							<strong>Tel:</strong> {{ $order->phone }}
							</h3></td>
				        </tr>
				    </table>  
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<table border="0" bordercolor="#cccccc" cellpadding="0" cellspacing="0" style="width: 100%;">    	
					    <tr>
				        <td style="font-size:17px;font-family: Arial, Helvetica, sans-serif; font-weight:600;padding: 5px; border:solid 1px #ccc; color:#557da1;">Billing address</td>		
						<td style="font-size:17px;font-family: Arial, Helvetica, sans-serif; font-weight:600;padding: 5px; border:solid 1px #ccc;color:#557da1;">Shipping address</td>
				        </tr>
				        @php
	                        $countries = getCountries();
	                        $states    = getStates($order->country);
	                    @endphp		
						<tr>
					        <td style="font-size:15px;font-family: Arial, Helvetica, sans-serif;padding: 5px;border:solid 1px #ccc;">
											{{$order->first_name.' '.$order->last_name}}<br/>
											{!! $order->street_address!='' ? $order->street_address.',' : '' !!}
                                    {!! $order->apartment!='' ? $order->apartment.',' : '' !!}<br/>
                                    {!! $order->town!='' ? $order->town.',' : '' !!} {!! $order->state!='' ? $order->state : '' !!} {!! $order->postcode!='' ? $order->postcode : '' !!}
                                     <br/>
                                     {!! $order->country!='' ? $countries[$order->country] : '' !!} 
							</td>		
							<td style="font-size:15px;font-family: Arial, Helvetica, sans-serif;padding: 5px;border:solid 1px #ccc;">
									@php
                                    	$countries = getCountries();
                                    	$states    = getStates($order->country);
                                	@endphp
									@if($order->ship_to_different_address == 1)
									{{$order->shipping_first_name.' '.$order->shipping_last_name}}<br/>
									{!! $order->shipping_street_address!='' ? $order->shipping_street_address.',' : '' !!}
                                    {!! $order->shipping_apartment!='' ? $order->shipping_apartment.',' : '' !!} <br/>
                                    {!! $order->shipping_town!='' ? $order->shipping_town.',' : '' !!} {!! $order->shipping_state!='' ? $order->shipping_state : '' !!} {!! $order->shipping_postcode!='' ? $order->shipping_postcode : '' !!}
                                     <br/>
                                    {!! $order->shipping_country!='' ? $countries[$order->shipping_country] : '' !!}
									@else
										{{$order->first_name.' '.$order->last_name}}<br/>
											{!! $order->street_address!='' ? $order->street_address.',' : '' !!}
                                    {!! $order->apartment!='' ? $order->apartment.',' : '' !!}<br/>
                                    {!! $order->town!='' ? $order->town.',' : '' !!} {!! $order->state!='' ? $order->state : '' !!} {!! $order->postcode!='' ? $order->postcode : '' !!}
                                     <br/>
                                     {!! $order->country!='' ? $countries[$order->country] : '' !!}  
									@endif
							</td>
				        </tr>
				    </table>   
				</td>
			</tr>
			@if($new_order != '')
			<tr>
				<td colspan="2">
					<table border="0" style="width: 100%; height:40px;">
				    	<tr>
				        <td style="margin:0px; padding:5px 0px;"><h3 style="font-size:14px; margin:0px; padding:0; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000; text-align:center;font-weight: normal;">
							{!! $new_order !!}
							</h3></td>
				        </tr>
				    </table>  
				</td>
			</tr>
			@endif
		</table>
	</div>
</div>