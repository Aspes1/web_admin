<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class IRS_Services extends Irs_config {

    
    private $secret_key;

    protected $list_operator_pulsa     = 'list/operator/product';
    protected $list_all_operator       = 'list/all/operator';
    protected $list_pulsa_all_operator = 'list/product/all/operator';
    protected $list_pulsa_by_operator  = 'list/product/by/operator';
    protected $list_produk_by_produk_id  = 'list/product/by/product_id';
    protected $update_list_product_by_category = 'list/product/by/category/name';

    public function __construct()
    {
        parent::__construct();
        $this->secret_key = $this->getSecretKey();
    }

    
    public function getListIRSOperatorByCategory($type)
    {
        $full_url = $this->getIRSAPIUrl($this->list_operator_pulsa);
        $response = $this->PostData($full_url, array('secret_key' => $this->secret_key, 'category_id' => $type));

        if($response['success'] == 1 && count($response['messages']) > 0)
            return $response['messages'];
    
        return array();
    }


    public function getListIRSProductByOperator($operator_id)
    {
        
        $full_url = $this->getIRSAPIUrl($this->list_pulsa_by_operator);
        $response = $this->PostData($full_url, array('secret_key' => $this->secret_key, 'operator_id' => $operator_id));
        
        if($response['success'] == 1 && count($response['messages']) > 0)
            return $response['messages'];
        else
            return $response['messages'];
    }

    public function getListProductIRSByCode($product_code)
    {
        $full_url = $this->getIRSAPIUrl($this->list_produk_by_produk_id);
        $response = $this->PostData($full_url, array(
            'secret_key' => $this->secret_key, 
            'product_code' => $product_code
        ));
        
        if($response['success'] == 1 && count($response['messages']) > 0)
            return $response['messages'];
        
        return array();
    }

    public function getDataProductIRSByCategory($category_name)
    {
        $full_url = $this->getIRSAPIUrl($this->update_list_product_by_category);
        $response = $this->PostData($full_url, array(
            'secret_key' => $this->secret_key, 
            'category_name' => $category_name, //pulsa, paket_data
        ));

        if($response['success'] == 1 && count($response['messages']) > 0)
            return $response['messages'];
        
        return array();
    }
    
}

/* End of file IRSServices.php */
