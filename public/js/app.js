$(document).ready(function () {
    $("#clearImgArticulo").hide();
    $('#imagenArticulo').change(function () {
        $("#prevArt").html('');
        for (var i = 0; i < $(this)[0].files.length; i++) {
            $("#prevArt").append('<img src="' + window.URL.createObjectURL(this.files[i]) + '" width="300" />');
        }
        $("#clearImgArticulo").show();
    });

    $("#clearImgArticulo").click(function () {
        $("#prevArt").html('');
        $("#imagenArticulo").val('');
        $("#clearImgArticulo").hide();
    });

    /*--producto-*/
    $("#clearImgProducto").hide();
    $('#imagenProducto').change(function () {
        $("#prevProd").html('');
        for (var i = 0; i < $(this)[0].files.length; i++) {
            $("#prevProd").append('<img src="' + window.URL.createObjectURL(this.files[i]) + '" width="150" />');
        }
        $("#clearImgProducto").show();
    });

    $("#clearImgProducto").click(function () {
        $("#prevProd").html('');
        $("#imagenProducto").val('');
        $("#clearImgProducto").hide();
    });
});