<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('/assets/pdfs/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/pdfs/sales.css') }}" />
    <script>
      function subst() {
        var vars = {};
        var x = document.location.search.substring(1).split("&");
        for (var i in x) {
          var z = x[i].split("=", 2);
          vars[z[0]] = unescape(z[1]);
        }
        var x = ["frompage", "topage", "page", "webpage", "section", "subsection", "subsubsection"];
        for (var i in x) {
          var y = document.getElementsByClassName(x[i]);
          for (var j = 0; j < y.length; ++j) y[j].textContent = vars[x[i]];
        }
      }
    </script>
  </head>
  <body onload="subst()">
    <hr color="grey" />
    <table class="col-12">
      <tr>
        <td width="150"><img src="{{ asset('images/logo2.png') }}" width="200px" alt="image" /></td>
        <td class="text-center">Copyright 2020 Equity Finders Pro. All Rights Reserved. A Data Miners LLC Company</td>
        <td class="text-right">Page <span class="page"></span> of <span class="topage"></span></td>
      </tr>
    </table>
  </body>
</html>
