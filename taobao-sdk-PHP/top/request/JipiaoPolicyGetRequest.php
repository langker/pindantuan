<?php
/**
 * TOP API: taobao.jipiao.policy.get request
 * 
 * @author auto create
 * @since 1.0, 2014-05-10 13:30:05
 */
class JipiaoPolicyGetRequest
{
	/** 
	 * type外0，表示机票政策id；type为1，表示机票政策out_product_id<br /> 支持最大长度为：64<br /> 支持的最大列表长度为：64
	 **/
	private $policyId;
	
	/** 
	 * 0，表示按政策id进行查询；1，表示按政策外部id进行查询<br /> 支持最大值为：1<br /> 支持最小值为：0
	 **/
	private $type;
	
	private $apiParas = array();
	
	public function setPolicyId($policyId)
	{
		$this->policyId = $policyId;
		$this->apiParas["policy_id"] = $policyId;
	}

	public function getPolicyId()
	{
		return $this->policyId;
	}

	public function setType($type)
	{
		$this->type = $type;
		$this->apiParas["type"] = $type;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getApiMethodName()
	{
		return "taobao.jipiao.policy.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->policyId,"policyId");
		RequestCheckUtil::checkMaxLength($this->policyId,64,"policyId");
		RequestCheckUtil::checkNotNull($this->type,"type");
		RequestCheckUtil::checkMaxValue($this->type,1,"type");
		RequestCheckUtil::checkMinValue($this->type,0,"type");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
