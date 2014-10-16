binary data should be base64 encoded

format json

PUT request
api/
{"string" : "text"}
{"binary" : "base64 encoded data"}

GET request
api/?search=keyword
[router may be improved to make request like api/keyword]


console app poster.php - simple curl wrapper

usage example
php poster.php PUT http://localhost/http-api-test-task/api/ {\"string\"\:\"bbbbbbbb\"}
php poster.php GET http://localhost/http-api-test-task/api/?search=bb
