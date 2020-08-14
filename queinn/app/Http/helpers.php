<?php

use App\AdminUser;
use App\BlogComments;
use App\Pages;
use App\Settings;
use App\Categories;
use App\WebSettings;
use App\Blogs;
use App\BlogCategories;
use App\Libraries\Coupon;
use App\BlogTags;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

if (! function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        return \Illuminate\Support\Str::words(strip_tags($value), $words, $end);
    }

    function characters($value, $chars = 160)
    {
        $tail = max(0, $chars-10);
        $trunk = substr(strip_tags($value), 0, $tail);
        $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^~', '', strrev(substr($value, $tail, $chars-$tail))));
        return $trunk;
    }
	
	function time_elapsed_string($datetime, $full = false) {
			$now = new DateTime;
			$ago = new DateTime($datetime);
			$diff = $now->diff($ago);
		
			$diff->w = floor($diff->d / 7);
			$diff->d -= $diff->w * 7;
		
			$string = array(
				'y' => 'year',
				'm' => 'month',
				'w' => 'week',
				'd' => 'day',
				'h' => 'hour',
				'i' => 'minute',
				's' => 'second',
			);
			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				} else {
					unset($string[$k]);
				}
			}
		
			if (!$full) $string = array_slice($string, 0, 1);
			return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}


if (! function_exists('stock_status')) {
	function stock_status($product_id){
		$product_attr = ProductAttributes::where('product_id',$product_id)->where('stock_status','instock')->get();
		if(!empty($product_attr)){
			$total_stock = 0;
			foreach($product_attr as $attr){
				$total_stock += $attr->available_qty;
			}
		}
		
		if($total_stock>0 && $total_stock<11){
			return "Just ".$total_stock." left";
		}
		else if($total_stock>0 && $total_stock>11){
			return "In stock";
		}else{
			return "Out of stock";
		}
	}
}

if (! function_exists('page')) {
	function page($slug){
	$page = Pages::where('slug',$slug)->first(['description','title','page_title', 'page_keyword', 'page_description']);
		if($page->page_title == '' && $page->page_keyword == '' && $page->page_description == '' ){
			$page = Settings::where('id',1)->first(['page_title', 'page_keyword', 'page_description']);
		}
	return $page;	
	}
}

if (! function_exists('logo_with_title')) {
	function logo_with_title(){
	$logo_title = Settings::where('id',1)->first(['site_title', 'logo', 'website','favicon']);
	return $logo_title;	
	}
}

if (! function_exists('settings')) {
	function settings(){
		$settings = Settings::where('id',1)->first();
		return $settings;	
	}
}

if (! function_exists('notification')) {
	function notification(){
		$notification = Notification::where('id',1)->first();
		return $notification;	
	}
}

if (! function_exists('web_settings')) {
	function web_settings(){
		$web_settings = WebSettings::where('id',1)->first();
		return $web_settings;	
	}
}

if (! function_exists('footer_menu')) {
	function footer_menu(){
		$footer_menu = Pages::where('footer_menu',1)->orderBy('sequence')->get();
		return $footer_menu;	
	}
}


if (! function_exists('fieldtofield')) {
	function fieldtofield($table, $column, $value, $getColumn){
			$row = DB::table($table)->where($column,'=',$value)->first([$getColumn]);
			if(!empty($row)){
				return $row->$getColumn;	
			}else{
				return ;
			}
	}
}

if (! function_exists('selectrow')) {
	function selectrow($table, $column, $value){
			$row = DB::table($table)->where($column,'=',$value)->first();
			if(!empty($row)){
				return $row;	
			}else{
				return ;
			}
	}
}

if (! function_exists('attr_values')) {
	function attr_values($table,$column,$value,$status=''){
			 $attribute_values  = json_decode($status);
			 $product_attrs_values = array();
			 if($attribute_values!=''){
					$product_attrs_values = explode(',', $attribute_values);
			 } 
			 $attributeValues = DB::table($table)->where($column,'=',$value)->get();
			
			 $str = '<div class="col-sm-1"></div> <div class="col-sm-11 attr_values_'.$value.'" style="display:'.($status=='' ? 'none': 'block').'">';
             foreach ($attributeValues as $attr){
                                  $str .= '<input type="checkbox" name="attr[]" class="flat-red" value="'. $attr->id.'" '.(in_array($attr->id,$product_attrs_values) ? 'checked="checked"' : '').'>'."&nbsp; ".$attr->attribute_value .'&nbsp;&nbsp;&nbsp;&nbsp;';
			}
           	$str .= '</div>';
			return $str;	
	}
}	

if (! function_exists('showOrderStatus')) {
	function showOrderStatus($value){
			$order_status = array(1=>'Pending', 2=>'Failed', 3=>'Processing', 4=>'Completed', 5=>'On-Hold', 6=>'Cancelled',7=>'Refunded');
			if($value > 0 && array_key_exists($value, $order_status)){
				return $order_status[$value];
			}else{
				return $order_status[2];
			}
	}
}

if( ! function_exists('send_smtp_email') ){
	function send_smtp_email($to='',$subject='',$messagebody='',$template='',$header=''){
		$options = Settings::where('id',1)->first(['website','logo','site_title','from_name','from_email','smtp_host','smtp_port','smtp_driver','smtp_username','smtp_password','smtp_encryption']);
		
        $messagebody['domain'] 		= ($options->website != '' )? $options->website : '';
        $messagebody['wl_logo'] 	= ($options->logo!='')?$options->logo:env('APP_LOGO');
        $messagebody['productName'] = ($options->site_title!='')?$options->site_title:env('APP_NAME');
        $messagebody['mailSignatureName'] = ($options->site_title!='')?$options->site_title:env('MAIL_SINGNATURE_NAME');
        if(array_key_exists('from_name', $header) && array_key_exists('from_email', $header) ){
        	$from_name 	= (isset($header['from_name']) && $header['from_name']!='')?$header['from_name']:env('MAIL_FROM_NAME');
			$from_email = (isset($header['from_email']) && $header['from_email']!='')?$header['from_email']:env('ADMIN_MAIL');
        }else{
        	$from_name 	= (!empty($options->from_name))?$options->from_name:env('MAIL_FROM_NAME');
			$from_email = (!empty($options->from_email))?$options->from_email:env('ADMIN_MAIL');
        }

			
		$ccemail 	= (isset($header['ccemail']) && $header['ccemail']!='')?$header['ccemail']:'';
		$bccemail 	= (isset($header['bccemail']) && $header['bccemail']!='')?$header['bccemail']:'';	
		$host 		= ($options->smtp_host!='')?$options->smtp_host:env('MAIL_HOST');
		$port 		= ($options->smtp_port!='')?$options->smtp_port:env('MAIL_PORT');
		$driver 	= ($options->smtp_driver!='')?$options->smtp_driver:env('MAIL_DRIVER');
		$username 	= ($options->smtp_username!='')?$options->smtp_username:env('MAIL_USERNAME');
		$password 	= ($options->smtp_password!='')?$options->smtp_password:env('MAIL_PASSWORD');
		$encryption = ($options->smtp_encryption!='')?$options->smtp_encryption:env('MAIL_ENCRYPTION');
		
        Config::set('mail.driver', $driver);
        Config::set('mail.host', $host);
        Config::set('mail.port', $port);
        Config::set('mail.encryption', $encryption);
        Config::set('mail.username', $username);
        Config::set('mail.password', $password);
				 
        return @Mail::send($template, $messagebody, function ($m) use ($to, $subject, $from_email,$from_name,$ccemail,$bccemail)
        {	
            $m->from($from_email, $from_name);
            $m->subject($subject);
            $m->to($to);
			if($ccemail!='')
            	$m->cc($ccemail);
            if($bccemail!='')
				$m->bcc($bccemail);
			$m->replyTo($from_email, $from_name);
        });
	}
}

if( ! function_exists('van_types') ){
	function van_types(){
		return ProductTypes::all();
	}
}

if( ! function_exists('product_categories') ){
	function product_categories(){
		return Categories::all();
	}
}

if( ! function_exists('articles_categories') ){
	function articles_categories(){
		return BlogCategories::where('visible_status', 1)->get();
	}
}

if( ! function_exists('articles_categories_ar') ){
    function articles_categories_ar(){
        return BlogCategories::where('visible_status', 1)->get()->toArray();
    }
}

if( ! function_exists('articles') ){
	function articles(){
		return Blogs::where('visibility', 1)->orderByRaw('RAND()')->take(5)->get();
	}
}

if( ! function_exists('articlesTotal') ){
    function articlesTotal(){
        return Blogs::where('visibility', 1)->get();
    }
}

if( ! function_exists('latestArticles') ){
    function latestArticles(){
        return Blogs::where('visibility', 1)->orderByDesc('created_at')->take(6)->get();
    }
}


if( ! function_exists('comment_count') ){
    function comment_count(){
        $blogs = Blogs::where('visibility', 1)->orderByDesc('created_at')->take(6)->get();
        $comment_count = array();
        foreach ($blogs as $blog){
            $count = BlogComments::where('blog_id', $blog->id)->count();
            array_push($comment_count, $count);
        }
        return $comment_count;
    }
}

if( ! function_exists('getCartTotal') ){
	function getCartTotal(){
		$cartcoupon = new Coupon();
		return $cartcoupon->getCartTotal();
	}
}

if( ! function_exists('getTax') ){
	function getTax(){
		$cartcoupon = new Coupon();
		return $cartcoupon->getTax();
	}
}

if( ! function_exists('getCountries') ){
	function getCountries(){
		return array(
					'AF' => 'Afghanistan',
					'AX' => '&#197;land Islands',
					'AL' => 'Albania',
					'DZ' => 'Algeria',
					'AS' => 'American Samoa',
					'AD' => 'Andorra',
					'AO' => 'Angola',
					'AI' => 'Anguilla',
					'AQ' => 'Antarctica',
					'AG' => 'Antigua and Barbuda',
					'AR' => 'Argentina',
					'AM' => 'Armenia',
					'AW' => 'Aruba',
					'AU' => 'Australia',
					'AT' => 'Austria',
					'AZ' => 'Azerbaijan',
					'BS' => 'Bahamas',
					'BH' => 'Bahrain',
					'BD' => 'Bangladesh',
					'BB' => 'Barbados',
					'BY' => 'Belarus',
					'BE' => 'Belgium',
					'PW' => 'Belau',
					'BZ' => 'Belize',
					'BJ' => 'Benin',
					'BM' => 'Bermuda',
					'BT' => 'Bhutan',
					'BO' => 'Bolivia',
					'BQ' => 'Bonaire, Saint Eustatius and Saba',
					'BA' => 'Bosnia and Herzegovina',
					'BW' => 'Botswana',
					'BV' => 'Bouvet Island',
					'BR' => 'Brazil',
					'IO' => 'British Indian Ocean Territory',
					'VG' => 'British Virgin Islands',
					'BN' => 'Brunei',
					'BG' => 'Bulgaria',
					'BF' => 'Burkina Faso',
					'BI' => 'Burundi',
					'KH' => 'Cambodia',
					'CM' => 'Cameroon',
					'CA' => 'Canada',
					'CV' => 'Cape Verde',
					'KY' => 'Cayman Islands',
					'CF' => 'Central African Republic',
					'TD' => 'Chad',
					'CL' => 'Chile',
					'CN' => 'China',
					'CX' => 'Christmas Island',
					'CC' => 'Cocos (Keeling) Islands',
					'CO' => 'Colombia',
					'KM' => 'Comoros',
					'CG' => 'Congo (Brazzaville)',
					'CD' => 'Congo (Kinshasa)',
					'CK' => 'Cook Islands',
					'CR' => 'Costa Rica',
					'HR' => 'Croatia',
					'CU' => 'Cuba',
					'CW' => 'Cura&ccedil;ao',
					'CY' => 'Cyprus',
					'CZ' => 'Czech Republic',
					'DK' => 'Denmark',
					'DJ' => 'Djibouti',
					'DM' => 'Dominica',
					'DO' => 'Dominican Republic',
					'EC' => 'Ecuador',
					'EG' => 'Egypt',
					'SV' => 'El Salvador',
					'GQ' => 'Equatorial Guinea',
					'ER' => 'Eritrea',
					'EE' => 'Estonia',
					'ET' => 'Ethiopia',
					'FK' => 'Falkland Islands',
					'FO' => 'Faroe Islands',
					'FJ' => 'Fiji',
					'FI' => 'Finland',
					'FR' => 'France',
					'GF' => 'French Guiana',
					'PF' => 'French Polynesia',
					'TF' => 'French Southern Territories',
					'GA' => 'Gabon',
					'GM' => 'Gambia',
					'GE' => 'Georgia',
					'DE' => 'Germany',
					'GH' => 'Ghana',
					'GI' => 'Gibraltar',
					'GR' => 'Greece',
					'GL' => 'Greenland',
					'GD' => 'Grenada',
					'GP' => 'Guadeloupe',
					'GU' => 'Guam',
					'GT' => 'Guatemala',
					'GG' => 'Guernsey',
					'GN' => 'Guinea',
					'GW' => 'Guinea-Bissau',
					'GY' => 'Guyana',
					'HT' => 'Haiti',
					'HM' => 'Heard Island and McDonald Islands',
					'HN' => 'Honduras',
					'HK' => 'Hong Kong',
					'HU' => 'Hungary',
					'IS' => 'Iceland',
					'IN' => 'India',
					'ID' => 'Indonesia',
					'IR' => 'Iran',
					'IQ' => 'Iraq',
					'IE' => 'Ireland',
					'IM' => 'Isle of Man',
					'IL' => 'Israel',
					'IT' => 'Italy',
					'CI' => 'Ivory Coast',
					'JM' => 'Jamaica',
					'JP' => 'Japan',
					'JE' => 'Jersey',
					'JO' => 'Jordan',
					'KZ' => 'Kazakhstan',
					'KE' => 'Kenya',
					'KI' => 'Kiribati',
					'KW' => 'Kuwait',
					'KG' => 'Kyrgyzstan',
					'LA' => 'Laos',
					'LV' => 'Latvia',
					'LB' => 'Lebanon',
					'LS' => 'Lesotho',
					'LR' => 'Liberia',
					'LY' => 'Libya',
					'LI' => 'Liechtenstein',
					'LT' => 'Lithuania',
					'LU' => 'Luxembourg',
					'MO' => 'Macao S.A.R., China',
					'MK' => 'Macedonia',
					'MG' => 'Madagascar',
					'MW' => 'Malawi',
					'MY' => 'Malaysia',
					'MV' => 'Maldives',
					'ML' => 'Mali',
					'MT' => 'Malta',
					'MH' => 'Marshall Islands',
					'MQ' => 'Martinique',
					'MR' => 'Mauritania',
					'MU' => 'Mauritius',
					'YT' => 'Mayotte',
					'MX' => 'Mexico',
					'FM' => 'Micronesia',
					'MD' => 'Moldova',
					'MC' => 'Monaco',
					'MN' => 'Mongolia',
					'ME' => 'Montenegro',
					'MS' => 'Montserrat',
					'MA' => 'Morocco',
					'MZ' => 'Mozambique',
					'MM' => 'Myanmar',
					'NA' => 'Namibia',
					'NR' => 'Nauru',
					'NP' => 'Nepal',
					'NL' => 'Netherlands',
					'NC' => 'New Caledonia',
					'NZ' => 'New Zealand',
					'NI' => 'Nicaragua',
					'NE' => 'Niger',
					'NG' => 'Nigeria',
					'NU' => 'Niue',
					'NF' => 'Norfolk Island',
					'MP' => 'Northern Mariana Islands',
					'KP' => 'North Korea',
					'NO' => 'Norway',
					'OM' => 'Oman',
					'PK' => 'Pakistan',
					'PS' => 'Palestinian Territory',
					'PA' => 'Panama',
					'PG' => 'Papua New Guinea',
					'PY' => 'Paraguay',
					'PE' => 'Peru',
					'PH' => 'Philippines',
					'PN' => 'Pitcairn',
					'PL' => 'Poland',
					'PT' => 'Portugal',
					'PR' => 'Puerto Rico',
					'QA' => 'Qatar',
					'RE' => 'Reunion',
					'RO' => 'Romania',
					'RU' => 'Russia',
					'RW' => 'Rwanda',
					'BL' => 'Saint Barth&eacute;lemy',
					'SH' => 'Saint Helena',
					'KN' => 'Saint Kitts and Nevis',
					'LC' => 'Saint Lucia',
					'MF' => 'Saint Martin (French part)',
					'SX' => 'Saint Martin (Dutch part)',
					'PM' => 'Saint Pierre and Miquelon',
					'VC' => 'Saint Vincent and the Grenadines',
					'SM' => 'San Marino',
					'ST' => 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe',
					'SA' => 'Saudi Arabia',
					'SN' => 'Senegal',
					'RS' => 'Serbia',
					'SC' => 'Seychelles',
					'SL' => 'Sierra Leone',
					'SG' => 'Singapore',
					'SK' => 'Slovakia',
					'SI' => 'Slovenia',
					'SB' => 'Solomon Islands',
					'SO' => 'Somalia',
					'ZA' => 'South Africa',
					'GS' => 'South Georgia/Sandwich Islands',
					'KR' => 'South Korea',
					'SS' => 'South Sudan',
					'ES' => 'Spain',
					'LK' => 'Sri Lanka',
					'SD' => 'Sudan',
					'SR' => 'Suriname',
					'SJ' => 'Svalbard and Jan Mayen',
					'SZ' => 'Swaziland',
					'SE' => 'Sweden',
					'CH' => 'Switzerland',
					'SY' => 'Syria',
					'TW' => 'Taiwan',
					'TJ' => 'Tajikistan',
					'TZ' => 'Tanzania',
					'TH' => 'Thailand',
					'TL' => 'Timor-Leste',
					'TG' => 'Togo',
					'TK' => 'Tokelau',
					'TO' => 'Tonga',
					'TT' => 'Trinidad and Tobago',
					'TN' => 'Tunisia',
					'TR' => 'Turkey',
					'TM' => 'Turkmenistan',
					'TC' => 'Turks and Caicos Islands',
					'TV' => 'Tuvalu',
					'UG' => 'Uganda',
					'UA' => 'Ukraine',
					'AE' => 'United Arab Emirates',
					'GB' => 'United Kingdom',
					'US' => 'United States (US)',
					'UM' => 'United States (US) Minor Outlying Islands',
					'VI' => 'United States (US) Virgin Islands',
					'UY' => 'Uruguay',
					'UZ' => 'Uzbekistan',
					'VU' => 'Vanuatu',
					'VA' => 'Vatican',
					'VE' => 'Venezuela',
					'VN' => 'Vietnam',
					'WF' => 'Wallis and Futuna',
					'EH' => 'Western Sahara',
					'WS' => 'Samoa',
					'YE' => 'Yemen',
					'ZM' => 'Zambia',
					'ZW' => 'Zimbabwe',
				);
	}
}

if( ! function_exists('getStates') ){
	function getStates($countryCode){
		$states = array();
		$states['AR'] = array(
								'C' =>  'Ciudad Aut&oacute;noma de Buenos Aires',
								'B' =>  'Buenos Aires',
								'K' =>  'Catamarca',
								'H' =>  'Chaco',
								'U' =>  'Chubut',
								'X' =>  'C&oacute;rdoba',
								'W' =>  'Corrientes',
								'E' =>  'Entre R&iacute;os',
								'P' =>  'Formosa',
								'Y' =>  'Jujuy',
								'L' =>  'La Pampa',
								'F' =>  'La Rioja',
								'M' =>  'Mendoza',
								'N' =>  'Misiones',
								'Q' =>  'Neuqu&eacute;n',
								'R' =>  'R&iacute;o Negro',
								'A' =>  'Salta',
								'J' =>  'San Juan',
								'D' =>  'San Luis',
								'Z' =>  'Santa Cruz',
								'S' =>  'Santa Fe',
								'G' =>  'Santiago del Estero',
								'V' =>  'Tierra del Fuego',
								'T' =>  'Tucum&aacute;n',
							);
			$states['AU'] = array(
								'ACT' =>  'Australian Capital Territory',
								'NSW' =>  'New South Wales',
								'NT'  =>  'Northern Territory',
								'QLD' =>  'Queensland',
								'SA'  =>  'South Australia',
								'TAS' =>  'Tasmania',
								'VIC' =>  'Victoria',
								'WA'  =>  'Western Australia',
							);
			$states['BD'] = array(
								'BAG'  =>  'Bagerhat',
								'BAN'  =>  'Bandarban',
								'BAR'  =>  'Barguna',
								'BARI' =>  'Barisal',
								'BHO'  =>  'Bhola',
								'BOG'  =>  'Bogra',
								'BRA'  =>  'Brahmanbaria',
								'CHA'  =>  'Chandpur',
								'CHI'  =>  'Chittagong',
								'CHU'  =>  'Chuadanga',
								'COM'  =>  'Comilla',
								'COX'  =>  "Cox's Bazar",
								'DHA'  =>  'Dhaka',
								'DIN'  =>  'Dinajpur',
								'FAR'  =>  'Faridpur ',
								'FEN'  =>  'Feni',
								'GAI'  =>  'Gaibandha',
								'GAZI' =>  'Gazipur',
								'GOP'  =>  'Gopalganj',
								'HAB'  =>  'Habiganj',
								'JAM'  =>  'Jamalpur',
								'JES'  =>  'Jessore',
								'JHA'  =>  'Jhalokati',
								'JHE'  =>  'Jhenaidah',
								'JOY'  =>  'Joypurhat',
								'KHA'  =>  'Khagrachhari',
								'KHU'  =>  'Khulna',
								'KIS'  =>  'Kishoreganj',
								'KUR'  =>  'Kurigram',
								'KUS'  =>  'Kushtia',
								'LAK'  =>  'Lakshmipur',
								'LAL'  =>  'Lalmonirhat',
								'MAD'  =>  'Madaripur',
								'MAG'  =>  'Magura',
								'MAN'  =>  'Manikganj ',
								'MEH'  =>  'Meherpur',
								'MOU'  =>  'Moulvibazar',
								'MUN'  =>  'Munshiganj',
								'MYM'  =>  'Mymensingh',
								'NAO'  =>  'Naogaon',
								'NAR'  =>  'Narail',
								'NARG' =>  'Narayanganj',
								'NARD' =>  'Narsingdi',
								'NAT'  =>  'Natore',
								'NAW'  =>  'Nawabganj',
								'NET'  =>  'Netrakona',
								'NIL'  =>  'Nilphamari',
								'NOA'  =>  'Noakhali',
								'PAB'  =>  'Pabna',
								'PAN'  =>  'Panchagarh',
								'PAT'  =>  'Patuakhali',
								'PIR'  =>  'Pirojpur',
								'RAJB' =>  'Rajbari',
								'RAJ'  =>  'Rajshahi',
								'RAN'  =>  'Rangamati',
								'RANP' =>  'Rangpur',
								'SAT'  =>  'Satkhira',
								'SHA'  =>  'Shariatpur',
								'SHE'  =>  'Sherpur',
								'SIR'  =>  'Sirajganj',
								'SUN'  =>  'Sunamganj',
								'SYL'  =>  'Sylhet',
								'TAN'  =>  'Tangail',
								'THA'  =>  'Thakurgaon',
							);
		$states['BG'] = array(
								'BG-01' =>  'Blagoevgrad',
								'BG-02' =>  'Burgas',
								'BG-08' =>  'Dobrich',
								'BG-07' =>  'Gabrovo',
								'BG-26' =>  'Haskovo',
								'BG-09' =>  'Kardzhali',
								'BG-10' =>  'Kyustendil',
								'BG-11' =>  'Lovech',
								'BG-12' =>  'Montana',
								'BG-13' =>  'Pazardzhik',
								'BG-14' =>  'Pernik',
								'BG-15' =>  'Pleven',
								'BG-16' =>  'Plovdiv',
								'BG-17' =>  'Razgrad',
								'BG-18' =>  'Ruse',
								'BG-27' =>  'Shumen',
								'BG-19' =>  'Silistra',
								'BG-20' =>  'Sliven',
								'BG-21' =>  'Smolyan',
								'BG-23' =>  'Sofia',
								'BG-22' =>  'Sofia-Grad',
								'BG-24' =>  'Stara Zagora',
								'BG-25' =>  'Targovishte',
								'BG-03' =>  'Varna',
								'BG-04' =>  'Veliko Tarnovo',
								'BG-05' =>  'Vidin',
								'BG-06' =>  'Vratsa',
								'BG-28' =>  'Yambol',
							);
		$states['BO'] = array(
								'B' =>  'Chuquisaca',
								'H' =>  'Beni',
								'C' =>  'Cochabamba',
								'L' =>  'La Paz',
								'O' =>  'Oruro',
								'N' =>  'Pando',
								'P' =>  'Potosí',
								'S' =>  'Santa Cruz',
								'T' =>  'Tarija',
							);
		$states['BR'] = array(
								'AC' =>  'Acre',
								'AL' =>  'Alagoas',
								'AP' =>  'Amap&aacute;',
								'AM' =>  'Amazonas',
								'BA' =>  'Bahia',
								'CE' =>  'Cear&aacute;',
								'DF' =>  'Distrito Federal',
								'ES' =>  'Esp&iacute;rito Santo',
								'GO' =>  'Goi&aacute;s',
								'MA' =>  'Maranh&atilde;o',
								'MT' =>  'Mato Grosso',
								'MS' =>  'Mato Grosso do Sul',
								'MG' =>  'Minas Gerais',
								'PA' =>  'Par&aacute;',
								'PB' =>  'Para&iacute;ba',
								'PR' =>  'Paran&aacute;',
								'PE' =>  'Pernambuco',
								'PI' =>  'Piau&iacute;',
								'RJ' =>  'Rio de Janeiro',
								'RN' =>  'Rio Grande do Norte',
								'RS' =>  'Rio Grande do Sul',
								'RO' =>  'Rond&ocirc;nia',
								'RR' =>  'Roraima',
								'SC' =>  'Santa Catarina',
								'SP' =>  'S&atilde;o Paulo',
								'SE' =>  'Sergipe',
								'TO' =>  'Tocantins',
							);

		$states['CA'] = array(
								'AB' =>  'Alberta',
								'BC' =>  'British Columbia',
								'MB' =>  'Manitoba',
								'NB' =>  'New Brunswick',
								'NL' =>  'Newfoundland and Labrador',
								'NT' =>  'Northwest Territories',
								'NS' =>  'Nova Scotia',
								'NU' =>  'Nunavut',
								'ON' =>  'Ontario',
								'PE' =>  'Prince Edward Island',
								'QC' =>  'Quebec',
								'SK' =>  'Saskatchewan',
								'YT' =>  'Yukon Territory',
							);
		$states['CN'] = array(
								'CN1'  =>  'Yunnan / &#20113;&#21335;',
								'CN2'  =>  'Beijing / &#21271;&#20140;',
								'CN3'  =>  'Tianjin / &#22825;&#27941;',
								'CN4'  =>  'Hebei / &#27827;&#21271;',
								'CN5'  =>  'Shanxi / &#23665;&#35199;',
								'CN6'  =>  'Inner Mongolia / &#20839;&#33945;&#21476;',
								'CN7'  =>  'Liaoning / &#36797;&#23425;',
								'CN8'  =>  'Jilin / &#21513;&#26519;',
								'CN9'  =>  'Heilongjiang / &#40657;&#40857;&#27743;',
								'CN10' =>  'Shanghai / &#19978;&#28023;',
								'CN11' =>  'Jiangsu / &#27743;&#33487;',
								'CN12' =>  'Zhejiang / &#27993;&#27743;',
								'CN13' =>  'Anhui / &#23433;&#24509;',
								'CN14' =>  'Fujian / &#31119;&#24314;',
								'CN15' =>  'Jiangxi / &#27743;&#35199;',
								'CN16' =>  'Shandong / &#23665;&#19996;',
								'CN17' =>  'Henan / &#27827;&#21335;',
								'CN18' =>  'Hubei / &#28246;&#21271;',
								'CN19' =>  'Hunan / &#28246;&#21335;',
								'CN20' =>  'Guangdong / &#24191;&#19996;',
								'CN21' =>  'Guangxi Zhuang / &#24191;&#35199;&#22766;&#26063;',
								'CN22' =>  'Hainan / &#28023;&#21335;',
								'CN23' =>  'Chongqing / &#37325;&#24198;',
								'CN24' =>  'Sichuan / &#22235;&#24029;',
								'CN25' =>  'Guizhou / &#36149;&#24030;',
								'CN26' =>  'Shaanxi / &#38485;&#35199;',
								'CN27' =>  'Gansu / &#29976;&#32899;',
								'CN28' =>  'Qinghai / &#38738;&#28023;',
								'CN29' =>  'Ningxia Hui / &#23425;&#22799;',
								'CN30' =>  'Macau / &#28595;&#38376;',
								'CN31' =>  'Tibet / &#35199;&#34255;',
								'CN32' =>  'Xinjiang / &#26032;&#30086;',
							);
		$states['ES'] = array(
								'C'  =>  'A Coru&ntilde;a',
								'VI' =>  'Araba/&Aacute;lava',
								'AB' =>  'Albacete',
								'A'  =>  'Alicante',
								'AL' =>  'Almer&iacute;a',
								'O'  =>  'Asturias',
								'AV' =>  '&Aacute;vila',
								'BA' =>  'Badajoz',
								'PM' =>  'Baleares',
								'B'  =>  'Barcelona',
								'BU' =>  'Burgos',
								'CC' =>  'C&aacute;ceres',
								'CA' =>  'C&aacute;diz',
								'S'  =>  'Cantabria',
								'CS' =>  'Castell&oacute;n',
								'CE' =>  'Ceuta',
								'CR' =>  'Ciudad Real',
								'CO' =>  'C&oacute;rdoba',
								'CU' =>  'Cuenca',
								'GI' =>  'Girona',
								'GR' =>  'Granada',
								'GU' =>  'Guadalajara',
								'SS' =>  'Gipuzkoa',
								'H'  =>  'Huelva',
								'HU' =>  'Huesca',
								'J'  =>  'Ja&eacute;n',
								'LO' =>  'La Rioja',
								'GC' =>  'Las Palmas',
								'LE' =>  'Le&oacute;n',
								'L'  =>  'Lleida',
								'LU' =>  'Lugo',
								'M'  =>  'Madrid',
								'MA' =>  'M&aacute;laga',
								'ML' =>  'Melilla',
								'MU' =>  'Murcia',
								'NA' =>  'Navarra',
								'OR' =>  'Ourense',
								'P'  =>  'Palencia',
								'PO' =>  'Pontevedra',
								'SA' =>  'Salamanca',
								'TF' =>  'Santa Cruz de Tenerife',
								'SG' =>  'Segovia',
								'SE' =>  'Sevilla',
								'SO' =>  'Soria',
								'T'  =>  'Tarragona',
								'TE' =>  'Teruel',
								'TO' =>  'Toledo',
								'V'  =>  'Valencia',
								'VA' =>  'Valladolid',
								'BI' =>  'Bizkaia',
								'ZA' =>  'Zamora',
								'Z'  =>  'Zaragoza',
							);
		$states['GR'] = array(
								'I' =>  'Αττική',
								'A' =>  'Ανατολική Μακεδονία και Θράκη',
								'B' =>  'Κεντρική Μακεδονία',
								'C' =>  'Δυτική Μακεδονία',
								'D' =>  'Ήπειρος',
								'E' =>  'Θεσσαλία',
								'F' =>  'Ιόνιοι Νήσοι',
								'G' =>  'Δυτική Ελλάδα',
								'H' =>  'Στερεά Ελλάδα',
								'J' =>  'Πελοπόννησος',
								'K' =>  'Βόρειο Αιγαίο',
								'L' =>  'Νότιο Αιγαίο',
								'M' =>  'Κρήτη',
							);
		$states['HK'] = array(
								'HONG KONG'       =>  'Hong Kong Island',
								'KOWLOON'         =>  'Kowloon',
								'NEW TERRITORIES' =>  'New Territories',
							);
		$states['HU'] = array(
								'BK' =>  'Bács-Kiskun',
								'BE' =>  'Békés',
								'BA' =>  'Baranya',
								'BZ' =>  'Borsod-Abaúj-Zemplén',
								'BU' =>  'Budapest',
								'CS' =>  'Csongrád',
								'FE' =>  'Fejér',
								'GS' =>  'Győr-Moson-Sopron',
								'HB' =>  'Hajdú-Bihar',
								'HE' =>  'Heves',
								'JN' =>  'Jász-Nagykun-Szolnok',
								'KE' =>  'Komárom-Esztergom',
								'NO' =>  'Nógrád',
								'PE' =>  'Pest',
								'SO' =>  'Somogy',
								'SZ' =>  'Szabolcs-Szatmár-Bereg',
								'TO' =>  'Tolna',
								'VA' =>  'Vas',
								'VE' =>  'Veszprém',
								'ZA' =>  'Zala',
							);
		$states['ID'] = array(
								'AC' =>  'Daerah Istimewa Aceh',
								'SU' =>  'Sumatera Utara',
								'SB' =>  'Sumatera Barat',
								'RI' =>  'Riau',
								'KR' =>  'Kepulauan Riau',
								'JA' =>  'Jambi',
								'SS' =>  'Sumatera Selatan',
								'BB' =>  'Bangka Belitung',
								'BE' =>  'Bengkulu',
								'LA' =>  'Lampung',
								'JK' =>  'DKI Jakarta',
								'JB' =>  'Jawa Barat',
								'BT' =>  'Banten',
								'JT' =>  'Jawa Tengah',
								'JI' =>  'Jawa Timur',
								'YO' =>  'Daerah Istimewa Yogyakarta',
								'BA' =>  'Bali',
								'NB' =>  'Nusa Tenggara Barat',
								'NT' =>  'Nusa Tenggara Timur',
								'KB' =>  'Kalimantan Barat',
								'KT' =>  'Kalimantan Tengah',
								'KI' =>  'Kalimantan Timur',
								'KS' =>  'Kalimantan Selatan',
								'KU' =>  'Kalimantan Utara',
								'SA' =>  'Sulawesi Utara',
								'ST' =>  'Sulawesi Tengah',
								'SG' =>  'Sulawesi Tenggara',
								'SR' =>  'Sulawesi Barat',
								'SN' =>  'Sulawesi Selatan',
								'GO' =>  'Gorontalo',
								'MA' =>  'Maluku',
								'MU' =>  'Maluku Utara',
								'PA' =>  'Papua',
								'PB' =>  'Papua Barat',
							);
		$states['IE'] = array(
								'CE' =>  'Clare',
								'CK' =>  'Cork',
								'CN' =>  'Cavan',
								'CW' =>  'Carlow',
								'DL' =>  'Donegal',
								'DN' =>  'Dublin',
								'GY' =>  'Galway',
								'KE' =>  'Kildare',
								'KK' =>  'Kilkenny',
								'KY' =>  'Kerry',
								'LD' =>  'Longford',
								'LH' =>  'Louth',
								'LK' =>  'Limerick',
								'LM' =>  'Leitrim',
								'LS' =>  'Laois',
								'MH' =>  'Meath',
								'MN' =>  'Monaghan',
								'MO' =>  'Mayo',
								'OY' =>  'Offaly',
								'RN' =>  'Roscommon',
								'SO' =>  'Sligo',
								'TY' =>  'Tipperary',
								'WD' =>  'Waterford',
								'WH' =>  'Westmeath',
								'WW' =>  'Wicklow',
								'WX' =>  'Wexford',
							);
		$states['IN'] = array(
								'AP' =>  'Andhra Pradesh',
								'AR' =>  'Arunachal Pradesh',
								'AS' =>  'Assam',
								'BR' =>  'Bihar',
								'CT' =>  'Chhattisgarh',
								'GA' =>  'Goa',
								'GJ' =>  'Gujarat',
								'HR' =>  'Haryana',
								'HP' =>  'Himachal Pradesh',
								'JK' =>  'Jammu and Kashmir',
								'JH' =>  'Jharkhand',
								'KA' =>  'Karnataka',
								'KL' =>  'Kerala',
								'MP' =>  'Madhya Pradesh',
								'MH' =>  'Maharashtra',
								'MN' =>  'Manipur',
								'ML' =>  'Meghalaya',
								'MZ' =>  'Mizoram',
								'NL' =>  'Nagaland',
								'OR' =>  'Orissa',
								'PB' =>  'Punjab',
								'RJ' =>  'Rajasthan',
								'SK' =>  'Sikkim',
								'TN' =>  'Tamil Nadu',
								'TS' =>  'Telangana',
								'TR' =>  'Tripura',
								'UK' =>  'Uttarakhand',
								'UP' =>  'Uttar Pradesh',
								'WB' =>  'West Bengal',
								'AN' =>  'Andaman and Nicobar Islands',
								'CH' =>  'Chandigarh',
								'DN' =>  'Dadra and Nagar Haveli',
								'DD' =>  'Daman and Diu',
								'DL' =>  'Delhi',
								'LD' =>  'Lakshadeep',
								'PY' =>  'Pondicherry (Puducherry)',
							);
		$states['IR'] = array(
								'KHZ' =>  'Khuzestan  (خوزستان)',
								'THR' =>  'Tehran  (تهران)',
								'ILM' =>  'Ilaam (ایلام)',
								'BHR' =>  'Bushehr (بوشهر)',
								'ADL' =>  'Ardabil (اردبیل)',
								'ESF' =>  'Isfahan (اصفهان)',
								'YZD' =>  'Yazd (یزد)',
								'KRH' =>  'Kermanshah (کرمانشاه)',
								'KRN' =>  'Kerman (کرمان)',
								'HDN' =>  'Hamadan (همدان)',
								'GZN' =>  'Ghazvin (قزوین)',
								'ZJN' =>  'Zanjan (زنجان)',
								'LRS' =>  'Luristan (لرستان)',
								'ABZ' =>  'Alborz (البرز)',
								'EAZ' =>  'East Azarbaijan (آذربایجان شرقی)',
								'WAZ' =>  'West Azarbaijan (آذربایجان غربی)',
								'CHB' =>  'Chaharmahal and Bakhtiari (چهارمحال و بختیاری)',
								'SKH' =>  'South Khorasan (خراسان جنوبی)',
								'RKH' =>  'Razavi Khorasan (خراسان رضوی)',
								'NKH' =>  'North Khorasan (خراسان جنوبی)',
								'SMN' =>  'Semnan (سمنان)',
								'FRS' =>  'Fars (فارس)',
								'QHM' =>  'Qom (قم)',
								'KRD' =>  'Kurdistan / کردستان)',
								'KBD' =>  'Kohgiluyeh and BoyerAhmad (کهگیلوییه و بویراحمد)',
								'GLS' =>  'Golestan (گلستان)',
								'GIL' =>  'Gilan (گیلان)',
								'MZN' =>  'Mazandaran (مازندران)',
								'MKZ' =>  'Markazi (مرکزی)',
								'HRZ' =>  'Hormozgan (هرمزگان)',
								'SBN' =>  'Sistan and Baluchestan (سیستان و بلوچستان)',
							);
		$states['IT'] = array(
								'AG' =>  'Agrigento',
								'AL' =>  'Alessandria',
								'AN' =>  'Ancona',
								'AO' =>  'Aosta',
								'AR' =>  'Arezzo',
								'AP' =>  'Ascoli Piceno',
								'AT' =>  'Asti',
								'AV' =>  'Avellino',
								'BA' =>  'Bari',
								'BT' =>  'Barletta-Andria-Trani',
								'BL' =>  'Belluno',
								'BN' =>  'Benevento',
								'BG' =>  'Bergamo',
								'BI' =>  'Biella',
								'BO' =>  'Bologna',
								'BZ' =>  'Bolzano',
								'BS' =>  'Brescia',
								'BR' =>  'Brindisi',
								'CA' =>  'Cagliari',
								'CL' =>  'Caltanissetta',
								'CB' =>  'Campobasso',
								'CI' =>  'Carbonia-Iglesias',
								'CE' =>  'Caserta',
								'CT' =>  'Catania',
								'CZ' =>  'Catanzaro',
								'CH' =>  'Chieti',
								'CO' =>  'Como',
								'CS' =>  'Cosenza',
								'CR' =>  'Cremona',
								'KR' =>  'Crotone',
								'CN' =>  'Cuneo',
								'EN' =>  'Enna',
								'FM' =>  'Fermo',
								'FE' =>  'Ferrara',
								'FI' =>  'Firenze',
								'FG' =>  'Foggia',
								'FC' =>  'Forlì-Cesena',
								'FR' =>  'Frosinone',
								'GE' =>  'Genova',
								'GO' =>  'Gorizia',
								'GR' =>  'Grosseto',
								'IM' =>  'Imperia',
								'IS' =>  'Isernia',
								'SP' =>  'La Spezia',
								'AQ' =>  "L'Aquila",
								'LT' =>  'Latina',
								'LE' =>  'Lecce',
								'LC' =>  'Lecco',
								'LI' =>  'Livorno',
								'LO' =>  'Lodi',
								'LU' =>  'Lucca',
								'MC' =>  'Macerata',
								'MN' =>  'Mantova',
								'MS' =>  'Massa-Carrara',
								'MT' =>  'Matera',
								'ME' =>  'Messina',
								'MI' =>  'Milano',
								'MO' =>  'Modena',
								'MB' =>  'Monza e della Brianza',
								'NA' =>  'Napoli',
								'NO' =>  'Novara',
								'NU' =>  'Nuoro',
								'OT' =>  'Olbia-Tempio',
								'OR' =>  'Oristano',
								'PD' =>  'Padova',
								'PA' =>  'Palermo',
								'PR' =>  'Parma',
								'PV' =>  'Pavia',
								'PG' =>  'Perugia',
								'PU' =>  'Pesaro e Urbino',
								'PE' =>  'Pescara',
								'PC' =>  'Piacenza',
								'PI' =>  'Pisa',
								'PT' =>  'Pistoia',
								'PN' =>  'Pordenone',
								'PZ' =>  'Potenza',
								'PO' =>  'Prato',
								'RG' =>  'Ragusa',
								'RA' =>  'Ravenna',
								'RC' =>  'Reggio Calabria',
								'RE' =>  'Reggio Emilia',
								'RI' =>  'Rieti',
								'RN' =>  'Rimini',
								'RM' =>  'Roma',
								'RO' =>  'Rovigo',
								'SA' =>  'Salerno',
								'VS' =>  'Medio Campidano',
								'SS' =>  'Sassari',
								'SV' =>  'Savona',
								'SI' =>  'Siena',
								'SR' =>  'Siracusa',
								'SO' =>  'Sondrio',
								'TA' =>  'Taranto',
								'TE' =>  'Teramo',
								'TR' =>  'Terni',
								'TO' =>  'Torino',
								'OG' =>  'Ogliastra',
								'TP' =>  'Trapani',
								'TN' =>  'Trento',
								'TV' =>  'Treviso',
								'TS' =>  'Trieste',
								'UD' =>  'Udine',
								'VA' =>  'Varese',
								'VE' =>  'Venezia',
								'VB' =>  'Verbano-Cusio-Ossola',
								'VC' =>  'Vercelli',
								'VR' =>  'Verona',
								'VV' =>  'Vibo Valentia',
								'VI' =>  'Vicenza',
								'VT' =>  'Viterbo',
							);
		$states['JP'] = array(
								'JP01' =>  'Hokkaido',
								'JP02' =>  'Aomori',
								'JP03' =>  'Iwate',
								'JP04' =>  'Miyagi',
								'JP05' =>  'Akita',
								'JP06' =>  'Yamagata',
								'JP07' =>  'Fukushima',
								'JP08' =>  'Ibaraki',
								'JP09' =>  'Tochigi',
								'JP10' =>  'Gunma',
								'JP11' =>  'Saitama',
								'JP12' =>  'Chiba',
								'JP13' =>  'Tokyo',
								'JP14' =>  'Kanagawa',
								'JP15' =>  'Niigata',
								'JP16' =>  'Toyama',
								'JP17' =>  'Ishikawa',
								'JP18' =>  'Fukui',
								'JP19' =>  'Yamanashi',
								'JP20' =>  'Nagano',
								'JP21' =>  'Gifu',
								'JP22' =>  'Shizuoka',
								'JP23' =>  'Aichi',
								'JP24' =>  'Mie',
								'JP25' =>  'Shiga',
								'JP26' =>  'Kyoto',
								'JP27' =>  'Osaka',
								'JP28' =>  'Hyogo',
								'JP29' =>  'Nara',
								'JP30' =>  'Wakayama',
								'JP31' =>  'Tottori',
								'JP32' =>  'Shimane',
								'JP33' =>  'Okayama',
								'JP34' =>  'Hiroshima',
								'JP35' =>  'Yamaguchi',
								'JP36' =>  'Tokushima',
								'JP37' =>  'Kagawa',
								'JP38' =>  'Ehime',
								'JP39' =>  'Kochi',
								'JP40' =>  'Fukuoka',
								'JP41' =>  'Saga',
								'JP42' =>  'Nagasaki',
								'JP43' =>  'Kumamoto',
								'JP44' =>  'Oita',
								'JP45' =>  'Miyazaki',
								'JP46' =>  'Kagoshima',
								'JP47' =>  'Okinawa',
								'Fukushima' => 'Fukushima'
							);
		$states['MX'] = array(
								'Distrito Federal' 		=>  'Distrito Federal',
								'Jalisco' 				=>  'Jalisco',
								'Nuevo Leon' 			=>  'Nuevo León',
								'Aguascalientes' 		=>  'Aguascalientes',
								'Baja California' 		=>  'Baja California',
								'Baja California Sur' 	=>  'Baja California Sur',
								'Campeche' 				=>  'Campeche',
								'Chiapas' 				=>  'Chiapas',
								'Chihuahua' 			=>  'Chihuahua',
								'Coahuila' 				=>  'Coahuila',
								'Colima' 				=>  'Colima',
								'Durango' 				=>  'Durango',
								'Guanajuato' 			=>  'Guanajuato',
								'Guerrero' 				=>  'Guerrero',
								'Hidalgo' 				=>  'Hidalgo',
								'Estado de Mexico' 		=>  'Edo. de México',
								'Michoacan' 			=>  'Michoacán',
								'Morelos' 				=>  'Morelos',
								'Nayarit' 				=>  'Nayarit',
								'Oaxaca' 				=>  'Oaxaca',
								'Puebla' 				=>  'Puebla',
								'Queretaro' 			=>  'Querétaro',
								'Quintana Roo' 			=>  'Quintana Roo',
								'San Luis Potosi' 		=>  'San Luis Potosí',
								'Sinaloa' 				=>  'Sinaloa',
								'Sonora' 				=>  'Sonora',
								'Tabasco' 				=>  'Tabasco',
								'Tamaulipas' 			=>  'Tamaulipas',
								'Tlaxcala' 				=>  'Tlaxcala',
								'Veracruz' 				=>  'Veracruz',
								'Yucatan' 				=>  'Yucatán',
								'Zacatecas' 			=>  'Zacatecas',
							);
		$states['MY'] = array(
								'JHR' =>  'Johor',
								'KDH' =>  'Kedah',
								'KTN' =>  'Kelantan',
								'LBN' =>  'Labuan',
								'MLK' =>  'Malacca (Melaka)',
								'NSN' =>  'Negeri Sembilan',
								'PHG' =>  'Pahang',
								'PNG' =>  'Penang (Pulau Pinang)',
								'PRK' =>  'Perak',
								'PLS' =>  'Perlis',
								'SBH' =>  'Sabah',
								'SWK' =>  'Sarawak',
								'SGR' =>  'Selangor',
								'TRG' =>  'Terengganu',
								'PJY' =>  'Putrajaya',
								'KUL' =>  'Kuala Lumpur',
							);
		$states['NG'] = array(
								'AB' =>  'Abia',
								'FC' =>  'Abuja',
								'AD' =>  'Adamawa',
								'AK' =>  'Akwa Ibom',
								'AN' =>  'Anambra',
								'BA' =>  'Bauchi',
								'BY' =>  'Bayelsa',
								'BE' =>  'Benue',
								'BO' =>  'Borno',
								'CR' =>  'Cross River',
								'DE' =>  'Delta',
								'EB' =>  'Ebonyi',
								'ED' =>  'Edo',
								'EK' =>  'Ekiti',
								'EN' =>  'Enugu',
								'GO' =>  'Gombe',
								'IM' =>  'Imo',
								'JI' =>  'Jigawa',
								'KD' =>  'Kaduna',
								'KN' =>  'Kano',
								'KT' =>  'Katsina',
								'KE' =>  'Kebbi',
								'KO' =>  'Kogi',
								'KW' =>  'Kwara',
								'LA' =>  'Lagos',
								'NA' =>  'Nasarawa',
								'NI' =>  'Niger',
								'OG' =>  'Ogun',
								'ON' =>  'Ondo',
								'OS' =>  'Osun',
								'OY' =>  'Oyo',
								'PL' =>  'Plateau',
								'RI' =>  'Rivers',
								'SO' =>  'Sokoto',
								'TA' =>  'Taraba',
								'YO' =>  'Yobe',
								'ZA' =>  'Zamfara',
							);
		$states['NP'] = array(
								'BAG' =>  'Bagmati',
								'BHE' =>  'Bheri',
								'DHA' =>  'Dhaulagiri',
								'GAN' =>  'Gandaki',
								'JAN' =>  'Janakpur',
								'KAR' =>  'Karnali',
								'KOS' =>  'Koshi',
								'LUM' =>  'Lumbini',
								'MAH' =>  'Mahakali',
								'MEC' =>  'Mechi',
								'NAR' =>  'Narayani',
								'RAP' =>  'Rapti',
								'SAG' =>  'Sagarmatha',
								'SET' =>  'Seti',
							);
		$states['NZ'] = array(
								'NL' =>  'Northland',
								'AK' =>  'Auckland',
								'WA' =>  'Waikato',
								'BP' =>  'Bay of Plenty',
								'TK' =>  'Taranaki',
								'GI' =>  'Gisborne',
								'HB' =>  'Hawke&rsquo;s Bay',
								'MW' =>  'Manawatu-Wanganui',
								'WE' =>  'Wellington',
								'NS' =>  'Nelson',
								'MB' =>  'Marlborough',
								'TM' =>  'Tasman',
								'WC' =>  'West Coast',
								'CT' =>  'Canterbury',
								'OT' =>  'Otago',
								'SL' =>  'Southland',
							);
		$states['PE'] = array(
								'CAL' =>  'El Callao',
								'LMA' =>  'Municipalidad Metropolitana de Lima',
								'AMA' =>  'Amazonas',
								'ANC' =>  'Ancash',
								'APU' =>  'Apur&iacute;mac',
								'ARE' =>  'Arequipa',
								'AYA' =>  'Ayacucho',
								'CAJ' =>  'Cajamarca',
								'CUS' =>  'Cusco',
								'HUV' =>  'Huancavelica',
								'HUC' =>  'Hu&aacute;nuco',
								'ICA' =>  'Ica',
								'JUN' =>  'Jun&iacute;n',
								'LAL' =>  'La Libertad',
								'LAM' =>  'Lambayeque',
								'LIM' =>  'Lima',
								'LOR' =>  'Loreto',
								'MDD' =>  'Madre de Dios',
								'MOQ' =>  'Moquegua',
								'PAS' =>  'Pasco',
								'PIU' =>  'Piura',
								'PUN' =>  'Puno',
								'SAM' =>  'San Mart&iacute;n',
								'TAC' =>  'Tacna',
								'TUM' =>  'Tumbes',
								'UCA' =>  'Ucayali',
							);
		$states['PH'] = array(
								'ABR' =>  'Abra',
								'AGN' =>  'Agusan del Norte',
								'AGS' =>  'Agusan del Sur',
								'AKL' =>  'Aklan',
								'ALB' =>  'Albay',
								'ANT' =>  'Antique',
								'APA' =>  'Apayao',
								'AUR' =>  'Aurora',
								'BAS' =>  'Basilan',
								'BAN' =>  'Bataan',
								'BTN' =>  'Batanes',
								'BTG' =>  'Batangas',
								'BEN' =>  'Benguet',
								'BIL' =>  'Biliran',
								'BOH' =>  'Bohol',
								'BUK' =>  'Bukidnon',
								'BUL' =>  'Bulacan',
								'CAG' =>  'Cagayan',
								'CAN' =>  'Camarines Norte',
								'CAS' =>  'Camarines Sur',
								'CAM' =>  'Camiguin',
								'CAP' =>  'Capiz',
								'CAT' =>  'Catanduanes',
								'CAV' =>  'Cavite',
								'CEB' =>  'Cebu',
								'COM' =>  'Compostela Valley',
								'NCO' =>  'Cotabato',
								'DAV' =>  'Davao del Norte',
								'DAS' =>  'Davao del Sur',
								'DAC' =>  'Davao Occidental', // TODO: Needs to be updated when ISO code is assigned
								'DAO' =>  'Davao Oriental',
								'DIN' =>  'Dinagat Islands',
								'EAS' =>  'Eastern Samar',
								'GUI' =>  'Guimaras',
								'IFU' =>  'Ifugao',
								'ILN' =>  'Ilocos Norte',
								'ILS' =>  'Ilocos Sur',
								'ILI' =>  'Iloilo',
								'ISA' =>  'Isabela',
								'KAL' =>  'Kalinga',
								'LUN' =>  'La Union',
								'LAG' =>  'Laguna',
								'LAN' =>  'Lanao del Norte',
								'LAS' =>  'Lanao del Sur',
								'LEY' =>  'Leyte',
								'MAG' =>  'Maguindanao',
								'MAD' =>  'Marinduque',
								'MAS' =>  'Masbate',
								'MSC' =>  'Misamis Occidental',
								'MSR' =>  'Misamis Oriental',
								'MOU' =>  'Mountain Province',
								'NEC' =>  'Negros Occidental',
								'NER' =>  'Negros Oriental',
								'NSA' =>  'Northern Samar',
								'NUE' =>  'Nueva Ecija',
								'NUV' =>  'Nueva Vizcaya',
								'MDC' =>  'Occidental Mindoro',
								'MDR' =>  'Oriental Mindoro',
								'PLW' =>  'Palawan',
								'PAM' =>  'Pampanga',
								'PAN' =>  'Pangasinan',
								'QUE' =>  'Quezon',
								'QUI' =>  'Quirino',
								'RIZ' =>  'Rizal',
								'ROM' =>  'Romblon',
								'WSA' =>  'Samar',
								'SAR' =>  'Sarangani',
								'SIQ' =>  'Siquijor',
								'SOR' =>  'Sorsogon',
								'SCO' =>  'South Cotabato',
								'SLE' =>  'Southern Leyte',
								'SUK' =>  'Sultan Kudarat',
								'SLU' =>  'Sulu',
								'SUN' =>  'Surigao del Norte',
								'SUR' =>  'Surigao del Sur',
								'TAR' =>  'Tarlac',
								'TAW' =>  'Tawi-Tawi',
								'ZMB' =>  'Zambales',
								'ZAN' =>  'Zamboanga del Norte',
								'ZAS' =>  'Zamboanga del Sur',
								'ZSI' =>  'Zamboanga Sibugay',
								'00'  =>  'Metro Manila',
							);
		$states['PK'] = array(
								'JK' =>  'Azad Kashmir',
								'BA' =>  'Balochistan',
								'TA' =>  'FATA',
								'GB' =>  'Gilgit Baltistan',
								'IS' =>  'Islamabad Capital Territory',
								'KP' =>  'Khyber Pakhtunkhwa',
								'PB' =>  'Punjab',
								'SD' =>  'Sindh',
							);
		$states['RO'] = array (
								'AB' =>  'Alba',
								'AR' =>  'Arad',
								'AG' =>  'Arges',
								'BC' =>  'Bacau',
								'BH' =>  'Bihor',
								'BN' =>  'Bistrita-Nasaud',
								'BT' =>  'Botosani',
								'BR' =>  'Braila',
								'BV' =>  'Brasov',
								'B'  =>  'Bucuresti',
								'BZ' =>  'Buzau',
								'CL' =>  'Calarasi',
								'CS' =>  'Caras-Severin',
								'CJ' =>  'Cluj',
								'CT' =>  'Constanta',
								'CV' =>  'Covasna',
								'DB' =>  'Dambovita',
								'DJ' =>  'Dolj',
								'GL' =>  'Galati',
								'GR' =>  'Giurgiu',
								'GJ' =>  'Gorj',
								'HR' =>  'Harghita',
								'HD' =>  'Hunedoara',
								'IL' =>  'Ialomita',
								'IS' =>  'Iasi',
								'IF' =>  'Ilfov',
								'MM' =>  'Maramures',
								'MH' =>  'Mehedinti',
								'MS' =>  'Mures',
								'NT' =>  'Neamt',
								'OT' =>  'Olt',
								'PH' =>  'Prahova',
								'SJ' =>  'Salaj',
								'SM' =>  'Satu Mare',
								'SB' =>  'Sibiu',
								'SV' =>  'Suceava',
								'TR' =>  'Teleorman',
								'TM' =>  'Timis',
								'TL' =>  'Tulcea',
								'VL' =>  'Valcea',
								'VS' =>  'Vaslui',
								'VN' =>  'Vrancea',
							);
		$states['TH'] = array(
								'TH-37' =>  'Amnat Charoen (&#3629;&#3635;&#3609;&#3634;&#3592;&#3648;&#3592;&#3619;&#3636;&#3597;)',
								'TH-15' =>  'Ang Thong (&#3629;&#3656;&#3634;&#3591;&#3607;&#3629;&#3591;)',
								'TH-14' =>  'Ayutthaya (&#3614;&#3619;&#3632;&#3609;&#3588;&#3619;&#3624;&#3619;&#3637;&#3629;&#3618;&#3640;&#3608;&#3618;&#3634;)',
								'TH-10' =>  'Bangkok (&#3585;&#3619;&#3640;&#3591;&#3648;&#3607;&#3614;&#3617;&#3627;&#3634;&#3609;&#3588;&#3619;)',
								'TH-38' =>  'Bueng Kan (&#3610;&#3638;&#3591;&#3585;&#3634;&#3628;)',
								'TH-31' =>  'Buri Ram (&#3610;&#3640;&#3619;&#3637;&#3619;&#3633;&#3617;&#3618;&#3660;)',
								'TH-24' =>  'Chachoengsao (&#3593;&#3632;&#3648;&#3594;&#3636;&#3591;&#3648;&#3607;&#3619;&#3634;)',
								'TH-18' =>  'Chai Nat (&#3594;&#3633;&#3618;&#3609;&#3634;&#3607;)',
								'TH-36' =>  'Chaiyaphum (&#3594;&#3633;&#3618;&#3616;&#3641;&#3617;&#3636;)',
								'TH-22' =>  'Chanthaburi (&#3592;&#3633;&#3609;&#3607;&#3610;&#3640;&#3619;&#3637;)',
								'TH-50' =>  'Chiang Mai (&#3648;&#3594;&#3637;&#3618;&#3591;&#3651;&#3627;&#3617;&#3656;)',
								'TH-57' =>  'Chiang Rai (&#3648;&#3594;&#3637;&#3618;&#3591;&#3619;&#3634;&#3618;)',
								'TH-20' =>  'Chonburi (&#3594;&#3621;&#3610;&#3640;&#3619;&#3637;)',
								'TH-86' =>  'Chumphon (&#3594;&#3640;&#3617;&#3614;&#3619;)',
								'TH-46' =>  'Kalasin (&#3585;&#3634;&#3628;&#3626;&#3636;&#3609;&#3608;&#3640;&#3660;)',
								'TH-62' =>  'Kamphaeng Phet (&#3585;&#3635;&#3649;&#3614;&#3591;&#3648;&#3614;&#3594;&#3619;)',
								'TH-71' =>  'Kanchanaburi (&#3585;&#3634;&#3597;&#3592;&#3609;&#3610;&#3640;&#3619;&#3637;)',
								'TH-40' =>  'Khon Kaen (&#3586;&#3629;&#3609;&#3649;&#3585;&#3656;&#3609;)',
								'TH-81' =>  'Krabi (&#3585;&#3619;&#3632;&#3610;&#3637;&#3656;)',
								'TH-52' =>  'Lampang (&#3621;&#3635;&#3611;&#3634;&#3591;)',
								'TH-51' =>  'Lamphun (&#3621;&#3635;&#3614;&#3641;&#3609;)',
								'TH-42' =>  'Loei (&#3648;&#3621;&#3618;)',
								'TH-16' =>  'Lopburi (&#3621;&#3614;&#3610;&#3640;&#3619;&#3637;)',
								'TH-58' =>  'Mae Hong Son (&#3649;&#3617;&#3656;&#3630;&#3656;&#3629;&#3591;&#3626;&#3629;&#3609;)',
								'TH-44' =>  'Maha Sarakham (&#3617;&#3627;&#3634;&#3626;&#3634;&#3619;&#3588;&#3634;&#3617;)',
								'TH-49' =>  'Mukdahan (&#3617;&#3640;&#3585;&#3604;&#3634;&#3627;&#3634;&#3619;)',
								'TH-26' =>  'Nakhon Nayok (&#3609;&#3588;&#3619;&#3609;&#3634;&#3618;&#3585;)',
								'TH-73' =>  'Nakhon Pathom (&#3609;&#3588;&#3619;&#3611;&#3600;&#3617;)',
								'TH-48' =>  'Nakhon Phanom (&#3609;&#3588;&#3619;&#3614;&#3609;&#3617;)',
								'TH-30' =>  'Nakhon Ratchasima (&#3609;&#3588;&#3619;&#3619;&#3634;&#3594;&#3626;&#3637;&#3617;&#3634;)',
								'TH-60' =>  'Nakhon Sawan (&#3609;&#3588;&#3619;&#3626;&#3623;&#3619;&#3619;&#3588;&#3660;)',
								'TH-80' =>  'Nakhon Si Thammarat (&#3609;&#3588;&#3619;&#3624;&#3619;&#3637;&#3608;&#3619;&#3619;&#3617;&#3619;&#3634;&#3594;)',
								'TH-55' =>  'Nan (&#3609;&#3656;&#3634;&#3609;)',
								'TH-96' =>  'Narathiwat (&#3609;&#3619;&#3634;&#3608;&#3636;&#3623;&#3634;&#3626;)',
								'TH-39' =>  'Nong Bua Lam Phu (&#3627;&#3609;&#3629;&#3591;&#3610;&#3633;&#3623;&#3621;&#3635;&#3616;&#3641;)',
								'TH-43' =>  'Nong Khai (&#3627;&#3609;&#3629;&#3591;&#3588;&#3634;&#3618;)',
								'TH-12' =>  'Nonthaburi (&#3609;&#3609;&#3607;&#3610;&#3640;&#3619;&#3637;)',
								'TH-13' =>  'Pathum Thani (&#3611;&#3607;&#3640;&#3617;&#3608;&#3634;&#3609;&#3637;)',
								'TH-94' =>  'Pattani (&#3611;&#3633;&#3605;&#3605;&#3634;&#3609;&#3637;)',
								'TH-82' =>  'Phang Nga (&#3614;&#3633;&#3591;&#3591;&#3634;)',
								'TH-93' =>  'Phatthalung (&#3614;&#3633;&#3607;&#3621;&#3640;&#3591;)',
								'TH-56' =>  'Phayao (&#3614;&#3632;&#3648;&#3618;&#3634;)',
								'TH-67' =>  'Phetchabun (&#3648;&#3614;&#3594;&#3619;&#3610;&#3641;&#3619;&#3603;&#3660;)',
								'TH-76' =>  'Phetchaburi (&#3648;&#3614;&#3594;&#3619;&#3610;&#3640;&#3619;&#3637;)',
								'TH-66' =>  'Phichit (&#3614;&#3636;&#3592;&#3636;&#3605;&#3619;)',
								'TH-65' =>  'Phitsanulok (&#3614;&#3636;&#3625;&#3603;&#3640;&#3650;&#3621;&#3585;)',
								'TH-54' =>  'Phrae (&#3649;&#3614;&#3619;&#3656;)',
								'TH-83' =>  'Phuket (&#3616;&#3641;&#3648;&#3585;&#3655;&#3605;)',
								'TH-25' =>  'Prachin Buri (&#3611;&#3619;&#3634;&#3592;&#3637;&#3609;&#3610;&#3640;&#3619;&#3637;)',
								'TH-77' =>  'Prachuap Khiri Khan (&#3611;&#3619;&#3632;&#3592;&#3623;&#3610;&#3588;&#3637;&#3619;&#3637;&#3586;&#3633;&#3609;&#3608;&#3660;)',
								'TH-85' =>  'Ranong (&#3619;&#3632;&#3609;&#3629;&#3591;)',
								'TH-70' =>  'Ratchaburi (&#3619;&#3634;&#3594;&#3610;&#3640;&#3619;&#3637;)',
								'TH-21' =>  'Rayong (&#3619;&#3632;&#3618;&#3629;&#3591;)',
								'TH-45' =>  'Roi Et (&#3619;&#3657;&#3629;&#3618;&#3648;&#3629;&#3655;&#3604;)',
								'TH-27' =>  'Sa Kaeo (&#3626;&#3619;&#3632;&#3649;&#3585;&#3657;&#3623;)',
								'TH-47' =>  'Sakon Nakhon (&#3626;&#3585;&#3621;&#3609;&#3588;&#3619;)',
								'TH-11' =>  'Samut Prakan (&#3626;&#3617;&#3640;&#3607;&#3619;&#3611;&#3619;&#3634;&#3585;&#3634;&#3619;)',
								'TH-74' =>  'Samut Sakhon (&#3626;&#3617;&#3640;&#3607;&#3619;&#3626;&#3634;&#3588;&#3619;)',
								'TH-75' =>  'Samut Songkhram (&#3626;&#3617;&#3640;&#3607;&#3619;&#3626;&#3591;&#3588;&#3619;&#3634;&#3617;)',
								'TH-19' =>  'Saraburi (&#3626;&#3619;&#3632;&#3610;&#3640;&#3619;&#3637;)',
								'TH-91' =>  'Satun (&#3626;&#3605;&#3641;&#3621;)',
								'TH-17' =>  'Sing Buri (&#3626;&#3636;&#3591;&#3627;&#3660;&#3610;&#3640;&#3619;&#3637;)',
								'TH-33' =>  'Sisaket (&#3624;&#3619;&#3637;&#3626;&#3632;&#3648;&#3585;&#3625;)',
								'TH-90' =>  'Songkhla (&#3626;&#3591;&#3586;&#3621;&#3634;)',
								'TH-64' =>  'Sukhothai (&#3626;&#3640;&#3650;&#3586;&#3607;&#3633;&#3618;)',
								'TH-72' =>  'Suphan Buri (&#3626;&#3640;&#3614;&#3619;&#3619;&#3603;&#3610;&#3640;&#3619;&#3637;)',
								'TH-84' =>  'Surat Thani (&#3626;&#3640;&#3619;&#3634;&#3625;&#3598;&#3619;&#3660;&#3608;&#3634;&#3609;&#3637;)',
								'TH-32' =>  'Surin (&#3626;&#3640;&#3619;&#3636;&#3609;&#3607;&#3619;&#3660;)',
								'TH-63' =>  'Tak (&#3605;&#3634;&#3585;)',
								'TH-92' =>  'Trang (&#3605;&#3619;&#3633;&#3591;)',
								'TH-23' =>  'Trat (&#3605;&#3619;&#3634;&#3604;)',
								'TH-34' =>  'Ubon Ratchathani (&#3629;&#3640;&#3610;&#3621;&#3619;&#3634;&#3594;&#3608;&#3634;&#3609;&#3637;)',
								'TH-41' =>  'Udon Thani (&#3629;&#3640;&#3604;&#3619;&#3608;&#3634;&#3609;&#3637;)',
								'TH-61' =>  'Uthai Thani (&#3629;&#3640;&#3607;&#3633;&#3618;&#3608;&#3634;&#3609;&#3637;)',
								'TH-53' =>  'Uttaradit (&#3629;&#3640;&#3605;&#3619;&#3604;&#3636;&#3605;&#3606;&#3660;)',
								'TH-95' =>  'Yala (&#3618;&#3632;&#3621;&#3634;)',
								'TH-35' =>  'Yasothon (&#3618;&#3650;&#3626;&#3608;&#3619;)',
							);
		$states['TR'] = array(
								'TR01' =>  'Adana',
								'TR02' =>  'Ad&#305;yaman',
								'TR03' =>  'Afyon',
								'TR04' =>  'A&#287;r&#305;',
								'TR05' =>  'Amasya',
								'TR06' =>  'Ankara',
								'TR07' =>  'Antalya',
								'TR08' =>  'Artvin',
								'TR09' =>  'Ayd&#305;n',
								'TR10' =>  'Bal&#305;kesir',
								'TR11' =>  'Bilecik',
								'TR12' =>  'Bing&#246;l',
								'TR13' =>  'Bitlis',
								'TR14' =>  'Bolu',
								'TR15' =>  'Burdur',
								'TR16' =>  'Bursa',
								'TR17' =>  '&#199;anakkale',
								'TR18' =>  '&#199;ank&#305;r&#305;',
								'TR19' =>  '&#199;orum',
								'TR20' =>  'Denizli',
								'TR21' =>  'Diyarbak&#305;r',
								'TR22' =>  'Edirne',
								'TR23' =>  'Elaz&#305;&#287;',
								'TR24' =>  'Erzincan',
								'TR25' =>  'Erzurum',
								'TR26' =>  'Eski&#351;ehir',
								'TR27' =>  'Gaziantep',
								'TR28' =>  'Giresun',
								'TR29' =>  'G&#252;m&#252;&#351;hane',
								'TR30' =>  'Hakkari',
								'TR31' =>  'Hatay',
								'TR32' =>  'Isparta',
								'TR33' =>  '&#304;&#231;el',
								'TR34' =>  '&#304;stanbul',
								'TR35' =>  '&#304;zmir',
								'TR36' =>  'Kars',
								'TR37' =>  'Kastamonu',
								'TR38' =>  'Kayseri',
								'TR39' =>  'K&#305;rklareli',
								'TR40' =>  'K&#305;r&#351;ehir',
								'TR41' =>  'Kocaeli',
								'TR42' =>  'Konya',
								'TR43' =>  'K&#252;tahya',
								'TR44' =>  'Malatya',
								'TR45' =>  'Manisa',
								'TR46' =>  'Kahramanmara&#351;',
								'TR47' =>  'Mardin',
								'TR48' =>  'Mu&#287;la',
								'TR49' =>  'Mu&#351;',
								'TR50' =>  'Nev&#351;ehir',
								'TR51' =>  'Ni&#287;de',
								'TR52' =>  'Ordu',
								'TR53' =>  'Rize',
								'TR54' =>  'Sakarya',
								'TR55' =>  'Samsun',
								'TR56' =>  'Siirt',
								'TR57' =>  'Sinop',
								'TR58' =>  'Sivas',
								'TR59' =>  'Tekirda&#287;',
								'TR60' =>  'Tokat',
								'TR61' =>  'Trabzon',
								'TR62' =>  'Tunceli',
								'TR63' =>  '&#350;anl&#305;urfa',
								'TR64' =>  'U&#351;ak',
								'TR65' =>  'Van',
								'TR66' =>  'Yozgat',
								'TR67' =>  'Zonguldak',
								'TR68' =>  'Aksaray',
								'TR69' =>  'Bayburt',
								'TR70' =>  'Karaman',
								'TR71' =>  'K&#305;r&#305;kkale',
								'TR72' =>  'Batman',
								'TR73' =>  '&#350;&#305;rnak',
								'TR74' =>  'Bart&#305;n',
								'TR75' =>  'Ardahan',
								'TR76' =>  'I&#287;d&#305;r',
								'TR77' =>  'Yalova',
								'TR78' =>  'Karab&#252;k',
								'TR79' =>  'Kilis',
								'TR80' =>  'Osmaniye',
								'TR81' =>  'D&#252;zce',
							);
		$states['US'] = array(
								'AL' =>  'Alabama',
								'AK' =>  'Alaska',
								'AZ' =>  'Arizona',
								'AR' =>  'Arkansas',
								'CA' =>  'California',
								'CO' =>  'Colorado',
								'CT' =>  'Connecticut',
								'DE' =>  'Delaware',
								'DC' =>  'District Of Columbia',
								'FL' =>  'Florida',
								'GA' =>  'US state of Georgia',
								'HI' =>  'Hawaii',
								'ID' =>  'Idaho',
								'IL' =>  'Illinois',
								'IN' =>  'Indiana',
								'IA' =>  'Iowa',
								'KS' =>  'Kansas',
								'KY' =>  'Kentucky',
								'LA' =>  'Louisiana',
								'ME' =>  'Maine',
								'MD' =>  'Maryland',
								'MA' =>  'Massachusetts',
								'MI' =>  'Michigan',
								'MN' =>  'Minnesota',
								'MS' =>  'Mississippi',
								'MO' =>  'Missouri',
								'MT' =>  'Montana',
								'NE' =>  'Nebraska',
								'NV' =>  'Nevada',
								'NH' =>  'New Hampshire',
								'NJ' =>  'New Jersey',
								'NM' =>  'New Mexico',
								'NY' =>  'New York',
								'NC' =>  'North Carolina',
								'ND' =>  'North Dakota',
								'OH' =>  'Ohio',
								'OK' =>  'Oklahoma',
								'OR' =>  'Oregon',
								'PA' =>  'Pennsylvania',
								'RI' =>  'Rhode Island',
								'SC' =>  'South Carolina',
								'SD' =>  'South Dakota',
								'TN' =>  'Tennessee',
								'TX' =>  'Texas',
								'UT' =>  'Utah',
								'VT' =>  'Vermont',
								'VA' =>  'Virginia',
								'WA' =>  'Washington',
								'WV' =>  'West Virginia',
								'WI' =>  'Wisconsin',
								'WY' =>  'Wyoming',
								'AA' =>  'Armed Forces (AA)',
								'AE' =>  'Armed Forces (AE)',
								'AP' =>  'Armed Forces (AP)',
							);

		$states['ZA'] = array(
								'EC'  =>  'Eastern Cape',
								'FS'  =>  'Free State',
								'GP'  =>  'Gauteng',
								'KZN' =>  'KwaZulu-Natal',
								'LP'  =>  'Limpopo',
								'MP'  =>  'Mpumalanga',
								'NC'  =>  'Northern Cape',
								'NW'  =>  'North West',
								'WC'  =>  'Western Cape',
							);
		if(array_key_exists($countryCode, $states)){
			return $states[$countryCode];
		}else{
			return array();
		}
	}
	
	function filterServiceName($serviceName){
		$serviceNameKey = str_replace("&lt;sup&gt;&amp;reg;&lt;/sup&gt;", "", $serviceName);
		$serviceNameKey = str_replace("&lt;sup&gt;&amp;trade;&lt;/sup&gt;", "", $serviceNameKey);
		$serviceNameKey = str_replace("&lt;sup&gt;&#8482;&lt;/sup&gt;", "", $serviceNameKey);
		$serviceNameKey = str_replace("&lt;sup&gt;&#174;&lt;/sup&gt;", "", $serviceNameKey);
		$serviceNameKey = str_replace("l&lt;sup&gt;&#174;&lt;/sup&gt;", "", $serviceNameKey);
	
		return $serviceNameKey;
	}
	function removeDay($serviceName){
		$serviceName = str_replace(array(' 1-Day',' 2-Day',' 3-Day',' Military',' DPO'), '', $serviceName);
		return $serviceName;
	}


	function mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME'=> '', 'FPHONE'=> '', 'FMSG'=> '') ){
	    $data = array(
	         'apikey'        => $api_key,
	         'email_address' => $email,
	         'status'        => $status,
	         'merge_fields'  => $merge_fields
	    );
	 	$mch_api = curl_init(); // initialize cURL connection

	    curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
	    curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
	    curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	    curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
	    curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
	    curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
	    curl_setopt($mch_api, CURLOPT_POST, true);
	    curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json

	    $result = curl_exec($mch_api);
	      return $result;
    }



}

if( ! function_exists('successMesaage') ){
		function successMesaage($session=''){	
			$errordiv = '';
			if($session!=''){
				$errordiv .= '<div class="msg-component">';
					$errordiv .= '<div class="alert alert-success alert-fill alert-close alert-dismissable show" role="alert">';
						$errordiv .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="Close">×</button>';
						$errordiv .= '<strong>'.$session.'</strong>';
					$errordiv .= '</div>';
				$errordiv .= '</div>';
			}   
		   	echo $errordiv;
		}
	}

if( ! function_exists('errorMesaage') ){
		function errorMesaage($session=''){	
			$errordiv = '';
			if($session!=''){
				$errordiv .= '<div class="msg-component">';
					$errordiv .= '<div class="alert alert-danger alert-fill alert-close alert-dismissable show" role="alert">';
						$errordiv .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="Close">×</button>';
						$errordiv .= '<strong>'.$session.'</strong>';
					$errordiv .= '</div>';
				$errordiv .= '</div>';
			}   
		   	echo $errordiv;
		}
}

if( ! function_exists('validationError') ){	
		function validationError($errors){
			$errordiv = '';
			if($errors->any()){
				$errordiv .= '<div class="msg-component">';
					$errordiv .= '<div class="alert alert-danger alert-dismissable alert-fill alert-close show" role="alert">';
						$errordiv .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="Close">×</button>';
						$errordiv .= '<ul>';
							$all_error = $errors->all();
							foreach ($all_error as $key => $value) {
								$errordiv .= '<li>'.$value.'</li>';
							}
						$errordiv .= '</ul>';
					$errordiv .= '</div>';		
				$errordiv .= '</div>';		
			}
			echo $errordiv;
		}
}

if (! function_exists('points')) {
	function points($amount){
	$points = $amount;
	$pointsSettings = PointsSettings::where('id', '=', 1)->first();
		if($pointsSettings->earn_points_conversion_rate > 0 && $pointsSettings->earn_points_conversion_points > 0){

			$points = ($amount/$pointsSettings->earn_points_conversion_rate) * $pointsSettings->earn_points_conversion_points;
		}else{
			$points = $amount;
		}
	return round($points);	
	}
}
if (! function_exists('PointsAmount')) {
	function PointsAmount($points){
		$pointsSettings = PointsSettings::where('id', '=', 1)->first();
		if($pointsSettings->redemption_conversion_rate > 0 && $pointsSettings->redemption_conversion_points > 0){
			$amount = ($points/$pointsSettings->redemption_conversion_points) * $pointsSettings->redemption_conversion_rate;
		}else{
			$amount = $points;
		}
		return number_format($amount, 2);
	}
}


if( ! function_exists('wishlist') ){
	function wishlist($user_id){		
		return Wishlist::select('*')->where('user_id',$user_id)->with('product')->get();
	}
}

if(! function_exists('wishlist_product') ){
	function wishlist_product($product_id=null,$user_id){
		$aa =Wishlist::select('*')->where('product_id',$product_id)->where('user_id',$user_id)->first();
		if($aa){
			return true;
		}else{
			return false;
		}
	}
}

if(! function_exists('image_path')){
    function image_path(){
        $img_path = asset('assets/hsfront/img/');
        return $img_path;
    }
}

if(! function_exists('css_path')){
    function css_path(){
        $css_path = asset('assets/hsfront/css/');
        return $css_path;
    }
}

if(! function_exists('js_path')){
    function js_path(){
        $js_path = asset('assets/hsfront/js/');
        return $js_path;
    }
}

if( ! function_exists('blog_tags') ){
    function blog_tags(){
        return BlogTags::where('status', 1)->get();
    }
}

if( ! function_exists('randomChar') ) {
    function randomChar()
    {
        $characters = 'abc';
        $randomString = '';

        for ($i = 0; $i < 1; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}

if(! function_exists('setActive')){
    function setActive($path, $class_name = "active")
    {
//        return Request::path();
//        if(request()->is('blogs') || request()->is('blog/*') || request()->is('category/*') && $path == 'blog'){
//            return $class_name;
//        }
        if((Request::path() == '/') && $path == 'home'){
            return $class_name;
        }
        return Request::path() === $path ? $class_name : "";
    }
}

if( !function_exists('dean_image_compression')) {
    function dean_image_compression($name, $path)
    {
        $filename = $name;
        $filepath = public_path($path . $filename);
        try {
            \Tinify\setKey(env('TINY_PNG_API_KEY', 'X2LWCrToXTgI5YirmD67u0JVmPFV2bci')); //X2LWCrToXTgI5YirmD67u0JVmPFV2bci
            $source = \Tinify\fromFile($filepath);
            $source->toFile($filepath);
        } catch (\Tinify\AccountException $e) {
            // Verify your API key and account limit.
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Tinify\ClientException $e) {
            // Check your source image and request options.
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Tinify\ServerException $e) {
            // Temporary issue with the Tinify API.
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Tinify\ConnectionException $e) {
            // A network connection error occurred.
            return redirect()->back()->with('error', $e->getMessage());;
        } catch (Exception $e) {
            // Something else went wrong, unrelated to the Tinify API.
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

if(! function_exists('user_avatar')){
    function user_avatar(){
        $avatar = AdminUser::first();
        $avatar = $avatar->featured_image;
        return $avatar;
    }
}