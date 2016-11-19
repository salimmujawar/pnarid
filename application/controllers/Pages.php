<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends CI_Controller {

	public function view($page = 'home')
	{
			if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}
			$current_url =  uri_string();			
			$url_arr = explode('/', $current_url);
			
			switch($url_arr[0]) {
				case 'privacy-policy':
					$data['seo_title']  = 'Mumbai Pune Taxi Fare | Mumbai to Shirdi Taxi | Pune Cab Services';
					$data['seo_desc']  = 'Get Pune Cab Services, Mumbai Pune Taxi Fare Pin A Ride Respects your privacy and recognizes the need to protect the personally identifiable information.';
				break;
				case 'terms-conditions':
					$data['seo_title']  = 'Mumbai to Pune Cab Services | Mumbai to Shirdi Taxi | Cab Services';
					$data['seo_desc']  = 'If you have question from where to take Car and Cab Rental Services for Mumbai, Pune, Shirdi, then Pin A Ride give you best service in Maharashtra, India.';
				break;
				case 'disclaimer':
					$data['seo_title']  = 'Mumbai to Shirdi Taxi | Mumbai Pune Taxi Fare | Cab Services';
					$data['seo_desc']  = 'Are you Searching for Mumbai to Shirdi Taxi, Mumbai Pune Taxi Fare, Cab on Rental, then Pin A Ride offers you best taxi services in Mumbai.';
				break;
				case 'about-us':
					$data['seo_title']  = 'Mumbai to Pune Car and Cab on Rental Services Provider';
					$data['seo_desc']  = 'Pin A Ride is basically Mumbai based Car and Cab on Rental Services Provider. Opening up more possibilities for riders and more business for drivers.';
				break;
				case 'contact-us':
					$data['seo_title']  = 'Mumbai to Pune Cab Services | Mumbai to Shirdi Taxi | Car Rental';
					$data['seo_desc']  = 'For booking your Rides on Rental in Mumbai, Pune, Shirdi, Khandala, Mahabaleshwar, Kolad, Call On: +91-96993-0594 or drop an email at help@pinaride.com.';
				break;
				default:
				break;
			}
			$data['title'] = ucfirst($page); // Capitalize the first letter

			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer', $data);
	}
}
