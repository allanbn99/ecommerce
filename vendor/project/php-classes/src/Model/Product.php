<?php

namespace Project\Model;

use \Project\Db\Sql;
use \Project\Model;

class Product extends Model {

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");

	}
	
	public static function checkList($list) {
		
		foreach ($list as &$row) {
			
			$p = new Product();
			$p->setData($row);
			$row = $p->getValues();

		}

		return $list;

	}

    public function save()
	{
        $sql = new Sql();
        
		$publicults = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
			":idproduct"=>$this->getidproduct(),
			":desproduct"=>$this->getdesproduct(),
			":vlprice"=>$this->getvlprice(),
			":vlwidth"=>$this->getvlwidth(),
			":vlheight"=>$this->getvlheight(),
			":vllength"=>$this->getvllength(),
			":vlweight"=>$this->getvlweight(),
			":desurl"=>$this->getdesurl()
        ));
        
		$this->setData($publicults[0]);
	}

    public function get($idproduct) {

        $sql = new Sql();

        $publicults = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct"=>$idproduct
        ));

        $this->setData($publicults[0]);

    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct"=>$this->getidproduct()
        ));

    }

    public function checkPhoto() {

		if (file_exists(
			$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"public" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"products" . DIRECTORY_SEPARATOR . 
			$this->getidproduct() . ".jpg"
			)) {

            $url = "/public/site/img/products/" . $this->getidproduct() . ".jpg";
            
		} else {

            $url = "/public/site/img/product.jpg";
            
        }
        
        return $this->setdesphoto($url);
        
    }
    
	public function getValues() {

        $this->checkPhoto();
        
        $values = parent::getValues();
        
        return $values;
        
    }
    
	public function setPhoto($file) {

		$extension = explode('.', $file['name']);
        $extension = end($extension);
        
		switch ($extension) {
			case "jpg":
			case "jpeg":
			    $image = imagecreatefromjpeg($file["tmp_name"]);
                break;
                
			case "gif":
			    $image = imagecreatefromgif($file["tmp_name"]);
                break;
                
			case "png":
			    $image = imagecreatefrompng($file["tmp_name"]);
                break;
                
        }
        
		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"public" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"products" . DIRECTORY_SEPARATOR . 
            $this->getidproduct() . ".jpg";
            
		imagejpeg($image, $dist);
        imagedestroy($image);
        
		$this->checkPhoto();
	}


}

