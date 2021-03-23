<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('/assets/pdfs/bootstrap.min.css') }}" />
    <style media="screen">
      h4 {
        margin-bottom: 0px;
      }
      hr {
        margin-top: 1px;
        margin-bottom: 1px;
      }

      body {
        font-size: 14px;
        font-style: normal;
        font-variant: normal;
        font-weight: 400;
        font-family: 'Roboto', 'Open Sans', sans-serif;
        line-height: 17px;
        color: #444444;
      }
    </style>
  </head>
  <body>
    <div class="col-12">
      <h4><strong>Sales Comparables</strong></h4>
      <h5><strong>{{ $headerInfo['address'] ?? '' }}</strong></h5>
      <div class="row">
        <div class="col-6">
          <span>APN: {{ $headerInfo['apn'] ?? '' }}</span>
        </div>
        <div class="col-6 text-right">
          <span>{{ $headerInfo['county'] ?? '' }} County Data as of: {{ date('m/d/Y') }}</span>
        </div>
      </div>
      <hr />
    </div>
  </body>
</html>
