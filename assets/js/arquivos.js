$(function() {
    var scntDiv = $('#p_scents');
    var i = $('#p_scents p').lenght + 1;

    $('#p').click (function() {
        alert("teste");

    });


    $('#addScnt').on('click', function() {
            $('<p id="#p"><label for="p_scnts"><input type="file" id="p_scnt" name="p_scnt_' + i +'" placeholder="Input Value" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
            i++;
            return false;
    });

    $('#remScnt').on('click', function() { 
            $(this).closest('#remScnt').remove();
    });
});