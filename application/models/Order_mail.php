<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_mail extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('email');
		$this->load->helper('url');
	}

	/**
	 * Request verify a new account
	 * @param 	$role, $email
	 * @return 	bool
	 */
	public function create($userEmail, $supplyEmail, $data) {
		$data['userLink'] = site_url('user');
		$data['supplyLink'] = site_url('supply');
		$data['logo'] = site_url('static/img/logo-landscape.png');
		$data['datetime'] = date(DATE_RSS);

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($userEmail);
		$this->email->subject('Sciclubs 预约已提交');

		$this->email->message($this->parser->parse("mail/order/user/create.html", $data, TRUE));
		$this->email->send();

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($supplyEmail);
		$this->email->subject('Sciclubs 新订单');
		$this->email->message($this->parser->parse("mail/order/supply/create.html", $data, TRUE));
		return $this->email->send();
	}

	public function confirm($userEmail, $data) {
		$data['userLink'] = site_url('user');
		$data['logo'] = site_url('static/img/logo-landscape.png');
		$data['datetime'] = date(DATE_RSS);

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($userEmail);
		$this->email->subject('Sciclubs 预约已确认');
		$this->email->message($this->parser->parse("mail/order/user/confirm.html", $data, TRUE));
		return $this->email->send();
	}

	public function budget($supplyEmail, $data) {
		$data['supplyLink'] = site_url('supply');
		$data['logo'] = site_url('static/img/logo-landscape.png');
		$data['datetime'] = date(DATE_RSS);

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($supplyEmail);
		$this->email->subject('Sciclubs 预算已支付');
		$this->email->message($this->parser->parse("mail/order/supply/budget.html", $data, TRUE));
		return $this->email->send();
	}

	public function begin($userEmail, $data) {
		$data['userLink'] = site_url('user');
		$data['logo'] = site_url('static/img/logo-landscape.png');
		$data['datetime'] = date(DATE_RSS);

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($userEmail);
		$this->email->subject('Sciclubs 实验已开始');
		$this->email->message($this->parser->parse("mail/order/user/begin.html", $data, TRUE));
		return $this->email->send();
	}

	public function end($userEmail, $data) {
		$data['userLink'] = site_url('user');
		$data['logo'] = site_url('static/img/logo-landscape.png');
		$data['datetime'] = date(DATE_RSS);

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($userEmail);
		$this->email->subject('Sciclubs 实验已结束');
		$this->email->message($this->parser->parse("mail/order/user/end.html", $data, TRUE));
		return $this->email->send();
	}

	public function fill($supplyEmail, $data) {
		$data['supplyLink'] = site_url('supply');
		$data['logo'] = site_url('static/img/logo-landscape.png');
		$data['datetime'] = date(DATE_RSS);

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($supplyEmail);
		$this->email->subject('Sciclubs 耗材费已支付');
		$this->email->message($this->parser->parse("mail/order/supply/fill.html", $data, TRUE));
		return $this->email->send();
	}

	public function cancel($userEmail, $supplyEmail, $data) {
		$data['userLink'] = site_url('user');
		$data['supplyLink'] = site_url('supply');
		$data['logo'] = site_url('static/img/logo-landscape.png');
		$data['datetime'] = date(DATE_RSS);

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($userEmail);
		$this->email->subject('Sciclubs 预约已取消');

		$this->email->message($this->parser->parse("mail/order/user/cancel.html", $data, TRUE));
		$this->email->send();

		$this->email->from('scicompass@sina.com', 'Sciclubs');
		$this->email->to($supplyEmail);
		$this->email->subject('Sciclubs 预约已取消');
		$this->email->message($this->parser->parse("mail/order/supply/cancel.html", $data, TRUE));
		return $this->email->send();
	}

}
