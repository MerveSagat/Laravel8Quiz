<x-app-layout>
    <x-slot name="header">Update Quiz</x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action=" {{ route('quizzes.update', $quiz->id) }}">
                @method('PUT')
                <!-- edit işleminde methodu put olarak belirtmezsek hata alırız-->
                @csrf
                <!--form uygulamalarında bunu yazmak mecburi. güvenlik için -->
                <div class="form-group">
                    <label>Title of Quiz</label>
                    <input type="text" name="title" class="form-control" value="{{ $quiz->title }}">
                </div>
                <div class="form-group">
                    <label>Description of Quiz</label>
                    <textarea name="description" class="form-control" rows="4">{{ $quiz->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Status of Quiz</label>
                    <select name="status" class="form-control">
                        <option @if ($quiz->questions_count < 4) disabled @endif @if ($quiz->status === 'publish') selected
                            @endif value = "publish"> Active </option>
                        <option @if ($quiz->status === 'passive') selected @endif value="passive"> Passive </option>
                        <option @if ($quiz->status === 'draft') selected @endif value="draft"> Draft </option>
                </div>
                <div class="form-group">
                    <input id="isFinished" @if ($quiz->finished_at) checked @endif type="checkbox">
                    <label>Has It Finish Date?</label>
                </div>
                <div id="finishedInput" @if (!$quiz->finished_at) style="display:none" @endif class="form-group">
                    <label>Finish Date</label>
                    <input type="datetime-local" name="finished_at" class="form-control" @if ($quiz->finished_at) value="{{ date('Y-m-d\TH:i', strtotime($quiz->finished_at)) }}" @endif>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm btn-block">Update Quiz</button>
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
