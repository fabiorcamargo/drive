<style>

</style>

<x-app-layout>
    <div class="container mx-auto pt-8 ">
        <div class="card w-full bg-base-100 shadow-xl">
            {{--<figure class="pt-8 "><img class=' w-24 ' src="{{asset('Logo Vetorial.svg')}}" alt="logo" /></figure>--}}
            <div class="card-body">
                <h2 class="card-title">Gerenciamento de arquivos!</h2>
                {{--<p>If a dog chews shoes whose shoes does he choose?</p>--}}
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Status</th>
                                {{--<th>Favorite Color</th>--}}
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                            <!-- rows -->
                            <input type="checkbox" id="my_modal{{ $file->name }}" class="modal-toggle" />
                            {{--<div class="modal">
                                <div class="modal-box">
                                    <video id="do-video{{ $file->name }}" controls></video>
                                </div>
                                <label class="modal-backdrop" for="my_modal{{ $file->name }}" onclick="pauseVideo('{{ $file->name }}')">Close</label>
                            </div>--}}
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <div class="font-bold">{{ $file->name }}</div>

                                            {{--<div class="text-sm opacity-50">United States</div>--}}
                                        </div>
                                    </div>
                                </td>
                                {{--<td>
                                    <article class="prose">
                                        <p>
                                            But a recent study shows that the celebrated appetizer may be linked to a
                                            series of rabies cases
                                            springing up around the country.
                                        </p>
                                        <!-- ... -->
                                    </article>
                                </td>--}}
                                <td>
                                    @if($file->status == 'Pendente')
                                    <div class="badge badge-warning badge-outline">{{$file->status}}</div>
                                    @elseif($file->status == 'Concluído')
                                    <div class="badge badge-success badge-outline">{{$file->status}}</div>
                                    @endif
                                </td>
                                <th>
                                    <div class="join">
                                        {{--<div class="join-item tooltip" data-tip="Reproduzir">
                                            <label for="my_modal{{ $file->name }}" class="btn btn-square btn-success" onclick="loadVideo('{{ $file->name }}')">
                                                <x-feathericon-play-circle />
                                            </label>
                                        </div>--}}
                                        <div class="join-item tooltip" data-tip="Download">
                                            <a href="{{ route('files.download', $file->name) }}"
                                                class="btn btn-square btn-info">
                                                <x-feathericon-download-cloud />
                                            </a>
                                        </div>

                                        <div class="join-item tooltip" data-tip="Excluir">
                                            <form action="{{ route('files.delete', ['id' => $file->id, 'name' => $file->name]) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-square btn-error">
                                                    <x-feathericon-x />
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form id='upload' action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data"
                    class="mt-2">
                    @csrf

                    <div class="join flex justify-between pt-8">
                        <div class="card-body">
                            <div id="upload-container" class="text-center">
                                <input type="file" id="browseFile" name="file"
                                class="file-input file-input-bordered file-input-primary w-full max-w-lg " />
                            </div>
                                <progress class="progress progress-secondary w-full" value="0" max="100"></progress>
                                <div class="radial-progress" style="--value:0; --size:12rem; --thickness: 2rem;">0%</div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>



    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<!-- Bootstrap JS Bundle with Popper -->
<!-- Resumable JS -->
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

<script type="text/javascript">
    let browseFile = $('#browseFile');
    let progressElement = $('.progress'); // Selecionar o elemento <progress>

    let resumable = new Resumable({
        target: '{{ route('files.upload.large') }}',
        query:{_token:'{{ csrf_token() }}'},
        fileType: ['mp4'],
        headers: {
            'Accept' : 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function (file) {
        showProgress();
        resumable.upload();
    });

    resumable.on('fileProgress', function (file) {
        let progressValue = Math.floor(file.progress() * 100); // Obter o valor do progresso
        updateProgress(progressValue); // Atualizar o elemento <progress>
    });

    resumable.on('fileSuccess', function (file, response) {
        response = JSON.parse(response);


        // Recarregar a página após um breve atraso (por exemplo, 2 segundos)
        setTimeout(function() {
            location.reload();
        }, 5000); // 2000 milissegundos (2 segundos)
    });

    resumable.on('fileError', function (file, response) {
        alert('Erro ao fazer upload do arquivo.');
    });

    function showProgress() {
        progressElement.find('.radial-progress').css('width', '0%');
        progressElement.find('.radial-progress').html('0%');
        progressElement.find('.radial-progress').removeClass('bg-success');
        progressElement.show();
    }

    function updateProgress(value) {
        progressElement.find('.radial-progress').css('width', `${value}%`);
        progressElement.find('.radial-progress').html(`${value}%`);

        // Atualize o valor do atributo 'value' do elemento <progress>
        progressElement.attr('value', value);
    }

    function hideProgress() {
        progressElement.hide();
    }

    
</script>

<script type="text/javascript">
    // Verifica se a mensagem 'reload' está definida
    @if(session('reload'))
        setTimeout(function () {
            location.reload(); // Recarrega a página
        }, 5000); // 5000 milissegundos (5 segundos)
    @endif
</script>

   {{--}} <script>
            function loadVideo(fileName) {

                
                const videoElement = document.getElementById(`do-video${fileName}`);
                const videoSource = `{{ route('stream.video', ['video' => '']) }}/${fileName}`; // Note que incluímos um espaço vazio para o parâmetro

                videoElement.setAttribute('src', videoSource);
                videoElement.load(); // Carrega o vídeo
                videoElement.play(); // Inicia a reprodução
            }

            function pauseVideo(fileName) {
                const videoElement = document.getElementById(`do-video${fileName}`);
                videoElement.pause(); // Pausa a reprodução
            }
    </script>--}}
</x-app-layout>

