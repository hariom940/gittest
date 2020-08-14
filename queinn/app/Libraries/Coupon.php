<?php namespace App\Libraries;

use DB;
use Session;
use Anam\Phpcart\Cart;

class Coupon {
	
	 public function __construct() {
    	$this->cart =  new Cart();
	}
	
	public function calculationCoupon($amount, $type, $coupon_code)
    {
      $is_coupon_set = false;
      $get_val = 0;
      
      if($type == 'discount_from_product'){
        $get_val = $this->cart->totalQuantity() * $amount;
      }
      elseif($type == 'percentage_discount_from_product'){
        if(!empty($this->cart->items())){
          foreach($this->cart->items() as $item){
             $get_val +=  $item->quantity * ($item->price * ($amount/100));
          }
        }
      }
      elseif($type == 'discount_from_total_cart'){
        $get_val = $amount;
      }
      elseif($type == 'percentage_discount_from_total_cart'){
        $get_val = $this->cart->getTotal() * ($amount/100);
      }
      
      if($get_val && $get_val > 0 && ($this->cart->getTotal() > $get_val)){
        $get_val = number_format($get_val, 2);
        if(Session::has('applyed_coupon_price')){
          Session::forget('applyed_coupon_price');
          Session::put('applyed_coupon_price', $get_val);
        }
        else{
          Session::put('applyed_coupon_price', $get_val);
        }
        
        if(Session::has('applyed_coupon_code')){
          Session::forget('applyed_coupon_code');
          Session::put('applyed_coupon_code', $coupon_code);
        }
        else{
          Session::put('applyed_coupon_code', $coupon_code);
        }
      }
      else{
        $this->remove_coupon();
      }
      
      if(Session::has('applyed_coupon_price') && Session::has('applyed_coupon_code')){
        $is_coupon_set = true;
      }
      
      return $is_coupon_set;
    }
    
    public function couponPrice(){
      $price = 0;
      
      if(Session::has('applyed_coupon_price')){
        $price = Session::get('applyed_coupon_price');
      }
      
      return $price;
    }
    
    public function couponCode(){
      $code = '';
      
      if(Session::has('applyed_coupon_code')){
        $code = Session::get('applyed_coupon_code');
      }
      
      return $code;
    }
    
    public function is_coupon_applyed(){
      if(Session::has('applyed_coupon_price') && Session::has('applyed_coupon_code')){
        return true;
      }
    }

    public function points_discount($amount,$pointstoredeem){
        if($amount > 0){
            if(Session::has('redeem_points_amount')){
              Session::forget('redeem_points_amount');
              Session::forget('redeem_points');
              Session::put('redeem_points_amount', $amount);
              Session::put('redeem_points',$pointstoredeem);
            }
            else{
              Session::put('redeem_points_amount', $amount);
              Session::put('redeem_points',$pointstoredeem);
            }
            return $amount;
        }
    }

    public function is_redeem_points(){
      if(Session::has('redeem_points_amount') && Session::has('redeem_points')){
        return true;
      }
    }

    public function redeeemPointsAmount(){
      $price = 0;
      if(Session::has('redeem_points_amount')){
        $price = Session::get('redeem_points_amount');
      }
      return $price;
    }

    public function remove_redeem_points(){
      if(Session::has('redeem_points_amount') && Session::has('redeem_points')){
        Session::forget('redeem_points_amount');
        Session::forget('redeem_points');
        return true;
      }
    }
    
    public function remove_coupon(){
      if(Session::has('applyed_coupon_price') && Session::has('applyed_coupon_code')){
        Session::forget('applyed_coupon_price');
        Session::forget('applyed_coupon_code');
        return true;
      }
    }
	
	public function getCartTotal()
    {
      if($this->is_coupon_applyed()){
		    return ($this->getSubTotalAndTax() + $this->getShippingCost()) - $this->couponPrice();
		  	//return ($this->getSubTotalAndTax() ) - $this->couponPrice();
        	//return $this->cart->getTotal() - $this->couponPrice();
      }
      else if($this->is_redeem_points()){
        return ($this->getSubTotalAndTax() + $this->getShippingCost()) - $this->redeeemPointsAmount();
      }
      else{
		  return ($this->getSubTotalAndTax() + $this->getShippingCost()) + $this->couponPrice() + $this->redeeemPointsAmount();
				//return ($this->getSubTotalAndTax() ) + $this->couponPrice();
        //return $this->cart->getTotal() + $this->couponPrice();
      }
    }
	
	public function getSubTotalAndTax()
    {
      return $this->cart->getTotal() + $this->getTax();
    }
	
	public function getTax()
    {
      $taxRate = 0;
      $state = Session::has('calc_shipping_state') ? Session::get('calc_shipping_state') : '';
      if($state == 'NJ'){
        $tax = DB::table('tax')->where('id', 1)->first();
        if($tax->tax_rate > 0){
          $taxRate = $this->cart->getTotal() * ($tax->tax_rate / 100.0); 
        }
      }
      return number_format($taxRate, 2);
    }
	
	public function getShippingCost()
    {
      $shipping_cost = 0;
     
      if(Session::has('shipping_type') && (Session::get('shipping_type') == 'ups' || Session::get('shipping_type') == 'usps'))
      {
        $shipping_cost = Session::get('shipping_price');
      }
	  if(Session::has('shipping_type') && (Session::get('shipping_type') == 'local_delivery'))
      {
        $shipping_cost = 0;
      }
      
      return $shipping_cost;
    }
}
