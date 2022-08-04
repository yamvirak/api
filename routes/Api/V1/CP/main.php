<?php

	$api->group(['namespace' => 'App\Api\V1\Controllers\CP'], function($api) {

		$api->get('/dashboard', 			    ['uses' => 'DashboardController@getInfo']);
		
		
		$api->get('/orders', 			        ['uses' => 'OrderController@listing']);
		$api->delete('/orders/{id}', 			['uses' => 'OrderController@delete']);

		$api->get('/pos/products', 				['uses' => 'POSController@getProducts']);
		$api->post('/pos/order', 				['uses' => 'POSController@makeOrder']);

		$api->get('/sales', 					['uses' => 'OrderController@listing']);
		$api->get('/sales/record', 				['uses' => 'OrderController@record']);
		$api->get('/sales/invoice/{id}', 		['uses' => 'OrderController@invoice']);
		$api->delete('/sales/{id}', 			['uses' => 'OrderController@delete']);

		//$api->get('/sales/report', 			['uses' => 'ReportController@report']);


		//===================>> Admin Only!!!! :(
		$api->group(['middleware' => 'onlyAdmin'], function($api) {

			$api->get('/branches', 			        ['uses' => 'BranchController@listing']);
			$api->get('/branches/{id}',		    	['uses' => 'BranchController@view']);
			$api->post('/branches', 			    ['uses' => 'BranchController@create']);
			$api->post('/branches/add-staff/{id}', 	['uses' => 'BranchController@addStaff']);
			$api->put('/branches/{id}',		    	['uses' => 'BranchController@update']);
			$api->delete('/branches/{id}',		    ['uses' => 'BranchController@delete']);

			$api->get('/expenses/types', 			['uses' => 'ExpenseTypeController@listing']);
			$api->post('/expenses/types', 			['uses' => 'ExpenseTypeController@create']);
			$api->put('/expenses/types/{id}', 		['uses' => 'ExpenseTypeController@update']);
			$api->delete('/expenses/types/{id}', 	['uses' => 'ExpenseTypeController@delete']);

			$api->get('/expenses', 					['uses' => 'ExpenseController@listing']);
			$api->post('/expenses', 				['uses' => 'ExpenseController@create']);
			$api->put('/expenses/{id}', 			['uses' => 'ExpenseController@update']);
			$api->delete('/expenses/{id}', 			['uses' => 'ExpenseController@delete']);

			$api->get('/income/types', 				['uses' => 'IncomeTypeController@listing']);
			$api->post('/income/types', 			['uses' => 'IncomeTypeController@create']);
			$api->put('/income/types/{id}', 		['uses' => 'IncomeTypeController@update']);
			$api->delete('/income/types/{id}', 		['uses' => 'IncomeTypeController@delete']);

			$api->get('/income', 					['uses' => 'IncomeController@listing']);
			$api->post('/income', 					['uses' => 'IncomeController@create']);
			$api->put('/income/{id}', 				['uses' => 'IncomeController@update']);
			$api->delete('/income/{id}', 			['uses' => 'IncomeController@delete']);

			$api->get('/products/types', 			['uses' => 'ProductTypeController@listing']);
			$api->post('/products/types', 			['uses' => 'ProductTypeController@create']);
			$api->put('/products/types/{id}', 		['uses' => 'ProductTypeController@update']);
			$api->delete('/products/types/{id}', 	['uses' => 'ProductTypeController@delete']);

			$api->get('/products', 					['uses' => 'ProductController@listing']);
			$api->post('/products', 				['uses' => 'ProductController@create']);
			$api->put('/products/{id}', 			['uses' => 'ProductController@update']);
			$api->put('/products/stock/{id}', 		['uses' => 'ProductController@addStock']);
			$api->delete('/products/{id}', 			['uses' => 'ProductController@delete']);

			$api->get('/supplier', 					['uses' => 'SupplierController@listing']);
			$api->post('/supplier', 				['uses' => 'SupplierController@create']);
			$api->put('/supplier/{id}', 			['uses' => 'SupplierController@update']);
			$api->delete('/supplier/{id}', 			['uses' => 'SupplierController@delete']);

			$api->get('/customer', 					['uses' => 'CustomerController@listing']);
			$api->post('/customer', 				['uses' => 'CustomerController@create']);
			$api->put('/customer/{id}', 			['uses' => 'CustomerController@update']);
			$api->delete('/customer/{id}', 			['uses' => 'CustomerController@delete']);


			$api->get('/users', 						['uses' => 'UserController@listing']);
			$api->post('/users/{id}/change-password',   ['uses' => 'UserController@changePassword']);
			
		});

		

	});