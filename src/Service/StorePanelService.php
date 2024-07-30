<?php

namespace App\Service;

class StorePanelService
{

    public function getPanels()
    {
        $dumiesPanel = [
            '0' => [
                'name' => 'Factures',
                'img' => 'facture.png',
                'url' => 'invoices'
            ],
            '1' => [
                'name' => 'Payment',
                'img' => 'bill.png',
                'url' => 'bill'
            ],
            '3' => [
                'name' => 'Recette',
                'img' => 'barbecue.png',
                'url' => 'categories'
            ],
            '4' => [
                'name' => 'Ingredients',
                'img' => 'food.png',
                'url' => 'foods'
            ],
            '5' => [
                'name' => 'Produit',
                'img' => 'plat.png',
                'url' => 'plats'
            ],
            '6' => [
                'name' => 'Gestion de Stock',
                'img' => 'warehouse.png',
                'url' => 'inventory'
            ],
            '7' => [
                'name' => 'Utilisateurs',
                'img' => 'customer-service.png',
                'url' => 'users'
            ],
            '8' => [
                'name' => 'Restaurant Settings',
                'img' => 'settings.png',
                'url' => 'settings'
            ],


        ];
        return $dumiesPanel;
    }
}
