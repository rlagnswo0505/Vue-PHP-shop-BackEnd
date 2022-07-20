<?php
namespace application\controllers;

class ApiController extends Controller {
    public function categoryList() {
        return $this->model->getCategoryList();
    }

    public function productInsert() {
        $json = getJson();
        print_r($json);
        return [_RESULT => $this->model->productInsert($json)];
    }
    public function productList2() {
      $result = $this->model->productList2();
      return $result === false ? [] : $result;
    }
    public function delProduct(){
      $json = getJson();
      $result = $this->model->delProduct($json);
    }
    public function productDetail(){
      $urlPaths = getUrlPaths();
      if(!isset($urlPaths[2])){
        exit();
      }
      $param = [
        'product_id' => intval($urlPaths[2])
      ];
      return $this->model->productDetail($param);
    }
    public function upload() {
      $urlPaths = getUrlPaths();
      // 2번방과 3번방에 pathvariable이 있다 2번방 id, 3번방 type
      if(!isset($urlPaths[2]) || !isset($urlPaths[3])) {
          exit();
      }
      $productId = intval($urlPaths[2]);
      $type = intval($urlPaths[3]);
      $json = getJson();
      $param = [
        'product_id' => $productId,
        'type' => $type,
        'path' => '',
      ];
      foreach($json['images'] as $image){
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);      
        $image_type = $image_type_aux[1];
        // 문자열을 디코딩
        $image_base64 = base64_decode($image_parts[1]);
        $dirPath = _IMG_PATH . "/" . $productId . "/" . $type;
        $randomNm = uniqid();
        $filePath = $dirPath . "/" . $randomNm . "." . $image_type;
        if(!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $param['path'] .= ($randomNm . '.' . $image_type . ', ');
        $result = file_put_contents($filePath, $image_base64); 
      };
      
      //$file = _IMG_PATH . "/" . $productId . "/" . $type . "/" . uniqid() . "." . $image_type;
      //$file = "static/" . uniqid() . "." . $image_type;
      // 해당경로에 이미지를 생성
      $this->model->productImageInsert($param);
      return [_RESULT => 1];
  }
}