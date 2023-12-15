fetch('./API.php')
.then(function(response) {
  return response.json();
})
.then(function(json) {
    itemJSON=json;
    console.log(itemJSON);
}
)
//console.log(itemJSON);
