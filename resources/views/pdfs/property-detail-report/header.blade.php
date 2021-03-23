<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('/assets/pdfs/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/pdfs/sales.css') }}" />
    <style media="screen">
      h4 {
        margin-bottom: 0px;
      }
      hr {
        margin-top: 0px;
        margin-bottom: 1px;
      }
    </style>
  </head>
  <body>
    <div class="col-12">
      <h4><strong>Property Detail Report</strong></h4>
      <h5><strong>{{ $headerInfo['address'] ?? '' }}</strong></h5>
      <div class="row">
        <div class="col-6">
          <span>APN: {{ $headerInfo['apn'] ?? '' }}</span>
        </div>
        <div class="col-6 text-right">
          <span>{{ $headerInfo['county'] ?? '' }} County Data as of: {{ date('m/d/Y') }}</span>
        </div>
      </div>
    </div>
    <hr />
  </body>
</html>
