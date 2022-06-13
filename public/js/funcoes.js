var loadFile = function(event) {
    var foto = document.getElementById('output');
    foto.src = URL.createObjectURL(event.target.files[0]);
  };