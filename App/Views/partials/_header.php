<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>
    <?php
    if (isset($view_title) && !empty($view_title)) {
      echo $view_title;
    } else {
      echo 'Polise';
    }
    ?>
  </title>
<!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>

    body {
      font-family: Helvetica;
    }

    .content {
      max-width: 90%;
      margin: auto;
    }

    .error {
      color: red;
    }

    .input-group {
      margin-bottom: 20px;
      margin-top: 20px;
    }

    .input-label {
      width: 250px;
    }

    #addPerson {
      display: none;
      margin-bottom: 20px;
    }

    #addPerson, #submitButton {
      font: bold 12px Arial;
      text-decoration: none;
      background-color: #EEEEEE;
      color: #333333;
      padding: 4px 8px 4px 8px;
      border-top: 1px solid #CCCCCC;
      border-right: 1px solid #333333;
      border-bottom: 1px solid #333333;
      border-left: 1px solid #CCCCCC;
      cursor: pointer;
    }

    .remove-image {
      width: 10px;
      padding-left: 5px;
    }

    input {
      margin-bottom: 5px;
    }

    #additional-people-container {
      display: block;
    }


    /*** Show ***/
    .people-group {
      padding-top: 10px;
    }

    /*** Index ***/
    .arrow {
      width: 12px;
    }

    table, th, td {
      border: 1px solid lightgray;
      padding: 4px;
    }

    table {
      border-collapse: collapse;
    }


  </style>
</head>
<body>
<div class="content">