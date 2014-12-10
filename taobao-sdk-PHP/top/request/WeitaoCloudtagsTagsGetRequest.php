<?php
/**
 * TOP API: taobao.weitao.cloudtags.tags.get request
 * 
 * @author auto create
 * @since 1.0, 2014-05-10 13:30:05
 */
class WeitaoCloudtagsTagsGetRequest
{
	
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "taobao.weitao.cloudtags.tags.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
