<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		.searchForm{
			display: block;
			margin: 0 auto;
			right: 0;
			left: 0;
			background-color: ;
			width: 400px;
			position: absolute;
		}

		input[type=search]{
			width: 335px;
			height: 35px;
			border-radius: -10px;
			border: 1px solid #900;
			border: 0px;
			border-bottom: 1px solid #666;
			border-left: 1px solid #666;
			border-right: 1px solid #666;
		}

		.searchBTN{
			height: 35px;
			border: 1px solid #666;
			font-family: arial;
			font-weight: bold;
			font-style: italic;
			border-bottom: 0px;
			background-color: white;
			margin-top: 10px;
		}

		.searchBTN:hover{
			background-color: #fff;
		}

		@media only screen and (max-width: 400px) {
			.searchForm{
			width: 100%;
		}
		}

	</style>
</head>
<body>
	<form id="" class="searchForm">
		<input type="search" name="search">
		<button class="searchBTN">Search</button>
	</form>
</body>
</html>