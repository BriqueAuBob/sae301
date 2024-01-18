$(document).ready(function(){
    function TextContrast(hexColor){
        var r = parseInt(hexColor.substr(1,2),16);
        var g = parseInt(hexColor.substr(3,2),16);
        var b = parseInt(hexColor.substr(5,2),16);
        var yiq = ((r*299)+(g*587)+(b*114))/1000;
        console.log((yiq >= 128) ? 'black' : 'white');
        colorSetter((yiq >= 128) ? 'black' : 'white');
    }
    function colorSetter(color){
    if(color === 'white'){
        $('.cardTitle').addClass('text-white');
        $('.cardTitle').removeClass('text-black');
    }else {
        $('.cardTitle').addClass('text-black');
        $('.cardTitle').removeClass('text-white');
    }
}

    $('#titleCardColor').each(function(){
        var color = $(this).data('color');
        TextContrast(color);
    });
})
