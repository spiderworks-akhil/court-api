<!--
 API Documentation HTML Template  - 1.0.1
 Copyright © 2016 Florian Nicolas
 Licensed under the MIT license.
 https://github.com/ticlekiwi/API-Documentation-HTML-Template
 !-->
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>API - Documentation</title>
    <meta name="description" content="">
    <meta name="author" content="ticlekiwi">

    <meta http-equiv="cleartype" content="on">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('doc-assets')}}/css/hightlightjs-dark.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,500|Source+Code+Pro:300" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('doc-assets')}}/css/style.css" media="all">
    <script>hljs.initHighlightingOnLoad();</script>
</head>

<body>
<div class="left-menu">
    <div class="content-logo">
        <img alt="platform by Emily van den Heever from the Noun Project" title="platform by Emily van den Heever from the Noun Project" src="https://www.spiderworks.in/wp-content/uploads/2020/09/spiderworks-logo-1.png" height="32" />
        <span>API Documentation</span>
    </div>
    <div class="content-menu">
        @include('documentation.include.menu')
    </div>
</div>
<div class="content-page">
    <div class="content-code"></div>
    <div class="content">
        <div class="overflow-hidden content-section" id="content-get-started">
            <h1 id="get-started">Get started</h1>
            <pre>
    API Endpoint

        https://api.spiderworks.co.in/playtime/
                </pre>
            <p>
                The Playtime API provides programmatic access to read court booking app details. Retrieve a user, courts, booking etc.
            </p>
        </div>
        <div class="overflow-hidden content-section" id="content-get-characters">
            <h2 id="get-characters">get characters</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://api.westeros.com/character/get \
-F 'secret_key=your_api_key' \
-F 'house=Stark,Bolton' \
-F 'offset=0' \
-F 'limit=50'
                </code></pre>
            <p>
                To get characters you need to make a POST call to the following url :<br>
                <code class="higlighted">http://api.westeros.com/character/get</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
  query:{
    offset: 0,
    limit: 50,
    house: [
      "Stark",
      "Bolton"
    ],
  }
  result: [
    {
      id: 1,
      first_name: "Jon",
      last_name: "Snow",
      alive: true,
      house: "Stark",
      gender: "m",
      age: 14,
      location: "Winterfell"
    },
    {
      id: 2,
      first_name: "Eddard",
      last_name: "Stark",
      alive: false,
      house: "Stark",
      gender: "m",
      age: 35,
      location: 'Winterfell'
    },
    {
      id: 3,
      first_name: "Catelyn",
      last_name: "Stark",
      alive: false,
      house: "Stark",
      gender: "f",
      age: 33,
      location: "Winterfell"
    },
    {
      id: 4,
      first_name: "Roose",
      last_name: "Bolton",
      alive: false,
      house: "Bolton",
      gender: "m",
      age: 40,
      location: "Dreadfort"
    },
    {
      id: 5,
      first_name: "Ramsay",
      last_name: "Snow",
      alive: false,
      house: "Bolton",
      gender: "m",
      age: 15,
      location: "Dreadfort"
    },
  ]
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>secret_key</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>search</td>
                    <td>String</td>
                    <td>(optional) A search word to find character by name.</td>
                </tr>
                <tr>
                    <td>house</td>
                    <td>String</td>
                    <td>
                        (optional) a string array of houses:
                    </td>
                </tr>
                <tr>
                    <td>alive</td>
                    <td>Boolean</td>
                    <td>
                        (optional) a boolean to filter alived characters
                    </td>
                </tr>
                <tr>
                    <td>gender</td>
                    <td>String</td>
                    <td>
                        (optional) a string to filter character by gender:<br>
                        m: male<br>
                        f: female
                    </td>
                </tr>
                <tr>
                    <td>offset</td>
                    <td>Integer</td>
                    <td>(optional - default: 0) A cursor for use in pagination. Pagination starts offset the specified offset.</td>
                </tr>
                <tr>
                    <td>limit</td>
                    <td>Integer</td>
                    <td>(optional - default: 10) A limit on the number of objects to be returned, between 1 and 100.</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="overflow-hidden content-section" id="content-errors">
            <h2 id="errors">Errors</h2>
            <p>
                The Westeros API uses the following error codes:
            </p>
            <table>
                <thead>
                <tr>
                    <th>Error Code</th>
                    <th>Meaning</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>X000</td>
                    <td>
                        Some parameters are missing. This error appears when you don't pass every mandatory parameters.
                    </td>
                </tr>
                <tr>
                    <td>X001</td>
                    <td>
                        Unknown or unvalid <code class="higlighted">secret_key</code>. This error appears if you use an unknow API key or if your API key expired.
                    </td>
                </tr>
                <tr>
                    <td>X002</td>
                    <td>
                        Unvalid <code class="higlighted">secret_key</code> for this domain. This error appears if you use an  API key non specified for your domain. Developper or Universal API keys doesn't have domain checker.
                    </td>
                </tr>
                <tr>
                    <td>X003</td>
                    <td>
                        Unknown or unvalid user <code class="higlighted">token</code>. This error appears if you use an unknow user <code class="higlighted">token</code> or if the user <code class="higlighted">token</code> expired.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="content-code"></div>
</div>

<script src="{{asset('doc-assets')}}/js/script.js"></script>
</body>
</html>