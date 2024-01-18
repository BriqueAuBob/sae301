$(document).ready(function(){
    // Trouver toutes les cartes
    const cards = document.querySelectorAll('[data-color-modal]');
    // Pour chaque carte
    cards.forEach((card) => {

        let colorBackground = '#'+$(card).data('color-modal');
        let modalId = $(card).data('modal-colorid');

        function hexToRgb(hex){
            let rgb = [];
            for(let i=1; i<7; i+=2){
                rgb.push(parseInt(hex.substr(i,2),16));
            }
            return rgb;
        }

        // Vérifier si la couleur est claire ou foncée
        function isLight(color){
            let r = color[0], g = color[1], b = color[2];
            let l = (r*299 + g*587 + b*114) / 1000;
            return l > 128;
        }
        let cardTitle = document.getElementsByClassName('cardTitle-'+modalId);
        console.log($(cardTitle));
        function colorSetter(){
            let target = $(cardTitle);
            if(isLight(hexToRgb(colorBackground)) === true){
                target.addClass('text-dark');
                target.removeClass('text-white');
            }else{
                target.addClass('text-white');
                target.removeClass('text-dark');
            }
        }
        colorSetter();
    })
})