$(document).ready(function() {
    const imageUrl = 'sua-imagem.jpg'; // Substitua pelo caminho da sua imagem

    // Define as posições das peças no grid 3x3
    const piecePositions = [
        { left: 0, top: 0 },
        { left: -100, top: 0 },
        { left: -200, top: 0 },
        { left: 0, top: -100 },
        { left: -100, top: -100 },
        { left: -200, top: -100 },
        { left: 0, top: -200 },
        { left: -100, top: -200 },
        { left: -200, top: -200 }
    ];

    // Inicializa as peças e embaralha a posição delas
    const pieces = $('.puzzle-piece');
    
    // Função para embaralhar as peças no início
    function shufflePieces() {
        // Embaralha as peças na tela, com uma posição aleatória
        pieces.each(function(index) {
            $(this).css({
                'background-image': 'url(' + imageUrl + ')',
                'background-position': piecePositions[index].left + 'px ' + piecePositions[index].top + 'px',
            });

            // Posição inicial aleatória para as peças dentro de uma área delimitada
            const randomX = Math.floor(Math.random() * (400 - 50)) + 50; // posição aleatória X
            const randomY = Math.floor(Math.random() * (400 - 50)) + 50; // posição aleatória Y

            $(this).css({
                'position': 'absolute',
                'top': randomY + 'px',
                'left': randomX + 'px'
            }).draggable({
                revert: 'invalid' // A peça volta para a posição original apenas se for colocada em uma área inválida
            });
        });
    }

    shufflePieces(); // Embaralha as peças ao carregar a página

    // Torna as áreas de drop interativas
    $('.drop-area').each(function(index) {
        $(this).droppable({
            accept: '.puzzle-piece',
            drop: function(event, ui) {
                const droppedPiece = ui.helper;
                const pieceId = droppedPiece.attr('id');
                
                // Verifica se a peça foi colocada na área correta
                if (pieceId === 'piece' + (index + 1)) {
                    // Move a peça diretamente para a posição correta na área de drop
                    $(this).append(droppedPiece);
                    droppedPiece.css({
                        position: 'relative', // Fixar a posição dentro da área de drop
                        top: 0,
                        left: 0
                    });

                    // Desabilita a área de drop, para que não seja reutilizada
                    $(this).droppable('disable');
                    updateScore(); // Atualiza a pontuação
                }
            }
        });
    });

    // Atualiza a pontuação
    let score = 0;
    function updateScore() {
        score++;
        $('#score').text('Acertos: ' + score + '/9');

        // Verifica se o jogo foi completado
        if (score === 9) {
            $('#congratulations').fadeIn(); // Exibe a mensagem de congratulações
        }
    }
});
