<x-app-layout>
    <x-slot name="header"> Quizler </x-slot>
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{route('quizzes.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Quiz Oluştur</a>
        </h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Quiz</th>
                    <th scope="col">Status</th>
                    <th scope="col">Finish Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                <tr>
                    <td>{{$quiz->title}}</td>
                    <td>{{$quiz->status}}</td>
                    <td>{{$quiz->finished_at}}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                        <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$quizzes->links()}}<!-- bu satırı kullanarak paginationu çağırdık ve böylece kayıtlar tek sayfada değil, her sayfada 5 tane olacak şekilde toplam 4 sayfada gözüktü -->
    </div>
</x-app-layout>