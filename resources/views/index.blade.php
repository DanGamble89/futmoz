<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>FUTMoz</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
  </head>
  <body>
    <div id="app">
      @{{ $data|json }}
    </div>

    <script src="/js/vendor.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>
