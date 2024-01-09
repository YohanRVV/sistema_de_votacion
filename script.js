$(document).ready(function () {
    var comuna = $('#id_city');

    $('#id_region').change(function () {
      var id_region = $(this).val();

      $.ajax({
        data: { id_region: id_region },
        dataType: 'html',
        type: 'POST',
        url: 'get_comunas.php',

      }).done(function (data) {
        comuna.html(data);
      });

    });

});


$(document).ready(function() {
  $('#miFormulario').submit(function() {
      var errores = '';
      
      // Obtener los valores de los campos y elementos
      var nombre = $('#name').val().trim();
      var alias = $('#alias').val().trim();
      var rut = $('#rut').val().trim();
      var email = $('#email').val().trim();
      var region = $('#id_region').val();
      var candidato = $('#candidato').val();
      var checked = $('input[name="fuente[]"]:checked').length;

      // Validaciones
      if (nombre === '') {
          errores += 'Por favor, ingrese su nombre.\n';
      }
      if (alias.length <= 5 || !alias.match(/[a-z]/i) || !alias.match(/\d/)) {
          errores += 'El alias debe tener más de 5 caracteres e incluir letras y números.\n';
      }
      if (!validarRUT(rut)) {
          errores += 'Por favor, ingrese un RUT válido.\n';
      }
      if (!validarEmail(email)) {
          errores += 'Por favor, ingrese un correo electrónico válido.\n';
      }
      if (region === '') {
          errores += 'Por favor, seleccione una región.\n';
      }
      if (candidato === '') {
          errores += 'Por favor, seleccione un candidato.\n';
      }
      if (checked < 2) {
          errores += 'Seleccione al menos dos opciones de cómo se enteró de nosotros.\n';
      }

      // Mostrar alerta si hay errores
      if (errores != '') {
          alert(errores);
          return false; // Previene el envío del formulario
      }

      return true; // Permite el envío del formulario
  });
});

function validarRUT(rut) {
  // Implementa la validación del RUT aquí
  var re = /^[0-9]+-[0-9kK]$/;
  return re.test(rut);
}

function validarEmail(email) {
  var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  return re.test(email);
}
