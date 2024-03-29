<?php
/**
 * TOP API: taobao.picture.update request
 * 
 * @author auto create
 * @since 1.0, 2014-05-10 13:30:05
 */
class PictureUpdateRequest
{
	/** 
	 * 新的图片名，最大长度50字符，不能为空<br /> 支持最大长度为：50<br /> 支持的最大列表长度为：50
	 **/
	private $newName;
	
	/** 
	 * 要更改名字的图片的id
	 **/
	private $pictureId;
	
	private $apiParas = array();
	
	public function setNewName($newName)
	{
		$this->newName = $newName;
		$this->apiParas["new_name"] = $newName;
	}

	public function getNewName()
	{
		return $this->newName;
	}

	public function setPictureId($pictureId)
	{
		$this->pictureId = $pictureId;
		$this->apiParas["picture_id"] = $pictureId;
	}

	public function getPictureId()
	{
		return $this->pictureId;
	}

	public function getApiMethodName()
	{
		return "taobao.picture.update";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->newName,"newName");
		RequestCheckUtil::checkMaxLength($this->newName,50,"newName");
		RequestCheckUtil::checkNotNull($this->pictureId,"pictureId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
