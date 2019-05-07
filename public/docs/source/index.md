---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/crowdfundingToolbox/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_f7b7ea397f8939c8bb93e6cab64603ce -->
## Display Swagger API page.

> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/api/documentation" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/documentation");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
null
```

### HTTP Request
`GET api/documentation`


<!-- END_f7b7ea397f8939c8bb93e6cab64603ce -->

<!-- START_1ead214f30a5e235e7140eb2aaa29eee -->
## Dump api-docs.json content endpoint.

> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/docs/{jsonFile?}" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/docs/{jsonFile?}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (500):

```json
{
    "message": "File does not exist at path D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\storage\\api-docs\/1",
    "exception": "Illuminate\\Contracts\\Filesystem\\FileNotFoundException",
    "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Filesystem\\Filesystem.php",
    "line": 41,
    "trace": [
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Facades\\Facade.php",
            "line": 237,
            "function": "get",
            "class": "Illuminate\\Filesystem\\Filesystem",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\darkaonline\\l5-swagger\\src\\Http\\Controllers\\SwaggerController.php",
            "line": 33,
            "function": "__callStatic",
            "class": "Illuminate\\Support\\Facades\\Facade",
            "type": "::"
        },
        {
            "function": "docs",
            "class": "L5Swagger\\Http\\Controllers\\SwaggerController",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php",
            "line": 54,
            "function": "call_user_func_array"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php",
            "line": 45,
            "function": "callAction",
            "class": "Illuminate\\Routing\\Controller",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php",
            "line": 219,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\ControllerDispatcher",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php",
            "line": 176,
            "function": "runController",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 682,
            "function": "run",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 684,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 659,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 625,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 614,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php",
            "line": 176,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\fideloper\\proxy\\src\\TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode.php",
            "line": 62,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php",
            "line": 151,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php",
            "line": 116,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseStrategies\\ResponseCallStrategy.php",
            "line": 275,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseStrategies\\ResponseCallStrategy.php",
            "line": 259,
            "function": "callLaravelRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseStrategies\\ResponseCallStrategy.php",
            "line": 36,
            "function": "makeApiCall",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseResolver.php",
            "line": 49,
            "function": "__invoke",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseResolver.php",
            "line": 68,
            "function": "resolve",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\Generator.php",
            "line": 57,
            "function": "getResponse",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Commands\\GenerateDocumentation.php",
            "line": 201,
            "function": "processRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\Generator",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Commands\\GenerateDocumentation.php",
            "line": 59,
            "function": "processRoutes",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "function": "handle",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php",
            "line": 29,
            "function": "call_user_func_array"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php",
            "line": 87,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php",
            "line": 31,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php",
            "line": 572,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php",
            "line": 183,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Command\\Command.php",
            "line": 255,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php",
            "line": 170,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Application.php",
            "line": 901,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Application.php",
            "line": 262,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Application.php",
            "line": 145,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php",
            "line": 89,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php",
            "line": 122,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```

### HTTP Request
`GET docs/{jsonFile?}`

`POST docs/{jsonFile?}`

`PUT docs/{jsonFile?}`

`PATCH docs/{jsonFile?}`

`DELETE docs/{jsonFile?}`

`OPTIONS docs/{jsonFile?}`


<!-- END_1ead214f30a5e235e7140eb2aaa29eee -->

<!-- START_1a23c1337818a4de9e417863aebaca33 -->
## docs/asset/{asset}
> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/docs/asset/{asset}" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/docs/asset/{asset}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (500):

```json
{
    "message": "(1) - this L5 Swagger asset is not allowed",
    "exception": "L5Swagger\\Exceptions\\L5SwaggerException",
    "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\darkaonline\\l5-swagger\\src\\helpers.php",
    "line": 37,
    "trace": [
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\darkaonline\\l5-swagger\\src\\Http\\Controllers\\SwaggerAssetController.php",
            "line": 12,
            "function": "swagger_ui_dist_path"
        },
        {
            "function": "index",
            "class": "L5Swagger\\Http\\Controllers\\SwaggerAssetController",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php",
            "line": 54,
            "function": "call_user_func_array"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php",
            "line": 45,
            "function": "callAction",
            "class": "Illuminate\\Routing\\Controller",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php",
            "line": 219,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\ControllerDispatcher",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php",
            "line": 176,
            "function": "runController",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 682,
            "function": "run",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 684,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 659,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 625,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php",
            "line": 614,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php",
            "line": 176,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\fideloper\\proxy\\src\\TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode.php",
            "line": 62,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php",
            "line": 151,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php",
            "line": 116,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseStrategies\\ResponseCallStrategy.php",
            "line": 275,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseStrategies\\ResponseCallStrategy.php",
            "line": 259,
            "function": "callLaravelRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseStrategies\\ResponseCallStrategy.php",
            "line": 36,
            "function": "makeApiCall",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseResolver.php",
            "line": 49,
            "function": "__invoke",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseStrategies\\ResponseCallStrategy",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\ResponseResolver.php",
            "line": 68,
            "function": "resolve",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Tools\\Generator.php",
            "line": 57,
            "function": "getResponse",
            "class": "Mpociot\\ApiDoc\\Tools\\ResponseResolver",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Commands\\GenerateDocumentation.php",
            "line": 201,
            "function": "processRoute",
            "class": "Mpociot\\ApiDoc\\Tools\\Generator",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\mpociot\\laravel-apidoc-generator\\src\\Commands\\GenerateDocumentation.php",
            "line": 59,
            "function": "processRoutes",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "function": "handle",
            "class": "Mpociot\\ApiDoc\\Commands\\GenerateDocumentation",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php",
            "line": 29,
            "function": "call_user_func_array"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php",
            "line": 87,
            "function": "Illuminate\\Container\\{closure}",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php",
            "line": 31,
            "function": "callBoundMethod",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php",
            "line": 572,
            "function": "call",
            "class": "Illuminate\\Container\\BoundMethod",
            "type": "::"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php",
            "line": 183,
            "function": "call",
            "class": "Illuminate\\Container\\Container",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Command\\Command.php",
            "line": 255,
            "function": "execute",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php",
            "line": 170,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Command\\Command",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Application.php",
            "line": 901,
            "function": "run",
            "class": "Illuminate\\Console\\Command",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Application.php",
            "line": 262,
            "function": "doRunCommand",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\symfony\\console\\Application.php",
            "line": 145,
            "function": "doRun",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php",
            "line": 89,
            "function": "run",
            "class": "Symfony\\Component\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php",
            "line": 122,
            "function": "run",
            "class": "Illuminate\\Console\\Application",
            "type": "->"
        },
        {
            "file": "D:\\PROJECTS\\xampp2\\htdocs\\crowdfundingToolbox\\artisan",
            "line": 37,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Console\\Kernel",
            "type": "->"
        }
    ]
}
```

### HTTP Request
`GET docs/asset/{asset}`


<!-- END_1a23c1337818a4de9e417863aebaca33 -->

<!-- START_a2c4ea37605c6d2e3c93b7269030af0a -->
## Display Oauth2 callback pages.

> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/api/oauth2-callback" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/oauth2-callback");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
null
```

### HTTP Request
`GET api/oauth2-callback`


<!-- END_a2c4ea37605c6d2e3c93b7269030af0a -->

<!-- START_0292acd41f8aa43f920264170424fe1a -->
## api/backoffice/login
> Example request:

```bash
curl -X POST "http://localhost/crowdfundingToolbox/api/backoffice/login" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/backoffice/login`


<!-- END_0292acd41f8aa43f920264170424fe1a -->

<!-- START_19a6cab27d913baf46ae02d84ac5d05e -->
## api/backoffice/register
> Example request:

```bash
curl -X POST "http://localhost/crowdfundingToolbox/api/backoffice/register" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/register");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/backoffice/register`


<!-- END_19a6cab27d913baf46ae02d84ac5d05e -->

<!-- START_55c8afac96b01252b1990674fc3c982e -->
## api/backoffice/logout
> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/api/backoffice/logout" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/logout");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "status": "Authorization Token not found"
}
```

### HTTP Request
`GET api/backoffice/logout`


<!-- END_55c8afac96b01252b1990674fc3c982e -->

<!-- START_2bbf9582b3bbf76293c9f48444496ee0 -->
## api/backoffice/remove-user
> Example request:

```bash
curl -X DELETE "http://localhost/crowdfundingToolbox/api/backoffice/remove-user" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/remove-user");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/backoffice/remove-user`


<!-- END_2bbf9582b3bbf76293c9f48444496ee0 -->

<!-- START_34ec8095583085ed1044559f99507b28 -->
## api/backoffice/users
> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/api/backoffice/users" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/users");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "status": "Authorization Token not found"
}
```

### HTTP Request
`GET api/backoffice/users`


<!-- END_34ec8095583085ed1044559f99507b28 -->

<!-- START_621eeba0529eae8d98aff389046beba0 -->
## api/backoffice/crowdfunding-settings
> Example request:

```bash
curl -X PUT "http://localhost/crowdfundingToolbox/api/backoffice/crowdfunding-settings" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/crowdfunding-settings");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/backoffice/crowdfunding-settings`


<!-- END_621eeba0529eae8d98aff389046beba0 -->

<!-- START_e50f4ec1addd98814580eeb3c5f21b8e -->
## api/backoffice/campaigns
> Example request:

```bash
curl -X POST "http://localhost/crowdfundingToolbox/api/backoffice/campaigns" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/campaigns");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/backoffice/campaigns`


<!-- END_e50f4ec1addd98814580eeb3c5f21b8e -->

<!-- START_d32d27d9e3477089ebe42364c6ab033e -->
## api/backoffice/campaigns/{id}
> Example request:

```bash
curl -X PUT "http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/backoffice/campaigns/{id}`


<!-- END_d32d27d9e3477089ebe42364c6ab033e -->

<!-- START_7b4870c9700a396a8445ac975941ac90 -->
## api/backoffice/campaigns/{id}/smart-settings
> Example request:

```bash
curl -X PUT "http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}/smart-settings" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}/smart-settings");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/backoffice/campaigns/{id}/smart-settings`


<!-- END_7b4870c9700a396a8445ac975941ac90 -->

<!-- START_39fbb7a81d19180e1dd0e68caa3018f1 -->
## api/backoffice/campaigns/all
> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/api/backoffice/campaigns/all" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/campaigns/all");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "status": "Authorization Token not found"
}
```

### HTTP Request
`GET api/backoffice/campaigns/all`


<!-- END_39fbb7a81d19180e1dd0e68caa3018f1 -->

<!-- START_4a9900562d694563fa727f17829bbd09 -->
## api/backoffice/campaigns/{id}
> Example request:

```bash
curl -X GET -G "http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "status": "Authorization Token not found"
}
```

### HTTP Request
`GET api/backoffice/campaigns/{id}`


<!-- END_4a9900562d694563fa727f17829bbd09 -->

<!-- START_77e82f89f8bbc8eafa263a97134d3d96 -->
## api/backoffice/campaigns/{id}
> Example request:

```bash
curl -X DELETE "http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/campaigns/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/backoffice/campaigns/{id}`


<!-- END_77e82f89f8bbc8eafa263a97134d3d96 -->

<!-- START_dd3210737b1b7f0680814281a22abecc -->
## api/backoffice/upload
> Example request:

```bash
curl -X POST "http://localhost/crowdfundingToolbox/api/backoffice/upload" 
```

```javascript
const url = new URL("http://localhost/crowdfundingToolbox/api/backoffice/upload");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/backoffice/upload`


<!-- END_dd3210737b1b7f0680814281a22abecc -->


