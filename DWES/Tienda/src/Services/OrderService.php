<?php
    namespace Services;
    use Repositories\OrderRepository;
    use Models\Order;

    class OrderService{
        private OrderRepository $orderRepository;

        public function __construct() {
            $this->orderRepository = new OrderRepository();
        }
    
        public function createOrder($data){
            return 1;
        }
        
    }

