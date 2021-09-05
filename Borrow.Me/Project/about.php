<?php require 'header.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
<style>
body {
  font-family: Arial, Helvetica, sans-serif !important;
  margin: 0 !important;
  background-color: ;
}

html {
  box-sizing: border-box !important;
}

*, *:before, *:after {
  box-sizing: inherit !important;
}

.navbar {
  margin: 0;
  border-radius: 0px;
      
}

.column {
  float: left !important;
  width: 50% !important;
  margin-bottom: 16px !important;
  background-color: ;

}

.card {
  background-color: inherit;
  margin: 8px !important;
}

.about-section {
  padding: 15px !important;
  text-align: center !important;
  background-color: #474e5d !important;
  color: white !important;
}

.container {
  padding: 0 16px !important;
}

.container::after, .row::after {
  content: "" !important;
  clear: both !important;
  display: table !important;
}

.row{
  width: 75%;
  display: block;
  margin: 0 auto;
}

.title {
  color: grey !important;
}

.button {
  border: none !important;
  outline: 0 !important;
  display: block !important;
  padding: 8px !important;
  color: white !important;
  background-color: #000 !important;
  text-align: center !important;
  cursor: pointer !important;
  position: relative;
  width: inherit !important;
  margin: 0 auto;
}

.button:hover {
  background-color: #555 !important;
}




@media screen and (max-width: 650px) {
  .column {
    width: 100% !important;
    display: block !important;
  }
}
</style>
</head>
<body>

<div class="about-section">
  <h1>About Us</h1>
  <p>Some text about who we are and what we do.</p>
</div>

<h2 style="text-align:center">The Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="/images/abed.jpg" alt="" style="background-color: whitesmoke;width:100%;height: 100%;display:block;margin: 0 auto;">
      <div class="container">
        <h2>Abdulrahman Tawffeq</h2>
        <p class="title">Designer</p>
        <p>Some text that describes me.</p>
        <p>Abdulrahman@example.com</p>
        
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="/images/muhammed.jpg" alt="" style="background-color: whitesmoke;width:100%;height: 100%;display:block;margin: 0 auto;">
      <div class="container">
        <h2>Muhammed Salahadin</h2>
        <p class="title">Developer</p>
        <p>Some text that describes me.</p>
        <p>Muhammed@example.com</p>
        
      </div>
    </div>
  </div>
  
</div>

</body>
</html>