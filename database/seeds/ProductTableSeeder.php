<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{

        // =========================================================>> Add Product
        DB::table('products_type')->insert(
            [
                [ 'name' =>'Food'],
                [ 'name' =>'Barverage'],
            ]);

        DB::table('supplier')->insert(
            [
                [ 'name' =>'LG'],
                [ 'name' =>'SAMSUNG'],
            ]);
    
            DB::table('product')->insert(
                [
                    ['name'=>'ស៊ុបម្រះ',
                     'image'=>'menu/1.jpg',
                    ],
                    
                    ['name'=>'ម៉ូយយុាំង',
                     'image'=>'menu/2.jpg',
                    ],
    
                    ['name'=>'បន្លែស៊ុបរួម',
                     'image'=>'menu/3.jpg',
                    ],
    
                    ['name'=>'បន្លែម៉ូយយុាំងរួម',
                     'image'=>'menu/4.jpg',
                    ],
    
                    ['name'=>'បន្លែថែមមី និងបាយស',
                     'image'=>'menu/5.jpg',
                    ],
    
                    ['name'=>'សាច់ថែមចានតូច',
                     'image'=>'menu/6.jpg',
                    ],
    
                    ['name'=>'សាច់ថែមចានធំ',
                     'image'=>'menu/7.jpg',
                    ],
    
                    ['name'=>'បាយឆា',
                     'image'=>'menu/8.jpg',
                    ],  
    
                ]
            );
    
            DB::table('product')->insert(
                [
                    ['name'=>'កូកា','supplier_id'=> 1, 'type_id'=> 2 ,'image'=>'menu/drinks/1.jpg'], 
                    ['name'=>'ទឹកសុទ្ធ','supplier_id'=> 1, 'type_id'=> 2 ,'image'=>'menu/drinks/2.jpg'], 
                    ['name'=>'ទឹកក្រូច','supplier_id'=> 1, 'type_id'=> 2 , 'image'=>'menu/drinks/3.jpg'], 
                    ['name'=>'សឹង','supplier_id'=> 1, 'type_id'=> 2 , 'image'=>'menu/drinks/6.jpg'] ,  
                    ['name'=>'ABC','supplier_id'=> 1, 'type_id'=> 2 , 'image'=>'menu/drinks/4.jpg'] , 
                    ['name'=>'Ancher','supplier_id'=> 1, 'type_id'=> 2, 'image'=>'menu/drinks/5.jpg'],  
    
                ]
            );

            DB::table('stock')->insert(
                [
                    ['product_id'=> 1, 'branch_id'=> 2 ,'available_stock'=> 0], 
                    ['product_id'=> 2, 'branch_id'=> 2 ,'available_stock'=> 0], 
                    ['product_id'=> 3, 'branch_id'=> 2 , 'available_stock'=> 0], 
                    ['product_id'=> 4, 'branch_id'=> 2 , 'available_stock'=> 0] ,  
                    ['product_id'=> 5, 'branch_id'=> 2 , 'available_stock'=> 0] , 
                    ['product_id'=> 6, 'branch_id'=> 2, 'available_stock'=> 0],  
    
                ]
            );
    
        

      
	}
}
