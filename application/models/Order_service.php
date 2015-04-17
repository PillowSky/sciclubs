<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_service extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->model('order_model');
	}

	/**
	 * Create an order
	 * @param 	$userID, $deviceID, $date, $resource
	 * @return  bool
	 */
	public function create($userID, $deviceID, $method, $date, $resource) {
		$this->load->model('device_model');
		$schedule = json_decode($this->device_model->info($deviceID)['schedule'], TRUE);
		$budget = $schedule[strtolower($method)][$resource]['price'];

		return $this->order_model->create($userID, $deviceID, $method, $date, $resource, $budget);
	}

	public function confirm($ID) {
		return $this->order_model->status($ID, 'CONFIRM');
	}

	public function budget($ID, $method, $account, $transaction) {
		$this->load->model('pay_model');

		switch ($method) {
			case 'GROUP':
				$budget = $this->order_model->info($ID)['budget'];
				$payID = $this->pay_model->pay($budget, 'GROUP', $account, $transaction);
				return $this->order_model->budget($ID, $payID);
			
			default:
				return FALSE;
		}
	}

	public function begin($ID) {
		return $this->order_model->status($ID, 'BEGIN');
	}

	public function end($ID, $fill, $detail) {
		return  $this->order_model->status($ID, 'END') AND $this->order_model->detail($ID, $fill, $detail);
	}

	public function fill($ID, $method, $account, $transaction) {
		$this->load->model('pay_model');

		switch ($method) {
			case 'GROUP':
				$fill = $this->order_model->info($ID)['fill'];
				$payID = $this->pay_model->pay($fill, 'GROUP', $account, $transaction);
				return $this->order_model->fill($ID, $payID);
			
			case 'NONE':
				return $this->order_model->fill($ID, 0);

			default:
				return FALSE;
		}
	}

	public function cancel($ID) {
		$this->load->model('usage_model');
		$this->load->model('pay_model');

		$orderInfo = $this->order_model->info($ID);
		$result = $this->usage_model->cancel($orderInfo['usageID']);

		if ($result && $orderInfo['budgetID']) {
			$result = $this->pay_model->refund($orderInfo['budgetID']);
		}

		if ($result && $orderInfo['fillID']) {
			$result = $this->pay_model->refund($orderInfo['fillID']);
		}

		if ($result) {
			$result = $this->order_model->cancel($ID);
		}

		return $result;
	}

	public function __call($name, $args) {
		return $this->order_model->$name($args);
	}

}
