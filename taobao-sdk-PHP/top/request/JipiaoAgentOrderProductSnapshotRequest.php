<?php
/**
 * TOP API: taobao.jipiao.agent.order.product.snapshot request
 * 
 * @author auto create
 * @since 1.0, 2014-05-10 13:30:05
 */
class JipiaoAgentOrderProductSnapshotRequest
{
	/** 
	 * 订单号
	 **/
	private $orderId;
	
	private $apiParas = array();
	
	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
		$this->apiParas["order_id"] = $orderId;
	}

	public function getOrderId()
	{
		return $this->orderId;
	}

	public function getApiMethodName()
	{
		return "taobao.jipiao.agent.order.product.snapshot";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->orderId,"orderId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
