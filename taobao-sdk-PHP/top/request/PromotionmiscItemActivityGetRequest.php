<?php
/**
 * TOP API: taobao.promotionmisc.item.activity.get request
 * 
 * @author auto create
 * @since 1.0, 2014-05-10 13:30:05
 */
class PromotionmiscItemActivityGetRequest
{
	/** 
	 * 活动id。<br /> 支持最小值为：0
	 **/
	private $activityId;
	
	private $apiParas = array();
	
	public function setActivityId($activityId)
	{
		$this->activityId = $activityId;
		$this->apiParas["activity_id"] = $activityId;
	}

	public function getActivityId()
	{
		return $this->activityId;
	}

	public function getApiMethodName()
	{
		return "taobao.promotionmisc.item.activity.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->activityId,"activityId");
		RequestCheckUtil::checkMinValue($this->activityId,0,"activityId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
