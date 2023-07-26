<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart 
{
    private $session;
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        // $cart[] = [
        //     'id' => $id,
        //     'quantity' => 1
        // ];
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart', []);
    }

    public function remove()
    {
        $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart', []);
    
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
    
        $this->session->set('cart', $cart);
    }

    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);

        if($cart[$id]>1){
            $cart[$id]--;
        }else{
            unset($cart[$id]);
        }
        $this->session->set('cart', $cart);

    }

    public function getFull()
    {
        $cartComplete = [];

       if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
                if ($product) {
                    
                    $cartComplete[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                    ];
                }
            }
        }
        return $cartComplete;
    }
    
}
