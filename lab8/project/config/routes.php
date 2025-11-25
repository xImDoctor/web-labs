<?php
use \Core\Route;

return [
	// HelloController routes
	new Route('/', 'hello', 'index'),
	new Route('/hello/', 'hello', 'index'),

	// TestController routes
	new Route('/test/act1/', 'test', 'act1'),
	new Route('/test/act2/', 'test', 'act2'),
	new Route('/test/act3/', 'test', 'act3'),

	// NumController routes
	new Route('/nums/:n1/:n2/:n3/', 'num', 'sum'),

	// PageController routes
	new Route('/pages/', 'page', 'all'),
	new Route('/page/array/:id/', 'page', 'showFromArray'),
	new Route('/page/test/', 'page', 'test'),
	new Route('/page/:id/', 'page', 'one'),

	// ProductController routes
	new Route('/products/all/', 'product', 'all'),
	new Route('/product/:n/', 'product', 'show'),
	new Route('/products/db/', 'product', 'allFromDb'),
	new Route('/product/db/:id/', 'product', 'showFromDb'),

	// UserController routes
	new Route('/user/all/', 'user', 'all'),
	new Route('/user/first/:n/', 'user', 'first'),
	new Route('/user/:id/:key/', 'user', 'info'),
	new Route('/user/:id/', 'user', 'show'),

	// Legacy routes (can be removed)
	new Route('/my-page1/', 'page', 'show1'),
	new Route('/my-page2/', 'page', 'show2'),
];

