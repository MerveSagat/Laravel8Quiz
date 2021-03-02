<x-app-layout>
    <x-slot name="header">Quiz Oluştur</x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action=" {{ route('quizzes.store') }}">
                @csrf
                <!--form uygulamalarında bunu yazmak mecburi. güvenlik için -->
                <div class="form-group">
                    <label>Title of Quiz</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label>Description of Quiz</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <input id="isFinished" @if (old('finished_at')) checked @endif type="checkbox">
                    <label>Has It Finish Date?</label>
                </div>
                <div id="finishedInput" @if (!old('finished_at')) style="display:none" @endif class="form-group">
                    <label>Finish Date</label>
                    <input type="datetime-local" name="finished_at" class="form-control"
                        value="{{ old('finished_at') }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm btn-block">Create Quiz</button>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="js">
        <script>
            /*$('#isFinished').change(function() { //burada başta hashtag olmasının sebebi id'den yakaladığımız için
                alert('Çalıştı')//bu iki satırla checkbox ın değişme durumunu yakalyıoruz
            })*/

            $('#isFinished').change(function() {
                if ($('#isFinished').is(':checked')) {
                    $('#finishedInput').show();
                } else {
                    $('#finishedInput').hide();
                }
            })

        </script>
    </x-slot>
</x-app-layout>
