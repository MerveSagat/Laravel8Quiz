<x-app-layout>
    <x-slot name="header">{{ $question->question }} Edit</x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action=" {{ route('questions.update',[$question->quiz_id,$question->id]) }}" enctype="multipart/form-data"> <!--resim dosyası yüklendiği için bu enctype ı kullanmamız gerekiyor yoksa hata alırız -->
                @csrf
                @method('PUT') <!--resource controllerın bulması için put eklememiz gerekiyor-->
                <!--form uygulamalarında bunu yazmak mecburi. güvenlik için -->
                <div class="form-group">
                    <label>Question</label>
                    <textarea name="question" class="form-control" rows="4">{{ $question->question}}</textarea>
                </div>
                <div class="form-group">
                    <label>Photo</label>
                    @if($question->image)
                    <a href="{{ asset($question->image) }}" target = "_blank">
                    <img src = "{{ asset($question->image) }}" class="img-responsive" style="width: 150px">
                    </a>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Answer 1</label>
                            <textarea name="answer1" class="form-control" rows="2">{{ $question->answer1 }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Answer 2</label>
                        <textarea name="answer2" class="form-control" rows="2">{{ $question->answer2 }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Answer 3</label>
                    <textarea name="answer3" class="form-control" rows="2">{{ $question->answer3 }}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Answer 4</label>
                <textarea name="answer4" class="form-control" rows="2">{{ $question->answer4 }}</textarea>
        </div>
    </div>
                </div>
                <div class="form-group">
                    <label>Correct Answer</label>
                    <select name="correct_answer" id="" class="form-control">
                        <option @if($question->correct_answer==='answer1') selected @endif value="answer1">Answer 1</option>
                        <option @if($question->correct_answer==='answer2') selected @endif value="answer2">Answer 2</option>
                        <option @if($question->correct_answer==='answer3') selected @endif value="answer3">Answer 3</option>
                        <option @if($question->correct_answer==='answer4') selected @endif value="answer4">Answer 4</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm btn-block">Update Question</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>