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
}