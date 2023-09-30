import Resumable from ' ../../resumablejs/resumable.js';

document.addEventListener('DOMContentLoaded', function () {
    const resumable = new Resumable({
        target: '/upload', // Rota onde os chunks serão enviados
        chunkSize: 10 * 1024 * 1024, // Tamanho de cada chunk (10 MB neste exemplo)
        simultaneousUploads: 4, // Número de chunks enviados simultaneamente
        fileParameterName: 'file', // Nome do campo que contém o arquivo
        query: {
            _token: 'seu-token-csrf', // Token CSRF, se necessário
        },
    });

    // Evento para adicionar um arquivo ao Resumable.js
    resumable.assignBrowse(document.getElementById('fileInput'));

    // Evento para quando um arquivo é adicionado
    resumable.on('fileAdded', function (file) {
        // Adicione o arquivo à lista de uploads pendentes
        // Exiba informações sobre o arquivo, como nome e tamanho
    });

    // Evento para atualizar o progresso do upload
    resumable.on('fileProgress', function (file) {
        // Atualize a barra de progresso ou exiba informações sobre o progresso
    });

    // Evento para quando o upload de um arquivo é concluído
    resumable.on('fileSuccess', function (file, message) {
        // O upload do arquivo foi bem-sucedido
    });

    // Evento para lidar com erros de upload
    resumable.on('fileError', function (file, message) {
        // Ocorreu um erro durante o upload
    });

    // Evento para quando todos os uploads são concluídos
    resumable.on('complete', function () {
        // Todos os uploads foram concluídos com sucesso
    });

    // Inicie o upload manualmente (por exemplo, quando o usuário pressiona um botão)
    document.getElementById('startUploadButton').addEventListener('click', function () {
        resumable.upload();
    });
});
