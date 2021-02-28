<x-app-layout>
    <x-slot name="header"> {{ $quiz->title }} Quizine Ait Sorular </x-slot>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{route('questions.create',$quiz->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Soru Oluştur</a>
            </h5>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col">Question</th>
                        <th scope="col">Images</th>
                        <th scope="col">Answer 1</th>
                        <th scope="col">Answer 2</th>
                        <th scope="col">Answer 3</th>
                        <th scope="col">Answer 4</th>
                        <th scope="col">Correct Answer</th>
                        <th scope="col" style="width: 75px;">Actions</th>
                    </tr>

                    @foreach($quiz->questions as $question)
                    <tr>
                        <td>{{$question->question}}</td>
                        <td>{{$question->image}}</td>
                        <td>{{$question->answer1}}</td>
                        <td>{{$question->answer2}}</td>
                        <td>{{$question->answer3}}</td>
                        <td>{{$question->answer4}}</td>
                        <td class="text-success">{{substr($question->correct_answer,-1)}}.Cevap </td>
                        
                        <td>
                            <a href="{{ route('quizzes.edit',$quiz->id) }}" 
                                class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>

                            <a href="{{ route('quizzes.destroy',$quiz->id) }}"  
                                class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </thead>
            </table>
        </div>
    </div>
</x-app-layout>