<?php

class ProductController
{
    public function __construct(private readonly ProductGateway $gateway)
    {}


    /**
     * @param string $method
     * @param string|null $id
     * @return void
     */
    public function processRequest(string $method, ?string $id): void
    {
        if($id){
            $this->processResourceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    /**
     * @param string $method
     * @param string $id
     * @return void
     */
    private function processResourceRequest(string $method, string $id): void
    {
        $product = $this->gateway->getProductWithId($id);

        if(!$product){
            ErrorHandler::showMessage(404, ["message" => "Product not found"]);
            return;
        }

        switch ($method) {
            case Methods::GET->value:
                echo json_encode($product);
                break;
            case Methods::PATCH->value:
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->getValidationErrors($data, false );

                if(!empty($errors)){
                    ErrorHandler::showMessage(422, ["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->update($product, $data);
                ErrorHandler::showMessage(201, ["message" => "Product with id  $id successfully updated",
                    "updated rows" => $rows]);
                break;
            case Methods::DELETE->value:
                $result = $this->gateway->delete($id);
                ErrorHandler::showMessage(201, ["message" => "Product with id  $id was successfully deleted"]);
                break;
            default:
                ErrorHandler::showMessage(405, ["errors" => "not allowed method"]);
                $allow = EnumMethods::getMethodsRequests();
                header("Allow: $allow");
                break;
        }

    }

    /**
     * @param string $method
     * @return void
     */
    private function processCollectionRequest(string $method): void
    {
        switch ($method){
            case Methods::GET->value:
                echo json_encode($this->gateway->getAll());
                break;
            case Methods::POST->value:
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->getValidationErrors($data);

                if(!empty($errors)){
                    ErrorHandler::showMessage(422, ["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);
                ErrorHandler::showMessage(201, ["message" => "Product successfully created", "id" => $id]);
                break;
            default:
                ErrorHandler::showMessage(405, ["errors" => "not allowed method"]);
                $allow = EnumMethods::getMethodsRequests();
                header("Allow: $allow");
        }
    }

    /**
     * @param array $data
     * @param bool $is_new
     * @return array
     */
    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = array();

        if($is_new && empty($data["name"])){
            $errors[] = 'Name is required!';
        }

        if(array_key_exists("size", $data)){
            if(filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "size must be integer";
            }
        }

        return $errors;
    }
}