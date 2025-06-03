$(document).ready(function () {
    // Detectar clic en el botón de hamburguesa
    $('#nav-toggle').click(function () {
        $('#nav').toggleClass('open');
    });

    // Opcional: cerrar el sidebar cuando se haga clic en un enlace (en móviles)
    $('.nav__link').click(function () {
        if ($(window).width() < 768) {
            $('#nav').removeClass('open');
        }
    });
});
